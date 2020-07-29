<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Articulos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function obtenerXTipo($tipo)
	{
		$resource = "/articulos/tipo/$tipo";
        $url = REST2 . $resource;
        $rsp = $this->rest->callAPI("GET", $url);
        if($rsp['status']){
            $rsp['data'] = json_decode($rsp['data'])->articulos->articulo;
        }
        return $rsp;
	}

	public function obtenerXTipos($tipos)
	{
		$res = [];
		foreach ($tipos as $o) {
			$aux = $this->obtenerXTipo($o);
			$res = array_merge(($aux['status']?$aux['data']:[]), $res);
		}
		return $res;
	}

	function getList()
	{
		$this->db->select('A.*, coalesce(sum(cantidad),0) as stock, T.valor');
		$this->db->from('alm.alm_articulos A');
		$this->db->join('alm.alm_lotes C', 'C.arti_id = A.arti_id', 'left');
		$this->db->join('core.tablas T', 'A.tipo = T.tabl_id', 'left');
		$this->db->where('A.empr_id', empresa());
		$this->db->where('A.eliminado', false);
		$this->db->group_by('A.arti_id, T.valor');


		$query = $this->db->get();


		if ($query && $query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	public function guardar($data)
	{
		$data['es_caja'] = isset($data['cantidad_caja']);
		$data['es_loteado'] = isset($data['es_loteado']);
		$data['empr_id'] = empresa();
		$this->db->insert('alm.alm_articulos', $data);
		return $this->db->insert_id();
	}

	public function editar($data)
	{
		$this->db->where('arti_id', $data['arti_id']);
		return $this->db->update('alm.alm_articulos', $data);
	}

	function get($id)
	{
		$this->db->where('arti_id', $id);
		return $this->db->get('alm.alm_articulos')->row_array();
	}

	function getLotes($id)
	{
		$this->db->where('arti_id', $id);
		$this->db->select('*');
		$this->db->from('alm.alm_lotes T');
		$this->db->join('alm.alm_depositos A', 'T.depo_id = A.depo_id');
		return $this->db->get()->result_array();
	}

	function getpencil($id) // Ok
	{
		$empresaId = empresa();

		$this->db->select('A.*, B.tabl_id as unidadmedida,B.descripcion as unidad_descripcion');
		$this->db->from('alm.alm_articulos A');
		$this->db->join('alm.alm.utl_tablas B', 'A.unidad_id = B.tabl_id', 'left');
		$this->db->where('arti_id', $id);
		$this->db->where('empr_id', $empresaId);



		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return 0;
		}
	}

	function eliminar($id)
	{
		$this->db->where('arti_id', $id);
		$this->db->set('eliminado', true);
		return $this->db->update('alm.alm_articulos');
	}

	function getUnidadesMedidas()
	{
		$this->db->select('A.tabl_id as id_unidadmedida, A.descripcion, A.valor');
		$this->db->where('tabla', 'unidad');
		$query  = $this->db->get('alm.alm.utl_tablas A');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function getUM()
	{
		$this->db->select('A.tabl_id as id_unidadmedida, A.descripcion, A.valor');
		$this->db->where('tabla', 'unidades_medida');
		$query  = $this->db->get('alm.utl_tablas A');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	function getArticle($data = null)
	{

		if ($data == null || strpos('Add', $data['act']) == 0) {
			return false;
		} else {
			$empresaId = empresa();
			$action    = $data['act'];
			$idArt     = $data['id'];
			$data      = array();

			$this->db->select('A.*,B.valor as unidad');
			$this->db->from('alm.alm_articulos A');
			$this->db->join('alm.alm.utl_tablas B', 'A.unidad_id = B.tabl_id');
			$this->db->join('alm.alm.utl_tablas C', 'A.estado_id = C.tabl_id');
			$this->db->where('C.valor', 'AC');

			$query = $this->db->get();

			if ($query->num_rows() != 0) {
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
			if ($action == 'Del' || $action == 'View') {
				$readonly = true;
			}
			$data['read']   = $readonly;
			$data['action'] = $action;


			return $data;
		}
	}

	function setArticle($data = null)
	{
		if ($data == null) {
			return false;
		} else {
			$empresaId = empresa();
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

			switch ($act) {
				case 'Add':
					if ($this->db->get_where('alm.alm_articulos', ['barcode' => $code, 'empr_id' => $empresaId])->num_rows() > 0) return false;

					if ($this->db->insert('alm.alm_articulos', $data)) {
						return $this->db->insert_id();
					}
					break;
				case 'Edit':
					//Actualizar Artículo
					if ($this->db->update('alm.alm_articulos', $data, array('artId' => $id)) == false) {
						return false;
					}
					break;
				case 'Del':
					//Eliminar Artículo
					if ($this->db->delete('alm.alm_articulos', array('artId' => $id)) == false) {
						return false;
					}
					break;
			}
			return true;
		}
	}

	function getdatosfams()
	{
		$empresaId = empresa();
		$query     = $this->db->get_where('conffamily', array('id_empresa' => $empresaId));
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function update_articulo($data, $idarticulo)
	{
		$empresaId          = empresa();
		$data['id_empresa'] = $empresaId;
		$this->db->where('artId', $idarticulo);
		$query = $this->db->update("articles", $data);
		return $query;
	}



	function update_editar($data, $id)
	{
		$this->db->where('arti_id', $id);
		$query = $this->db->update("alm.alm_articulos", $data);
		return $query;
	}

	function searchByCode($data = null)
	{
		$str = '';
		if ($data != null) {
			$str = $data['code'];
		}

		$articles = array();

		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where(array('artBarCode' => $str, 'artEstado' => 'AC'));
		$query = $this->db->get();
		if ($query->num_rows() != 0) {
			if ($query->num_rows() > 1) {
				//Multiples coincidencias
			} else {
				//Unica coincidencia
				$a = $query->result_array();
				$articles = $a[0];

				//Calcular precios 
				$pUnit = $articles['artCoste'];
				if ($articles['artIsByBox'] == 1) {
					$pUnit = $articles['artCoste'] / $articles['artCantBox'];
				}

				if ($articles['artMarginIsPorcent'] == 1) {
					$articles['pVenta'] = $pUnit + ($pUnit * ($articles['artMargin'] / 100));
				} else {
					$articles['pVenta'] = $pUnit + $articles['artMargin'];
				}
			}
			return $articles;
		}

		return $articles;
	}

	function searchByAll($data = null)
	{
		$str = '';
		if ($data != null) {
			$str = $data['code'];
		}

		$art = array();

		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('artEstado', 'AC');
		if ($str != '') {
			$this->db->like('artBarCode', $str);
			$this->db->or_like('artDescription', $str);
		}
		$query = $this->db->get();
		if ($query->num_rows() != 0) {
			foreach ($query->result_array() as $a) {
				$articles = $a;

				//Calcular precios 
				$pUnit = $articles['artCoste'];
				if ($articles['artIsByBox'] == 1) {
					$pUnit = $articles['artCoste'] / $articles['artCantBox'];
				}

				if ($articles['artMarginIsPorcent'] == 1) {
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
		$empresaId = empresa();

		$this->db->select('articles.artEstado, tbl_estado.estadoid, tbl_estado.descripcion');
		$this->db->from('articles');
		$this->db->join('tbl_estado', 'tbl_estado.estado = articles.artEstado');
		$this->db->where('articles.id_empresa', $empresaId);
		$this->db->group_by('articles.artEstado');
		$query = $this->db->get();
		if ($query->num_rows() != 0) {
			return $query->result_array();
		} else {
			return array();
		}
	}

	public function getArtiService()
	{
		$url =  REST . 'articulos';
		$data = $this->rest->callApi('GET', $url);
		if ($data['status']) {
			$data['data'] = json_decode($data['data'])->materias->materia;
		}
		return $data['data'];
	}
}
