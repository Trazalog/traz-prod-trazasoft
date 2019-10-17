<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Notapedidos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setMotivoRechazo($pema, $motivo)
    {

        $this->db->where('pema_id', $pema);
        $this->db->set('motivo_rechazo', $motivo);
        return $this->db->update('alm_pedidos_materiales');

    }

    public function notaPedidos_List($ot = null)
    {
        $this->db->select('T.pema_id as id_notaPedido,T.fecha,T.ortr_id as id_ordTrabajo,T.justificacion, T.estado');
        if($ot) $this->db->select('orden_trabajo.descripcion');
        $this->db->from('alm_pedidos_materiales as T');
        if($ot) $this->db->join('orden_trabajo', 'T.ortr_id = orden_trabajo.id_orden','left');
        $this->db->where('T.empr_id', empresa());
        if($ot)  $this->db->where('orden_trabajo.id_orden', $ot);
        $query = $this->db->get();

        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function get($id)
    {
        $this->db->where('pema_id', $id);
        return $this->db->get('alm_pedidos_materiales')->row_array();
    }

    public function getXCaseId($case)
    {
        $this->db->where('case_id', $case);
        return $this->db->get('alm_pedidos_materiales')->row_array();
    }

    public function setCaseId($id, $case)
    {
        $this->db->set('case_id', $case);
        $this->db->set('estado', $case?'Solicitado':'Reintentar');
        $this->db->where('pema_id', $id);
        $this->db->update('alm_pedidos_materiales');
    }

    //
    public function getNotasxOT($id)
    {
        $userdata = $this->session->userdata('user_data');
        $empId = empresa();
        $this->db->select('
            alm_pedidos_materiales.pema_id as id_notaPedido,
            alm_pedidos_materiales.fecha,
            alm_pedidos_materiales.ortr_id as id_ordTrabajo,
            solicitud_reparacion.solicitante,
            orden_trabajo.descripcion
        ');
        $this->db->from('alm_pedidos_materiales');
        $this->db->join('orden_trabajo', 'alm_pedidos_materiales.ortr_id = orden_trabajo.id_orden');
        $this->db->join('solicitud_reparacion', 'orden_trabajo.id_solicitud = solicitud_reparacion.id_solicitud', 'left');
        $this->db->where('alm_pedidos_materiales.empr_id', $empId);
        $this->db->where('orden_trabajo.id_orden', $id);

        $query = $this->db->get();

        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    // Trae lista de articulos por id de nota de pedido
    public function getNotaPedidoIds($id)
    {

        $this->db->select('alm_pedidos_materiales.pema_id as id_notaPedido,
                          alm_pedidos_materiales.fecha,
                          alm_pedidos_materiales.ortr_id as id_ordTrabajo,
                          alm_pedidos_materiales.justificacion,
                          alm_deta_pedidos_materiales.cantidad,
                          (alm_deta_pedidos_materiales.cantidad - alm_deta_pedidos_materiales.resto) as entregado,
                          alm_deta_pedidos_materiales.fecha_entrega,
                          alm_deta_pedidos_materiales.fecha_entregado,
                          alm_articulos.barcode,
                          alm_articulos.arti_id,
                          alm_articulos.descripcion as artDescription,
                          alm_deta_pedidos_materiales.depe_id'
        );

        if(viewOT)$this->db->select('orden_trabajo.descripcion');
        $this->db->from('alm_pedidos_materiales');
        if(viewOT)$this->db->join('orden_trabajo', 'alm_pedidos_materiales.ortr_id = orden_trabajo.id_orden','left');
        $this->db->join('alm_deta_pedidos_materiales', 'alm_deta_pedidos_materiales.pema_id = alm_pedidos_materiales.pema_id');
        $this->db->join('alm_articulos', 'alm_deta_pedidos_materiales.arti_id = alm_articulos.arti_id');
        $this->db->where('alm_pedidos_materiales.pema_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getArticulos()
    {
        $query = $this->db->query("SELECT alm_articulos;.artId, alm_articulos;.artBarCode,alm_articulos;.artDescription FROM alm_articulos;");
        $i = 0;
        foreach ($query->result() as $row) {

            $insumos[$i]['value'] = $row->artId;
            $insumos[$i]['label'] = $row->artBarCode;
            $insumos[$i]['descripcion'] = $row->artDescription;
            $i++;
        }
        return $insumos;
    }

    public function getProveedores()
    {

        $this->db->select('alm_proveedores.provid, alm_proveedores.provnombre');
        $this->db->from('alm_proveedores');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {

            return $query->result_array();
        }
    }

    public function setNotaPedidos($data)
    {
        $userdata = $this->session->userdata('user_data');
        $empId = empresa();

        $orden = (int) $data['orden_Id'][0];
        $notaP = array(
            'fecha' => date('Y-m-d H:i:s'),
            'empr_id' => $empId,
        );

        if($orden) $notaP['ortr_id'] =  $orden;
        $this->db->insert('alm_pedidos_materiales', $notaP);
        $idNota = $this->db->insert_id();

        for ($i = 0; $i < count($data['insum_Id']); $i++) {

            $insumo = $data['insum_Id'][$i];
            $cant = $data['cant_insumos'][$i];
            $proveed = $data['proveedid'][$i];
            $date = $data['fechaentrega'][$i];
            $newDate = date("Y-m-d", strtotime($date));

            $nota = array(
                'pema_id' => $idNota,
                'arti_id' => $insumo,
                'cantidad' => $cant,
                'resto' => $cant,
                'prov_id' => $proveed,
                'fechaEntrega' => $newDate,
                'fechaEntregado' => $newDate,
            );
            $this->db->insert('alm_deta_pedidos_materiales', $nota);
        }

        if ($this->db->trans_status() === false) {
            return false;
        } else {
            return true;
        }

    } // fin setNotaPedidos

    // devuelve plantilla por Id de cliente
    public function getPlantillaPorCliente($idcliente)
    {
        //FIXME: DESHARDCODEAR ESTE CLIENTE!!!!
        $idcliente = 21;
        $this->db->select('asp_detaplantillainsumos.artId,
												alm_articulos;.artDescription,
												asp_plantillainsumos.plant_id');
        $this->db->from('asp_detaplantillainsumos');
        $this->db->join('asp_plantillainsumos', 'asp_detaplantillainsumos.plant_id = asp_plantillainsumos.plant_id');
        $this->db->join('alm_articulos;', 'alm_articulos;.artId = asp_detaplantillainsumos.artId');
        $this->db->join('admcustomers', 'asp_plantillainsumos.plant_id = admcustomers.plant_id');
        $this->db->where('admcustomers.plant_id', '(SELECT admcustomers.plant_id WHERE admcustomers.cliId = ' . $idcliente . ')', false);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    // guarda nota pedido (desde tareas de bpm)
    public function setCabeceraNota($cabecera)
    {
        $cabecera['ortr_id'] = (int)$cabecera['ortr_id'];
        $this->db->insert('alm_pedidos_materiales', $cabecera);
        $idInsert = $this->db->insert_id();
        return $idInsert;
    }
    // guarda detalle nota pedido (desde tareas de bpm)
    public function setDetaNota($deta)
    {
        foreach ($deta as $o) {
            $o['resto'] = $o['cantidad'];
            if($this->db->get_where('alm_deta_pedidos_materiales',array('pema_id'=>$o['pema_id'],'arti_id'=>$o['arti_id']))->num_rows()==1){
                
                $this->db->where(array('pema_id'=>$o['pema_id'],'arti_id'=>$o['arti_id']));
                $this->db->update('alm_deta_pedidos_materiales', $o);
                
            }else{
                $this->db->insert('alm_deta_pedidos_materiales', $o);
            }
        }
        return true;
    }

    public function editarDetalle($id, $data)
    {
        $this->db->where('depe_id', $id);
        $data['resto'] = $data['cantidad'];
        return $this->db->update('alm_deta_pedidos_materiales',$data);
    }

    public function eliminarDetalle($id)
    {
        $this->db->where('depe_id', $id);
        return $this->db->delete('alm_deta_pedidos_materiales');
    }

}
