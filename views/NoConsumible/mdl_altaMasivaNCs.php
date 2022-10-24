<!-- Modal ALTA NC's masivamente -->
<div class="modal fade bd-example-modal-md" tabindex="-1" id="mdl-altaMasivaNCs" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mdl-titulo">ABM No Consumibles</h4>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    Revise que todos los campos esten completos
                </div>
                <form class="form-horizontal" id="frm-NoConsumible">
                        <fieldset id="read-only">
                            <fieldset>
                                <div class="form-group">
                                        <label class="col-md-2 control-label" for="codigo">Código<?php echo hreq() ?>:</label>
                                        <div class="col-md-4">
                                                <input id="codigo" name="codigo" type="text" placeholder="Ingrese código..." class="form-control input-md" required>
                                        </div>
                                        <label class="col-md-2 control-label" for="tipo_no_consumible">Tipo No Consumible<?php echo hreq() ?>:</label>
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
                                <div class="form-group">
                                        <label class="col-md-2 control-label" for="descripcion">Descripción<?php echo hreq() ?>:</label>
                                        <div class="col-md-10">
                                                <textarea class="form-control" id="descripcion" name="descripcion"
                                                <?php echo req() ?>></textarea>
                                        </div>
                                </div>
                                <div class="form-group">
                                    
                                        <label class="col-md-4 control-label" for="fecha_vencimiento">Fecha de
                                                vencimiento<?php echo hreq() ?>:</label>
                                        <div class="col-md-8">
                                                <input id="fec_vencimiento" name="fec_vencimiento" type="date"
                                                        placeholder="" class="form-control input-md"  <?php echo req() ?>>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="">Establecimiento<?php echo hreq() ?>:</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2 select2-hidden-accesible" id="establecimiento" name="establecimiento" onchange="selectEstablecimiento()" <?php echo req() ?>>
                                            <option value="" disabled selected>Seleccionar</option>
                                            <?php
                                                if(is_array($tipoEstablecimiento)){
                                                            foreach ($tipoEstablecimiento as $i) {
                                                            echo "<option value = $i->esta_id>$i->nombre</option>";
                                                            }
                                                }
                                            ?>
                                        </select>
                                        <span id="estabSelected" style="color: forestgreen;"></span>
                                    </div>
                                </div>
                                <br>
                                <!-- ___________________________________________________ -->
                                <div class="form-group">
                                                <label class="col-md-4 control-label" for="depositos">Depósito<?php echo hreq() ?>:</label>
                                                <div class="col-md-8">
                                                <select class="form-control select2 select2-hidden-accesible" id="depositos" name="depositos" onchange="selectDeposito()" <?php echo req() ?>>
                                                </select>
                                                <span id="deposSelected" style="color: forestgreen;"></span>
                                                </div>
                                        
                                </div>
                            </fieldset>
                </form>
            </div> <!-- /.modal-body -->
            <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-accion" class="btn btn-success btn-guardar" onclick="guardarNoConsumible()">Guardar</button>
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
</script>