<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etapa extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Etapas');
		$this->load->model('general/Establecimientos');
		$this->load->model('general/Recipientes');
		$this->load->model('general/Tareas');
	}

	// Muestra listado de articulos
	public function index()
	{
				$data['list'] =$this->Etapas->listar()->etapas->etapa;
				$data['etapas'] = $this->Etapas->listarEtapas()->etapas->etapa;
		//$data['permission'] = 'Add-Edit-Del-View';
		$this->load->view('etapa/list', $data);
		}
		public function nuevo()
	 {
		$data['op'] = $this->input->get('op');
		$data['accion'] = 'Nuevo';
		$data['tareas'] = $this->Tareas->listar()->tareas->tarea; 
		$data['establecimientos'] = $this->Establecimientos->listar($data['op'])->establecimientos->establecimiento;
		$this->load->view('etapa/abm', $data);
	 }
	 public function crear()
	 {

	 }
}