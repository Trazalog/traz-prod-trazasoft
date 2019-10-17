<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('getJson'))
{ 
    function getJson($file, $show = false)
    {
        $url = base_url('json/') .  $file . '.json';

        $rsp = json_decode(file_get_contents($url));

        if($show)
        {
            echo var_dump($rsp);
        }else
        {
            return $rsp;
        }
    }
}
?>