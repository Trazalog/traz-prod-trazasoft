<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Procesos extends CI_Model
{
    function listarProcesos()
    {
        log_message('DEBUG', 'Procesos/getProcesos');
        $resource = '/procesos/list/empresa/'.empresa();
        $url = REST_PRD_ETAPAS . $resource;
        $array = $this->rest->callApi('GET', $url);
        return json_decode($array['data']);
    }

}