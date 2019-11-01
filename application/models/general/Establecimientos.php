<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Establecimientos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listar($etapa)
    {
        // if($etapa == 1|| $etapa == 4)
        // {
        // $resource = 'establecimientos1';
        // }	elseif ($etapa == 2 || $etapa == 3 || $etapa == 5)
        // { 
        //     $resource = 'establecimientos2'; 
        // }
     
        // TODO: VER FILTRADO DE ESTABLECIMIENTOS POR ESTAPAS 

            
        $resource = '/establecimiento';    

        $parametros["http"]["method"] = "GET";
        $parametros["http"]["header"] = "Accept: application/json";			 
        $param = stream_context_create($parametros);
        // TODO: DESHARCODEAR EL RESOURCE 
        //$url = REST.$resource;
        $url = 'http://PC-PC:8280/services/ProduccionDataService'.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    public function listarTodo()
    {
        $resource = 'establecimiento'; 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, http('GET'));
        return json_decode($array);
    }
    
}