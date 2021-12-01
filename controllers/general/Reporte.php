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
        $data = $this->session->userdata;

        $this->load->model('general/Etapas');
        $this->load->model('general/Recursos');
        $data['rec_trabajo'] = $this->Recursos->obtenerXTipo('TRABAJO')['data'];
        $this->load->model('general/Etapas');
        $data['lotes'] = $this->Etapas->listar()->etapas->etapa;

        $data['lotes_responsable'] = $this->Etapas->listarResponsables($data['id'], null);

        $this->load->view('reportes/lista_tareas_operarios', $data);
    }

    function listarPorEstablecimiento($opciones = false)
  {
    $establecimiento = $this->input->post('establecimiento');
    $tipo = $this->input->post('tipo');

    $res = $this->Recipientes->obtener($tipo, 'TODOS', $establecimiento);

    if ($opciones) $res['data'] = selectBusquedaAvanzada(false, false, $res['data'], 'reci_id', 'nombre', array('Estado:' => 'estado', 'Tipo:' => 'tipo'));

    echo json_encode($res);
  }

    public function ListarResponsable($bacth_id){

        $this->load->model('general/Etapas');

        $bacth_id = $this->input->post('bacth_id');
        $rsp = $this->Etapas->listarResponsables(null, $bacth_id);

        echo json_encode($rsp);
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