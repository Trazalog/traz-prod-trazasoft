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
    #CAMBIA_CONTANTS .empresa()
     $resource = 'establecimientos/empresa/'.empresa();
     $url = REST_ALM_NoCon . $resource;
    return wso2($url);
    
}


// Listar Tipos de No Consumibles
public function ListarNoConsumible()
{
   #HARCODE .empresa()
    #CAMBIA_CONTANTS                        
     $resource = PRD_NoCon . "/noConsumibles/porEmpresa/".empresa();
    $url = $resource;//PRD_NoCon . 
    return wso2($url);

}

    
    public function editarNoConsumible($data)
    {
       #CAMBIA_CONTANTS
      $url = PRD_NoCon . '/noConsumibles';
      $rsp = $this->rest->callApi('PUT', $url, $data);
      return $rsp;
    }
 


    function eliminarNoConsumible($codigo)
	{
   
     $url = PRD_NoCon . "/noConsumible";
     return wso2($url, 'DELETE',$codigo);
    }

    
    public function guardarTrazabilidadNoConsumible()
	{   
        //$resource = 'http://localhost:8080/prueba';
        //$url = REST . $resource;
        $url = 'http://localhost:8080/prueba';
        $rsp = $this->rest->callApi('POST', $url, $data);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data']);
          }
          return $rsp;
	}  


// Listar trazabilidad No Consumibles
public function ListarTrazabilidadNoConsumible($codigo)
{
    #CAMBIA_CONTANTS                    
    $resource = "/noConsumible/trazabilidad/porCodigo/$codigo";
    $url = PRD_NoCon.$resource;
    return wso2($url);
}

// // Guardar Movimiento Entrada No Consumibles
public function guardarMovimientoEntrada($data)
{   
     return  requestBox(PRD_NoCon.'/', $data);
}


// // Guardar Movimiento Salida No Consumibles
public function guardarMovimientoSalida($data)
{   
     return  requestBox(PRD_NoCon.'/', $data);
}

}