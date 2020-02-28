<!-- producto -->
<div class="box box-primary">
    <div class="box-header">
        <h4 class="box-title">Producto</h4>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <!-- PRODUCTO Y CANTIDAD INICIO -->
        <?php if ($accion != 'Editar' && $etapa->estado != "PLANIFICADO") {
        ?>
            <div class="row" style="margin-top: 40px">
                <div class="col-xs-12">
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-6">
                            <label for="template" class="form-label">Descripción:</label>
                        </div>
                        <div class="col-md-6 col-xs-12 input-group ba">

                            <?php
                            echo selectBusquedaAvanzada('idproducto', 'vprod', $materias, 'arti_id', 'barcode',  array('descripcion', 'Unidad Medida:' => 'unidad_medida'));
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
                            <input type="number" class="form-control" placeholder="Inserte Cantidad" id="cantidadproducto" name="vcantprod">
                        </div>
                        <div class="col-md-1 col-xs-1">
                            <input type="text" class="form-control" value=" - " id="um" disabled name="vum">
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>
        <!-- PRODUCTO Y CANTIDAD INICIO -->

        <!-- PRODUCTO Y CANTIDAD EDITAR -->
        <?php if ($accion == 'Editar' && $etapa->estado == "FINALIZADO") {
        ?>
            <div class="row" style="margin-top: 40px">
                <div class="col-xs-12">
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-6">
                            <label for="template" class="form-label">Materia:</label>
                        </div>
                        <div class="col-md-6 col-xs-12 input-group">
                            <input list="productos" id="" class="form-control" value="<?php echo $producto[0]->descripcion; ?>" disabled name="vproddesc">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-6">
                            <label for="template" class="form-label">Cantidad:</label>
                        </div>
                        <div class="col-md-6 col-xs-12 input-group">
                            <input type="text" class="form-control" value="<?php echo $producto[0]->cantidad . ' (' . $producto[0]->uni_med . ')'; ?>" id="" disabled name="prodcantidad">
                        </div>
                    </div>
                </div>
            </div>
        <?php  }
        ?>

        <?php if ($accion == 'Editar' && $etapa->estado == "PLANIFICADO") { ?>
            <div class="row" style="margin-top: 40px" id="editPlani">


                <!-- <div class="col-xs-12">
                    <div class="row form-group">
                        <div class="col-md-3 col-xs-6">
                            <label for="template" class="form-label">Descripción:</label>
                        </div>
                        <div class="col-md-6 col-xs-12 input-group ba">

                            <?php
                            //echo selectBusquedaAvanzada('idproducto', 'vprod', $materias, 'arti_id', 'barcode',  array('descripcion', 'Unidad Medida:' => 'unidad_medida'));
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
                            <input type="number" class="form-control" placeholder="Inserte Cantidad" id="cantidadproducto" name="vcantprod">
                        </div>
                        <div class="col-md-1 col-xs-1">
                            <input type="text" class="form-control" value=" - " id="um" disabled name="vum">
                        </div>
                    </div>
                </div> -->
            </div>
        <?php  } ?>

        <div class="row hidden" style="margin-top: 40px" id="nuevaEtapa">
            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Descripción:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group ba">

                        <?php
                        echo selectBusquedaAvanzada('idproducto', 'vprod', $materias, 'arti_id', 'barcode',  array('descripcion', 'Unidad Medida:' => 'unidad_medida'));
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
                        <input type="number" class="form-control" placeholder="Inserte Cantidad" id="cantidadproducto" name="vcantprod">
                    </div>
                    <div class="col-md-1 col-xs-1 input-group">
                        <input type="text" class="form-control" value=" - " id="um" disabled name="vum">
                        <!-- <div id='buttonProducto' class='col-md-2 col-xs-2 espacioboton'><button type='button' class='btn btn-primary btn-flat' onclick='editProducto()'><i class='fa fa-fw fa-cog'></i></button></div> -->
                        <span id='buttonProducto' class="input-group-btn espacioboton">
                            <button type='button' class='btn btn-primary btn-flat' onclick='editProducto()'>Editar</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row hidden" style="margin-top: 40px" id="editFinal">
            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Materia:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input list="productos" id="" class="form-control" value="<?php echo $producto[0]->descripcion; ?>" disabled name="vproddesc">
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Cantidad:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input type="text" class="form-control" value="<?php echo $producto[0]->cantidad . ' (' . $producto[0]->uni_med . ')'; ?>" id="" disabled name="prodcantidad">
                        <span id='buttonProducto' class="input-group-btn espacioboton">
                            <button type='button' class='btn btn-primary btn-flat' onclick='editProducto()'>Editar</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- PRODUCTO Y CANTIDAD EDITAR -->
    </div>
</div>
<!-- . /producto -->

<script>
    $('#idproducto').on('change', function() {
        var data = getJson(this);
        $('#um').val(data.unidad_medida);
    })
</script>