<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipiente extends CI_Controller {

		function __construct() 
			{
			parent::__construct();
			$this->load->model('general/Recipientes');
		}


    function listarPorEstablecimiento()
    {
        $establecimiento = $this->input->post('establecimiento');
        $res = $this->Recipientes->listarPorEstablecimiento($establecimiento)->recipientes->recipiente; 
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
        echo json_encode($rsp);
    }
    
  
}