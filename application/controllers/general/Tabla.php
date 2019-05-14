<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabla extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Recipientes');
    }
    function armaTabla()
    {
        $json = $this->input->post('json');
        $id = $this->input->post('idtabla');
        $res = armaBusca($json,$id);
        echo $res;
    }
}