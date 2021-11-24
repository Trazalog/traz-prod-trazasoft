<?php if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Koolreport extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function depurarJson($url)
  {
    $rsp = $this->rest->callApi('GET', $url);
    if ($rsp['status']) {
      $json = json_decode($rsp['data']);
    }
    log_message('DEBUG', '#TRAZA| TRAZ-PROD-TRAZASOFT | #KOOLREPORT.PHP | #KOOLREPORT | #depurarJson() | #JSON: >>' . json_encode($json));
    return $json;
  }
}
