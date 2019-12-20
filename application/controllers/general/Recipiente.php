<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipiente extends CI_Controller {

		function __construct() 
			{
			parent::__construct();
			$this->load->model('general/Recipientes');
		}


    function listarPorEstablecimiento($opciones = false)
    {
        $establecimiento = $this->input->post('establecimiento');

        $res = $this->Recipientes->obtener('PRODUCTIVO', 'VACIO', $establecimiento); 

        if($opciones) $res['data'] = selectBusquedaAvanzada(false, false,$res['data'],'reci_id', 'nombre',array('Estado:'=>'estado'));

        echo json_encode($res);
    }

    public function obtener()
    {
        $tipo = $this->input->get('tipo');
        $estado = $this->input->get('estado');
        $opc = $this->input->get('opciones');

        $rsp = $this->Recipientes->obtener($tipo, $estado);
        echo json_encode($rsp);
    }

     public function obtenerOpciones()
    {
        $tipo = $this->input->get('tipo');
        $estado = $this->input->get('estado');

        $rsp = $this->Recipientes->obtener($tipo, $estado);
        if($rsp['status']) $rsp['data'] = selectBusquedaAvanzada(false, false, $rsp['data'],'reci_id','nombre', array('Tipo:'=>'tipo', 'Estado:'=>'estado','Lote:'=>'lote_id', 'ID ART:'=>'arti_id'));
        echo json_encode($rsp);
    }
    
  
}