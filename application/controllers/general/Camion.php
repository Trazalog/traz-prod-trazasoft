<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Camion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Establecimientos');
        $this->load->model('general/Camiones');
        $this->load->model('general/Materias');
        $this->load->model('general/Recipientes');
    }

    public function cargarCamion()
    {
        $data['fecha'] = date('Y-m-d');
        $data['lang'] = lang_get('spanish', 4);
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $this->load->view('camion/carga_camion', $data);
    }
    public function descargarCamion()
    {
        $data['fecha'] = date('Y-m-d');
        $data['lang'] = lang_get('spanish', 4);
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $this->load->view('camion/descarga_camion', $data);
    }
    public function salidaCamion()
    {
        $data['fecha'] = date('Y-m-d');
        $data['lang'] = lang_get('spanish', 4);
        $data['camiones'] = $this->Camiones->listarCargados()->camiones->camion;
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $this->load->view('camion/salida_camion', $data);
    }
    public function listarPorEstablecimiento()
    {
        $establecimiento = $this->input->post('establecimiento');
        $res = $this->Camiones->listarPorEstablecimiento($establecimiento);
        echo json_encode($res['data']);
    }
    public function finalizarCarga()
    {
        $lotes = json_decode($this->input->post('lotes'));
        $rsp = $this->Camiones->guardarCarga($lotes);
        echo json_encode($rsp);
    }
    public function entradaCamion()
    {
        $data['fecha'] = date('Y-m-d');
        $data['lang'] = lang_get('spanish', 4);
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $data['proveedores'] = $this->Camiones->listarProveedores()->proveedores->proveedor;
        $data['materias'] = $this->Materias->listar()->materias->materia;
        $data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
        $this->load->view('camion/entrada_camion', $data);
    }
    public function GuardarEntrada()
    {
        $entrada = json_decode($this->input->post('entrada'));
        var_dump($entrada);
        echo 'ok';
	}

	#FLEIVA
	public function setEntrada()
	{
        $this->load->model('general/Entradas');
        
		$data = $this->input->post();
        $rsp = $this->Entradas->guardar($data);
        echo json_encode($rsp);
    }
    
    public function guardarDescarga()
    {
        $data = json_decode($this->input->post('array'));
        echo json_encode($rsp);
    }
    
    public function descargaOrigen()
    {
        $data = $this->input->post('array');
        $rsp = $this->Camiones->guardarDescarga($data);
        echo json_encode($rsp);
    }
}
