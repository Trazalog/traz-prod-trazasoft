<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tabla extends CI_Controller {

    function __construct(){

      parent::__construct();

      $this->load->model('general/Tablas'); 
   }

   function index(){
      $data['list'] = $this->Tablas->get();
      $data['list_valores']  = $this->Tablas->get_valores();
      $this->load->view('general/abm_tablas',$data);
   }

   function guardar(){
      $data = $this->input->post();
   }
   
   function editar(){
      $data = $this->input->post();
   }

   function eliminar(){
      $id = $this->input->post('id');
   }
}
?>