<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lote extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('general/Lotes');
  }

  // Muestra listado de articulos
  public function listarPorMateria()
  {
    $id = $this->input->post('id');

    $res = $this->Lotes->listarPorMateria($id)->lotes->lote;
    echo json_encode($res);
  }
  public function listarPorEstablecimientoConSalida()
  {
    $establecimiento = $this->input->post('establecimiento');
    $salida = $this->input->post('salida');
    $res = $this->Lotes->listarPorEstablecimientoConSalida($establecimiento);
    $res['data'] = selectBusquedaAvanzada(false, false, $res['data'], 'batch_id', 'id', array('tituloproducto', 'Stock:' => 'stock'));
    echo json_encode($res);
  }
  public function listarPorCamion()
  {
    $camion = $this->input->post('camion');
    $res = $this->Lotes->listarPorCamion($camion)->lotes->lote;
    echo json_encode($res);
  }
  public function listar()
  {
    $res = $this->Lotes->listar()->lotes->lote;
    echo json_encode($res);
  }

  public function obtenerLotesCamion($options = true)
  {
    $patente = $this->input->post('patente');
    $rsp = $this->Lotes->obtenerLotesCamion($patente);
    if($options != "false")$rsp['data'] = selectBusquedaAvanzada(false, false, $rsp['data'], 'batch_id', 'lote_id', array('Origen:' => 'establecimiento', 'Cantidad:' => 'cantidad', 'Unidad Medida:' => 'um'));
    echo json_encode($rsp);
  }

  public function obtenerLote($lote)
  {
    $this->load->model('general/Lotes');
    $rsp = $this->Lotes->obtenerLote($lote);
    echo json_encode($rsp);
  }

  public function informeTrazabilidad()
  {
    $data = '';
    $this->load->view('produccion/lotes/trazabilidad', $data);
  }

  public function trazabilidadBatch()
  {
    $lote_id = $this->input->get('batch');
    $batch_id = $this->Lotes->getBatchIdLote($lote_id)['data'][0]->batch_id;
    if (isset($batch_id)) {
      $rsp = $this->Lotes->trazabilidadBatch($batch_id);
      $data = $rsp['data'];
      $arbol = array();
      $visto = array();
      $data_filtrada=array();
      $i=0;

      log_message('DEBUG','#TRAZA | trazabilidadBatch() >>  $rsp[data]'.$data);

      //Verifico si ya esta repetido para no mostrarlo en listado debajo de gráfico
      foreach($data as $key => $o){
          if(!$visto[$o->batch_id]){
            $visto[$o->batch_id]=1;
            $data_filtrada[$i]=$o;
            $i=$i+1;
          }else{
            log_message('DEBUG','#TRAZA | #JSON_TRAZABILIDAD >> batch ya repetido '.$o->batch_id);
            }
      }
      
      //Genero estructura de objetos para gráfico de Trazabilidad
      #NO TOCAR PLIS
      foreach ($data as $key => $o) {

          if($o->batch_id_padre){
              #TIENE PADRE Y ESTA METIDO EN EL ARBOL
            if(isset($arbol[$o->batch_id])){
                $arbol[$o->batch_id]  = $arbol[$o->batch_id];
            }else{
                $o->hijos = $arbol;
                $arbol = array("$o->batch_id" => $o);
            }
          }else{
              $arbol[$o->batch_id] = $o;
          }

      }
      $e = reset($arbol);
      $respuesta['arbol_json'] = [nodo($e, $e->hijos)];
      $respuesta['data']=$data_filtrada;

      log_message('DEBUG','#TRAZA | #JSON_TRAZABILIDAD >>'. json_encode($respuesta));

      echo json_encode($respuesta);
      

    } else echo "¡Batch no encontrado! Intente nuevamente.";
  }
  /**
	* Recibe como parametro un batch_id y devuelve la cantidad de reportes de produccion generados para ese batch_id
	* @param integer
	* @return array listado de choferes coincidentes
	*/
  function validarCantidadReportes(){
    log_message("DEBUG", "#TRAZA | TRAZ-PROD-TRAZASOFT | Lote | validarCantidadReportes()");
    $batch_id = $this->input->post('batch_id');
    $rsp = $this->Lotes->validarCantidadReportes($batch_id);
    echo json_encode($rsp);
  }
  /**
    * Verifica si se realizo una entrega de materiales para el lote enviado
    * @param integer batch_id
    * @return bool respuesta del servicio
	*/
  public function verificaEntregaMateriales($batch_id){
    log_message('DEBUG','#TRAZA | #TRAZ-PROD-TRAZASOFT | Etapa | verificaEntregaMateriales($id) ');
    $rsp = $this->Lotes->verificaEntregaMateriales($batch_id);
    echo json_encode($rsp);
  }
}
