<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('menu_helper');
      $this->load->helper('file');
   }
   function index(){
      $leng="spanish";
      $page="layout";
      $data['lang'] = lang_get($leng,$page);
      $data['menu'] = menu($data['lang'],$this->session->userdata['id']);
 
      $this->load->view('layout/Admin',$data);
   }
}
?>