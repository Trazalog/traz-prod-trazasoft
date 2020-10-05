<!--RBASAÑES-->

<!--Muestra la ventana modal de la pantalla carga de camion-->
<!--/////////////////Articulos, Cantidad, Codigo de Lote y UM/////////////////-->
<?php 
$this->load->view('camion/modal_cargarcamion');
?>
<!--________________________________________________________________________-->

<!--Pantalla "LISTADO CARGA DE CAMION"-->
<div class="box box-primary">
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
            <table id="tbl-camiones" class="table table-striped table-hover">

                <!--Cabecera del datatable-->
                <thead>

                    <th></th>
                    <th></th>
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

              echo '<td width="5%" class="text-center">';
              echo '<a onclick="salidaCamiones(';
              echo '\''.$fila->patente.'\')" ><i class="fa fa-fw fa-truck text-red ml-1" style="cursor: pointer;" title="Salida camion" ></i></a>';
              echo '</td>';

        

              echo '<td width="5%" class="text-center">';
              echo '<i class="fa fa-fw fa-truck text-light-blue ml-1" style="cursor: pointer;" title="Ver" data-toggle="modal" data-target="#modal_cargacamion" onclick="rellenarDetalles(this)"></i>';
              //echo '<i class="fa fa-fw fa-times-circle text-light-blue ml-1" style="cursor: pointer;" title="Eliminar" onclick="seleccionar(this)"></i>';
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
        if (!data.articulo) return;
        var tabla = $('#tbl-articulos').find('tbody');
        $(tabla).empty();
        data.articulo.forEach(function(e) {

            tabla.append(
                `<tr>
      <td>${e.articulo}</td>
      <td>${e.cantidad}</td>
      <td>${e.codigo_lote}</td>
      <td>${e.um}</td>
    </tr>`
            );
        });
    }
    
    function salidaCamiones(patente){
        wo();
       linkTo('<?php echo base_url(PRD) ?>general/Camion/salidaCamion/' + patente);
        wc();
    }
    </script>
    <!--________________________________________________________________________-->