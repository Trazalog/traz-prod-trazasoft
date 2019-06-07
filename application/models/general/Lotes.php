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
   function listarPorEstablecimientoConSalida($establecimiento,$salida)
    {
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        if($establecimiento == 1 || $establecimiento == 3 || $establecimiento == 5)
        {
           if($salida == "true"){
            $resource = 'lotesalida1';
           }else{
            $resource = 'lotenosalida1';
           }
        }
        if($establecimiento == 2 || $establecimiento == 4 || $establecimiento == 6)
        {
            if($salida =="true"){
            $resource = 'lotesalida2';
        }else{
            $resource = 'lotenosalida2';
        }
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