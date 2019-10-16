<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lotes extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function getList() // Ok
	{
		$this->db->select('alm_lotes.*, alm_articulos.descripcion as artDescription, alm_articulos.barcode as artBarCode,alm_lotes.cantidad,alm_depositos.descripcion as depositodescrip');
		$this->db->from('alm_lotes');
		$this->db->join('alm_articulos', 'alm_lotes.arti_id = alm_articulos.arti_id');
		$this->db->join('alm_depositos', ' alm_lotes.depo_id = alm_depositos.depo_id');
		//$this->db->join('utl_tablas C','alm_lotes.estado_id = C.tabl_id');

		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{	
			return false;
		}

	}

	public function getPuntoPedido()
	{
		  // OBTENER CANTIDADES RESERVADAS
		  $this->db->select('arti_id, IFNULL(sum(resto),0) as cant_reservada');
		  $this->db->from('alm_deta_pedidos_materiales');
		  $this->db->join('alm_pedidos_materiales', 'alm_deta_pedidos_materiales.pema_id = alm_pedidos_materiales.pema_id');
		  $this->db->where('estado!=','Entregado');
		  $this->db->where('estado!=','Rechazado');
		  $this->db->where('estado!=','Cancelado');
		  $this->db->where('alm_pedidos_materiales.empr_id', empresa());
		  $this->db->group_by('arti_id');
		  $C = '(' . $this->db->get_compiled_select() . ') C';

		  $this->db->select('ART.arti_id, ART.barcode, ART.descripcion, punto_pedido, IFNULL(sum(LOTE.cantidad), 0) as cantidad_stock, IFNULL(sum(LOTE.cantidad),0)-cant_reservada as cantidad_disponible');
		  $this->db->from('alm_articulos ART');
		  $this->db->join('alm_lotes LOTE','LOTE.arti_id = ART.arti_id');
		  $this->db->join($C,'C.arti_id = ART.arti_id');
		  $this->db->group_by('ART.arti_id');
		  $sql = '('.$this->db->get_compiled_select().') AUX';

		  $this->db->where('AUX.cantidad_disponible < AUX.punto_pedido');
		  $this->db->from($sql);
		  return $this->db->get()->result_array();
	}
	
	function getMotion($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$idStk = $data['id'];

			$data = array();

			//Datos del movimiento
			$query= $this->db->get_where('admstock',array('stkId'=>$idStk));
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
				$data['motion'] = $c[0];
			} else {
				$stk = array();
				$stk['stkCant'] = '';
				$stk['stkMotive'] = '';
				$data['motion'] = $stk;
			}

			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View'){
				$readonly = true;
			}
			$data['read'] = $readonly;

			//Products
			$query= $this->db->get_where('admproducts',array('prodStatus'=>'AC'));
			if ($query->num_rows() != 0)
			{
			 	$data['products'] = $query->result_array();	
			}
			
			return $data;
		}
	}
	
	function setMotion($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
            $act = $data['act'];
            $prodId = $data['prodId'];
            $cant = $data['cant'];
            $motive = $data['motive'];

           // $userdata = $this->session->userdata('user_data');
			//$usrId = $userdata[0]['usrId'];

			$data = array(
				   'prodId' => $prodId,
				   'stkCant' => $cant,
				   'stkMotive' => $motive,
				   'usrId' => 0, //!HARDCODE
				   'stkDate' => date('Y-m-d H:i:s')
				);

			switch($act){
				case 'Add':
					//Agregar Movimiento 
					if($this->db->insert('admstock', $data) == false) {
						return false;
					} 
					break;

			}
			return true;

		}
	}

	public function crearLoteSistema($data)
	{
		$aux  = array(
			'codigo'=> $data['barcode'],
			'arti_id'=>$data['arti_id'],
			'prov_id'=>0,
			'depo_id'=>1,
			'cantidad'=>0,
			'estado_id'=>1,
			'empr_id'=>empresa()
		);
		return $this->db->insert('alm_lotes',$aux);
	}

	public function verificarExistencia($arti, $lote, $depo)
	{
		$this->db->where('codigo',$lote);
		$this->db->where('depo_id',$depo);
		$this->db->where('arti_id',$arti);
		$this->db->where('empr_id', empresa());
		return $this->db->get('alm_lotes')->num_rows()>0?1:0;
	}
	
}