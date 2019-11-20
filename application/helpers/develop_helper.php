<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('getJson')) {
    function getJson($file, $show = false)
    {
        $url = base_url('json/') . $file . '.json';

        $rsp = json_decode(file_get_contents($url));

        if ($show) {
            echo var_dump($rsp);
        } else {
            return $rsp;
        }
    }

    function http($metodo, $data = false)
    {
        $header = array("Accept: application/json");

        if ($data) {
            array_push($header, 'Content-Type: application/json');
            $parametros["http"]["content"] = json_encode($data);
        }

        $parametros["http"]["method"] = $metodo;
        $parametros["http"]["header"] = $header;

        log_message('DEBUG', '#REST #OUT-HEADER: '.json_encode($parametros));

        return stream_context_create($parametros);
    }

    function rsp($header, $msj = false, $data = false){

        log_message('DEBUG', '#REST #RESPONCE-HEADER: '.json_encode($header) .' | #RESPONCE-DATA: '.json_encode($data));
        return array(
            'status' => rspCode($header) < 300,
            'code' => rspCode($header),
            'msj' => $msj,
            'data' => $data
        );
    }

    function rspCode($header)
    {
        $aux = explode(" ", $header[0]);
        return $aux[1];
    }

    function wso2Msj($rsp)
    {
        $rsp['data'] = json_decode( $rsp['data']);
        $msj = $rsp['data']->Fault->faultstring;
        preg_match('~>>([^{]*)<<~i', $msj, $match);
        log_message('DEBUG', '#WSO2 #RESPONCE: ' . $match[1]);
    }
}
