<div class="box box-primary tag-descarga" id="bloque_descarga">
    <div class="box-header">
        <i class="fa fa-sign-in"></i>
        <h3 class="box-title"> Ingreso <span id="origen"></span></h3>
    </div>
    <div class="box-body">
        <form id="frm-origen" class="frm-origen">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Código Lote:</label>
                        <input type="text" id="new_codigo" name="lote_id" class="form-control hidden" disabled
                            style="margin-botton:-500px">
                        <?php
                            echo selectBusquedaAvanzada('codigo', 'lote_id');
                        ?>
                        <!-- <small class="help-block"></small> -->
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Producto:</label>
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
                        <label>Unidad Medida:</label>
                        <input list="unidades" name="unidad_medida" class="form-control inp-descarga" type="text"
                            id="um" placeholder="< Seleccionar >">
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
$('#new_codigo').removeClass('hidden').attr('disabled', false);
$('#frm-origen #codigo').attr('disabled', true).next(".select2-container").hide();

var batch = null;
$('.frm-origen #codigo').on('change', function() {
    $('.frm-destino')[0].reset();
    $('.frm-destino').find('#recipiente').val("0").trigger('change');
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
        url: 'index.php/<?php echo ALM ?>Articulo/obtener/true',
        success: function(rsp) {
            console.log(rsp);

            if (!rsp.status) {
                alert('No hay Articulos Disponibles');
                return;
            }

            var obj = $('.frm-origen #articulos');
            fillSelect(obj, rsp.data);
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        }
    });
}


$('.frm-origen #um').on('change', function() {
    $('.frm-destino #unidad_medida').val(this.value);
});

//Cambios Mauri

//Cuando no hay lotes asociados busca por codigo de lote, lotes internos registrados en el sistema
$('#new_codigo').keyup(function(e) {
    loteSistema = false;
    if (e.keyCode === 13) {
        buscarLote(this.value);
    }
});


var loteSistema =  false;
var loteSistemaData = null;
function buscarLote(lote) {
    loteSistema =  false;
    wo();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'index.php/general/Lote/obtenerLote/'+lote,
        success: function(rsp) {
            console.log(rsp);
            
           if(rsp.status && rsp.data){
                var data = rsp.data[0];
                loteSistemaData = data;
                $('.frm-origen #articulos').val(data.arti_id).trigger('change');
                $('.frm-origen #cantidad').val(data.cantidad);
                $('.frm-origen #um').val(data.unidad_medida);
                $('.frm-destino #unidad_medida').val(data.unidad_medida);
                loteSistema = true;
           }
        },
        error: function(rsp) {
            alert('Error');
        },
        complete:function(){
            wc();
        }
    });
}
</script>