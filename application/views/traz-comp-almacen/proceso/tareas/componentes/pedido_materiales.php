<input id="pema_id" type="number" class="hidden" value="<?php echo (isset($info->pema_id)?$info->pema_id:null)?>">
<input id="ortr_id" type="number" class="hidden" value="<?php echo (isset($info->ortr_id)?$info->ortr_id:null)?>">

<div class="row">
    <div
        class="<?php echo (isset($info->pema_id)?'hidden':null)?>  col-xs-12 col-sm-12 col-md-12 <?php echo(viewOT?'hidden':null)?>">
        <div class="form-group">
            <label>Justificacíon:</label>
            <textarea id="just" type="text" class="form-control <?php echo (isset($info->pema_id)?'hidden':null)?>"
                placeholder="Ingrese Justificación..."></textarea>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <label>Seleccionar Artículo:</label>
            <?php $this->load->view(ALM.'articulo/componente'); ?>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label>Cantidad:</label>
            <input id="add_cantidad" type="number" min="0" step="1" class="form-control" placeholder="Cantidad">
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3" style="margin-top:25px">
        <button class="btn btn-primary" onclick="guardar_pedido();"><i class="fa fa-check"></i>Agregar</button>
    </div>
</div>
<table id="tabladetalle2" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th width="1%">Acciones</th>
            <th>Artículo</th>
            <th class="text-center">Cantidad</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="modal-footer <?php echo (isset($info->pema_id)?'hidden':null)?>">
    <?php
    if(isset($info->modal))
    {
        echo '<button class="btn btn-primary" style="float:right;"
        onclick="lanzarPedidoModal()">Hecho</button>';
    }else{
    echo '<button class="btn btn-primary" style="float:right;"
        onclick="lanzarPedido()">Hecho</button>';
    }
        ?>
</div>
<script>
var tablaDetalle2 = $('#tabladetalle2').DataTable({});
var selectRow = null;

get_detalle();

function del(e) {
    selectRow = $(e).closest('tr');
    $('#eliminar').modal('show');
}

function del_detalle() {
    if (selectRow.hasClass('new')) $(selectRow).remove();
    else {
        $.ajax({
            type: 'POST',
            data: {
                id: $(selectRow).data('id')
            },
            url: 'index.php/<?php echo ALM ?>Notapedido/eliminarDetalle',
            success: function(data) {
                //$('.modal #eliminar').modal('hide');
                $('#eliminar').modal('hide');

                get_detalle();
            },
            error: function(data) {
                alert('Error');
            }
        });
    }
}

function edit() {

    var id = $(selectRow).closest('tr').data('id');
    var cantidad = $('#set_cantidad #cantidad').val();
    wo();
    $.ajax({
        type: 'POST',
        data: {
            id,
            cantidad
        },
        url: 'index.php/<?php echo ALM ?>Notapedido/editarDetalle',
        success: function(data) {
            get_detalle();
            selectRow = null;
            $('#set_cantidad').modal('hide');
        },
        error: function(data) {
            alert('Error');
        },
        complete:function() {
            wc();
        }
    });

}

function edit_cantidad(e) {
    selectRow = $(e).closest('tr');
    $('#set_cantidad input').val($(selectRow).find('.cantidad').html());
    $('#set_cantidad h5').html($(selectRow).find('.articulo').html());
    $('#set_cantidad').modal('show');
}


function get_detalle() {
    var id = $('#pema_id').val();
    if (id == null || id == '') {
        return;
    }
    $.ajax({
        type: 'POST',
        url: 'index.php/<?php echo ALM ?>Notapedido/getNotaPedidoId?id_nota=' + id,
        success: function(data) {
            tablaDetalle2.clear();

            for (var i = 0; i < data.length; i++) {
                var tr = "<tr class='celdas' data-id='" + data[i]['depe_id'] + "'data-id='" + data[i][
                        'arti_id'
                    ] + "' data-json='" + JSON.stringify(data) + "'>" +
                    "<td class='text-light-blue'>" +
                    "<i class='fa fa-fw fa-pencil' style='cursor: pointer;' title='Editar' onclick='edit_cantidad(this)'></i>" +
                    "<i class='fa fa-fw fa-times-circle' style='cursor: pointer;' title='Eliminar' onclick='del(this);'></i></td>" +
                    "<td class='articulo'>" + data[i]['barcode'] + "</td>" +
                    "<td class='cantidad text-center'>" + data[i]['cantidad'] + "</td></tr>";
                tablaDetalle2.row.add($(tr)).draw();
            }

        },
        error: function(result) {

            console.log(result);
        },
        dataType: 'json'
    });
}
</script>


<div class="modal fade" id="set_cantidad">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ingresar Cantidad</h4>
            </div>
            <div class="modal-body">
                <h5 class="text-center"></h5>
                <input id="cantidad" class="form-control text-center" type="number" placeholder="Cantidad">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-accion" data-dismiss="modal"
                    onclick="edit()">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal eliminar-->
<div class="modal" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"
                        class="fa fa-fw fa-times-circle text-light-blue"></span> Eliminar Artículo</h4>
            </div> <!-- /.modal-header  -->

            <div class="modal-body" id="modalBodyArticle">
                <h4 class="text-center">¿Confirmar Operación? </h4>
            </div> <!-- /.modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="del_detalle()">Eliminar</button>
            </div> <!-- /.modal footer -->

        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog modal-lg -->
</div> <!-- /.modal fade -->
<!-- / Modal -->


<script>
//('#tabladetalle2').dataTable({});
function guardar_pedido() {

    if (!validarCampos()) {
        alert('Completar Campos');
        return;
    }

    if ($('#pema_id').val() == '' || $('#pema_id').val() == 0) {

        set_pedido();

    } else {

        edit_pedido();

    }
}

function set_pedido() {

    var idinsumos = new Array();
    var cantidades = new Array();

    id = selectItem.arti_id;
    idinsumos.push(id);
    cant = $('#add_cantidad').val();
    cantidades.push(cant);

    var idOT = $('#ortr_id').val();

    if (idinsumos.length == 0) {
        alert('Error');
        return;
    }

    var peex_id = $('#peex_id').val();
    var justificacion = $('#just').val();

    wo("Guardando pedido...");

    $.ajax({
        data: {
            idinsumos,
            cantidades,
            idOT,
            peex_id,
            justificacion
        },
        type: 'POST',
        dataType: 'json',
        url: 'index.php/<?php echo ALM ?>Notapedido/setNotaPedido',
        success: function(result) {
            console.log('setNotaPedido: ');
            
            console.log(result);
            
            $('#pema_id').val(result.pema_id);
            wc();
            get_detalle();
            clear();
        },
        error: function() {

            data = {
                arti_id: id,
                cantidad: cant
            };
            var tr = "<tr class='celdas' data-json='[" + JSON.stringify(data) + "]'>" +
                "<td class='text-light-blue'>" +
                "<i class='fa fa-fw fa-pencil' style='cursor: pointer;' title='Editar' onclick='edit_cantidad(this)'></i>" +
                "<i class='fa fa-fw fa-times-circle' style='cursor: pointer;' title='Eliminar' onclick='del(this);'></i></td>" +
                "<td class='articulo'>" + document.getElementById('inputarti').value + "</td>" +
                "<td class='cantidad text-center'>" + data.cantidad + "</td></tr>";
            tablaDetalle2.row.add($(tr)).draw();
            wc();

        },
    });
}

function lanzarPedido() {
    $.ajax({
        data: {
            id: $('#pema_id').val()
        },
        dataType: 'json',
        type: 'POST',
        url: '<?php echo base_url(ALM) ?>new/Pedido_Material/pedidoNormal',
        success: function(result) {
            if (result.status) {
                linkTo('<?php echo ALM ?>Notapedido');
            } else {
                alert(result.msj);
            }
        },
        error: function(result) {
            wc();
            alert("Error al Lanzar Pedido");
        }
    });
}

function lanzarPedidoModal() {

    console.log('ALM | Pedido Materiales...');

    notaid = document.getElementById('pema_id').value;
    idOT = document.getElementById('ortr_id').value;
    descripcion = document.getElementById('descripcionOT').value;

    fecha = new Date();
    mes = fecha.getMonth() + 1;
    dia = fecha.getDate();
    año = fecha.getFullYear();
    fecha = dia + '/' + mes + '/' + año;
    document.getElementById('pema_id').value = null;
    modal = '<?php #echo $info->modal;?>';
    data = {
        id_notaPedido: notaid,
        fecha: fecha,
        id_ordTrabajo: idOT,
        descripcion: descripcion,
        justificacion: "",
        estado: " Esperando Conexión.."
    };
    html = "";
    html += "<tr data-json='" + JSON.stringify(data) + "' id='" + data.id_notaPedido + "'>";
    html +=
        '<td class="text-center"> <i onclick="ver(this)" class="fa fa-fw fa-search text-light-blue buscar" style="cursor: pointer;margin:5px;" title="Detalle Pedido Materiales"></i> </td>';
    html += '<td class="text-center"><span data-toggle="tooltip" title="" class="badge bg-blue estado">' + data
        .id_notaPedido + '</span></td>';
    html += '<td class="text-center"><span data-toggle="tooltip" class="badge bg-yellow estado">' + data.id_ordTrabajo +
        '</span></td>';
    html += '<td class="text-center">' + data.fecha + '</td>';
    html += '<td>' + data.descripcion + ' ' + data.justificacion + '</td>';
    html += '<td class="text-center ped-estado">' + data.estado + '</td>';
    html += '</tr>';

    tablaDeposito.row.add($(html)).draw();

    //Guardar Estado en Sesion
    guardarEstado($('#task').val() + '_pedidos', html);

    var articulos = [];
    $('#tabladetalle2 tbody').find('tr').each(function() {
        json = "";
        json = JSON.parse($(this).attr('data-json'));
        articulos.push(json[0]);
    });
    articulos = JSON.stringify(articulos);
    console.log(articulos);

    if (conexion()) {
        $.ajax({
            type: 'POST',
            url: 'index.php/<?php echo ALM ?>Notapedido/pedidoNormal/' + notaid,
            success: function() {
                $('#' + notaid).find('.ped-estado').html(
                    '<span data-toggle="tooltip" title="" class="badge bg-orange estado">Solicitado</span>'
                    );
                alert('Hecho');
            },
            error: function() {
                console.log('ALM | Error Pedido Materiales');
            }
        });
    } else {
        ajax({
            data: {
                articulos: articulos,
                idOT: idOT
            },
            type: 'POST',
            url: 'index.php/<?php echo ALM ?>Notapedido/pedidoOffline',
            success: function(result) {
                console.log('OFFLINE | Pedido Material Enviado');

            },
            error: function(result) {
                console.log('ALM | Error Pedido Materiales');
            }
        });
    }

    $('#' + modal).modal('hide');
}

function edit_pedido() {

    var idinsumos = new Array();
    var cantidades = new Array();

    id = selectItem.arti_id;
    idinsumos.push(id);
    cant = $('#add_cantidad').val();
    cantidades.push(cant);

    var idOT = $('#ortr_id').val();

    if (idinsumos.length == 0) {
        alert('Error');
        return;
    }

    wo("Guardando pedido...");

    $.ajax({
        data: {
            idinsumos,
            cantidades,
            idOT,
            pema: $('#pema_id').val()
        },
        type: 'POST',
        dataType: 'json',
        url: 'index.php/<?php echo ALM ?>Notapedido/editPedido',
        success: function(result) {
            wc();
            get_detalle();
            clear();
        },
        error: function(result) {
            alert('editesrt');
            wc();
            //  alert("Error en guardado...");
        }
    });
}

function validarCampos() {

    if ($('#inputarti').val() == null) return false;

    if ($('#add_cantidad') == null) return false;

    return true;
}

function clear() {
    $('#inputarti').val(null);
    $('#add_cantidad').val(null);
}
//Rearmo ajax para guardar Post en indexedDB//

function ajax(options) {
    if (navigator.serviceWorker.controller) {
        navigator.serviceWorker.controller.postMessage(options.data)
    }

    return $.ajax(options);
}
//Fin redifinicion//
</script>