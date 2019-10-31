<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lote extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Lotes');
	}

	// Muestra listado de articulos
	public function listarPorMateria()
	{
        $id = $this->input->post('id');
       
        $res = $this->Lotes->listarPorMateria($id)->lotes->lote;
        echo json_encode($res);
	}
	public function listarPorEstablecimientoConSalida()
	{
		$establecimiento = $this->input->post('establecimiento');
		$salida = $this->input->post('salida');
		$res =$this->Lotes->listarPorEstablecimientoConSalida($establecimiento);
		echo json_encode($res);
	}
	public function listarPorCamion()
	{
		$camion = $this->input->post('camion');
		$res =$this->Lotes->listarPorCamion($camion)->lotes->lote;
		echo json_encode($res);
	}
	public function listar()
	{
		$res =$this->Lotes->listar()->lotes->lote;
		echo json_encode($res);
	}
}