<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etapa extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('etapa/Etapas');
	}

	// Muestra listado de articulos
	public function index()
	{
        $data['list'] = $this->Etapas->listar();
        //var_dump($data['list']->etapas);
		//$data['permission'] = 'Add-Edit-Del-View';
		$this->load->view('etapa/list', $data);
    }
}