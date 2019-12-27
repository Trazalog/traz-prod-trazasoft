<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajustestocks extends CI_Model {
    function __construct(){

      parent::__construct();
   }

   function guardarAjustes($data)
   {
        $data = array(
         'ajuste' => array(
            'empr_id' => strval(empresa()),
            'usuario_app' => userNick(),
            'justificacion' => $data['justificacion'],
            'tipo_ajuste' => $data['tipoajuste']
           )
         );

        log_message('DEBUG', 'Ajustestocks/guardarAjuste (datos)-> '.json_encode($data));
        $resource = 'stock/ajuste';
        $url = REST0.$resource;
        $array = $this->rest->callAPI("POST", $url, $data); 
        return json_decode($array['data']);
   }
   function guardarDetalleAjustes($data)
   {
      $data = $data;
      if($data['tipo_ent_sal'] == "ENTRADA"){
         $dato = array(
            'ajuste_detalles' => array(
               'ajuste_detalle' => array(
                  'ajus_id' => $data['ajus_id'],
                  'lote_id' => $data['loteent'],
                  'cantidad' => $data['cantidadent']
               )
              )
         );
      }else if(($data['tipo_ent_sal'] == "SALIDA")){
         $dato = array(
            'ajuste_detalles' => array(
               'ajuste_detalle' => array(
                  'ajus_id' => $data['ajus_id'],
                  'lote_id' => $data['lotesal'],
                  'cantidad' => strval(intval($data['cantidadsal']) * -1)
               )
              )
         );
      }else if(($data['tipo_ent_sal'] == "E/S")){
         $dato['ajuste_detalles']['ajuste_detalle'][] = array(
            'ajus_id' => $data['ajus_id'],
            'lote_id' => $data['loteent'],
            'cantidad' => $data['cantidadent']
         );
         $dato['ajuste_detalles']['ajuste_detalle'][] = array(
            'ajus_id' => $data['ajus_id'],
            'lote_id' => $data['lotesal'],
            'cantidad' => strval(intval($data['cantidadsal']) * -1)
         );
      }

      log_message('DEBUG', 'Ajustestocks/guardarDetalleAjustes (datos)-> '.json_encode($data));
      $resource = 'stock/ajuste/detalle_batch_req';
      $url = REST0.$resource;
      $array = $this->rest->callAPI("POST", $url, $dato); 
      return json_decode($array['status']);
   }
}
?>