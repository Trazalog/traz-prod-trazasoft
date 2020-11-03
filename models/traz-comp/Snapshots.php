<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Snapshots extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener($key)
    {
        $url = REST_LOG . "/snapshots/$key";
        $rsp = $this->rest->callApi('GET', $url);
        if($rsp['status']) $rsp['data'] = json_decode($rsp['data'])->data->snapshot[0]->data;
        return $rsp;
    }

    function guardar($data)
    {
        $aux['post_snapshot']['clave'] = $data['key']; unset($data['key']);
        $aux['post_snapshot']['data'] =  json_encode($data);
        
        $url = REST_LOG . '/snapshots';
        $rsp = $this->rest->callApi('POST', $url, $aux);
        return $rsp;
    }
    
    function eliminar($key){

        $aux['delete_snapshot']['clave'] = $key;

        $url = REST_LOG . '/snapshots';
        $rsp = $this->rest->callApi('DELETE', $url, $aux);
        return $rsp;

    }
}