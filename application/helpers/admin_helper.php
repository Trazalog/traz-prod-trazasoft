<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('bolita')) {
    function bolita($texto, $color, $detalle = null)
    {
        return

            '<span data-toggle="tooltip" title="' . $detalle . '" class="badge bg-' . $color . ' estado">' . $texto . '</span>';
    }

    function estadoPedido($estado)
    {
        switch ($estado) {
            case 'Creada':
                return bolita($estado, 'purple');
                break;

            case 'Solicitado':
                return bolita($estado, 'orange');
                break;
            case 'Aprobado':
                return bolita($estado, 'green');
                break;
            case 'Rechazado':
                return bolita($estado, 'red');
                break;
            case 'Ent. Parcial':
                return bolita($estado, 'blue');
                break;
            case 'Entregado':
                return bolita($estado, 'green');
                break;
            case 'Cancelado':
                return bolita($estado, 'red');
                break;
            default:
                return bolita('S/E', '');
                break;
        }
    }

}
