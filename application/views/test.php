<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Fraccionamiento</h3>
    </div>
    <div class="box-body">
        <form id="frm-fracc">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Orden Fraccionamiento </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha:</label>
                                        <input class="form-control" type="text" name="fecha">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Orden Producción:</label>
                                        <input class="form-control" type="text" name="orden_produccion">
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
                                        <label>Establecimiento:</label>
                                        <select class="form-control" type="text" name="establecimiento"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Recipiente:</label>
                                        <select class="form-control" type="text" name="recipiente"></select>
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
                                <label>Lote a Fraccionar:</label>
                                <select class="form-control" type="text" name="lote_origen"></select>
                                <small>Codigos de lotes "Activos" de tipo producto final contenidos en el
                                    recipiente</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock Actual:</label>
                                <input class="form-control" type="text" name="stock_actual">
                                <small>Cantidad del Lote x Unidad Medida</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Envase:</label>
                                <select class="form-control" type="text" name="envase"></select>
                                <small>Articulo de tipo envase</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock Envase:</label>
                                <select class="form-control" type="text" name="stock_envase"></select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cantidad de envases:</label>
                                <input class="form-control" type="text" name="cantidad_envases">
                                <small>Cantidad de Envases a utilizar</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cantidad:</label>
                                <input class="form-control" type="text" name="cantidad">
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
                                <label>Producto Final:</label>
                                <input class="form-control" type="text" name="producto_final" readonly>
                                <small></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Código de Lote:</label>
                                <input class="form-control" type="text" name="codigo_lote" readonly>
                                <small></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Paletizado:</label>
                                <input class="form-control" type="text" name="paletizado">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cantidad de Palets:</label>
                                <input class="form-control" type="text" name="cantidad_palets">
                                <small>Calculado con la capacidad del palets y la cantidad de cajas envases</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="box-footer">
        <div class="modal-footer">
            <button class="btn btn-success" onclick="gFraccionamiento()">Iniciar Fraccionamiento</button>
            <button class="btn btn-default">Cancel</button>
        </div>
    </div>
</div>

<script>
$('input.form-control').val('Valor Test');

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