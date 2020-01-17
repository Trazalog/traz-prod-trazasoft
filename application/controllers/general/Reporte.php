<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reporte extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Reportes');
    }

    public function guardar()
    {
        $data = $this->input->post('data');
        $this->Reportes->guardar($data);
        echo json_encode($data);
    }
}
