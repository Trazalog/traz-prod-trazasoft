<section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Listado de Artículos</h3>
                    <?php
                    if (strpos($permission, 'Add') !== false) {
                        echo '<button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;" onclick="LoadArt(0,\'Add\')">Agregar</button>';
                    }
                    ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="articles" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="10%">Acciones</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Unidad de Medida</th>
                                <th width="10%">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

foreach ($list as $a) {

    $id = $a['arti_id'];
    echo '<tr  id="' . $id . '" >';

    echo '<td class="text-center text-light-blue">';

    echo '<i class="fa fa-search" style="cursor: pointer;margin: 3px;" title="Ver Detalles" onclick="ver_detalles(this);"></i>';
    
    if (strpos($permission, 'Edit') !== false) {
        echo '<i class="fa fa-fw fa-pencil " style="cursor: pointer; margin: 3px;" title="Editar" data-toggle="modal" data-target="#modaleditar"></i>';
    }
    if (strpos($permission, 'Del') !== false) {
        echo '<i class="fa fa-fw fa-times-circle" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="seleccionar(this)"></i>';
    }

   
  
    echo '</td>';

    echo '<td class="codigo">' . $a['barcode'] . '</td>';
    echo '<td>' . $a['descripcion'] . '</td>';
    echo '<td>' . ($a['medida'] == '' ? '-' : $a['medida']) . '</td>';
    echo '<td class="text-center">' . ($a['valor'] == 'AC' ? '<small class="label pull-left bg-green">Activo</small>' : ($a['valor'] == 'IN' ? '<small class="label pull-left bg-red">Inactivo</small>' : '<small class="label pull-left bg-yellow">Suspendido</small>')) . '</td>';
    echo '</tr>';

}

?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->

<script>
// Abre modal agregar artículos
function LoadArt(id_, action) {
    idArt = id_;
    acArt = action;

    WaitingOpen('Cargando Artículo');
    $.ajax({
        type: 'POST',
        data: {
            id: id_,
            act: action
        },
        url: 'index.php/<?php echo ALM ?>Articulo/getArticle',
        success: function(result) {

            $("#modalBodyArticle").html(result.html);

            $('#new_articulo').modal('show');
            WaitingClose();

        },
        error: function(result) {
            console.error("error");
            console.table(result);
            WaitingClose();
        },
        dataType: 'json'
    }); // Ok
}

$('#btnSave').click(function() {
    if (acArt == 'View') {
        $('#modalArticle').modal('hide');
        return;
    }

    var hayError = false;
    if ($('#artBarCode').val() == '') {
        hayError = true;
    }

    if ($('#artDescription').val() == '') {
        hayError = true;
    }

    if (hayError == true) {
        $('#errorArt').fadeIn('slow');
        return;
    }

    if(!validarCodigosExistentes($('#artBarCode').val())){
        alert('Articulo Repetido');
        return;
    }

    $('#error').fadeOut('slow');
    WaitingOpen('Guardando cambios');
    $.ajax({
        type: 'POST',
        data: {
            id: idArt,
            act: acArt,
            code: $('#artBarCode').val(),
            name: $('#artDescription').val(),
            status: $('#artEstado').val(),
            box: $('#artIsByBox').prop('checked'),
            boxCant: $('#artCantBox').val(),
            unidmed: $('#unidmed').val(),
            puntped: $('#puntped').val(),
            es_loteado: $('#new_articulo #es_loteado').prop('checked') ? 1 : 0
        },
        url: 'index.php/<?php echo ALM ?>Articulo/setArticle',
        success: function(result) {
            console.log("estoy Guardando");
            WaitingClose();
            $('.modal').modal('hide');
            linkTo();
        },
        error: function(result) {
            WaitingClose();
            alert("error");
        },
        dataType: 'json'
    });
});

DataTable('#articles');

function validarCodigosExistentes(newCodigo){
    var ban = true;
    $('#articles .codigo').each(function(){
        if($(this).html() == newCodigo){
            ban = false;
        }
    });

    return ban;
}
</script>

<script>
// Trae datos para llenar el modal Editar
$(".fa-pencil").click(function(e) { // Ok
    var idartic = $(this).parent('td').parent('tr').attr('id');

    ida = idartic;
    $('#artBarCode').val('');
    $('#artDescription').val('');
    $('#artIsByBox').val('');
    $('#artCantBox').val('');
    $('#famId').html('');
    $('#unidmed').html('');
    $('#artEstado').val('');
    $('#puntped').val('');
    $.ajax({
        data: {
            idartic: idartic
        },
        dataType: 'json',
        type: 'POST',
        url: 'index.php/<?php echo ALM ?>Articulo/getpencil',
        success: function(data) {
            datos = {
                'codigoart': data[0]['barcode'],
                'descripart': data[0]['descripcion'],
                'artIsByBox': data[0]['es_caja'],
                'artcant': data[0]['cantidad_caja'],
                'estado_id': data[0]['estado'],
                'idunidad': data[0]['unidadmedida'],
                'unidadmedidades': data[0]['unidad_descripcion'],
                'punto_pedido': data[0]['punto_pedido'],
                'es_loteado': data[0]['es_loteado']
            }
            completarEdit(datos);
        },
        error: function(result) {
            console.error("Error al traer datos para llenar Modal Editar");
            console.table(result);
        },
    });
});

// Llena campos del modal Editar
function completarEdit(datos) { // Ok

    $('#artBarCode').val(datos['codigoart']);
    $('#artDescription').val(datos['descripart']);

    if (datos['artIsByBox'] == 1) {
        $('#artIsByBox').prop('checked', true);
        $('#artCantBox').val(datos['artcant']);
        $('#artCantBox').removeAttr('disabled');
    } else {
        $('#artIsByBox').prop('checked', false);
        $('#artCantBox').val('');
        $('#artCantBox').attr('disabled', true);
    }

    // traer_familia(datos['idfam']);
    traer_estado(datos['estado']);
    traer_unidad(datos['idunidad']);
    $('#puntped').val(datos['punto_pedido']);
    $('#es_loteado').attr('checked', datos['es_loteado'] == 1 ? true : false);
}

// Trae estado de artículo y llena select
function traer_estado(estado) { // Ok
    var estados = [
        ['1', 'Activo'],
        ['7', 'Inactivo'],
        ['2', 'Anulado'],
    ];
    $('#artEstado').empty();
    for (var i = 0; i < estados.length; i++) {
        var nombre = estados[i][1];
        var selected = (estado == estados[i][0]) ? 'selected' : '';
        var opcion = "<option value='" + estados[i][0] + "' " + selected + ">" + nombre + "</option>";
        $('#artEstado').append(opcion);
    }
}

// trae unidad de medida y llena select
function traer_unidad(idunidad) { // Ok
    $.ajax({
        data: {},
        dataType: 'json',
        type: 'POST',
        url: 'index.php/<?php echo ALM ?>Articulo/getdatosart',
        success: function(data) {
            $('#unidmed').empty();
            for (var i = 0; i < data.length; i++) {
                var nombre = data[i]['descripcion'];
                var selected = (idunidad == data[i]['id_unidadmedida']) ? 'selected' : '';
                var opcion = "<option value='" + data[i]['id_unidadmedida'] + "' " + selected + ">" +
                    nombre + "</option>";
                $('#unidmed').append(opcion);
            }
        },
        error: function(result) {
            console.log(result);
        },
    }); // Ok
}

// Edita los datos de artículo
function guardareditar() { // Ok
    var codigo = $('#artBarCode').val();
    var desc = $('#artDescription').val();
    if ($('#artIsByBox').is(':checked')) {
        var box = 1;
        var unidades = $('#artCantBox').val();
    } else {
        var box = 0;
        var unidades = '';
    }

    var estado = $('#artEstado').val();
    var unmed = $('#unidmed').val();
    var punto = $('#puntped').val();
    var loteado = $('#es_loteado').prop('checked') ? 1 : 0;
    var parametros = {
        // 'id_equipo': id_equipo, // el id_equipo es ida
        'barcode': codigo,
        'descripcion': desc,
        'es_caja': box,
        'cantidad_caja': unidades,
        'estado_id': estado,
        'unidad_id': unmed,
        'punto_pedido': punto,
        'es_loteado': loteado
    };
    console.log("estoy editando");
    console.table(parametros);
    $.ajax({
        type: 'POST',
        data: {
            data: parametros,
            ida: ida
        },
        url: 'index.php/<?php echo ALM ?>Articulo/editar_art',
        success: function(data) {
            linkTo();
        },
        error: function(result) {
            console.error("Error al editar Artículo");
            console.table(result);
        }
        //dataType: 'json'
    });
}

var select = '';

function seleccionar(o) {
    select = $(o).closest('tr');
    $('#modaleliminar').modal('show');
}


function eliminar_articulo() {
    var id = select.attr('id');
    $.ajax({
        type: 'POST',
        data: {
            idelim: id
        },
        url: 'index.php/<?php echo ALM ?>Articulo/baja_articulo', //index.php/
        success: function(data) {
            alert("Articulo Eliminado");
            linkTo();
        },
        error: function(result) {
            console.log(result);
        }

    });
}

function ver_detalles(e) {
    var idartic = $(e).closest('tr').attr('id');

    $('#artBarCode').val('');
    $('#artDescription').val('');
    $('#artIsByBox').val('');
    $('#artCantBox').val('');
    $('#famId').html('');
    $('#unidmed').html('');
    $('#artEstado').val('');
    $('#puntped').val('');
    $.ajax({
        data: {
            idartic: idartic
        },
        dataType: 'json',
        type: 'POST',
        url: 'index.php/<?php echo ALM ?>Articulo/getpencil',
        success: function(data) {
            datos = {
                'codigoart': data[0]['barcode'],
                'descripart': data[0]['descripcion'],
                'artIsByBox': data[0]['es_caja'],
                'artcant': data[0]['cantidad_caja'],
                'estado_id': data[0]['estado'],
                'idunidad': data[0]['unidadmedida'],
                'unidadmedidades': data[0]['unidad_descripcion'],
                'punto_pedido': data[0]['punto_pedido'],
                'es_loteado': data[0]['es_loteado']
            }
            completarEdit(datos);
            $('.btn-edit').hide();
            $('#modaleditar input').prop('readonly', true);
            $('#modaleditar select').prop('disabled', true);
            $('titu').html('Detalles del Articulo');
            $('#modaleditar').modal('show');
        },
        error: function(result) {
            console.error("Error al traer datos para llenar Modal Editar");
            console.table(result);
        },
    });
}

function reset() {
    $('.btn-edit').show();
    $('#modaleditar input').prop('readonly', false);
    $('#modaleditar select').prop('disabled',false);
    $('titu').html('Editar Articulo');
}

$('#artIsByBox').click(function() {
  if($(this).is(':checked')){
    $('#artCantBox').prop('disabled',false);
  } else {
    $('#artCantBox').val('');
    $('#artCantBox').prop('disabled',true);
  }
});
</script>

<!-- Modal -->
<div class="modal" id="new_articulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Artículo</h4>
            </div>

            <div class="modal-body" id="modalBodyArticle">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal eliminar-->
<div class="modal" id="modaleliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

<!-- Modal editar-->
<div class="modal" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"class="fa fa-fw fa-pencil text-light-blue"></span> <titu>Editar Artículo</titu></h4>
            </div> <!-- /.modal-header  -->

            <div class="modal-body" id="modalBodyArticle">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <label style="margin-top: 7px;">Código <strong style="color: #dd4b39">*</strong>: </label>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <input type="text" class="form-control" id="artBarCode" value="">
                    </div>
                </div><br>

                <!-- Código del Artículo -->
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <label style="margin-top: 7px;">Descripción <strong style="color: #dd4b39">*</strong>: </label>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <input type="text" class="form-control" id="artDescription" value="">
                    </div>
                </div><br>

                <!-- Descripción del Artículo -->
                <div class="row">
                    <div class="col-xs-10 col-sm-4">
                        <label style="margin-top: 7px;">Se Compra x Caja <strong style="color: #dd4b39">*</strong>:
                        </label>
                    </div>
                    <div class="col-xs-2 col-sm-1">
                        <input type="checkbox" id="artIsByBox" style="margin-top:10px;">
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <label style="margin-top: 7px;">Unidades <strong style="color: #dd4b39">*</strong>: </label>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <input type="text" class="form-control" id="artCantBox" value="">
                    </div>
                </div><br>

                <!-- -->
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <label style="margin-top: 7px;">Estado: </label>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <select class="form-control" id="artEstado" name="artEstado" value="">

                        </select>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <label style="margin-top: 7px;">Unidad de medida <strong style="color: #dd4b39">*</strong>:
                        </label>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <select class="form-control" id="unidmed" name="unidmed" value="">
                        </select>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <label style="margin-top: 7px;">Punto de pedido<strong
                                style="color: #dd4b39">*</strong>:</label>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <input type="text" name="puntped" id="puntped" class="form-control">
                    </div>
                </div> <!-- /.modal-body -->

                <br>

                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <label style="margin-top: 7px;">¿Lotear Artículo?</label>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <input type="checkbox" name="es_loteado" id="es_loteado">
                    </div>
                </div> <!-- /.modal-body -->

                <div class="modal-footer ">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reset()">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-edit" id="btnSave" data-dismiss="modal"
                        onclick="guardareditar()">Guardar</button>
                </div> <!-- /.modal footer -->

            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog modal-lg -->
    </div> <!-- /.modal fade -->