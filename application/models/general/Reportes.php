<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Reportes extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function guardar($data)
    {
        $url =  . "";
        $rsp = $this->rest->callApi('', $url);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($rsp['data']);
        return $rsp;   
    }
    
}