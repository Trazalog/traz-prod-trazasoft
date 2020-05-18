<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Tablas extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerTabla($tabla)
    {
        $url = RESTPT . "tablas/$tabla";
        $rsp = $this->rest->callApi('GET', $url);
        if($rsp['status']) $rsp['data'] = json_decode($rsp['data'])->tablas->tabla;
        return $rsp;
    }

    public function obtener($id = false)
    {
        if ($id) {
            $this->db->where('tabla', $id);
        }
        $this->db->where('eliminado',false);
        return $this->db->get('alm.utl_tablas')->result();
    }
}
