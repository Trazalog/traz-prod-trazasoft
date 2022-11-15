<div class="box box-primary tag-descarga">
		<div class="box-header with-border">
        <h3 class="box-title">Listado de Recepcion MP<span id="origen"></span></h3>
    </div>
    <div class="box-body">
        <table class="table table-striped table-hover">
            <thead>
                <th></th>
                <th>Cod. Origen</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Cod. Destino</th>
                <th>Recipiente</th>
                <th></th>
            </thead>
            <tbody id="lotes">

            </tbody>
        </table>
        <hr>
        <button id="guardarDescarga" class="btn btn-primary btn-sm" style="float:right"
            onclick="guardarEntradaNoCon();addCamion();" disabled><i
                class="fa fa-check"></i> Guardar Descarga</button>
								<!-- <button id="guardarDescarga" class="btn btn-primary btn-sm" style="float:right"
            onclick="guardarEntradaNoCon()"><i
                class="fa fa-check"></i> Guardar Descarga</button> -->
    </div>
</div>

<script>
var fila = null;
var rmFila = function(e){
    $(e).closest('tr').remove()
}
function agregarFila(data) {

    var lote_origen = $('#new_codigo').hasClass('hidden') ? $('#codigo').select2('data')[0].text : $('#new_codigo').val();

    $('#lotes').append(
        `<tr data-json='${JSON.stringify(data)}' class='lote'>
            <td class="text-center"><i class="fa fa-times text-danger" onclick="conf(rmFila, this)"></i></td>
            <td>${lote_origen}</td>
            <td>${$('.frm-destino #art-detalle').val()}</td>
            <td>${data.destino.cantidad + ' | ' + data.destino.unidad_medida}</td>
            <td>${data.destino.lote_id}</td>
            <td>${data.destino.recipiente}</td>
        </tr>`
    );

    $('#guardarDescarga').attr('disabled', false);
}

function guardarDescargaOrigen() {

    var array = [];
    $('#lotes tr.lote').each(function() {
        array.push(JSON.parse(this.dataset.json));
    });

    if (array.length == 0) return;
    
    //Si es externo utilizo otro método para el guardado
    if($("#esExterno").val() == 'externo'){
        guardarCargaCamionExterno(array);
    }else{
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo base_url(PRD) ?>general/Camion/guardarDescarga',
            data: {
                array
            },
            success: function(rsp) {
                if (rsp.status) {
                    console.log('Listado de Recepciones MP se realizó correctamente');
                    actualizarEstadoCamion($('#patente').val());
                } else {
                    error('Error','Fallo al guardar el listado de Recepciones MP');
                }
            },
            error: function(rsp) {
                error('Error','Error: ' + rsp.msj);
                console.log(rsp.msj);
            }
        });
    }
}
//Realiza el guardado de la carga del camion cuando es externo (haria las veces de la pantalla carga camion)
// esto quiere decir que no se realizo la carga de los lotes por sistema
// PARAM 'carga' es un array con los lotes cargados en la tabla de descarga
function guardarCargaCamionExterno(cargaCamion) {
    //Definida en entrada_camion.php, trae el formulario de info y camion juntos agregandole estado = 'EN CURSO'
    var frmCamion = obtenerFormularioCamion();

    if (cargaCamion.length == 0) return;

    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Camion/guardarCargaCamionExterno',
        data: {
            cargaCamion,
            frmCamion
        },
        success: function(rsp) {
            if (rsp.status) {
                hecho('Correcto','Se guardó la recepción con éxito');
                linkTo("traz-prod-trazasoft/general/Camion/recepcionCamion");
            } else {
                error('Error','Error al guardar la recepción');
            }
            
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        },
        complete: function() {
            wc();
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
// Actualizo los datos del movimiento con lso datos de recepcion
function actualizarEstadoCamion(patente) {
    var estado = 'TRANSITO|EN CURSO';
    var estadoFinal = 'DESCARGADO';
    var proveedor = $('#proveedor').val();
    var boleta = $('#boleta').val();
    var tara = $('#tara').val();
    var neto = $('#neto').val();
    var motr_id = $('#motr_id').val();
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/camion/estado',
        data: {patente, estado, estadoFinal, proveedor,boleta,tara,neto,motr_id},
        success: function(res) {
            hecho('Éxito','Se guardo la recepción del camión correctamente');
            linkTo("traz-prod-trazasoft/general/Camion/recepcionCamion");
        },
        error: function(res) {
            error();
        },
        complete: function() {
            wc();
        }
    });
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