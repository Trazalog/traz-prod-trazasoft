<div class="box box-primary tag-descarga">
    <div class="box-header with-border">
        <i class="fa fa-sign-in"></i>
        <h3 class="box-title"> Destino</h3>
    </div>
    <div class="box-body" id="div_destino">
        <form id="frm-destino" class="frm-destino">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Código Lote<?php hreq() ?>:</label>
                        <input name="lote_id" class="form-control req" type="text" id="codigo">
                        <small class="help-block">
                            <a class="pull-right" href="#frm-destino" onclick="$(this).closest('.form-group').find('input').val($('#new_codigo').hasClass('hidden')?$('#codigo').select2('data')[0].text:$('#new_codigo').val())">
                                # Copiar Lote Origen
                            </a>
                        </small>
                    </div><br>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Producto<?php hreq() ?>:</label>
                        <input list="articulos" name="arti_id" class="form-control inp-descarga req" type="text" id="articulo" readonly>
                        <small class="help-block">
                            <a class="pull-right" href="#frm-origen" onclick="$('.frm-destino #articulo').val($('.frm-origen #articulo').val())">
                                # Copiar Producto Origen
                            </a>
                        </small>
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
                        <label>Unidad Medida<?php hreq() ?>:</label>
                        <input readonly id="unidad_medida" list="unidades" name="unidad_medida" class="form-control req"
                            type="text">
                        <datalist id="unidades" class="unidades">
                        </datalist>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cantidad<?php hreq() ?>:</label>
                        <input name="cantidad" class="form-control req" type="number">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group ba">
                        <label>Destino:</label>
                        <!--
                        <input list="recipientes" name="reci_id" class="form-control req" type="text" id="recipiente" placeholder="< Seleccionar >">
                        <datalist id="recipientes">
                        </datalist> -->
                        <?php
                            echo selectBusquedaAvanzada('recipiente', 'reci_id', false, false, false, false, false, 'revisarRecipiente(this)')
                        ?>
                    </div>
                </div>
                <div class="col-md-8" id="bloque_etapa" hidden="true">
                    <div class="form-group ba">
                        <label>Etapa:</label>
                        <?php
                            echo selectBusquedaAvanzada('proceso', 'etapa_etap_id', false, false, false, false, false, false)
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" style="margin-top:23px; float:right;"><i class="fa fa-plus"></i>
                        Agregar
                    </button>
                </div>
            </div>
            <input type="text" name="unificar" value="false" class="hidden" id="unificar" placeholder="< Seleccionar >">
        </form>

    </div>
    <!-- box-body -->
</div>
<!-- box -->

<script>
$('#frm-destino').on('submit', function(e) {
    e.preventDefault();
    // console.log('prov_id:' + $('#proveedor').val());
    if (!validar($('#frm-destino'))) {
        alert('Complete los Campos Obligatorios');
        return;
    }
    var json = getJson($('#recipiente'));
    if ($('#recipiente').value == '0' || !json) return;
    validarRecipiente(json);
    if (vacio || $('#unificar').val() == "true") {
        var fo = new FormData($('#frm-origen')[0]);
        var fd = new FormData($('#frm-destino')[0]);
        origen = formToObject(fo);
        destino = formToObject(fd);
        origen.prov_id = $('#proveedor').val();
        origen.batch_id = batch;
        destino.recipiente = $("#recipiente").find(':selected').text();        
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
});
//Busca los recipientes de un establecimiento seleccionado
//se llama en el onchange del select de establecimiento
function obtenerRecipientes() {
    // console.log('Obtener Recipientes');    
    esta_id = $("#establecimientos").val();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Recipiente/obtenerOpciones?tipo=DEPOSITO&estado=TODOS&establecimiento=' + esta_id,
        success: function(rsp) {
            if (rsp.status && _isset(rsp.data)) {
                $('#recipiente').html(rsp.data);
            }else{
                $('#recipiente').html('');
                error('Error!','No se encontraron Recipientes en el establecimiento seleccionado');
            }
        },
        error: function(rsp) {
            alert('Error al Obtener Recipientes');
        }
    });
}
//Busca las etapas de un recipiente seleccionado siempre y cuando sea DEPOSITO/PRODUCTIVO
//se llama en el onchange del select de recipientes
function revisarRecipiente(elem) {
    console.log('Obtener Etapas');
    // dataJsoncito = JSON.parse($(tag).closest('tr').attr('data-json'));  
    var recipiencito = JSON.parse($(elem).attr("data-json"));
    // console.log(recipiencito);  
    if (recipiencito.tipo == "DEPOSITO/PRODUCTIVO") {
        console.log(recipiencito);
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '<?php echo base_url(PRD) ?>general/Etapa/getProcesosEtapas',
            success: function(rsp) {
                if (rsp.status && _isset(rsp.data)) {
                    $('#proceso').html(rsp.data);
                    // $('#proceso').show();
                    $('#bloque_etapa').attr('hidden', false);
                    // $('#proceso').removeAttr("disabled");
                }else{
                    $('#proceso').html('');
                    error('Error!','No se encontraron Etapas en el establecimiento seleccionado');
                }
            },
            error: function(rsp) {
                alert('Error al Obtener Etapas');
            }
        });
    };   
}
//Busca las etapas de un recipiente seleccionado siempre y cuando sea DEPOSITO/PRODUCTIVO
//se llama en el onchange del select de recipientes
function obtenerEtapas() {
    console.log('Obtener Etapas');    
    reci_id = $("#recipiente").val();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Recipiente/obtenerOpciones?tipo=DEPOSITO&estado=TODOS&establecimiento=' + reci_id,
        success: function(rsp) {
            if (rsp.status && _isset(rsp.data)) {
                $('#recipiente').html(rsp.data);
            }else{
                $('#recipiente').html('');
                error('Error!','No se encontraron Etapas en el establecimiento seleccionado');
            }
        },
        error: function(rsp) {
            alert('Error al Obtener Etapas');
        }
    });
}
// $('#recipiente').on('change', function() {
//     var json = getJson(this);
//     if (this.value == '0' || !json) return;
//     validarRecipiente(json);
// });

var vacio = false;
function validarRecipiente(json) {
    if (json.estado == 'VACIO'){
        $('#unificar').val(false);
        vacio = true;
        return;
    }
    vacio = false; 
    var arti_id = $('.frm-destino #articulo').attr('data-id');
    var lote_id = $('.frm-destino #codigo').val();
    wo();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        async: false,
        url: `<?php echo base_url(PRD.'general/recipiente/obtenerContenido/')?>${json.reci_id}`,
        success: function(res) {
            console.log(res);
            if (res.status && res.data) {
                var ban = true;
                res.data.forEach(function(e) {
                    if (e.arti_id != arti_id || e.lote_id != lote_id) {
                        ban = false;
                    }
                })

                if (!ban) {
                    error('Error','No se pueden mezclar distintos artículos y distintos lotes en un mismo recipiente');
                    $('#unificar').val(false);
                    return;
                }
                const confirm = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    });

                confirm.fire({
                    title: 'Confirmación',
                    text: "¿Desea mezclar los artículos en el recipiente?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    
                    if (result.value) {
                        $('#unificar').val(result.value);
                    } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                        $('#unificar').val(result.value);
                    }
                });

                // $('#unificar').val(result.value);

            } else {
                error('Error','Error al traer contenido del recipiente');
                $('#unificar').val(false);
            }
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