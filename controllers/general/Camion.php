<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Camion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Noconsumibles');
        $this->load->model('general/Establecimientos');
        $this->load->model('general/Camiones');
        $this->load->model('general/Materias');
        $this->load->model('general/Recipientes');
        $this->load->model('general/Transportistas');
        $this->load->model('general/Listado_carga_camion');
        $this->load->model('general/Listado_recepcion_camion');
    }
		/**
		* Levanta pantalla Carga Camión
		* @param 
		* @return
		*/	
    public function cargarCamion()
    {
        $data['fecha'] = date('Y-m-d');
        $data['lang'] = lang_get('spanish', 4);
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $data['tipoEstablecimiento'] = $this->Noconsumibles->tipoEstablecimiento()['data'];
        $this->load->view('camion/carga_camion', $data);
    }

    public function descargarCamion()
    {
        $data['fecha'] = date('Y-m-d');
        $data['lang'] = lang_get('spanish', 4);
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $data['tipoEstablecimiento'] = $this->Noconsumibles->tipoEstablecimiento()['data'];
        $this->load->view('camion/descarga_camion', $data);
    }

    public function salidaCamion($motr_id = false)
    {
        log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | salidaCamion()");

        $motr_id =  $this->input->get('motr_id');

        isset($motr_id) ? $data['datosCamion'] = $this->Camiones->getMovimientoTransporte($motr_id) : '';
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $data['tipoEstablecimiento'] = $this->Noconsumibles->tipoEstablecimiento()['data'];
        $data['destinoNoConsumible'] = $this->Noconsumibles->seleccionarDestino()['data'];
        $this->load->view('camion/salida_camion', $data);
    }

    /**
		* Trae listado de camiones ingresados por establecimiento
		* @param establecimiento
		* @return array datos camiones
    */
    public function listarPorEstablecimiento()
    {
        log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | listarPorEstablecimiento()");
        $establecimiento = $this->input->post('establecimiento');
        $res = $this->Camiones->listarPorEstablecimiento($establecimiento);
        echo json_encode($res['data']);
    }

    /**
		* Levanta pantalla Entrada|Recepcion Camion
		* @param 
		* @return 
		*/
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

		/**
		* Guarda la Carga de camión(pantalla carga camion)
		* @param array con datos
		* @return array con respuesta del servicio
		*/	
    public function finalizarCarga()
    {
        log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | finalizarCarga()");

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
        $data['tipoEstablecimiento'] = $this->Noconsumibles->tipoEstablecimiento()['data'];
        $data['proveedores'] = $this->Camiones->listarProveedores()['data'];
        $data['materias'] = $this->Materias->listar()->materias->materia;
        $data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
        $data['transportistas'] = $this->Transportistas->obtener()['data'];
        $this->load->view('camion/entrada_camion', $data);
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

    /**
		* Obtiene la informacion de un camion por patente
		* @param array con datos de salida
		* @return array con respuesta de servicio
		*/
    public function obtenerInfo($patente){
        log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | obtenerInfo()");
        $estado = $this->input->post('estado');
        $rsp = $this->Camiones->obtenerInfo($patente, $estado);
        if(!isset($rsp)){
            $rsp = $this->getEstadosFinalizadosCamion('recepcion');
        }
        echo json_encode($rsp);
    }
    /**
		* Obtiene la informacion con estado no FINALIZADO de un camion por patente
		* @param array con datos de salida
		* @return array con respuesta de servicio
    */
    public function getEstadosFinalizadosCamion($accion){
        log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | getEstadosFinalizadosCamion()");

        $patente = $this->input->post('patente');

        $rsp = $this->Camiones->getEstadosFinalizadosCamion($patente);
        if($accion == 'recepcion'){
            return $rsp;
        }
        echo json_encode($rsp);
    }

    public function guardarLoteSistema()
    {
        $frmCamion = $this->input->post('frmCamion');
        $frmDescarga = $this->input->post('array');

        $rsp = $this->Camiones->guardarLoteSistema($frmCamion, $frmDescarga);

        echo json_encode($rsp);
    }

		/**
		* Guarda salida de camion a algun deposito interno o Salida al exterior
		* @param array con datos de salida
		* @return array con respuesta de servicio
		*/
    public function guardarSalida()
    {
        $data = $this->input->post('data');
				$noco = $this->input->post('datosTabla');
        $res = $this->Camiones->guardarSalida($data);

				if ($res['status']) {

						// si hay no consumibles se guardan aca
						if (isset($noco)) {
							foreach ($noco as $value) {
								$codigo[0] = $value['codigo'];
								$destino = $value['destino'];
								$depo_id = "";
								$rsp =  $this->Noconsumibles->movimientoNoConsumibles($codigo, 'EN_TRANSITO', $depo_id, $destino);
								if ($rsp == null) {
									log_message('ERROR','#TRAZA|TRAZASOFT|GENERAL|CAMION|guardarSalida() >> ERROR: no se pudo guardar el movimiento del Noconsumible ');
									$res = false;
									break 1;
								}
							}
						}
				}else{
						log_message('ERROR','#TRAZA|TRAZASOFT|CAMION|guardarSalida() >> ERROR: fallo el guardarSalida($data)');
				}

        echo json_encode($res);
    }

    public function estado()
    {
        $post = $this->input->post();
        $rsp = $this->Camiones->estado($post['patente'], $post['estado'], $post['estadoFinal']);
        if($rsp['status'] && $post['estadoFinal'] == 'DESCARGADO')
            $this->Camiones->actualizarProveedor($post['patente'], $post['estadoFinal'], $post['proveedor']);
        echo json_encode($rsp);
    }
    
    /**
		* Busca en la tabla movimientos_transportes los datos por motr_id y empr_id
		* @param string motr_id
		* @return array con datos de los movimientos de transporte(camion)
    */
    public function getMovimientoCamion(){
        
        log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | getMovimientoCamion()");
        
        $motr_id = $this->input->post("motr_id");
        $resp = $this->Camiones->getMovimientoTransporte($motr_id);

        echo json_encode($resp);
    }
}
