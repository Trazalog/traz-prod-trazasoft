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
    $url = REST2 . $resource;
    $array = $this->rest->callAPI("GET", $url);
    $resp =  json_decode($array['data']);
    return $resp;
  }
  public function listarTodo($esta_id = null)
  {
    $resource = 'establecimiento' . ($esta_id ? "/$esta_id" : null);
    $url = REST . $resource;
    // $url = 'http://localhost:3000/establecimientos';
    // $array = file_get_contents($url, false, http('GET'));
    $array = $this->rest->callApi('GET', $url);
    return json_decode($array['data']);
  }
  public function obtenerDepositos($esta_id)
  {
    $resource = 'depositos_establecimiento/' . $esta_id;
    $url = RESTPT . $resource;
    $rsp = $this->rest->callApi('GET', $url);
    return json_decode($rsp['data']);
  }

  public function getEstablecimiento($esta_id = null)
  {
    $resource = 'establecimiento/' . $esta_id;
    $url = RESTPT . $resource;
    $rsp = $this->rest->callApi('GET', $url);
    if ($rsp['status']) {
      $rsp['data'] = json_decode($rsp['data'])->establecimientos->establecimiento;
    }
    return $rsp;
  }

  public function getRecipientes($depo_id,$esta_id)
  {
    // $esta_id = 1;
      $url = REST_ALM."recipientes/establecimiento/$esta_id/deposito/$depo_id/estado/TODOS/tipo/TODOS/categoria/TODOS";
      $aux['data'] = wso2($url);
      $url = REST_ALM."/depositos/$depo_id";
      $a = $this->rest->callApi('GET',$url);
      $b = json_decode($a['data']);
      $aux['col'] = $b->deposito->col;
      $aux['row'] = $b->deposito->row;
      return $aux;
  }

  public function guardar($data)
  {
    $data['empr_id'] = (string) empresa();
    $data['usuario'] = userNick();
    #log_message('DEBUG','#Establecimientos/guardar | DATA: '.json_encode($data));
    $post['post_establecimiento'] = $data;
    $url = RESTPT . "establecimientos";
    $rsp = $this->rest->callApi('POST', $url, $post);
    return $rsp;
  }

  public function eliminar($id)
  {
    $data['delete_est']['esta_id'] = $id;
    $url = RESTPT . "establecimientos";
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
    $url = RESTPT . "establecimientos";
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
