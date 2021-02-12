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
    
    
    public function guardarDestino()
    {

      $data['_post_tablas'] = array(
        'valor' => $this->input->post('valor'),
        'valor2' => '',
        'tabla' => 'destinos_no_consumibles',
        'valor3' => '',
        'descripcion' => $this->input->post('descripcion')
      );

      $data = $this->Noconsumibles->guardarDestino($data);
      echo json_encode($data);
    }

    public function ListarTrazabilidadNoConsumible()
    {
        $codigo =  $this->input->post('codigo');
        $data['ListarTrazabilidadNoConsumible'] =  $this->Noconsumibles->ListarTrazabilidadNoConsumible($codigo)['data'];
        $this->load->view('NoConsumible/tnc', $data);
    }
  
    
   
    public function buscarNoConsumible()
    {
      $codigo =  $this->input->post('codigoNoCon');
        $data['buscarNoConsumible'] =  $this->Noconsumibles->buscarNoConsumible($codigo)['data'];
        $this->load->view('NoConsumible/buscar', $data);
      }
    


    public function guardarMovimientoEntrada()
  { 
    $datos = $this->input->post('datos');

    $tableData = stripcslashes($datos);
    $tableDataArray['datos'] = json_decode($tableData, TRUE);


      foreach ($tableDataArray['datos'] as $key => $x) {
  
        $data[]['_put_noconsumible_estado'] = array(
  
          'codigo' => $tableDataArray['datos'][$key]['codigo'],
          'estado' => 'ACTIVO',
          'usuario_app' => 'rodotest'
                   );
  
        $data[]['_post_noconsumibles_movimientos'] = array(
  
          'estado' => 'ACTIVO',
          'usuario_app' => 'rodotest', 
          'noco_id' => $tableDataArray['datos'][$key]['codigo'],
          'depo_id' => $tableDataArray['datos'][$key]['establecimiento'],
          'dest_id' => ''
       
                  );
                 
          $rsp =  $this->Noconsumibles->guardarMovimientoEntrada($data);
          $data = [];

        }
        echo json_encode($rsp);
        
  
  }



    public function guardarMovimientoSalida()
    {
      $datos = $this->input->post('datos');

    $tableData = stripcslashes($datos);
    $tableDataArray['datos'] = json_decode($tableData, TRUE);


      foreach ($tableDataArray['datos'] as $key => $x) {
  
        $data[]['_put_noconsumible_estado'] = array(
  
          'codigo' => $tableDataArray['datos'][$key]['codigo'],
          'estado' => 'EN_TRANSITO',
          'usuario_app' => 'rodotest'
                   );
  
        $data[]['_post_noconsumibles_movimientos'] = array(
  
          'estado' => 'EN_TRANSITO',
          'usuario_app' => 'rodotest', 
          'noco_id' => $tableDataArray['datos'][$key]['codigo'],
          'depo_id' => $tableDataArray['datos'][$key]['establecimiento'],
          'dest_id' => $tableDataArray['datos'][$key]['destino']
       
                  );
                 
          $rsp =  $this->Noconsumibles->guardarMovimientoSalida($data);
          $data = [];

        }
        echo json_encode($rsp);
    }

    /**
    * Levanta pantalla recepcion no consumible
    * @param 
    * @return 
    */
    public function recepcionNoConsumible()
    {

      $this->load->view('NoConsumible/recepcionNoConsumible');
    }

    /**
    * Consulta info de un NO consumible
    * @param string codigo de no consumible
    * @return array con info de no consumible
    */
    function consultarInfo()
    {
      $codigo = $this->input->post('codigo');
      log_message('INFO','#TRAZA|| >> ');
      $info = $this->Noconsumibles->consultarInfo($codigo);
      echo json_encode($info);
    }

    /**
    * Libera No consumibles
    * @param array con datos de los no consumibles a liberar
    * @return array respuesta seguns servicio
    */
    function liberarNoConsumible()
    {
      $noCons = $this->input->post('datos');
      log_message('DEBUG','#TRAZA|TRA-PROD-TRAZASOFT|NOCONSUMIBLE|liberarNoConsumible() $noCons>> '.json_encode($noCons));

      $resp = $this->Noconsumibles->liberarNoConsumible($noCons);

      echo json_encode($resp);
    }
}
