<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Camion extends CI_Controller
{

    public function __construct(){
      parent::__construct();
      $this->load->model('general/Noconsumibles');
      $this->load->model('general/Establecimientos');
      $this->load->model('general/Camiones');
      $this->load->model('general/Materias');
      $this->load->model('general/Recipientes');
      $this->load->model('general/Transportistas');
      $this->load->model('general/Listado_carga_camion');
      $this->load->model('general/Listado_recepcion_camion');
      $this->load->model('core/Clientes');
      $this->load->model('core/Precios');
      $this->load->model('core/Valores');
      // si esta vencida la sesion redirige al login
      $data = $this->session->userdata();
      // log_message('DEBUG','#Main/login | '.json_encode($data));
      if(!$data['email']){
        log_message('DEBUG','#TRAZA|DASH|CONSTRUCT|ERROR  >> Sesion Expirada!!!');
        redirect(DNATO.'main/login');
      }
    }
		/**
		* Levanta pantalla Carga Camión
		* @param 
		* @return
		*/	
    public function cargarCamion(){
      log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | cargarCamion()");
      $data['fecha'] = date('Y-m-d');
      $data['lang'] = lang_get('spanish', 4);
      $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
      $data['tipoEstablecimiento'] = $this->Noconsumibles->tipoEstablecimiento()['data'];
      $data['clientes']=$this->Clientes->Listar_Clientes();
      $poseeRemitosValorizados = $this->Valores->getValor("posee_remitos_valorizados_carga_camion"); //verifica si el cliente posee remitos valorizados
      $camionInterno = $this->Valores->getValor("camion_interno"); //verifica si debe aparecer boton genera camion interno
      if($poseeRemitosValorizados[0]->valor == 'true'){
        $data['remitosValorizados'] = $poseeRemitosValorizados;
        $data['listasPrecios']=$this->Precios->getListasPrecios();
      }else{
        $data['remitosValorizados'] = $poseeRemitosValorizados;
      }
      if($camionInterno[0]->valor == 'true'){
        $data['camionInterno'] = true;
      }else{
        $data['camionInterno'] = false;
      }
      $data['empresa'] = empresa();
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
    public function finalizarCarga(){
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
    /**
		* Carga la vista para generar una nuevo movimiento de transporte(pantalla Nueva Entrada | Recepción MP)
		* @param 
		* @return view entrada camion con datos de servicios
		*/	 
    public function entradaCamion()
    {
      log_message('DEBUG'," #TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | entradaCamion()");
      $data['fecha'] = date('Y-m-d');
      $data['lang'] = lang_get('spanish', 4);
      $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
      $data['tipoEstablecimiento'] = $this->Noconsumibles->tipoEstablecimiento()['data'];
      $data['proveedores'] = $this->Camiones->listarProveedores()['data'];
      $data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
      $data['transportistas'] = $this->Transportistas->obtener()['data'];
      $this->load->view('camion/entrada_camion', $data);
    }

    /**
		* Recibe los datos del camion para guardarlos en los movimientos_transportes
		* @param array datos camion
		* @return array con respuesta del servicio
    */	
    public function setEntrada(){
      log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | setEntrada()");
      $this->load->model('general/Entradas');

      $data = $this->input->post();
      $rsp = $this->Entradas->guardar($data);
      echo json_encode($rsp);
    }

    public function guardarDescarga(){
      log_message('DEBUG'," #TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | guardarDescarga()");
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

    public function guardarCargaCamionExterno()
    {
        log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | guardarCargaCamionExterno()");
        $frmCamion = $this->input->post('frmCamion');
        $frmDescarga = $this->input->post('cargaCamion');

        $rsp = $this->Camiones->guardarCargaCamionExterno($frmCamion, $frmDescarga);

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
    /**
		* Actualiza el estado del camion. Si es estado final es descargado, actualiza datos del movimiento
		* @param array patente; estado; estadoFinal; proveedor; tara; neto;boleta
		* @return array respuesta del servicio
    */
    public function estado(){
      log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | estado()");
      $post = $this->input->post();
      $rsp['estadoMovimiento'] = $this->Camiones->estado($post['patente'], $post['estado'], $post['estadoFinal']);
      if($rsp['estadoMovimiento']['status'] && $post['estadoFinal'] == 'DESCARGADO')
        $rsp['datos_movimiento'] = $this->Camiones->actualizaDatosMovimientoTransporte($post);
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
    /**
		* Obtiene el listado de articulos por tipo y luego genera el select de busqueda avanzada con el listado
		* @param 
		* @return html select con articulso tipo materia prima
    */
    public function obtenerArticulosPorTipo(){
      log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | obtenerArticulosPorTipo()");
      $rsp = $this->Materias->listar('TODOS');
      if($rsp['status']){
        $materiasPrimas = json_decode($rsp['data']);
        $data['status'] = $rsp['status'];
        $data['data'] = selectBusquedaAvanzada(false, false, $materiasPrimas->articulos->articulo, 'arti_id', 'barcode',array('descripcion','um'));
        echo json_encode($data);
      }else{
        $rsp['msj'] = "Fallo el servicio que obtiene los articulos tipo materia prima.";
        json_encode($rsp);
      }
    }
    /**
		* Obtiene el listado de clientes de ABM Clientes
		* @param 
		* @return array clientes 
    */
    function Listar_Clientes(){
      log_message('INFO','#TRAZA| CLIENTES | Listar_Clientes() >> ');
      $data['list'] = $this->Clientes->Listar_Clientes();
      return $data;
	  }
    /**
		* Genera el remito de carga de camion y devuelve el ID para numero de remito con la funcion de contador
		* @param array $data articulos cargados en el remito separados por cliente 
		* @return Array clientes 
    */
    function guardaRemito(){
      log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | Camion | guardaRemito()');
      $detalleArticulos = $this->input->post('data');
      $clie_id = $this->input->post('clie_id');
      $tabla = 'numerador_remito_carga_camion';
			$nro = $this->Valores->getValor($tabla);
      if (!$nro) {
				$dataRemito['nro_remito'] = '1';
			} else {
				$nuevoNro = $nro[0]->valor2 + 1;
				$dataRemito['nro_remito'] = strval($nuevoNro);
			}
      $dataRemito['detalleArticulos'] =  $detalleArticulos;
      $dataRemito['clie_id'] = $clie_id;
      //Creo la cabcera y el detalle del remito
			$respRemito = $this->Camiones->crearRemito($dataRemito);
      
      /* Actualizo o creo nuevo registro en core.tablas con 'numerador_remito_carga_camion' */
			if($respRemito['cabecera']['status'] && $respRemito['detalle']['status']){
				$datos['tabla'] = $tabla;
				if(!$nro){
					$datos['valor'] = 'contador';
					$datos['valor2'] = '1';
					$datos['valor3'] = '';
					$datos['descripcion'] = $tabla;
					$respRemito['contador'] = $this->Valores->guardarValor($datos);
				}else {
					$dato['valor'] = 'contador';
					$dato['valor2'] = strval($nuevoNro);
					$dato['valor3'] = '';
					$dato['descripcion'] = $tabla;
					$dato['tabl_id'] = $nro[0]->tabl_id;
					$respRemito['contador'] = $this->Valores->editarValor($dato);
				}

				$respRemito['nro_remito'] = $dataRemito['nro_remito'];
			}
      echo json_encode($respRemito);
	  }

}
