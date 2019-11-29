<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoajuste extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Tipoajustes');
    }
    
    function obtenerAjuste()
    {
        $datos = $this->Tipoajustes->obtenerAjustes();
        echo json_encode($datos);
    }
}