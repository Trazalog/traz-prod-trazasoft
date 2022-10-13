<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Procesos extends CI_Model
{
    /**
	* Obtiene el listado de procesos productivos para una empresa
	* @param integer empr_id
	* @return array respuesta del servicio con listado de procesos, si tuviera.
	*/
    function listarProcesos(){
        log_message('DEBUG', '#TRAZA | TRAZ-PROD-TRAZASOFT | Procesos | listarProcesos');
        $resource = '/procesos/list/empresa/'.empresa();
        $url = REST_PRD_ETAPAS . $resource;
        $array = $this->rest->callApi('GET', $url);
        return json_decode($array['data']);
    }

}