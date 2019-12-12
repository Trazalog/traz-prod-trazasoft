<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Establecimiento extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('general/Establecimientos');
    }

    function obtenerDepositos(){
        $idestablecimiento = $this->input->get("esta_id");
        $datos = $this->Establecimientos->obtenerDepositos($idestablecimiento)->depositos->deposito;
        echo json_encode($datos);
    }
}