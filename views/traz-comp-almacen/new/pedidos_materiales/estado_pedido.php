<!-- Modal ver nota pedido-->
<div class="modal fade" id="detalle_pedido2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"
                        class="fa fa-battery-full text-light-blue"></span> Estado Pedido Materiales</h4>
            </div> <!-- /.modal-header  -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="tablapedido" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Cod. Artículo</th>
                                    <th class="text-center">Cant. Pedida</th>
                                    <th class="text-center">Cant. Pedida</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--TABLE BODY -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- /.modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSave" data-dismiss="modal">Cerrar</button>
            </div> <!-- /.modal footer -->
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog modal-lg -->
</div> <!-- /.modal fade -->
<!-- / Modal -->

<script>
function EstadoPedido(e)
 {

    var id = $(e).closest('tr').data('pema');
    if (id == '' || id == null) return;
    $.ajax({
        type: 'GET',
        url: 'index.php/<?php echo ALM ?>new/Pedido_Material/estado?id='+id,
        success: function(result) {
            var tabla = $('#tablapedido');
            $(tabla).DataTable().destroy();
            $(tabla).find('tbody').html('');
            result.forEach(e => {
                $(tabla).append(
                    '<tr>' +
                    '<td>' + e.barcode + '</td>' +
                    '<td class="text-center"><b>' + e.cantidad + '</b></td>' +
                    '<td class="text-center"><b>' + (e.cantidad - e.resto) +
                    '</b></td>' +
                    '<td class="text-center"><i class="fa '+
                    (e.resto == 0?'fa-battery-full':(e.resto < e.cantidad?'fa-battery-2':(e.resto == e.cantidad?'fa-battery-0':'')))+
                    '"></i></td>'+
                    '</tr>'
                );
            });

            $('#detalle_pedido2').modal('show');
        },
        error: function(result) {
            alert('Error');
        },
        dataType: 'json'
    });
    DataTable('#tablapedido');
 }
</script>