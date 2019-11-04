<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        $dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=12345");

        if (!$dbconn) {
        echo "An error occurred.\n";
        exit;
        }else{
            echo "Connected";die;
        }
    }

    public function index()
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

    public function index2()
    {
        $data['tareas'] = getJson('tareas')->tareas;
        $data['subtareas'] = getJson('tareas')->subtareas;
        $data['plantillas'] = getJson('tareas')->plantillas;
        $this->load->view(TSK . 'list', $data);
    }
}
