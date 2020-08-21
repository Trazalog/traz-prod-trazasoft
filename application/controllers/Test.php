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
        $contract['nombre_proceso'] = 'TST01';
        $contract['session'] = $this->session->has_userdata('bpm_token')?$this->session->userdata('bpm_token'):'';
        $contract['payload']['nombreTarea'] = 'Nombre Tarea test';
        $contract['payload']['userNick'] = 'ad.min';
        $contract['payload']['taplId'] = '370';
        $res = wso2(REST_API_BPM, 'POST', $contract);
        show($res);
    }

    public function index1()
    {
        $data['articulos'] = $this->Articulos->obtener()['data'];
        $data['envases'] = $this->Tablas->obtenerTabla('envases')['data'];
        $data['establecimientos'] =[];# $this->Establecimientos->obtener();
        $this->load->view('test', $data);
    }

}
