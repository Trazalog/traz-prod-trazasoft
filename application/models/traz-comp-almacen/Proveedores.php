<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}

class Proveedores extends CI_Model {

    public function __construct() {
        
        parent:: __construct();

    }

    public function obtener($id = false)
    {
        if($id) $this->db->where('prov_id', $id);
        $this->db->where('empr_id', empresa());
        return $this->db->get('alm.alm_proveedores')->result();
    }
}
?>