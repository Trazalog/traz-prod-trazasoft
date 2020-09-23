<?php defined('BASEPATH') or exit('No direct script access allowed');

class Informe extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(ALM.'Informes');
    }
    public function loteStock()
    {
        $data = $this->Informes->loteStock();

        echo var_dump($data);
    }
}
