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
        if(!$this->validarCamion($data['patente'])){  
            return array('status'=>false, 'msj'=>'El Camion ya se encuentra en el establecimiento');
        }

        $data['proveedor'] = strval(PROVEEDOR_INTERNO);
        log_message('DEBUG', '#ENTRADAS > guardar | #DATA-POST: ' . json_encode($data));
        $url = REST_LOG . '/entradas';
        $rsp = $this->rest->callApi('POST', $url, ['post_entradas' => $data]);
        return $rsp;
    }

    public function validarCamion($patente)
    {
        $res = wso2(REST. "camiones/$patente");
        if($res){
            foreach($res as $o) {
                
                if($o->estado = 'EN CURSO') return true;

            }
        }

        return false;
    }
}
