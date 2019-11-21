<div class="box box-primary tag-descarga">
    <div class="box-header">
        <i class="fa fa-sign-in"></i>
        <h3 class="box-title"> ENTRADA</h3>
    </div>
    <div class="box-body">
        <form id="frm-origen" class="frm-origen">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Articulo:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="choferr" name="chofer"
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
                        <input list="articulos" name="arti_id" class="form-control inp-descarga" type="text"
                            id="articulo">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input name="cantidad" class="form-control inp-descarga" type="number" id="cantidad">
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
