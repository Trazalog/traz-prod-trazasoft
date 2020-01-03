<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Opciones_Filtros extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function ejemplo($valores)
    {

        // $res =  new StdClass(); //creamos un objeto genérico vacío

        // $this->db->select('EQ.codigo as descripcion');
        // $this->db->where('id_empresa', $empId);
        // $res->equipos = $this->db->get('equipos EQ')->result();

        // $this->db->select('A.descripcion');
        // $this->db->where('id_empresa', $empId);
        // $res->areas = $this->db->get('area A')->result();

        // $this->db->select('G.descripcion');
        // $this->db->where('id_empresa', $empId);
        //  $res->grupos = $this->db->get('grupo G')->result();

        // $this->db->select('S.descripcion');
        // $this->db->where('id_empresa', $empId);
        // $res->sectores = $this->db->get('sector S')->result();

        // $this->db->select('TO.descripcion');
        // $res->origenes = $this->db->get('tbl_tipoordentrabajo TO')->result();

        // $this->db->select('valor');
        // $this->db->where('tabla', 'unidades_medida');
        // $res->unidad_medida = $this->db->get("alm.utl_tablas")->result_array();
        // $res = $this->db->get('alm.utl_tablas');
        // var_dump($res);
        // $res = '10';
        // return $res;
        $res =  new StdClass(); //creamos un objeto genérico vacío
        // $rsp = $this->rest->callApi('GET', $url);
        // if ($rsp['status']) {
        //     $json = json_decode($rsp['data']);
        // }
        $res->unidad = $valores['unidades_medida'];
        $res->estado = $valores['estados'];

        return $res;
    }

    public function filtrosProduccion($valores)
    {
        $res =  new StdClass();
        $res->producto = $valores['productos'];
        // $res->unidad = $valores['unidades_medida'];
        $res->etapa = $valores['etapas'];
        // $res->responsable = $valores['responsables'];

        return $res;
    }

    public function filtrosProdResponsable($valores)
    {
        $res =  new StdClass();
        $res->responsable = $valores['responsables'];
        $res->producto = $valores['productos'];
        // $res->unidad = $valores['unidades_medida'];
        $res->etapa = $valores['etapas'];

        return $res;
    }
}
