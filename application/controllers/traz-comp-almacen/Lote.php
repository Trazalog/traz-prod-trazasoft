<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lote extends CI_Controller {

	private $path = ALM.'/';

	function __construct()
  {
		parent::__construct();
		$this->load->model($this->path.'Lotes');
	}

	public function index()
	{
		$data['list']       = $this->Lotes->getList();
		$data['permission'] = "Add-Edit-Del-View";
		$this->load->view($this->path.'lotes/list', $data);
	}
	
	public function puntoPedList()
	{
		$data['list']       = $this->Lotes->getPuntoPedido();
		$data['permission'] = "Add-Edit-Del-View";
		$this->load->view($this->path.'lotes/list_punto_ped', $data);
	}

	public function getMotion(){
		$data['data'] = $this->Stocks->getMotion($this->input->post());
		$response['html'] = $this->load->view($this->path.'stock/view_', $data, true);

		echo json_encode($response);
	}
	
	public function setMotion(){
		$data = $this->Stocks->setMotion($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}

	function verificarExistencia()
	{
		$lote = $this->input->post('lote');
		$depo = $this->input->post('depo');
		$arti = $this->input->post('arti');
		echo $this->Lotes->verificarExistencia($arti, $lote, $depo);
	}
}