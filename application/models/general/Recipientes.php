<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipientes extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function listarPorEstablecimiento($establecimiento)
    {       
				// TODO: DESHARCODEAR EL RESOURCE		
        log_message('DEBUG', 'Recipientes/listarPorEstablecimiento (idEstablecimiento)-> '.$establecimiento);              
        $resource = '/lote/'.$establecimiento;	 	
        $url = REST2.$resource;      
        $array = $this->rest->callAPI("GET",$url); 		           
        log_message('DEBUG', 'Recipientes/listarPorEstablecimiento (resp del servicio)-> '.json_encode($array['data']));				       
				return json_decode($array['data']);    
    }


    public function listarTodosDeposito(){

      $parametros["http"]["method"] = "GET";		 
      $parametros["http"]["header"] = "Accept: application/json";
      $param = stream_context_create($parametros);
      
      $resource = '/lote/todos/deposito';
      
      // TODO: DESHARCODEAR EL RESOURCE 
    
      $url = REST2.$resource;

      $array = file_get_contents($url, false, $param);
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
        $aux = array(
            'tipo' => 'TRANSPORTE',
            'patente' => $data->patente,
            'motr_id' => $data->motr_id,
            'depo_id' => strval(DEPOSITO_TRANSPORTE),
            'empr_id' => strval(empresa()),
        );

        $url = RESTPT.'recipientes';
        $rsp =  $this->rest->callApi('POST', $url, ['post_recipientes'=>$aux]);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($rsp['data'])->resultado->reci_id;
        return $rsp;
    }

    public function obtener($tipo = 'TODOS', $estado = 'TODOS', $establecimiento = 0)
    {
        $url  = RESTPT . "recipientes/tipo/$tipo/estado/$estado/establecimiento/0";
        $rsp = $this->rest->callAPI('GET' , $url);
        $rsp['data'] = json_decode($rsp['data'])->recipientes->recipiente;
        return $rsp;
    }
    
}
