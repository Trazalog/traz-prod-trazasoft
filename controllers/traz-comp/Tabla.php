<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tabla extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->model(ALM.'Articulos');
   
      
   }
   function index(){
      $list = json_decode(json_encode($this->Articulos->getList()));
      $aux = array();
      $obj = null;
      foreach ($list as $key =>$o) {
          $obj = new stdClass();
          $obj->id = $o->arti_id;
          $obj->descripcion = $o->descripcion;
          $obj->codigo = $o->barcode;
          $obj->stock = $o->stock;

          array_push($aux, $obj);
      }
      $data['items'] = $aux;
      //echo var_dump($data);die;
      $data['lang'] = json_decode(file_get_contents(base_url('lang.json')), true)['labels']['label'];
      $lenguaje =  array();
       for($i=0;$i<count($data['lang'] );$i++)
       {
           $aux = array($data['lang'][$i]['id']=> $data['lang'][$i]['texto']);
           $lenguaje = array_merge($lenguaje,$aux);
       }
       $data['lang'] =$lenguaje;
      @$this->load->view('test', $data);
   }

   function armaTabla()
   {   
       $json = $this->input->post('json');
       $id = $this->input->post('idtabla');
       $acciones = $this->input->post('acciones');
       $res = armaBusca($json,$id,$acciones,lang_get());
       echo $res;
   }
   function insertaFila()
   {
       $json = $this->input->post('json');
       $id = $this->input->post('idtabla');
       $acciones = $this->input->post('acciones');
       $res = insertarFila($json,$id,$acciones);
       echo $res;
   }
}
?>