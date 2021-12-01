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
        if($this->validarCamion($data['patente'])){  
            return array('status'=>false, 'msj'=>'El camión ya se encuentra en el establecimiento');
        }

        $data['empr_id'] = strval(empresa());

        if(!isset($data['proveedor']) || $data['proveedor'] == ""){
            $data['proveedor'] = strval(PROVEEDOR_INTERNO);
        }

        log_message('DEBUG', '#TRAZA | #TRAZ-PROD-TRAZASOFT | Entradas | guardar() | #DATA-POST: ' . json_encode($data));

        $url = REST_LOG . '/entradas';
        $rsp = $this->rest->callApi('POST', $url, ['post_entradas' => $data]);
        return $rsp;
    }

    public function validarCamion($patente, $estado = 'EN CURSO')
    {
        log_message('DEBUG',"#TRAZA | #TRAZ-PROD-TRAZASOFT | MÉTODO: ".__METHOD__."| PANTENTE: $patente | ESTADO: $estado");

        $res = wso2(REST_LOG. "/camiones/$patente")['data'];
        if($res){
            foreach($res as $o) {
                
                if($o->estado == $estado) return true;

            }
        }
        return false;
    }
}
