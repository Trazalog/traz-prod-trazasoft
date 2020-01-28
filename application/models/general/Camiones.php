<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Camiones extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function listarPorEstablecimiento($establecimiento)
    {
        $resource = 'camion_establecimiento/' . $establecimiento;
        $url = RESTPT . $resource;
        $array = file_get_contents($url, false, http('GET'));
        return rsp($http_response_header, false, json_decode($array)->camiones->camion);
    }
    public function listarProveedores()
    {
        $resource = 'proveedores/' . empresa();
        $url = REST . $resource;
        $array = file_get_contents($url, false, http('GET'));
        return json_decode($array);
    }
    public function listarCargados($patente = null)
    {
        // $estado = "ASIGNADO";
        // $resource = 'camiones_estado/' . $estado;
        // $url = RESTPT . $resource;
        $url = 'http://localhost:3000/camiones/';
        // $array2 = file_get_contents($url, false, http('GET'));
        $array = $this->rest->callApi('GET', $url);
        // var_dump(json_decode($array)->camiones->camion);

        // var_dump(json_decode($array['data'])->camiones->camion);
        // var_dump(json_decode($array['data']));
        // var_dump(json_decode($array2)->camiones->camion);
        // var_dump($array['data']);
        // var_dump(json_decode($array)->camiones->camion);
        // return json_decode($array['data']);
        // return json_encode($array);
        // var_dump($array['status']);
        return json_decode($array['data']);
    }

    public function guardarCarga($data)
    {

        log_message('DEBUG', '#CAMIONES > guardarCarga | #DATA: ' . json_encode($data));

        $this->load->model(ALM . '/Lotes');
        $this->load->model('general/Recipientes');

        $array = [];

        $camiones = [];

        foreach ($data as $key => $o) {

            #CREAR NUEVO RECIPIENTE
            $rsp = $this->Recipientes->crear($o);
            log_message('DEBUG', '#CAMIONES > guardarCarga | #NEW RECIPIENTE: ' . json_encode($rsp));
            if (!$rsp['status']) {
                break;
            }
            $newReci = $rsp['data'];

            $o->reci_id = $newReci;
            $o->prov_id = PROVEEDOR_INTERNO;

            $array[] = $o;

            $camiones[] = array('motr_id' => $o->motr_id, 'estado' => 'ASIGNADO');
        }

        $rsp = $this->Lotes->guardarCargaCamion($array);

        if ($rsp['status']) {

            $rsp =  $this->actualizarEstado($camiones);
        }

        return $rsp;
    }

    public function actualizarEstado($data)
    {
        $aux['post_camion_estado']['data'] = $data;
        $url = RESTPT . "camion/estado_batch_req";
        $rsp = $this->rest->callApi('PUT', $url, $aux);
        return $rsp;
    }

    public function guardarDescarga($data)
    {
        log_message('DEBUG', '#CAMION > guardarDescarga | #DATA: ' . json_encode($data));

        $array = [];
        foreach ($data as $key => $o) {
            $array[] = array(
                "id" => $o['destino']['lote_id'],
                "producto" => $o['origen']['arti_id'],
                "prov_id" => $o['origen']['prov_id'],
                "batch_id" => $o['origen']['batch_id'] ? $o['origen']['batch_id'] : 0,
                "cantidad" => $o['destino']['cantidad'],
                "stock" => $o['origen']['cantidad'],
                "reci_id" => $o['destino']['reci_id'],
                "forzar_agregar" => $o['destino']['unificar']
            );
        }
        $array = json_decode(json_encode($array));
        $this->load->model(ALM . 'Lotes');
        $rsp = $this->Lotes->crearBatch($array);
        return $rsp;
    }

    public function finalizarSalida($data)
    {
        $aux['update_camion'] = $data;
        $url = RESTPT . "camiones/salida";
        $rsp = $this->rest->callApi('PUT', $url, $aux);
        return $rsp;
    }

    public function obtenerInfo($patente = null)
    {
        $url = RESTPT . "camiones/" . $patente;
        // $url = 'http://localhost:3000/camiones';
        $rsp = $this->rest->callApi('GET', $url);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data'])->camiones->camion;
        }
        // var_dump($rsp['data']);
        return $rsp;
    }

    #RBASAÑES
    public function listaTransporte()
    {
        $url = REST_TDS . 'transporte/movimiento/list/tipo_movimiento';
        $rsp =  $this->rest->callApi('GET', $url);
        if ($rsp['status']) $rsp['data'] = json_decode($rsp['data'])->movimientosTransporte->movimientoTransporte;
        return $rsp;
    }
    public function listaCargaCTransporte()
    {
        $url = REST_TDS . 'transporte/movimiento/list/tipo_movimiento';
        $rsp =  $this->rest->callApi('GET', $url);
        if ($rsp['status']) $rsp['data'] = json_decode($rsp['data'])->movimientosTransporte->movimientoTransporte;
        return $rsp;
    }
    #_____________________________________________________________________________________


    public function guardarLoteSistema($frmCamion, $frmDescarga)
    {
        #Esta función hara automáticamente la ENTRADA CAMIÓN y la CARGA CAMIÓN

        #Entrada Camion
        $this->load->model('general/Entradas');
        $frmCamion['bruto'] = "0";
        $frmCamion['tara'] = "0";
        $frmCamion['neto'] = "0";
        $frmCamion['establecimiento'] = $frmDescarga['loteSistema'][0]['esta_id'];
        $frmCamion['estado'] = 'INICIADO';
        $rsp = $this->Entradas->guardar($frmCamion);
        if (!$rsp['status']) {
            $rsp['msj'] = 'Error al Guardar Entrada Camion';
            return $rsp;
        }

        #Obtener motr_id
        $rsp = $this->obtenerInfo($frmCamion['patente']);
        if(!$rsp['status']){
            $rsp['msj'] = 'Error al Obtener MOTR_ID';
            return $rsp;
        }

        #Carga Camion
        $lotes = [];
        foreach ($frmDescarga as $o) {
            $aux = new StdClass();
        
            $aux->patente = $frmCamion['patente'];
            $aux->motr_id = $rsp['data'][0]->motr_id;
            $aux->batch_id = $o['loteSistema']['batch_id'];
            $aux->cantidad = $o['loteSistema']['cantidad'];
            $lotes[] =  $aux;
        }

        $rsp = $this->guardarCarga($lotes);
        if(!$rsp['status']){
            $rsp['msj'] = 'Error al Guardar Carga Camion';
            return $rsp;
        }

        return $rsp;
    }
}