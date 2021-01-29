<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Opcionesfiltros extends CI_Model
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
    $url = REST_LOG . '/transportistas/'.empresa();
    return wso2($url)['data'];
  }

  public function getProductos()
  { 
    $url = REST_PRD_ETAPAS . '/productos/list';
    return wso2($url)['data'];
  }

  public function getProveedores()
  {
    $url = REST_ALM . '/proveedores/' . empresa();
    return wso2($url)['data'];
  }

  public function getCantidadIngresos($data)
  {
    log_message('DEBUG', '#TRAZA| #REPORTES|#GETCANTIDADINGRESOS| #INGRESO: >>' . json_encode($data));
    $arti_id = (isset($data['arti_id'])) ? $data['arti_id'] : '';
    $prov_id = (isset($data['prov_id'])) ? $data['prov_id'] : '';
    $cuit = (isset($data['tran_id'])) ? $data['tran_id'] : '';
    $fecdesde = (isset($data['datepickerDesde'])) ? date("Y-m-d", strtotime($data['datepickerDesde'])) : '';
    $fechasta = (isset($data['datepickerHasta'])) ? date("Y-m-d", strtotime($data['datepickerHasta'])) : '';

    $url = REST_LOG . '/cantidad/proveedor/' . $prov_id . '/transporte/' . $cuit . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/ingresos';
    return wso2($url)['data'];
  }

  public function getLotes()
  {
    $url = REST_PRD_LOTE . '/lotes';
    return wso2($url)['data'];
  }

  public function getClientes()
  {
    $url = REST_CORE . '/clientes';
    return wso2($url)['data'];
  }

  public function asignacionDeRecursos($data)
  {
    log_message('DEBUG', '#TRAZA| #REPORTES|#ASIGNACIONDERECURSOS| #INGRESO: >>' . json_encode($data));
    $empr_id = empresa();
    $lote_id = (isset($data['lote_id'])) ? $data['lote_id'] : '';
    $empr_id = (isset($empr_id)) ? $empr_id : '';

    $url = REST_PRD_LOTE . '/asignaciones/' . $lote_id . '/empresa/' . $empr_id; //TODO: comentar y descomentar la linea de arriba

    return wso2($url)['data'];
  }

  public function getSalidas($data)
  {
    log_message('DEBUG', '#TRAZA| #REPORTES|#GETSALIDAS| #INGRESO: >>' . json_encode($data));
    $arti_id = (isset($data['arti_id'])) ? $data['arti_id'] : '';
    $clie_id = (isset($data['clie_id'])) ? $data['clie_id'] : '';
    $cuit = (isset($data['tran_id'])) ? $data['tran_id'] : '';
    $fecdesde = (isset($data['datepickerDesde'])) ? date("Y-m-d", strtotime($data['datepickerDesde'])) : '';
    $fechasta = (isset($data['datepickerHasta'])) ? date("Y-m-d", strtotime($data['datepickerHasta'])) : '';

    $url = REST_LOG. '/movimientos/cliente/' . $clie_id . '/transporte/' . $cuit . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/salidas'; //TODO:comentar y descomentar el de arriba
    return wso2($url)['data'];
  }

  public function getIngresos($data)
  {
    log_message('DEBUG', '#TRAZA| #REPORTES|#GETINGRESOS| #INGRESO: >>' . json_encode($data));
    $arti_id = (isset($data['arti_id'])) ? $data['arti_id'] : '';
    $prov_id = (isset($data['prov_id'])) ? $data['prov_id'] : '';
    $cuit = (isset($data['tran_id'])) ? $data['tran_id'] : '';
    $fecdesde = (isset($data['datepickerDesde'])) ? date("Y-m-d", strtotime($data['datepickerDesde'])) : '';
    $fechasta = (isset($data['datepickerHasta'])) ? date("Y-m-d", strtotime($data['datepickerHasta'])) : '';

    $url = REST_LOG . '/movimientos/proveedor/' . $prov_id . '/transporte/' . $cuit . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/ingresos';
    return wso2($url)['data'];
  }
}
