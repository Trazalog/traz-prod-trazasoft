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
    log_message('DEBUG', '#TRAZA| #REPORTES|#GETCANTIDADINGRESOS| #INGRESO: >>' . json_encode($data));
    $arti_id = (isset($data['arti_id'])) ? $data['arti_id'] : '';
    $prov_id = (isset($data['prov_id'])) ? $data['prov_id'] : '';
    $cuit = (isset($data['tran_id'])) ? $data['tran_id'] : '';
    $fecdesde = (isset($data['datepickerDesde'])) ? date("Y-m-d", strtotime($data['datepickerDesde'])) : '';
    $fechasta = (isset($data['datepickerHasta'])) ? date("Y-m-d", strtotime($data['datepickerHasta'])) : '';

    $url = LOG_DS . 'cantidad/proveedor/' . $prov_id . '/transporte/' . $cuit . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/ingresos';
    return wso2($url)['data'];
  }

  public function getLotes()
  {
    // $url = PRD_Lote_DS . 'lotes';
    $url = 'http://10.142.0.3:8280/services/PRDLoteDataService/lotes';
    return wso2($url)['data'];
  }

  public function getClientes()
  {
    $url = CORE_DS . 'clientes';
    return wso2($url)['data'];
  }

  public function asignacionDeRecursos($data)
  {
    log_message('DEBUG', '#TRAZA| #REPORTES|#ASIGNACIONDERECURSOS| #INGRESO: >>' . json_encode($data));
    $empr_id = empresa();
    $lote_id = (isset($data['lote_id'])) ? $data['lote_id'] : '';
    $empr_id = (isset($empr_id)) ? $empr_id : '';

    // $json = '{
    //     "asignaciones":{
    //       "asignacion":[{
    //         "comprobante":"0023",
    //         "fecha":"02-02-2020",
    //         "tarea":"Primera",
    //         "articulo":"Mosca",
    //         "cantidad":"22",
    //         "um":"L",
    //         "tipo":"caca"
    //     }
    //     ]
    //   }
    // }';

    // $url = PRD_Lote_DS . 'asignaciones/' . $lote_id . '/empresa/' . $empr_id;
    $url = 'http://10.142.0.3:8280/services/PRDLoteDataService/' . 'asignaciones/' . $lote_id . '/empresa/' . $empr_id; //TODO: comentar y descomentar la linea de arriba

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

    // $url = LOG_DS . 'movimientos/cliente/' . $clie_id . '/transporte/' . $cuit . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/salidas';
    $url = 'http://10.142.0.3:8280/services/LOGDataService/' . 'movimientos/cliente/' . $clie_id . '/transporte/' . $cuit . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/salidas'; //TODO:comentar y descomentar el de arriba
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

    $url = LOG_DS . 'movimientos/proveedor/' . $prov_id . '/transporte/' . $cuit . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/ingresos';
    // $url = 'http://10.142.0.3:8280/services/LOGDataService/' . 'movimientos/cliente/' . $prov_id . '/transporte/' . $cuit . '/producto/' . $arti_id . '/desde/' . $fecdesde . '/hasta/' . $fechasta . '/ingresos'; //TODO:comentar y descomentar el de arriba
    return wso2($url)['data'];
  }
}
