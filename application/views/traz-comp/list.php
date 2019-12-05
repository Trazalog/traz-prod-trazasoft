<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">
                    <label for="">Artículos:</label>
                    <?php 
                        echo selectBusquedaAvanzada('articulos', $listArt, 'arti_id', 'barcode',  array('descripcion','Stock:' => 'stock', 'Unidad Medida:'=>'unidad_medida'), true);
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>
