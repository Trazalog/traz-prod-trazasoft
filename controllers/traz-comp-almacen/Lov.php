<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lov extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->model(ALM.'Lovs'); 
   }
   function lista($grupo){
      echo var_dump($this->Lovs->lista($grupo));
   }
   function modificar(){
      
   }
   function eliminar(){
  
   }
}
?>