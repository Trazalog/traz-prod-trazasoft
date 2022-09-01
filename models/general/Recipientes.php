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
        $url = REST_ALM.$resource;      
        $array = $this->rest->callAPI("GET",$url); 		           
        log_message('DEBUG', 'Recipientes/listarPorEstablecimiento (resp del servicio)-> '.json_encode($array['data']));				       
		return json_decode($array['data']);    
    }

   public function obtenerContenido($reciId)
   {
        $url = REST_PRD."/recipientes/contenido/$reciId";
        return wso2($url);
   }


    public function listarTodosDeposito(){
      log_message('DEBUG', 'Recipientes/listarTodosDeposito');
      $resource = '/lote/todos/deposito';
      $url = REST_PRD.$resource;
      $array = $this->rest->callAPI("GET",$url); 	
      wso2Msj($array);
      return json_decode($array['data']);
    }
    /**
      * Trae todos los empaques y su fórmula(receta) asociada, por empresa
      * @param array con datos del recipiente nuevo
      * @return array con reci_id 
		*/
    public function listarEmpaques(){
        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | Recipientes |  listarEmpaques()');
        $resource = '/empaques/'.empresa();
        $url = REST_PRD.$resource;
        $array = $this->rest->callAPI("GET",$url); 	
        wso2Msj($array);
        return json_decode($array['data']);
    }

    /**
      * Crea un nuevo recipiente y responde con el reci_id nuevo generado
      * @param array con datos del recipiente nuevo
      * @return array con reci_id 
		*/
    public function crear($data)
    {
      $aux = array(
          'tipo' => 'TRANSPORTE',
          'patente' => $data->patente,
          'motr_id' => $data->motr_id,
          'depo_id' => strval(DEPOSITO_TRANSPORTE),
          'empr_id' => strval(empresa()),
      );
      
      log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | RECIPIENTES | crear()  >> data ".json_encode($aux));

      $url = REST_PRD.'/recipientes';
      $rsp =  $this->rest->callApi('POST', $url, ['post_recipientes'=>$aux]);
      if(!$rsp['status']) return $rsp;
      $rsp['data'] = json_decode($rsp['data'])->resultado->reci_id;
      return $rsp;
    }
    
    public function obtener($tipo = 'TODOS', $estado = 'TODOS', $establecimiento = 0)
    {
      log_message('DEBUG'," #TRAZA | #TRAZ-PROD-TRAZASOFT | RECIPIENTES | obtener()");
      $url  = REST_PRD. "/recipientes/tipo/$tipo/estado/$estado/establecimiento/$establecimiento/".empresa();
      $rsp = $this->rest->callAPI('GET' , $url);
      $rsp['data'] = json_decode($rsp['data'])->recipientes->recipiente;
      return $rsp;
    }

  public function obtenerTodosRecipientes()
  {
    $url  = REST_ALM. "/recipientes/empresa/".empresa();
    $rsp = $this->rest->callAPI('GET', $url);
    $rsp['data'] = json_decode($rsp['data'])->recipientes->recipiente;
    return $rsp['data'];
  }

  public function deleteRecipiente($id)
  {
    $data['recipiente']['reci_id'] = $id;
    $url  = REST_ALM . "/deleteRecipiente";
    $rsp = $this->rest->callApi('PUT', $url, $data);
    return $rsp;
  }

  public function editarRecipiente($data)
  {
    $url  = REST_ALM . "/updateRecipiente";
    $rsp = $this->rest->callApi('PUT', $url, $data);
    return $rsp;
  }
}
