<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Tipoajustes extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerAjustes()
    {
        $resource = 'stock/ajuste/tipo/list';	
        $url = REST0.$resource;
        $rsp = $this->rest->callapi("GET", $url);
        if(!$rsp["status"]) return $rsp;
        
        $rsp["data"] = json_decode($rsp["data"])->tiposAjuste->tipoAjuste;
        return $rsp;
        
    }
    
}