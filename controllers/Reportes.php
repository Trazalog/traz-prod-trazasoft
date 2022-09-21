<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/modules/'.PRD."reports/Primer_Reporte.php";
require APPPATH . '/modules/'.PRD."reports/produccion/Produccion.php";
require APPPATH . '/modules/'.PRD."reports/prodResponsable/Prod_Responsable.php";
require APPPATH . '/modules/'.PRD."reports/ingresos/Ingresos.php";
require APPPATH . '/modules/'.PRD."reports/salidas/Salidas.php";
require APPPATH . '/modules/'.PRD."reports/asignacion_de_recursos/Asignacion_de_recursos.php";
class Reportes extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(PRD.'koolreport/Koolreport');
    $this->load->model(PRD.'koolreport/Opcionesfiltros');
  }

  public function produccion()
  {

    $data = $this->input->post('data');

    $producto = $data['producto'];
    $etapa = $data['etapa'];
    $desde = $data['datepickerDesde'];
    $hasta = $data['datepickerHasta'];

    if ($producto || $etapa || $desde || $hasta) {
      $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
      $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
      
      log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | produccion() | #ETAPA: >>' . $etapa . '#DESDE: >>' . $desde . '#HASTA: >>' . $hasta);

      $url = REST_PRD_ETAPAS . '/productos/etapa/' . $etapa . '/desde/' . $desde . '/hasta/' . $hasta . '/producto/' . $producto.'/empr_id/'.empresa();
      $json = $this->Koolreport->depurarJson($url)->productos->producto;
      $reporte = new Produccion($json);
      $reporte->run()->render();
      
    } else {

      log_message('INFO', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | produccion() | #INGRESO');
      
      $url = REST_PRD_ETAPAS . '/productos/etapa//desde//hasta//producto//empr_id/'.empresa();
      $json = $this->Koolreport->depurarJson($url)->productos->producto;

      log_message('INFO', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | produccion() | #JSON: >>' . json_encode($json));

      $reporte = new Produccion($json);
      $reporte->run()->render();
      
    }
  }

  public function prodResponsable()
  {
    $data = $this->input->post('data');
    $responsable = $data['responsable'];
    $producto = $data['producto'];
    $etapa = $data['etapa'];
    $desde = $data['datepickerDesde'];
    $hasta = $data['datepickerHasta'];

    if ($responsable || $producto || $etapa || $desde || $hasta) {
      $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
      $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;

      log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | prodResponsable() | #ETAPA: >>' . $etapa . '#DESDE: >>' . $desde . '#HASTA: >>' . $hasta . '#PRODUCTO: >>' . $producto);

      $url = REST_TDS . '/productos/recurso/' . $responsable . '/etapa/' . $etapa . '/desde/' . $desde . '/hasta/' . $hasta . '/producto/' . $producto;
      $json = $this->Koolreport->depurarJson($url)->productos->producto;
      $reporte = new Prod_Responsable($json);
      $reporte->run()->render();

    } else {
      log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | prodResponsable() | #INGRESO');

      $url = REST_TDS . '/productos/recurso//etapa//desde//hasta//producto/';
      $json = $this->Koolreport->depurarJson($url)->productos->producto;

      log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | prodResponsable() | #JSON: >>' . $json);
      $reporte = new Prod_Responsable($json);
      $reporte->run()->render();
    }

  }

  public function filtroProduccion()
  {
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | filtroProduccion() | #INGRESO');
    // $url['responsables'] = '';
    $url['articulos'] = REST_PRD_ETAPAS . '/articulos/'.empresa();
    // $url['unidades_medida'] = '';
    $url['etapas'] = REST_PRD_ETAPAS . '/etapas';

    // $valores['responsables'] = $this->Koolreport->depurarJson($url['responsables'])->responsables->responsable;
    $valores['articulos'] = $this->Koolreport->depurarJson($url['articulos'])->articulos->articulo;
    // $valores['unidades_medida'] = $this->Koolreport->depurarJson($url['unidades_medida'])->unidades->unidad;
    $valores['etapas'] = $this->Koolreport->depurarJson($url['etapas'])->etapas->etapa;

    // $data['filtro'] = $this->Opcionesfiltros->filtrosProduccion($valores);

    // $data['calendarioDesde'] = true;
    // $data['calendarioHasta'] = true;
    // $data['op'] = "produccion";

    // $this->load->view(PRD.'layout/Filtro', $data);
    echo json_encode($valores);
  }

  public function filtroProdResponsable()
  {
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | filtroProdResponsable() | #INGRESO');
    $url['responsables'] = REST_TDS . '/recursos/list';
    $url['productos'] = REST_TDS . '/productos/list';
    // $url['unidades_medida'] = '';
    $url['etapas'] = REST_PRD_ETAPAS . '/etapasProductivas/list/empresa/'.empresa();
    // $url['etapas'] = REST_TDS . '/etapas/all/list';

    $valores['responsables'] = $this->Koolreport->depurarJson($url['responsables'])->recursos->recurso;
    $valores['productos'] = $this->Koolreport->depurarJson($url['productos'])->productos->producto;
    // $valores['unidades_medida'] = $this->Koolreport->depurarJson($url['unidades_medida'])->unidades->unidad;
    // $valores['etapas'] = $this->Koolreport->depurarJson($url['etapas'])->etapas->etapa;
    $valores['etapas'] = $this->Koolreport->depurarJson($url['etapas'])->etapas_productivas->etapa_productiva;

    // $data['filtro'] = $this->Opcionesfiltros->filtrosProdResponsable($valores);

    // $data['calendarioDesde'] = true;
    // $data['calendarioHasta'] = true;
    // $data['op'] = 'prodResponsable';

    // $this->load->view(PRD.'layout/Filtro', $data);
    echo json_encode($valores);
  }

  public function ingresos()
  {
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | ingresos() | #INGRESO');
    $data = $this->input->post('data');
    $json = $this->Opcionesfiltros->getIngresos($data);
    $reporte = new Ingresos($json);
    $reporte->run()->render();
  }

  public function cantidadIngresos()
  {
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | cantidadIngresos() | #INGRESO');
    $data = $this->input->post('data');
    $rsp = $this->Opcionesfiltros->getCantidadIngresos($data);
    echo json_encode($rsp);
  }

  public function filtroIngresos()
  {
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | filtroIngresos() | #INGRESO');
    $rsp['proveedores'] = $this->Opcionesfiltros->getProveedores();
    $rsp['transportista'] = $this->Opcionesfiltros->getTransportistas();
    $rsp['productos'] = $this->Opcionesfiltros->getProductos();
    $rsp['u_medidas'] = $this->Opcionesfiltros->getMedidas();
    
    echo json_encode($rsp);
  }

  public function asignacionDeRecursos()
  {
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | asignacionDeRecursos | #INGRESO');
    $data = $this->input->post('data');
    $json = $this->Opcionesfiltros->asignacionDeRecursos($data);
    $reporte = new Asignacion_de_recursos($json);
    $reporte->run()->render();
  }

  public function filtroAsignacionDeRecursos()
  {
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | filtroAsignacionDeRecursos() | #INGRESO');
    $rsp['lote'] = $this->Opcionesfiltros->getLotes();
    echo json_encode($rsp);
  }

  public function salidas()
  {
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | salidas() | #INGRESO');
    $data = $this->input->post('data');
    $json = $this->Opcionesfiltros->getSalidas($data);
    $reporte = new Salidas($json);
    $reporte->run()->render();
  }

  public function filtroSalidas()
  {
    log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | #REPORTES | filtroSalidas() | #INGRESO');
    $rsp['clientes'] = $this->Opcionesfiltros->getClientes();
    $rsp['transportista'] = $this->Opcionesfiltros->getTransportistas();
    echo json_encode($rsp);
  }
}
