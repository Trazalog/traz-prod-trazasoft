<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Model ABM No Consumibles
class Noconsumibles extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Guardar No Consumibles nuevos
    public function guardarNoConsumible($data)
    {
        return requestBox(REST_PRD_NOCON . '/', $data);
    }

 		// Listar No Consumibles
    public function tipoNoConsumible()
    {
        $resource = '/tablas/tipos_no_consumibles';
        $url = REST_CORE . $resource;
        return wso2($url);
    }

		/**
		* Devuelve listado de Establecimientos por Empresa
		* @param
		* @return array respuesta de servicio
		*/
    public function tipoEstablecimiento()
    {
        $resource = '/establecimientos/empresa/' . empresa();
        $url = REST_ALM . $resource;
        return wso2($url);
    }

		/**
		* Devuelve listado de Destinos externos
		* @param
		* @return array con listado de destinos externos
		*/
    public function seleccionarDestino()
    {
        $resource = '/tablas/destinos_no_consumibles';
        $url = REST_CORE . $resource;
        return wso2($url);
    }

		// Listar Tipos de No Consumibles
    public function ListarNoConsumible()
    {
        $resource = REST_PRD_NOCON . "/noConsumibles/porEstado/TODOS/porEmpresa/" . empresa();
        $url = $resource;
        return wso2($url);
    }

    public function editarNoConsumible($data)
    {
        $url = REST_PRD_NOCON . '/noConsumibles';
        $rsp = $this->rest->callApi('PUT', $url, $data);
        return $rsp;
    }
		/**
		* Guarda destino externo nuevo
		* @param array con datos del nuevo destino externo
		* @return array respuesta de servicio
		*/
    public function guardarDestino($data)
    {
        $url = REST_CORE . '/tablas';
        $rsp = $this->rest->callApi('POST', $url, $data);
        return $rsp;
    }

    public function eliminarNoConsumible($codigo)
    {

        $url = REST_PRD_NOCON . "/noConsumible";
        return wso2($url, 'DELETE', $codigo);
    }

		// Listar trazabilidad No Consumibles
    public function ListarTrazabilidadNoConsumible($codigo)
    {
				$empr_id = empresa();
        $resource = '/noConsumible/trazabilidad/porCodigo/'.$codigo.'/porEmpresa/'.$empr_id;
        $url = REST_PRD_NOCON . $resource;
        return wso2($url);
    }

    public function buscarNoConsumible($codigo)
    {
				$empr_id = empresa();
        $resource = '/noConsumible/porCodigo/'.$codigo.'/porEmpresa/'.$empr_id;
        $url = REST_PRD_NOCON . $resource;
        return wso2($url);
    }

    public function obtenerXEstado($emprId, $estado)
    {
        return wso2(REST_PRD_NOCON."/noConsumibles/porEstado/$estado/porEmpresa/$emprId");
    }

    /**
    * Consulta info de un NO consumible
    * @param string codigo de no consumible
    * @return array con info de no consumible
    */
    function consultarInfo($codigo){
        log_message('DEBUG','#TRAZA|TRAZ-PROD-TRAZASOFT|NOCONSUMIBLES  $codigo >> '.json_encode($codigo));
				$empr_id = empresa();
				$codigo = urlencode($codigo);
				$url = REST_PRD_NOCON.'/noConsumible/porCodigo/'.$codigo.'/porEmpresa/'.$empr_id;

				$aux = $this->rest->callAPI("GET",$url);
        $aux =json_decode($aux["data"]);
        return $aux->noConsumible;
    }

		// actualizar estado en nco.no_consumibles
		// insertar movimiento en nco.movimientos_no_consumibles
		// poner la fecha de liberación en nco.no_consumibles_lotes usando /noConsumible/lote/liberar
    /**
		* Libera No consumibles
		* @param array con datos de los no consumibles a liberar
		* @return array respuesta seguns servicio
		*/
		function liberarNoConsumible($noCons)
    {
        $hoy = 	date('Y-m-d H:i');
        $user = userNick();

        foreach ($noCons as $key => $value) {

            $noCons[$key]['fec_liberacion'] = $hoy;
            $noCons[$key]['usuario_app'] = $user;
						$noCons[$key]['empr_id'] = empresa();
            $resp = $this->updateTabla($noCons[$key]);
            if (!$resp) {
                log_message('ERROR','#TRAZA|TRAZ-PROD-TRAZASOFT|GENERAL|NOCONSUMIBLES|liberarNoConsumible($noCons) >> ERROR en update de tabla');
                return $resp;
            }
        }

        return $resp;
    }

    /**
    * Invoca servicio de actualizacion tabla
    * @param array con datos a actualizar
    * @return boolean true - false respuesta del servicio
    */
    function updateTabla($noCons){

        $put["_put_noconsumible_lote_liberar"] = $noCons;
        $url = $url = REST_PRD_NOCON.'/noConsumible/lote/liberar';
        $aux = $this->rest->callAPI("PUT",$url, $put);
        $aux =json_decode($aux["status"]);
        return $aux;
    }

		/**
		* Actualiza estado
		* @param array con datos a actualizar
		* @return boolean respuesta de servicio
		*/
		function cambioEstado($data)
		{
			$post['_put_noconsumible_estado'] = $data;
			log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | Noconsumibles | cambioEstado($data) >> $data: '.json_encode($data));
			$aux = $this->rest->callAPI("PUT", REST_PRD_NOCON."/noConsumible/estado", $post);
			$aux =json_decode($aux["status"]);
			return $aux;
		}

		/**
		* Guardar Movimiento No consmible Generico
		* (guarda movimiento de ASOCIACIÓN/ENTRADA/SALIDA)
		* guarda trazabilidad de no cons y cambia estado
		* segun lo enviado en array y variable estado
		* @param
		* @return
		*/
		function movimientoNoConsumibles($noco_list, $estado, $depo_id, $destino)
		{
      foreach ($noco_list as $nc) {

					$data['_put_noconsumible_estado'] = array(
								'estado' => $estado,
								'usuario_app' => userNick(),
								'codigo' => $nc,
								'empr_id' => empresa()
					);
					$data['_post_noconsumibles_movimientos'] = array(
								'estado' => $estado,
								'noco_id' => $nc,
								'usuario_app' => userNick(),
								'dest_id' => $destino,
								'depo_id' => $depo_id,
								'empr_id' => empresa()
					);
					$datos['request_box'][] = $data;

					log_message('DEBUG','#TRAZA|TRAZASOFT|GENERAL|NOCONSUMIBLES|movimientoNoConsumibles($noco_list, $depo_id, $estado) $datos:  >> '.$datos);

					$aux = $this->rest->callAPI("POST", REST_PRD_NOCON ."/request_box", $datos);
					$aux =json_decode($aux["data"]);
					$monc_id = $aux->DATA_SERVICE_REQUEST_BOX_RESPONSE->respuesta->monc_id;

					if ($monc_id == null) {
						log_message('ERROR','#TRAZA|TRAZASOFT|GENERAL|NOCONSUMIBLES|movimientoNoConsumibles($noco_list, $depo_id, $estado) >> ERROR NO SE PUDO ASOCIAR NO CONSUMIBLES');
						break 1;
					}
					// limpio array para reutilizar
					unset($datos);
					$datos = array();
      }

			return $monc_id;
		}
  
  /**
	* Consulta al service si el codigo insertado, ya esta creado para la empresa
	* @param string código NoCo
	* @return array respuesta del servicio
	*/
  public function validarNoConsumible($noco){
    $url = REST_PRD_NOCON."/noConsumible/validar/". urlencode($noco) . "/empresa/".empresa();

    $aux = $this->rest->callAPI("GET",$url);
    $resp = json_decode($aux['data']);
    log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Noconsumibles | validarNoConsumible() >> resp ".json_encode($resp));

    return $resp->resultado;
  }
  /**
	* Consulta al service si los parametros enviados no estas ya insertados
	* @param string codigo_incial; codigo_final
	* @return array respuesta del servicio
	*/
  public function validarCodigoMasivoNoConsumibles($prefijo,$noco_inicio,$noco_final){
    $url = REST_PRD_NOCON."/noConsumible/validar/prefijo/". urlencode($prefijo) ."/desde/". urlencode($noco_inicio) . "/hasta/". urlencode($noco_final) ."/empresa/".empresa();

    $aux = $this->rest->callAPI("GET",$url);
    $resp = json_decode($aux['data']);
    log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Noconsumibles | validarCodigoMasivoNoConsumibles() >> resp ".json_encode($resp));

    return $resp->resultado;
  }
  /**
	* Consulta al service si el prefijo recibido esta creado, si es afirmativa obtiene el último codigo ingresado
	* @param string $prefijo cadena del codigo
	* @return array respuesta del servicio
	*/
  public function obtenerIndicePrefijo($prefijo){
    log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | Noconsumibles | obtenerIndicePrefijo()');
    $url = REST_PRD_NOCON."/noConsumibles/ultimoCodigo/". urlencode($prefijo) ."/empresa/".empresa();

    $aux = $this->rest->callAPI("GET",$url);
    $resp = json_decode($aux['data']);
    return $resp;
  }
  /**
	* Obtiene el estilo definido en core.tablas para los no consumibles 
	* @param integer empr_id
	* @return array respuesta con estilos configurados
	*/
  public function getEstilosQRNoCos(){
        
    $url = REST_CORE."/tabla/estilos_qr/empresa/".empresa();

    $aux = $this->rest->callAPI("GET",$url);
    $resp = json_decode($aux['data']);

    log_message('DEBUG', "#TRAZA | #SICPOA | Inspecciones | getTiposFacturas()  resp: >> " . json_encode($resp));

    return $resp->tablas->tabla;
}
}
