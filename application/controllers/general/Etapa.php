<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etapa extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
		$this->load->model('general/Etapas');
		$this->load->model('general/Establecimientos');
		$this->load->model('general/Recipientes');
		$this->load->model('general/Materias');
		$this->load->model(TAREAS_ASIGNAR.'/Tareas');
		$this->load->model(TAREAS_ASIGNAR.'/Templates');
		$this->load->model(TAREAS_ASIGNAR.'/Recursos_Materiales');
		$this->load->model(TAREAS_ASIGNAR.'/Recursos_Trabajo');
	}

	// Muestra listado de articulos
	public function index()
	{
				$data['list'] =$this->Etapas->listar()->etapas->etapa;
				$data['etapas'] = $this->Etapas->listarEtapas()->etapas->etapa;
				
		//$data['permission'] = 'Add-Edit-Del-View';
		$this->load->view('etapa/list', $data);
	}
	 public function nuevo()
	 {
		$data['fecha'] = date('Y-m-d');
		$data['id'] = $this->input->get('op');
		$data['etapa'] = $this->Etapas->nuevo($data['id'])->etapa; // listo llama a etapas/1
		$data['idetapa'] = $data['etapa']->id;
		$data['accion'] = 'Nuevo';
		$data['op'] = 	$data['etapa']->titulo;
		$data['materias'] = $this->Materias->listar()->materias->materia; // listo
		$data['lang'] = lang_get('spanish',5);
		$data['tareas'] = $this->Tareas->listar()->tareas->tarea; 
		$data['templates'] = $this->Templates->listar()->templates->template; 
		$data['establecimientos'] = $this->Establecimientos->listar($data['id'])->establecimientos->establecimiento; // listo
		$data['recursosmateriales'] = $this->Recursos_Materiales->listar()->recursos->recurso;
		$trabajo = $this->Recursos_Trabajo->listar()->trabajos->trabajo;
		$data['recursostrabajo'] = $trabajo;
		$this->load->view('etapa/abm', $data);
	 }



	 // guarda el Inicio de una nueva etapa mas orden pedido y lanza pedido almac
	 public function guardar()
	 {
		
			//////////// PARA CREAR EL NUNEVO BATCH ///////////////////
				$datosCab['lote_id'] = $this->input->post('lote');
				$datosCab['arti_id'] = (string)$this->input->post('idprod');
				$datosCab['prov_id'] = (string)PROVEEDOR_INTERNO;
				$datosCab['batch_id_padre'] = (string)0;
				$datosCab['cantidad'] = (string)$this->input->post('cantidad');
				$datosCab['cantidad_padre'] = (string)0;
				$datosCab['num_orden_prod'] = $this->input->post('op');
				$datosCab['reci_id'] = $this->input->post('recipiente');
				$datosCab['etap_id'] = $this->input->post('idetapa');
				$datosCab['usuario_app'] = userNick();
				$datosCab['empr_id'] = (string)empresa();
				$datosCab['forzar_agregar'] = "FALSE";
				$datosCab['fec_vencimiento'] = "01-01-1899";	
				
				$data['_post_lote'] = $datosCab;	
				
				$respServ = $this->Etapas->SetNuevoBatch($data);
				$batch_id	= $respServ->respuesta->resultado;

				if(($batch_id != "BATCH_NO_CREADO" )  || ($batch_id != "RECI_NO_VACIO")){

					////////////// INSERTAR CABECERA NOTA PEDIDO   ///
						$arrayPost['fecha'] = $this->input->post('fecha');		
						$arrayPost['empr_id'] = (string)empresa();
						$arrayPost['batch_id'] = $batch_id;		
						$cab['_post_notapedido'] = $arrayPost;					
						$response = $this->Etapas->setCabeceraNP($cab);
						$pema_id = $response->nota_id->pedido_id;

					//////////// PARA CREAR EL BATCH PARA EL BATCH REQUEST //////////					
						if($pema_id){

								$materia = $this->input->post('materia');
								$i = 0;	
								foreach($materia as $id => $cantidad)	{
								
									if($cantidad !== ""){									
										$det['pema_id'] = $pema_id;
										$det['arti_id'] = (string)$id;
										$det['cantidad'] = $cantidad;
										$detalle['_post_notapedido_detalle'][$i]=(object) $det;
										$i++;					
									}
								}
								$arrayDeta['_post_notapedido_detalle_batch_req'] = $detalle;							
								$respDetalle = $this->Etapas->setDetaNP($arrayDeta);
								
								//$response = json_decode($respDetalle['code']);
								
								if($respDetalle < 300){
									/////// LANZAR EL PROCESO DE BONITA DE PEDIDO 								
									$contract = [
										'pIdPedidoMaterial' => $pema_id,
									];

									$rsp = $this->bpm->lanzarProceso(BPM_PROCESS_ID_PEDIDOS_NORMALES,$contract);
									
									if($rsp['status']){
										echo("ok");
									}else{
										echo ($rsp['msj']);
									}
									

								}else{

									echo ("Error en generacion de Detalle Pedido Materiales");
								}


						}else{

								echo("Error en generacion de Cabecera Pedido Materiales");
						}	

				}else{
					echo ("Error en creacion Batch");
				}		
	 }

	 public function editar()
	 {
		 
		$id = $this->input->get('id');// batch_id
	
		$data['accion'] = 'Editar';
		$data['etapa'] = $this->Etapas->buscar($id)->etapa;
		//	var_dump($data['etapa']);die;
		$data['idetapa'] = $data['etapa']->id;
		// $data['recipientes'] = $this->Recipientes->listarPorEstablecimiento($data['etapa']->establecimiento->id)->recipientes->recipiente;

		$prodCant = $this->Etapas->getCantProducto($id);
		$data['prodCant'] = $prodCant->existencia->cantidad;
	
		$prodNombre = $this->Etapas->getNomProducto($id);
		$data['prodNomb'] =$prodNombre->producto->nombre;
	
		
		$data['recipientes'] = $this->Recipientes->listarTodosDeposito()->recipientes->recipiente;// trae todos los recipientes de Tipo Deposito
		$data['op'] = 	$data['etapa']->titulo;
		$data['lang'] = lang_get('spanish',4);
		$data['establecimientos'] = $this->Establecimientos->listar(2)->establecimientos->establecimiento;
		$data['materias'] = $this->Materias->listar()->materias->materia;
		$data['fecha'] = $data['etapa']->fecha;
		if($data['op'] == 'fraccionamiento')
		{
			$data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
			$this->load->view('etapa/fraccionar/fraccionar', $data);
		}else{

		$data['tareas'] = $this->Tareas->listar()->tareas->tarea; 
		$data['templates'] = $this->Templates->listar()->templates->template; 
		$data['recursosmateriales'] = $this->Recursos_Materiales->listar()->recursos->recurso;
		$trabajo =$this->Recursos_Trabajo->listar()->trabajos->trabajo;
		$data['recursostrabajo'] = $trabajo;
		//var_dump($data);
		$this->load->view('etapa/abm', $data);
		}
	 }
	 public function guardarFraccionar()
	 {
		 $data['idetapa'] = $this->input->post('idetapa');
		 $data['establecimiento'] =$this->input->post('establecimiento');
		 $data['recipiente'] =$this->input->post('recipiente');
		 $data['fecha'] =$this->input->post('fecha');
		 $data['productos'] = $this->input->post('productos');
		 
		 $this->Etapas->guardar($data);
		 echo("ok");
	 }
	 public function Finalizar()
	 {
		 	$productos = json_decode($this->input->post('productos'));
		 	$cantidad_padre = $this->input->post('cantidad_padre');
			$num_orden_prod = $this->input->post('num_orden_prod');	
			$lote_id = $this->input->post('lote_id');
			$batch_id_padre = $this->input->post('batch_id_padre');
		 foreach ($productos as $value) {			

				$arrayPost["lote_id"] = $lote_id; // lote origen
				$arrayPost["arti_id"] = $value->id;	// art seleccionado en lista
				$arrayPost["prov_id"] = (string)PROVEEDOR_INTERNO;
				$arrayPost["batch_id_padre"] = $batch_id_padre;// bacth actual
				$arrayPost["cantidad"] = $value->cantidad;// art seleccionado en lista
				$arrayPost["cantidad_padre"] =	$cantidad_padre;		//cantida padre esl lo que descuenta del batch actula
				$arrayPost["num_orden_prod"] =	$num_orden_prod;			
				$arrayPost["reci_id"] = $value->destino;  //reci_id destino del nuevo batch
				$arrayPost["etap_id"] = (string)DEPOSITO_TRANSPORTE;
				$arrayPost["usuario_app"] = userNick();
				$arrayPost["empr_id"] = (string)empresa();	
				$arrayPost["forzar_agregar"] = "false";
				$arrayPost["fec_vencimiento"] = "01-01-1988";

				$arrayDatos['_post_lote'] = $arrayPost;	
				
				$resp = $this->Etapas->finalizarEtapa($arrayDatos);
				
				if ($resp > 300) {
					echo("Error en dataservice");
					return;
				}else{
					echo("ok");
				}
				
		}
		 

		
	 }
	 public function fraccionar()
	 {
		$data['accion'] = 'Nuevo';
		$data['etapa']= $this->Etapas->nuevo(3)->etapa;
		$data['fecha'] = date('Y-m-d');
		$data['lang'] = lang_get('spanish',5);
		$data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
		$data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
		$data['materias'] = $this->Materias->listar()->materias->materia;
		$this->load->view('etapa/fraccionar/fraccionar', $data);
	 }
}