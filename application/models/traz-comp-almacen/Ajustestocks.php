<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajustestocks extends CI_Model {
    function __construct(){

      parent::__construct();
   }

   function guardarAjuste($data)
   {
        log_message('DEBUG', 'Ajustestocks/guardarAjuste (datos)-> '.json_encode($data));
        // $resource = '/establecimiento';
        // $url = REST2.$resource;
        // $array = $this->rest->callAPI("POST", $url, $data); 
        // return json_decode($array['status']);
   }
}
?>