<!-- Origen -->
<div class="box">
    <div class="box-header">
        <h4 class="box-title">Origen</h4>
    </div>
    <!-- /.box-header -->


    <!-- ORIGEN INICIO ETAPA -->
    <?php if($etapa->estado != 'En Curso'){?>
    <div class="box-body">
        
        <div class="row" style="margin-top: 40px">
            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Materia:</label>
               
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input list="materias" id="inputmaterias" class="form-control" autocomplete="off">
                        <input type="hidden" id="idmateria" value="" data-json="">
                        <datalist id="materias">
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
                        <label for="" class="form-label">Stock Actual:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input type="number" class="form-control" disabled id="stockdisabled">
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Cantidad:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input type="number" class="form-control" placeholder="Inserte Cantidad" id="cantidadmateria"
                            disabled>
                        <span class="input-group-btn">
                            <button class='btn btn-success' id="botonmateria" disabled
                                onclick="aceptarMateria()">Aceptar
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 40px ">
            <input type="hidden" id="materiasexiste" value="no">
            <div class="col-xs-12 table-responsive" id="materiasasignadas">
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- ORIGEN INICIO ETAPA -->

    <!-- ORIGEN EDICION ETAPA -->
    <?php if($accion == 'Editar'){?>
    <div class="box-body">
        <div class="row" style="margin-top: 40px ">
            <input type="hidden" id="materiasexiste" value="no">
            <div class="col-xs-12 table-responsive" id="materiasasignadas">
                <table id="etapas" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php											
								foreach($matPrimas as $fila)
								{
										echo "<tr>";
										echo "<td>$fila->descripcion</td>";
                                        echo "<td>$fila->cantidad($fila->uni_med)</td>";														
                                        echo "</tr>"; 																
								}		
						?>
                    </tbody>
                </table>

            </div>
            <!-- ORIGEN EDICION ETAPA -->

        </div>
    </div>
            <?php }?>
</div>
<!-- ./ Origen -->