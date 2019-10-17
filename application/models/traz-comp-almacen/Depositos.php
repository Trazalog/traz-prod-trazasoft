<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Depositos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener($id = false)
    {
        if($id) $this->db->where('depo_id', $id);
        return $this->db->get('alm_depositos')->result();
    }
}
