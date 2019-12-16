<!-- Origen -->
<div class="box box-primary">
    <div class="box-header">
        <h4 class="box-title">Origen</h4>
    </div>
    <!-- /.box-header -->


    <!-- ORIGEN INICIO ETAPA -->
    <?php if($etapa->estado != 'En Curso' && $etapa->estado !='FINALIZADO'){?>
    <div class="box-body">
        
        <div class="row" style="margin-top: 40px">
            <div class="col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-6">
                        <label for="template" class="form-label">Materia:</label>
               
                    </div>
                    <div class="col-md-6 col-xs-12 input-group ba">
                  
                        <?php
                            echo selectBusquedaAvanzada('inputmaterias', false, $materias, 'arti_id', 'barcode', array('descripcion'));
                        ?>
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
    <?php if($accion == 'Editar' || $etapa->estado =='FINALIZADO'){?>
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

<script>
// al seleccionar desde el input de Origen muestra stock y habilita input para cantidad y btn aceptar
var matSelect = null;
$("#inputmaterias").on('change', function() {

        var data = getJson(this);
    
        var stock = data.stock;
        document.getElementById('stockdisabled').value = stock;
        materia = this.dataset.json;
        // FIXME: SI SE SACA SIN QUE ANDE EL MODALCITO DE MATERIAS SE ROMPE LA CARGA EN TABLITA
        // agregaMateria(materia);
        matSelect =  data;
        // FIXME: SI SE SACA SIN QUE ANDE EL MODALCITO DE MATERIAS SE ROMPE LA CARGA EN TABLITA
        //document.getElementById('stockdisabled').value = ma
        
        document.getElementById('cantidadmateria').disabled = false;
        document.getElementById('botonmateria').disabled = false;
});

function aceptarMateria() {
    cantidad = document.getElementById('cantidadmateria').value;
    materia = matSelect;
    materia.cantidad = cantidad;
    materia = JSON.stringify(materia);
    materia = '[' + materia + ']';
    materia = JSON.parse(materia);
    console.log(materia);
    agregaMateria(materia);
}


</script>