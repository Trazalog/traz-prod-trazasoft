<div class="panel panel-default">
    <div class="panel-heading">
        Artículo: <?php echo $articulo['descripcion'] ?>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label for="comprobante">Cantidad Pedida:</label>
                <input id="tit_pedida" type="text" class="form-control" disabled>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label for="fecha">Cantidad Entregada:</label>
                <input id="tit_entregada" type="text" class="form-control" disabled>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label for="fecha">Cantidad en Stock:</label>
                <input id="tit_disponible" type="text" class="form-control" disabled>
            </div>

        </div>
        <hr>

        <div class="table-responsive">
            <table id="lotes" class="table table-striped">
                <thead>
                    <tr>
                        <th>Lote</th>
                        <th class="text-center">Fec. Vencimiento</th>
                        <th>Depóstio</th>
                        <th>Cantidad</th>
                        <th width="20%">a Entregar</th>
                    </tr>
                </thead>
                <tbody id="lotes_depositos">

                    <?php
foreach ($list as $o) {
    echo '<tr>';
    echo '<td>' . ($o['codigo']==1?'S/L':$o['codigo']) . '<input class="lote_depo hidden" value=\'' . json_encode(['lote_id' => $o['lote_id'], 'depo_id' => $o['depo_id'], 'arti_id' => $o['arti_id'], 'prov_id' => $o['prov_id'], 'empr_id' => $o['empr_id']]) . '\'></td>';
    echo '<td class="text-center">' . fecha($o['fec_vencimiento']) . '</td>';
    echo '<td>' . $o['descripcion'] . '</td>';
    echo '<td class="cant_lote">' . $o['cantidad'] . '</td>';
    echo '<td><input min="0" step="1" pattern="\d*" class="form-control cantidad" placeholder="Ingrese Cantidad..." type="number" name="cantidad" onkeyup="verificar_cantidad();"></td>';
    echo '</tr>';
}
?>

                </tbody>
                <tfoot>
                    <tr>
                        <th rowspan="3" colspan="3" class="text-danger text-center" style="font-size: 130%">
                            <label id="msj" style="display: none;">!</label>
                        </th>
                        <th style="font-size: 130%" class="text-right">
                            Total a Entregar:
                        </th>
                        <th id="totalExtraer" style="font-size: 130%" class="text-center">
                            0
                        </th>
                    </tr>
                </tfoot>
                <!-- <tfoot>
                <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="2" colspan="2">Engine version</th></tr>
                </tfoot> -->
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn btn-default" onclick="$('.modal').modal('hide')">Cerrar</button>
            <button class="btn btn-primary" id="btn-extraccion" onclick="guardar_entrega()" disabled>Guardar</button>
        </div>
        
    </div>
</div>

<script>
index();

function index() {
    $('#tit_pedida').val($(select_row).find('.pedido').html());
    $('#tit_entregada').val($(select_row).find('.entregado').html());
    $('#tit_disponible').val($(select_row).find('.disponible').html());
}

function guardar_entrega() {

    if (!verificar_cantidad()) return;

    var array = [];

    var sum = 0;

    $('#lotes_depositos tr').each(function(i, e) {

        var input = $(e).find('.lote_depo').val();

        var aux = JSON.parse(input);

        var num = $(e).find('.cantidad').val();

        if (!isNaN(num) && num != 0) {
            aux.cantidad = Math.trunc(num);
            array.push(aux);
            sum += parseInt(num);
        }

    });

    $(select_row).find('.extraer').html(sum);
    //Calcular Restante
    $(select_row).attr('resto', parseInt($(select_row).find('.pedido').html()) - (parseInt($(select_row).find(
        '.entregado').html()) + sum));

    $(select_row).attr('data-json', JSON.stringify(array));

    $('.modal').modal('hide');

}

function actualizar_entregas() {
    $.ajax({
        url: '<?php echo ALM ?>Notapedido/getTablaDetalle/' + $('#pema').val(),
        type: 'POST',
        success: function(data) {
            $('#entregas').empty();
            $('#entregas').html(data);
        },
        error: function(error) {
            alert('Error');
        }
    });
}



function verificar_cantidad() {

    var disponible = parseInt($(select_row).find('.disponible').html());
    var pedido = parseInt($(select_row).find('.pedido').html());
    var entregado = parseInt($(select_row).find('.entregado').html());
    entregado = isNaN(entregado) ? 0 : entregado;

    var acum = 0;

    var excede = false;

    $('#lotes_depositos tr').each(function(i, e) {

        var cant_lote = parseInt($(e).find('.cant_lote').html());

        var cant_extraer = parseInt($(e).find('.cantidad').val());

        if (cant_extraer > cant_lote) {
            excede = true;
            return;
        }
        acum = acum + (isNaN(cant_extraer) ? 0 : cant_extraer);

    });

    $('#totalExtraer').html(acum);

    if (excede) {
        $('#msj').html('Supera la Cantidad del Lote');$('#msj').show();
        $('#btn-extraccion').prop('disabled', true);
        return false;
    }

    if (acum > disponible) {
        $('#msj').html('Supera la Cantidad Disponible');$('#msj').show();
        $('#btn-extraccion').prop('disabled', true);
        return false;
    }

    if ((acum + entregado) > pedido) {
        $('#msj').html('Supera la Cantidad Pedida');$('#msj').show();
        $('#btn-extraccion').prop('disabled', true);
        return false;
    }

    if( acum == 0){
        $('#btn-extraccion').prop('disabled', true);
        return false;
    }

    $('#msj').hide();

    excede = false;

    $('#btn-extraccion').prop('disabled', excede);

    return true;
}

$('table#lotes').DataTable({
    "aLengthMenu": [10, 25, 50, 100],
    "columnDefs": [{
            "targets": [0],
            "searchable": false
        },
        {
            "targets": [0],
            "orderable": false
        }
    ],
    "order": [
        [1, "asc"]
    ],
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
});
</script>