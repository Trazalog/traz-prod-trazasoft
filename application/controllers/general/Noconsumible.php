<?php defined('BASEPATH') or exit('No direct script access allowed');

class Noconsumible extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Noconsumibles');
        $this->load->model('general/Establecimientos');
        $this->load->model('general/Recipientes');
    }

    public function index()
    {
   $data['tipoNoConsumible'] = $this->Noconsumibles->tipoNoConsumible()['data'];
   $data['tipoEstablecimiento'] = $this->Noconsumibles->tipoEstablecimiento()['data'];
   $data['ListarNoConsumible'] = $this->Noconsumibles->ListarNoConsumible()['data'];
   $data['ListarTrazabilidadNoConsumible'] = $this->Noconsumibles->ListarTrazabilidadNoConsumible()['data'];
        $this->load->view('NoConsumible/ListarNoConsumible',$data);
    }

    #HARCORE
    public function guardarNoConsumible()
    {
      $data[]['_post_noconsumibles'] = array(

          'codigo' => $this->input->post('codigo'),
          'descripcion' => $this->input->post('descripcion'), 
          'fec_vencimiento' => $this->input->post('fec_vencimiento'),
          'usuario_app' => 'rodotest', 
          'tinc_id' => $this->input->post('tipo_no_consumible'),
          'empr_id' => '1'
                   );

        $data[]['_post_noconsumibles_movimientos'] = array(

          'estado' => 'ALTA',
          'usuario_app' => 'rodotest', 
          'noco_id' => $this->input->post('codigo'),
          'depo_id' => $this->input->post('depositos'),
          'dest_id' => ''
                    
                  );
        
        $data =  $this->Noconsumibles->guardarNoConsumible($data);
         echo json_encode($data);
    }
  



    public function editarNoConsumible()
    {
   $data['_put_noconsumibles'] = array(

    'codigo' => $this->input->post('codigo'),
    'descripcion' => $this->input->post('descripcion'), 
    'fec_vencimiento' => $this->input->post('fec_vencimiento'),
    'usuario_app' => 'rodotest', 
    'tinc_id' => $this->input->post('tipo_no_consumible')
   
             );

      $data = $this->Noconsumibles->editarNoConsumible($data);
      echo json_encode($data);
    }


    public function eliminarNoConsumible()
    {
      $data['_delete_noconsumible'] = array(
        'codigo' => $this->input->post('codigo'),
        'usuario_app' => 'rodotest'
      );
      $data = $this->Noconsumibles->eliminarNoConsumible($data);
     
    }


    public function ListarTrazabilidadNoConsumible()
    {
      $data = array(  
      'codigo' => $this->input->post('codigo'),
        );
        $data =  $this->Noconsumibles->ListarTrazabilidadNoConsumible($data);
         echo json_encode($data);
    }
  
    
}
