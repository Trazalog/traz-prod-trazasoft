<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Establecimientos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listar($etapa)
    {
        if($etapa == 'siembra' || $etapa == 'estacionamiento')
        {
        $resource = 'establecimientos1';
        }	elseif ($etapa == 'zaranda' || $etapa == 'limpieza' || $etapa == 'fraccionamiento')
        { 
            $resource = 'establecimientos2'; 
        }
        $REST= 'http://localhost:8080/';
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
         	
        $url = $REST.$resource;
        $array = file_get_contents($url, false, $param);
        //var_dump($array);die;
        return json_decode($array);
    }
    
}