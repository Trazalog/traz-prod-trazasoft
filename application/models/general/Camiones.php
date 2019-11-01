<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Camiones extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listarPorEstablecimiento($establecimiento)
    {
        $resource = 'camion_establecimiento/'.$establecimiento;
        $url = REST2.$resource;
        $array = file_get_contents($url, false, http('GET'));
        return rsp($http_response_header, false, json_decode($array)->camiones->camion);
    }
    public function listarProveedores()
    {
        $resource = 'proveedores/'.empresa();
        $url = REST.$resource;
        $array = file_get_contents($url, false, http('GET'));
        return json_decode($array);
    }
    public function listarCargados()
    {
        $resource = 'cargados';
        $url = REST.$resource;
        $array = file_get_contents($url, false, http('GET'));
        return json_decode($array);
    }

    public function guardarCarga($data)
    {
        #Guardar Carga
        $resource = 'set_carga';
        $url = REST2 . $resource;
        $array = file_get_contents($url, false, http('POST', $data));
        $rsp = rsp($http_response_header);

        $this->load->model('general/Lotes');
        #Descontar Stock
        $aux = array(
            '' => '',
            '' => '',
            '' => '',
        );
        $this->Lotes->extraerCantidad($aux);

        #Pedir Nuevo Batch ID
        $aux = array(
            'lote_id'=> strval($data['lote_id']),
            'reci_id'=> strval($data['reci_id']),
            'empr_id'=> strval(empresa())
        );
        $this->Lotes->crearBatch($aux);

        #Crear Nuevo Lote
        $aux = array(
            '' => '',
            '' => '',
            '' => '',
        );
        $this->Lotes->crear($aux);

    }
    
}