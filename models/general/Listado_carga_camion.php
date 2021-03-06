<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Listado_carga_camion extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener()
    {
        #REST?
        $url = RESTPT . 'cargacamion';
        $rsp = $this->rest->callApi('GET', $url);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($rsp['data'])->cargacamion->cargacamion;
        return $rsp;
    }
}