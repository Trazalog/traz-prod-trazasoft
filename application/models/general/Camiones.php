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
    public function listarCargados()
    {
        $resource = 'cargados';
        $url = REST . $resource;
        $array = file_get_contents($url, false, http('GET'));
        return json_decode($array);
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

        if($rsp['status']){

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
                "producto" => $o['destino']['arti_id'],
                "prov_id" => $o['origen']['prov_id'],
                "batch_id" => $o['origen']['batch_id']?$o['origen']['batch_id']:0,
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
}
