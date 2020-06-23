<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Establecimientos extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }
  public function listar()
  {
    log_message('DEBUG', 'Establecimientos/listar (id etapa)-> ' . $etapa);
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
  public function obtenerDepositos($idestablecimiento)
  {
    $resource = 'establecimiento/' . $idestablecimiento . '/deposito/list';
    $url = REST0 . $resource;
    $array = file_get_contents($url, false, http('GET'));
    return json_decode($array);
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

  public function editar($data)
  {
    $url = RESTPT . "establecimientos";
    $rsp = $this->rest->callApi("PUT", $url, $data);
    if ($rsp['status']) $rsp['data'] = json_decode($rsp['data']);
    return $rsp;
  }

  public function guardarTodo($depositos = null, $recipientes = null)
  {
    if (isset($depositos)) {
      $url = RESTPT . "updateDepositos";
      $rsp = $this->rest->callApi("PUT", $url, $depositos);
      if ($rsp['status']) $rsp['data'] = json_decode($rsp['data']);
    }

    if (isset($recipientes)) {
      $url = RESTPT . "updateRecipientes";
      $rsp = $this->rest->callApi("PUT", $url, $recipientes);
      if ($rsp['status']) $rsp['data'] = json_decode($rsp['data']);
    }

    return $rsp;
  }
}
