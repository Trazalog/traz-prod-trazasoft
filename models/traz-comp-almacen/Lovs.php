<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lovs extends CI_Model {

	function __construct()
	{
		parent::__construct();
    }
    
    public function lista($grupo)
    {
        $this->db->select('*');
        $this->db->from('alm.alm.utl_tablas');
        $this->db->where('tabla', $grupo);
        $this->db->where('eliminado',false);
        return $this->db->get()->result_array();
    }

    public function obtener($id)
    {
        $this->db->select('*');
        $this->db->from('alm.alm.utl_tablas');
        $this->db->where('tabl_id', $id);
        $this->db->where('eliminado',false);
        return $this->db->get()->result_array();
    }
    public function crear($data)
    {
        return $this->db->insert('alm.alm.utl_tablas', $data);
    }

    public function modificar($data)
    {
        $this->db->where('tabl_id', $data['tabl_id']);
        return $this->db->update('alm.alm.utl_tablas', $data);
    }

    public function eliminar($id)
    {
        $this->db->where('tabl_id', $id);
        $this->db->set('eliminado',true);
        return $this->db->update('alm.alm.utl_tablas');
    }

}
