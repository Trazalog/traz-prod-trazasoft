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

   public function obtenerContenido($reci_id)
   {
        $url = RESTPT."recipientes/contenido/$reci_id";
        $rsp = $this->rest->callApi('GET', $url);
        if($rsp['status']){
            $rsp['data'] = json_decode($rsp['data'])->batches->batch;
        }
        return $rsp;
   }


    public function listarTodosDeposito(){

      // $parametros["http"]["method"] = "GET";		 
      // $parametros["http"]["header"] = "Accept: application/json";
      // $param = stream_context_create($parametros);      
      // $resource = '/lote/todos/deposito';      
      // // TODO: DESHARCODEAR EL RESOURCE     
      // $url = REST2.$resource;
      // $array = file_get_contents($url, false, $param);
      // return json_decode($array);

      log_message('DEBUG', 'Recipientes/listarTodosDeposito');
      $resource = '/lote/todos/deposito';
      $url = REST2.$resource;
      $array = $this->rest->callAPI("GET",$url); 	
      wso2Msj($array);
      return json_decode($array['data']);
    }

    public function listarEmpaques()
    {
        // $parametros["http"]["method"] = "GET";		 
        // $param = stream_context_create($parametros);
        // $resource="empaques";
        // $url = REST.$resource;
        // $array = file_get_contents($url, false, $param);
        // return json_decode($array);

        log_message('DEBUG', 'Recipientes/listarEmpaques');
        $resource = '/empaques';
        $url = REST2.$resource;
        $array = $this->rest->callAPI("GET",$url); 	
        wso2Msj($array);
        return json_decode($array['data']);
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

        $url = REST_PRD.'/recipientes';
        $rsp =  $this->rest->callApi('POST', $url, ['post_recipientes'=>$aux]);
        if(!$rsp['status']) return $rsp;
        $rsp['data'] = json_decode($rsp['data'])->resultado->reci_id;
        return $rsp;
    }

    public function obtener($tipo = 'TODOS', $estado = 'TODOS', $establecimiento = 0)
    {
        $url  = RESTPT . "recipientes/tipo/$tipo/estado/$estado/establecimiento/$establecimiento";
        $rsp = $this->rest->callAPI('GET' , $url);
        $rsp['data'] = json_decode($rsp['data'])->recipientes->recipiente;
        return $rsp;
    }

  public function obtenerTodosRecipientes()
  {
    $url  = RESTPT . "getAllRecipientes";
    $rsp = $this->rest->callAPI('GET', $url);
    $rsp['data'] = json_decode($rsp['data'])->recipientes->recipiente;
    return $rsp['data'];
  }

  public function deleteRecipiente($id)
  {
    $data['recipiente']['reci_id'] = $id;
    $url  = RESTPT . "deleteRecipiente";
    $rsp = $this->rest->callApi('PUT', $url, $data);
    return $rsp;
  }

  public function editarRecipiente($data)
  {
    $url  = RESTPT . "updateRecipiente";
    $rsp = $this->rest->callApi('PUT', $url, $data);
    return $rsp;
  }

}