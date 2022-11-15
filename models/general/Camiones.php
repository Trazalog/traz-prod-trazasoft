<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Camiones extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function listarPorEstablecimiento($establecimiento)
    {
        $resource = '/camion_establecimiento/' . $establecimiento;
        $url = REST_LOG . $resource;
        $array = file_get_contents($url, false, http('GET'));
        return rsp($http_response_header, false, json_decode($array)->camiones->camion);
    }
    public function listarProveedores()
    {
        $resource = '/proveedores/' . empresa();
        $url = REST_ALM . $resource;
        return wso2($url);
    }
    public function listarCargados($patente = null)
    {
        #HARDCODE
        $url = REST_LOG . '/camiones';
        $array = $this->rest->callApi('GET', $url);
        return json_decode($array['data']);
    }

    /**
    * Guarda la carga de camion(pantalla carga camion)
    * @param $data lotes cargados en pantalla
    * @return array respuesta del service
    */
    public function guardarCarga($data){
        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | guardarCarga() | #DATA: ' . json_encode($data));

        $this->load->model(ALM . '/Lotes');
        $this->load->model(PRD . 'general/Recipientes');
        $array = [];
        $camiones = [];

        foreach ($data as $key => $o) {
            #CREAR NUEVO RECIPIENTE
            $rsp = $this->Recipientes->crear($o);
            log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | guardarCarga() | #NEW RECIPIENTE ID: >> reci_id -> ' . json_encode($rsp));
            if (!$rsp['status']) {
                break;
            }
            $newReci = $rsp['data'];

            $o->reci_id = $newReci;
            $o->prov_id = PROVEEDOR_INTERNO;

            $array[] = $o;
            $camiones[] = array('motr_id' => $o->motr_id, 'estado' => 'CARGADO');
        }

        $rsp = $this->Lotes->guardarCargaCamion($array);

        if ($rsp['status']) {
            $rsp = $this->actualizarEstado($camiones);
        }

        return $rsp;
    }
    /**
        * Actualiza el estado en la tabla de movimientos_transportes
        * @param $data movimientos
        * @return array respuesta del service
    */
    public function actualizarEstado($data)
    {
        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | actualizarEstado() | DATA: ' . json_encode($data));

        $aux['post_camion_estado']['data'] = $data;
        $url = REST_PRD . "/camion/estado_batch_req";
        $rsp = $this->rest->callApi('PUT', $url, $aux);

        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | actualizarEstado() | RSP: ' . json_encode($rsp));

        return $rsp;
    }
    /**
        * Crea los lotes para guardar los productos y su stock
        * @param $data datos para crear los lotes(stored procedure)
        * @return array respuesta del service
    */
    public function guardarDescarga($data){
        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | guardarDescarga() | #DATA: ' . json_encode($data));

        $array = [];
        foreach ($data as $key => $o) {
            $array[] = array(
                "id" => $o['destino']['lote_id'],
                "producto" => $o['origen']['arti_id'],
                "prov_id" => $o['origen']['prov_id'],
                "batch_id_padre" => $o['origen']['batch_id'] ? $o['origen']['batch_id'] : 0,
                "cantidad" => $o['destino']['cantidad'],
                "stock" => $o['origen']['cantidad'],
                "reci_id" => $o['destino']['reci_id'],
                "forzar_agregar" => $o['destino']['unificar'],
            );
        }
        $array = json_decode(json_encode($array));
        $this->load->model(ALM . 'Lotes');
        $rsp = $this->Lotes->crearBatch($array);
        return $rsp;
    }

    public function finalizarSalida($data)
    {
        unset($data['patente']);
        $aux['update_camion'] = $data;
        $url = REST_LOG . "/camiones/salida";
        $rsp = $this->rest->callApi('PUT', $url, $aux);
        return $rsp;
    }
    /**
    * Obtiene la informacion cargada para una patente por estado
    * @param string $patente;$estado
    * @return array con datos del camion 
    */
    public function obtenerInfo($patente, $estado){
        $url = REST_LOG . "/camiones/$patente/".empresa();
        $rsp = wso2($url);
        if ($estado) {
            foreach ($rsp['data'] as $o) {
                if (strpos($estado, $o->estado) !== false) {
                    log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT| Camiones | obtenerInfo()  resp: >> " . json_encode($o));
                    return $o;
                }

            }
        }
    }
    /**
		* Recibo todo los movimientos por patente y loopeo sobre ellos para buscar movimientos que no se encuentren en estado FINALIZADO
		* @param $patente
		* @return array con datos de movimiento que no se encuentre en FINALIZADO, null en caso contrario.
    */
    public function getEstadosFinalizadosCamion($patente)
    {
        $url = REST_LOG . "/camiones/$patente/".empresa();
        $rsp = wso2($url);
    
        foreach ($rsp['data'] as $o) {
            if ($o->estado !== 'FINALIZADO') {
                log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT| Camiones | getEstadosFinalizadosCamion()  resp: >> " . json_encode($o));
                return $o;
            }
        }
    }
    /**
    * Listado de Movimientos de Transporte (Listado Recepción Camión)
    * @param
    * @return array con respuesta de servicio
    */
    public function listaTransporte()
    {
        $url = REST_LOG . '/transporte/movimiento/list/tipo_movimiento/' . empresa();
        return wso2($url);
    }

    public function listaCargaCTransporte()
    {
        $url = REST_LOG . '/transporte/movimiento/list/tipo_movimiento/' . empresa();
        return wso2($url);
    }

    /**
		* Esta función hara las veces de la pantalla CARGA CAMIÓN para proveedores externos
		* @param array frmCamion formulario de informacion y camion; frmDescarga datos de lotes cargados en listado de Recepciones MP
		* @return array con respuesta de servicio
    */
    public function guardarCargaCamionExterno($frmCamion, $frmDescarga){

        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | guardarCargaCamionExterno() | #frmCamion: ' . json_encode($frmCamion));
        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | guardarCargaCamionExterno() | #frmDescarga: ' . json_encode($frmDescarga));

        #Obtener motr_id
        $this->load->model('general/Entradas');
        $rsp = $this->obtenerInfo($frmCamion['patente'], 'EN CURSO');
        if(!isset($rsp->motr_id)){
            $rsp['msj'] = 'Error al obtener MOTR_ID';
            return $rsp;
        }

        $motr_id = $rsp->motr_id;

        #Carga Camión
        $lotes = [];
        foreach ($frmDescarga as $o) {
            $aux = new StdClass();

            $aux->patente = $frmCamion['patente'];
            $aux->motr_id = $motr_id;
            
            $aux->lote_id_origen = $o['origen']['lote_id'];
            $aux->lote_id_destino = $o['destino']['lote_id'];
            $aux->arti_id_origen = $o['origen']['arti_id'];
            $aux->arti_id_destino = $o['destino']['arti_id'];
            $aux->prov_id = $frmCamion['proveedor'];
            $aux->batch_id = !empty($o['origen']['batch_id']) ? $o['origen']['batch_id'] : 0;//Es null para externos
            $aux->cantidad_origen = $o['origen']['cantidad'];
            $aux->cantidad_destino = $o['destino']['cantidad'];
            $aux->num_orden_prod = !empty($o['origen']['orden_prod']) ? $o['origen']['orden_prod'] : '';
            $aux->reci_id_destino = $o['destino']['reci_id'];
            $aux->etap_id = ETAPA_TRANSPORTE;
            $aux->usuario_app = userNick();
            $aux->empre_id = empresa();
            $aux->forzar_agregar = $o['destino']['unificar'];
            $aux->fec_vencimiento = FEC_VEN;

            $lotes[] = $aux;
        }

        #Guardo carga y descarga de proveedor externo
        $rsp = $this->guardarCargaDescargaExterna($lotes);
        if (!$rsp['status']) {
            $rsp['msj'] = 'Error al guardar la CARGA del listado de recepciones del camión';
            return $rsp;
        }

        #Cambio Estado Camión a DESCARGADO
        $aux1 = array(array(
            'motr_id' => $motr_id,
            'estado' => 'DESCARGADO',
        ));

        $rsp = $this->actualizarEstado($aux1);

        return $rsp;
    }

    /**
    * Realiza la carga y descarga de un camión desde la RECEPCIÓN MP cuando es perteneciente a un proveedor externo.
    * Genera los recipientes y crea los lotes.
    * @param $data lotes cargados en pantalla
    * @return array $rsp respuesta del service
    */
    public function guardarCargaDescargaExterna($data)
    {

        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | guardarCargaDescargaExterna() | #DATA: ' . json_encode($data));

        $this->load->model(ALM . '/Lotes');
        $this->load->model(PRD . 'general/Recipientes');

        $lotes = [];

        $camiones = [];

        foreach ($data as $key => $o) {

            #CREAR NUEVO RECIPIENTE
            $rsp = $this->Recipientes->crear($o);
            log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | guardarCargaDescargaExterna() | #NEW RECIPIENTE ID: >> reci_id -> ' . json_encode($rsp));

            if (!$rsp['status']) {
                $rsp['msj'] = "Error al crear recipientes de la carga del camión";
                break;
            }

            $newReci = $rsp['data'];
            $o->reci_id = $newReci;

            #Creo el lote
            $rsp = $this->Lotes->crearLote($o);
            if (!$rsp['status']) {
                $rsp['msj'] = "Error al crear lotes de la carga del camión";
                break;
            }
            $o->batch_id = $rsp['data'];

            $lotes[] = $o;

            $camiones[] = array('motr_id' => $o->motr_id, 'estado' => 'CARGADO');

        }

        $rsp = $this->guardarDescargaExterna($lotes);

        #Acutalizo estado camión
        if ($rsp['status']) {

            $rsp = $this->actualizarEstado($camiones);
        }

        return $rsp;
    }
    /**
    * Crea los lotes necesarios para los articulos cargados en pantalla.
    * NOTA: Si batch_id_padre(seria el batch_id cargado en origen de la pantalla) es 0 crea lotes nuevos, no descuenta ni vacía)
    * @param $data lotes cargados en pantalla
    * @return array $rsp respuesta del service
    */
    public function guardarDescargaExterna($data){
        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | guardarDescarga() | #DATA: ' . json_encode($data));

        $array = [];
        foreach ($data as $key => $value) {
            $array[] = array(
                "id" => $value->lote_id_destino,
                "producto" => $value->arti_id_origen,
                "prov_id" => $value->prov_id,
                "batch_id_padre" => $value->batch_id,
                "batch_id" => "0",
                "cantidad" => $value->cantidad_destino,
                "stock" => $value->cantidad_origen,
                "reci_id" => $value->reci_id_destino,
                "forzar_agregar" => $value->forzar_agregar
            );
        }
        $array = json_decode(json_encode($array));
        $this->load->model(ALM . 'Lotes');
        $rsp = $this->Lotes->crearBatch($array);
        return $rsp;
    }

    /**
    * Guarda salida de camion a algun deposito interno o Salida al exterior
    * @param array con datos de salida
    * @return array con respuesta de servicio
    */
    public function guardarSalida($data)
    {
        log_message("DEBUG", "#TRAZA | TRAZ-PROD-TRAZASOFT | CAMIONES | guardarSalida()");
        $post['_put_camiones_salida'] = array(
            'motr_id' => strval($data['motr_id']),
            //'patente' => $data['patente'],
            'estado' => isset($data['destino_esta_id']) ? 'TRANSITO' : 'FINALIZADO',
            'bruto' => strval($data['bruto']),
            'tara' => strval($data['tara']),
            'neto' => strval($data['neto']),
        );
        return wso2(REST_LOG . '/camiones/salida', 'PUT', $post);
    }
    /**
    * Actualiza el estado del camion en prd.movimientos_transportes por motr_id
    * @param array motr_id;estado
    * @return array con respuesta de servicio
    */
    public function estado($patente, $estado, $estadoFinal){
        log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | Camiones | estado($patente, $estado, $estadoFinal)');
        $rsp = $this->obtenerInfo($patente, $estado);
        if($rsp){
            $url = REST_LOG . '/camiones/estado';
            $data['_put_camiones_estado'] = array(
                'motr_id' => $rsp->motr_id,
                'estado' => $estadoFinal
            );
            return wso2($url, 'PUT', $data);
        }
    }

    public function actualiarEstablecimiento($motrId, $estaId)
    {
        $url = REST_LOG.'/camiones/establecimiento';
        $data['_put_camiones_establecimiento'] = array('motr_id' => "$motrId", 'esta_id' => "$estaId");
        return wso2($url, 'PUT', $data);
    }

    public function actualizaDatosMovimientoTransporte($data){
        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT| Camiones | actualizaDatosMovimientoTransporte($data)');
        $dataPut['_put_camiones_proveedor'] = array(
            'boleta' => $data['boleta'],
            'tara' => $data['tara'],
            'neto' => $data['neto'],
            'motr_id' => $data['motr_id'],
            'prov_id' => $data['proveedor']
        );

        $url = REST_LOG."/camiones/proveedor";
        return wso2($url, 'PUT', $dataPut);
    }
    /**
	* Busca datos del movimiento de transporte (camion) por motr_id en prd.movimiento_transporte
	* @param string motr_id
	* @return array datos de camion en prd.movimientos_transportes
	*/
    public function getMovimientoTransporte($motr_id){
        
        $url = REST_LOG."/transporte/movimiento/motr_id/".$motr_id."/".empresa();

        $aux = $this->rest->callAPI("GET",$url);
        $resp = json_decode($aux['data']);

        log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT| Camiones | getMovimientoTransporte()  resp: >> " . json_encode($resp));

        return $resp->movimiento;
    }
}
