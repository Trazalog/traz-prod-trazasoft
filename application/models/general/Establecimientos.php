<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Establecimientos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listar()
    {
				log_message('DEBUG', 'Establecimientos/listar (id etapa)-> '.$etapa);
				$resource = '/establecimiento';
        $url = REST2.$resource;
				$array = $this->rest->callAPI("GET",$url); 
				$resp =  json_decode($array['data']);		
				return $resp;	
    }
    public function listarTodo()
    {
        $resource = 'establecimiento'; 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, http('GET'));
        return json_decode($array);
    }
    
}