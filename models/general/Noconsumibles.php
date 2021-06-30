<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Model ABM No Consumibles
class Noconsumibles extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Guardar No Consumibles
    public function guardarNoConsumible($data)
    {
        return requestBox(REST_PRD_NOCON . '/', $data);
    }

	// // Listar No Consumibles
			public function tipoNoConsumible()
			{
					$resource = '/tablas/tipos_no_consumibles';
					$url = REST_CORE . $resource;
					return wso2($url);
			}

	// Listar Establecimiento
			public function tipoEstablecimiento()
			{
					#HARCODE
					$resource = '/establecimientos/empresa/' . empresa();
					$url = REST_ALM . $resource;
					return wso2($url);

			}

			public function seleccionarDestino()
			{
					$resource = '/tablas/destinos_no_consumibles';
					$url = REST_CORE . $resource;
					return wso2($url);
			}

	// Listar Tipos de No Consumibles
			public function ListarNoConsumible()
			{
					#HARCODE .empresa()
					$resource = REST_PRD_NOCON . "/noConsumibles/porEstado/TODOS/porEmpresa/" . empresa();
					$url = $resource; //REST_PRD_NOCON .
					return wso2($url);

			}

			public function editarNoConsumible($data)
			{
					$url = REST_PRD_NOCON . '/noConsumibles';
					$rsp = $this->rest->callApi('PUT', $url, $data);
					return $rsp;
			}

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

					$resource = "/noConsumible/trazabilidad/porCodigo/$codigo";
					$url = REST_PRD_NOCON . $resource;
					return wso2($url);
			}

			public function buscarNoConsumible($codigo)
			{
					$resource = "/noConsumible/porCodigo/$codigo";
					$url = REST_PRD_NOCON . $resource;
					return wso2($url);
			}

	// Guardar Movimiento Entrada No Consumibles
			public function guardarMovimientoEntrada($data)
			{
					return requestBox(REST_PRD_NOCON . '/', $data);
			}

	// // Guardar Movimiento Salida No Consumibles
			public function guardarMovimientoSalida($data)
			{
					return requestBox(REST_PRD_NOCON . '/', $data);
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
			$url = REST_PRD_NOCON.'/noConsumible/porCodigo/'.$codigo;
			$aux = $this->rest->callAPI("GET",$url);
			$aux =json_decode($aux["data"]);
			return $aux->noConsumible;
	}

	/**
	* Libera No consumibles
	* @param array con datos de los no consumibles a liberar
	* @return array respuesta seguns servicio
	*/
	function liberarNoConsumible($noCons)
	{
			$hoy = 	date('Y-m-d H:i:s');
			$user = userNick();

			foreach ($noCons as $key => $value) {

					$noCons[$key]['fec_liberacion'] = $hoy;
					$noCons[$key]['usuario_app'] = $user;
					$resp = $this->updateTabla($noCons[$key]);
					if (!$resp) {
							log_message('ERROR','#TRAZA|TRAZ-PROD-TRRAZASOFT|NOCONSUMIBLES|liberarNoConsumible($noCons) >> ERROR en update de tabla');
							return $resp;
					}
			}

			return $resp;
	}

	/**
	* Invoca servicio de actualizacion tabla
	* @param array con datos a actualizar
	* @return boolean true  alse respuesta del servicio
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
		log_message('DEBUG','#TRAZA|NOSCONSUMIBLES|cambioEstado($data) >> $data: '.json_encode($data));
		$aux = $this->rest->callAPI("PUT", REST_PRD_NOCON."/noConsumible/estado", $post);
		$aux =json_decode($aux["status"]);
		return $aux;
	}

	/**
	* Asocia Noconsumible con lote
	* @param array con info de no consumibles
	* @return json respùesta del servicio
	*/
	function asociarConLote($data)
	{
		$post['_post_noconsumible_lote_asociar_batch_req'] = $data;
		log_message('DEBUG','#TRAZA|TRAZASOFT|NOCONSUMIBLES|asociarConLote($data) >> $post: '.json_encode($post));
		$aux = $this->rest->callAPI("POST",REST_PRD_NOCON."/_post_noconsumible_lote_asociar_batch_req", $post);
		$aux =json_decode($aux["status"]);
		return $aux;


	}

	/**
	* Cambia estado por batch
	* @param array con info de noconsumibles
	* @return bool respuesta de servicio
	*/
	function cambioEstadoXBatchReq($data)
	{
		log_message('DEBUG','#TRAZA|TRAZASOFT|NOCONSUMIBLES|cambioEstadoXBatchReq($data) >> $data: '.json_encode($data));
		$aux = $this->rest->callAPI("PUT",REST_PRD_NOCON."/_put_noconsumible_estado_batch_req", $data);
		$aux = json_decode($aux["status"]);
		return $aux;

	}




}
