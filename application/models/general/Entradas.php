<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Entradas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Recipientes');
    }

    public function guardar($data)
    {
       log_message('DEBUG','#ENTRADAS > guardar | #DATA-POST: '.json_encode($data));

        $url = RESTPT.'entradas';
        $rsp =  file_get_contents($url, false, http('POST', ['post_entradas'=>$data]));
        return rsp($http_response_header, false, $rsp);
    }
    
}