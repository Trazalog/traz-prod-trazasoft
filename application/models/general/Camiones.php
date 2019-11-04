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
            $aux = array(
                'tipo' => 'TRANSPORTE',
                'patente' => $o->patente,
                'motr_id' => $o->motr_id,
                'depo_id' => strval(DEPOSITO_TRANSPORTE),
                'empr_id' => strval(empresa()),
            );
            $reci_id = $this->Recipientes->crear($aux)['data']->resultado->reci_id;
            
            #Pedir Nuevo Batch ID
            $aux = array(
                'lote_id' => strval($o->id),
                'reci_id' => strval($reci_id),
                'batch_id' => strval($o->batch_id),
                'empr_id' => strval(empresa()),
            );
            $rsp = $this->Lotes->crearBatch($aux);
            if (!$rsp['status']) {
                break;
            }
            $newBatch = $rsp['data']; 
            
            #Descontar Stock
            $aux = array(
                'cantidad' => strval($o->cantidad),
                'batch_id' => strval($o->batch_id),
                'empr_id' => strval(empresa()),
            );
            $rsp = $this->Lotes->extraerCantidad($aux);
            if (!$rsp['status']) {
                break;
            }

            #Crear Nuevo Lote
            $aux = array(
                'batch_id' => $newBatch,
                'old_batch_id' => strval($o->batch_id),
                'cantidad' => strval($o->cantidad),
            );
            $rsp = $this->Lotes->crear($aux);
            if (!$rsp['status']) {
                break;
            }

        }
        return $rsp;
    }

    public function guardarDescarga($data)
    {
        log_message('DEBUG','#CAMION > guardarDescarga | #DATA: '.json_encode($data));

        foreach ($data as $key => $o) {
            $aux = array(
                "batch_id_origen"=> strval($o->batch_id),
                "empre_id"=>strval(empresa()),
                "etap_id_deposito"=>strval(ETAPA_DEPOSITO),
                "usuario_app"=>strval(userNick()),
                "reci_id"=> strval($o->reci_id),
                "forzar_agregar"=>"false"
            );
            $recurso = 'lote/deposito/cambiar';
            $url = REST_TDS.$recurso;
            $data = file_get_contents($url, false, http('POST',[ 'post_lote_deposito_cambiar' => $aux]));
            $rsp = rsp($http_response_header, false, json_decode($data)->respuesta->resultado);
            if(!$rsp['data'] == 'CORRECTO'){
                $rsp['status'] = false;
            }
        }
        return $rsp;
    }
}
