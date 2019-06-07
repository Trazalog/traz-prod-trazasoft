<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Camion extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Establecimientos');
		$this->load->model('general/Camiones');
		$this->load->model('general/Materias');
		$this->load->model('general/Recipientes');
	}


	public function cargarCamion()
	{
		$data['fecha'] = date('Y-m-d');
		$data['lang'] = lang_get('spanish',4);
		$data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
		$this->load->view('camion/carga_camion',$data);
		}
		public function salidaCamion()
		{
			$data['fecha'] = date('Y-m-d');
			$data['lang'] = lang_get('spanish',4);
			$data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
			$this->load->view('camion/salida_camion',$data);
			}
		function listarPorEstablecimiento()
    {
        $establecimiento = $this->input->post('establecimiento');
        $res = $this->Camiones->listarPorEstablecimiento($establecimiento)->camiones->camion; 
        echo json_encode($res);
		}
		public function Finalizar()
		{
			$lotes = $this->input->post('lotes');
			$msj = "ok";
			echo $msj;
		}
		public function entradaCamion()
		{
			$data['fecha'] = date('Y-m-d');
			$data['lang'] = lang_get('spanish',4);
			$data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
			$data['proveedores'] = $this->Camiones->listarProveedores()->proveedores->proveedor;
			$data['materias'] = $this->Materias->listar()->materias->materia; 
			$data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
			$this->load->view('camion/entrada_camion',$data);
			}
			public function GuardarEntrada()
			{
				$entrada = json_decode($this->input->post('entrada'));
				var_dump($entrada);
				echo 'ok';
			}
}