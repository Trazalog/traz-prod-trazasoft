<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Camiones extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listarPorEstablecimiento($establecimiento)
    {
        if($establecimiento == 1 || $establecimiento == 3 || $establecimiento == 5)
        {
            $resource = 'camiones1';
        }
        if($establecimiento == 2 || $establecimiento == 4 || $establecimiento == 6)
        {
            $resource = 'camiones2';
        }
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    
}