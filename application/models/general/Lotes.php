<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lotes extends CI_Model {

	function __construct() 
    {
		parent::__construct();
		
	}
function listarPorMateria($id)
    {
        
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        if($id == 1)
        {
            $resource = 'lotes1';
        }else if ($id == 2)
        {
            $resource = 'lotes2';
        }
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
   function listarPorEstablecimientoConSalida($establecimiento,$salida = false)
    {
        $resource = 'lotes_establecimiento/'.$establecimiento;
        $url = RESTPT.$resource;
        $array = file_get_contents($url, false, http('GET'));
        log_message('DEBUG', '#REST #LOTES > listarPorEstablecimientoConSalida | #RSP-DATA:' . $array);
        $rsp = rsp($http_response_header);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($array)->lotes->lote;
        return $rsp;
    }
    function listarPorCamion($camion)
    {
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        if($camion == 1 || $camion == 3)
        { 
            $resource = 'loteentrada1';
        }
        if($camion == 2 || $camion == 4)
        {
            $resource = 'loteentrada2';
        }
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    function listar()
    {
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $resource = 'lotestodo';
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }

   
}