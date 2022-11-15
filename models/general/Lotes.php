<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lotes extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }
    public function listarPorMateria($id)
    {

        $parametros["http"]["method"] = "GET";
        $param = stream_context_create($parametros);
        if ($id == 1) {
            $resource = 'lotes1';
        } else if ($id == 2) {
            $resource = 'lotes2';
        }
        $url = REST_PRD . $resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    public function listarPorEstablecimientoConSalida($establecimiento, $salida = false){
      log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | Lotes | listarPorEstablecimientoConSalida($establecimiento, $salida)');
      $resource = "/lotes_establecimiento/$establecimiento";
      $url = REST_PRD_LOTE . $resource;
      return wso2($url);
    }
    public function listarPorCamion($camion)
    {
        $parametros["http"]["method"] = "GET";
        $param = stream_context_create($parametros);
        if ($camion == 1 || $camion == 3) {
            $resource = 'loteentrada1';
        }
        if ($camion == 2 || $camion == 4) {
            $resource = 'loteentrada2';
        }
        $url = REST_PRD . $resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    public function listar()
    {
        $parametros["http"]["method"] = "GET";
        $param = stream_context_create($parametros);
        $resource = 'lotestodo';
        $url = REST_PRD . $resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }

    public function obtenerLotesCamion($patente)
    {
        $resource = "/camion/lotes/$patente";
        $url = REST_LOG . $resource;
        return wso2($url);
    }

    public function obtenerLote($lote)
    {
        $url = REST_PRD_LOTE . "/lotes/codigo/$lote";
        $rsp = $this->rest->callApi('GET', $url);
        if($rsp['status']) $rsp['data'] = json_decode($rsp['data'])->lotes->lote;
        return $rsp;
    }

  public function getBatchIdLote($lote_id)
  {
    $lote_id = str_replace(' ','%20', $lote_id);
    $path = "/lote/". $lote_id."/ultimo";
    $url = REST_PRD_LOTE . $path;
    $rsp = $this->rest->callApi('GET', $url);
    if ($rsp['status']) $rsp['data'] = json_decode($rsp['data'])->lotes->lote;
    return $rsp;
  }
  
    public function trazabilidadBatch($batch_id)
  {
    $path = "/lote/" . $batch_id . "/trazabilidad";
    $url = REST_PRD_LOTE . $path;
    $rsp = $this->rest->callApi('GET', $url);
    if ($rsp['status']) {
      $rsp['data'] = json_decode($rsp['data'])->lotes->lote;
    }
    return $rsp;
  }
    /**
	* Obtiene la cantidad de reportes de produccion realizados para el batch_id
	* @param integer batch_id del lote
	* @return array respuesta del servicio con la cantidad de reportes
	*/
  function validarCantidadReportes($batch_id){
    log_message("DEBUG", "#TRAZA | #TRAZ-PROD-TRAZASOFT | Lotes | validarCantidadReportes()");
    $url = REST_PRD_LOTE. "/lote/".$batch_id."/cantidadReportes";
    $rsp = $this->rest->callAPI("GET",$url);
    return $rsp;
  }
  /**
	* Verifica si se realizó alguna entrega de materiales para el batch_id recibido. 
  * Si es true la respuesta, significa que si se realizo una Entrega de Materiales
	* @param integer batch_id
	* @return array respuesta del servicio
	*/
  public function verificaEntregaMateriales($batch_id){
    log_message('DEBUG', "#TRAZA | #TRAZ-PROD-TRAZASOFT | Etapas | verificaEntregaMateriales() >> resp ".json_encode($resp));
    $url = REST_PRD_LOTE."/validar/entregaMateriales/batch_id/".$batch_id;
    $aux = $this->rest->callAPI("GET",$url);
    $resp = json_decode($aux['data']);
    return $resp->resultado->existe;
  }
}
