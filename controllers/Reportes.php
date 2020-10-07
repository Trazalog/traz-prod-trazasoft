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
      // var_dump('Desde: ' . $desde . '  Hasta: ' . $hasta);
      log_message('INFO', '#TRAZA| #REPORTES.PHP|#REPORTES|#PRODUCCION| #ETAPA: >>' . $etapa . '#DESDE: >>' . $desde . '#HASTA: >>' . $hasta);
      $url = REST_TDS . 'productos/etapa/' . $etapa . '/desde/' . $desde . '/hasta/' . $hasta . '/producto/' . $producto;
      $json = $this->Koolreport->depurarJson($url)->productos->producto;
      $reporte = new Produccion($json);
      $reporte->run()->render();
      //echo json_encode(["fals"=>$etapa]);
    } else {

      log_message('INFO', '#TRAZA| #REPORTES.PHP|#REPORTES|#PRODUCCION| #INGRESO');
      $url = REST_TDS . 'productos/etapa//desde//hasta//producto/';
      $json = $this->Koolreport->depurarJson($url)->productos->producto;
      log_message('DEBUG', '#TRAZA| #REPORTES.PHP|#REPORTES|#PRODRESPONSABLE| #JSON: >>' . $json);
      $reporte = new Produccion($json);
      $reporte->run()->render();
      //echo json_encode(["hola"=>$etapa]);
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
      log_message('INFO', '#TRAZA| #REPORTES.PHP|#REPORTES|#PRODRESPONSABLE| #ETAPA: >>' . $etapa . '#DESDE: >>' . $desde . '#HASTA: >>' . $hasta . '#PRODUCTO: >>' . $producto);
      $url = REST_TDS . 'productos/recurso/' . $responsable . '/etapa/' . $etapa . '/desde/' . $desde . '/hasta/' . $hasta . '/producto/' . $producto;
      $json = $this->Koolreport->depurarJson($url)->productos->producto;
      $reporte = new Prod_Responsable($json);
      $reporte->run()->render();
    } else {
      log_message('INFO', '#TRAZA| #REPORTES.PHP|#REPORTES|#PRODRESPONSABLE| #INGRESO');
      $url = REST_TDS . 'productos/recurso//etapa//desde//hasta//producto/';
      $json = $this->Koolreport->depurarJson($url)->productos->producto;
      log_message('DEBUG', '#TRAZA| #REPORTES.PHP|#REPORTES|#PRODRESPONSABLE| #JSON: >>' . $json);
      $reporte = new Prod_Responsable($json);
      $reporte->run()->render();
    }

  }

  public function filtroProduccion()
  {
    log_message('INFO', '#TRAZA| #REPORTES.PHP|#REPORTES|#FILTROPRODUCCION| #INGRESO');
    // $url['responsables'] = '';
    $url['productos'] = REST_TDS . 'productos/list';
    // $url['unidades_medida'] = '';
    $url['etapas'] = REST_TDS . 'etapas/all/list';

    // $valores['responsables'] = $this->Koolreport->depurarJson($url['responsables'])->responsables->responsable;
    $valores['productos'] = $this->Koolreport->depurarJson($url['productos'])->productos->producto;
    // $valores['unidades_medida'] = $this->Koolreport->depurarJson($url['unidades_medida'])->unidades->unidad;
    $valores['etapas'] = $this->Koolreport->depurarJson($url['etapas'])->etapas->etapa;

    $data['filtro'] = $this->Opciones_Filtros->filtrosProduccion($valores);

    $data['calendarioDesde'] = true;
    $data['calendarioHasta'] = true;
    $data['op'] = "produccion";

    $this->load->view(PRD.'layout/Filtro', $data);
  }

  public function filtroProdResponsable()
  {
    log_message('INFO', '#TRAZA| #REPORTES.PHP|#REPORTES|#FILTROPRODRESPONSABLE| #INGRESO');
    $url['responsables'] = REST_TDS . 'recursos/list';
    $url['productos'] = REST_TDS . 'productos/list';
    // $url['unidades_medida'] = '';
    $url['etapas'] = REST_TDS . 'etapas/all/list';

    $valores['responsables'] = $this->Koolreport->depurarJson($url['responsables'])->recursos->recurso;
    $valores['productos'] = $this->Koolreport->depurarJson($url['productos'])->productos->producto;
    // $valores['unidades_medida'] = $this->Koolreport->depurarJson($url['unidades_medida'])->unidades->unidad;
    $valores['etapas'] = $this->Koolreport->depurarJson($url['etapas'])->etapas->etapa;

    $data['filtro'] = $this->Opciones_Filtros->filtrosProdResponsable($valores);

    $data['calendarioDesde'] = true;
    $data['calendarioHasta'] = true;
    $data['op'] = 'prodResponsable';

    $this->load->view(PRD.'layout/Filtro', $data);
  }

  public function ingresos()
  {
    log_message('INFO', '#TRAZA| #REPORTES|#INGRESOS| #INGRESO');
    $data = $this->input->post('data');
    $json = $this->Opciones_Filtros->getIngresos($data);
    $reporte = new Ingresos($json);
    $reporte->run()->render();
  }

  public function cantidadIngresos()
  {
    log_message('INFO', '#TRAZA| #REPORTES|#CANTIDADINGRESOS| #INGRESO');
    $data = $this->input->post('data');
    $rsp = $this->Opciones_Filtros->getCantidadIngresos($data);
    echo json_encode($rsp);
  }

  public function filtroIngresos()
  {
    log_message('INFO', '#TRAZA| #REPORTES|#FILTROINGRESOS| #INGRESO');
    $rsp['proveedores'] = $this->Opciones_Filtros->getProveedores();
    $rsp['transportista'] = $this->Opciones_Filtros->getTransportistas();
    $rsp['productos'] = $this->Opciones_Filtros->getProductos();
    echo json_encode($rsp);
  }

  public function asignacionDeRecursos()
  {
    log_message('INFO', '#TRAZA| #REPORTES|#ASIGNACIONDERECURSOS| #INGRESO');
    $data = $this->input->post('data');
    $json = $this->Opciones_Filtros->asignacionDeRecursos($data);
    $reporte = new Asignacion_de_recursos($json);
    $reporte->run()->render();
  }

  public function filtroAsignacionDeRecursos()
  {
    log_message('INFO', '#TRAZA| #REPORTES|#FILTROASIGNACIONDERECURSOS| #INGRESO');
    $rsp['lote'] = $this->Opciones_Filtros->getLotes();
    echo json_encode($rsp);
  }

  public function salidas()
  {
    log_message('INFO', '#TRAZA| #REPORTES|#SALIDAS| #INGRESO');
    $data = $this->input->post('data');
    $json = $this->Opciones_Filtros->getSalidas($data);
    $reporte = new Salidas($json);
    $reporte->run()->render();
  }

  public function filtroSalidas()
  {
    log_message('INFO', '#TRAZA| #REPORTES|#FILTROSALIDAS| #INGRESO');
    $rsp['clientes'] = $this->Opciones_Filtros->getClientes();
    $rsp['transportista'] = $this->Opciones_Filtros->getTransportistas();
    echo json_encode($rsp);
  }
}
