<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Establecimiento extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('general/Establecimientos');
    $this->load->model('general/Recipientes');
  }

  public function index()
  {
    $data = '';
    $this->load->view('Establecimientos/registrar_establecimiento', $data);
  }

  function Lista_Establecimientos()
  {
    $data["establecimientos"] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
    $this->load->view('Establecimientos/lista_establecimientos', $data);
  }

  public function obtenerDepositos()
  {
    $esta_id = $this->input->get("esta_id");
    $rsp = $this->Establecimientos->obtenerDepositos($esta_id)->depositos->deposito;
    if (isset($rsp)) {
      echo json_encode($rsp);
    } else {
      echo "No existen depositos";
    }
  }

  public function guardar()
  {
    $data = $this->input->post('datos');
    $rsp = $this->Establecimientos->guardar($data);
  }

  public function eliminar($id)
  {
    $rsp = $this->Establecimientos->eliminar($id);
    echo json_encode($rsp);
  }

  /* MAQUETA DESDE RESIDUOS */
  public function obtenerRecipientesDeposito()
  {
    $data = $this->input->get();
    $rsp = $this->Establecimientos->obtenerRecipientesDeposito($data)->tipos->tipo;
    if ($rsp) {
      $aux = $this->Establecimientos->getRecipientes($data['depo_id'],$data['esta_id']);
      $aux = $this->load->view('Establecimientos/gridRecipientes',$aux);
      echo json_encode($rsp);
    } else {
      echo "No existen recipientes";
    }
  }

  // public function obtenerRecipientes($depo_id)
  // {
  //     $rsp = $this->Establecimientos->getRecipientes($depo_id);
  //     $rsp = $this->load->view('Establecimientos/gridRecipientes',$rsp);
  //     return($rsp);
  // }

  public function asignarAEstablecimiento()
  {
    $data['establecimiento'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
    $data['recipiente'] = $this->Recipientes->obtenerTodosRecipientes();
    $data['tipo'] = $this->Establecimientos->obtenerRecipientesDeposito()->tipos->tipo;
    $this->load->view('Establecimientos/Asignar_establecimiento', $data);
  }

  public function guardarTodo()
  { //asigna a un establecimiento, depositos, recipientes y tipos de los mismos
    $recipientes = $this->input->post('recipientes');

    $tableData = stripcslashes($recipientes);
    $tableDataArray['recipientes'] = json_decode($tableData, TRUE);
    foreach ($tableDataArray['recipientes'] as $key => $x) {
      $array['tipo'] = $tableDataArray['recipientes'][$key]['reci_tipo'];
      $array['patente'] = $tableDataArray['recipientes'][$key]['reci_nombre'];
      $array['empr_id'] = "1";
      $array['depo_id'] = $tableDataArray['recipientes'][$key]['depo_id'];
      // $array['motr_id'] = null;
      $pinchila['_post_recipientes'][$key] = $array;
    }
    $arrayDatos['_post_recipientes_batch_req'] = $pinchila;
    $rsp = $this->Establecimientos->guardarTodo($arrayDatos);

    echo json_encode($rsp);
  }
}
