<div class="box box-primary tag-descarga">
    <div class="box-header">
        <h3 class="box-title">Ajuste de Stock</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Establecimiento:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="choferr" name="chofer" required>
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php                                               
                        foreach ($establecimientos as $i) {
                            echo '<option value="'.$i->nombre.'" class="emp" data-json=\''.json_encode($i).'\'>'.$i->nombre.'</option>';
                            
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Deposito:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="choferr" name="chofer" required>
                        <option value="" disabled selected>-Seleccione opcion-</option>

                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tipo de ajuste:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="choferr" name="chofer" required>
                        <option value="" disabled selected>-Seleccione opcion-</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>