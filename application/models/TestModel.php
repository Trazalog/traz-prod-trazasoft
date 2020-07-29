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
            $data = wso2(REST.'etapas/salidas/'.$etap_id);
            return $data;
        }

        function putMaterial($data)
        {
            // $data = $this->Test->agregaMaterial('POST');
            $a = '';
        }

        function deleteMaterial()
        {
            $a = '';
        }
    }

?>