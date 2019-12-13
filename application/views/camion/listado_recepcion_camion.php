<!--RBASAÑES-->

<!--Muestra los datos de los servicios directamente en pantalla-->
<?php 
var_dump($movimientosTransporte)
?>
<!--________________________________________________________________________-->

<!--Pantalla "LISTADO RECEPCION DE CAMION"-->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado Recepción Camión</h3>
    </div>
    <div class="box-body">
      <!--________________________________________________________________________-->    
    
      <!--Campos de Filtrado de //LISTADO RECEPCION CAMION//-->
        <div class="col-md-6">
            
            <!--Establecimiento-->
            <div class="form-group">
                <label for="exampleInputEmail1">Establecimiento</label>
                <input type="text" class="form-control" id="establecimiento" placeholder="Ingresar Establecimiento">
            </div>
            <!--________________________________________________________________________-->   
            
            <!--Transportista-->
            <div class="form-group">
                <label for="exampleInputEmail1">Transportista</label>
                <input type="text" class="form-control" id="transportista" placeholder="Ingresar Transportista">
            </div>
            <!--________________________________________________________________________-->   
            
            <!--Proveedor-->
            <div class="form-group">
                <label for="exampleInputEmail1">Proveedor</label>
                <input type="text" class="form-control" id="proveedor" placeholder="Ingresar Proveedor">
            </div>
            <!--________________________________________________________________________-->   
            
        </div>
        <div class="col-md-6">
            
            <!--Rango Fecha-->
            <div class="form-group">
                <label for="exampleInputEmail1">Rango Fecha</label>
                <input type="text" class="form-control" id="rangofecha" placeholder="Ingresar Rango Fecha">
            </div>
            <!--________________________________________________________________________-->   
            
            <!--Articulo-->
            <div class="form-group">
                <label for="exampleInputEmail1">Articulo</label>
                <input type="text" class="form-control" id="articulo" placeholder="Ingresar Articulo">
            </div>
        </div>
    <!--________________________________________________________________________-->
    <br>
</div>
<!--Campos de Filtrado de //LISTADO CARGA CAMION//-->

<!--Tabla de datos que recibe informacion carga de la //Recepcion de Camion\\-->
<!---////////////////////////////////////////---DATA TABLES 1---/////////////////////////////////////////////////////----->
    <div class="box-header with-border">
        <div class="box-tittle">
            <h4>Filtrado de Recepcion</h4>
        </div>
    </div>
<!--________________________________________________________________________-->
  <div class="box-body table-scroll table-responsive">
    <table id="example2" class="table table-bordered table-hover">

      <!--Cabecera del datatable-->  
        <thead>
          <tr>
            <th class="boleta" id="boleta" style="width: 200px; font-weight: lighter;">N° Boleta</th> 
            <th class="proveedor" id="proveedor" style="width: 200px; font-weight: lighter;">Proveedor</th>
            <th class="transportista" id="transportista" style="width: 200px; font-weight: lighter;">Transportista</th>
            <th class="fecha_entrada" id="fecha_entrada" style="width: 200px; font-weight: lighter;">Fecha</th>
            <th class="patente" id="patente" style="width: 200px; font-weight: lighter;">Patente - Acoplado</th>
            <th class="neto" id="neto" style="width: 200px; font-weight: lighter;">Neto</th>
            <th class="codigo_lote" id="codigo_lote" style="width: 200px; font-weight: lighter;">Cod. Lote</th>
            <th class="articulo" id="articulo" style="width: 200px; font-weight: lighter;">Articulo</th>
            <th class="cantidad" id="cantidad" style="width: 200px; font-weight: lighter;">Cantidad</th>
            <th class="" id="" style="width: 200px; font-weight: lighter;">UM</th>
            <th class=estado" id="estado" style="width: 200px; font-weight: lighter;">Estado</th>
          </tr>
        </thead>
      <!--________________________________________________________________________-->
      
      <!--Cuerpo del Datatable-->
        <tbody>
          <tr style="font-weight: lighter;">
            <td>111111111111</td>
            <td>Guevara </td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
          </tr>
          <tr style="font-weight: lighter;">
            <td>111111111111</td>
            <td>Guevara </td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
          </tr>
          <tr style="font-weight: lighter;">
            <td>111111111111</td>
            <td>Guevara </td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
          </tr>
          <tr style="font-weight: lighter;">
            <td>111111111111</td>
            <td>Guevara </td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
          </tr>
          <tr style="font-weight: lighter;">
            <td>111111111111</td>
            <td>Guevara </td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaaaaaaaaaaaaaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
            <td>aaa</td>
          </tr>
        </tbody>
      </table>
    </div>
</div>
<!--________________________________________________________________________-->

<!--Script Data Table-->
<script>
$(function() {
//True = Activado
//False = Desactivado

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