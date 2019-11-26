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

if(!function_exists('mapSelect')){
    function mapSelect($value, $label, $data){

        $data = json_decode(json_encode($data), true);

        foreach ($data as $key => $value) {
            if($key == $value) $data[$key]['value'] = $o[$value];
            if($key == $label) $data[$key]['label'] = $o[$label];
        }

        return json_decode(json_encode($data));
    }
}