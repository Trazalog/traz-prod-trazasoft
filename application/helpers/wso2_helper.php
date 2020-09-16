<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('wso2')) {

    function wso2($url, $metodo = 'GET', $data = false)
    {
        $url = str_replace('//','&', $url);
        $url = str_replace('http:&','http://', $url);
        $url = str_replace('&','//', $url);

        $ci = &get_instance();

        if ($metodo == 'GET') {

            $rsp = $ci->rest->callApi($metodo, $url);

        } else {

            $rsp = $ci->rest->callApi($metodo, $url, $data);

        }

        if ($rsp['status']) 
        {
            $rsp['data'] = json_decode($rsp['data']);

            #SOLO SI ES UNA API WSO2
            if(isset($rsp['data']->session)){
                $ci->session->set_userdata('bpm_token', $rsp['data']->session);
                return $rsp;
            }

            if($rsp['data']) $rsp['data'] = reset($rsp['data']);
            if($rsp['data']) $rsp['data'] = reset($rsp['data']);
        }

        return $rsp;
    }

}

if (!function_exists('requestBox')) {
    function requestBox($rest, $data)
    {
        $json = '';

        foreach ($data as $key => $o) {
            if ($key) {
                $json .= ',';
            }
            $aux = json_encode($o);
            $json .= substr($aux, 1, strlen($aux) - 2);
        }

        $json = '{"request_box":{' . $json . '}}';

        $ci = &get_instance();

        $rsp = $ci->rest->callApi('POST', $rest . 'request_box', $json);

        return $rsp;
    }
}
