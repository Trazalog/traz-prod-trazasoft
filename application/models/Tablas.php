<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Tablas extends CI_Model
{

    public function __construct()
    {

        parent::__construct();
    }

    public function obtener($id = false)
    {
        if ($id) {
            $this->db->where('tabla', $id);
        }
        $this->db->where('eliminado',false);
        return $this->db->get('utl_tablas')->result();
    }
}
