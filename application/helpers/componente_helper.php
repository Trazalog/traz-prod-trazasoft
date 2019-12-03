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
        $html = "<select class='form-control select2' style='width: 100%;' id='$id'><option selected disabled> Seleccionar </option>";
        foreach ($list as $o) {
            $html .= "<option value='".$o[$value]."' data-json='".json_encode($o)."'>".$o[$label]."<br>";
            $html .= "</select><script>$('#$id').select2()</script>";
        return $html;
    }
}
}