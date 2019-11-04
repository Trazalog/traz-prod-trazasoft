<?php $this->load->view('etapa/modal_materia_prima');?>
<?php $this->load->view('etapa/modal_lotes');?>
<?php $this->load->view('etapa/modal_producto');?>
<?php if($etapa->estado == "En Curso"){
$this->load->view('etapa/modal_finalizar');}?>

<?php //var_dump($etapa); ?>

<div class="box">

    <div class="box-header">
        <h3>
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
                <input type="text" id="Lote" <?php if($accion=='Editar' ){echo 'value="'.$etapa->lote.'"';}?> class="form-control" placeholder="Inserte Lote"
                <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
            </div>
            <div class="col-md-1 col-xs-12">
                <label for="fecha" class="form-label">Fecha:</label>
            </div>
            <div class="col-md-5 col-xs-12">
                <input type="date" id="fecha" class="form-control" <?php if($accion=='Editar' ){echo  'value="'.$etapa->fecha.'"';}else if($accion == 'Nuevo'){echo 'value="' .$fecha.'"';}?>
                <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
            </div>
        </div>
        <div class="row" style="margin-top: 50px">
            <div class="col-md-2 col-xs-12">
                <label for="establecimientos" class="form-label">Establecimiento*:</label>
            </div>
            <div class="col-md-4 col-xs-12">
                <select class="form-control select2 select2-hidden-accesible" onchange="actualizaRecipiente(this.value,'recipientes')" id="establecimientos" <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
                    <option value="" disabled selected>-Seleccione Establecimiento-</option>
                    <?php
                    foreach($establecimientos as $fila)
                    {
                     // if($accion == 'Editar' && $fila->titulo == $etapa->establecimiento->titulo)
                     // {
                     // echo '<option value="'.$fila->id.'" selected >'.$fila->nombre.'</option>';
                    //  }else
                    //  {
                        echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
                    //  }
                    } 
                    ?>
                </select>
            </div>
            <div class="col-md-1 col-xs-12">
                <label for="Recipiente" class="form-label"><?php echo $etapa->titulorecipiente;?>*:</label>
                
            </div>
           
            <div class="col-md-5 col-xs-12">
                <?php if($accion == 'Nuevo'){
                    echo '<select class="form-control" id="recipientes" disabled></select>';
                    }
                    if($accion == 'Editar'){
                      if($etapa->estado == 'En Curso')
                      {
                        echo '<select class="form-control" id="recipientes" disabled>';
                      }else{
                      echo '<select class="form-control" id="recipientes">';
                      }
                      echo '<option value="" disabled selected>-Seleccione Recipiente-</option>';
                      foreach($recipientes as $recipiente)
                      {
                        //if($recipiente->titulo == $etapa->recipiente)
                        //{
                          echo '<option value="'.$recipiente->id.'" selected>'.$recipiente->titulo.'</option>';
                        //}else{
                        //  echo '<option value="'.$recipiente->id.'" >'.$recipiente->titulo.'</option>';
                        //}
                      }
                      echo '</select>';
                    }
                    ?>
            </div>
        </div>
        <div class="row" style="margin-top: 50px">
            <div class="col-md-2 col-xs-12">
                <label for="op" class="form-label">Orden de Produccion:</label>
            </div>
            <div class="col-md-4 col-xs-12">
                <input type="text" id="ordenproduccion" class="form-control" <?php if($accion=='Editar' ){echo ( 'value="'.$etapa->op.'"');}?> placeholder="Inserte Orde de Produccion"
                <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
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

<div class="box">
    <div class="box-header">
        <h4 class="box-title">Origen</h4>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?php if($etapa->estado != 'En Curso'){?>
        <div class="row" style="margin-top: 40px">
            <div class="col-md-4 col-xs-12">
                <div class="row form-group">
                    <div class="col-md-3 col-xs-12">
                        <label for="template" class="form-label"><?php echo $lang['materias']; ?>:</label>
                    </div>
                    <div class="col-md-6 col-xs-12 input-group">
                        <input list="materias" id="inputmaterias" class="form-control" autocomplete="off">
                        <input type="hidden" id="idmateria" value="" data-json="">
                        <datalist id="materias">
          <?php foreach($materias as $fila)
          {
            echo  '<option value="'.$fila->titulo.'">';
            }
            ?>
          </datalist>
                        <span class="input-group-btn">
            <button class='btn btn-primary' 
              onclick='checkTabla("tablamaterias","modalmaterias",`<?php echo json_encode($materias);?>`,"Add")' data-toggle="modal" data-target="#modal_materia_prima">
              <i class="glyphicon glyphicon-search"></i></button>
            </span>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xs-12">
                <label for="" class="form-label">Stock Actual:</label>
            </div>
            <div class="col-md-2 col-xs-12">
                <input type="number" class="form-control" disabled id="stockdisabled">
            </div>
            <div class="col-md-1 col-xs-12">
                <label for="template" class="form-label">Cantidad:</label>
            </div>
            <div class="col-md-3 col-xs-12 input-group">
                <input type="number" class="form-control" placeholder="Inserte Cantidad" id="cantidadmateria" disabled>
                <span class="input-group-btn">
            <button class='btn btn-success' id="botonmateria"disabled onclick="aceptarMateria()">Aceptar
            </button>
            </span>
            </div>
        </div>
        <?php } ?>
            <div class="row" style="margin-top: 40px ">
                <input type="hidden" id="materiasexiste" value="no">
                <div class="col-xs-12 table-responsive" id="materiasasignadas">
                </div>
            </div>
    </div>
</div>
<div class="box">
    <div class="box-header">
        <h4 class="box-title">Tareas</h4>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row" style="margin-top: 40px ">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Calendario</a></li>
                        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tareas</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <p>Aca iria el Calendario</p>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <?php $this->load->view(TAREAS_ASIGNAR.'/tareas')?>
                        </div>
                        <div class="row" hidden id="incompleto">
                            <div class="col-xs-12">
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Datos incompletos</h4>
                                    <p id="mensajeincompleto"></p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-2 col-xs-6">
                            <?php if($etapa->estado == 'planificado')
             {
            echo '<button class="btn btn-primary btn-block" onclick="valida()">Iniciar Etapa</button>';
             }else if($etapa->estado == 'En Curso')
             {
              echo '<button class="btn btn-primary btn-block" id="btnfinalizar" onclick="finalizar()">Finalizar Etapa</button>';
             }
             ?>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <button class="btn btn-primary btn-block" onclick="guardar()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box -->
    </div>
</div>
<script>
        accion = '<?php echo $accion;?>';
        if (accion == "Editar") {
            var materias = <?php echo json_encode($etapa->materias);?>;
            for (i = 0; i < materias.length; i++) {
                materia = materias[i];
                materia = JSON.stringify(materia);
                materia = '[' + materia + ']';
                materia = JSON.parse(materia);
                agregaMateria(materia);
            }
        }

        function actualizaRecipiente(establecimiento, recipientes) {
            establecimiento = establecimiento;

            $.ajax({
                type: 'POST',
                data: {
                    establecimiento: establecimiento
                },
                url: 'general/Recipiente/listarPorEstablecimiento',
                success: function(result) {
                    result = JSON.parse(result);                    
                    var html = "";
                    html = html + '<option value="" disabled selected>-Seleccione Recipiente-</option>';
                    for (var i = 0; i < result.length; i++) {
                        html = html + '<option value="' + result[i].id + '">' + result[i].titulo + '</option>';
                    }
                    document.getElementById(recipientes).disabled = false;
                    document.getElementById(recipientes).innerHTML = html;
                },
                //dataType: 'json'

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

        function guardar() {

            var tabla = $('#tablamateriasasignadas tbody tr');       
            var materiales = [];
            var materia = []; 
            var i = 0;   
            $.each(tabla, function(index){
                var cantidad = $(this).find("td").eq(3).html();
                var id_materia = $(this).attr("id");               
                if(id_materia != null){
                    materia[id_materia] = cantidad;
                }                                 
            });
            lote = document.getElementById('Lote').value;
            fecha = document.getElementById('fecha').value;
            establecimiento = document.getElementById('establecimientos').value;
            recipiente = document.getElementById('recipientes').value;
            op = document.getElementById('ordenproduccion').value;
            idetapa = <?php echo $idetapa;?>;

            $.ajax({
                type: 'POST',
                data: {
                    idetapa: idetapa,
                    lote: lote,
                    fecha: fecha,
                    establecimiento: establecimiento,
                    recipiente: recipiente,
                    op: op,
                    materia:materia
                },
                url: 'general/Etapa/guardar',
                success: function(result) {
                    if (result == "ok") {
                        linkTo('general/Etapa/index');
                    }else{
											alert("Hubo un error en BD");
										} 
                    if(result == 'Error al Inciar Proceso'){
                        alert("Hubo un error al iniciar Proceso BPM");
                    }else{
											linkTo('general/Etapa/index');
										}
                }
            });
        }

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

       


        $("#inputmaterias").on('change', function() {
            document.getElementById('cantidadmateria').value = "";
            materias = <?php echo json_encode($materias);?>;
            
            titulo = document.getElementById('inputmaterias').value;
            ban = false;
            i = 0;
            while (!ban && i < materias.length) {
                if (titulo == materias[i].titulo) {
                    ban = true;
                    materia = materias[i];
                }
                i++;
            }
            if (ban) {
                document.getElementById('stockdisabled').value = materia.stock;
                materia = JSON.stringify(materia);

                 //agregaMateria(materia);
                $('#idmateria').attr('data-json', materia);
                //document.getElementById('stockdisabled').value = ma
                document.getElementById('cantidadmateria').disabled = false;
                document.getElementById('botonmateria').disabled = false;
            } else {
                alert('No existe esa Materia');
                document.getElementById('cantidadmateria').disabled = true;
                document.getElementById('botonmateria').disabled = true;
            }

        });

        function aceptarMateria() {
            cantidad = document.getElementById('cantidadmateria').value;
            materia = $('#idmateria').attr('data-json');
            materia = JSON.parse(materia);
            materia.cantidad = cantidad;
            materia = JSON.stringify(materia);
            materia = '[' + materia + ']';
            materia = JSON.parse(materia);
            console.log(materia);
            agregaMateria(materia);


        }

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