<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Establecimiento extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('general/Establecimientos');
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

    function obtenerDepositos(){
        $idestablecimiento = $this->input->get("esta_id");
        $datos = $this->Establecimientos->obtenerDepositos($idestablecimiento)->depositos->deposito;
        echo json_encode($datos);
    }

    public function guardar()
    {
        $data = $this->input->post('datos');
        $rps = $this->Establecimientos->guardar($data);
        echo json_encode($rsp);
    }

    public function eliminar($id)
    {
        $rps = $this->Establecimientos->eliminar($id);
        echo json_encode($rsp);
    }
}