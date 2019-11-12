<div class="box box-primary tag-descarga">
    <div class="box-header">
        <h3 class="box-title"> Ingreso <span id="origen"> - </span></h3>
    </div>
    <div class="box-body">
        <form id="frm-origen" class="frm-origen">
            <input type="text" name="batch_id" id="batch_id" >
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Código Lote:</label>
                        <input list="codigos" name="lote_id" class="form-control" type="text" id="codigo">
                        <datalist id="codigos">
                            <!-- LOTES POR CAMION -->
                        </datalist>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Producto:</label>
                        <input list="articulos" name="arti_id" class="form-control inp-descarga" type="text"
                            id="articulo">
                        <datalist id="articulos">

                        </datalist>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top:7px">
                    <div class="form-group">
                        <label for="">Descripción:</label>
                        <textarea type="text" class="form-control" id="art-detalle" disabled></textarea>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Unidad Medida:</label>
                        <input list="unidades" name="unidad_medida" class="form-control inp-descarga" type="text"
                            id="um">
                        <datalist id="unidades" class="unidades">

                        </datalist>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input name="cantidad" class="form-control inp-descarga" type="number" id="cantidad">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- box-body -->
</div>
<!-- box -->

<script>
var batch = null;
$('.frm-origen #codigo').on('change', function() {
    var json = getJson($('#codigos [value="' + this.value + '"]'));
    if (!json) return;

    $('.frm-origen #articulo').val(json.arti_id);
    $('.frm-destino #articulo').val(json.arti_id);
    $('.frm-origen #um').val(json.um);
    $('.frm-origen #cantidad').val(json.cantidad);
    batch = json.batch_id;
    $('.inp-descarga').attr('readonly', true);

    //Rellenar Inputs Informacion
    var desc = $('.frm-origen #articulos [value="' + json.arti_id + '"]').html()
    $('.frm-origen #art-detalle').val(desc);
    $('.frm-destino #art-detalle').val(desc);

});

$('.frm-origen #articulo').on('change', function() {
   var desc = $('.frm-origen #articulos [value="' + this.value + '"]').html()
    $('.frm-origen #art-detalle').val(desc);
    $('.frm-destino #art-detalle').val(desc);
    $('.frm-destino #articulo').val(this.value);
});



obtenerUM();

function obtenerUM() {
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'index.php/traz-comp/Parametro/obtener?tabla=unidades_medida',
        success: function(rsp) {

            if (!rsp.status) {
                alert('Error al Traer las Unicadades de Medida');
                return;
            }

            rsp.data.forEach(function(i, e) {
                $('.unidades').append(
                    `<option value="${i.valor}">${i.descripcion}</option>`
                );
            });
        },
        error: function(rsp) {
            alert('Error: No se pudo Obtener Unidades Medida');
        }
    });
}

obtenerArticulos();
function obtenerArticulos() {
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'index.php/<?php echo ALM ?>Articulo/obtener',
        success: function(rsp) {
            console.log(rsp);

            if (!rsp.status) {
                alert('No hay Articulos Disponibles');
                return;
            }
            rsp.data.forEach(function(e, i) {
                $('.frm-origen #articulos').append(
                    `<option value="${e.id}">${e.barcode} | ${e.titulo}</option>`
                );
            });
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        }
    });
}
</script>