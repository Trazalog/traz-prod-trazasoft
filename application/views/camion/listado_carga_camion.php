<!--RBASAÑES-->

<!--Pantalla "LISTADO CARGA DE CAMION"-->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado Carga Camión</h3>
    </div>
    <div class="box-body">
<!--________________________________________________________________________-->    

<!--Campos de Filtrado de //LISTADO CARGA CAMION//-->
<div class="col-md-12">
<!--Tabla de datos que recibe informacion carga de la //Carga de Camion\\-->     
<!---////////////////////////////////////////---DATA TABLES 1---/////////////////////////////////////////////////////----->
    <div class="box-header with-border">
        <div class="box-tittle">
            <h3>Filtrado de Carga</h3>
        </div>
    </div>
<!--________________________________________________________________________-->
  <div class="box-body table-scroll">
    <table id="example2" class="table table-bordered table-hover">
      
      <!--Cabecera del datatable--> 
        <thead>
          <tr>
            <th>N° Boleta</th>
            <th>Establecimiento</th>
            <th>Fecha</th>
            <th>Patente</th>
            <th>Acoplado</th>
            <th>Transportista</th>
            <th>Neto</th>
            <th>Estado</th>
          </tr>
        </thead>
      <!--________________________________________________________________________-->
      
      <!--Cuerpo del Datatable-->
        <tbody>
          <tr>
            <td>1</td>
            <td>Dato 1</td>
            <td>Dato 1</td>
            <td>Dato 1</td>
            <td>Dato 1</td>
            <td>Dato 1</td>
            <td>Dato 1</td>
            <td>Dato 1</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Dato 2</td>
            <td>Dato 2</td>
            <td>Dato 2</td>
            <td>Dato 2</td>
            <td>Dato 2</td>
            <td>Dato 2</td>
            <td>Dato 2</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Dato 3</td>
            <td>Dato 3</td>
            <td>Dato 3</td>
            <td>Dato 3</td>
            <td>Dato 3</td>
            <td>Dato 3</td>
            <td>Dato 3</td>
          </tr>
        </tbody>
      </table>
    </div>
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