<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedidoextra extends CI_Model {
	function __construct()
	{
		parent::__construct();
    }	
    
    public function set($data)
    {
        return $this->db->insert('alm.alm_pedidos_extraordinario', $data);
    }

    public function get($id)
    {
        $this->db->where('peex_id', $id);
        return $this->db->get('alm.alm_pedidos_extraordinario')->row_array();
    }

    public function setCaseId($id,$case)
    {
        $this->db->set('case_id', $case);
        $this->db->where('peex_id', $id);
        return $this->db->update('alm.alm_pedidos_extraordinario');
    }

    public function setMotivoRechazo($id, $motivo)
    {
        $this->db->set('motivo_rechazo', $motivo);
        $this->db->where('peex_id', $id);
        return $this->db->update('alm.alm_pedidos_extraordinario');
    }

    public function getXCaseId($id)
    {
        $this->db->where('case_id', $id);
        return $this->db->get('alm.alm_pedidos_extraordinario')->row_array();
    }

    public function setPemaId($id, $pema)
    {
        $this->db->where('peex_id', $id);
        $this->db->set('pema_id', $pema);
        return $this->db->update('alm.alm_pedidos_extraordinario');
    }
}
