<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('wso2')) {

    function wso2($url, $metodo = 'GET', $data = false)
    {
        $ci = &get_instance();

        if ($metodo == 'GET') {

            $rsp = $ci->rest->callApi($metodo, $url);

        } else {

            $rsp = $ci->rest->callApi($metodo, $url, $data);

        }

        if ($rsp['status']) {
            $aux = json_decode($rsp['data']);
            $rsp['data'] = reset(reset($aux));
        }

        return $rsp;
    }

}