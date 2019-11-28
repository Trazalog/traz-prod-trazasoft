<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

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
}
