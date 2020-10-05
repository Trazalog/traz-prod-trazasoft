<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarea extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		
	}

    public function index()
    {
        $data['fecha'] = date('Y-m-d');
		$data['lang'] = lang_get('spanish',4);
		$this->load->view('plantillas/formulario_prueba',$data);
    }
	
}