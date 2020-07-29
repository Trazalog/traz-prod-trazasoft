<?php defined('BASEPATH') or exit('No direct script access allowed');

function requestBox($rest, $data)
{
    $json = '';

    foreach ($data as $key => $o) {
        if ($key) {
            $json .= ',';
        }
        $aux = json_encode($o);
        $json .= substr($aux, 1, strlen($aux)-2);
    }

    $json = '{"request_box":{'.$json.'}}';

    $ci = &get_instance();

    $rsp = $ci->rest->callApi('POST', $rest . 'request_box', $json);

    return $rsp;
}
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
            if($aux)
            {
                $aux = reset($aux);
                if($aux)
                {
                    $aux = reset($aux);
                }
            }
            $rsp['data'] = $aux;
        }

        return $rsp;
    }

}