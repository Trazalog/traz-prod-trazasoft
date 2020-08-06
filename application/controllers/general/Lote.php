<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lote extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('general/Lotes');
  }

  // Muestra listado de articulos
  public function listarPorMateria()
  {
    $id = $this->input->post('id');

    $res = $this->Lotes->listarPorMateria($id)->lotes->lote;
    echo json_encode($res);
  }
  public function listarPorEstablecimientoConSalida()
  {
    $establecimiento = $this->input->post('establecimiento');
    $salida = $this->input->post('salida');
    $res = $this->Lotes->listarPorEstablecimientoConSalida($establecimiento);
    $res['data'] = selectBusquedaAvanzada(false, false, $res['data'], 'batch_id', 'id', array('tituloproducto', 'Stock:' => 'stock'));
    echo json_encode($res);
  }
  public function listarPorCamion()
  {
    $camion = $this->input->post('camion');
    $res = $this->Lotes->listarPorCamion($camion)->lotes->lote;
    echo json_encode($res);
  }
  public function listar()
  {
    $res = $this->Lotes->listar()->lotes->lote;
    echo json_encode($res);
  }

  public function obtenerLotesCamion()
  {
    $patente = $this->input->get('patente');
    $rsp = $this->Lotes->obtenerLotesCamion($patente);
    $rsp['data'] = selectBusquedaAvanzada(false, false, $rsp['data'], 'batch_id', 'lote_id', array('Origen:' => 'establecimiento', 'Cantidad:' => 'cantidad', 'Unidad Medida:' => 'um'));
    echo json_encode($rsp);
  }

  public function obtenerLote($lote)
  {
    $this->load->model('general/Lotes');
    $rsp = $this->Lotes->obtenerLote($lote);
    echo json_encode($rsp);
  }

  public function informeTrazabilidad()
  {
    $data = '';
    $this->load->view('produccion/lotes/trazabilidad', $data);
  }

  public function trazabilidadBatch()
  {
    $lote_id = $this->input->get('batch');
    $batch_id = $this->Lotes->getBatchIdLote($lote_id)['data'][0]->batch_id;
    if (isset($batch_id)) {
      $rsp = $this->Lotes->trazabilidadBatch($batch_id);
      echo json_encode($rsp);
    } else echo "¡Batch no encontrado! Intente nuevamente.";
  }
}
