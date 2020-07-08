<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        // $contract = [
        //     'pIdPedidoMaterial' => 711,
        // ];
        // $rsp = $this->bpm->lanzarProceso(BPM_PROCESS_ID_PEDIDOS_NORMALES, $contract);
        // echo json_encode($rsp);
        $this->load->model('general/Etapas');
        echo json_encode($this->Etapas->setCaseIdPedido("712", "1010"));
    }

    public function index6($id = 389)
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

    public function index5()
    {
        $user = 'fernando_leiva';
        $view = 'test';
        $data['key'] = $view . $user;
        $this->load->view($view, $data);
    }

    public function index4(){

        $this->load->model(ALM.'Articulos');
        $data['listArt'] = $this->Articulos->getList();
        $this->load->view('traz-comp/list', $data);
    }

    public function index2()
    {
        $url = REST.'entradas';
        $rsp =  file_get_contents($url, false, http('POST', ['post_entradas'=>$data]));

        var_dump(rspCode($http_response_header));
    }

    public function index1()
    {
        $this->load->model('Tablas');
        var_dump($this->Tablas->obtener('unidad_medida'));
    }

    public function index3()
    {
        $data['tareas'] = getJson('tareas')->tareas;
        $data['subtareas'] = getJson('tareas')->subtareas;
        $data['plantillas'] = getJson('tareas')->plantillas;
        $this->load->view(TSK . 'list', $data);
    }

    public function guardar(){

        $data = $this->input->post('data');
        echo json_encode($data);
    }
}
