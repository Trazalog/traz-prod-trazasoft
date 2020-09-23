<hr>
<input type="number" class="hidden" value="<?php echo $pema_id ?>" id="pemaId">
<h3>Pedido Materiales <small>Detalle</small></h3>
<div id="nota_pedido">
    <table id="tabladetalle" class="table table-striped table-hover">
        <thead>
            <tr>
                <!-- <th>Código</th> -->
                <th>Descripcion</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Fecha Nota</th>
            </tr>
        </thead>
        <tbody>
            <!--Detalle Pedido Materiales -->
        </tbody>
    </table>
</div>
<hr>

<form id="generic_form">
    <div class="form-group">
        <center>
            <h4 class="text-danger"> ¿Se Aprueba o Rechaza el Pedido de Materiales? </h4>
            <label class="radio-inline">
                <input type="radio" name="result" value="true"
                    onclick="$('#motivo').hide();$('#hecho').prop('disabled',false);"> Aprobar
            </label>
            <label class="radio-inline">
                <input id="rechazo" type="radio" name="result" value="false"
                    onclick="$('#motivo').show();$('#hecho').prop('disabled',false);"> Rechazar
            </label>
        </center>
    </div>

    <div id="motivo" class="form-group motivo">
        <textarea class="form-control" name="motivo_rechazo" placeholder="Motivo de Rechazo..."></textarea>
    </div>
</form>

<script>
$('#motivo').hide();
$('#hecho').prop('disabled', true);



cargarPedidos();

function cargarPedidos() {
    var id = $('#pemaId').val();
    $.ajax({
        type: 'POST',
        url: 'index.php/<?php echo ALM ?>Notapedido/getNotaPedidoId?id_nota=' + id,
        success: function(data) {

            $('tr.celdas').remove();
            for (var i = 0; i < data.length; i++) {
                var tr = "<tr class='celdas'>" +
                    "<td>" + data[i]['artDescription'] + "</td>" +
                    "<td class='text-center'>" + data[i]['cantidad'] + "</td>" +
                    "<td class='text-center'>" + data[i]['fecha'] + "</td>" +
                    "</tr>";
                $('table#tabladetalle tbody').append(tr);
            }
            $('.table').DataTable();
        },
        error: function(result) {

            console.log(result);
        },
        dataType: 'json'
    });
}

function cerrarTarea() {

    if ($('#rechazo').prop('checked') && $('#motivo .form-control').val() == '') {
        alert('Completar Motivo de Rechazo');
        return;
    }

    var id = $('#taskId').val();

    var dataForm = new FormData($('#generic_form')[0]);

    dataForm.append('pema_id', $('#pemaId').val());

    $.ajax({
        type: 'POST',
        data: dataForm,
        cache: false,
        contentType: false,
        processData: false,
        url: '<?php base_url() ?>index.php/<?php echo BPM ?>Proceso/cerrarTarea/' + id,
        success: function(data) {
            //wc();
            back();

        },
        error: function(data) {
            alert("Error");
        }
    });

}
</script>