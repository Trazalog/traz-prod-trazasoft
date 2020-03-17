<!-- producto -->
<div class="box box-primary">
    <div class="box-header">
        <h4 class="box-title">Producto</h4>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row" style="margin-top: 40px">
            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Descripción:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group ba">
                        <?php
                            echo selectBusquedaAvanzada('idproducto', 'vprod', $materias, 'id', 'barcode',  array('descripcion', 'Unidad Medida:' => 'unidad_medida'));
                            ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Cantidad:</label>
                    </div>
                    <div class="col-md-5 col-xs-11">
                        <input type="number" class="form-control" placeholder="Inserte Cantidad" id="cantidadproducto"
                            name="vcantprod">
                    </div>
                    <div class="col-md-1 col-xs-1">
                        <input type="text" class="form-control" value=" - " id="um" disabled name="vum">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- . /producto -->

<script>

var producto = <?php echo json_encode($producto[0]) ?>

if(producto){
    $('#idproducto').val(producto.arti_id);
    $('#idproducto').trigger('change');
    $('#cantidadproducto').val(producto.cantidad);
    $('#um').val(producto.uni_med);
}


$('#idproducto').on('change', function() {
    var data = getJson(this);
    $('#um').val(data.um);
});
</script>