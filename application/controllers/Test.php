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
        $this->load->model('general/Etapas');
    }

    public function index()
    {
        $this->load->view(TST.'pedidos/pedidos_tarea');
    }

    public function index1()
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

    public function obtenerEtapas()
    {
        $rsp = $this->Etapas->listarEtapas();
        $rsp = $rsp->etapas->etapa;
        $rsp = json_encode($rsp);
        echo $rsp;
    }

    public function guardarEtapa()
    {
        $rsp = $this->input->post('data');
        $aux['nombre'] = $rsp[0];
        $aux['nombre_recipiente'] = $rsp[1];
        $aux['orden'] = $rsp[2];
        $this->Etapas->guardarEtapa($aux);
    }

    public function eliminarEtapa()
    {
        $rsp = $this->input->post('data');
        $this->Etapa->eliminarEtapa($rsp);
    }

    public function obtenerEtapa($etapa)
    {
        $rsp = $this->Etapas->obtenerEtapa($etapa);
        $aux = json_encode($rsp['data']);
        echo $aux;
    }
}
