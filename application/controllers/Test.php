<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['articulos'] = wso2(REST_ALM . 'articulos/1')['data'];
       
        $this->load->view('test', $data);
    }

}
