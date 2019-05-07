<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct(){

      parent::__construct();
   }
   function index(){
      redirect('http://localhost/Dnato/main/setdir?direccion=traz-comp-almacenes/Login/login&direccionsalida=traz-comp-almacenes/Login/');
   }
   function login()
   {
      
       redirect('http://localhost/traz-comp-almacenes/Dash');
       
     
       
   }
   function logout()
   {
       var_dump($this->session->userdata);die;
   // redirect('http://localhost/Dnato/main/logout');
   }
   function edit()
   {
       redirect('http://localhost/Dnato/main/changeuser');
   }
}
?>