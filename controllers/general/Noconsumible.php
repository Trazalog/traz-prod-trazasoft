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
                'usuario_app' => userNick(),
                'tinc_id' => $this->input->post('tipo_no_consumible'),
                'empr_id' => empresa()
              );

        $data[]['_post_noconsumibles_movimientos'] = array(

                'estado' => 'ALTA',
                'usuario_app' => userNick(),
                'noco_id' => $this->input->post('codigo'),
                'depo_id' => $this->input->post('depositos'),
                'dest_id' => '',
                'empr_id' => empresa()
              );

        $data =  $this->Noconsumibles->guardarNoConsumible($data);
         echo json_encode($data['status']);
    }

    public function editarNoConsumible()
    {
        $data['_put_noconsumibles'] = array(
          'codigo' => $this->input->post('codigo'),
          'descripcion' => $this->input->post('descripcion'),
          'fec_vencimiento' => $this->input->post('fec_vencimiento'),
          'usuario_app' => userNick(),
          'tinc_id' => $this->input->post('tinc_id'),
          'empr_id' => empresa()
        );

        $data = $this->Noconsumibles->editarNoConsumible($data);
        echo json_encode($data);
    }

    public function eliminarNoConsumible()
    {
      $data['_delete_noconsumible'] = array(
        'codigo' => $this->input->post('codigo'),
        'usuario_app' => userNick(),
        'empr_id' => empresa()
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

    /**
    * Guarda movimiento de entrada No Consumibles(Pantalla Entrada|Recepcion->Recepcion MP)
    * @param array con datos de No Consumibles
    * @return array con respuesta de servicio
    */
    public function guardarMovimientoEntrada()
    {
        $datos = $this->input->post('datos');
        $tableData = stripcslashes($datos);
        $tableDataArray = json_decode($tableData, TRUE);

        foreach ($tableDataArray as $key => $value) {

            $noco_list[$key] = $value['noco_id'];
            $estado = 'ACTIVO';
            $depo_id = $value['depositos'];
            $destino = "";
            $response = $this->Noconsumibles->movimientoNoConsumibles($noco_list, $estado, $depo_id, $destino);
            if (!$response) {
              log_message('ERROR','#TRAZA|TRAZASOFT|GENERAL|NOCONSMIBLE|guardarMovimientoEntrada() >> ERROR: No se pudo guarda movimiento de no consumibles ');
              break 1;
            }
        }

        echo json_encode($rsp);
    }

    /**
    * Levanta pantalla recepcion no consumible
    * @param
    * @return view recepcion
    */
    public function recepcionNoConsumible()
    {
        $data['tipoEstablecimiento'] = $this->Noconsumibles->tipoEstablecimiento()['data'];
        $this->load->view('NoConsumible/recepcionNoConsumible', $data);
    }

    /**
    * Consulta info de un NO consumible (pantalla recepcion no consm)
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
    * Libera No consumibles (Pantalla Recepción no consumibles)
    * @param array con datos de los no consumibles a liberar
    * @return array respuesta seguns servicio
    */
    function liberarNoConsumible()
    {
        $noCons = $this->input->post('datos');
        $depo_id = $this->input->post('deposito');
        $destino = "";
        log_message('DEBUG','#TRAZA|TRA-PROD-TRAZASOFT|NOCONSUMIBLE|liberarNoConsumible() $noCons>> '.json_encode($noCons));

        // libera noconsumible en no consumibles_lote
        $respLibNoConsLotes = $this->Noconsumibles->liberarNoConsumible($noCons);
        if (!$respLibNoConsLotes) {
          # code...
        }

        // procesa array para guardar movimientos
          $noco_list = $this->armaArray($noCons);

        // llamar a movimientos lotes
          $destino = "";
          $respNoCons = $this->Noconsumibles->movimientoNoConsumibles($noco_list, 'ACTIVO', $depo_id, $destino);
          echo json_encode($respNoCons);
    }

    /**
    * Arma array para guardar movimiento no consumibles
    * @param array con datos
    * @return array con datos mapeados
    */
    function armaArray($noCons)
    {
        foreach ($noCons as $key => $value) {
          $noco_list[$key] = $noCons[$key]['noco_id'];
        }
        return $noco_list;
    }

    /**
    * Actualiza estado PANTALLA ABM NO CONSUMIBLES
    * @param array con datos a actualizar
    * @return boolean respuesta de servicio
    */
    function cambioEstado()
    {
        log_message('INFO','#TRAZA|| >> ');
        $data = $this->input->post('data');
        $data['usuario_app'] = userNick();
        $data['empr_id'] = empresa();
        $resp = $this->Noconsumibles->cambioEstado($data);
        echo json_encode($resp);
    }

    /**
    * Trae listado de Destinos Externos para llenar selectores
    * @param
    * @return array con listado de destinos externos
    */
    function seleccionarDestino(){
        $resp = $this->Noconsumibles->seleccionarDestino()['data'];
        echo json_encode($resp);
    }

  /**
	* Recibe el codigo del NoCo, para posteriormente validar si ya esta creado para una empresa
	* @param string codigo NoCo
	* @return array respuesta del servicio
	*/
  public function validarNoConsumible(){
    log_message('INFO','#TRAZA | #TRAZ-PROD-TRAZASOFT | Noconsumible | validarNoConsumible()');

		$noco = $this->input->post('codigo');

		$resp = $this->Noconsumibles->validarNoConsumible($noco);
        
    echo json_encode($resp);
	}
}
