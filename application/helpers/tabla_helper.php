<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('armaBusca')){

    function armaBusca($json, $id, $acciones,$lenguaje = false)
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
        for($i = 0;$i<count(array_keys((array)$array[0]));$i++)
        {
            $head=array_keys((array)$array[0])[$i];
            array_push($keys,$head);
            $head2= $lenguaje[strtolower($head)];
            $html = $html.'<th>'.$head2.'</th>';
        }
        
       
        $html = $html.'</tr></thead><tbody>';
        foreach($array as $fila)
        {
            $json =json_encode(array($fila));
            $html = $html."<tr  id='".$fila->id."' data-json='".$json."'>";
            if($acciones !== '')            
        		{
							$acc = agregaAcciones($id, $acciones);
							$html = $html.$acc;
						}
            for($i = 0;$i<count($keys);$i++)
            {
                $key = $keys[$i];
                if(is_array($fila->$key))
                    {
                        $html= $html.'<td> <button class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-search"';
                       $title='title="';
                       for($j=0;$j<count($fila->$key);$j++)
                       {
                           $title = $title.$j.' '.$fila->$key[$j]->titulo.PHP_EOL;
                       }
                       $title = $title.'"';
                        $html= $html.$title.'></i></button></td>';
                    }else{
								$html= $html.'<td>'.$fila->$key.'</td>';
						
                    }
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
            $acc= $acc.'<i class="fa fa-fw fa-pencil text-light-blue '.$id.'_editar" style="cursor: pointer; margin-left: 15px;" title="Editar" ></i>';
          }
          if(strpos($acciones,'Add') !== false) {
            $acc= $acc.'<i class="fa fa-fw fa-plus text-light-blue '.$id.'_nuevo" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i>';
          }
          if(strpos($acciones,'Del') !== false) {
            $acc= $acc.'<i class="fa fa-fw fa-minus-circle text-light-blue '.$id.'_borrar" style="cursor: pointer; margin-left: 15px;" title="Borrar"></i>';
          }
          if(strpos($acciones,'View') !== false) {
            $acc= $acc.'<i class="fa fa-fw fa-search text-light-blue '.$id.'_ver" style="cursor: pointer; margin-left: 15px;" title="Ver" ></i>';
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
        $ret = '<tr id="'.$array[0]->id.'" data-json='.$jason.'>';
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