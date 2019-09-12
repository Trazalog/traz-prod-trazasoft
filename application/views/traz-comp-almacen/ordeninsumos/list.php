<section>                                                                                                  
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Entrega Materiales</h3>
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">

            <table id="insumo" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="1%">Acciones</th>
                        <th width="10%">N° Entrega</th>
                        <th class="<?php echo (!viewOT?"hidden":null) ?>">Orden de Trabajo</th>
                        <th>N° Comprobante</th>
                        <th>Solicitante</th>
                        <th>Fecha Entrega</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
          
                    ?>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

</section><!-- /.content -->

<script>
$('#modalvista').on('shown.bs.modal', function(e) {
    $($.fn.dataTable.tables(true)).DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        })
        .columns.adjust();
});
//  var isOpenWindow = false;
var comglob = "";
var ide = "";
var edit = 0;
var datos = Array();

datos = Array();


$(".fa-search-plus").click(function(e) {
    $('#total').val('');

    var idor = $(this).parent('td').parent('tr').attr('id');

    $.ajax({
        type: 'POST',
        data: {
            idor: idor
        },
        url: 'index.php/almacen/Ordeninsumo/consultar',
        success: function(data) {

            // datos={
            //   'id':data['datos'][0]['enma_id'],
            //   'fecha':data['datos'][0]['fecha'],
            //   'solicitante':data['datos'][0]['solicitante'],
            //   'comprobante':data['datos'][0]['comprobante'],
            //   'id_ot':data['datos'][0]['ortr_id'],
            // }

            $('#total').val(data['total'][0]['cantidad']);
            $('#orden').val(data['datos'][0]['enma_id']);
            $('#fecha').val(data['datos'][0]['fecha']);
            $('#id_ot').val(data['datos'][0]['ortr_id']);


            for (var i = 0; i < data['equipos'].length; i++) {
                $('#tablaconsulta').DataTable().row.add([
                    data['equipos'][i]['artBarCode'],
                    data['equipos'][i]['artDescription'],
                    data['equipos'][i]['codigo'],
                    data['equipos'][i]['depositodescrip'],
                    data['equipos'][i]['cantidad']
                ]).draw();
            }
        },
        error: function(result) {
            alert('Error');
        },
        dataType: 'json'
    });
});

function consultarDetalle(e) {
    var row = $(e).closest('tr');
}


DataTable('#insumo');
DataTable('#tablaconsulta');


// imprime consulta de insumos
$(".imprimir").click(function(e) {
    $('.acciones, .dataTables_filter, .dataTables_length, .dataTables_info, .dataTables_paginate paging_full_numbers, #modalAction')
        .addClass('no-print');
    $('a[href]').addClass('no-print');
    $(".impresion").printArea();
});
</script>


<!-- Modal CONSULTA-->
<div class="modal" id="modalvista" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content impresion">

            <div class="modal-header">
                <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"
                        class="fa fa-fw fa-search-plus text-light-blue"></span>Detalle Entrega Materiales</h4>
            </div> <!-- /.modal-header  -->

            <div class="modal-body" id="modalBodyArticle">
                <div class="row" id="infoOI">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <label for="orden">N° Entrega:</label>
                        <input type="text" class="form-control" id="orden" name="orden" disabled>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <label for="fecha">Fecha:</label>
                        <input type="text" class="form-control" id="fecha" name="fecha" disabled>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 <?php echo (!viewOT?"hidden":null) ?>">
                        <label for="fecha">Orden de trabajo:</label>
                        <input type="text" class="form-control" id="id_ot" name="id_ot" disabled>
                    </div>
                    <div class="clearfix"></div>
                </div><br>

                <div class="row">
                    <div class="col-xs-12">
                        <hr>
                        <div class="row">
                            <div class="col-xs-12" id="btn-datatables"></div>
                        </div><br>
                        <table class="table table-bordered compact" id="tablaconsulta">
                            <thead>
                                <tr>
                                    <th>Artículo</th>
                                    <th>Descripción</th>
                                    <th>N° Lote</th>
                                    <th>Depósito</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <label for="total">Total:</label>
                        <input type="text" class="form-control" id="total" name="total">
                    </div>
                </div>
            </div> <!-- /.modal-body -->

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default imprimir no-print" data-dismiss="modal">Imprimir</button> -->
                <button type="button" class="btn btn-default no-print" data-dismiss="modal">Cerrar</button>
            </div> <!-- /.modal footer -->

        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog modal-lg -->
</div> <!-- /.modal fade -->
<!-- / Modal -->