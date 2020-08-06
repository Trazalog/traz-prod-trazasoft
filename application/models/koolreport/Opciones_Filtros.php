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
    // $url = RESTPT . 'transportistas';
    $url = LOG_DS . 'transportistas';
    return wso2($url)['data'];
  }

  public function getProductos()
  { //articulos
    // $url = REST_ALM . 'articulos/' . empresa();
    $url = PRD_Etapa_DS . 'productos/list';
    return wso2($url)['data'];
  }

  public function getProveedores()
  {
    $url = REST_ALM . 'proveedores/' . empresa();
    return wso2($url)['data'];
  }

  public function getCantidadIngresos($data)
  {
    $prov_id = $data['prov_id'];
    $tran_id = $data['tran_id'];
    $arti_id = $data['arti_id'];
    $fecdesde = $data['datepickerDesde'];
    $fechasta = $data['datepickerHasta'];

    if ($prov_id || $tran_id || $arti_id || $fecdesde || $fechasta) {
      $fecdesde = ($fecdesde) ? date("Y-m-d", strtotime($fecdesde)) : null;
      $fechasta = ($fechasta) ? date("Y-m-d", strtotime($fechasta)) : null;
      // $url = LOG_DS . 'productos/etapa/' . 'cantidad/proveedor/' . $prov_id . '/transporte/' . $tran_id . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/ingresos';
      // $json = $this->Koolreport->depurarJson($url)->cantidades->cantidad;
      // return $json[0]->cant_ingresos;

      $url = LOG_DS . 'cantidad/proveedor/' . $prov_id . '/transporte/' . $tran_id . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/ingresos';
      return wso2($url)['data'];
    } else {
      // log_message('INFO', '#TRAZA| #REPORTES|#INGRESOS| #INGRESO');
      // $url = LOG_DS . 'productos/etapa/cantidad/proveedor//transporte//producto//desde//hasta//ingresos';
      // $json = $this->Koolreport->depurarJson($url)->cantidades->cantidad;
      // return $json[0]->cant_ingresos;

      $url = LOG_DS . 'cantidad/proveedor//transporte//producto//desde//hasta//ingresos';
      return wso2($url)['data'];
    }
  }
}
