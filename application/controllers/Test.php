<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct() {
		parent:: __construct();
	}

	public function index()
	{
		$data['tareas'] =  getJson('tareas')->tareas;
		$data['subtareas'] =  getJson('tareas')->subtareas;
		$data['plantillas'] =  getJson('tareas')->plantillas;
		$this->load->view(TSK.'list', $data);
	}
}
