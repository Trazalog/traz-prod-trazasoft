<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Listado de Artículos</h3>
        <button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;" data-toggle="modal"
            data-target="#new_articulo" data->Agregar</button>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table id="articles" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="15%">Acciones</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Unidad de Medida</th>
                    <th width="10%">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($list as $a) {

                    echo "<tr  id='$a->arti_id' data-json='".json_encode($a)."'>";

                    echo "<td class='text-center text-light-blue'>";

                    echo '<i class="fa fa-search" style="cursor: pointer;margin: 3px;" title="Ver Detalles" onclick="ver(this)"></i>';

                    echo '<i class="fa fa-fw fa-pencil " style="cursor: pointer; margin: 3px;" title="Editar" onclick="editar(this)"></i>';
                   
                    echo '<i class="fa fa-fw fa-times-circle eliminar" style="cursor: pointer;margin: 3px;" title="Eliminar"></i>';
                    
                    echo "</td>";

                    echo "<td class='codigo'>$a->barcode</td>";
                    echo "<td>$a->descripcion</td>";
                    echo "<td>$a->unidad_medida</td>";
                    echo "<td class='text-center'>".estado($a->estado)."</td>";
                    echo "</tr>";

                }

                ?>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<script>
DataTable($('table'));

function guardarArticulo() {
    
    var formData = new FormData($('#frm-articulo')[0]);

    if (!validarForm()) return;
    wo();

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'index.php/<?php echo ALM ?>Articulo/guardar',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(rsp) {
            $('.modal-backdrop').remove();
            linkTo();
        },
        error: function(rsp) {
            alert('Error: No se pudo Guardar Artículo');
            console.log(rsp.msj);
        },
        complete:function() {
            wc();
        }
    });
}

function editarArticulo() {
    
    var formData = new FormData($('#frm-articulo')[0]);

    if (!validarForm()) return;
    wo();

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'index.php/<?php echo ALM ?>Articulo/editar',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(rsp) {
            $('.modal-backdrop').remove();
            linkTo();
        },
        error: function(rsp) {
            alert('Error: No se pudo Editar Artículo');
            console.log(rsp.msj);
        },
        complete:function() {
            wc();
        }
    });
}

function ver(e) {
    var json = JSON.parse(JSON.stringify($(e).closest('tr').data('json')));
    Object.keys(json).forEach(function(key, index) {
        $('[name="' + key + '"]').val(json[key]);
    });
    $('#btn-accion').hide();
    $('#read-only').prop('disabled', true);
    $('#mdl-titulo').html('Detalle Artículo');
    $('#new_articulo').modal('show');
}

function editar(e) {
     $('#arti_id').prop('disabled',false);
    var json = JSON.parse(JSON.stringify($(e).closest('tr').data('json')));
    Object.keys(json).forEach(function(key, index) {
        $('[name="' + key + '"]').val(json[key]);
    });
    $('#mdl-titulo').html('Editar Artículo');
    $('#btn-accion').attr('onclick', 'editarArticulo()');
    $('#new_articulo').modal('show');
    
}

// Eliminar Articulo
var selected = null;
$('.eliminar').click(function() {
    selected = $(this).closest('tr').attr('id');
    $('#mdl-eliminar').modal('show');
});

function eliminar_articulo() {
    $.ajax({
        type: 'POST',
        data: {
            idelim: selected
        },
        url: 'index.php/<?php echo ALM ?>Articulo/baja_articulo',
        success: function(data) {
            alert("Articulo Eliminado");
            linkTo();
        },
        error: function(result) {
            console.log(result);
        }

    });
}


$("#new_articulo").on("hide.bs.modal", function() {
    $('#mdl-titulo').html('Nuevo Artículo');
    $('#btn-accion').attr('onclick', 'guardarArticulo()');
    $('#btn-accion').show();
    $('#frm-articulo')[0].reset();
    $('#read-only').prop('disabled', false);
    $('#arti_id').prop('disabled',true);
});

function validarForm() {
    var ban = ($('#unidmed').val() != 'false' && $('#artBarCode').val() != null && $('#artDescription').val() != null);
    if (!ban) alert('Complete los Campos Obligatorios (*)');
    return ban;
}
</script>

<!-- Modal -->
<div class="modal" id="new_articulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mdl-titulo">Nuevo Artículo</h4>
            </div>

            <div class="modal-body" id="modalBodyArticle">

                <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    Revise que todos los campos esten completos
                </div>

                <form id="frm-articulo">
                    <input id="arti_id" name="arti_id" type="text" class="hidden" disabled>
                    <fieldset id="read-only">
                        <div class="row">
                            <!-- Código de Articulo -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Código <strong class="text-danger">*</strong>: </label>
                                    <input type="text" class="form-control" id="artBarCode" name="barcode">
                                </div>

                                <!-- Código del Artículo -->
                                <div class="form-group">
                                    <label>Descripción <strong class="text-danger">*</strong>: </label>
                                    <input type="text" class="form-control" id="artDescription" name="descripcion">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Unidad de medida <strong class="text-danger">*</strong>:</label>
                                    <select class="form-control" id="unidmed" name="unidad_medida">
                                        <option value="false"> - Seleccionar -</option>
                                        <?php
                                    foreach ($unidades_medida as $o) {
                                        echo  "<option value='$o->valor'>$o->descripcion</option>";
                                    }
                                ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Unidades por Caja:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox"
                                                onclick="$('#cant_caja').prop('disabled', !this.checked)">
                                        </span>
                                        <input id="cant_caja" type="number" class="form-control" name="cantidad_caja"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Punto de pedido:</label>
                                    <input type="number" name="punto_pedido" id="puntped" min="0"
                                        class="form-control text-center" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="margin-top:25px">
                                    <label>¿Lotear Artículo?</label>
                                    <input type="checkbox" name="es_loteado" id="es_loteado" value="true">
                                </div>
                            </div>
                        </div>
                </form>
            </div> <!-- /.modal-body -->


            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn-accion" class="btn btn-primary btn-guardar" onclick="guardarArticulo()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal eliminar-->
<div class="modal" id="mdl-eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"
                        class="fa fa-fw fa-times-circle text-light-blue"></span> Eliminar Artículo</h4>
            </div> <!-- /.modal-header  -->

            <div class="modal-body" id="modalBodyArticle">
                <p>¿Realmente desea ELIMINAR ARTICULO? </p>
            </div> <!-- /.modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSave" data-dismiss="modal"
                    onclick="eliminar_articulo()">Eliminar</button>
            </div> <!-- /.modal footer -->

        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog modal-lg -->
</div> <!-- /.modal fade -->
<!-- / Modal -->