<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('formato_fecha')){
    function formato_fecha_hora($fecha){
        if(strlen($fecha)==0) return '';
        $aux = explode(" ",$fecha);
        if(sizeOf($aux)==2){
            $date = explode("-",$aux[0]);
            $date = $date[2].'/'.$date[1].'/'.$date[0].'  -  '.substr($aux[1],0,5).' hs';
            return $date;
        }
    }

      function fecha_hora($fecha){
        if(strlen($fecha)==0) return '';
        $aux = explode(" ",$fecha);
        if(sizeOf($aux)==2){
            $date = explode("-",$aux[0]);
            $date = $date[2].'/'.$date[1].'/'.$date[0].'  -  '.substr($aux[1],0,5).' hs';
            return $date;
        }
    }
    

    function fecha($fecha){
        if(strlen($fecha)==0) return '';
        $date = explode("-",$fecha);
        $date = $date[2].'/'.$date[1].'/'.$date[0];
        return $date;
        
    }

    function resta_fechas($a,$b){
        $fecha1 = new DateTime($a);
        $fecha2 = new DateTime($b);
        $resultado = $fecha1->diff($fecha2);
        $dias = $resultado->format('%a');
        $horas = $resultado->format('%H');
        $result =  ($dias!='0'?$dias.' días ':'').(strcmp($horas,'00')!=0?$horas.' hs':'');
        if(strlen($result)==0){
            return $resultado->format('%i').' min';
        }else{
            return $result;
        }
    }

    function formatFechaPG($fecha)
    {
        $fecha = substr($fecha,0,10);
        return fecha($fecha);
    }
}
?>