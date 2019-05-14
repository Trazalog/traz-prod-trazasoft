<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('armaBusca')){

    function armaBusca($json, $id)
    {
        $array =  json_decode($json);
        $html = '<table id="'.$id.'" class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>';
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
            $html = $html.'<tr  id="'.$fila->id.'" data-json:'.json_encode($fila).'>';
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



}