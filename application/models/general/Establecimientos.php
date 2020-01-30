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
    $resource = 'establecimiento' . ($esta_id?"/$esta_id":null);
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
}
