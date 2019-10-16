<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Remito extends CI_Controller {

	private $permission = 'Add-Edit-Del-View';

    public function __construct()
    {
		parent::__construct();
		
		$this->load->model(ALM.'Remitos');
		$this->load->model(ALM.'Articulos');
		$this->load->model(ALM.'Lotes');
    }

    public function index() // Ok
    {
		 
      	$data['permission'] = $this->permission;
      	$data['list'] = $this->Remitos->getRemitosList();
		$this->load->view(ALM.'remito/list',$data);
    }

    public function cargarlista() // Ok
    { 
		$this->load->model('traz-comp/Componentes');
		
		#COMPONENTE ARTICULOS
		$data['items'] = $this->Componentes->listaArticulos();
		$data['lang'] = lang_get('spanish', 'Ejecutar OT');

		$data['permission'] = $this->permission;
        $this->load->view(ALM.'remito/view_',$data);
	}
	
	public function getcodigo($json=true)
    {
		$codigo = $this->Remitos->getcodigo();

		if($codigo)
		{	
			$arre = array();$i=0;
	        foreach ($codigo as $valor ) 
	        {   
				$valorS = (array)$valor;
				$arre[$i]['value'] = $valorS['artId'];
				$arre[$i]['label'] = $valorS['artBarCode'];
				$arre[$i]['artDescription'] = $valorS['artDescription'];
				$arre[$i]['es_loteado'] = $valorS['es_loteado'];
				$arre[$i]['es_caja'] = $valorS['es_caja'];
				$arre[$i]['cantidad_caja'] = $valorS['cantidad_caja'];
				$i++;
	        }
			if($json) echo json_encode($arre);
			else{return $arre;}
		}
		else echo "nada";
	}

	public function getdeposito()
	{
		$deposito = $this->Remitos->getdeposito();
		if($deposito)
		{	
			$arre = array();
	        foreach ($deposito as $row ) 
	        {   
	           $arre[] = $row;
	        }
			echo json_encode($arre);
		}
		else echo "nada";
	}

	public function getproveedor()
	{
		$sol = $this->Remitos->getproveedor();
		if($sol)
		{	
			$arre = array();
	        foreach ($sol as $row ) 
	        {   
	           $arre[] = $row;
	        }
			echo json_encode($arre);
		}
		else echo "nada";
	}

	public function getdescrip()
 	{
		//$this->load->model('Remitos');
		$des = $this->Remitos->getdescrip($this->input->post());
		//echo json_encode($Customers);
		if($des)
		{	
			$arre = array();
	        foreach ($des as $row ) 
	        {   
	           $arre[] = $row;
	        }
			echo json_encode($arre);
		}
		else echo "nada";
	}

	public function consultar()
	{
		$id     = $_POST['idremito'];
		$result = $this->Remitos->getConsulta($id);
		if($result)
		{	
			$arre['datosRemito'] = $result;
			$datosDetaRemitos       = $this->Remitos->getDetaRemitos($id);
			if($datosDetaRemitos)
			{
				$arre['datosDetaRemitos'] = $datosDetaRemitos;
			}
			echo json_encode($arre);
		}
		else echo "nada";
	}
	
	public function alerta()
	{
		$deposito = $_POST['id_deposito'];
		$codigo   = $_POST['id_her'];
		$s        = $this->Remitos->alerta($codigo, $deposito);
		if($s)
		{				
			echo json_encode($s);
		}
		else echo "nada";
	}

	public function getlote()
	{
		$idd = $_POST['id_deposito'];
		$ide = $_POST['id_her'];
		$sol = $this->Remitos->getlote($ide, $idd);
		//echo json_encode($Customers);
		if($sol)
		{	
			$arre = array();
	        foreach ($sol as $row ) 
	        {   
	           $arre[] = $row;
	        }
			echo json_encode($arre);
		}
		else echo "nada";
	}

	public function guardar()
	{
		$datos  = $_POST['data'];
		$lote =   $_POST['lote'];
		$co     = $_POST['comp']; // cnt
		$dep    = $_POST['depo']; // deposito
		$indice = $_POST['idsinsumo'];
		$ar     = $_POST['art']; //id de articulos 
		$prov_id = $_POST['prov_id'];
		$i      = 1;
	
		$result = $this->Remitos->insert_orden($datos);
		if($result)
		{
		
			$ultimoId=$this->db->insert_id(); //traigo el ultimo id 
			$this->Remitos->detaorden($ultimoId,$lote, $co, $dep, $indice, $ar, $prov_id);
	
		}
		return $result;
	}




	public function getsolicitante(){
		$this->load->model('Ordeninsumos');
		$solicitante = $this->Ordeninsumos->getsolicitante();
		if($solicitante)
		{	
			$arre = array();
	        foreach ($solicitante as $row ) 
	        {   
	           $arre[] = $row;
	        }
			echo json_encode($arre);
		}
		else echo "nada";
	}

	public function guardar_mejor()
	{
		$info = $this->input->post('info');

		$detalles = $this->input->post('detalles');

		$this->Remitos->insert_orden($info);

		$id = $this->db->insert_id();

		$this->Remitos->guardar_detalles($id,$detalles);

		return $data;
	}

}
