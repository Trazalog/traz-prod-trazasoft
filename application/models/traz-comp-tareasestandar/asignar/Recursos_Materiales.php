<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recursos_Materiales extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listar()
    {
        $resource = 'recursosmateriales';
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);	 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    public function listarPorTarea($idtarea, $idetapa)
    {
        $resource = 'listaportarea';
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);	 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    
}