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
                                <input id="prefijoNCM" name="prefijo" type="text" placeholder="Ingrese prefijo" class="form-control input-md">
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
                                <textarea class="form-control" id="descripcionNCM" name="descripcion" <?php echo req() ?>></textarea>
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
        success: function(rsp) {
            wc();
            resp = JSON.parse(rsp);
            $("#mdl-altaMasivaNCs").modal('hide');
            const confirm = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });

            if (resp.status) {
                confirm.fire({
                    title: 'Correcto',
                    text: "No consumible dado de alta correctamente!",
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    
                    linkTo('<?php echo base_url(PRD) ?>general/Noconsumible/index');
                    
                });
            } else {
                wc();
                error('Error...','No pudo darse de alta el No consumible!')
            }
        },
        error: function(rsp) {
            wc();
            $("#mdl-altaMasivaNCs").modal('hide');
            error('Error...','No pudo darse de alta el No consumible!')
            console.log(rsp.msj);
        }
    });
}	
</script>