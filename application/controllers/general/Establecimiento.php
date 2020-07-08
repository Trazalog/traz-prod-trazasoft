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
      echo json_encode($rsp);
    } else {
      echo "No existen recipientes";
    }
  }

  public function asignarAEstablecimiento()
  {
    $data['establecimiento'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
    $data['recipiente'] = $this->Recipientes->obtenerTodosRecipientes();
    $data['tipo'] = $this->Establecimientos->obtenerRecipientesDeposito()->tipos->tipo;
    $this->load->view('Establecimientos/Asignar_establecimiento', $data);
  }

  public function editar()
  { //edita establecimiento
    $data = $this->input->post('data');
    $rsp = $this->Establecimientos->editar($data);
    echo json_encode($rsp);
  }

  public function guardarTodo()
  { //asigna a un establecimiento, depositos, recipientes y tipos de los mismos
    $recipientes = $this->input->post('recipientes');

    // $arrayDatos = '';
    // foreach ($recipientes as $key) {
    //   $arrayPost['tipo'] = $key['reci_tipo'];
    //   $arrayPost['patente'] = $key['reci_nombre'];
    //   $arrayPost['depo_id'] = $key['depo_id'];
    //   $arrayDatos['_post_recipiente_batch_req']['_post_recipiente'][] = $arrayPost;
    // }
    // $rsp = $this->Establecimientos->guardarTodo($arrayDatos);

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

  public function editarTodo()
  {
  }

  public function guardarDepositos()
  { //inserta depositos de un establecimiento
    $data = $this->input->post('data'); //id estab., depositos
    $rsp = $this->Establecimientos->guardarDepositos($data);
    echo json_encode($rsp);
  }

  public function editarDepositos()
  { //edita depositos de un establecimiento
    $data = $this->input->post('data'); //id estab., depositos
    $rsp = $this->Establecimientos->guardarDepositos($data);
    echo json_encode($rsp);
  }

  public function obtenerRecipientes()
  { //get recipientes y sus tipos, de un establecimiento
    $idestablecimiento = $this->input->get("esta_id");
    $datos = $this->Establecimientos->obtenerRecipientes($idestablecimiento)->recipientes->recipiente;
    echo json_encode($datos);
  }

  public function guardarRecipientes()
  { //inserta recipientes y sus tipos, de un establecimiento
    $data = $this->input->post('data'); //id estab., recipientes y tipo de recipientes
    $rsp = $this->Establecimientos->guardarRecipientes($data);
    echo json_encode($rsp);
  }

  public function editarRecipientes()
  { //edita recipientes de un establecimiento
    $data = $this->input->post('data'); //id estab., recipientes y tipo de recipientes
    $rsp = $this->Establecimientos->editarRecipientes($data);
    echo json_encode($rsp);
  }
}
