<?php defined('BASEPATH') or exit('No direct script access allowed');

class Parametro extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

    }
    public function obtener()
    {
        $tabla = $this->input->get('tabla');
        $url = REST_ALM . '/parametros/'.$tabla;
        $data = $this->rest->callApi('GET', $url);
        if($data['status']) $data['data'] = json_decode($data['data'])->parametros->parametro;
        echo json_encode($data);
    }
}
