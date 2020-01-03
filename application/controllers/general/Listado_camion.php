<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Listadocamion extends CI_Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Listado_carga_camion');
        $this->load->model('general/Listado_recepcion_camion');
    }

    public function recepcionCamion()
    {
        $data['fecha'] = date('Y-m-d');
        $data['lang'] = lang_get('spanish', 4);
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $this->load->view('camion/listado_recepcion_camion', $data);
    }

    public function cargadeCamion()
    {
        $data['fecha'] = date('Y-m-d');
        $data['lang'] = lang_get('spanish', 4);
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $this->load->view('camion/listado_carga_camion', $data);
    }
}
?>