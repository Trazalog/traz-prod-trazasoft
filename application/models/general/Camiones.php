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
            log_message('DEBUG', '#CAMIONES > guardarCarga | #NEW RECIPIENTE: '. json_encode($rsp));
             if (!$rsp['status']) {
                break;
            }
            $newReci = $rsp['data'];
           

            #PEDIR NUEVO BATCH ID
            $o->reci_id = $newReci;
            $o->prov_id = PROVEEDOR_INTERNO;
            $rsp = $this->Lotes->crearBatch($o);
            log_message('DEBUG', '#CAMIONES > guardarCarga | #NEW BATCH: ' . json_encode($rsp));
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
                "id"=> $o['destino']['lote_id'],
                "arti_id" => $o['destino']['arti_id'],
                "prov_id" => $o['origen']['prov_id'],
                "batch_id" => $o['destino']['batch_id'],
                "cantidad"=> $o['destino']['cantidad'],
                "stock" => $o['origen']['cantidad'],
                "reci_id" => $o['destino']['reci_id'],
                "forzar_agregar" => $o['destino']['unificar'],
            );

            $this->load->model(ALM.'Lotes');
            $rsp = $this->Lotes->crearBatch($aux);
        }
        return $rsp;
    }
}
