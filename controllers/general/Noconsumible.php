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
        log_message('INFO','#TRAZA | #TRAZ-PROD-TRAZASOFT | Noconsumible | cambioEstado');
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
  /**
	* Realiza la validación, generación y creación de los NoCo's segun los parámetros recibidos
	* @param array parametros (cantidad, prefijo,desde,tipo NC, descripción, fec_vencimiento, establecimiento, depósito)
	* @return array respuesta del servicio
	*/
  public function altaMasivaNoConsumibles(){
    $cantidad = $this->input->post('cantidad');
    $prefijo = $this->input->post('prefijo');
    $desde = $this->input->post('desde');
    $tipo_no_consumible = $this->input->post('tipo_no_consumible');
    $descripcion = $this->input->post('descripcion');
    $fec_vencimiento = $this->input->post('fec_vencimiento');
    // $establecimiento = $this->input->post('establecimiento');
    $deposito = $this->input->post('deposito');

    $noco_inicial =  (!empty($prefijo)? $prefijo : '') . $desde;
    $noco_final =  (!empty($prefijo)? $prefijo : '') . ($desde + $cantidad);

    //Valido que los parametros sean correctos y no existan NoCo's en dicho intervalo
    $rspValidacion =  $this->Noconsumibles->validarCodigoMasivoNoConsumibles($noco_inicial,$noco_final);
    //Este arreglo va amndar a la vista lso NoCo's generados apra su psoteriror impresión
    $NoCosGenerados = array();
    if($rspValidacion->existe != "true"){
      for ($i=$desde; $i < $desde + $cantidad; $i++) {
        $data[]['_post_noconsumibles'] = array(
          'codigo' => (!empty($prefijo)? $prefijo : '') . $i,
          'descripcion' => $descripcion,
          'fec_vencimiento' => $fec_vencimiento,
          'usuario_app' => userNick(),
          'tinc_id' => $tipo_no_consumible,
          'empr_id' => empresa()
        );
  
        $data[]['_post_noconsumibles_movimientos'] = array(
          'estado' => 'ALTA',
          'usuario_app' => userNick(),
          'noco_id' => (!empty($prefijo)? $prefijo : '') . $i,
          'depo_id' => $deposito,
          'dest_id' => '',
          'empr_id' => empresa()
        );
        array_push($NoCosGenerados, array("codigo" => (!empty($prefijo)? $prefijo : '') . $i, "descripcion" => $descripcion, "fec_alta" => date('d-m-Y')));
        $rsp = $this->Noconsumibles->guardarNoConsumible($data);
        unset($data);
      }

      if($rsp['status']){
        $rsp['title'] = 'Hecho';
        $rsp['msg'] = "Se dieron de alta los <b>No Consumibles</b> exitosamente.";
        $rsp['type'] = "success";
        $rsp['NoCos'] = $NoCosGenerados;
      }else{
        $rsp['title'] = 'Error';
        $rsp['msg'] = "Se produjo un error al dar de alta algún <b>No Consumible</b>";
        $rsp['type'] = "error";
      }
    }else{
      $rsp['status'] = false;
      $rsp['title'] = "Ops!";
      $rsp['msg'] = "Ya existen <b>No Consumibles</b> con identificador dentro del rango solicitado";
      $rsp['type'] = "warning";
    }
    echo json_encode($rsp);
  }
  /**
	* Recibe un prefijo del codigo de un NoCo, para posteriormente buscar el ultimo indice de ese código
	* @param string codigo NoCo
	* @return array respuesta del servicio
	*/
  public function obtenerIndicePrefijo(){
    log_message('INFO','#TRAZA | #TRAZ-PROD-TRAZASOFT | Noconsumible | obtenerIndicePrefijo()');
		$prefijo = $this->input->post('prefijo');
		$aux = $this->Noconsumibles->obtenerIndicePrefijo($prefijo);
    if(!empty($aux->noConsumible->codigo)){
      $resp['status'] = true;
      $auxi = str_replace(array('+','-'), '', $aux->noConsumible->codigo);
      $resp['indice'] = (int) filter_var($auxi, FILTER_SANITIZE_NUMBER_INT);
    }else{
      $resp['status'] = false;
      $resp['indice'] = 'SIN COINCIDENCIAS';
    }
    echo json_encode($resp);
	} 
}
