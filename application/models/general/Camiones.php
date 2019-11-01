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

        log_message('DEBUG','#CAMIONES > guardarCarga | #DATA: '.json_encode($data));

        #Guardar Carga
        // $resource = 'set_carga';
        // $url = RESTPT . $resource;
        // $array = file_get_contents($url, false, http('POST', $data));
        // $rsp = rsp($http_response_header);

        $this->load->model(ALM . '/Lotes');

        foreach ($data as $key => $o) {
           
            #Descontar Stock
            $aux = array(
                'cantidad' => strval($o->cantidad),
                'batch_id' => strval($o->batch_id),
                'empr_id' => strval(empresa()),
            );
            $rsp = $this->Lotes->extraerCantidad($aux);
            if(!$rsp['status']) continue;

            #Pedir Nuevo Batch ID
            $aux = array(
                'lote_id' => strval($o->id),
                'reci_id' => strval($o->reci_id),
                'batch_id' => strval($o->batch_id),
                'empr_id' => strval(empresa())
            );
            $rsp = $this->Lotes->crearBatch($aux);
            if(!$rsp['status'])  continue;

            #Crear Nuevo Lote
            $aux = array(
                'batch_id' => $rsp['data'],
                'old_batch_id' => strval($o->batch_id),
                'cantidad' => strval($o->cantidad)
            );       
            $rsp = $this->Lotes->crear($aux);
            if(!$rsp['status'])  continue;
        }
        return true;
    }

}
