<?php defined('BASEPATH') or exit('No direct script access allowed');

class Recipiente extends CI_Controller
{
  

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Recipientes');
    }

    public function obtenerContenido($reci_id)
    {
        $rsp = $this->Recipientes->obtenerContenido($reci_id);
        echo json_encode($rsp);
    }
}
