<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('info_header')) {
    function info_header($titulo,$body){
        echo 
            '<div class="box box-primary collapsed-box asd">
                <div class="box-header with-border">
                <h3 class="box-title">'.$titulo.'</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" onclick="collapse(this)"><i class="fa fa-plus"></i>
                    </button>
                </div>
                </div>
                <div class="box-body">
                '.$body.'
                </div>
            </div>';
    }
}

if(!function_exists('select2')){
    function select2($id, $list, $label, $value, $descripcion = false){

        $list = json_decode(json_encode($list), true);

        $button = '<div class="input-group">%s<span class="input-group-btn"><button class="btn btn-primary" data-toggle="modal" data-target="#modal_articulos"><i class="glyphicon glyphicon-search"></i></button></span></div>';
        $html .= "<select class='form-control select2' style='width: 100%;' id='$id' data-json=''";
        foreach ($list as $o) {
            $html .= "<option value='$o[$value]' data-json='".json_encode($o)."'";

            if($descripcion){
                $aux = '';
                if(is_array($descripcion)){

                    foreach ($descripcion as $key =>$e) {
                        $aux .= (is_numeric($key)?$o[$e] : sprintf($key, $o[$e])) . ' || ' ;
                    }

                }else{
                    $aux = $o[$descripcion];
                }
            }
            $html .= " data-foo='$aux'>$o[$label]</option>";
        }
        $html .= "</select>";
        $html = sprintf($button, $html);
        $html .= "<cite id='detalle' class='text-blue'></cite>";
        return $html;
}
}