<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dash extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->helper('menu_helper');
        $this->load->helper('file');
        $this->load->helper('login_helper');
    }
    public function index()
    {
        //  if (!$this->session->userdata('email')) {
        //      login();
        //  } else {  
            $leng = "spanish";
            $page = "layout";
            $data['lang'] = lang_get($leng, $page);
            $data['menu'] = [];#menu($data['lang'], $this->session->userdata['id']);
            $this->load->view('layout/Admin', $data);
      #  }
    }
}
