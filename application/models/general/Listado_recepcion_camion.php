<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Recepcioncamion extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener()
    {
        $url = RESTPT . 'recepcioncamion';
        $rsp = $this->rest->callApi('GET', $url);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($rsp['data'])->recepcioncamion->recepcioncamion;
        return $rsp;
    }
}