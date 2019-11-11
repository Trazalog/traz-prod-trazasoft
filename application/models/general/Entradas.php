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
        $data['proveedor'] = strval(PROVEEDOR_INTERNO);
        log_message('DEBUG', '#ENTRADAS > guardar | #DATA-POST: ' . json_encode($data));

        $url = RESTPT . 'entradas';
        $rsp = $this->rest->callApi('POST', $url, ['post_entradas' => $data]);
        return $rsp;
    }

}
