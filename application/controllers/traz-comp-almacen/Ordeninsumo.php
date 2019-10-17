<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ordeninsumo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(ALM.'Ordeninsumos');
    }

    public function index()
    {
    	$data['list']       = $this->Ordeninsumos->getList();
      	$data['permission'] = "Add-Edit-Del-View";
        $this->load->view(ALM.'ordeninsumos/list',$data);
    }

    public function cargarlista()
    {
		$data['permission'] = "Add-Edit-Del-View";
		$data['list'] = $this->getcodigo();
        $this->load->view(ALM.'ordeninsumos/view_',$data);
    }

	public function getcodigo()
	{
		$codigo = $this->Ordeninsumos->getcodigo();

		if($codigo)
		{	
			$arre = array();$i=0;
	        foreach ($codigo as $valor ) 
	        {   
				$valorS = (array)$valor;
				$arre[$i]['value']          = $valorS['artId'];
				$arre[$i]['label']          = $valorS['artBarCode'];
				$arre[$i]['artDescription'] = $valorS['artDescription'];
				$arre[$i]['loteid']         = $valorS['loteid'];
				$i++;
	        }
			return $arre;
		}
		else echo "nada";
	}

	public function getsolicitante()
	{
		$solicitante = $this->Ordeninsumos->getsolicitante();
		if($solicitante)
		{	
			$arre = array();$i=0;
	        foreach ($solicitante as $valor ) 
	        {   
				$valorS = (array)$valor;
				$arre[$i]['value'] = $valorS['id_solicitud'];
				$arre[$i]['label'] = $valorS['solicitante'];
				$i++;
	        }
			echo json_encode($arre);
		}
		else echo "nada";
	}

	public function getdeposito()
	{
		$deposito = $this->Ordeninsumos->getdeposito($this->input->post());
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

 	public function getdescrip()
 	{
		$des = $this->Ordeninsumos->getdescrip($this->input->post());
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

	public function guardar()
	{
		$cantidad = array();
		$art = array();
		$datos  = $this->input->post('data');
		$lote   = $this->input->post('idslote');
		$cantidad  = $this->input->post('comp');
		$dep    = $this->input->post('depo');
		$art    = $this->input->post('art');
		$result = $this->Ordeninsumos->insert_orden($datos);	

		if($result)
		{
			$ultimoId = $this->db->insert_id(); 

			//$lote as $row 
			for($i=0; $i < sizeof($art); $i++) { 
	        	$idArticulo = $art[$i];
				if(isset($cantidad[$i]) && $cantidad[$i]){
					$deposito = $dep[$i];
					$idLote = $this->Ordeninsumos->lote($idArticulo,$cantidad[$i],$deposito);


					$datos2 = array(
	        			'enma_id' => $ultimoId, 
	        			'lote_id'         => $idLote,
	        			'cantidad'       => $cantidad[$i]
	        		);
		     
		          	$this->Ordeninsumos->insert_detaordeninsumo($datos2);
         		}
	        }        
		}
		return $result;
	}

	public function alerta()
	{
		$deposito = $_POST['id_deposito'];
		$codigo   = $_POST['id_her'];
		$s = $this->Ordeninsumos->alerta($codigo,$deposito);
		if($s)
		{	
			echo json_encode($s);
		}
		else echo "nada";	
	}

	public function getsolImp(){  
      $id=$_POST['id_orden'];
      $result = $this->Ordeninsumos->getsolImps($id);

      if($result){ 
        
        $arre['datos']=$result;
        $equipos = $this->Ordeninsumos->getequiposBycomodato($id);
        
        if($equipos)
        {
          $arre['equipos']=$equipos;
        }
        else $arre['equipos']=0;


        echo json_encode($arre);
      }
      else echo "nada";
  	}

	public function consultar()
	{
		$id     = $_POST['idor'];
		$result = $this->Ordeninsumos->getConsult($id);
		if($result)
		{	
			$arre['datos'] = $result;
			$equipos       = $this->Ordeninsumos->getequipos($id);
			if($equipos)
			{
				$arre['equipos'] = $equipos;
			}
			else $arre['equipos'] = 0;
			$total = $this->Ordeninsumos->total($id);
			if($total)
			{
				$arre['total'] = $total;
			}
			else $arre['total'] = 0;
			echo json_encode($arre);
		}
		else echo "nada";
	}

	public function getOT()
	{
		$solicitante = $this->Ordeninsumos->getOT();
		if($solicitante)
		{	
			$arre = array();$i=0;
	        foreach ($solicitante as $valor ) 
	        {   
				$valorS = (array)$valor;
				$arre[$i]['value'] = $valorS['id_orden'];
				$arre[$i]['label'] = $valorS['id_orden'];
				$arre[$i]['info']  = $valorS['descripcion'];
				$i++;
	        }
			echo json_encode($arre);
		}
		else echo "nada";
	}

}