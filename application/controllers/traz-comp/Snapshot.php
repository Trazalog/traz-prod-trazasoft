<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Snapshot extends CI_Controller {

    function __construct()
    {
      parent::__construct();
      $this->load->model('traz-comp/Snapshots'); 
   }

   function obtener()
   {
      $key =  $this->input->post('key');
      $res = $this->Snapshots->obtener($key);
      echo json_encode($res);
   }

   function guardar()
   {
      $data = $this->input->post('datos');
      $res = $this->Snapshots->guardar($data);
      echo json_encode($res);
   }

   public function eliminar()
   {
      $key = $this->input->post('key');
      $rsp = $this->Snapshots->eliminar($key);
      echo json_encode($rsp);
   }
}
?>