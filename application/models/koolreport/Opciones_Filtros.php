<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Opciones_Filtros extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('wso2_helper');
    $this->load->helper('sesion_helper');
  }

  public function ejemplo($valores)
  {
    $res =  new StdClass(); //creamos un objeto genérico vacío
    $res->unidad = $valores['unidades_medida'];
    $res->estado = $valores['estados'];

    return $res;
  }

  public function filtrosProduccion($valores)
  {
    $res =  new StdClass();
    $res->producto = $valores['productos'];
    // $res->unidad = $valores['unidades_medida'];
    $res->etapa = $valores['etapas'];
    // $res->responsable = $valores['responsables'];

    log_message('DEBUG', '#TRAZA| #OPCIONES_FILTROS.PHP|#OPCIONES_FILTROS|#FILTROSPRODUCCION| #PRODUCTOS: >>' . $res->producto . '#ETAPAS: >>' . $res->etapa);
    return $res;
  }

  public function filtrosProdResponsable($valores)
  {
    $res =  new StdClass();
    $res->responsable = $valores['responsables'];
    $res->producto = $valores['productos'];
    $res->etapa = $valores['etapas'];

    log_message('DEBUG', '#TRAZA| #OPCIONES_FILTROS.PHP|#OPCIONES_FILTROS|#FILTROSPRODRESPONSABLE| #REPONSABLES: >>' . $res->responsable . '#PRODUCTOS: >>' . $res->producto . '#ETAPAS: >>' . $res->etapa);
    return $res;
  }

  public function getTransportistas()
  {
    $url = RESTPT . 'transportistas';
    return wso2($url)['data'];
  }

  public function getProductos()
  {//articulos
    $url = REST_ALM . 'articulos/' . empresa();
    return wso2($url)['data'];
  }

  public function getProveedores()
  {
    $url = REST_ALM . 'proveedores/' . empresa();
    return wso2($url)['data'];
  }

}
