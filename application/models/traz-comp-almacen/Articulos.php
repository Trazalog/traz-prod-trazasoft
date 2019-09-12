<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Articulos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getList()  
	{	
		$this->db->select('A.*, B.descripcion as medida,"AC" as valor, IFNULL(sum(C.cantidad),0) as stock');
		$this->db->from('alm_articulos A');
		$this->db->join('utl_tablas B', 'B.tabl_id = A.unidad_id','left');
		$this->db->join('alm_lotes C', 'C.arti_id = A.arti_id','left');
		$this->db->where('A.empr_id', empresa());
		$this->db->where('not A.eliminado');
		$this->db->group_by('arti_id');
			
		$query = $this->db->get();	
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{	
			return array();
		}
	}

	function get($id)
	{
		$this->db->where('arti_id',$id);
		return $this->db->get('alm_articulos')->row_array();
	}

	function getLotes($id)
	{
		$this->db->where('arti_id',$id);
		$this->db->select('*');
		$this->db->from('alm_lotes T');
		$this->db->join('alm_depositos A','T.depo_id = A.depo_id');
		return $this->db->get()->result_array();
	}
	
	function getpencil($id) // Ok
    {
    	$userdata  = $this->session->userdata('user_data');
		$empresaId = $userdata[0]['id_empresa'];

		$this->db->select('A.*, B.tabl_id as unidadmedida,B.descripcion as unidad_descripcion');
		$this->db->from('alm_articulos A');
		$this->db->join('utl_tablas B','A.unidad_id = B.tabl_id','left');
		$this->db->where('arti_id',$id);
		$this->db->where('empr_id',$empresaId);


	    $query = $this->db->get();
	    if( $query->num_rows() > 0)
	    {
	    	return $query->result_array();	
	    } 
	    else {
	    	return 0;
	    }
	}

	function eliminar($id){
		//$estado_id = $this->db->get_where('utl_tablas',['valor'=>'IN'])->row()->tabl_id;
		$this->db->where('arti_id',$id);
		$this->db->set('eliminado',true);
		return $this->db->update('alm_articulos');
	}

	function getUnidadesMedidas()
	{
		$this->db->select('A.tabl_id as id_unidadmedida,A.descripcion');
		$this->db->where('tabla','unidad');
		$query  = $this->db->get('utl_tablas A');
		if($query->num_rows()>0)
		{
		    return $query->result_array();
		}
		else
		{
		    return false;
		}		
	}


	function getArticle($data = null)
	{
		
		if($data == null || strpos('Add',$data['act']) == 0)
		{
			return false;
		}
		else
		{
			$userdata  = $this->session->userdata('user_data');
			$empresaId = empresa();
			$action    = $data['act'];
			$idArt     = $data['id'];
			$data      = array();
			
			$this->db->select('A.*,B.valor as unidad');
			$this->db->from('alm_articulos A');
			$this->db->join('utl_tablas B','A.unidad_id = B.tabl_id');
			$this->db->join('utl_tablas C','A.estado_id = C.tabl_id');
			$this->db->where('C.valor','AC');
		
		    $query = $this->db->get();
		    
		 	if ($query->num_rows() != 0)
			{
				//echo "if ".$empresaId;
				$c               = $query->result_array();
				$data['article'] = $c[0];

			} else {
				//echo "else ".$empresaId;
				$art                       = array();
				$art['artId']              = '';
				$art['artBarCode']         = '';
				$art['artDescription']     = '';
				$art['artCoste']           = '';
				$art['artMargin']          = '';
				$art['artMarginIsPorcent'] = '';
				$art['artIsByBox']         = '';
				$art['artCantBox']         = '';
				$art['artEstado']          = 'AC';
				$art['unidadmedida']       = '';
				$art['punto_pedido']       = '';
				$art['id_empresa']		   = $empresaId;
				$data['article']           = $art;
			}
			$data['article']['action'] = $action;
			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View'){
				$readonly = true;
			}
			$data['read']   = $readonly;
			$data['action'] = $action;
		
			
			return $data;
		}
	}
	
	function setArticle($data = null)
	{
		if($data == null)
		{
			return false;
		}
		else
		{
			$userdata  = $this->session->userdata('user_data');
			$empresaId = $userdata[0]['id_empresa'];
			$id        = $data['id'];
			$act       = $data['act'];
			$name      = $data['name'];
			$status    = $data['status'];
			$box       = $data['box'];
			$boxCant   = $data['boxCant'];
			$code      = $data['code'];
		
			$unidmed   = $data['unidmed'];   
			$puntped   = $data['puntped'];     
			$data      = array(
				'barcode'     => $code,
				'descripcion' => $name,
				'estado_id'      => $status,
				'es_caja'     => ($box === 'true'),
				'cantidad_caja'     => $boxCant,
				'unidad_id'   => $unidmed,
				'punto_pedido'   => $puntped,
				'es_loteado' => $data['es_loteado'],
				'empr_id'	 => $empresaId
			);

			switch($act){
				case 'Add':
					if($this->db->get_where('alm_articulos',['barcode'=>$code, 'empr_id'=>$empresaId])->num_rows()>0)return false;
				
					if($this->db->insert('alm_articulos', $data)) {
						return $this->db->insert_id();
					} 
					break;
				case 'Edit':
				 	//Actualizar Artículo
				 	if($this->db->update('alm_articulos', $data, array('artId'=>$id)) == false) {
				 		return false;
				 	}
				 	break;
				case 'Del':
				 	//Eliminar Artículo
				 	if($this->db->delete('alm_articulos', array('artId'=>$id)) == false) {
				 		return false;
				 	}
				 	break;
			}
			return true;
		}
	}
	

	
	function getdatosfams()
	{
		$userdata  = $this->session->userdata('user_data');
        $empresaId = $userdata[0]['id_empresa'];
		$query     = $this->db->get_where('conffamily', array('id_empresa' => $empresaId));
		if($query->num_rows()>0){
		    return $query->result();
		}
		else{
		    return false;
		    }
				
	}
	
	function update_articulo($data, $idarticulo)
	{
		$userdata           = $this->session->userdata('user_data');
        $empresaId          = $userdata[0]['id_empresa'];
        $data['id_empresa'] = $empresaId;
        $this->db->where('artId', $idarticulo);
        $query = $this->db->update("articles",$data);
		return $query;
    }



	function update_editar($data, $id)
	{
        $this->db->where('arti_id', $id);
        $query = $this->db->update("alm_articulos",$data);
        return $query;
    }

	function searchByCode($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$articles = array();

		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where(array('artBarCode'=>$str, 'artEstado'=>'AC')); 
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			if($query->num_rows() > 1){
				//Multiples coincidencias
			} else {
				//Unica coincidencia
				$a = $query->result_array();
				$articles = $a[0];

				//Calcular precios 
				$pUnit = $articles['artCoste'];
				if($articles['artIsByBox'] == 1){
					$pUnit = $articles['artCoste'] / $articles['artCantBox'];
				}

				if($articles['artMarginIsPorcent'] == 1){
					$articles['pVenta'] = $pUnit + ($pUnit * ($articles['artMargin'] / 100));
				} else {
					$articles['pVenta'] = $pUnit + $articles['artMargin'];
				}

			}
			return $articles;
		}

		return $articles;
	}

	function searchByAll($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$art = array();

		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('artEstado','AC');
		if($str != ''){
			$this->db->like('artBarCode',$str);
			$this->db->or_like('artDescription',$str);
		}
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			foreach($query->result_array() as $a){
				$articles = $a;

				//Calcular precios 
				$pUnit = $articles['artCoste'];
				if($articles['artIsByBox'] == 1){
					$pUnit = $articles['artCoste'] / $articles['artCantBox'];
				}

				if($articles['artMarginIsPorcent'] == 1){
					$articles['pVenta'] = $pUnit + ($pUnit * ($articles['artMargin'] / 100));
				} else {
					$articles['pVenta'] = $pUnit + $articles['artMargin'];
				}

				$art[] = $articles;
			}
		}

		return $art;
	}

	function getestados()
	{
		$userdata  = $this->session->userdata('user_data');
		$empresaId = $userdata[0]['id_empresa'];
		
		$this->db->select('articles.artEstado, tbl_estado.estadoid, tbl_estado.descripcion');
		$this->db->from('articles');
		$this->db->join('tbl_estado', 'tbl_estado.estado = articles.artEstado');
		$this->db->where('articles.id_empresa', $empresaId);
		$this->db->group_by('articles.artEstado');
		$query = $this->db->get();	
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{	
			return array();
		}
	}
}
