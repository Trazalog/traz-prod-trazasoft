<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Listado_recepcion_camion extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener()
    {
        #REST?
        $url = RESTPT . 'recepcioncamion';
        $rsp = $this->rest->callApi('GET', $url);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($rsp['data'])->recepcioncamion->recepcioncamion;
        return $rsp;
    }
}