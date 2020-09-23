<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Model {

	function __construct()
	{
        parent::__construct();
	}
	
	function getRepOrdServicio($data)
    {
        $empresaId = empresa();
        
		if (($data['desde'] !== "") || ($data['hasta'] !== "")) {
            $datDesde = $data['desde'];
            $datDesde = explode('-', $datDesde);
            $desde    = $datDesde[2].'-'.$datDesde[1].'-'.$datDesde[0];
            $datHasta = $data['hasta'];
            $datHasta = explode('-', $datHasta);
            $hasta    = $datHasta[2].'-'.$datHasta[1].'-'.$datHasta[0];
		}
        $id_equipo = $data['id_equipo'];
        $id_sector = $data['id_sector'];
        $this->db->select('solicitud_reparacion.*,
            equipos.codigo as equipo, 
            sector.descripcion as sector, 
            grupo.descripcion as grupo, 
            equipos.ubicacion');
        $this->db->from('solicitud_reparacion');
        $this->db->join('equipos', 'solicitud_reparacion.id_equipo = equipos.id_equipo');
        $this->db->join('sector', 'equipos.id_sector = sector.id_sector');
        $this->db->join('grupo', 'equipos.id_grupo = grupo.id_grupo');
        
        if ($id_sector !== "") {
            $this->db->where('sector.id_sector', $id_sector);
        }
        if ($id_equipo !== "") {
            $this->db->where('equipos.id_equipo', $id_equipo);
        }
        if ($data['desde'] || $data['hasta'] !== "") {
            $this->db->where('solicitud_reparacion.f_solicitado >=', $desde);
            $this->db->where('solicitud_reparacion.f_solicitado <=', $hasta);
        }
        //$this->db->where('solicitud_reparacion.estado', 'C');
        $this->db->where('solicitud_reparacion.id_empresa', $empresaId);
        $query = $this->db->get();
        if ($query->num_rows()!=0)
        {
            //dump_exit($query->result_array());
            return $query->result_array();  
        }
        else
        {   
            return array();
        }  
    }

}
