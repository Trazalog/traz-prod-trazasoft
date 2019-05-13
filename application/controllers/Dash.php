<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('menu_helper');
      $this->load->helper('file');
   }
   function index(){
     
      $data['menu'] = menu($this->session->userdata['id']);
      $leng="spanish";
      $page="layout";
      $data['lang'] = lang_get($leng,$page);
      $this->load->view('layout/Admin',$data);
   }
}
?>