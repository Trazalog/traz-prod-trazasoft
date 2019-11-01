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
        #Crear Recipiente
        $aux = array(
            'tipo' => 'TRANSPORTE',
            'patente' => $data['patente'],
            'depo_id' => strval(DEPOSITO_TRANSPORTE),
            'empr_id' => strval(empresa()),
        );

        $reci_id = $this->Recipientes->crear($aux)['data']->resultado->reci_id;

        $data['reci_id'] = strval($reci_id);

        $url = REST1.'entradas';
        $rsp =  file_get_contents($url, false, http('POST', ['post_entradas'=>$data]));
        return rsp($http_response_header, false, $rsp);
    }
    
}