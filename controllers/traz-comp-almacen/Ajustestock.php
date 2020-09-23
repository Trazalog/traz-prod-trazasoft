<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ajustestock extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Establecimientos');
        $this->load->model(ALM.'Ajustestocks');
    }
    public function index()
    {
        $data['establecimientos'] = $this->Establecimientos->listar()->establecimientos->establecimiento;
        
        $this->load->view(ALM.'ajustestock/ajuste_stock',$data);
    }

    public function guardarAjuste()
    {
        $data = $this->input->post('data');
        $rsp = $this->Ajustestocks->guardarAjustes($data);
        echo json_encode($rsp);
    }

    public function guardarDetalleAjuste()
    {
        $data = $this->input->post('data');
        $rsp = $this->Ajustestocks->guardarDetalleAjustes($data);
        echo json_encode($rsp);
    }


}