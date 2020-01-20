<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
    }
    public function index()
    {
        if(LOGIN)
        {
            $dir = 'traz-prod-trazasoft';
            login($dir);
        }else{
            redirect(base_url().'Dash');
        }
    }
    public function log_out()
    {
        logout();
    }
    public function edit()
    {
        editar();
    }
}
