<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recipiente extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('general/Recipientes');
  }


  function listarPorEstablecimiento($opciones = false)
  {
    $establecimiento = $this->input->post('establecimiento');
    $tipo = $this->input->post('tipo');

    $res = $this->Recipientes->obtener($tipo, 'TODOS', $establecimiento);

    if ($opciones) $res['data'] = selectBusquedaAvanzada(false, false, $res['data'], 'reci_id', 'nombre', array('Estado:' => 'estado', 'Tipo:' => 'tipo'));

    echo json_encode($res);
  }

  public function obtener()
  {
    $tipo = $this->input->get('tipo');
    $estado = $this->input->get('estado');
    $opc = $this->input->get('opciones');

    $rsp = $this->Recipientes->obtener($tipo, $estado);
    echo json_encode($rsp);
  }

  public function obtenerOpciones()
  {
    $tipo = $this->input->get('tipo');
    $estado = $this->input->get('estado');

    $rsp = $this->Recipientes->obtener($tipo, $estado);
    if ($rsp['status']) $rsp['data'] = selectBusquedaAvanzada(false, false, $rsp['data'], 'reci_id', 'nombre', array('Tipo:' => 'tipo', 'Estado:' => 'estado', 'Lote:' => 'lote_id', 'ID ART:' => 'arti_id'));
    echo json_encode($rsp);
  }

  public function deleteRecipiente($id =  null)
  {
    $rsp = $this->Recipientes->deleteRecipiente($id);
    // $datos = '';
    if ($rsp['code'] == 202 || $rsp['code'] == 200) {
      echo json_encode($rsp);
    } else {
      echo "Se produjo un error al eliminar el recipiente.";
    }
  }

  public function editarRecipiente()
  {
    $data['recipiente']['reci_id'] = $this->input->post('reci_id');
    $data['recipiente']['reci_tipo'] = $this->input->post('reci_tipo');
    $data['recipiente']['reci_nombre'] = $this->input->post('reci_nombre');
    $rsp = $this->Recipientes->editarRecipiente($data);
    // $datos = '';
    if ($rsp['code'] == 202 || $rsp['code'] == 200) {
      echo json_encode($rsp);
    } else {
      echo "Se produjo un error al editar el recipiente.";
    }
  }

  public function obtenerContenido($reciId)
  {
    $rsp = $this->Recipientes->obtenerContenido($reciId);
    echo json_encode($rsp);
  }
}
