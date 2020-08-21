<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    /**
    * 
    * @param 
    * @return 
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Establecimientos');
        $this->load->model('Tablas');
        $this->load->model(ALM.'Articulos');
    }

    public function index()
    {
        $data['articulos'] = $this->Articulos->obtener()['data'];
        $data['envases'] = $this->Tablas->obtenerTabla('envases')['data'];
        $data['establecimientos'] =[];# $this->Establecimientos->obtener();
        $this->load->view('test', $data);
    }

    public function test2()
    {
        $this->load->view('test2');
    }
}
