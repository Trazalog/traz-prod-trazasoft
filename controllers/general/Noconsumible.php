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
   $this->load->view('NoConsumible/ListarNoConsumible',$data);
    }

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
        $codigo =  $this->input->post('codigo');
        $data['ListarTrazabilidadNoConsumible'] =  $this->Noconsumibles->ListarTrazabilidadNoConsumible($codigo)['data'];
        $this->load->view('NoConsumible/tnc', $data);
    }
  
    


    public function guardarMovimientoEntrada1()
    {
      $data[]['_put_noconsumible_estado'] = array(

          'codigo' => $this->input->post('codigo'),
          'estado' => 'ACTIVO',
          'usuario_app' => 'rodotest'
                   );

        $data[]['_post_noconsumibles_movimientos'] = array(

          'estado' => 'ACTIVO',
          'usuario_app' => 'rodotest', 
          'noco_id' => $this->input->post('codigo'),
          'depo_id' => $this->input->post('establecimiento'),
          'dest_id' => $this->input->post('depositos'),
                    
                  );
         // $data = $this->input->post('array');
        $data =  $this->Noconsumibles->guardarMovimientoEntrada($data);
         echo json_encode($data);
    }

    public function guardarMovimientoEntrada()
  { //asigna a un establecimiento, depositos, recipientes y tipos de los mismos
    $datos = $this->input->post('datos');

    $tableData = stripcslashes($datos);
    $tableDataArray['datos'] = json_decode($tableData, TRUE);


    foreach ($tableDataArray['datos'] as $key => $x) {
      $array['codigo'] = $tableDataArray['datos'][$key]['codigo'];
      $array['estado'] = "ACTIVO";
      $array['usuario_app'] = "rodotest";


      $array1['estado'] = "ACTIVO";
      $array1['usuario_app'] = "rodotest";
      $array1['noco_id'] = $tableDataArray['datos'][$key]['codigo'];
      $array1['depo_id'] = $tableDataArray['datos'][$key]['establecimiento'];
      $array1['dest_id'] = $tableDataArray['datos'][$key]['depositos'];

      $put['_put_noconsumible_estado'][] = $array;

      $post['_post_noconsumibles_movimientos'][] = $array1;
    }



    $data =  $this->Noconsumibles->guardarMovimientoEntrada($put,$post);

    echo json_encode($data);
  }



    public function guardarMovimientoSalida()
    {
      $data[]['_put_noconsumible_estado'] = array(

          'codigo' => $this->input->post('codigo'),
          'estado' => 'EN_TRANSITO',
          'usuario_app' => 'rodotest'
                   );

        $data[]['_post_noconsumibles_movimientos'] = array(

          'estado' => 'EN_TRANSITO',
          'usuario_app' => 'rodotest', 
          'noco_id' => $this->input->post('codigo'),
          'depo_id' => $this->input->post('depositos'),
          'dest_id' => ''
                    
                  );
        
        $data =  $this->Noconsumibles->guardarMovimientoSalida($data);
         echo json_encode($data);
    }


}
