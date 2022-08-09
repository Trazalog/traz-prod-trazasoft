<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Etapa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Etapas');
        $this->load->model('general/Establecimientos');
        $this->load->model('general/Recipientes');
        $this->load->model('general/Materias');
        # $this->load->model(TAREAS_ASIGNAR . '/Tareas');
        #$this->load->model(TAREAS_ASIGNAR . '/Templates');
        #$this->load->model(TAREAS_ASIGNAR . '/Recursos_Materiales');
        $this->load->model('general/Recursos');
        $this->load->model('general/Procesos');
        $this->load->model('general/Lotes');
        $this->load->model(FRM . 'Forms');

        // si esta vencida la sesion redirige al login
		$data = $this->session->userdata();
		if(!$data['email']){
			log_message('DEBUG','#TRAZA|DASH|CONSTRUCT|ERROR  >> Sesion Expirada!!!');
			redirect(DNATO.'main/login');
		}
    }

    // Muestra listado de etapas
    public function index()
    {
        $data['list'] = $this->Etapas->listar()->etapas->etapa;
        $temp = $this->Etapas->listarEtapas()->etapas->etapa;
        //reforma las url segun id
        foreach ($temp as $value) {
            if ($value->tiet_id == 'prd_tipos_etapaFraccionamiento') {
                $urlComp = 'general/Etapa/fraccionar?op=' . $value->id;;
                $value->link = $urlComp;
            } else {
                $urlComp = 'general/Etapa/nuevo?op=' . $value->id;
                $value->link = $urlComp;
            }
        }
        $data['etapas'] = $temp;
        $this->load->view('etapa/list', $data);
    }
    /**
        * Llama a etapas para una nueva Etapa
        * @param integer $op opcion seleccionada
        * @return view con $data para nueva Etapa segun opcion seleccionada
	*/
    public function nuevo()
    {
        log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | ETAPA | nuevo()');
        
        $this->load->model(TST.'Tareas');
        $this->Tareas->eliminarTareasSinOrigen(empresa());
        #Snapshot
        $user = userNick();
        $view = 'etapa/abm';
        $data['key'] = $view . $user;

        $data['fecha'] = date('Y-m-d');
        $data['id'] = $this->input->get('op');
        $data['etapa'] = $this->Etapas->nuevo($data['id'])->etapa;
        $data['idetapa'] = $data['etapa']->id;
        $data['accion'] = 'Nuevo';
        $data['op'] = $data['etapa']->titulo;

        $this->load->model(ALM . 'Articulos');
        #$data['materias'] = $this->Articulos->obtenerXTipos(array('Proceso', 'Final', 'Materia Prima'));
        // $data['productos'] = $this->Articulos->obtenerXTipos(array('Proceso', 'Producto'));

        #FORMULARIO GENERICO
        $data['form_id'] = $data['etapa']->form_id;

        #Obtener Proucto por Etapa
        $data['productos_etapa'] = $this->Etapas->obtenerArticulos($data['etapa']->id)['data'];
        $data['productos_entrada_etapa'] = $this->Etapas->getEntradaEtapa($data['etapa']->id)['data'];

        $data['lang'] = lang_get('spanish', 5);
        $data['tareas'] = []; //$this->Tareas->listar()->tareas->tarea;
        $data['templates'] = []; //$this->Templates->listar()->templates->template;
        $data['establecimientos'] = $this->Establecimientos->listar($data['id'])->establecimientos->establecimiento; // listo
        $data['recursosmateriales'] = []; //;$this->Recursos_Materiales->listar()->recursos->recurso;
        $data['rec_trabajo'] = $this->Recursos->obtenerXTipo('TRABAJO')['data'];
        $this->load->view($view, $data);
    }

    // guarda el Inicio de una nueva etapa mas orden pedido y lanza pedido almac
    public function guardar($nuevo = null)
    {
        log_message('DEBUG', '#TRAZA | TRAZ-PROD-TRAZASOFT | ETAPA | guardar() | INICIO');

        $post_data = $this->input->post('data');

        log_message('DEBUG', '#TRAZA | TRAZ-PROD-TRAZASOFT | ETAPA | guardar() | #DATA-POST: ' . json_encode($post_data));
        //////////// PARA CREAR EL NUEVO BATCH ///////////////////

        $datosCab['arti_id'] = (string) $post_data['idprod'];
        $datosCab['lote_id'] = (string) $post_data['lote'];
        $datosCab['prov_id'] = (string) PROVEEDOR_INTERNO;
        $datosCab['batch_id_padre'] = (string) 0;
        $datosCab['cantidad'] = (string) $post_data['cantidad'] ? $post_data['cantidad'] : "0";
        $datosCab['cantidad_padre'] = (string) 0;
        $datosCab['num_orden_prod'] = (string) $post_data['op'];
        $datosCab['reci_id'] = (string) $post_data['recipiente'];
        $datosCab['etap_id'] = (string) $post_data['idetapa'];
        $datosCab['usuario_app'] = userNick();
        $datosCab['empr_id'] = (string) empresa();
        $datosCab['forzar_agregar'] = ($nuevo == 'guardar') ? 'false' : $post_data['forzar'];
        $datosCab['fec_vencimiento'] = FEC_VEN;
        $datosCab['recu_id'] = "0";
        $datosCab['tipo_recurso'] = "";

        $batch_id = (string) $post_data['batch_id']; //mbustos
        $datosCab['batch_id'] = $batch_id; // SI LO MANDA VACIO LO CREA SINO LO EDITAR
        $estado = $post_data['estadoEtapa']; //mbustos

        $datosCab['planificado'] = ($nuevo == 'guardar') ? 'true' : "false";
        $data['_post_lote'] = $datosCab;

        $rsp = $this->Etapas->SetNuevoBatch($data);

        if (!$rsp['status']) {
            echo json_encode($rsp);
            return;
        }

        #En el caso de no existir devuelve nuevo BATCH_ID SINO el EXISTENTE
        $batch_id = $rsp['data']->respuesta->resultado;

        $this->Etapas->asociarFormulario($batch_id, $post_data['info_id']);

        log_message('DEBUG', '#TRAZA | TRAZ-PROD-TRAZASOFT | ETAPA | guardar() | FIN');

        $res = $this->guardarParte2($post_data, $datosCab, $batch_id);
        if (!$res) {
            return;
        }

        $this->guardarParte3($post_data, $batch_id, $nuevo, $estado);

        echo json_encode(['status' => true, 'batch_id' => $batch_id]);
    }

    public function guardarParte2($post_data, $datosCab, $batch_id)
    {
        log_message('DEBUG', '#TRAZA | TRAZ-PROD-TRAZASOFT | ETAPA | guardarParte2() | INICIO');

        // guardo recursos materiales (origen)
        $materia = $post_data['materia'];

        // busca id recurso por id articulo
        $recu_id = false;
        if ($datosCab['arti_id'] != "0") {
            $recu_id = $this->Etapas->getRecursoId($datosCab['arti_id']);
            if (!$recu_id) {
                log_message('ERROR', '#TRAZA | TRAZ-PROD-TRAZASOFT | ETAPA | guardarParte2() >> Error al traer ID Rercurso');
                return false;
            }
        }

        $arrayTemp1 = array();
        $arrayTemp1['request_box']['_delete_recurso_lote']['batch_id'] = $batch_id;
        if ($recu_id) {
            $arrayTemp1['request_box']['_post_recurso_lote'][] = $this->Etapas->setRecursosLotesProd($batch_id, $recu_id, $datosCab['cantidad']);
        }

        foreach ($materia as $o) {
            if ($cantidad !== "") {
                $recurso_id = $this->Etapas->getRecursoId($o['id_materia']);
                $detArt['batch_id'] = (string) $batch_id;
                $detArt['recu_id'] = (string) $recurso_id;
                $detArt['usuario'] = userNick();
                $detArt['empr_id'] = (string) empresa();
                $detArt['cantidad'] = $o['cantidad'];
                $detArt['tipo'] = "MATERIA_PRIMA";
                $detArt['empa_id'] = (string) 0;
                $detArt['empa_cantidad'] = (string) 0;
                $arrayTemp1['request_box']['_post_recurso_lote'][] = $detArt;
            }
        }

        log_message('DEBUG', 'JSON request_box: >> ' . json_encode($arrayTemp1));
        $rspRequestBox = $this->Etapas->setRecursosLotes_requestBox($arrayTemp1);

        if (!$rspRequestBox['status']) {
            log_message('ERROR', 'setRecursosLotes_requestBox(): >> ' . json_encode($rspRequestBox));
            echo ("Error al guardar las materias primas. ");
            return false;
        }

        log_message('DEBUG', 'ETAPA >> guardarParte2 | FIN');
        return true;

    }

    public function guardarParte3($post_data, $batch_id, $nuevo, $estado)
    {

        log_message('DEBUG', '#TRAZA | TRAZ-PROD-TRAZASOFT | ETAPA | guardarParte3() | INICIO');

        if (($batch_id == "BATCH_NO_CREADO") || ($batch_id == "RECI_NO_VACIO")) {
            log_message('ERROR', 'Error en creacion Batch. batch_id: >>' . $batch_id);
            echo ("Error en creacion Batch");
            return;
        }

        $pedido = $this->Etapas->obtenerPedidoXBatch($batch_id)['data'];
        if ($pedido) {
            $pedido = reset($pedido);
            $pema_id = $pedido->pema_id;
            if ($nuevo == 'guardar') {
                $this->Etapas->eliminarDetallePedido($pema_id);
                $respDetalle = $this->guardarDetallePedido($pema_id, $post_data);
            }

        } else {
            ////////////// INSERTAR CABECERA NOTA PEDIDO   ///
            $arrayPost['fecha'] = $post_data['fecha'];
            $arrayPost['empr_id'] = (string) empresa();
            $arrayPost['batch_id'] = $batch_id;

            $cab['_post_notapedido'] = $arrayPost;
            $response = $this->Etapas->setCabeceraNP($cab);
            $pema_id = $response->nota_id->pedido_id;

            if (!$pema_id) {
                log_message('ERROR', 'Error en generación de Cabecera Pedido Materiales. pema_id: >>' . $pema_id);
                echo ("Error en generacion de Cabecera Pedido Materiales");
                return;
            }

            $respDetalle = $this->guardarDetallePedido($pema_id, $post_data);
        }

        if ($nuevo == 'iniciar') {
            $this->lanzarPedidoEtapa($pema_id);
        }

        log_message('DEBUG', '#TRAZA | TRAZ-PROD-TRAZASOFT | ETAPA | guardarParte3() | FIN');

    }

    public function guardarDetallePedido($pema_id, $post_data)
    {
        $materia = $post_data['materia'];
        if($materia){
        foreach ($materia as $o) {
            if ($cantidad !== "") {
                $det['pema_id'] = $pema_id;
                $det['arti_id'] = (string) $o['id_materia'];
                $det['cantidad'] = $o['cantidad'];
                $detalle['_post_notapedido_detalle'][] = $det;
            }
        }
        $arrayDeta['_post_notapedido_detalle_batch_req'] = $detalle;
        $respDetalle = $this->Etapas->setDetaNP($arrayDeta);
        }
        if ($respDetalle >= 300) {
            log_message('ERROR', 'Error en generacion de Detalle Pedido Materiales. respDetalle: >>' . $respDetalle);
            echo ("Error en generacion de Detalle Pedido Materiales");
            return false;
        }
        return true;
    }

    public function lanzarPedidoEtapa($pema_id)
    {
        log_message("DEBUG", "ETAPA / lanzarPedidoEtapa >> pema_id: $pema_id");

        $contract['pIdPedidoMaterial'] = $pema_id;
        $rsp = $this->bpm->lanzarProceso(BPM_PROCESS_ID_PEDIDOS_NORMALES, $contract);
        if (!$rsp['status']) {
            log_message('ERROR', 'Etapa/lanzarPedidoEtapa >> Error al lanzar pedido');
            echo json_encode($rsp);
            return;
        }

        $this->load->model(ALM . 'Notapedidos');

        $this->load->model(ALM.'new/Pedidosmateriales');
        $this->Notapedidos->setCaseId($pema_id, $rsp['data']['caseId']);

        // AVANZA PROCESO A TAREA SIGUIENTE
        if (PLANIF_AVANZA_TAREA) {

            $this->aceptarPedidoMateriales($rsp['data']['caseId']);

        }
    }

    public function aceptarPedidoMateriales($case_id)
    {
        $taskId = $this->bpm->ObtenerTaskidXNombre(BPM_PROCESS_ID_PEDIDOS_NORMALES, $case_id, 'Aprueba pedido de Recursos Materiales');
        log_message('DEBUG', 'Etapa/guardar(ObtenerTaskidXNombre) #$taskId->' . $taskId);
        $user = userId();
        if ($taskId && $user) {
            $resultSetUsuario = $this->bpm->setUsuario($taskId, $user);
            $contract["apruebaPedido"] = true;

            if ($resultSetUsuario['status']) {
                $resulCerrar = $this->bpm->cerrarTarea($taskId, $contract);
                log_message('DEBUG', 'Etapa/guardar #$resulCerrar->' . $resulCerrar);
                return;
            }
        }
    }

    // trae info para informe de Etapa (Todas y Fraccionar)
    public function editar(){
        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | Etapa | editar()');
        $id = $this->input->get('id'); // batch_id

        $data['tarea'] = $this->Etapas->validarPedidoMaterial($id);

        $this->load->model(ALM . 'Articulos');
        #$data['articulos'] = $this->Articulos->obtenerXTipos(array('Proceso', 'Final'));

        $data['accion'] = 'Editar';
        $data['etapa'] = $this->Etapas->buscar($id)->etapa;
        $data['idetapa'] = $data['etapa']->id;

        #$data['materias'] = $this->Articulos->obtenerXTipos(array('Proceso', 'Final', 'Materia Prima'));
        // $data['productos'] = $this->Articulos->obtenerXTipos(array('Proceso', 'Producto'));

        // trae tablita de materia prima Origen y producto
         $data['matPrimas'] = $this->Etapas->getRecursosOrigen($id, MATERIA_PRIMA)->recursos->recurso;

        #Obtener Articulos por Etapa
        $data['productos_etapa'] = $this->Etapas->obtenerArticulos($data['etapa']->etap_id)['data'];

        $data['productos_salida_etapa'] = $this->Etapas->getSalidaEtapa($data['etapa']->etap_id)['data'];
        $data['productos_entrada_etapa'] = $this->Etapas->getEntradaEtapa($data['etapa']->etap_id)['data'];

        $data['producto'] = $this->Etapas->getRecursosOrigen($id, PRODUCTO)->recursos->recurso;

        $data['op'] = $data['etapa']->titulo;
        $data['lang'] = lang_get('spanish', 4);

        $data['establecimientos'] = $this->Establecimientos->listar()->establecimientos->establecimiento;
        $data['fecha'] = $data['etapa']->fecha;

        if ($data['etapa']->tiet_id == 'prd_tipos_etapaFraccionamiento') {
            // trae lotes segun entrega de materiales de almacen.(81)
            $data['recipientes'] = $this->Recipientes->obtener('DEPOSITO', 'TODOS', $data['etapa']->esta_id)['data'];
            $data['ordenProd'] = $data['etapa']->orden;
            $data['articulos_fraccionar'] = $this->Etapas->getEntradaEtapa($data['etapa']->etap_id)['data'];
            $data['articulos_fracc_salida'] = $this->Etapas->getSalidaEtapa($data['etapa']->etap_id)['data'];

            $this->load->view('etapa/fraccionar/fraccionar', $data);
        } else {

            $data['tareas'] = []; //$this->Tareas->listar()->tareas->tarea;
            $data['templates'] = []; //$this->Templates->listar()->templates->template;
            $data['recursosmateriales'] = []; //$this->Recursos_Materiales->listar()->recursos->recurso;
            $data['rec_trabajo'] = $this->Recursos->obtenerXTipo('TRABAJO')['data'];
            $this->load->view('etapa/abm_editar', $data);
        }
    }
    // guarda fraccionamiento y lanza pedido de materiales
    public function guardarFraccionar()
    {
        log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | ETAPA | guardarFraccionar()');
        //////////// PARA CREAR EL NUEVO BATCH ///////////////////
      //  $datosCab['lote_id'] = 'FRACCIONAMIENTO';
        $datosCab['lote_id'] =$this->input->post('lote_id');
        $datosCab['arti_id'] = (string) 0;
        $datosCab['prov_id'] = (string) PROVEEDOR_INTERNO;
        $datosCab['batch_id_padre'] = (string) 0;
        $datosCab['cantidad'] = (string) $this->input->post('cant_total_desc');
        $datosCab['cantidad_padre'] = (string) 0;
        $datosCab['num_orden_prod'] = (string) $this->input->post('ordProduccion');
        $datosCab['reci_id'] = $this->input->post('recipiente');
        $datosCab['etap_id'] = $this->input->post('idetapa');
        $datosCab['usuario_app'] = userNick();
        $datosCab['empr_id'] = (string) empresa();
        $datosCab['forzar_agregar'] = $this->input->post('forzar');
        $datosCab['fec_vencimiento'] = FEC_VEN;
        $datosCab['recu_id'] = (string) 0;
        $datosCab['tipo_recurso'] = "";

        #FLEIVA
        $datosCab['batch_id'] = "0";
        $datosCab['planificado'] = "false";
        $data['_post_lote'] = $datosCab;
        // guardo recursos materiales (origen)
        $productos = $this->input->post('productos');
        //guarda batch nuevo (tabla lotes)
        $respServ = $this->Etapas->SetNuevoBatch($data);

        if (!$respServ['status']) {
            echo json_encode($respServ);
            return;
        }

        $batch_id = $respServ['data']->respuesta->resultado;
        //////////// PARA GUARDAR EN RECURSOS LOTES ///////////////////
        $i = 0;
        foreach ($productos as $key => $prod) {
            $p = json_decode($prod);
            $recurso_id = $this->Etapas->getRecursoId($p->arti_id);
            $arrRec['batch_id'] = (string) $batch_id;
            $arrRec['recu_id'] = (string) $recurso_id;
            $arrRec['usuario'] = userNick();
            $arrRec['empr_id'] = (string) empresa();
            $arrRec['cantidad'] = (string) $p->cant_descontar; // cantidad a descontar en stock
            $arrRec['tipo'] = MATERIA_PRIMA;
            $arrRec['empa_id'] = (string) $p->empaque;
            $arrRec['empa_cantidad'] = (string) $p->cantidad; // cantidad del empaque
            $recu['_post_recurso'][$i] = (object) $arrRec;
            $i++;
        }
        // batch para guardar
        $arrayRecursos['_post_recurso_lote_batch_req'] = $recu;
        $respArtic = $this->Etapas->setRecursosLotesMat($arrayRecursos);

        ///////////////////////  PEDIDO DE MATERIALES //////////////////////////
        if (($batch_id != "BATCH_NO_CREADO") || ($batch_id != "RECI_NO_VACIO")) {
            ////////////// INSERTAR CABECERA NOTA PEDIDO   ///
            $arrayPost['fecha'] = $this->input->post('fecha');
            $arrayPost['empr_id'] = (string) empresa();
            $arrayPost['batch_id'] = (string) $batch_id;
            $cab['_post_notapedido'] = $arrayPost;
            $response = $this->Etapas->setCabeceraNP($cab);
            $pema_id = $response->nota_id->pedido_id;

            //Esto se debe cambiar por fórmulas
            // $envases = array();
            //////////// PARA CREAR EL BATCH PARA EL BATCH REQUEST //////////
            if ($pema_id) {
                $x = 0;
                foreach ($productos as $key => $prod) {
                    $p = json_decode($prod);
                    $det['pema_id'] = (string) $pema_id;
                    $det['arti_id'] = (string) $p->arti_id;
                    $det['cantidad'] = (string) $p->cant_descontar;
                    $detalle['_post_notapedido_detalle'][$x] = (object) $det;

                    // $envases[$key]['pema_id'] = (string) $pema_id;
                    // $envases[$key]['arti_id'] = (string) $p->envase_arti_id;
                    // $envases[$key]['cantidad'] = (string) $p->cantidad;
                    $x++;
                }
                $arrayDeta['_post_notapedido_detalle_batch_req'] = $detalle;
                $respDetalle = $this->Etapas->setDetaNP($arrayDeta);

                // $rsp = $this->pedidoEnvases($envases);

                if ($respDetalle < 300) {
                    /////// LANZAR EL PROCESO DE BONITA DE PEDIDO
                    $contract = [
                        'pIdPedidoMaterial' => $pema_id,
                    ];
                    $rsp = $this->bpm->lanzarProceso(BPM_PROCESS_ID_PEDIDOS_NORMALES, $contract);
                    if ($rsp['status']) {
                        $case_id = strval($rsp['data']['caseId']);
                        $this->load->model(ALM . 'Notapedidos');
                        $this->Notapedidos->setCaseId($pema_id, $case_id);
                        // AVANZA PROCESO A TAREA SIGUIENTE
                        if (PLANIF_AVANZA_TAREA) {

                            $this->aceptarPedidoMateriales($case_id);

                        }

                    }
                    echo json_encode($rsp);
                } else {
                    echo ("Error en generacion de Detalle Pedido Materiales");
                }
            } else {
                echo ("Error en generacion de Cabecera Pedido Materiales");
            }
        }
    }

    public function pedidoEnvases($envases)
    {
        if (false) { //HAY FORMULA

        } else {

            $detalle['_post_notapedido_detalle_batch_req']['_post_notapedido_detalle'] = $envases;

            $rsp = $this->Etapas->setDetaNP($detalle);

            return $rsp;
        }
    }
    // Elabora informe de Etapa hasta que se saque el total del contenido de batch origen
    public function Finalizar()
    {
        $productos = json_decode($this->input->post('productos'));
        $cantidad_padre = $this->input->post('cantidad_padre');
        $num_orden_prod = $this->input->post('num_orden_prod');
        $batch_id_padre = $this->input->post('batch_id_padre');
        $depo_id = $this->input->post('depo_id');

        foreach ($productos as $key => $value) {

            $arrayPost["lote_id"] = $value->lotedestino; // lote origen
            $arrayPost["arti_id"] = $value->id; // art seleccionado en lista
            $arrayPost["prov_id"] = (string) PROVEEDOR_INTERNO;
            $arrayPost["batch_id_padre"] = $batch_id_padre; // bacth actual
            $arrayPost["cantidad"] = $value->cantidad; // art seleccionado en lista
            $arrayPost["cantidad_padre"] = strval($key == (sizeof($productos) - 1) ? $cantidad_padre : 0); //cantida padre es lo que descuenta del batch actual
            $arrayPost["num_orden_prod"] = $num_orden_prod;
            $arrayPost["reci_id"] = $value->destino; //reci_id destino del nuevo batch
            $arrayPost["etap_id"] = (string) ETAPA_DEPOSITO;
            $arrayPost["usuario_app"] = userNick();
            $arrayPost["empr_id"] = (string) empresa();
            $arrayPost["forzar_agregar"] = $value->forzar;
            $arrayPost["fec_vencimiento"] = FEC_VEN;
            $arrayPost["recu_id"] = strval($value->recu_id);
            $arrayPost["tipo_recurso"] = $value->tipo_recurso;
            $arrayPost['batch_id'] = "0";
            $arrayPost['planificado'] = "false";
            $arrayPost['noco_list'] = isset($value->nocos)?implode(';',$value->nocos):'';
            $arrayDatos['_post_lote_noconsumibles_list_batch_req']['_post_lote_noconsumibles_list'][] = $arrayPost;
						$noco_list = isset($value->nocos)? $value->nocos:'';
        }
			// se crean lotes nuevos a traves de un store procedure
            $rsp = $this->Etapas->finalizarEtapa($arrayDatos);

				// si tiene asociado no consumibles se guarda el movimiento y el nuevo estado
				if ($rsp['status']){

						// Si hay que asociar Noconsmibles
						if ($this->input->post('noConsumAsociar')) {

								$this->load->model('general/Noconsumibles');
								$depo_id = $this->input->post('depo_id');
								$estado = $this->input->post('estado');
								$destino = "";
                                if ($noco_list !='' and $noco_list != null ){
                                    $respNoco = $this->Noconsumibles->movimientoNoConsumibles($noco_list, $estado, $depo_id, $destino);

                                    if ($respNoco == null) {
                                            # si la respuesta es negativa corto la ejecucion
                                            log_message('ERROR','#TRAZA|TRAZ-PROD-TRAZASOFT|ETAPA|Finalizar() >> ERROR: NO SE PUDO ASOCIAR LOS NO CONSMIBLES.');
                                            echo json_encode($rsp = array('mensNoCons'=>'No se pudieron asociar los No Consumibles'));
                                            return;
                                    }
                                }
						}
				}

        if ($rsp['status']) {

            $rsp['data'] = $this->Etapas->buscar($batch_id_padre)->etapa;
        }

        echo json_encode($rsp);
    }
    // Informe de etata fracccionamiento.
    public function finalizaFraccionar()
    {
        log_message('DEBUG',"#TRAZA | #TRAZ-PROD-TRAZASOFT | Etapa | finalizaFraccionar()");
        $productos = $this->input->post('productos');
        $num_orden_prod = $this->input->post('num_orden_prod');
        $batch_id_padre = $this->input->post('batch_id');

        foreach ($productos as $info) {
            $arrayPost["lote_id"] = $info['lotedestino']; // lote origen
            $arrayPost["arti_id"] = $info['arti_id']; // art seleccionado en lista
            $arrayPost["prov_id"] = (string) PROVEEDOR_INTERNO;
            $arrayPost["batch_id_padre"] = $batch_id_padre; // bacth actual
            $arrayPost["cantidad"] = $info['cantidad']; // art seleccionado en lista
            $arrayPost["cantidad_padre"] = "0"; //cantida padre esl lo que descuenta del batch actual
            $arrayPost["num_orden_prod"] = $num_orden_prod;
            $arrayPost["reci_id"] = $info['destino']; //reci_id destino del nuevo batch
            $arrayPost["etap_id"] = (string) ETAPA_DEPOSITO;
            $arrayPost["usuario_app"] = userNick();
            $arrayPost["empr_id"] = (string) empresa();
            $arrayPost["forzar_agregar"] = $info['forzar'];
            $arrayPost["fec_vencimiento"] = FEC_VEN;
            $arrayPost["recu_id"] = "0";
            $arrayPost["tipo_recurso"] = "";
            #FLEIVA
            $arrayPost['batch_id'] = "0";
            $arrayPost['planificado'] = "false";
            $arrayPost['noco_list'] = isset($info->nocos) ? implode(';',$info->nocos) : '';// Para reutilizar el stored procedure de Noco's
            $arrayDatos['_post_lote_noconsumibles_list_batch_req']['_post_lote_noconsumibles_list'][] = $arrayPost;
        }

        $rsp = $this->Etapas->finalizarEtapa($arrayDatos);

        if ($rsp['status']) {
            $rsp = $this->Etapas->buscar($batch_id_padre)->etapa;
        }

        echo json_encode($rsp);
    }
    /**
        * Levanta pantalla abm fraccionar
        * @param 
        * @return view etapa fraccionar
	*/
    public function fraccionar()
    {
        log_message('DEBUG',"#TRAZA | #TRAZ-PROD-TRAZASOFT | Etapa | fraccionar()");
        $this->load->model(ALM . 'Articulos');
        $this->load->model('general/Recipientes');

        $data['articulos'] = $this->Articulos->getList();

        $data['accion'] = 'Nuevo';
        $data['id'] = $this->input->get('op');
        $data['etapa'] = $this->Etapas->nuevo($data['id'])->etapa;
        $data['fecha'] = date('Y-m-d');
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
        $data['articulos_fraccionar'] = $this->Etapas->getEntradaEtapa($data['id'])['data'];
        $data['articulos_fracc_salida'] = $this->Etapas->getSalidaEtapa($data['id'])['data'];

        $this->load->view('etapa/fraccionar/fraccionar', $data);
    }

    public function finalizarLote()
    {
        $id = $this->input->post('batch_id');
        $rsp = $this->Etapas->finalizarLote($id);
        echo json_encode($rsp);
    }

    public function validarPedidoMaterial($batch_id)
    {
        $rsp['tarea'] = $this->Etapas->validarPedidoMaterial($batch_id);
        echo json_encode($rsp);
    }

    public function getUsers()
    {
        // $usuarios = $this->bpm->getUsuariosBPM();//usuarios bonita
        $usuarios = $this->Etapas->getUsers()->usuarios->usuario; //usuarios seg.users
        echo json_encode($usuarios);
    }

    public function getTurnosProd()
    {
        $turnos = $this->Etapas->getTurnosProd()->turnos->turno;
        echo json_encode($turnos);
    }

    public function setUserLote()
    {
        $batch_id = $this->input->post('batch_id');

        //eliminamos los resonsables viejos
        $delete = $this->Etapas->deleteUserLote($batch_id);

        //cargamos los responsables nuevos
        $responsables = $this->input->post('responsables');
        $tableData = stripcslashes($responsables);
        $tableDataArray['responsable'] = json_decode($tableData, true);
        foreach ($tableDataArray['responsable'] as $key => $x) {
            $tableDataArray['responsable'][$key]['batch_id'] = $batch_id;
            $tableDataArray['responsable'][$key]['user_id'] = strval($tableDataArray['responsable'][$key]['user_id']);
            $tableDataArray['responsable'][$key]['turn_id'] = strval($tableDataArray['responsable'][$key]['turn_id']);
        }
        $responsablesArray['_post_responsable'] = $tableDataArray;
        $rsp = $this->Etapas->setUserLote($responsablesArray);
        if ($rsp == '202') {
            echo 'Responsables cargados correctamente.';
        } else {
            return;
        }

    }

    public function getUserLote($batch_id)
    {
        $user = $this->Etapas->getUserLote($batch_id)->users->user;
        echo json_encode($user);
    }
    
    /**
        * Valida el formulario asociado al orta_id
        * @param integer $orta_id
        * @return bool true or false
    */
    public function validarFormularioCalidad($orta_id){
        $res = $this->Etapas->validarFormularioCalidad($orta_id);
        echo json_encode(['status' => $res]);
    }

    public function obtenerProductosSalida($etapId)
    {
        $productos_salida_etapa = $this->Etapas->getSalidaEtapa($etapId)['data'];
        echo selectBusquedaAvanzada('inputproducto', 'id', $productos_salida_etapa, 'arti_id', 'descripcion');
    }

    public function obtenerNoConsumibles()
    {
        $this->load->model('general/Noconsumibles');
				$emp = empresa();
        $rsp = $this->Noconsumibles->obtenerXEstado($emp, 'ACTIVO');
        if($rsp['status']){
            echo selectBusquedaAvanzada('noco_id', 'noco_id', $rsp['data'], 'codigo', 'codigo');
        }else echo 'S/N';
    }
    /**
        * Elimina el lote enviado
        * @param integer batch_id
        * @return array respuesta del servicio
	*/
    public function eliminarEtapa($batchId){
        log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | Etapa | eliminarEtapa($batchId)');
        $rsp = $this->Etapas->eliminarEtapa($batchId);
        echo json_encode($rsp);
    }

    public function abmEtapa()
    {
        log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | #ETAPA | abmEtapa()');
        $data['listarProcesos'] = $this->Procesos->listarProcesos()->procesos->proceso;
        $data['listarTipos'] = $this->Etapas->listarTipos()->tablas->tabla;
        $data['listarFormularios'] = $this->Forms->listarFormularios()->formularios->formulario;        
        $data['listarEtapasProductivas'] = $this->Etapas->listarEtapasProductivas()->etapas_productivas->etapa_productiva;
        $data['listarArticulos'] = $this->Etapas->listarArticulos()->articulos->articulo;
        $this->load->view('etapa/abm_etapa/view_',$data);
    }

    public function listarEtapas()
	{
		log_message('INFO','#TRAZA|| >> ');
		$data['listarEtapasProductivas'] = $this->Etapas->listarEtapasProductivas()->etapas_productivas->etapa_productiva;
		$this->load->view('etapa/abm_etapa/listar', $data);
	}

    public function guardarEtapa()
	{
        log_message('INFO','#TRAZA | #TRAZ-PROD-TRAZASOFT | Etapa | guardarEtapa() ');
		$etapa = $this->input->post('datos');
		$etapa['empr_id'] = empresa();
        if (!$etapa['form_id']) {
            $etapa['form_id'] = NULL;
        }
		$resp = $this->Etapas->guardarEtapa($etapa);
		if ($resp != null) {
			return json_encode(true);
		} else {
			return json_encode(false);
		}
	}

    public function editarEtapa()
	{
		$etapa = $this->input->post('datos');
		$etapa['empr_id'] = empresa();
		$resp = $this->Etapas->editarEtapa($etapa);
		echo json_encode($resp);
	}

    public function borrarEtapa()
	{
		log_message('INFO','#TRAZA|TRAZ-PROD-TRAZASOFT|ETAPAS|BORRARETAPAS >> ');
		$etap_id = $this->input->post('etap_id');
		$result = $this->Etapas->borrarEtapa($etap_id);
		echo json_encode($result);
	}

    public function listarArticulosYTipos()
    {
        $etap_id = $this->input->get('etap_id');
        $empr_id = empresa();
        $resp =  $this->Etapas->listarArticulosYTipos($etap_id,$empr_id);
        if ($resp != null) {
			echo json_encode($resp);            
		} else {
			echo json_encode($resp);
		}
    }

    public function borrarArticuloDeEtapa()
    {
        log_message('INFO','#TRAZA | ETAPAS | borrarValor() >> ');
		$arti_id = $this->input->post('arti_id');
        $tipo = $this->input->post('tipo');
        $etap_id = $this->input->post('etap_id');
        switch ($tipo) {
            case 'Entrada':
                $result = $this->Etapas->borrarArticuloEntrada($arti_id, $etap_id);
                break;
            case 'Producto':
                $result = $this->Etapas->borrarArticuloProducto($arti_id, $etap_id);
                break;
            case 'Salida':
                $result = $this->Etapas->borrarArticuloSalida($arti_id, $etap_id);
                break;
        };
		// $result = $this->Etapas->borrarArticuloDeEtapa($arti_id, $tipo);
		echo json_encode($result);
    }

    public function guardarArticulo()
	{
        $data = $this->input->post('datos');
		$resp = $this->Etapas->guardarArticulo($data);
        echo json_encode($resp);
	}

    public function validarEtapa()
	{
        log_message('INFO','#TRAZA | #TRAZ-PROD-TRAZASOFT | Etapa | validarEtapa() ');

		$etapa = $this->input->post('datos');
		$etapa['empr_id'] = empresa();

		$resp = $this->Etapas->validarEtapa($etapa);
        
        echo json_encode($resp);
	}
    /**
        * Obtiene los lotes a fraccionar
        * @param array con datos de lotes para fraccionamiento
        * @return array respuesta del servicio
	*/
    public function getLotesFraccionar(){
        log_message('INFO','#TRAZA | #TRAZ-PROD-TRAZASOFT | Etapa | getLotesFraccionar() ');

        $batch_id = $this->input->post('batch_id');

        $lotesFracc['data'] = $this->Etapas->getLotesaFraccionar($batch_id)->lotes->lote;
        
        if(!empty($lotesFracc)){
            $lotesFracc['status'] = true;
            echo json_encode($lotesFracc);
        }else{
            echo json_encode(array("status" => false,"msj" => "No se encontraron lotes a fraccionar"));
        }
    }
}
