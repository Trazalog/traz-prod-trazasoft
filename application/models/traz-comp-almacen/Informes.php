<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Informes extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function loteStock()
    {
        $this->db->select('codigo, arti_id, sum(cantidad) as stock');
        $this->db->group_by('codigo, arti_id');
        $this->db->where('empr_id', empresa());
        return $this->db->get('alm_lotes')->result();
    }
}
