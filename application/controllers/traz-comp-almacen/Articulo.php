<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articulo extends CI_Controller {

	function __construct() 
    {
		parent::__construct();

		$this->load->model(CMP_ALM.'/Articulos');
		$this->load->model(CMP_ALM.'/Lotes');

	}

	// Muestra listado de articulos
	public function index($permission='Add-Edit-Del-View')
	{
		$data['list'] = $this->Articulos->getList();
		$data['permission'] = $permission;
		$this->load->view(CMP_ALM.'/articulo/list', $data);
	}
		
	public function getdatosart() // Ok
	{
		$art = $this->Articulos->getUnidadesMedidas();
		if($art)
		{	
			$arre = array();
	        foreach ($art as $row ) 
	        {   
	           $arre[] = $row;
	        }
			echo json_encode($arre);
		}
		else echo "nada";
	}

	//
	public function getArticle() // Ok
	{
		$data['data']   = $this->Articulos->getArticle($this->input->post());
		$response['html'] = $this->load->view(CMP_ALM.'/articulo/view_', $data, true);

		echo json_encode($response);
	}

	//
	public function getpencil() // Ok
	{
		$id     = $this->input->post('idartic');
		$result = $this->Articulos->getpencil($id);
		echo json_encode($result);
	}

	//
	public function editar_art()  // Ok
	{
		$datos  = $this->input->post('data');
		$id     = $this->input->post('ida');
		$result = $this->Articulos->update_editar($datos,$id);
		print_r(json_encode($result));	
	}


	public function setArticle(){
		$data = $this->input->post();
		$id = $this->Articulos->setArticle($data);


		if($id  == false)
		{
			echo json_encode(false);
		}
		else
		{
			
			echo json_encode(true);	
		}
	}


	public function baja_articulo()
	{
		$idarticulo = $_POST['idelim'];
		$result     = $this->Articulos->eliminar($idarticulo);
		print_r($result);
	}

	public function searchByCode() {
		$data = $this->Articulos->searchByCode($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);	
		}
	} 

	public function searchByAll() {
		$data = $this->Articulos->searchByAll($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);	
		}
	}

	public function getestado(){

		$response = $this->Articulos->getestados();

		echo json_encode($response);
		  
	}

	public function getLotes($id = null) //fleiva
	{
		if(!$id){ $this->load->view('no_encontrado');return;}

		$data['articulo'] = $this->Articulos->get($id);

		$data['list'] = $this->Articulos->getLotes($id);
			
		$this->load->view(CMP_ALM.'/proceso/tareas/componentes/tabla_lote_deposito', $data);
	}

}