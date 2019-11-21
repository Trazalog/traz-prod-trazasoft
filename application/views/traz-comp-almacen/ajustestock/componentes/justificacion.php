<div class="box box-primary tag-descarga">
    <div class="box-body">
        <div class="form-group">
            <label for="">Justificacion:</label>
            <textarea style="resize: none;" type="text" class="form-control input-sm" rows="5" id="descripcion"
                name="descripcion" required></textarea>
        </div>
        <div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                <button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
var fila = null;

function agregarFila(data) {
    $('#lotes').append(
        `<tr data-json='${JSON.stringify(data)}'>"
            <td class="text-center"><i class="fa fa-times text-danger" onclick="fila = $(this).closest('tr'); $('#eliminar_fila').modal('show');"></i></td>
            <td>${data.origen.lote_id}</td>
            <td>${$('.frm-destino #art-detalle').val()}</td>
            <td>${data.destino.cantidad + ' | ' + data.destino.unidad_medida}</td>
            <td>${data.destino.lote_id}</td>
        </tr>`
    );

    $('#guardarDescarga').attr('disabled', false);
}

function guardarDescargaOrigen() {

    //Guardar Datos de Camión parametro = FALSE es para NO mostrar el MSJ de Datos Guardados
    addCamion(false);

    var array = [];
    $('#lotes tr').each(function() {
        array.push(JSON.parse(this.dataset.json));
    });

    if (!array) return;

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'index.php/general/Camion/guardarDescarga',
        data: {
            array
        },
        success: function(rsp) {
            if (rsp.status == true) {
                alert('Hecho');
                linkTo();
            } else {
                alert('Falla al Guardar Descarga');
            }
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        }
    });
}

function eliminarFila() {
    var json = getJson($(fila));
    if (!json) return;
    $('.frm-origen #cantidad').val(parseFloat($('.frm-origen #cantidad').val()) + parseFloat(json.destino.cantidad));
    $(fila).remove();

    $('#guardarDescarga').attr('disabled', $('#lotes tr').length == 0);
}
</script>

<div class="modal fade" id="eliminar_fila" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center">¿Desea Eliminar Registro?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="eliminarFila()">Si</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>