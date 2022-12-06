<!-- Modal ALTA NC's masivamente -->
<div class="modal fade bd-example-modal-md" tabindex="-1" id="mdl-altaMasivaNCs" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mdl-titulo">Generar No Consumibles Masivo</h4>
            </div>
            <div class="modal-body" id="modalBody">
                <form class="form-horizontal" id="frm-NoConsumibleMasivo">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="cantidad">Cantidad<?php echo hreq() ?>:</label>
                            <div class="col-md-4">
                                <input type="number" class="form-control" id="cantidadNCM" name="cantidad" placeholder="Ingrese cantidad" <?php echo req() ?>>
                            </div>
                            <label class="col-md-2 control-label" for="prefijo">Prefijo:</label>
                            <div class="col-md-4">
                                <input id="prefijoNCM" name="prefijo" type="text" placeholder="Ingrese prefijo" class="form-control input-md" onchange="obtenerUltimoIndicePrefijo()" maxlength="8">
                            </div>
                        </div>
                        <!-- ___________________________________________________ -->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="desde">Desde<?php echo hreq() ?>:</label>
                            <div class="col-md-4">
                                <input type="number" class="form-control" id="desdeNCM" name="desde" placeholder="Nro de iniciación" title="Desde que número iniciar la gneración" <?php echo req() ?>>
                            </div>
                            <label class="col-md-2 control-label" for="tipo_no_consumible">Tipo NC<?php echo hreq() ?>:</label>
                            <div class="col-md-4">
                                <select name="tipo_no_consumible" class="form-control" required>
                                    <option value=""> - Seleccionar - </option>
                                    <?php 
                                    if(is_array($tipoNoConsumible)){
                                        foreach ($tipoNoConsumible as $i) {
                                            echo "<option value = $i->tabl_id>$i->valor</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- ___________________________________________________ -->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="descripcion">Descripción<?php echo hreq() ?>:</label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="descripcionNCM" name="descripcion" maxlength="80" <?php echo req() ?>></textarea>
                            </div>
                        </div>
                        <!-- ___________________________________________________ -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="fecha_vencimiento">Fecha de vencimiento<?php echo hreq() ?>:</label>
                            <div class="col-md-8">
                                <input id="fec_vencimientoNCM" name="fec_vencimiento" type="date" placeholder="" class="form-control input-md"  <?php echo req() ?>>
                            </div>
                        </div>
                        <!-- ___________________________________________________ -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="">Establecimiento<?php echo hreq() ?>:</label>
                            <div class="col-md-8">
                                <select class="form-control select2 select2-hidden-accesible" id="establecimientoNCM" name="establecimiento" onchange="selectEstablecimiento(this)" <?php echo req() ?>>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <?php
                                        if(is_array($tipoEstablecimiento)){
                                            foreach ($tipoEstablecimiento as $i) {
                                                echo "<option value = $i->esta_id>$i->nombre</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- ___________________________________________________ -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="depositos">Depósito<?php echo hreq() ?>:</label>
                            <div class="col-md-8">
                                <select class="form-control select2 select2-hidden-accesible selectedDeposito" id="depositosNCM" name="deposito" <?php echo req() ?>>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div> <!-- /.modal-body -->
            <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-accion" class="btn btn-success btn-guardar" onclick="guardarNoCoMasivo()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-------------------------------------------------------->
<!-- MODAL PLANTILLA QR MASIVO-->
<div class='modal fade' id='modalPlantillaQR' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class='modal-title' id='myModalLabel'>QR generado</h4>
            </div>
            <div class='modal-body'>
                <div id="QRsGenerados" style="position:relative; float:left; width: 100%">
                </div>
            </div>
            <div class='modal-footer'>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <button type='button' class='btn btn-primary' onclick='imprimirQRMasivos()'>Imprimir</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL PLANTILLA QR MASIVO-->
<script>
///////////////////////////////////////////////////////////
//Scripts para el alta masiva de NC's
function modalLoteNCs(){
	$("#mdl-altaMasivaNCs").modal('show');
}
///////////////////////////////////////////////
//Guarda datos de generacion masiva de NoCo's 
function guardarNoCoMasivo() {

    if(!frm_validar('#frm-NoConsumibleMasivo')){
        error('Error','Debes completar los campos obligatorios (*)');
        wc();
        return;
    }
    var formData = new FormData($('#frm-NoConsumibleMasivo')[0]);
    wo();

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Noconsumible/altaMasivaNoConsumibles',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(resp) {
            wc();
            // resp = JSON.parse(rsp);
            $("#mdl-altaMasivaNCs").modal('hide');
            const confirm = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });

            if (resp.status) {
                confirm.fire({
                    title: resp.title,
                    html: resp.msg,
                    type: resp.type,
                    showCancelButton: false,
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#QRsGenerados").empty();
                    resp.NoCos.forEach(NoCo => {
                        solicitarQRMasivo(NoCo);
                    });
                    wo();
                    setTimeout(() =>{
                        // $("#modalPlantillaQR").modal('show');
                        imprimirQRMasivos();
                        wc();
                    }, 5000);
                });
            } else {
                wc();
                notificar(resp.title,resp.msg,resp.type);
            }
        },
        error: function(resp) {
            // resp = JSON.parse(rsp);
            wc();
            $("#mdl-altaMasivaNCs").modal('hide');
            notificar(resp.title,resp.msg,resp.type);
        }
    });
}
///////////////////////////////////////////////
//Obtiene el ultimo valor + 1 cargado para el prefijo ingresado
function obtenerUltimoIndicePrefijo() {
    wo();
    data = {"prefijo": $("#prefijoNCM").val()};
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Noconsumible/obtenerIndicePrefijo',
        data: data,
        success: function(resp) {
            wc();
            if(resp.status){
                notificar('Último índice: ' + resp.indice,' - ','info');
                $("#desdeNCM").val(++resp.indice);
            }
        },
        error: function(resp) {
            wc();
        }
    });
}
///////////////////////////////////////////////////
//////// Configuracion y creacion códigos QR MASIVO
function solicitarQRMasivo(datosNoCo){
	// configuración de código QR
	var config = {};
	config.titulo = "Código No Consumible";
	config.pixel = "3";
	config.level = "L";
	config.framSize = "2";

	var dataQR = datosNoCo;

	// agrega codigo QR al modal impresion
	obtenerQR(config, dataQR, 'codigosQR/Traz-prod-trazasoft/NoConsumibles/QR_Masivo');
}
// trae codigo QR con los datos recibidos y pega el resultado para ser impreso
function obtenerQR(config, data, direccion) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
            config,
            data,
            direccion
        },
        url: 'index.php/<?php echo COD ?>Codigo/generarQRMasivo',
        success: function(result) {
            if (result != null) {
                html =  '<div class="contenedorBloqueNoCo anchoFull" style="width: 100%; float:left">' +
                            '<div class="anchoFull" style="width: 100%">' +
                                '<div class="anchoFull separarContenido" style="width: 100%">' +
                                    '<p class="tituloNoCo">ID: <strong>'+ data.codigo+'</strong></p>'+
                                '</div>'+
                                '<div class="anchoFull separarContenido" style="width: 100%">' +
                                    '<p><strong>Descripción: '+ data.descripcion+'</strong></p>'+
                                    '<p><strong>Fecha de Alta: '+ data.fec_alta+'</strong></p>'+
                                '</div>'+
                            '</div>'+
                            '<div class="anchoFull centrar" style="width: 100%; text-align:center"><img class="imagenQRNoCo" src="' + result.filename + '" alt="codigo qr" >' +
                            '</div>'+
                        '</div>';
                $("#QRsGenerados").append(html);
            }
        },
        error: function(result) {

        },
        complete: function() {

        }
    });
}
////////////// FIN Creación QR
//hoja_estilos se define en core.tablas por empresa
function imprimirQRMasivos(){
    var base = "<?php echo base_url()?>";
    var hoja_estilos = "<?php echo !empty($estiloImpresionQR->descripcion) ? base_url($estiloImpresionQR->descripcion) : '' ?>";
    $('#QRsGenerados').printThis({
        debug: false,
        importCSS: false,
        importStyle: false,
        pageTitle: "TRAZALOG TOOLS",
        printContainer: false,
        // removeInline: true,
        // copyTagClasses: true,
        printDelay: 3000,
        loadCSS: hoja_estilos,
        base: base
    });
	linkTo('<?php echo base_url(PRD) ?>general/Noconsumible/index');
}
</script>