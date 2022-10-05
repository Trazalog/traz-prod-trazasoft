<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Materias extends CI_Model
{
	function __construct()
	{
		parent::__construct();
  }
  /**
	* Obtiene el listado de articulos por tipo
	* @param string $tipo tipo de articulo
	* @return array respuesta del servicio
	*/
  function listar($tipo){
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | Materias | listar($tipo) >>> $tipo '.$tipo);    
    $resource = "/articulos/tipo/".urlencode($tipo)."/".empresa();	 	
    $url = REST_ALM.$resource;
    $rsp = $this->rest->callAPI("GET",$url,  $id); 		
    return $rsp;
  }
    
}