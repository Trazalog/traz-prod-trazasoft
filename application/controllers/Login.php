<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('login_helper');
   }
   function index(){
      $dir = 'traz-prod-trazasoft';
      login($dir);
       }
  function log_out()
  {
      logout();
  }
   function edit()
   {
       editar();
   }
}
?>