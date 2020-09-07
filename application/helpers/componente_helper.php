<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('info_header')) {
    function info_header($titulo, $body)
    {
        echo
            '<div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                <h3 class="box-title">' . $titulo . '</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" onclick="collapse(this)"><i class="fa fa-plus"></i>
                    </button>
                </div>
                </div>
                <div class="box-body">
                ' . $body . '
                </div>
            </div>';
    }
}

if (!function_exists('selectBusquedaAvanzada')) {
    function selectBusquedaAvanzada($id, $name = false, $list = false, $value = false, $label = false, $descripcion = false, $button = false)
    {
        #Convertir Datos a Arreglo
        $list = json_decode(json_encode($list), true);

        $opt = $list?"<option value='0' data-foo='' selected disabled> -  Seleccionar  - </option>":null;
        
        # Si Trae Datos Construir Opciones
        if($list) {
            foreach ($list as $o) {
                $opt .= "<option value='$o[$value]' data-json='" . json_encode($o) . "' ";

                if ($descripcion) {
                    $aux = '';
                    if (is_array($descripcion)) {

                        foreach ($descripcion as $i => $e) {
                            $o[$e] = $o[$e] ? "\"$o[$e]\"" : ' - ';
                            $aux .= '<small class"text-blue"><cite>' . (is_numeric($i) ? $o[$e] : sprintf("$i %s", $o[$e])) . '</cite></small>  <label class="text-blue">♦ </label>   ';
                        }

                    } else {
                        $aux = $o[$descripcion];
                    }
                }
                $opt .= " data-foo='$aux'>$o[$label]</option>";
            }
        }

        # Si solo pide las opciones retorna $OPT
        if(!$id) return $opt;

        $html .= "<select class='form-control select2' style='width: 100%;' id='$id' name='$name' data-json=''>$opt</select>";

        # Boton de Busqueda avanzada
        if ($button) {
            $button = '<div class="input-group">%s<span class="input-group-btn"><button class="btn btn-primary" data-toggle="modal" data-target="#modal_articulos"><i class="glyphicon glyphicon-search"></i></button></span></div>';
            $html = sprintf($button, $html);

        }

        $html .= "<label id='detalle' class='select-detalle' class='text-blue'></label>";
        $html .= "<script>$('#$id').select2({matcher: matchCustom,templateResult: formatCustom}).on('change', function() { selectEvent(this);})</script>";
        return $html;
    }
}

function selectFromCore($name, $placeholder, $tabla)
{
    $url = REST_CORE."tablas/$tabla";
    $rsp = wso2($url);
    $opt = '';
    foreach ($rsp['data'] as $o) {
        $opt .= "<option value='$o->valor'>$o->descripcion</option>";
    }
    return "<select id='$name' name='$name' class='form-control' style='width: 100%;'><option value='0' disabled selected> - $placeholder - </option>$opt</select>";   
}

function selectFromFont($name, $placeholder, $url, $mapValues)
{
    $rsp = wso2($url);
    $opt = '';
    foreach ($rsp['data'] as $o) {
        $opt .= "<option value='".($o->{$mapValues['value']})."'>".($o->{$mapValues['descripcion']})."</option>";
    }
    return "<select id='$name' name='$name' class='form-control' style='width: 100%;'><option value='0' disabled selected> - $placeholder - </option>$opt</select>";
}


function componente($id, $url, $load = false)
{
  
    if($load) $load = "<script>reload('#$id')</script>"; else   $load = '';
    return "<componente id='$id' class='reload' data-link='$url'>$load</componente>";
}