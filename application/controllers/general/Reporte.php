<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reporte extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Reportes');
        $this->load->model('general/Etapas');
    }

    public function tareasOperario()
    {
        $data['list'] =$this->Etapas->listar()->etapas->etapa;
        $this->load->view('reportes/lista_tareas_operarios', $data);
    }

    public function crearReporte($id)
    {

        $this->load->model('general/Recursos');
        $this->load->model('general/Etapas');
        $this->load->model(ALM.'Articulos');
        $this->load->model('general/Recipientes');

        $data['etapa'] = $this->Etapas->buscar($id)->etapa;
        $data['producto'] = $this->Etapas->getRecursosOrigen($id, PRODUCTO)->recursos->recurso;

        $data['articulos'] = $this->Articulos->getList();
        $data['operarios'] = $this->Recursos->obtenerXTipo('TRABAJO')['data'];
        $data['recipientes'] = $this->Recipientes->obtener('DEPOSITO','TODOS',$data['etapa']->esta_id)['data'];	

        $this->load->view('reportes/reporte_operario', $data);
    }


    public function guardar()
    {
        $data = $this->input->post('data');
        $this->Reportes->guardar($data);
        echo json_encode($data);
    }
}