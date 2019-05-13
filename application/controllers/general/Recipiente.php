<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipiente extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Recipientes');
	}


    function listarPorEstablecimiento()
    {
        $establecimiento = $this->input->post('establecimiento');
        $res = $this->Recipientes->listarPorEstablecimiento($establecimiento); 
        echo json_encode($res);
    }
}