<!--RBASAÑES-->

<div class="modal fade" id="modal_cargacamion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <!--Header del modal-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Informacion</h4>
            </div>
            <!--_____________________________________________________________-->

            <!--Body del modal-->
            <div class="modal-body">
                <div class="row">

                <!--DATOS ESPECIFICOS DEL MODAL-->                                
                <div class="box-body table-scroll table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                    
                    <!--Cabecera del datatable-->  
                        <thead>
                            <tr>
                                <th class="articulos" id="articulos" style="width: 1000px; font-weight: lighter;">Articulos</th> 
                                <th class="cantidad" id="cantidad" style="width: 1000px; font-weight: lighter;">Cantidad</th>
                                <th class="codigo_lote" id="codigo_lote" style="width: 1000px; font-weight: lighter;">Codigo Lote</th>
                                <th class="um" id="um" style="width: 1000px; font-weight: lighter;">UM</th>
                           </tr>
                        </thead>
                    <!--________________________________________________________________________-->
                    
                    <!--Cuerpo del Datatable-->
                    <tbody>                        
                    </tbody>
                    <!--________________________________________________________________________-->
                    </table>
                </div>
                <!--________________________________________________________________________-->
                </div>
            </div>
            <!--_____________________________________________________________-->

            <!--Footer del modal-->
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!--_____________________________________________________________-->

        </div>
    </div>

</div>

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