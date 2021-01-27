<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Materias extends CI_Model
{
	function __construct()
	{
		parent::__construct();
  }
  function listar()
  {    
    //TODO: DESHARDCODEAR LA URL
      $resource = '/articulos/busquedaavanzada/'.empresa();	 	
      $url = REST_ALM.$resource;
      $array = $this->rest->callAPI("GET",$url,  $id); 		
      return json_decode($array['data']);
  }
    
}