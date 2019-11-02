<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipientes extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listarPorEstablecimiento($establecimiento)
    {
        // if($establecimiento == 1 || $establecimiento == 3 || $establecimiento == 5)
          // {
          //     $resource = 'recipientes1';
          // }
          // if($establecimiento == 2 || $establecimiento == 4 || $establecimiento == 6)
          // {
          //     $resource = 'recipientes2';
          // }
				
				$resource = '/lote/'.$establecimiento;
				
				// TODO: DESHARCODEAR EL RESOURCE 
				$url = 'http://PC-PC:8280/services/ProduccionDataService'.$resource;

       // $url = REST.$resource;
        $array = file_get_contents($url, false, http('GET'));

        return json_decode($array);
    }


    public function listarEmpaques()
    {
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $resource="empaques";
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }

    public function crear($data)
    {
        $url = RESTPT.'recipientes';
        $rsp =  file_get_contents($url, false, http('POST', ['post_recipientes'=>$data]));
        return rsp($http_response_header, false, json_decode($rsp));
    }
    
}