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
        log_message('DEBUG', '#TRAZA| #KOOLREPORT.PHP|#KOOLREPORT|#DEPURARJSON| #JSON: >>' . $json);
        return $json;
    }

    public function getDatosTarjeta($valores)
    {        
        // var_dump($valores);
        $res =  new StdClass();
        // $res->etapa = $valores['etapa'];
        $res->etapa = $valores[0]->etapa;
        // var_dump($valores[0]->etapa);
        // $res->responsable = $valores['responsable'];
        $res->responsable = $valores[0]->responsable;
        // $res->producto = $valores['producto'];
        $res->producto = $valores[0]->producto;
        // var_dump($res);

        log_message('DEBUG', '#TRAZA| #OPCIONES_FILTROS.PHP|#OPCIONES_FILTROS|#FILTROSPRODRESPONSABLE| #ETAPA: >>' . $res->etapa . '#RESPONSABLE: >>' . $res->responsable . '#PRODUCTO: >>' . $res->producto);
        return $res;
    }
}
