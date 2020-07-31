<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ordeninsumos extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getList()
    {
        $empresaId = empresa();

        $this->db->select('A.enma_id as id_orden,C.ortr_id as id_ot, A.fecha, A.solicitante, A.comprobante');
        $this->db->from('asset_almacen_v3.alm.alm_entrega_materiales A');
        //$this->db->join('alm.alm_deta_entrega_materiales B', 'B.enma_id = A.enma_id');
        $this->db->join('asset_almacen_v3.alm.alm_pedidos_materiales C','C.pema_id = A.pema_id');
      //  $this->db->where('A.empr_id', $empresaId);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data['openBox'] = 1;
            $data['data'] = $query->result_array();
            return $data;
        } else { $data['openBox'] = 1;
            return $data;
        }
    }

    public function getcodigo()
    {
        $empresaId = empresa();
        $this->db->select('alm.alm_articulos.arti_id as artId ,alm.alm_lotes.lote_id as loteid,alm.alm_articulos.barcode as artBarCode, alm.alm_articulos.descripcion as artDescription');

        $this->db->from('alm.alm_articulos');
        $this->db->join('alm.alm_lotes ', 'alm.alm_lotes.arti_id = alm.alm_articulos.arti_id');
        $this->db->join('alm.alm.utl_tablas', 'alm.alm.utl_tablas.tabl_id = alm.alm_lotes.estado_id');
        $this->db->where('alm.alm_lotes.arti_id = alm.alm_articulos.arti_id');
        $this->db->where('alm.alm_articulos.empr_id', $empresaId);
        $this->db->group_by('alm.alm_lotes.arti_id');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getsolicitante()
    {
        $empresaId = empresa();

        $this->db->select('id_solicitud, solicitante');
        $this->db->from('solicitud_reparacion');
        $this->db->where('id_empresa', $empresaId);
        $this->db->group_by('solicitante');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // devuelve las ot de la empresa y que esten curso o asignadas
    public function getOT()
    {
        $empresaId = empresa();

        $this->db->select('orden_trabajo.id_orden, orden_trabajo.descripcion');
        $this->db->from('orden_trabajo');
        $this->db->where('orden_trabajo.id_empresa', $empresaId); //de la empresa
        $this->db->where('orden_trabajo.estado', 'C'); //que estan en curso
        $this->db->or_where('orden_trabajo.estado', 'AS'); //que asignadas

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getdescrip($data = null)
    {
        if ($data == null) {
            return false;
        } else {
            $id = $data['arti_id'];
            //Datos del usuario
            $query = $this->db->get_where('alm.alm_articulos', array('arti_id' => $id));
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }

    public function insert_orden($data)
    {
        $data['empr_id'] = empresa();
        $query = $this->db->insert("alm.alm_entrega_materiales", $data);
        return $query;
    }

    public function insert_entrega_materiales($form)
    {
       
        $data['empr_id'] = empresa();
        
        //CABECERA ENTREGA
        $info = json_decode($form['info_entrega'],true); 
        
        $info['empr_id'] = $data['empr_id'];

        //DETALLE ENTREGA
        $detalle = $form['detalles'];

        //CANTIDADEES PARA ACTUALZAR NOTA PEDIDOS
        $cantidades = $form['cantidades'];

        //INSERTAR EN CABECERA ENTREGA
        $query = $this->db->insert("alm.alm_entrega_materiales", $info);
        $id = $this->db->insert_id();

        //VALIDAR INSERCION
        if (!$id) return false;

        //PREPARO INSERCION DETALLES
        foreach ($detalle as $key => $o) {
            $detalle[$key]['enma_id'] = $id;
        }

        //INSERTAR DETALLES
        $this->db->insert_batch('alm.alm_deta_entrega_materiales', $detalle);
        $this->actualizar_lote($detalle);
        $this->actualizar_entregas($info['pema_id'], $cantidades);

    }

    public function actualizar_entregas($pema, $cantidades)
    {
        foreach ($cantidades as $o) {
            $this->db->where('pema_id', $pema);
            $this->db->where('arti_id', $o['arti_id']);
            $this->db->set('resto', $o['resto']);
            $this->db->update('alm.alm_deta_pedidos_materiales');
        }
   
    }

    public function actualizar_lote($detalle)
    {
        foreach ($detalle as $o) {
            $this->db->set('cantidad', 'cantidad - ' . $o['cantidad'], false);
            $this->db->where('lote_id', $o['lote_id']);
            $this->db->update('alm.alm_lotes');
        }

    }

    public function get_detalle_entrega($pema)
    {
        // FILTRAR ARTICULOS PEDIDO MATERIALES
        $this->db->select('ART.arti_id, ART.barcode, ART.descripcion, PEMA.cantidad as cant_pedida, sum("LOTE".cantidad) as cantidad_stock');
        $this->db->from('alm.alm_deta_pedidos_materiales as PEMA');
        $this->db->join('alm.alm_articulos as ART', 'ART.arti_id = PEMA.arti_id');
        $this->db->join('alm.alm_lotes as LOTE','LOTE.arti_id = ART.arti_id', 'left');
        $this->db->where('pema_id', $pema);
        $this->db->where('ART.empr_id', empresa());
        $this->db->group_by('ART.arti_id, PEMA.cantidad');
        $A = '(' . $this->db->get_compiled_select() . ') as "A"';

        // SUMAR ENTREGAS
        $this->db->select('DEEN.arti_id, sum(cantidad) as cant_entregada');
        $this->db->from('alm.alm_entrega_materiales as ENMA');
        $this->db->join('alm.alm_deta_entrega_materiales as DEEN', 'DEEN.enma_id = ENMA.enma_id');
        $this->db->where('ENMA.pema_id', $pema);
        $this->db->group_by('DEEN.arti_id');
        $B = '(' . $this->db->get_compiled_select() . ') as "B"';

        // OBTENER EXISTENCIAS
        $this->db->select('A.barcode, A.descripcion, A.arti_id, A.cant_pedida, COALESCE(cantidad_stock,0) as cant_disponible, COALESCE("B".cant_entregada,0) as cant_entregada');
        $this->db->from($A);
        $this->db->join($B, 'B.arti_id = A.arti_id', 'left');

        //echo var_dump($this->db->get()->result_array());die;
        return $this->db->get()->result_array();
    }

    public function insert_detaordeninsumo($data2)
    {
        $data2['empr_id'] = empresa();
        $query = $this->db->insert("alm.alm_deta_entrega_materiales", $data2);
        return $query;
    }

    public function getdeposito($data = null)
    {
        if ($data == null) {
            return false;
        } else {
            $empresaId = empresa();
            $id = $data['artId'];

            $this->db->select('alm.alm_articulos.arti_id as artId, alm.alm_depositos.depo_id as depositoId, alm.alm_depositos.descripcion as depositodescrip');
            $this->db->from('alm.alm_articulos');
            $this->db->join('alm.alm_lotes', 'alm.alm_lotes.arti_id = alm.alm_articulos.arti_id');
            $this->db->join('alm.alm_depositos', 'alm.alm_depositos.depo_id = alm.alm_lotes.depo_id');
            $this->db->where('alm.alm_lotes.arti_id', $id);
            $this->db->where('alm.alm_lotes.empr_id', $empresaId);

            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }

    public function getlotecant($id)
    {
        $sql = "SELECT  alm.alm_lotes.cantidad
    	FROM alm.alm_lotes
    	WHERE alm.alm_lotes.depo_id=$id AND alm.alm_lotes.lotestado='AC'
    	";
        $query = $this->db->query($sql);

        $i = 0;
        foreach ($query->result_array() as $row) {

            $datos[$i] = $row['cantidad'];
            $i++;
        }

        return $datos;
    }

    public function lote($idarticulo, $cantidadOrdenInsumo, $iddeposito)
    {
        $result = $this->traeIdLote($idarticulo, $iddeposito);

        $idLote = $result[0]["loteid"];
        if ($idLote != 0) {
            $cantidadLote = $this->lotecantidad($idLote); //obtengo la cantidad segun el lote
            //dump($cantidadLote);
        } else {
            echo "No hay insumos";
        }
        if ($cantidadLote >= $cantidadOrdenInsumo) {
            $res = $cantidadLote - $cantidadOrdenInsumo;
        } else {
            echo "No hay insumos suficientes";
            //$res=$cantidadOrdenInsumo - $cantidadLote;
        }

        $datos3 = array(
            'cantidad' => $res,
        );
        //dump($datos3);

        $this->update_tbllote($idLote, $datos3);
        return $idLote;
    }

    public function traeIdLote($idarticulo, $iddeposito)
    {
        $this->db->select('alm.alm_lotes.lote_id as loteid');
        $this->db->from('alm.alm_lotes');
        $this->db->where('alm.alm_lotes.arti_id', $idarticulo);
        $this->db->where('alm.alm_lotes.depo_id', $iddeposito);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function lotecantidad($v)
    {
        $sql = "SELECT alm.alm_lotes.cantidad
			FROM alm.alm_lotes
			WHERE alm.alm_lotes.lote_id = $v";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $datos = $row->cantidad;
        }
        return $datos;
    }

    public function update_tbllote($id, $data3)
    {
        $this->db->where('lote_id', $id);
        $query = $this->db->update("alm.alm_lotes", $data3);
        return $query;
    }

    public function alerta($codigo, $de)
    {
        $sql = "SELECT alm.alm_lotes.cantidad
			FROM alm.alm_lotes
			WHERE alm.alm_lotes.arti_id=$codigo AND alm.alm_lotes.depo_id=$de
			";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $datos = $row->cantidad;
        }
        return $datos;
    }

    public function getsolImps($id)
    {

        $sql = "SELECT T.fecha,T.solicitante,T.comprobante, A.cantidad
                  FROM alm.alm_entrega_materiales T
                  JOIN alm.alm_deta_entrega_materiales A ON A.enma_id=T.enma_id
                  WHERE T.ortr_id=$id
              ";

        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {

            $data['fecha'] = $row['fecha'];
            $data['solicitante'] = $row['solicitante'];
            $data['comprobante'] = $row['comprobante'];
            $data['cantidad'] = $row['cantidad'];

            return $data;
        }
    }

    public function getequiposBycomodato($id)
    {

        $sql = "SELECT alm.alm_deta_entrega_materiales.loteid, alm.alm_deta_entrega_materiales.cantidad, alm.alm_deta_entrega_materiales.enma_id as ortr_idinsumo, alm.alm_lotes.arti_id, alm.alm_articulos.artBarCode, alm.alm_articulos.artDescription
                FROM alm.alm_deta_entrega_materiales

                JOIN alm.alm_lotes ON alm.alm_lotes.loteid = alm.alm_deta_entrega_materiales.loteid
                JOIN alm.alm_articulos ON alm.alm_articulos.arti_id= alm.alm_lotes.arti_id
                WHERE alm.alm_deta_entrega_materiales.enma_id=$id
                    ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getConsult($id)
    {
        $sql = "SELECT *
            FROM alm.alm_entrega_materiales
            JOIN alm.alm_deta_entrega_materiales ON alm.alm_deta_entrega_materiales.enma_id = alm.alm_entrega_materiales.enma_id
            JOIN alm.alm_lotes ON alm.alm_lotes.lote_id = alm.alm_deta_entrega_materiales.lote_id
            WHERE alm.alm_entrega_materiales.enma_id = $id
            ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getequipos($id)
    {
        $empresaId = empresa();
        $sql = "SELECT T.deen_id as id_detaordeninsumo, T.enma_id as ortr_idinsumo, T.lote_id as loteid, T.cantidad, alm.alm_lotes.codigo, alm.alm_lotes.depo_id, art.arti_id, art.barcode as artBarCode, art.descripcion as artDescription, alm.alm_depositos.descripcion as depositodescrip
    		FROM alm.alm_deta_entrega_materiales T
			JOIN alm.alm_lotes ON alm.alm_lotes.lote_id = T.lote_id
			JOIN alm.alm_articulos art ON art.arti_id = alm.alm_lotes.arti_id
			JOIN alm.alm_depositos ON alm.alm_depositos.depo_id = alm.alm_lotes.depo_id
			WHERE T.enma_id = $id
            AND T.empr_id = $empresaId
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function total($id)
    {
        $empresaId = empresa();

        $sql = "SELECT SUM(alm.alm_deta_entrega_materiales.cantidad) as cantidad
    		FROM alm.alm_deta_entrega_materiales
			JOIN alm.alm_entrega_materiales ON alm.alm_entrega_materiales.enma_id = alm.alm_deta_entrega_materiales. enma_id
			WHERE alm.alm_deta_entrega_materiales.enma_id = $id
            AND alm.alm_deta_entrega_materiales.empr_id = $empresaId
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

}
