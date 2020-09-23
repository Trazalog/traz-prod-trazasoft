<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Componentes extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listaArticulos()
    {
        $this->load->model(ALM.'Articulos');

        $list = json_decode(json_encode($this->Articulos->getList()));
		$aux = array();
		$obj = null;
		foreach ($list as $key =>$o) {
			$obj = new stdClass();
			$obj->id = $o->arti_id;
			$obj->descripcion = $o->descripcion;
			$obj->codigo = $o->barcode;
			$obj->stock = $o->stock;
			$obj->json = json_encode($o);
  
			array_push($aux, $obj);
		}
		$data['items'] = $aux;
		//echo var_dump($data);die;
		/*$data['lang'] = json_decode(file_get_contents(base_url('lang.json')), true)['labels']['label'];
		$lenguaje =  array();
		 for($i=0;$i<count($data['lang'] );$i++)
		 {
			 $aux = array($data['lang'][$i]['id']=> $data['lang'][$i]['texto']);
			 $lenguaje = array_merge($lenguaje,$aux);
		 }
         $data['lang'] =$lenguaje;*/
         
         return $data['items'];
    }
}
