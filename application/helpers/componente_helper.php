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

if(!function_exists('selectBusquedaAvanzada')){
    function selectBusquedaAvanzada($id, $list, $value, $label, $descripcion = false , $button = false){

        $list = json_decode(json_encode($list), true);

        if($button) $button = '<div class="input-group">%s<span class="input-group-btn"><button class="btn btn-primary" data-toggle="modal" data-target="#modal_articulos"><i class="glyphicon glyphicon-search"></i></button></span></div>';

        $html .= "<select class='form-control select2' style='width: 100%;' id='$id' data-json=''>";
        $html .= "<option value='' data-foo='' selected disabled> -  Seleccionar  - </option>";
        foreach ($list as $o) {
            $html .= "<option value='$o[$value]' data-json='".json_encode($o)."' ";

            if($descripcion){
                $aux = '';
                if(is_array($descripcion)){

                    foreach ($descripcion as $i => $e) {
                        $o[$e] = $o[$e]?"\"$o[$e]\"":' - '; 
                        $aux .= '<small class"text-blue"><cite>'.(is_numeric($i) ? $o[$e] : sprintf($i, $o[$e])).'</cite></small>  <label class="text-black">♥  </label>   ';
                    }

                }else{
                    $aux = $o[$descripcion];
                }
            }
            $html .= " data-foo='$aux'>$o[$label]</option>";
        }
        $html .= "</select>";
        if($button) $html = sprintf($button, $html);
        $html .= "<label id='detalle' class='text-blue'></label>";
        $html .= "<script>$('#$id').select2({matcher: matchCustom,templateResult: formatCustom}).on('change', function() { selectEvent(this);})</script>";
        return $html;
}
}