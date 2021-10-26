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
        <h4 class="box-title">Entrada Recepción MP</h4><br> 
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
                <label style="font-weight: lighter;" for="exampleInputEmail1">Artículo</label>
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

        <button class="btn btn-primary" onclick="linkTo('<?php echo base_url(PRD) ?>general/Camion/entradaCamion')"
            style="margin-top:10px;">Nueva Entrada | Recepción MP</button>
        <br><br>

        <table id="tbl-camiones" class="table table-striped table-hover">
            <!--Cabecera del datatable-->
            <thead>
                <th></th>
                <th>Accion</th>
                <th>N° Boleta</th>
                <th>Proveedor</th>
                <th>Transportista</th>
                <th>CUIT</th>
                <th>Fecha</th>
                <th>Patente - Acoplado</th>
                <th>Neto</th>
                <th>Estado</th>

            </thead>
            <!--________________________________________________________________________-->

            <!--Cuerpo del Datatable-->
            <tbody>
                <?php
        foreach($movimientosTransporte as $fila)
        {
          if($fila->estado == 'Finalizado') continue;
          $id=$fila->id;
          echo "<tr  id='$id' data-json='".json_encode($fila->articulos)."'>";
          echo '<td width="5%" class="text-center" style="font-weight: lighter;">';
          echo "<a class='mr-2' onclick='salidaCamiones(\"$fila->patente\")'><i class='fa fa-fw fa-truck text-red ml-1' style='cursor: pointer;' title='Salida camion'></i></a>";

          echo '<i class="fa fa-fw fa-truck text-light-blue" style="cursor: pointer;" title="Ver Lotes"  onclick="rellenarDetalles(this)"></i>';
          echo '</td>';
          echo "<th><b>".(strtoupper($fila->accion))."</b></th>";

          echo '<td style="font-weight: lighter;">'.$fila->boleta.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->proveedor.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->transportista.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->cuit.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->fecha_entrada.'</td>';
          echo '<td style="font-weight: lighter;">'.$fila->patente .' | '.$fila->acoplado.'</td>';
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
DataTable('#tbl-camiones');

//example 1 -Script Datatable-
DataTable('#tbl-articulos');

function rellenarDetalles(e) {

    var data = $(e).closest('tr').attr('data-json');
    data = JSON.parse(data);

    if (!data.articulo) {
        alert('Sin Detalles a Mostrar');
        return;
    }
    var tabla = $('#tbl-articulos').find('tbody');
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

function salidaCamiones(patente) {
    wo();
    linkTo('<?php echo base_url(PRD) ?>general/Camion/salidaCamion?patente=' + patente);
    wc();
}
</script>
<!--________________________________________________________________________-->