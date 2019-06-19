<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Establecimientos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listar($etapa)
    {
        if($etapa == 1|| $etapa == 4)
        {
        $resource = 'establecimientos1';
        }	elseif ($etapa == 2 || $etapa == 3 || $etapa == 5)
        { 
            $resource = 'establecimientos2'; 
        }
     
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    public function listarTodo()
    {
        $resource = 'establecimientotodos'; 
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);  	
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    
}