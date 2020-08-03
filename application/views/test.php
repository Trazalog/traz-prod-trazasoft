<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Fraccionamiento</h3>
    </div>
    <div class="box-body">
        <form id="frm-fraccionamiento">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Orden Fraccionamiento</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha <?php hreq() ?> :</label>
                                        <input class="form-control" type="text" name="fecha"
                                            value="<?php echo date('d-m-Y')?>" <?php echo req() ?>>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Orden Producción <?php hreq() ?> :</label>
                                        <input class="form-control" type="text" name="orden_produccion"
                                            <?php echo req() ?>>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lote a Fraccionar
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Establecimiento <?php hreq() ?> :</label>
                                        <select class="form-control" type="text" name="establecimiento"
                                            id="establecimiento" <?php echo req() ?>>
                                            <option value="0" disabled selected>- Seleccionar Establecimiento -</option>
                                            <?php
                                                foreach ($establecimientos as $o) {
                                                    echo "<option value='$o->json_encode($o)'>$o->nombre</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Recipiente <?php hreq() ?> :</label>
                                        <select class="form-control" type="text" name="recipiente" id="recipiente"
                                            <?php echo req() ?>>
                                            <option value="0" disabled selected>- Seleccionar -</option>
                                            <?php
                                                foreach ($establecimientos as $o) {
                                                    if(isset($o->recipientes->recipiente)){
                                                        foreach ($o->recipientes->recipiente as $p) {
                                                            echo "<option value='$o->json_encode($p)' class='$o->nombre'>$p->nombre</option>";
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Detalle Fraccionamiento</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lote a Fraccionar <?php echo hreq() ?>:</label>
                                <select class="form-control" type="text" name="lote_origen"
                                    <?php echo req() ?>></select>
                                <small>Codigos de lotes "Activos o En Curso" de tipo producto final contenidos en el
                                    recipiente</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock Productos:</label>
                                <input class="form-control" type="text" name="stock_productos" readonly>
                                <small>Cantidad del Lote x Unidad Medida</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Envase <?php echo hreq() ?> :</label>
                                <select class="form-control" type="text" name="envase" <?php echo req() ?>>
                                    <option value="0" selected disabled>- Seleccionar -</option>
                                    <?php
                                        foreach ($envases as $o) {
                                            echo "<option value='$o->tabl_id'>$o->valor</option>";
                                        }
                                    ?>
                                </select>
                                <small>Articulo de tipo envase</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock Envase:</label>
                                <input class="form-control" name="stock_envase" readonly>
                                <small>asdasdsa</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cantidad de envases <?php echo hreq() ?> :</label>
                                <input class="form-control" type="text" name="cantidad_envases" <?php echo req() ?>>
                                <small>Cantidad de Envases a utilizar</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock Producto Necesarios:</label>
                                <input class="form-control" type="text" name="stock_necesario" readonly>
                                <small>Producto entre el neto del envase por cantidad de envases. Tiene que ser menor o
                                    igual que el stock producto</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Artículos:</label>
                                <?php
                                        echo selectBusquedaAvanzada('articulo', 'articulo', $articulos, 'arti_id', 'barcode', array('descripcion','Stock:' => 'stock'));
                                    ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Código de Lote <?php echo hreq() ?> :</label>
                                <input class="form-control" type="text" name="codigo_lote" <?php echo req() ?>>
                                <small></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fórmula:</label>
                                <select class="form-control" type="text" name="cantidad_palets"></select>
                                <small>Calculado con la capacidad del palets y la cantidad de cajas envases</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success" style="margin-top:5%"
                                onclick="frm_validar('#frm-fraccionamiento')"><i class="fa fa-plus"></i>
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="box-footer">
        <div class="modal-footer">
            <button class="btn btn-success" onclick="gFraccionamiento()"><i class="fa fa-check"></i> Iniciar
                Fraccionamiento</button>
            <button class="btn btn-default">Cancel</button>
        </div>
    </div>
</div>

<script>
initForm();
//$('input.form-control').val('Valor Test');
$('small').remove();

function gFraccionamiento() {

    var data = getForm('#frm-fracc');
    console.log(data);
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'general/Etapas/guardarFraccinamiento',
        data,
        success: function(res) {
            hecho();
        },
        error: function(res) {
            error();
        },
        complete: function() {

        }
    });

}
</script>