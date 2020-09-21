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
        $this->load->model('general/Transportistas');
        $this->load->model('general/Listado_carga_camion');
        $this->load->model('general/Listado_recepcion_camion');
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

    public function salidaCamion($patente = false)
    {
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $this->load->view('camion/salida_camion', $data);
    }

    public function listarPorEstablecimiento()
    {
        $establecimiento = $this->input->post('establecimiento');
        $res = $this->Camiones->listarPorEstablecimiento($establecimiento);
        echo json_encode($res['data']);
    }

    #RBASAÑES
    public function recepcionCamion()
    {
        $data['movimientosTransporte'] = $this->Camiones->listaTransporte()['data'];

        $this->load->view('camion/listado_recepcion_camion', $data);
    }

    public function cargadeCamion()
    {
        $data['movimientosTransporte'] = $this->Camiones->listaCargaCTransporte()['data'];

        $this->load->view('camion/listado_carga_camion', $data);
    }
    #_____________________________________________________________________________________

    public function finalizarCarga()
    {
        $lotes = json_decode($this->input->post('lotes'));
        $rsp = $this->Camiones->guardarCarga($lotes);
        echo json_encode($rsp);
    }

    public function finalizarSalida()
    {
        // $camion = json_decode($this->input->post('data'));
        $camion = $this->input->post('data');
        // var_dump(json_encode($camion));
        // $array = [];
        // foreach ($camion as $key => $o) {
        $array = array(            
            "bruto" => $camion['bruto'],
            "tara" => $camion['tara'],
            "neto" => $camion['neto'],
            "patente" => $camion['patente']
        );
        // }
        $rsp = $this->Camiones->FSalida($array);
        echo json_encode($rsp);
        // var_dump($camion);
        // echo 'ok';
    }

    public function entradaCamion()
    {
        $data['fecha'] = date('Y-m-d');
        $data['lang'] = lang_get('spanish', 4);
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $data['proveedores'] = $this->Camiones->listarProveedores()->proveedores->proveedor;
        $data['materias'] = $this->Materias->listar()->materias->materia;
        $data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
        $data['transportistas'] = $this->Transportistas->obtener()['data'];
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
        $data = $this->input->post('array');
        $rsp = $this->Camiones->guardarDescarga($data);
        echo json_encode($rsp);
    }
    #_____________________________________________________________________________________

    public function obtenerInfo($patente = null)
    {
        $rsp = $this->Camiones->obtenerInfo($patente);
        echo json_encode($rsp);
    }

    public function guardarLoteSistema()
    {
        $frmCamion = $this->input->post('frmCamion');
        $frmDescarga = $this->input->post('array');

        $rsp = $this->Camiones->guardarLoteSistema($frmCamion, $frmDescarga);

        echo json_encode($rsp);
    }

    public function guardarSalida()
    {
        $data = $this->input->post();
        $this->Camiones->guardarSalida($data);
        echo json_encode($data);
    }
}
