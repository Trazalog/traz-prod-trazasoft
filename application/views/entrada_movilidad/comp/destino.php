<div class="box box-primary">
    <div class="box-header">
        <i class="fa fa-pencil"></i>
        <h3 class="box-title"> Destino</h3>
    </div>
    <div class="box-body">
        <form id="frm-destino" class="frm-destino">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Código Lote:</label>
                        <input name="lote_id" class="form-control req" type="text" id="codigo">
                        <small class="help-block"><a class="pull-right" href="#frm-origen"
                                onclick="$('.frm-destino #codigo').val($('.frm-origen #codigo').val())"># Copiar Lote
                                Origen</a></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Producto:</label>
                        <input list="articulos" name="arti_id" class="form-control inp-descarga req" type="text"
                            id="articulo" readonly>
                        <small class="help-block"><a class="pull-right" href="#frm-origen"
                                onclick="$('.frm-destino #articulo').val($('.frm-origen #articulo').val())"># Copiar
                                Producto
                                Origen</a></small>
                        <datalist id="articulos">
                        
                        </datalist>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Descripción:</label>
                        <textarea type="text" class="form-control" id="art-detalle" disabled></textarea>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unidad Medida:</label>
                        <input list="unidades" name="unidad_medida" class="form-control req" type="text">
                        <datalist id="unidades" class="unidades">

                        </datalist>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input name="cantidad" class="form-control req" type="number">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Destino:</label>
                        <input list="recipientes" name="reci_id" class="form-control req" type="text" id="recipiente">
                        <datalist id="recipientes">

                        </datalist>
                    </div>
                </div>
            </div>
            <input type="text" name="unificar" value="false" class="hidden" id="unificar">
        </form>
        <button class="btn btn-primary btn-sm" style="float:right;" onclick="agregarRegistro();"><i
                class="fa fa-plus"></i> Agregar</button>
    </div>
    <!-- box-body -->
</div>
<!-- box -->

<script>
function agregarRegistro() {

    if (!validar($('#frm-destino'))) {
        alert('Complete los Campos Obligatorios');
        return;
    }

    var fo = new FormData($('#frm-origen')[0]);
    var fd = new FormData($('#frm-destino')[0]);

    origen = formToObject(fo);
    destino = formToObject(fd);

    if (parseFloat(origen.cantidad) <= 0 || parseFloat(destino.cantidad) > parseFloat(origen.cantidad)) {
        alert('La Cantidad Supera la Cantidad del Lote Origen');
        return;
    }
    $('.frm-origen #cantidad').val(origen.cantidad - destino.cantidad);
    var res = {
        origen,
        destino
    };
    agregarFila(res);
}

obtenerRecipientes();

function obtenerRecipientes() {
    console.log('Obtener Recipientes');
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'index.php/general/Recipiente/obtener?tipo=DEPOSITO&estado=TODOS',
        success: function(rsp) {
            if (!rsp.status) {
                alert('No se encontraron Recipientes');
                return;
            }
            rsp.data.forEach(e => {
                // Rellenar Select Recipientes
                $('#recipientes').append(
                    `<option value="${e.reci_id}" data-json='${JSON.stringify(e)}'>${e.nombre}</option>`
                );

            });
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        }
    });
}
$('#recipiente').on('change', function() {
    var json = getJson($('.frm-destino #recipientes [value="' + this.value + '"]'));
    if (!json) return;
    validarRecipiente(json);
});

function validarRecipiente(json) {

    if (json.estado == 'VACIO') return;

    var arti_id = $('.frm-destino #articulo').val();
    var lote_id = $('.frm-destino #codigo').val();

    if (json.arti_id != arti_id || json.lote_id != lote_id) {
        alert('No se pueden mezclar Distintos Articulos y Distintos Lotes en un mismo Recipiente');
        $('#recipiente').val('');
        return;
    }

    if (confirm('¿Desea mezclar los Artículos en el Recipiente?') != true) {
        $('#recipiente').val('');
        return;
    }

    $('#unificar').val(true);

}
</script>