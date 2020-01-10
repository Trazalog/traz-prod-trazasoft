<?php $this->load->view('etapa/modal_materia_prima');?>
<?php $this->load->view('etapa/modal_lotes');?>
<?php $this->load->view('etapa/modal_producto');?>

<div id="snapshot" data-key="<?php echo $key ?>">
    <?php if($etapa->estado == "En Curso"){
$this->load->view('etapa/modal_finalizar');}?>

    <!-- Cabecera -->
    <div class="box box-primary">

        <div class="box-header">
            <h3 class="box-title">
                <?php echo $accion.' '.$etapa->titulo ?>
            </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-1 col-xs-12">
                    <label for="Lote" class="form-label">Codigo Lote:*</label>
                </div>
                <div class="col-md-5 col-xs-12">
                    <input name="vcode" type="text" id="Lote" <?php if($accion=='Editar' ){echo 'value="'.$etapa->lote.'"';}?>
                        class="form-control" placeholder="Inserte Lote"
                        <?php if($etapa->estado == 'En Curso' || $etapa->estado =='FINALIZADO') {echo 'disabled';}?>>
                </div>
                <div class="col-md-1 col-xs-12">
                    <label for="fecha" class="form-label">Fecha:</label>
                </div>
                <div class="col-md-5 col-xs-12">

                    <?php
                            if($accion == 'Editar' || $accion == 'Nuevo'){ 
                                echo '<input type="" id="fecha" class="form-control" value="'.$fecha.'" disabled >' ;	
                            }
                    ?>

                </div>
            </div>
            <div class="row" style="margin-top: 50px">
                <div class="col-md-2 col-xs-12">
                    <label for="establecimientos" class="form-label">Establecimiento*:</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <select class="form-control select2 select2-hidden-accesible" name="vestablecimiento"
                        onchange="actualizaRecipiente(this.value,'recipientes')" id="establecimientos"
                        <?php if($etapa->estado == 'En Curso' || $etapa->estado =='FINALIZADO'){echo 'disabled';}?>>
                        <option value="" disabled selected>-Seleccione Establecimiento-</option>
                        <?php
						foreach($establecimientos as $fila){

								if(($accion == 'Editar' || $etapa->estado =='FINALIZADO' ) && $fila->nombre == $etapa->establecimiento){

										echo '<option value="'.$fila->id.'" selected>'.$fila->nombre.'</option>';
								}else{

										echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
								}
						} 
						?>
                    </select>
                </div>
                <div class="col-md-1 col-xs-12">
                    <?php if($accion == 'Nuevo'){
										echo '<label for="Recipiente" class="form-label">'.$etapa->titulorecipiente.'*:</label>'; 
									}?>
                    <?php if($accion == 'Editar' || $etapa->estado =='FINALIZADO'){ 
										echo	'<label for="Recipiente" class="form-label"> '.$etapa->reci_estab_nom.' *:</label>';
									}?>
                </div>

                <div class="col-md-5 col-xs-12">
                    <?php if($accion == 'Nuevo'){
                   echo selectBusquedaAvanzada('recipientes', 'vreci'); 
				}
				if($accion == 'Editar'){
					echo "<input value='$etapa->recipiente' type='text' class='form-control' disabled>";
				}
				?>
                </div>
            </div>
            <div class="row" style="margin-top: 50px">
                <div class="col-md-2 col-xs-12">
                    <label for="op" class="form-label">Orden de Produccion:</label>
                </div>
                <div class="col-md-4 col-xs-12">


                    <input type="text" id="ordenproduccion" class="form-control" name="vorden"
                        <?php if($accion=='Editar' || $etapa->estado =='FINALIZADO'){echo ( 'value="'.$etapa->orden.'"');}?>
                        placeholder="Inserte Orde de Produccion"
                        <?php if($etapa->estado == 'En Curso' || $etapa->estado =='FINALIZADO'){echo 'disabled';}?>>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="row" style="margin-top: 40px">
                <div class="col-xs-12">
                    <i class="glyphicon glyphicon-plus"></i><a onclick="despliega()" class="">Datos Adicionales</a>
                    <div id="desplegable" hidden>
                        <h3>Lo que vaya aca</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ Cabecera -->

    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view('etapa/comp/origen') ?>
        </div>
        <div class="col-md-12">
            <?php $this->load->view('etapa/comp/producto') ?>
        </div>
    </div>


    <!-- Tareas -->
    <div class="box box-primary">
        <div class="box-header">
            <h4 class="box-title">Tareas</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row" style="margin-top: 40px ">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Calendario</a>
                            </li>
                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tareas</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <!-- <p>Aca iria el Calendario</p> -->
                            </div>
                            <div class="tab-pane" id="tab_2">
                                <?php 		
															//TODO: NO COMETAR, TIENEUN INPUT Q NO SE LLENA  Y ROPE JAVASCRIPT											
															$this->load->view(TAREAS_ASIGNAR.'/tareas')?>
                            </div>
                            <div class="row" hidden id="incompleto">
                                <div class="col-xs-12">
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-ban"></i> Datos incompletos</h4>
                                        <p id="mensajeincompleto"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">

                            <?php if($etapa->estado == 'planificado')
								{
								echo '<button class="btn btn-primary" onclick="valida()">Iniciar Etapa</button>';
								}else if($etapa->estado == 'En Curso')
								{
									echo '<button class="btn btn-primary" id="btnfinalizar" onclick="finalizar()">Reporte de Producción</button>';
								}
							?>


                            <button class="btn btn-primary" onclick="saveSnapshot()">Guardar</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
<!-- ./ Tareas-->
</div>


<script>
getSnapshot();

accion = '<?php echo $accion;?>';
if (accion == "Editar") {
    var materias = <?php echo json_encode($etapa-> materias); ?> ;
    for (i = 0; i < materias.length; i++) {
        materia = materias[i];
        materia = JSON.stringify(materia);
        materia = '[' + materia + ']';
        materia = JSON.parse(materia);
        //agregaMateria(materia);
    }
}

function actualizaRecipiente(establecimiento, recipientes) {
    wo();
    establecimiento = establecimiento;
    $('#recipientes').empty();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {
            establecimiento
        },
        url: 'general/Recipiente/listarPorEstablecimiento/true',
        success: function(result) {

            if (!result.status) {
                alert('Fallo al Traer Recipientes');
                return;
            }

            if (!result.data) {
                alert('No hay Recipientes Asociados');
                return;
            }
            fillSelect('#recipientes', result.data);

        },
        error: function() {
            alert('Error al Traer Recipientes');
        },
        complete: function() {
            wc();
        }
    });

}

function despliega() {
    estado = document.getElementById('desplegable').hidden;
    if (estado) {
        document.getElementById('desplegable').hidden = false;
    } else {
        document.getElementById('desplegable').hidden = true;
    }
}

// envia datos para iniciar etapa y acer orden de pedido a almacenes
function guardar() {

    var tabla = $('#tablamateriasasignadas tbody tr');
    var materiales = [];
    var materia = [];
    var i = 0;
    $.each(tabla, function(index) {
        var cantidad = $(this).find("td").eq(3).html();
        var id_materia = $(this).attr("id");
        if (id_materia != null) {
            materia[id_materia] = cantidad;
        }
    });
    lote = document.getElementById('Lote').value;
    fecha = document.getElementById('fecha').value;
    establecimiento = document.getElementById('establecimientos').value;
    recipiente = document.getElementById('recipientes').value;
    op = document.getElementById('ordenproduccion').value;
    idetapa = <?php echo $idetapa; ?> ;
    cantidad = $('#cantidadproducto').val();
    idprod = $('#idproducto').val();
    wo();
    $.ajax({
        type: 'POST',
        data: {
            idetapa: idetapa,
            lote: lote,
            fecha: fecha,
            establecimiento: establecimiento,
            recipiente: recipiente,
            op: op,
            materia: materia,
            cantidad: cantidad,
            idprod: idprod
        },
        url: 'general/Etapa/guardar',
        success: function(result) {
            if (result == "ok") {
                linkTo('general/Etapa/index');
            } else {
                alert("Hubo un error en BD");
            }
            if (result == 'Error al Inciar Proceso') {
                alert("Hubo un error al iniciar Proceso BPM");
            } else {
                linkTo('general/Etapa/index');
            }
        },
        error: function(rsp) {
            alert('Error al Iniciar Etapas');
        },
        complete: function() {
            wc();
        }
    });
}
// valida campos vacios
function valida() {
    mensaje = "No se ha podido completar la operacion debido a que algunos datos no han sido completados: <br>";
    ban = true;
    if (document.getElementById('Lote').value == "") {
        mensaje += "- No ha ingresado Lote <br>";
        ban = false;
    }
    if (document.getElementById('fecha').value == "") {
        mensaje += "- No ha ingresado Fecha <br>";
        ban = false;
    }
    if (document.getElementById('establecimientos').value == "") {
        mensaje += "- No ha seleccionado establecimiento <br>";
        ban = false;
    }
    if (document.getElementById('recipientes').value == "") {
        mensaje += "- No ha seleccionado recipiente <br>";
        ban = false;
    }
    if (document.getElementById('materiasexiste').value == "no") {
        mensaje += "- No ha seleccionado ninguna materia prima <br>";
        ban = false;
    }
    // if (document.getElementById('existe_tabla').value == "no") {
    //     mensaje += "- No ha seleccionado ninguna tarea <br>";
    //     ban = false;
    // }
    if (ban) {
        guardar();
    } else {
        document.getElementById('mensajeincompleto').innerHTML = "";
        document.getElementById('mensajeincompleto').innerHTML = mensaje;
        document.getElementById('incompleto').hidden = false;
    }
}

// selecciona id de producto y guarda en input hidden
$("#inputproductos").on('change', function() {

    band = false;
    i = 0;
    $('#idproducto').val("");
    articulos = <?php echo json_encode($materias); ?> ;
    producto = document.getElementById('inputproductos').value;

    while (!band && i < articulos.length) {

        if (producto == articulos[i].titulo) {
            band = true;
            $('#idproducto').val(articulos[i].id);
            console.log('materia id: ' + articulos[i].id);
        }
        i++;
    }

    prod = $('#idproducto').val();
});



// levanta modal para finalizar la etapa solamente
function finalizar() {
    /* idetapa = //php echo $idetapa;?>;
							$.ajax({
									type: 'POST',
									data: {idetapa:idetapa },
									url: 'general/Etapa/checkFormularios', 
									success: function(result){
										if(result)
										{
											
											}else
											{
												alert('Faltan formularios');
											}
										
									}
						);*/
    $("#modal_finalizar").modal('show');
}
$(document).off('click', '.tablamateriasasignadas_borrar').on('click', '.tablamateriasasignadas_borrar', {
    idtabla: 'tablamateriasasignadas',
    idrecipiente: 'materiasasignadas',
    idbandera: 'materiasexiste'
}, remover);
</script>