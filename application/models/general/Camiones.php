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

        foreach ($data as $key => $o) {

            #CREAR NUEVO RECIPIENTE
            $rsp = $this->Recipientes->crear($o);
             if (!$rsp['status']) {
                break;
            }
            $newReci = $rsp['data'];

            #PEDIR NUEVO BATCH ID
            $o->reci_id = $newReci;
            $rsp = $this->Lotes->crearBatch($o);
            if (!$rsp['status']) {
                break;
            }
            $newBatch = $rsp['data'];

           #GUARDA CARGA MIONCA CON NUEVO BATCH ID 
           $o->new_batch_id = $newBatch; 
           $rsp = $this->Lotes->guardarCargaCamion($o);

        }

        return $rsp;
    }

    public function guardarDescarga($data)
    {
        log_message('DEBUG', '#CAMION > guardarDescarga | #DATA: ' . json_encode($data));

        foreach ($data as $key => $o) {
            $aux = array(
                "batch_id_origen" => strval($o['destino']['batch_id']),
                "empre_id" => strval(empresa()),
                "etap_id_deposito" => strval(ETAPA_DEPOSITO),
                "usuario_app" => strval(userNick()),
                "reci_id" => strval($o['destino']['reci_id']),
                "forzar_agregar" => strval($o['destino']['unificar']),
            );

           
            $recurso = 'lote/deposito/cambiar';
            $url = REST_TDS . $recurso;
            $data = file_get_contents($url, false, http('POST', ['post_lote_deposito_cambiar' => $aux]));
            $rsp = rsp($http_response_header, false, json_decode($data)->respuesta->resultado);
            if (!$rsp['data'] == 'CORRECTO') {
                $rsp['status'] = false;
            }
        }
        return $rsp;
    }
}
