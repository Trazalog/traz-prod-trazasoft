<!--RBASAÑES-->

<!--Muestra los datos de los servicios directamente en pantalla-->
<?php 
//var_dump($movimientosTransporte)
?>
<!--________________________________________________________________________--> 

<!--Pantalla "LISTADO CARGA DE CAMION"-->
<div class="box">
    <div class="box-header with-border">
        <h4 class="box-title">Listado Carga Camión</h4>
    </div>
    <div class="box-body">
<!--________________________________________________________________________-->    

<!--Campos de Filtrado de //LISTADO CARGA CAMION//-->

<!--Tabla de datos que recibe informacion carga de la //Carga de Camion\\-->     
<!---////////////////////////////////////////---DATA TABLES 1---/////////////////////////////////////////////////////----->
    <div class="box-header with-border">
        <div class="box-tittle">
            <h4>Filtrado de Carga</h4>
        </div>
    </div>
<!--________________________________________________________________________-->

  <div class="box-body table-scroll table-responsive">
    <table id="example2" class="table table-bordered table-hover">

      <!--Cabecera del datatable--> 
        <thead>
          <tr>
            <th></th>
            <th class="boleta" id="boleta" style="width: 200px; font-weight: lighter;">N° Boleta</th>
            <th class="establecimiento" id="establecimiento" style="width: 200px; font-weight: lighter;">Establecimiento</th>
            <th class="fecha_entrada" id="fecha_entrada" style="width: 200px; font-weight: lighter;">Fecha</th>
            <th class="patente" id="patente" style="width: 400px; font-weight: lighter;">Patente Acoplado</th>
            <th class="transportista" id="transportista" style="width: 200px; font-weight: lighter;">Transportista</th>
            <th class="neto" id="neto" style="width: 200px; font-weight: lighter;">Neto</th>
            <th class="estado" id="estado" style="width: 200px; font-weight: lighter;">Estado</th>
          </tr>
        </thead>
      <!--________________________________________________________________________-->

      <!--Cuerpo del Datatable-->
        <tbody>
          <?php
            foreach($movimientosTransporte as $fila)
            {
              $id=$fila->id;
              echo'<tr  id="'.$id.'" data-json:'.json_encode($fila).'>';

              echo '<td width="5%" class="text-center">';
              echo '<i class="fa fa-fw fa-search text-light-blue ml-1" style="cursor: pointer;" title="Editar" onclick=linkTo("general/Etapa/editar?id='.$id.'")></i>';
              echo '<i class="fa fa-fw fa-times-circle text-light-blue ml-1" style="cursor: pointer;" title="Eliminar" onclick="seleccionar(this)"></i>';
              echo '</td>';

              echo '<td>'.$fila->boleta.'</td>';
              echo '<td>'.$fila->establecimiento.'</td>';
              echo '<td>'.$fila->fecha_entrada.'</td>';
              echo '<td>'.$fila->patente.'</td>';
              echo '<td>'.$fila->transportista.'</td>';
              echo '<td>'.$fila->neto.'</td>';
              echo '<td>'.$fila->estado.'</td>';
              echo '</tr>';
            }
          ?>
        </tbody>
      </table>
    </div>

<!--________________________________________________________________________-->  

<!--Script Data Table-->
<script>
$(function() {
//true = Activado
//false = Desactivado

//example 2 -Script Datatable-
$('#example2').DataTable({
    'paging': true,
    'lengthChange': true,
    'searching': false,
    'ordering': true,
    'info': true,
    'autoWidth': true,
    'autoFill': true,
    'buttons': true,
    'fixedHeader': true,
    dom: 'Bfrtip',
    buttons: [
    'excel', 'pdf', 'print'
    ]
  })
})

//example 1 -Script Datatable-
$('#example1').DataTable({
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': true,
    'autoFill': true,
    'buttons': true,
    'fixedHeader': true,
});

</script>
<!--________________________________________________________________________-->