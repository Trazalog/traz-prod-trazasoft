<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('armaBusca')){

    function armaBusca($json, $id, $acciones)
    {
        $array =  json_decode($json);
        $html = '<table id="'.$id.'" class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>';
        if($acciones !== '')
        {
            $html = $html.'<th>Acciones</th>';
        }
        $keys = array();
        while($element = current($array[0])) {
            $head=key($array[0]);
            array_push($keys,$head);
            $html = $html.'<th>'.$head.'</th>';
            next($array[0]);
        }
       
        $html = $html.'</tr></thead><tbody>';
        foreach($array as $fila)
        {
            if($acciones !== '')
            $json = "'".json_encode(array($fila))."'";
            $html = $html.'<tr  id="'.$fila->id.'" data-json='.$json.'>';
        {
           $acc = agregaAcciones($id, $acciones);
           $html = $html.$acc;
        }
            for($i = 0;$i<count($keys);$i++)
                {
                $key = $keys[$i];
                $html= $html.'<td>'.$fila->$key.'</td>';
            }
            $html = $html.'</tr>';
        }
        $html = $html.'</tbody></table>';
        return $html;
       
    }
    function agregaAcciones($id, $acciones)
    {
        $acc = '<td>';
        if(strpos($acciones,'Edit') !== false) {
            $acc= $acc.'<i class="fa fa-fw fa-pencil text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Editar" id="'.$id.'_editar"></i>';
          }
          if(strpos($acciones,'Add') !== false) {
            $acc= $acc.'<i class="fa fa-fw fa-plus text-light-blue '.$id.'_nuevo" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i>';
          }
          if(strpos($acciones,'Del') !== false) {
            $acc= $acc.'<i class="fa fa-fw fa-minus-circle text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Borrar" id="'.$id.'_borrar"></i>';
          }
          if(strpos($acciones,'View') !== false) {
            $acc= $acc.'<i class="fa fa-fw fa-search text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Ver" id="'.$id.'_ver"></i>';
          }
          $acc = $acc.'</td>';
          return $acc;
        
    }
    function insertarFila($json, $id ,$acciones)
    {
        $array =  json_decode($json);
        $keys = array();
        while($element = current($array[0])) {
            $head=key($array[0]);
            array_push($keys,$head);
            next($array[0]);
        };
        $jason = "'".json_encode(array($array))."'";
        $ret = '<tr id="'.$array[0]->id.'" data-json="'.$jason.'">';
        $acc = agregaAcciones($id,$acciones);
        $ret = $ret.$acc;
        for($i = 0;$i<count($keys);$i++)
                {
                $key = $keys[$i];
                $ret = $ret.'<td>'.$array[0]->$key.'</td>';
                }
            $ret= $ret.'</tr>';
            return $ret;

    }



}