<div class="box box-primary tag-descarga">
    <div class="box-header">
        <i class="fa fa-sign-in"></i>
        <h3 class="box-title"> Destino</h3>
    </div>
    <div class="box-body">
        <form id="frm-destino" class="frm-destino">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Código Lote:</label>
                        <input name="lote_id" class="form-control req" type="text" id="codigo">
                        <small class="help-block"><a class="pull-right" href="#frm-origen"
                                onclick="$(this).closest('.form-group').find('input').val()">#
                                Copiar Lote
                                Origen</a></small>
                    </div><br>
                </div>
                <div class="col-md-12">
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
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Unidad Medida:</label>
                        <input disabled id="unidad_medida" list="unidades" name="unidad_medida" class="form-control req"
                            type="text">
                        <datalist id="unidades" class="unidades">

                        </datalist>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input name="cantidad" class="form-control req" type="number">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Destino:</label> <!--
                        <input list="recipientes" name="reci_id" class="form-control req" type="text" id="recipiente"
                            placeholder="< Seleccionar >">
                        <datalist id="recipientes">

                        </datalist> -->

                        <?php
                            echo selectBusquedaAvanzada('recipiente', 'reci_id')
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" style="margin-top:23px; float:right;"
                        onclick="agregarRegistro();"><i class="fa fa-plus"></i> Agregar</button>
                </div>
            </div>
            <input type="text" name="unificar" value="false" class="hidden" id="unificar" placeholder="< Seleccionar >">
        </form>

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

    origen.prov_id = $('#proveedor').val();
    origen.batch_id = batch;

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
        url: 'index.php/general/Recipiente/obtenerOpciones?tipo=DEPOSITO&estado=TODOS&opciones=true',
        success: function(rsp) {
            if (!rsp.status) {
                alert('No se encontraron Recipientes');
                return;
            }

            $('#recipiente').html(rsp.status);
        },
        error: function(rsp) {
            alert('Error al Obtener Recipientes');
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