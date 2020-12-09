<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Establecimientos extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }
  public function listar()
  {
    // log_message('DEBUG', 'Establecimientos/listar (id etapa)-> ' . $etapa);
    $resource = '/establecimiento';
    $url = REST_ALM . $resource;
    $array = $this->rest->callAPI("GET", $url);
    $resp =  json_decode($array['data']);
    return $resp;
  }
  public function listarTodo($esta_id = null)
  {
    $resource = '/establecimiento' . ($esta_id ? "/$esta_id" : null);
    $url = REST_ALM . $resource;
    $array = $this->rest->callApi('GET', $url);
    return json_decode($array['data']);
  }
  public function obtenerDepositos($esta_id)
  {
    $resource = "/depositos_establecimiento/$esta_id";
    $url = REST_ALM . $resource;
    $rsp = $this->rest->callApi('GET', $url);
    return json_decode($rsp['data']);
  }

  public function getEstablecimiento($esta_id = null)
  {
    $resource = "/establecimiento/$esta_id" ;
    $url = REST_ALM . $resource;
    return wso2($url);
  }

  public function guardar($data)
  {
    $data['empr_id'] = (string) empresa();
    $data['usuario'] = userNick();
    $post['post_establecimiento'] = $data;
    $url = REST_ALM . "/establecimientos";
    $rsp = $this->rest->callApi('POST', $url, $post);
    return $rsp;
  }

  public function eliminar($id)
  {
    $data['delete_est']['esta_id'] = $id;
    $url = REST_ALM . "/establecimientos";
    $rsp = $this->rest->callApi("DELETE", $url, $data);
    if ($rsp['status']) $rsp['data'] = json_decode($rsp['data']);
    return $rsp;
  }

  #FLEIVA
  public function obtener($id = false)
  {
    $recurso =  REST_ALM.'/establecimientos/'.($id?$id:empresa());
    return wso2($recurso);
  }

  public function editar($data)
  {
    $url = REST_ALM . "/establecimientos";
    $rsp = $this->rest->callApi("PUT", $url, $data);
    if ($rsp['status']) $rsp['data'] = json_decode($rsp['data']);
    return $rsp;
  }

  public function guardarTodo($datos)
  {
    $resource = '_post_recipientes_batch_req';
    $url = REST_ALM . $resource;
    $rsp = $this->rest->callApi("POST", $url, $datos);
    if ($rsp['status']) $rsp['data'] = json_decode($rsp['data']);
    return $rsp;
  }

  public function obtenerRecipientesDeposito($data = null)
  {
    $rsp = '{
      "tipos":{
        "tipo":[
          {"nombre":"DEPOSITO"},
          {"nombre":"PRODUCTIVO"},
          {"nombre":"TRANSPORTE"}
      ]
    }
    }';
    return json_decode($rsp);
  }
}
