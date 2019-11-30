<div class="box box-default tag-descarga" id="boxEntrada" style="opacity: 0.5;">
    <div class="box-header">
        <i class="fa fa-sign-in"></i>
        <h3 class="box-title"> ENTRADA</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Articulo:</label>
                    <select class="form-control select2 select2-hidden-accesible articulos" id="articuloent"
                        name="articuloent" required>
                        <option value="" disabled selected>-Seleccione opcion-</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Lote:</label>
                    <input name="loteent" class="form-control inp-descarga" type="text" id="loteent">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Cantidad:</label>
                    <input name="cantidadent" class="form-control inp-descarga" type="number" id="cantidadent">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Unidad de Medida:</label>
                    <input name="unidadesent" readonly class="form-control inp-descarga" type="text" id="unidadesent">
                </div>
            </div>
        </div>
    </div>
    <!-- box-body -->
</div>
<!-- box -->