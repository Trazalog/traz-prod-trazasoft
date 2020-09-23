<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarea extends CI_Controller {

	function __construct() 
    {
		parent::__construct();
        $this->load->model(TAREAS_ASIGNAR.'/Recursos_Materiales');
        $this->load->model(TAREAS_ASIGNAR.'/Tareas');
    }
   function listarRecursosMateriales()
   {
       $idtarea = $this->input->post('idtarea');
       $idetapa = $this->input->post('idetapa');
      if($idtarea == 2){
       echo json_encode($this->Recursos_Materiales->listarPorTarea($idtarea,$idetapa)->recursos->recurso);
      }
      else{
          echo "";
      }
       
   }
   function listarRecursosTrabajo()
   {
       $idtarea = $this->input->post('idtarea');
       $idetapa = $this->input->post('idetapa');
      /*if($idtarea == 2){
       echo json_encode($this->Recursos_Materiales->listarPorTarea($idtarea,$idetapa)->recursos->recurso);
      }
      else{*/
          echo "";
      //}
       
   }
   function insertaTarea()
   {
    $idtarea = $this->input->post('idtarea');
    $idetapa = $this->input->post('idetapa');
    echo $this->Tareas->insertaTarea($idetapa,$idtarea)->id;
   }
}