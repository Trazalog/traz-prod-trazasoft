<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Etapas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    function listar()
    {
        $REST= 'http://localhost:8080/';
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $resource = 'etapatodo';	 	
        $url = $REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
}