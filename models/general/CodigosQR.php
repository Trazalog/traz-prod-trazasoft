<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class CodigosQR extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDatos($codigo = null)
    {
        #HARDCODE
        // $url = RESTPT . "datosQRs/" . $codigo;
        $url = 'http://localhost:3000/datosQRs';
        $rsp = $this->rest->callApi('GET', $url);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data'])->datosQRs->datosQR;
        }
        // var_dump($rsp['data']);
        return $rsp;
    }
}
