<!--RBASAÑES-->

<!--Muestra la ventana modal de la pantalla carga de camion-->
<!--/////////////////Articulos, Cantidad, Codigo de Lote y UM/////////////////-->
<?php 
$this->load->view('camion/modal_recepcioncamion');
$this->load->view('camion/modal_cargarcamion');
?>
<!--________________________________________________________________________-->

<!--Pantalla "LISTADO CARGA DE CAMION"-->
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">Listado Camiones</h4>
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
            <table id="tbl-camiones" class="table table-striped table-hover">

                <!--Cabecera del datatable-->
                <thead>

                    <th>Acción</th>
                    <th>N° Boleta</th>
                    <th>Establecimiento</th>
                    <th>Fecha</th-weight:>
                    <th>Patente Acoplado</th>
                    <th>Transportista</th>
                    <th>Neto</th>
                    <th>Estado</th>

                </thead>
                <!--________________________________________________________________________-->

                <!--Cuerpo del Datatable-->
                <tbody>
                    <?php
            foreach($movimientosTransporte as $fila)
            {
              $id=$fila->id;
              echo "<tr  id='$id' data-json='".json_encode($fila->articulos)."'>";

              echo '<td width="7%" class="text-center">';
              echo '<a onclick="salidaCamiones(';
              echo '\''.$fila->motr_id.'\')" ><i class="fa fa-fw fa-truck text-red ml-1" style="cursor: pointer;" title="Salida camión" ></i></a>';
              echo '<i class="fa fa-fw fa-search text-light-blue ml-1" style="cursor: pointer;" title="Ver" onclick="rellenarDetalles(this)"></i>';
              echo '</td>';

              echo '<td style="font-weight: lighter;">'.$fila->boleta.'</td>';
              echo '<td style="font-weight: lighter;">'.$fila->establecimiento.'</td>';
              echo '<td style="font-weight: lighter;">'.$fila->fecha_entrada.'</td>';
              echo '<td style="font-weight: lighter;">'.$fila->patente.'</td>';
              echo '<td style="font-weight: lighter;">'.$fila->transportista.'</td>';
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
    //example 2 -Script Datatable-
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

    function salidaCamiones(motr_id) {
        wo();
        linkTo('<?php echo base_url(PRD) ?>general/Camion/salidaCamion?motr_id=' + motr_id);
        wc();
    }
    </script>
    <!--________________________________________________________________________-->