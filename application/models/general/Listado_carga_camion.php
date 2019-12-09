<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Cargacamion extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener()
    {
        $url = RESTPT . 'cargacamion';
        $rsp = $this->rest->callApi('GET', $url);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($rsp['data'])->cargacamion->cargacamion;
        return $rsp;
    }
}