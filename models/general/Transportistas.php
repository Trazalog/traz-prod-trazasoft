<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Transportistas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener()
    {
        $url = RESTPT . 'transportistas';
        return wso2($url);

        $rsp = $this->rest->callApi('GET', $url);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($rsp['data'])->transportistas->transportista;
        return $rsp;
    }
    
}