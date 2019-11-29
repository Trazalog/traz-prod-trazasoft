<!-- producto -->
<div class="box">
    <div class="box-header">
        <h4 class="box-title">Producto</h4>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <!-- PRODUCTO Y CANTIDAD INICIO -->
        <?php if($etapa->estado != 'En Curso'){?>
        <div class="row" style="margin-top: 40px">
            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Materia:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input list="productos" id="inputproductos" class="form-control"
                            placeholder="Ingrese articulo a buscar" autocomplete="off">
                        <input type="hidden" id="idproducto" value="" data-json="">
                        <datalist id="productos">
                            <?php foreach($materias as $fila)
								{
									echo  "<option value='$fila->titulo'>";
									}
							?>
                        </datalist>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Cantidad:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input type="number" class="form-control" placeholder="Inserte Cantidad" id="cantidadproducto">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- PRODUCTO Y CANTIDAD INICIO -->

        <!-- PRODUCTO Y CANTIDAD EDITAR -->
        <?php if($accion == 'Editar'){?>
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