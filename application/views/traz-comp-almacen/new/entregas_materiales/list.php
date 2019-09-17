<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Entrega Materiales</h3>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="entregas" class="table table-bordered table-striped table-hover">
            <thead>
               
                    <th width="10%">Acciones</th>
                    <th width="10%">Pedido</th>
                    <th width="10%">Entrega</th>
                    <th width="10%" class="<?php echo (!viewOT ? "hidden" : null) ?>">Ord.Trabajo</th>
                    <th class="text-center" width="10%">Fecha</th>
                    <th>N° Comprobante</th>
                    <th>Entregado</th>
                    <th width="12%">Estado Ped.</th>
               
            </thead>
            <tbody>
                <?php
                    foreach ($list as $o) {
                        echo '<tr data-id='.$o['enma_id'].' data-pema="'.$o['pema_id'].'" data-json=\''.json_encode($o).'\'>'; 
                        echo '<td>';
                        echo '<i class="fa fa-fw fa-print text-light-blue" style="cursor: pointer; margin:2px" title="Imprimir"></i> ';
                        echo '<i class="fa fa-fw fa-search text-light-blue btn-buscar" style="cursor: pointer; margin:2px" onclick="ConsultarEntrega(this)"title="Consultar"></i> ';
                        echo '<i class="fa fa-fw  fa-battery text-light-blue btn-estado" style="cursor: pointer; margin:2px"onclick="EstadoPedido(this)" title="Estado Pedido"></i> ';
                        echo '</td>';
                        echo '<td class="text-center">'.bolita($o['pema_id'],'blue').'</td>';
                        echo '<td class="text-center">'.bolita($o['enma_id'],'aqua').'</td>';
                        echo '<td class="text-center '.(!viewOT ? "hidden" : null).'">'.bolita($o['ortr_id'],'orange').'</td>';
                        echo '<td class="text-center">'.fecha($o['fecha']).'</td>';
                        echo '<td>'.$o['comprobante'].'</td>';
                        echo '<td>'.$o['solicitante'].'</td>';
                        echo '<td class="text-center" style="cursor: pointer;">'.estadoPedido($o['estado']).'</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</section>
<script>
//DataTable('#entregas');

function ConsultarEntrega(e)
{
    var tr = $(e).closest('tr');
    var id = $(tr).data('id');
    var json = JSON.parse(JSON.stringify($(tr).data('json')));
    rellenarCabecera(json);
    $.ajax({
        type: 'GET',
        url: 'index.php/almacen/new/Entrega_Material/detalle?id='+id,
        success: function(result) {
            var tabla = $('#modal_detalle_entrega table');
    
            $(tabla).find('tbody').html('');
            result.forEach(e => {
                $(tabla).append(
                    '<tr>' +
                    '<td>' + e.barcode + '</td>' +
                    '<td>' + e.descripcion + '</td>' +
                    '<td>' + e.lote + '</td>' +
                    '<td>' + e.deposito + '</td>' +
                    '<td class="text-center">' + e.cantidad + '</td>' +
                    '</tr>'
                );
            });
         
            $('#modal_detalle_entrega').modal('show');
           
        },
        error: function(result) {
            alert('Error');
        },
        dataType: 'json'
    });
}

function rellenarCabecera(json) {
    $('#modal_detalle_entrega .enma_id').val(json.enma_id);
    $('#modal_detalle_entrega .pema_id').val(json.pema_id);
    $('#modal_detalle_entrega .orden').val(json.ortr_id);
    $('#modal_detalle_entrega .comprobante').val(json.comprobante);
    $('#modal_detalle_entrega .fecha').val(json.fecha);
    $('#modal_detalle_entrega .entregado').val(json.solicitante);
    $('#modal_detalle_entrega .estado').val(json.estado);
}
</script>



<!-- Modal ver nota pedido-->
<div class="modal fade" id="modal_detalle_entrega" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"
                        class="fa fa-search text-light-blue"></span> Detalle Pedido Materiales</h4>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <label for="">Entrega:</label>
                        <input class="form-control enma_id" type="text" value="???" readonly>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <label for="">Pedido:</label>
                        <input class="form-control pema_id" type="text" value="???" readonly>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4 <?php echo (!viewOT ? "hidden" : null) ?>">
                        <label for="">Orden de Trabajo:</label>
                        <input class="form-control orden" type="text" value="???" readonly>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <label for="">Comprobante:</label>
                        <input class="form-control comprobante" type="text" value="???" readonly>
                    </div><br>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <label for="">Fecha:</label>
                        <input class="form-control fecha" type="text" value="???" readonly>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <label for="">Entregado a:</label>
                        <input class="form-control entregado" type="text" value="???" readonly>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <label for="">Estado:</label>
                        <input class="form-control estado" type="text" value="???" readonly>
                    </div>
                </div>
            </div> <!-- /.modal-header  -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped table-hover">
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

<?php
    $this->load->view(ALM.'new/pedidos_materiales/estado_pedido');            
?>