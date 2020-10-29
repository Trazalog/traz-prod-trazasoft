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
        $url = REST . $resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    public function listarPorEstablecimientoConSalida($establecimiento, $salida = false)
    {
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
        $url = REST . $resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    public function listar()
    {
        $parametros["http"]["method"] = "GET";
        $param = stream_context_create($parametros);
        $resource = 'lotestodo';
        $url = REST . $resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }

    public function obtenerLotesCamion($patente)
    {
        $resource = "camion/lotes/$patente";
        $url = REST_LOG . $resource;
        return wso2($url);
    }

    public function obtenerLote($lote)
    {
        $url = RESTPT . "lotes/codigo/$lote";
        $rsp = $this->rest->callApi('GET', $url);
        if($rsp['status']) $rsp['data'] = json_decode($rsp['data'])->lotes->lote;
        return $rsp;
    }

  public function getBatchIdLote($lote_id)
  {
    $lote_id = str_replace(' ','%20', $lote_id);
    $path = "lote/". $lote_id."/ultimo";
    $url = PRD_Lote_DS . $path;
    $rsp = $this->rest->callApi('GET', $url);
    if ($rsp['status']) $rsp['data'] = json_decode($rsp['data'])->lotes->lote;
    return $rsp;
  }
  
    public function trazabilidadBatch($batch_id)
  {
    $path = "lote/" . $batch_id . "/trazabilidad";
    $url = PRD_Lote_DS . $path;
    $rsp = $this->rest->callApi('GET', $url);
    if ($rsp['status']) {
      $rsp['data'] = json_decode($rsp['data'])->lotes->lote;
    }
    return $rsp;
  }

}
