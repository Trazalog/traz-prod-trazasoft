<?php defined('BASEPATH') or exit('No direct script access allowed');

class Almacen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(ALM . 'Articulos');
    }
    public function index()
    {

        echo 'Componente Almacen<br>';
        echo 'Cantidad Articulos: '.sizeOf($this->Articulos->getList());    
    }

    public function install()
    {
        #$this->Ala
    }
}
