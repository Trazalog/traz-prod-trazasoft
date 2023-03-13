<div class="box box-primary tag-descarga" id="bloque_descarga">
    <div class="box-header with-border">
        <i class="fa fa-sign-in"></i>
        <h3 class="box-title"> Ingreso <span id="origen"></span></h3>
    </div>
    <div class="box-body" id="div_ingreso">
        <form id="frm-origen" class="frm-origen">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Código Lote<?php hreq() ?>:</label>
                        <input type="text" id="new_codigo" name="lote_id" class="form-control hidden" disabled>
                        <?php
                            echo selectBusquedaAvanzada('codigo', 'lote_id');
                        ?>
                        <!-- <small class="help-block"></small> -->
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Producto<?php hreq() ?>:</label>
                        <?php
                            echo selectBusquedaAvanzada('articulos', 'arti_id');
                            ?>
                        <!-- <small class="help-block"></small> -->
                    </div>
                </div>
                <div class="col-md-12" style="margin-top:7px">
                    <div class="form-group">
                        <label for="">Descripción:</label>
                        <textarea type="text" class="form-control" id="art-detalle" disabled></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Unidad Medida<?php hreq() ?>:</label>
                        <input list="unidades" name="unidad_medida" class="form-control inp-descarga" type="text"
                            id="um" placeholder="< Seleccionar >">
                        <datalist id="unidades" class="unidades">

                        </datalist>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cantidad<?php hreq() ?>:</label>
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
$('#new_codigo').removeClass('hidden').attr('disabled', false);
$('#frm-origen #codigo').attr('disabled', true).next(".select2-container").hide();

var batch = null;
$('.frm-origen #codigo').on('change', function() {
    $('.frm-destino')[0].reset();
    $('.frm-destino').find('#recipiente').val(null).trigger('change');
    $('.frm-destino').find('#recipiente').parent().find('#detalle').empty();


    var json = getJson(this);
    if (!json) return;

    $('.frm-origen #articulos').val(json.arti_id).trigger('change');
    $('.frm-destino #articulos').val(json.arti_id).trigger('change');


    $('.frm-origen #um').val(json.um);
    $('.frm-destino #unidad_medida').val(json.um);
    $('.frm-origen #cantidad').val(json.cantidad);
    batch = json.batch_id;
    $('.inp-descarga').attr('readonly', true);

    //Rellenar Inputs Informacion
    var art = getJson($('.frm-origen #articulos'));

    $('.frm-origen #art-detalle').val(art.descripcion);
    $('.frm-destino #art-detalle').val(art.descripcion);

});

$('.frm-origen #articulos').on('change', function() {
    var art = getJson(this);
    $('.frm-origen #art-detalle').val(art.descripcion);
    $('.frm-destino #art-detalle').val(art.descripcion);
    $('.frm-destino #articulo').val($(this).find('option:selected').text());
    $('.frm-destino #articulo').attr('data-id', $(this).find('option:selected').val());
});



obtenerUM();

function obtenerUM() {
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '<?php echo base_url(ALM) ?>traz-comp/Parametro/obtener?tabla=unidades_medida',
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
        url: '<?php echo base_url(PRD) ?>general/Camion/obtenerArticulosPorTipo',
        success: function(rsp) {
            if (!rsp.status) {
                error('Error!','No hay materia prima disponible.');
                return;
            }

            var obj = $('.frm-origen #articulos');
            fillSelect(obj, rsp.data);
        },
        error: function(rsp) {
            error('Error','Error: ' + rsp.msj);
            console.log(rsp.msj);
        }
    });
}


$('.frm-origen #um').on('change', function() {
    $('.frm-destino #unidad_medida').val(this.value);
});
</script>