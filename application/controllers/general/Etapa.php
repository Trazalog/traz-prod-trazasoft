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
        $this->load->model(TAREAS_ASIGNAR . '/Tareas');
        $this->load->model(TAREAS_ASIGNAR . '/Templates');
        $this->load->model(TAREAS_ASIGNAR . '/Recursos_Materiales');
        $this->load->model('general/Recursos');
    }

    // Muestra listado de etapas
    public function index()
    {

        $data['list'] = $this->Etapas->listar()->etapas->etapa;
        $temp = $this->Etapas->listarEtapas()->etapas->etapa;
        //reforma las url segun id
        foreach ($temp as $value) {
            if ($value->id == 5) {
                $urlComp = $value->link . 'fraccionar';
                $value->link = $urlComp;
            } else {
                $urlComp = $value->link . 'nuevo?op=' . $value->id;
                $value->link = $urlComp;
            }
        }
        $data['etapas'] = $temp;
        $this->load->view('etapa/list', $data);
    }
    // Llama a etapas para una nueva Etapa
    public function nuevo()
    {
        #Snapshot
        $user = userNick();
        $view = 'etapa/abm';
        $data['key'] = $view . $user;

        $data['fecha'] = date('Y-m-d');
        $data['id'] = $this->input->get('op');
        $data['etapa'] = $this->Etapas->nuevo($data['id'])->etapa; // listo llama a etapas/1
        $data['idetapa'] = $data['etapa']->id;
        $data['accion'] = 'Nuevo';
        $data['op'] = $data['etapa']->titulo;

        $this->load->model(ALM . 'Articulos');
        $data['materias'] = $this->Articulos->getList(); // listo
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
        log_message('DEBUG', 'ETAPA >> guardar | INICIO');

        $post_data = $this->input->post('data');

        log_message('DEBUG', 'C#ETAPA > guardar | #DATA-POST: ' . json_encode($post_data));
        //////////// PARA CREAR EL NUEVO BATCH ///////////////////

        $datosCab['arti_id'] = (string) $post_data['idprod'];
        $datosCab['lote_id'] = (string) $post_data['lote'];
        $datosCab['prov_id'] = (string) PROVEEDOR_INTERNO;
        $datosCab['batch_id_padre'] = (string) 0;
        $datosCab['cantidad'] = (string) $post_data['cantidad'];
        $datosCab['cantidad_padre'] = (string) 0;
        $datosCab['num_orden_prod'] = (string) $post_data['op'];
        $datosCab['reci_id'] = (string) $post_data['recipiente'];
        $datosCab['etap_id'] = (string) $post_data['idetapa'];
        $datosCab['usuario_app'] = userNick();
        $datosCab['empr_id'] = (string) empresa();
        $datosCab['forzar_agregar'] = "FALSE";
        $datosCab['fec_vencimiento'] = date('d-m-Y');
        $datosCab['recu_id'] = "0";
        $datosCab['tipo_recurso'] = "";

        $batch_id = (string) $post_data['batch_id']; //mbustos
        $datosCab['batch_id'] = $batch_id; // SI LO MANDA VACIO LO CREA SINO LO EDITAR
        $estado = $post_data['estadoEtapa']; //mbustos

        if ($estado == 'PLANIFICADO' || $nuevo == 'guardar') {
            $datosCab['planificado'] = 'true';
            $data['_post_lote'] = $datosCab;

            //guarda batch existente modificado (tabla lotes)

        } else {
            $datosCab['planificado'] = "";

            $data['_post_lote'] = $datosCab;

        }
        $respServ = $this->Etapas->SetNuevoBatch($data);

        #En el caso de no existir devuelve nuevo BATCH_ID SINO el EXISTENTE
        $batch_id = $respServ->respuesta->resultado;

        if (!$batch_id) {
            log_message('ERROR', 'Etapa/guardar #ERROR BATCH_ID NULO: >>' . $batch_id);
            echo ("Error en creacion Batch");
        }

        log_message('DEBUG', 'ETAPA >> guardar | FIN');

        $this->guardarParte2($post_data, $datosCab, $batch_id);

        $this->guardarParte3($post_data, $batch_id);

    }

    public function guardarParte2($post_data, $datosCab, $batch_id)
    {
        log_message('DEBUG', 'ETAPA >> guardarParte2 | INICIO');

        // guardo recursos materiales (origen)
        $materia = $post_data['materia'];

        // busca id recurso por id articulo
        $recu_id = $this->Etapas->getRecursoId($datosCab['arti_id']);

        // guarda producto en tabla recurso_lotes
        $respRecurso = $this->Etapas->setRecursosLotesProd($batch_id, $recu_id, $datosCab['cantidad']);
        if (!$respRecurso['status']) {
            log_message('ERROR', 'ETAPA/guardarParte2 >> Fallo: guarda producto en tabla recurso_lotes');
            echo json_encode($respRecurso);
            return;
        }
        // guarda articulos(id de recurso en tabla recursos) origen en tabla recursos_lotes
        $arrayTemp1 = array();
        $arrayTemp1['request_box']['_delete_recurso_lote']['batch_id'] = $batch_id;
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

        log_message('DEBUG', 'JSON request_box: >>' . json_encode($arrayTemp1));

        $rspRequestBox = $this->Etapas->setRecursosLotes_requestBox($arrayTemp1);
        log_message('DEBUG', 'setRecursosLotes_requestBox(): >>' . $rspRequestBox);
        if (!$rspRequestBox['status']) {
            log_message('ERROR', 'setRecursosLotes_requestBox(): >>' . $rspRequestBox);
            echo ("Error al guardar las materias primas. ");
        }

        log_message('DEBUG', 'ETAPA >> guardarParte2 | FIN');

    }

    public function guardarParte3($post_data, $batch_id)
    {

        log_message('DEBUG', 'ETAPA >> guardarParte3 | INICIO');

        if (($batch_id == "BATCH_NO_CREADO") || ($batch_id == "RECI_NO_VACIO")) {
            log_message('ERROR', 'Error en creacion Batch. batch_id: >>' . $batch_id);
            echo ("Error en creacion Batch");
            return;
        }

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

        $materia = $post_data['materia'];
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

       // if ($estado != "PLANIFICADO" || $nuevo == 'iniciar') {

          if(true){ 
            if ($respDetalle < 300) {

                $contract['pIdPedidoMaterial'] = $pema_id;
                $rsp = $this->bpm->lanzarProceso(BPM_PROCESS_ID_PEDIDOS_NORMALES, $contract);

                $this->load->model(ALM . 'Notapedidos');
                if ($rsp['status']) {
                    echo ("ok");
                    $this->Notapedidos->setCaseId($pema_id, $rsp['data']['caseId']);

                    // AVANZA PROCESO A TAREA SIGUIENTE
                    if (PLANIF_AVANZA_TAREA) {

                        $taskId = $this->bpm->ObtenerTaskidXNombre(BPM_PROCESS_ID_PEDIDOS_NORMALES, $rsp['data']['caseId'], 'Aprueba pedido de Recursos Materiales');
                        log_message('DEBUG', 'Etapa/guardar(ObtenerTaskidXNombre) #$taskId->' . $taskId);

                        if ($taskId) {
                            $user = userId();
                            $resultSetUsuario = $this->bpm->setUsuario($taskId, $user);
                            log_message('DEBUG', 'Etapa/guardar #$user->' . $user);
                            log_message('DEBUG', 'Etapa/guardar #$resultSetUsuario->' . $resultSetUsuario);

                            $contract = array(
                                "apruebaPedido" => true,
                            );
                            if ($resultSetUsuario['status']) {
                                $resulCerrar = $this->bpm->cerrarTarea($taskId, $contract);
                                log_message('DEBUG', 'Etapa/guardar #$resulCerrar->' . $resulCerrar);
                            }
                        }
                    }
                } else {
                    echo ($rsp['msj']);
                }
            } else {

                echo ("Error en generacion de Detalle Pedido Materiales");
                log_message('ERROR', 'Error en generacion de Detalle Pedido Materiales. respDetalle: >>' . $respDetalle);
            }
        } elseif ($estado == "PLANIFICADO") { //&& $result['data']
            log_message('DEBUG', 'Guardado, batch_id: >>' . $batch_id);
            echo ($batch_id);
            // echo json_decode($result);
        } else {
            log_message('ERROR', 'Error al guardar. estado: >>' . $estado);
            echo ("Error al guardar");
        }

        log_message('DEBUG', 'ETAPA >> guardarParte3 | FIN');

    }

    // trae info para informe de Etapa (Todas y Fraccionar)
    public function editar()
    {
        $id = $this->input->get('id'); // batch_id

        $data['accion'] = 'Editar';
        $data['etapa'] = $this->Etapas->buscar($id)->etapa;
        $data['idetapa'] = $data['etapa']->id;
        //$data['recipientes'] = $this->Recipientes->listarPorEstablecimiento($data['etapa']->establecimiento->id)->recipientes->recipiente;
        $data['recipientes'] = $this->Recipientes->obtener('DEPOSITO', 'TODOS', $data['etapa']->esta_id)['data'];
        // trae tablita de materia prima Origen y producto
        $data['matPrimas'] = $this->Etapas->getRecursosOrigen($id, MATERIA_PRIMA)->recursos->recurso;
        $data['producto'] = $this->Etapas->getRecursosOrigen($id, PRODUCTO)->recursos->recurso;
        // trae recipientes de Tipo Deposito
        //$data['recipientes'] = $this->Recipientes->listarTodosDeposito()->recipientes->recipiente;
        // $data['op'] =     $data['etapa']->orden;
        $data['op'] = $data['etapa']->titulo;
        $data['lang'] = lang_get('spanish', 4);
        // $data['establecimientos'] = $this->Establecimientos->listar(2)->establecimientos->establecimiento;
        $data['establecimientos'] = $this->Establecimientos->listar()->establecimientos->establecimiento;
        $data['materias'] = $this->Materias->listar()->materias->materia;
        $data['fecha'] = $data['etapa']->fecha;

        if ($data['op'] == 'Fraccionamiento') {
            // trae lotes segun entrega de materiales de almacen.(81)
            $data['lotesFracc'] = $this->Etapas->getLotesaFraccionar($id)->lotes->lote;
            $data['ordenProd'] = $data['etapa']->orden;
            //$data['matfraccionar'] = $this->Etapas->getRecursosFraccionar($id, MATERIA_PRIMA)->recursos->recurso;
            //$data['lotesFracc'] = $this->Etapas->getLotesaFraccionar(81)->lotes->lote;
            //$data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
            $this->load->view('etapa/fraccionar/fraccionar', $data);
        } else {

            $data['tareas'] = []; //$this->Tareas->listar()->tareas->tarea;
            $data['templates'] = []; //$this->Templates->listar()->templates->template;
            $data['recursosmateriales'] = []; //$this->Recursos_Materiales->listar()->recursos->recurso;
            $data['rec_trabajo'] = $this->Recursos->obtenerXTipo('TRABAJO')['data'];
            $this->load->view('etapa/abm', $data);
        }
    }
    // guarda fraccionamiento y lanza pedido de materiales
    public function guardarFraccionar()
    {

        //////////// PARA CREAR EL NUEVO BATCH ///////////////////
        $datosCab['lote_id'] = 'FRACCIONAMIENTO';
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
        $datosCab['forzar_agregar'] = "FALSE";
        $datosCab['fec_vencimiento'] = "01-01-1899";
        $datosCab['recu_id'] = (string) 0;
        $datosCab['tipo_recurso'] = "";
        $data['_post_lote'] = $datosCab;
        // guardo recursos materiales (origen)
        $productos = $this->input->post('productos');
        //guarda batch nuevo (tabla lotes)
        $respServ = $this->Etapas->SetNuevoBatch($data);
        $batch_id = $respServ->respuesta->resultado;
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

            //////////// PARA CREAR EL BATCH PARA EL BATCH REQUEST //////////
            if ($pema_id) {
                $x = 0;
                foreach ($productos as $key => $prod) {
                    $p = json_decode($prod);
                    $det['pema_id'] = (string) $pema_id;
                    $det['arti_id'] = (string) $p->arti_id;
                    $det['cantidad'] = (string) $p->cant_descontar;
                    $detalle['_post_notapedido_detalle'][$x] = (object) $det;
                    $x++;
                }
                $arrayDeta['_post_notapedido_detalle_batch_req'] = $detalle;
                $respDetalle = $this->Etapas->setDetaNP($arrayDeta);

                if ($respDetalle < 300) {
                    /////// LANZAR EL PROCESO DE BONITA DE PEDIDO
                    $contract = [
                        'pIdPedidoMaterial' => $pema_id,
                    ];
                    $rsp = $this->bpm->lanzarProceso(BPM_PROCESS_ID_PEDIDOS_NORMALES, $contract);
                    if ($rsp['status']) {
                        echo ("ok");
                    } else {
                        echo ($rsp['msj']);
                    }
                } else {
                    echo ("Error en generacion de Detalle Pedido Materiales");
                }
            } else {
                echo ("Error en generacion de Cabecera Pedido Materiales");
            }
        }
    }
    // Elabora informe de Etapa hasta que se saque el total del contenido de batch origen
    public function Finalizar()
    {
        $productos = json_decode($this->input->post('productos'));
        $cantidad_padre = $this->input->post('cantidad_padre');
        $num_orden_prod = $this->input->post('num_orden_prod');
        $lote_id = $this->input->post('lote_id');
        $batch_id_padre = $this->input->post('batch_id_padre');

        foreach ($productos as $key => $value) {

            $arrayPost["lote_id"] = $lote_id; // lote origen
            $arrayPost["arti_id"] = $value->id; // art seleccionado en lista
            $arrayPost["prov_id"] = (string) PROVEEDOR_INTERNO;
            $arrayPost["batch_id_padre"] = $batch_id_padre; // bacth actual
            $arrayPost["cantidad"] = $value->cantidad; // art seleccionado en lista
            $arrayPost["cantidad_padre"] = strval($key == (sizeof($productos) - 1) ? $cantidad_padre : 0); //cantida padre esl lo que descuenta del batch actual
            $arrayPost["num_orden_prod"] = $num_orden_prod;
            $arrayPost["reci_id"] = $value->destino; //reci_id destino del nuevo batch
            $arrayPost["etap_id"] = (string) ETAPA_DEPOSITO;
            $arrayPost["usuario_app"] = userNick();
            $arrayPost["empr_id"] = (string) empresa();
            $arrayPost["forzar_agregar"] = $value->unificar;
            $arrayPost["fec_vencimiento"] = "01-01-1988";
            $arrayPost["recu_id"] = strval($value->recu_id);
            $arrayPost["tipo_recurso"] = $value->tipo_recurso;
            $arrayDatos['_post_lote_list_batch_req']['_post_lote_lis'][] = $arrayPost;
        }

        $resp = $this->Etapas->finalizarEtapa($arrayDatos);

        if ($resp > 300) {
            echo ("Error en dataservice");
            return;
        } else {
            echo ("ok");
        }
    }
    // Informe de etata fracccionamiento.
    public function finalizaFraccionar()
    {

        $productos = json_decode($this->input->post('productos'));
        $cantidad_padre = $this->input->post('cantidad_padre');
        $num_orden_prod = $this->input->post('num_orden_prod');
        $lote_id = $this->input->post('lote_id');
        $batch_id_padre = $this->input->post('batch_id');
        $cantidad = $this->input->post('cant_total_desc');

        foreach ($productos as $value) {

            $info = json_decode($value);
            $arrayPost["lote_id"] = $info->loteorigen; // lote origen
            $arrayPost["arti_id"] = $info->id; // art seleccionado en lista
            $arrayPost["prov_id"] = (string) PROVEEDOR_INTERNO;
            $arrayPost["batch_id_padre"] = $batch_id_padre; // bacth actual
            $arrayPost["cantidad"] = $info->cantidad; // art seleccionado en lista
            $arrayPost["cantidad_padre"] = $cantidad_padre; //cantida padre esl lo que descuenta del batch actual
            $arrayPost["num_orden_prod"] = $num_orden_prod;
            $arrayPost["reci_id"] = $info->destino; //reci_id destino del nuevo batch
            $arrayPost["etap_id"] = (string) ETAPA_DEPOSITO;
            $arrayPost["usuario_app"] = userNick();
            $arrayPost["empr_id"] = (string) empresa();
            $arrayPost["forzar_agregar"] = false;
            $arrayPost["fec_vencimiento"] = "01-01-1988";
            $arrayPost["recu_id"] = "0";
            $arrayPost["tipo_recurso"] = "";
            $arrayDatos['_post_lote_list_batch_req']['_post_lote_lis'][] = $arrayPost;
        }

        $resp = $this->Etapas->finalizarEtapa($arrayDatos);

        if ($resp > 300) {
            echo ("Error en dataservice");
            return;
        } else {
            echo ("ok");
        }
    }
    // Levanta pantalla abm fraccionar
    public function fraccionar()
    {
        $this->load->model(ALM . 'Articulos');
        $this->load->model('general/Recipientes');

        $data['articulos'] = $this->Articulos->getList();

        $data['accion'] = 'Nuevo';
        $data['etapa'] = $this->Etapas->nuevo(5)->etapa; // igual que en contrato pedido
        $data['fecha'] = date('Y-m-d');
        //TODO: VER SI TRAER PRODUCTO POR ID BATCH CON ESTA FUNCION
        //$data['producto'] = $this->Etapas->getRecursosOrigen($id, PRODUCTO)->recursos->recurso;
        //    $data['lang'] = lang_get('spanish',5);
        $data['establecimientos'] = $this->Establecimientos->listarTodo()->establecimientos->establecimiento;
        $data['empaques'] = $this->Recipientes->listarEmpaques()->empaques->empaque;
        //$data['materias'] = $this->Materias->listar()->materias->materia;
        $this->load->view('etapa/fraccionar/fraccionar', $data);
    }
}
