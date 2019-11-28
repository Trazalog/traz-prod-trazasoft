<div class="box box-primary">
    <div class="box-body">
        <div class="form-group">
            <label for="">Selecionar:</label>
            <?php 
            echo select2('articulos', $listArt, 'barcode', 'arti_id');
            ?>

        </div>
    </div>
</div>
