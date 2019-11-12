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
		//		$url = 'http://PC-PC:8280/services/ProduccionDataService'.$resource;

        $url = 'http://dev-trazalog.com.ar:8280/services/ProduccionDataService'.$resource;
       
        $array = file_get_contents($url, false, http('GET'));

        return json_decode($array);
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

    public function obtener($tipo = 'TODOS', $estado = 'TODOS')
    {
        $url  = RESTPT . "recipientes/tipo/$tipo/estado/$estado";
        $rsp = $this->rest->callAPI('GET' , $url);
        $rsp['data'] = json_decode($rsp['data'])->recipientes->recipiente;
        return $rsp;
    }
    
}