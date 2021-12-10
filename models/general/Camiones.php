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
    public function guardarCarga($data)
    {

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

        log_message('DEBUG', '#Camiones/actualizarEstado | RSP: ' . json_encode($rsp));

        return $rsp;
    }

    public function guardarDescarga($data)
    {
        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | CAMIONES | guardarDescarga() | #DATA: ' . json_encode($data));

        $array = [];
        foreach ($data as $key => $o) {
            $array[] = array(
                "id" => $o['destino']['lote_id'],
                "producto" => $o['origen']['arti_id'],
                "prov_id" => $o['origen']['prov_id'],
                "batch_id" => $o['origen']['batch_id'] ? $o['origen']['batch_id'] : 0,
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

    public function obtenerInfo($patente, $estado)
    {
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

    public function validarCamion($patente, $estado = 'EN CURSO')
    {
        log_message('DEBUG', "#TZL | " . __METHOD__ . "| PANTENTE: $pantente | ESTADO: $estado");

        $res = wso2(REST_LOG . "/camiones/$patente")['data'];
        if ($res) {
            foreach ($res as $o) {

                if ($o->estado == $estado) {
                    return true;
                }

            }
        }
        return false;
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
		* Esta función hara automáticamente la ENTRADA CAMIÓN y la CARGA CAMIÓN
		* @param array con datos de salida
		* @return array con respuesta de servicio
    */
    public function guardarLoteSistema($frmCamion, $frmDescarga)
    {
        #Entrada Camion
        $this->load->model('general/Entradas');

        #Obtener motr_id
        $rsp = $this->obtenerInfo($frmCamion['patente'], 'EN CURSO');
        if (!isset($rsp->motr_id)) {
            $rsp['msj'] = 'Error al Obtener MOTR_ID';
            return $rsp;
        }

        $motr_id = $rsp->motr_id;

        #Carga Camion
        $lotes = [];
        foreach ($frmDescarga as $o) {
            $aux = new StdClass();

            $aux->patente = $frmCamion['patente'];
            $aux->motr_id = $motr_id;
            $aux->batch_id = $o['origen']['batch_id'];
            $aux->cantidad = $o['origen']['cantidad'];
            $aux->batch_id = $o['origen']['arti_id'];
            $aux->prov_id = $o['origen']['prov_id'];
            $aux->reci_id = $o['origen']['reci_id'];
            $aux->orden_prod = $o['origen']['orden_prod'];
            $aux->etap_id = ETAPA_TRANSPORTE;
            $aux->forzar_agregar = $o['destino']['unificar'];
            $lotes[] = $aux;
        }

        $rsp = $this->guardarCarga($lotes);
        if (!$rsp['status']) {
            $rsp['msj'] = 'Error al Guardar Carga Camion';
            return $rsp;
        }

        #Cambio Estado Camion
        $aux1 = array(array(
            'motr_id' => $motr_id,
            'estado' => 'FINALIZADO',
        ));

        $rsp = $this->actualizarEstado($aux1);

        return $rsp;
    }

		/**
		* Guarda salida de camion a algun deposito interno o Salida al exterior
		* @param array con datos de salida
		* @return array con respuesta de servicio
		*/
    public function guardarSalida($data)
    {
        $post['_put_camiones_salida'] = array(
            'motr_id' => strval($data['motr_id']),
            //'patente' => $data['patente'],
            'estado' => isset($data['destino_esta_id']) ? 'TRANSITO' : 'FINALIZADO',
            'bruto' => strval($data['bruto']),
            'neto' => strval($data['neto']),
        );
        return wso2(REST_LOG . '/camiones/salida', 'PUT', $post);
    }

    public function estado($patente, $estado, $estadoFinal)
    {
        $rsp = $this->obtenerInfo($patente, $estado);
        if($rsp)
        {
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

    public function actualizarProveedor($patente, $estado, $proveedor)
    {
        $data['_put_camiones_proveedor'] = array(
            'patente' => $patente,
            'estado' => $estado,
            'prov_id' => "$proveedor"
        );

        $url = REST_LOG."/camiones/proveedor";
        return wso2($url, 'PUT', $data);
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
