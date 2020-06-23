<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Establecimiento extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('general/Establecimientos');
    $this->load->controller('general/Recipiente');
    $this->load->controller('general/Deposito');
  }

  public function index()
  {
    $data = [];
    $this->load->view('Establecimientos/registrar_establecimiento', $data);
  }

  function Lista_Establecimientos()
  {
    $data["establecimientos"] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
    $this->load->view('Establecimientos/lista_establecimientos', $data);
  }

  function obtenerDepositos()
  {
    $idestablecimiento = $this->input->get("esta_id");
    $datos = $this->Establecimientos->obtenerDepositos($idestablecimiento)->depositos->deposito;
    echo json_encode($datos);
  }

  public function guardar()
  {
    $data = $this->input->post('datos');
    $rsp = $this->Establecimientos->guardar($data);
    echo json_encode($rsp);
  }

  public function eliminar($id)
  {
    $rsp = $this->Establecimientos->eliminar($id);
    echo json_encode($rsp);
  }

  /* MAQUETA DESDE RESIDUOS */
  public function editar()
  {//edita establecimiento
    $data = $this->input->post('data');
    $rsp = $this->Establecimientos->editar($data);
    echo json_encode($rsp);
  }

  public function guardarTodo()
  { //asigna a un establecimiento, depositos, recipientes y tipos de los mismos
    $depositos = $this->input->post('depositos'); //id estab., depositos
    $recipientes = $this->input->post('recipientes');
    $rsp = $this->Establecimientos->guardarTodo($depositos, $recipientes);
    echo json_encode($rsp);
  }

  public function editarTodo()
  {
  }

  public function guardarDepositos()
  {//inserta depositos de un establecimiento
    $data = $this->input->post('data');//id estab., depositos
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
  {//inserta recipientes y sus tipos, de un establecimiento
    $data = $this->input->post('data');//id estab., recipientes y tipo de recipientes
    $rsp = $this->Establecimientos->guardarRecipientes($data);
    echo json_encode($rsp);
  }

  public function editarRecipientes()
  { //edita recipientes de un establecimiento
    $data = $this->input->post('data');//id estab., recipientes y tipo de recipientes
    $rsp = $this->Establecimientos->editarRecipientes($data);
    echo json_encode($rsp);
  }
}
