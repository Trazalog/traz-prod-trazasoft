<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');} 

    class TestModel extends CI_Model
    {
        /**
        * Constructor de Clase
        * @param 
        * @return 
        */
        function __construct()
        {
            parent::__construct();
        }

        /**
        * Constructor de Clase
        * @param 
        * @return data devuelve materiales 
        */
        function getMateriales()
        {
            $data = wso2(REST_ALM.'articulos/'.empresa());
            return $data;
        }

        function getEtapas()
        {
            $data = wso2(REST.'etapas');
            return $data;
        }

        function getMaterialesPorEtapa($etap_id)
        {
            $data = wso2(REST.'etapas/entradas/'.$etap_id);
            return $data;
        }

        function setMaterial($data)
        {
            $url = REST.'etapas/entradas';
            $aux['_post_etapas_entradas'] = $data;
            $rsp = wso2($url,'POST',$aux);
            return $rsp;
        }

        function deleteMaterial($data)
        {
            $url = REST.'etapas/entradas';
            $aux['_delete_etapas_entradas'] = $data;
            $rsp = wso2($url,'DELETE',$aux);
            return $rsp;
        }
    }
?>