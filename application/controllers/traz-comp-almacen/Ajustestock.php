<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ajustestock extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Establecimientos');
        // $this->load->model(ALM.'Articulos');
		// $this->load->model(ALM.'Lotes');
		// $this->load->model('Tablas');
    }
    public function index()
    {
        $data['establecimientos'] = $this->Establecimientos->listar()->establecimientos->establecimiento;
        

        //var_dump($data);
        $this->load->view(ALM.'ajustestock/ajuste_stock',$data);
    }
}