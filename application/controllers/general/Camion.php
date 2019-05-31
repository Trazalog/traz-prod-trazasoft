<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Camion extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Establecimientos');
		$this->load->model('general/Camiones');
	}


	public function cargarCamion()
	{
		$data['lang'] = lang_get('spanish',4);
		$data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
		$this->load->view('camion/carga_camion',$data);
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
}