<!--RBASAÑES-->
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
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Establecimiento</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Establecimiento">
            </div>
            <!--________________________________________________________________________-->   
            <!--Transportista-->
            <div class="form-group">
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Transportista</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Transportista">
            </div>
            <!--________________________________________________________________________-->   
            <!--Proveedor-->
            <div class="form-group">
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Proveedor</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Proveedor">
            </div>
            <!--________________________________________________________________________-->   
        </div>
        <div class="col-md-6">
            <!--Rango Fecha-->
            <div class="form-group">
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Rango Fecha</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Establecimiento">
            </div>
            <!--________________________________________________________________________-->   
            <!--Articulo-->
            <div class="form-group">
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Articulo</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Establecimiento">
            </div>
        </div>
    <!--________________________________________________________________________-->
    <br>
</div>
<!--Tabla de datos que recibe informacion carga de la //Recepcion de Camion\\-->
<!---////////////////////////////////////////---DATA TABLES 1---/////////////////////////////////////////////////////----->
    <div class="box-header with-border">
        <div class="box-tittle">
            <h3>Listado de datos</h3>
        </div>
    </div>
<!--________________________________________________________________________-->
    <div class="box-body table-scroll">
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>N° Boleta</th>
                    <th>Proveedor</th>
                    <th>Transportista</th>
                    <th>Fecha</th>
                    <th>Patente - Acoplado</th>
                    <th>Neto</th>
                    <th>Cod. Lote</th>
                    <th>Articulo</th>
                    <th>Cantidad</th>
                    <th>UM</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1111</td>
                    <td>Guevara </td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                </tr>
                <tr>
                    <td>1111</td>
                    <td>Guevara </td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                </tr>
                <tr>
                    <td>1111</td>
                    <td>Guevara </td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                </tr>
                <tr>
                    <td>1111</td>
                    <td>Guevara </td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                </tr>
                <tr>
                    <td>1111</td>
                    <td>Guevara </td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                    <td>aaa</td>
                </tr>
                </tfoot>
        </table>
    </div>
</div>
<!--________________________________________________________________________-->
<!--Script Data Table-->
<script>
$(function() {

    $('#example2').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
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