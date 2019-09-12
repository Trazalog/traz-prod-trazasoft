<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Etapas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    function listar()
    {
        
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $resource = 'etapatodo';	 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    function listarEtapas()
    {
       
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $resource = 'etapas';	 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    function buscar($id)
    {
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        if ($id == 1)
        {
            $resource = 'etapaeditar';	
        }
        if ($id == 3)
        {
            $resource = 'fraccioneditar';	
        }
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    function nuevo($opcion)
    {
        if($opcion == 3)
        {
            $resource = 'fraccionarnuevo';
        }else{
            $resource = 'etapasnuevo';
        }
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        	 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    function guardar($etapa)
    {
        /*$parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $resource = 'etapasnuevo';	 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);*/
        
        return;
    }
}