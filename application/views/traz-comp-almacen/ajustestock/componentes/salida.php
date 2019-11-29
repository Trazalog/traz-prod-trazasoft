<div class="box box-default tag-descarga" id="boxSalida">
    <div class="box-header">
        <i class="fa fa-sign-out"></i>
        <h3 class="box-title"> SALIDA</h3>
    </div>
    <div class="box-body">
        <form id="frm-salida" class="frm-destino">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Articulo:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="articulosal"
                            name="articulosal" required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Lote:</label>
                        <input list="articulos" name="lotesal" class="form-control inp-descarga" type="text"
                            id="lotesal">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input name="cantidadsal" class="form-control inp-descarga" type="number" id="cantidadsal">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Unidad de Medida:</label>
                        <input list="unidades" name="umsal" class="form-control inp-descarga" type="text" id="umsal">
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>
<!-- box-body -->
</div>
<!-- box -->