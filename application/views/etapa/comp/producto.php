<!-- producto -->
<div class="box box-primary">
    <div class="box-header">
        <h4 class="box-title">Producto</h4>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <!-- PRODUCTO Y CANTIDAD INICIO -->
        <?php if($etapa->estado != 'En Curso' && $etapa->estado !='FINALIZADO'){?>
        <div class="row" style="margin-top: 40px">
            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Descripción:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group ba">
                     
                          <?php
                            echo selectBusquedaAvanzada('idproducto', false, $materias, 'arti_id', 'barcode',  array('descripcion', 'Unidad Medida:'=>'unidad_medida'));
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
                        <input type="number" class="form-control" placeholder="Inserte Cantidad" id="cantidadproducto">
                    </div>
                   <div class="col-md-1 col-xs-1">
                            <input type="text" class="form-control" value=" - " id="um" disabled>
                   </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- PRODUCTO Y CANTIDAD INICIO -->

        <!-- PRODUCTO Y CANTIDAD EDITAR -->
        <?php if($accion == 'Editar' || $etapa->estado == "FINALIZADO"){?>
        <div class="row" style="margin-top: 40px">
            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Materia:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input list="productos" id="" class="form-control"
                            value="<?php echo $producto[0]->descripcion; ?>" disabled>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Cantidad:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input type="text" class="form-control"
                            value="<?php echo $producto[0]->cantidad.' ('.$producto[0]->uni_med.')'  ; ?>" id=""
                            disabled>
                    </div>
                </div>
            </div>
        </div>
        <?php  } ?>
        <!-- PRODUCTO Y CANTIDAD EDITAR -->
    </div>
</div>
<!-- . /producto -->

<script>
$('#idproducto').on('change', function(){
    var data = getJson(this);
    $('#um').val(data.unidad_medida);
})
</script>