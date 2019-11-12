<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lotes extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function getList() // Ok
	{
		$this->db->select('alm.alm_lotes.*, alm.alm_articulos.descripcion as artDescription, alm.alm_articulos.barcode as artBarCode,alm.alm_lotes.cantidad,alm.alm_depositos.descripcion as depositodescrip');
		$this->db->from('alm.alm_lotes');
		$this->db->join('alm.alm_articulos', 'alm.alm_lotes.arti_id = alm.alm_articulos.arti_id');
		$this->db->join('alm.alm_depositos', ' alm.alm_lotes.depo_id = alm.alm_depositos.depo_id');
		//$this->db->join('alm.alm.utl_tablas C','alm.alm_lotes.estado_id = C.tabl_id');

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
		  $this->db->select('arti_id, COALESCE(sum(resto),0) as cant_reservada');
		  $this->db->from('alm.alm_deta_pedidos_materiales');
		  $this->db->join('alm.alm_pedidos_materiales', 'alm.alm_deta_pedidos_materiales.pema_id = alm.alm_pedidos_materiales.pema_id');
		  $this->db->where('estado!=','Entregado');
		  $this->db->where('estado!=','Rechazado');
		  $this->db->where('estado!=','Cancelado');
		  $this->db->where('alm.alm_pedidos_materiales.empr_id', empresa());
		  $this->db->group_by('arti_id');
		  $C = '(' . $this->db->get_compiled_select() . ') as "C"';

		  $this->db->select('ART.arti_id, ART.barcode, ART.descripcion, ART.punto_pedido, COALESCE(sum("LOTE".cantidad), 0) as cantidad_stock, COALESCE(sum("LOTE".cantidad),0)-COALESCE(cant_reservada,0) as cantidad_disponible');
		  $this->db->from('alm.alm_articulos as ART');
		  $this->db->join('alm.alm_lotes as LOTE','LOTE.arti_id = ART.arti_id');
		  $this->db->join($C,'C.arti_id = ART.arti_id','left');
		  $this->db->group_by('ART.arti_id, C.cant_reservada');
		
		  $sql = '('.$this->db->get_compiled_select().') as "AUX"';
		  $this->db->where('AUX.cantidad_disponible < AUX.punto_pedido');
		  $this->db->from($sql);
		  $data = $this->db->get()->result_array();
		 // var_dump($data);die;
		  return $data;
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
		return $this->db->insert('alm.alm_lotes',$aux);
	}

	public function verificarExistencia($arti, $lote, $depo)
	{
		$this->db->where('codigo',$lote);
		$this->db->where('depo_id',$depo);
		$this->db->where('arti_id',$arti);
		$this->db->where('empr_id', empresa());
		return $this->db->get('alm.alm_lotes')->num_rows()>0?1:0;
	}
	
	public function extraerCantidad($data)
	{
		$url = RESTPT . 'extraer_cantidad_lote';
		$rsp = file_get_contents($url, false, http('POST', ['post_extraer_cantidad_lote' => $data]));
		$rsp = rsp($http_response_header, false, $rsp);
		return $rsp;
	}

	public function crear($data)
	{
		$url = RESTPT . 'lotes/movimiento_stock';
		$rsp = file_get_contents($url, false, http('POST', ['post_lotes_movimiento_stock' => $data]));
		$rsp =  rsp($http_response_header, false, $rsp);
		return $rsp;
	}

	public function crearBatch($data)
    {
        // $aux["p_lote_id"] = strval($data['lote_id']);
		// $aux["p_batch_id_padre"] = strval($data['batch_id']);
		// $aux["p_num_orden_prod"] = "";
		// $aux["p_etap_id"] = strval(ETAPA_TRANSPORTE);
		// $aux["p_usuario_app"] = userNick();
		// $aux["p_reci_id"] = strval($data['reci_id']);
		// $aux["p_empr_id"] = strval(empresa());
		// $aux["p_forzar_agregar"] = "FALSE";
		
		$aux["lote_id"] =strval( $data->id);
		$aux["arti_id"] = strval($data->producto);
		$aux["prov_id"] = strval($data->prov_id);
		$aux["batch_id_padre"] = strval($data->batch_id);
		$aux["cantidad"] = strval($data->cantidad);
		$aux["cantidad_padre"] = strval($data->stock);
		$aux["num_orden_prod"] = "";
		$aux["reci_id"] = strval($data->reci_id);
		$aux["etap_id"] = strval(ETAPA_DEPOSITO);
		$aux["usuario_app"] =  userNick();
		$aux["empr_id"] = strval(empresa());
		$aux["forzar_agregar"] =  isset($data->forzar_agregar)?$data->forzar_agregar:"FALSE";
		$aux["fec_vencimiento"] = date('d-m-Y');
        
        $url = REST_TDS.'lote';
		$rsp = $this->rest->callApi('POST', $url,['post_lote'=>$aux]);
		if($rsp['status']) $rsp['data'] = json_decode($rsp['data'])->respuesta->resultado;
		if(!is_numeric($rsp['data'])){
			$rsp['status'] = false;
		}
		return $rsp;
	}

	public function guardarCargaCamion($data)
	{
		$aux["batch_id_origen"] = strval($data->batch_id);
		$aux["reci_id"] = strval($data->reci_id);
		$aux["etap_id_deposito"]= strval(ETAPA_DEPOSITO);
		$aux["empre_id"]= strval(empresa());
		$aux["usuario_app"]= "chuck";
		$aux["forzar_agregar"]= "false";

		$url = REST_TDS.'lote/recipiente/cambiar';
		$rsp = $this->rest->callApi('POST',$url, ['post_lote_recipiente_cambiar'=>$aux]);
		if(!$rsp['status']) return $rsp;
		$rsp['data'] = json_decode($rsp['data'])->respuesta->resultado;
	##	log_message('DEBUG', '#MODEL > guardaCargaCamion | RSP: '.json_encode($rsp));
		$rsp['status'] = ($rsp['data'] == 'CORRECTO');  

		return $rsp;

	}
}