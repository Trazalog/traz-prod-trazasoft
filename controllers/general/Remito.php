<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Remito extends CI_Controller
{

    public function __construct(){
      parent::__construct();
      $this->load->model('general/Remitos');
     
    }

  /**
	* Carga view listado de remito
	* @param 
	* @return array remitos
	*/
    public function listaRemito(){
      //$resp = $this->Remitos->listRemitos();
      $this->load->view('remito/historico_remitos');
    }


    /**
	* Busca clientes que coincidan con un patron ingresado
	* @param array patron ingresado en pantalla
	* @return array listado de clientes coincidentes con el criterio de busqueda
	*/
  public function buscaClientes(){
		log_message('DEBUG', "#TRAZA | # #TRAZ-PROD-TRAZASOFT | Remitos | buscaClientes()");
    $dato = $this->input->get('patron');        		
		$resp = $this->Remitos->buscaClientes($dato);
		echo json_encode($resp);
    }



  /**
	* Genera el listado de remitos paginadas
	* @param integer;integer;string start donde comienza el listado; length cantidad de registros; search cadena a buscar
	* @return array listado paginado y la cantidad
	*/
    public function getRemitosPaginado() {
    $draw = $this->input->post('draw');
    $start = $this->input->post('start');
    $length = $this->input->post('length');
    $ordering = $this->input->post('order');
    $search = $this->input->post('search')['value'];
    $fechaDesde = $this->input->post('fechaDesde');
    $fechaHasta = $this->input->post('fechaHasta');
    $cliente = $this->input->post('cliente');

    // Obtener los datos de la base de datos, incluyendo el total de registros
     // Total sin filtrar
    $data = $this->Remitos->listRemitos($start, $length, $search, $ordering, $fechaDesde,  $fechaHasta, $cliente); // Obtener los datos paginados
    
    if($cliente || $search){
      $totalRecords = $this->Remitos->cantidadRemitosFiltrados($search)[0]->total;;
      $filteredRecords = $totalRecords;
    }
    else{
      $totalRecords = $this->Remitos->cantidadRemitos()[0]->total;
      $filteredRecords = $totalRecords; 
    }
    

    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords),
        "recordsFiltered" => intval($filteredRecords),
        "data" => $data
    );

    echo json_encode($response);
  }


   /**
	* trae las lineas del remito por su remi_id
	* @param array remi_id
	* @return array listado de lineas del remito
	*/
  public function getLineasRemito(){
    $remi_id = $this->input->post('remi_id');
		log_message('DEBUG', "#TRAZA | # #TRAZ-PROD-TRAZASOFT | Remitos | getLineasRemito()");     		
		$resp = $this->Remitos->getLineasRemito($remi_id);
		echo json_encode($resp);
    }
    
 /**
	* trae la version con los articulos y precios
	* @param array remi_id
	* @return array listado de versiones de articulo usados en el remito
	*/
  public function getVersionArticulos(){
    $remi_id = $this->input->post('remi_id');
		log_message('DEBUG', "#TRAZA | # #TRAZ-PROD-TRAZASOFT | Remitos | getVersionArticulos()");     		
		$resp = $this->Remitos->getVersionArticulos($remi_id);
		echo json_encode($resp);
    }
		
}
