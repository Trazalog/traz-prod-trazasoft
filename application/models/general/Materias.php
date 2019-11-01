<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Materias extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    function listar()
    {
        
				// $parametros["http"]["method"] = "GET";		 
				// $parametros["http"]["header"] = "Accept: application/json";	
        // $param = stream_context_create($parametros);
        // $resource = 'materias';	 	
        // $url = REST.$resource;
        // $array = file_get_contents($url, false, $param);
				// return json_decode($array);
				
			//TODO: DESHARDCODEAR LA URL
			

				$parametros["http"]["method"] = "GET";		 
				$parametros["http"]["header"] = "Accept: application/json";	
        $param = stream_context_create($parametros);
        $resource = '/articulos';	 	
        $url = 'http://PC-PC:8280/services/ProduccionDataService/articulos';
        $array = file_get_contents($url, false, $param);
				return json_decode($array);

    }
    
}