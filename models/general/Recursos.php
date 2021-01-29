<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Recursos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerXTipo($tipo)
    {
        $url = REST_PRD_ETAPAS . "/recursos/$tipo/".empresa();
        $rsp = $this->rest->callApi('GET', $url);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($rsp['data'])->recursos->recurso;
        return $rsp;
    }
}