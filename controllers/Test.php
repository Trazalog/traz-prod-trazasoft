<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Establecimientos');
        $this->load->model('Tablas');
        $this->load->model(ALM.'Articulos');
    }

    public function index()
    {
        $this->load->model('general/Etapas');
        $this->load->model('general/Recursos');
        $data['rec_trabajo'] = $this->Recursos->obtenerXTipo('TRABAJO')['data'];
        $this->load->model('general/Etapas');
        $data['lotes'] = $this->Etapas->listar()->etapas->etapa;
        $this->load->view('test', $data);
    }

    public function p(Type $var = null)
    {
        # code...
    }
}
