<!--RBASAÑES-->

<!--Muestra la ventana modal de la pantalla recepcion de camion-->
<!--/////////////////Articulos, Cantidad, Codigo de Lote y UM/////////////////-->
<?php 
$this->load->view('camion/modal_recepcioncamion');
?>
<!--________________________________________________________________________-->

<!--Pantalla "LISTADO RECEPCION DE CAMION"-->
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">Listado Recepción Camión</h4>
    </div>
    <div class="box-body hidden">
        <!--________________________________________________________________________-->

        <!--Campos de Filtrado de //LISTADO RECEPCION CAMION//-->
        <div class="col-md-6">

            <!--Establecimiento-->
            <div class="form-group">
                <label style="font-weight: lighter;" for="exampleInputEmail1">Establecimiento</label>
                <input style="font-weight: lighter;" type="text" class="form-control" id="establecimiento"
                    placeholder="Ingresar Establecimiento">
            </div>
            <!--________________________________________________________________________-->

            <!--Transportista-->
            <div class="form-group">
                <label style="font-weight: lighter;" for="exampleInputEmail1">Transportista</label>
                <input style="font-weight: lighter;" type="text" class="form-control" id="transportista"
                    placeholder="Ingresar Transportista">
            </div>
            <!--________________________________________________________________________-->

            <!--Proveedor-->
            <div class="form-group">
                <label style="font-weight: lighter;" for="exampleInputEmail1">Proveedor</label>
                <input style="font-weight: lighter;" type="text" class="form-control" id="proveedor"
                    placeholder="Ingresar Proveedor">
            </div>
            <!--________________________________________________________________________-->

        </div>
        <div class="col-md-6">

            <!--Rango Fecha-->
            <div class="form-group">
                <label style="font-weight: lighter;" for="exampleInputEmail1">Rango Fecha</label>
                <input style="font-weight: lighter;" type="text" class="form-control" id="rangofecha"
                    placeholder="Ingresar Rango Fecha">
            </div>
            <!--________________________________________________________________________-->

            <!--Articulo-->
            <div class="form-group">
                <label style="font-weight: lighter;" for="exampleInputEmail1">Articulo</label>
                <input style="font-weight: lighter;" type="text" class="form-control" id="articulo"
                    placeholder="Ingresar Articulo">
            </div>
        </div>
        <!--________________________________________________________________________-->
        <br>
    </div>
    <!--Campos de Filtrado de //LISTADO CARGA CAMION//-->

    <!--Tabla de datos que recibe informacion carga de la //Recepcion de Camion\\-->
    <!---////////////////////////////////////////---DATA TABLES 1---/////////////////////////////////////////////////////----->
    <!-- <div class="box-header with-border">
        <div class="box-tittle">
            <h4>Filtrado de Recepcion</h4>
        </div>
    </div> -->
    <!--________________________________________________________________________-->
    <div class="box-body table-scroll table-responsive">
        <table id="example2" class="table table-striped table-hover">
            <!--Cabecera del datatable-->
            <thead>

                <th></th>
                <th class="boleta" id="boleta" style="width: 200px;">N° Boleta</th>
                <th class="proveedor" id="proveedor" style="width: 200px;">Proveedor</th>
                <th class="transportista" id="transportista" style="width: 200px;">
                    Transportista</th>
                <th class="fecha_entrada" id="fecha_entrada" style="width: 200px;">Fecha</th>
                <th class="patente" id="patente" style="width: 200px;">Patente - Acoplado</th>
                <th class="neto" id="neto" style="width: 200px;">Neto</th>
                <th class="estado" id="estado" style="width: 200px;">Estado</th>

            </thead>
            <!--________________________________________________________________________-->

            <!--Cuerpo del Datatable-->
            <tbody>
                <?php
        foreach($movimientosTransporte as $fila)
        {
          $id=$fila->id;
          echo "<tr  id='$id' data-json='".json_encode($fila->articulos)."'>";

          echo '<td width="5%" class="text-center" style="font-weight: lighter;">';
          echo '<i class="fa fa-fw fa-truck text-light-blue ml-1" style="cursor: pointer;" title="Ver"  onclick="rellenarDetalles(this)"></i>';
          echo '</td>';

          echo '<td style="font-weight: lighter;">'.$fila->boleta.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->proveedor.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->transportista.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->fecha_entrada.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->patente.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->neto.'</td>';
          echo '<td style="font-weight: lighter;">'.estado($fila->estado).'</td>';
          echo '</tr>';
        }
        ?>
            </tbody>
        </table>
    </div>
</div>
<!--________________________________________________________________________-->

<!--Script Data Table-->
<script>
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
});

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
    'fixedHeader': true
});

function rellenarDetalles(e) {

    var data = $(e).closest('tr').attr('data-json');
    data = JSON.parse(data);
    if (!data) {
        alert('Sin Detalles a Mostrar');
        return;
    }
    var tabla = $('#example2').find('tbody');
    $(tabla).empty();
    data.articulo.forEach(function(e) {

        tabla.append(
            `<tr>
        <td style="font-weight: lighter;">${e.articulo}</td>
        <td style="font-weight: lighter;">${e.cantidad}</td>
        <td style="font-weight: lighter;">${e.codigo_lote}</td>
        <td style="font-weight: lighter;">${e.um}</td>
      </tr>`
        );
    });

    $('#modal_recepcioncamion').modal('show');
}
</script>
<!--________________________________________________________________________-->