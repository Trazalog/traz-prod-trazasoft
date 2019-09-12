<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etapa extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Etapas');
		$this->load->model('general/Establecimientos');
		$this->load->model('general/Recipientes');
		$this->load->model('general/Materias');
		$this->load->model(TAREAS_ASIGNAR.'/Tareas');
		$this->load->model(TAREAS_ASIGNAR.'/Templates');
		$this->load->model(TAREAS_ASIGNAR.'/Recursos_Materiales');
		$this->load->model(TAREAS_ASIGNAR.'/Recursos_Trabajo');
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
		$data['fecha'] = date('Y-m-d');
		$data['id'] = $this->input->get('op');
		$data['etapa']= $this->Etapas->nuevo($data['id'])->etapa;
		$data['idetapa'] = $data['etapa']->id;
		$data['accion'] = 'Nuevo';
		$data['op'] = 	$data['etapa']->titulo;
		$data['materias'] = $this->Materias->listar()->materias->materia;
		$data['lang'] = lang_get('spanish',5);
		$data['tareas'] = $this->Tareas->listar()->tareas->tarea; 
		$data['templates'] = $this->Templates->listar()->templates->template; 
		$data['establecimientos'] = $this->Establecimientos->listar($data['id'])->establecimientos->establecimiento;
		$data['recursosmateriales'] = $this->Recursos_Materiales->listar()->recursos->recurso;
		$trabajo =$this->Recursos_Trabajo->listar()->trabajos->trabajo;
		$data['recursostrabajo'] = $trabajo;
		$this->load->view('etapa/abm', $data);
	 }
	 public function guardar()
	 {
		 $data['idetapa'] = $this->input->post('idetapa');
		 $data['lote'] =$this->input->post('lote');
		 $data['establecimiento'] =$this->input->post('establecimiento');
		 $data['recipiente'] =$this->input->post('recipiente');
		 $data['fecha'] =$this->input->post('fecha');
		 $data['op'] =$this->input->post('op');
		 $this->Etapas->guardar($data);
		 echo("ok");
	 }
	 public function editar()
	 {
		$id = $this->input->get('id');
		$data['accion'] = 'Editar';
		$data['etapa'] = $this->Etapas->buscar($id)->etapa;
		//var_dump($data['etapa']);die;
		$data['idetapa'] = $data['etapa']->id;
		$data['recipientes'] = $this->Recipientes->listarPorEstablecimiento($data['etapa']->establecimiento->id)->recipientes->recipiente;
		$data['op'] = 	$data['etapa']->titulo;
		$data['lang'] = lang_get('spanish',4);
		$data['establecimientos'] = $this->Establecimientos->listar(2)->establecimientos->establecimiento;
		$data['materias'] = $this->Materias->listar()->materias->materia;
		$data['fecha'] = $data['etapa']->fecha;
		if($data['op'] == 'fraccionamiento')
		{
			$data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
			$this->load->view('etapa/fraccionar/fraccionar', $data);
		}else{

		$data['tareas'] = $this->Tareas->listar()->tareas->tarea; 
		$data['templates'] = $this->Templates->listar()->templates->template; 
		$data['recursosmateriales'] = $this->Recursos_Materiales->listar()->recursos->recurso;
		$trabajo =$this->Recursos_Trabajo->listar()->trabajos->trabajo;
		$data['recursostrabajo'] = $trabajo;
		$this->load->view('etapa/abm', $data);
		}
	 }
	 public function guardarFraccionar()
	 {
		 $data['idetapa'] = $this->input->post('idetapa');
		 $data['establecimiento'] =$this->input->post('establecimiento');
		 $data['recipiente'] =$this->input->post('recipiente');
		 $data['fecha'] =$this->input->post('fecha');
		 $data['productos'] = $this->input->post('productos');
		 
		 $this->Etapas->guardar($data);
		 echo("ok");
	 }
	 public function Finalizar()
	 {
		 $productos = json_decode($this->input->post('productos'));
		 echo "";
	 }
	 public function fraccionar()
	 {
		$data['accion'] = 'Nuevo';
		$data['etapa']= $this->Etapas->nuevo(3)->etapa;
		$data['fecha'] = date('Y-m-d');
		$data['lang'] = lang_get('spanish',5);
		$data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
		$data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
		$data['materias'] = $this->Materias->listar()->materias->materia;
		$this->load->view('etapa/fraccionar/fraccionar', $data);
	 }
}