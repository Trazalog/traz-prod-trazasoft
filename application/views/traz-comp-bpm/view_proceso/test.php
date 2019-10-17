
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Detalle Pedido Materiales</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div id="deposito_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="dataTables_length" id="deposito_length"><label>Show <select
                                                    name="deposito_length" aria-controls="deposito"
                                                    class="form-control input-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> entries</label></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="deposito_filter" class="dataTables_filter"><label>Search:<input
                                                    type="search" class="form-control input-sm" placeholder=""
                                                    aria-controls="deposito"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="deposito"
                                            class="table table-bordered table-hover dataTable no-footer" role="grid"
                                            aria-describedby="deposito_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_disabled" rowspan="1" colspan="1"
                                                        aria-label="Acciones" style="width: 78.2px;">Acciones</th>
                                                    <th class="sorting_asc" tabindex="0" aria-controls="deposito"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Nota de Pedido: activate to sort column descending"
                                                        style="width: 139.4px;">Nota de Pedido</th>
                                                    <th class="sorting" tabindex="0" aria-controls="deposito"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Orden de Trabajo: activate to sort column ascending"
                                                        style="width: 154.6px;">Orden de Trabajo</th>
                                                    <th class="sorting" tabindex="0" aria-controls="deposito"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Detalle: activate to sort column ascending"
                                                        style="width: 70.6px;">Detalle</th>
                                                    <th class="sorting" tabindex="0" aria-controls="deposito"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Fecha Nota: activate to sort column ascending"
                                                        style="width: 106px;">Fecha Nota</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="1" class="1 odd" role="row">
                                                    <td><i class="fa fa-fw fa-search text-light-blue"
                                                            style="cursor: pointer; margin-left: 15px;"
                                                            title="Ver Nota Pedido"></i></td>
                                                    <td class="sorting_1">1</td>
                                                    <td>36</td>
                                                    <td>jjjjjjj</td>
                                                    <td>2019-05-10</td>
                                                </tr>
                                                <tr id="9" class="9 even" role="row">
                                                    <td><i class="fa fa-fw fa-search text-light-blue"
                                                            style="cursor: pointer; margin-left: 15px;"
                                                            title="Ver Nota Pedido"></i></td>
                                                    <td class="sorting_1">9</td>
                                                    <td>36</td>
                                                    <td>jjjjjjj</td>
                                                    <td>2019-05-20</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="dataTables_info" id="deposito_info" role="status"
                                            aria-live="polite">Showing 1 to 2 of 2 entries</div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="dataTables_paginate paging_simple_numbers" id="deposito_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button previous disabled" id="deposito_previous"><a
                                                        href="#" aria-controls="deposito" data-dt-idx="0"
                                                        tabindex="0">Previous</a></li>
                                                <li class="paginate_button active"><a href="#" aria-controls="deposito"
                                                        data-dt-idx="1" tabindex="0">1</a></li>
                                                <li class="paginate_button next disabled" id="deposito_next"><a href="#"
                                                        aria-controls="deposito" data-dt-idx="2" tabindex="0">Next</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
 


        <!-- Modal ver nota pedido-->
        <div class="modal fade" id="detalle_pedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"
                                class="fa fa-plus-square text-light-blue"></span> Ver Nota de Pedido</h4>
                    </div> <!-- /.modal-header  -->

                    <div class="modal-body" id="modalBodyArticle">
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="tabladetalle" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Articulo</th>
                                            <th>Cantidad</th>
                                            <th>Fecha Nota</th>
                                            <th>Fecha de Entrega</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- /.modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnSave" data-dismiss="modal">Ok</button>
                    </div> <!-- /.modal footer -->

                </div> <!-- /.modal-content -->
            </div> <!-- /.modal-dialog modal-lg -->
        </div> <!-- /.modal fade -->
        <!-- / Modal -->
    </div>

    <form id="generic_form">
        <div class="form-group">
            <center>
                <h4> ¿Se Aprueba o Rechaza el Pedido de Materiales? </h4>
                <label class="radio-inline">
                    <input type="radio" name="result" value="true"
                        onclick="$('#motivo').hide();$('#hecho').prop('disabled',false);"> Aprobar
                </label>
                <label class="radio-inline">
                    <input type="radio" name="result" value="false"
                        onclick="$('#motivo').show();$('#hecho').prop('disabled',false);"> Rechazar
                </label>
            </center>

        </div>

        <div id="motivo" class="form-group motivo" style="display: none;">
            <textarea class="form-control" name="motivo_rechazo" placeholder="Motivo de Rechazo..."></textarea>
        </div>
    </form>

    <script>
    $('#motivo').hide();
    $('#hecho').prop('disabled', true);



    function cerrarTarea() {

        var id = $('#idTarBonita').val();

        var dataForm = new FormData($('#generic_form')[0]);

        dataForm.append('pema_id', $('table#deposito tbody tr').attr('id'));

        $.ajax({
            type: 'POST',
            data: dataForm,
            cache: false,
            contentType: false,
            processData: false,
            url: 'index.php/general/Proceso/cerrarTarea/' + id,
            success: function(data) {
                //WaitingClose();
                linkTo('general/Proceso');

            },
            error: function(data) {
                alert("Error");
            }
        });

    }
    </script>
