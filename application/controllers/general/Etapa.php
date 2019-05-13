<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etapa extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Etapas');
		$this->load->model('general/Establecimientos');
		$this->load->model('general/Recipientes');
	}

	// Muestra listado de articulos
	public function index()
	{
				$data['list'] = $this->Etapas->listar();
				$data['etapas'] = $this->Etapas->listarEtapas();
		//$data['permission'] = 'Add-Edit-Del-View';
		$this->load->view('etapa/list', $data);
		}
		public function nuevo()
	 {
		$data['op'] = $this->input->get('op');
		$data['accion'] = 'Nuevo';
		$data['establecimientos'] = $this->Establecimientos->listar($data['op'])->establecimientos;
		$this->load->view('etapa/abm', $data);
	 }
	 public function crear()
	 {
		
	 }
}