<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('bolita')) {
  function bolita($texto, $color, $detalle = null)
  {
    return "<span data-toggle='tooltip' title='$detalle' class='badge bg-$color estado'>$texto </span>";
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

  function estado($estado)
  {
    #   $estado =  trim($estado);

    switch ($estado) {

        //Estado Generales
      case 'AC':
        return bolita('Activo', 'green');
        break;
      case 'IN':
        return bolita('Inactivo', 'red');
        break;

        //Estado Camiones
      case 'ASIGNADO':
        return bolita('Asignado', 'blue');
        break;
      case 'EN CURSO':
        return bolita('En Curso', 'green');
        break;
      case 'FINALIZADO':
        return bolita('Finalizado', 'yellow');
        break;

        //Estado Etapas
      case 'En Curso':
        return bolita('En Curso', 'green');
        break;

      case 'PLANIFICADO':
        return bolita('Planificado', 'blue');
        break;

      case 'FINALIZADO':
        return bolita('Finalizado', 'yellow');
        break;

        //Estado por Defecto
      default:
        return bolita('S/E', '');
        break;
    }
  }


  function estadoNoCon($estado)
  {
    #   $estado =  trim($estado);

    switch ($estado) {

      case 'ALTA':
        return bolita('ALTA', 'blue');
        break;
      case 'VENCIDO':
        return bolita('VENCIDO', 'red');
        break;

        //Estado Camiones
      case 'ACTIVO':
        return bolita('Asignado', 'green');
        break;
      case 'EN_TRANSITO':
        return bolita('En Trancito', 'info');
        break;
      case 'EN_REPARACION':
        return bolita('En Reparacion', 'yellow');
        break;

        //Estado Etapas
      case 'En Curso':
        return bolita('En Curso', 'green');
        break;

      case 'PLANIFICADO':
        return bolita('Planificado', 'blue');
        break;

      case 'FINALIZADO':
        return bolita('Finalizado', 'yellow');
        break;

        //Estado por Defecto
      default:
        return bolita('S/E', '');
        break;
    }
  }


}
