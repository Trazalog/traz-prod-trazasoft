<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabla extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Recipientes');
    }
    function armaTabla()
    {
        $json = $this->input->post('json');
        $id = $this->input->post('idtabla');
        $acciones = $this->input->post('acciones');
        $res = armaBusca($json,$id,$acciones);
        echo $res;
    }
    function insertaFila()
    {
        $json = $this->input->post('json');
        $id = $this->input->post('idtabla');
        $acciones = $this->input->post('acciones');
        $res = insertarFila($json,$id,$acciones);
        echo $res;
    }
}