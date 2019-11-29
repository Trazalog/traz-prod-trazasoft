<div class="box box-default tag-descarga" id="boxEntrada">
    <div class="box-header">
        <i class="fa fa-sign-in"></i>
        <h3 class="box-title"> ENTRADA</h3>
    </div>
    <div class="box-body">
        <form id="frm-entrada" class="frm-origen">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Articulo:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="articuloent" name="articuloent"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Lote:</label>
                        <input  name="loteent" class="form-control inp-descarga" type="text"
                            id="loteent">
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
                        <input list="unidades" name="ument" class="form-control inp-descarga" type="text" id="ument">
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<!-- box -->
