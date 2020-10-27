<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Model ABM No Consumibles
class Noconsumibles extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Guardar No Consumibles
    public function guardarNoConsumible($data)
	{   
         return  requestBox(PRD_NoCon.'/', $data);
	}

// // Listar No Consumibles
       public function tipoNoConsumible()
      {
           $resource = 'tablas/tipos_no_consumibles';
           $url = REST_CORE . $resource; 
           return wso2($url);
       }
    
// Listar Establecimiento
public function tipoEstablecimiento()
{
    #HARCODE
     $resource = 'establecimientos/empresa/'.empresa();
     $url = REST_ALM_NoCon . $resource;
    return wso2($url);
    
}


public function seleccionarDestino()
{
  $resource = 'tablas/destinos_no_consumibles';
  $url = CORE_DS_NoCon . $resource;
  return wso2($url);
}

// Listar Tipos de No Consumibles
public function ListarNoConsumible()
{
   #HARCODE .empresa()                       
     $resource = PRD_NoCon . "/noConsumibles/porEstado/TODOS/porEmpresa/".empresa();
    $url = $resource;//PRD_NoCon . 
    return wso2($url);

}

    
    public function editarNoConsumible($data)
    {
      $url = PRD_NoCon . '/noConsumibles';
      $rsp = $this->rest->callApi('PUT', $url, $data);
      return $rsp;
    }
 
    public function guardarDestino($data)
    {
      $url = CORE_DS_NoCon . 'tablas';
      $rsp = $this->rest->callApi('POST', $url, $data);
      return $rsp;
    }
 

    function eliminarNoConsumible($codigo)
	{
   
     $url = PRD_NoCon . "/noConsumible";
     return wso2($url, 'DELETE',$codigo);
    }



// Listar trazabilidad No Consumibles
public function ListarTrazabilidadNoConsumible($codigo)
{
                      
    $resource = "/noConsumible/trazabilidad/porCodigo/$codigo";
    $url = PRD_NoCon.$resource;
    return wso2($url);
}

public function buscarNoConsumible($codigo)
{              
    $resource = "/noConsumible/porCodigo/$codigo";
    $url = PRD_NoCon.$resource;
    return wso2($url);
}



// // Guardar Movimiento Entrada No Consumibles 
public function guardarMovimientoEntrada($data)
{   
      return  requestBox(PRD_NoCon.'/',$data);
}



// // Guardar Movimiento Salida No Consumibles
public function guardarMovimientoSalida($data)
{   
     return  requestBox(PRD_NoCon.'/', $data);
}


}
