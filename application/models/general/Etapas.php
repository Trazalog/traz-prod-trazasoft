<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Etapas extends CI_Model
{
    private $rsp_lote = [
        "TOOLSERROR:RECI_NO_VACIO_DIST_ART" => "El recipiente ya contiene artículos distintos",
        "TOOLSERROR:RECI_NO_VACIO_DIST_LOTE_IGUAL_ART" => "El recipiente ya contiene lotes distintos",
        "TOOLSERROR:RECI_NO_VACIO_IGUAL_ART_LOTE" => "El recipiente ya contiene los mismos lotes y artículos",
    ];

    public function __construct()
    {
        parent::__construct();
    }
    // trae listado de etapas con sus datos (Tabla)
    public function listar()
    {
        $resource = '/lotes';
        $url = REST3 . $resource;
        $rsp = $this->rest->callApi('GET', $url);
        if ($rsp['status']) {
            $rsp = json_decode($rsp['data']);
        }
        return $rsp;
    }
    // Listado de etapas estandar para seleccionar
    public function listarEtapas()
    {

        log_message('DEBUG', 'Etapas/listarEtapas');
        $resource = '/etapas';
        $url = REST2 . $resource;
        $array = $this->rest->callAPI("GET", $url);
        $resp = json_decode($array['data']);
        return $resp;
    }
    public function buscar($id)
    {
        if (!$id) {
            log_message('DEBUG', 'Etapas/buscar #ERROR | BATCH_ID NULO');
            return;
        }
        $resource = '/lote/';
        $url = REST_PRD_LOTE. $resource . $id;
        $array = $this->rest->callAPI("GET", $url);
        $resp = json_decode($array['data']);

        return $resp;
    }
    public function nuevo($opcion)
    {
        log_message('DEBUG', 'Etapas/nuevo($opcion)-> ' . $opcion);

        $resource = '/etapas/';
        $url = REST2 . $resource . $opcion;
        $array = $this->rest->callAPI("GET", $url);
        wso2Msj($array);
        return json_decode($array['data']);
    }
    // devuelve id recurso por id articulo
    public function getRecursoId($arti_id)
    {

        $resource = '/recurso/';
        $url = REST2 . $resource . $arti_id;
        $array = $this->rest->callAPI("GET", $url); //tincho
        $resp = json_decode($array['data']);
        return $resp->recurso->recu_id;
    }
    // guarda prod en recursos lotes (productos)
    public function setRecursosLotesProd($batch_id, $recu_id, $cantidad)
    {

        $arrayDatos['batch_id'] = (string) $batch_id;
        $arrayDatos['recu_id'] = (string) $recu_id;
        $arrayDatos['usuario'] = userNick();
        $arrayDatos['empr_id'] = (string) empresa();
        $arrayDatos['cantidad'] = (string) $cantidad;
        $arrayDatos['tipo'] = 'PRODUCTO';
        // FLEIVA
        $arrayDatos['empa_id'] = "0";
        $arrayDatos['empa_cantidad'] = "0";
        // FLEIVA
        $data['_post_recurso'] = $arrayDatos;

        log_message('DEBUG', 'Etapas/setRecursosLotes(recursos a grabar)-> ' . json_encode($data));

        return $arrayDatos;

        // $resource = '/recurso/lote';
        // $url = REST2 . $resource;
        // $rsp = $this->rest->callAPI("POST", $url, $data);
        // wso2Msj($rsp);
        // return $rsp;
    }
    // guarda prod en recursos lotes (articulos)
    public function setRecursosLotesMat($data)
    {

        log_message('DEBUG', 'Etapas/setRecursos(materias a grabar)-> ' . $data);

        $resource = '/recurso/lote_batch_req';
        $url = REST_PRD_LOTE . $resource;
        $array = $this->rest->callAPI("POST", $url, $data);
        wso2Msj($array);
        return json_decode($array['status']);
    }

    //Tincho
    // guarda materias primas en recursos lotes (request_box)
    public function setRecursosLotes_requestBox($data)
    {
        $resource = '/request_box';
        $url = REST2 . $resource;
        $rsp = $this->rest->callAPI("POST", $url, $data);
        wso2Msj($rsp);
        return $rsp;
    }

    // Inicia nueva Etapa (ej siembra)
    public function SetNuevoBatch($data)
    {
        $this->load->model(ALM . 'Articulos');

        $arrayBatch = json_encode($data);
        log_message('DEBUG', 'Etapas/SetNuevoBatch(datos)-> ' . $arrayBatch);
        $resource = '/lote';
        $url = REST_PRD_LOTE . $resource;
        $rsp = $this->rest->callAPI("POST", $url, $data);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data']);
        } else {
            $msj = explode('-', wso2Msj($rsp));
            $rsp['error'] = $msj[0];
            $rsp['msj'] = $this->rsp_lote[$rsp['error']];
            foreach ($msj as $key => $o) {
                if (!$key) {
                    continue;
                }

                $aux = explode('=', $o);
                $rsp[$aux[0]] = $aux[1];
            }
        }
        $rsp['barcode'] = $this->Articulos->get($rsp['arti_id'])['barcode'];
        return $rsp;
    }
    // Guarda cabecera de Nota de pedido
    public function setCabeceraNP($data)
    {
        log_message('DEBUG', 'Etapas/setCabeceraNP(datos)-> ' . json_encode($data));
        $resource = '/notapedido';
        $url = REST2 . $resource;
        $array = $this->rest->callAPI("POST", $url, $data);
        return json_decode($array['data']);
    }
    // Guarda detalle de Nota de pedido
    public function setDetaNP($arrayDeta)
    {
        log_message('DEBUG', 'Etapas/setDetaNP(datos)-> ' . json_encode($arrayDeta));
        $resource = '/_post_notapedido_detalle_batch_req';
        $url = REST2 . $resource;
        $array = $this->rest->callAPI("POST", $url, $arrayDeta);
        return json_decode($array['code']);
    }

    public function setCaseIdPedido($pema_id, $case_id)
    {
        $data['_post_pedidosMateriales_case']['pema_id'] = $pema_id;
        $data['_post_pedidosMateriales_case']['case_id'] = $case_id;
        $resource = '/pedidosMateriales/case';
        $url = REST2 . $resource;
        $rsp = $this->rest->callAPI("POST", $url, $data);
        return $rsp;
    }

    // devuelve de recursos_lotes materia prima y producto segun id batch y tipo
    public function getRecursosOrigen($id, $recursoTipo)
    {

        $idBatch = json_encode($id);
        log_message('DEBUG', 'Etapas/getRecursosOrigen(batch_id)-> ' . $idBatch);
        log_message('DEBUG', 'Etapas/getRecursosOrigen(tipo de recurso)-> ' . $recursoTipo);
        $resource = '/recurso/lote/' . $id . '/tiporec/' . $recursoTipo;
        $url = REST2 . $resource;
        $array = $this->rest->callAPI("GET", $url, $id);
        return json_decode($array['data']);
    }
    public function getRecursosFraccionar($id, $recursoTipo)
    {

        // $idBatch = json_encode($id);
        // log_message('DEBUG', 'Etapas/getRecursosFraccionar(batch_id)-> ' . $idBatch);
        // log_message('DEBUG', 'Etapas/getRecursosFraccionar(tipo de recurso)-> ' . $recursoTipo);
        // $resource = '/lote/fraccionar/batch/'. $id .'/tipo/'.$recursoTipo;
        // $url = REST2 . $resource;
        // $array = $this->rest->callAPI("GET", $url);
        // return json_decode($array['data']);

        $parametros["http"]["method"] = "GET";
        $parametros["http"]["header"] = "Accept: application/json";
        $param = stream_context_create($parametros);
        $resource = '/lote/fraccionar/batch/' . $id . '/tipo/' . $recursoTipo;
        $url = REST2 . $resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    // Informe de Etapa (modal_finaizar)
    public function finalizarEtapa($arrayDatos)
    {
        log_message('DEBUG', 'Etapas/finalizarEtapa(datos)-> ' . json_encode($arrayDatos));
        $resource = '/_post_lote_list_batch_req';
        $url = REST_PRD_LOTE . $resource;
        $rsp = $this->rest->callAPI("POST", $url, $arrayDatos);
        if (!$rsp['status']) {
            $msj = explode('-', wso2Msj($rsp));
            $rsp['error'] = $msj[0];
            $rsp['reci_id'] = explode('=', $msj[1])[1];
            $rsp['msj'] = $this->rsp_lote[$rsp['error']];
        }

        return $rsp;
    }

    //TODO: BORAR DEPRECADA
    // Guarda fraccionamiento temp Etapa Fraccionamiento
    public function setFraccionamTemp($fraccionam)
    {
        log_message('DEBUG', 'Etapas/setFraccionamTemp(fraccionam)-> ' . json_encode($fraccionam));
        $resource = '/_post_fraccionamiento_batch_req';
        $url = REST2 . $resource;
        $array = $this->rest->callAPI("POST", $url, $fraccionam);
        return json_decode($array['code']);
    }

    // trae lotes a fraccionar desde entrega materiales por batch_id
    public function getLotesaFraccionar($id)
    {
        $resource = '/lote/fraccionar/batch/' . $id;
        $url = REST2 . $resource;
        $array = $this->rest->callAPI("GET", $url);
        return json_decode($array['data']);
    }

    public function obtenerArticulos($id_etapa)
    {
        $resource = "/etapas/productos/$id_etapa";
        $url = REST2 . $resource;
        $rsp = $this->rest->callAPI("GET", $url);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data'])->productos->producto;
        }
        return $rsp;
    }

    public function obtenerMateriales($id_etapa)
    {
        $resource = "/etapas/materiales/$id_etapa";
        $url = REST2 . $resource;
        $rsp = $this->rest->callAPI("GET", $url);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data'])->productos->producto;
        }
        return $rsp;
    }

    public function finalizarLote($id)
    {
        $post['_put_lote_finalizar']['batch_id'] = $id;
        $url = REST2 . "/lote/finalizar";
        $rsp = $this->rest->callApi('PUT', $url, $post);
        return $rsp;
    }

    public function getSalidaEtapa($etap_id)
    {
        $url = REST2 . "/etapas/salidas/$etap_id";
        $rsp = $this->rest->callApi('GET', $url);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data'])->salidas->salida;
        }
        return $rsp;
    }

    public function validarPedidoMaterial($batch_id)
    {
        if (PLANIF_AVANZA_TAREA) { #Pregunta Magica

            $url = REST_ALM . "pedidos/batch/$batch_id";

            $rsp = wso2($url);

            if ($rsp['status'] && $rsp['data']) {
                $caseId = $rsp['data'][0]->case_id;

                $tarea = $this->bpm->ObtenerTaskidXNombre(BPM_PROCESS_ID_PEDIDOS_NORMALES, $caseId, "Entrega pedido pendiente");

                return $tarea;
            }

            return false;
        } else {
            return false;
        }
    }

    public function asociarFormulario($batch_id, $info_id)
    {
        $rec = '_put_lote_instancia_formulario';
        $url = REST_PRD_ETAPA . "/$rec";
        $data[$rec] = array('batch_id' => $batch_id, 'info_id' => $info_id); 
        $res = wso2($url, 'PUT', $data);
        return $res;
    }
}
