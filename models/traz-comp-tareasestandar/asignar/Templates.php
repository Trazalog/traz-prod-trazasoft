<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Templates extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listar()
    {
        $resource = 'templates';
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    
}