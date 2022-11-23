<?php $this->load->view('etapa/modal_materia_prima'); ?>
<?php $this->load->view('etapa/modal_lotes'); ?>
<?php $this->load->view('etapa/modal_producto'); ?>
<?php $this->load->view('etapa/modal_unificacion_lote'); ?>

<div id="pnl-etapa" data-key="<?php echo $key ?>">
    <?php if ($etapa->estado == "En Curso") {
        $this->load->view('etapa/modal_finalizar');
    } ?>

    <!-- Cabecera -->
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">
                <?php echo $accion . ' ' . $etapa->titulo ?>
            </h3>
            <!-- <button class="btn btn-success btn-xs pull-right" onclick="deleteSnapshot()">Limpiar Campos</button> -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row form-group">
                <input type="hidden" value="0" id="batch_id" name="batch_id">
                <div class="col-md-2 col-xs-12">
                    <label for="Lote" class="form-label">Código Lote:*</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <input name="vcode" type="text" id="Lote" <?php if ($accion == 'Editar') {
                        echo 'value="' . $etapa->lote . '"';
                    } ?> class="form-control" placeholder="Inserte Lote"
                        <?php if ($etapa->estado == 'En Curso' || $etapa->estado == 'FINALIZADO') {
                                                                                                                            echo 'disabled';
                                                                                                                        } ?>>
                </div>
                <div class="col-md-1 col-xs-12">
                    <label for="fecha" class="form-label">Fecha:</label>
                </div>
                <div class="col-md-5 col-xs-12">

                    <?php
                    if ($accion == 'Editar' || $accion == 'Nuevo') {
                        echo '<input type="date" id="fecha" class="form-control" value="' . $fecha . '"  >';
                    }
                    ?>

                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2 col-xs-12">
                    <label for="establecimientos" class="form-label">Establecimiento*:</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <select class="form-control select2 select2-hidden-accesible" name="vestablecimiento"
                        onchange="actualizaRecipiente(this.value,'recipientes')" id="establecimientos"
                        <?php if ($etapa->estado == 'En Curso' || $etapa->estado == 'FINALIZADO') {                                                                                                                                                            echo 'disabled';
                                                                                                                                                                                            } ?>>
                        <option value="" disabled selected>-Seleccione Establecimiento-</option>
                        <?php
                        foreach ($establecimientos as $fila) {

                            if (($accion == 'Editar' || $etapa->estado == 'FINALIZADO') && $fila->nombre == $etapa->establecimiento) {

                                echo '<option value="' . $fila->esta_id . '" selected>' . $fila->nombre . '</option>';
                            } else {

                                echo '<option value="' . $fila->esta_id . '" >' . $fila->nombre . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-1 col-xs-12">
                    <?php if ($accion == 'Nuevo') {
                        echo '<label for="Recipiente" class="form-label">' . $etapa->titulorecipiente . '*:</label>';
                    } ?>
                    <?php if ($accion == 'Editar' || $etapa->estado == 'FINALIZADO') {
                        echo    '<label for="Recipiente" class="form-label"> ' . $etapa->reci_estab_nom . ' *:</label>';
                    } ?>
                </div>

                <div class="col-md-5 col-xs-12">
                    <?php if ($accion == 'Nuevo') {
                        echo selectBusquedaAvanzada('recipientes','vreci', array('Tipo'=>'tipo','Estado:'=>'estado')); 
                    } elseif ($accion == 'Editar' && $etapa->estado != 'PLANIFICADO') {
                        echo "<input value='$etapa->recipiente' type='text' class='form-control' readonly id='recipientes_id' name='recipientes_id'>";
                    } elseif ($accion == 'Editar' && $etapa->estado == 'PLANIFICADO') {
                        echo "<div class='recipienteSelected input-group'>";
                        echo "<div class=''><input value='$etapa->recipiente' data-json='$etapa->reci_id' type='text' class='form-control' id='recipientesHidden' name='recipientesHidden' readonly></div>";
                        echo "<span class='input-group-btn'><button id='buttonRecipi' type='button' class='btn btn-primary btn-flat' onclick='callRecipiente()'>Editar</button></span>
                        </div>";
                        echo "<div class='col-md-12 col-xs-12 recipientesDiv'>";
                        echo selectBusquedaAvanzada('recipientes', 'vreci', array('Tipo'=>'tipo','Estado:'=>'estado'));
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-2 col-xs-12">
                    <label for="op" class="form-label">Orden de Producción:</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <input type="text" id="ordenproduccion" class="form-control" name="vorden" <?php if ($accion == 'Editar' || $etapa->estado == 'PLANIFICADO') {
                        echo ('value="' . $etapa->orden . '"');
                    } ?> placeholder="Inserte Orden de Produccion"
                        <?php if ($etapa->estado == 'En Curso' || $etapa->estado == 'FINALIZADO') {
                            echo 'disabled';
                        } ?>>
                </div>
                <?php
                if ($accion == 'Editar') {
                    echo "<div class='col-md-1 col-xs-12'>
                    <label for='estadoEtapa' class='form-label'>Estado:</label>
                </div>
                <div class='col-md-5 col-xs-12'>
                    <input type='text' id='estadoEtapa' class='form-control' name='estadoEtapa' ";
                    echo 'value="' . $etapa->estado . '" disabled>
                </div>';
                } ?>
            </div>
            
            <div class="row">
                <div class="col-xs-12">
                    <a onclick="despliega()" href="#"><i class="glyphicon glyphicon-plus"></i>Datos Adicionales</a>
                    <div id="desplegable" class="panel panel-default" hidden>
                        <div class="panel-heading">Formulario Etapa</div>
                        <div class="panel-body"><?php echo nuevoForm($form_id) ?></div>
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
</div>
<tareas>
    <script>
    $('tareas').load('<?php echo base_url(TST) ?>Tarea/planificar/BATCH/' + $('#batch_id').val());
    </script>
</tareas>

<!-- Tareas -->
<div class="box box-primary">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="modal-footer">
            <?php if ($etapa->estado != 'En Curso' || $etapa->estado != 'Finalizado') {
                echo "<button class='btn btn-primary' onclick='guardar(\"iniciar\")'>Iniciar Etapa</button>";
                } else if ($etapa->estado == 'En Curso') {
                    echo '<button class="btn btn-primary" id="btnfinalizar" onclick="finalizar()">Reporte de Producción</button>';
                }
                echo "<button class='btn btn-primary' onclick='guardar(" . '"guardar"' . ")'>Guardar</button>";
            ?>
            <button class="btn btn-default" onclick="back()">Cerrar</button>
        </div>
    </div>
    <!-- /.box -->
</div>

<script>
$('.frm-save').hide();
initForm();
var estadoEtapa = $('#estadoEtapa').val();
if (estadoEtapa == 'PLANIFICADO') {
    $(".recipientesDiv").addClass("hidden");
}

callRecipiente();

function callRecipiente() {
    actualizaRecipiente($('#establecimientos').val());
}

accion = '<?php echo $accion; ?>';
if (accion == "Editar") {
    var materias = <?php echo json_encode($etapa-> materias); ?> ;
    if (_isset(materias)) {
        for (i = 0; i < materias.length; i++) {
            materia = materias[i];
            materia = JSON.stringify(materia);
            materia = '[' + materia + ']';
            materia = JSON.parse(materia);
            //agregaMateria(materia);
        }
    }
}

function actualizaRecipiente(establecimiento, recipientes) {
    $(".recipienteSelected").addClass("hidden");
    $(".recipientesDiv").removeClass("hidden");
    $('#recipientes').empty();
    establecimiento = establecimiento;
    if (!establecimiento) return;
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {
            establecimiento,
            tipo: 'PRODUCTIVO'
        },
        url: '<?php echo base_url(PRD) ?>general/Recipiente/listarPorEstablecimiento/true',
        success: function(result) {

            if (!result.status) {
                alert('Fallo al Traer Recipientes');
                return;
            }

            if (!result.data) {
                Swal.fire(
        'Error',
        'No hay Recipientes Asociados.',
        'error'
      );
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

var guardarForzado = function(data) {
    console.log('Guardar Forzado...');
    data.forzar = "true";
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Etapa/guardar/iniciar',
        data: {
            data
        },
        success: function(rsp) {
            console.log(rsp);
            if (rsp.status) {
                setAttr('#origen', 'orta_id', rsp.batch_id);
                guardarTodasTareas();
                $('#mdl-unificacion').modal('hide');
                Swal.fire(
        'Hecho',
        'Salida Guardada exitosamente.',
        'success'
      );
                linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');
            } else {
                alert('Fallo al iniciar la etapa');
            }
        },
        error: function() {
            alert('Error al iniciar etapa');
        },
        complete: function() {
            wc();
        }
    });
}
// envia datos para iniciar etapa y acer orden de pedido a almacenes
function guardar(boton) {

    var dataReci =  getJson($('#recipientes'))
    if(boton == "guardar" && dataReci.estado == "LLENO")
    {
        alert('Para iniciar etapa el recipiente seleccionado debes estar vacío.');
        return;
    }

    if (!validarCampos()) return;

    $('.frm').find('.frm-save').click();
    var info_id = $('.frm').attr('data-info');
    var recipiente = idprod = '';
    var tabla = $('#tablamateriasasignadas tbody tr');
    var materiales = [];
    var materia = [];

    $.each(tabla, function(index) {
        var cantidad = $(this).find("td").eq(4).html();
        var id_materia = $(this).attr("id");
        if (id_materia != null) {
            materia.push({
                id_materia,
                cantidad
            });
        }
    });

    var lote = $('#Lote').val();
    var fecha = $('#fecha').val();

    //Invierto formato de fecha
    var nueva_fecha =fecha.split(" ")[0];
    var format = nueva_fecha.split("-");
    var ultima = format[2]+'-'+format[1] +'-'+format[0];



    var establecimiento = document.getElementById('establecimientos').value;

    var op = document.getElementById('ordenproduccion').value;
    var idetapa = <?php echo $idetapa ?> ;
    var cantidad = $('#cantidad_producto').val();

    var prod = getJson($('#idproducto'));
    var prod = prod ? prod.arti_id : 0;

    var recipiente = getJson($('#recipientes'));
    var recipiente = recipiente ? recipiente.reci_id : 0;

    var estadoEtapa = $('#estadoEtapa').val();
    var batch_id = $('#batch_id').val();

    var data = {
        info_id: info_id,
        idetapa: idetapa,
        lote: lote,
        fecha: ultima,
        establecimiento: establecimiento,
        recipiente: recipiente,
        op: op,
        materia: materia,
        cantidad: cantidad,
        idprod: prod,
        estadoEtapa: estadoEtapa,
        batch_id: batch_id,
        forzar: "false"
    };

    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Etapa/guardar/' + boton,
        data: {
            data
        },
        success: function(rsp) {
            if (rsp.status) {
                setAttr('#origen', 'orta_id', rsp.batch_id);
                guardarTodasTareas();
                Swal.fire(
        'Hecho',
        'Salida Guardada exitosamente.',
        'success'
      );
                linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');
            } else {
                if (rsp.msj) {
                    // conf(guardarForzado, data, '¿Confirma Unificación de Lotes?', rsp.msj + " | Detalle del Contenido: LOTE: " + rsp.lote_id + " | PRODUCTO: " + rsp.barcode);
                    bak_data = data;
                    getContenidoRecipiente(recipiente);
                } else {
                    alert('Fallo al iniciar la etapa');
                }
            }
        },
        error: function() {
            alert('Error al iniciar etapa');
        },
        complete: function() {
            wc();
        }
    });
}

function validarCampos() {
    if ($('#Lote').val() == "" || $('#establecimientos').val() == "" || $('#recipientes').val() == "") {
        alert('Completar los campos obligatorios *');
        return false;
    }

    if ($('#tablamateriasasignadas tbody tr').length == 0) {
        alert('No ha seleccionado ninguna materia prima');
        return false;
    }

    if ($('#idproducto').val() != null && $('#cantidad_producto').val() == '') {
        alert('Por favor ingresar cantidad para el Producto');
        return false;
    }

    if(($('#fecha').val() == '' )){
        alert('Por favor ingresar fecha');
        return false;
    }

    return true;
}


// valida campos vacios
function valida(boton) {
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
    if ($('#establecimientos').val() == "") {
        mensaje += "- No ha seleccionado establecimiento <br>";
        ban = false;
    }
    if ($('#recipientes').val() == "") {
        mensaje += "- No ha seleccionado recipiente <br>";
        ban = false;
    }
    if (document.getElementById('materiasexiste').value == "no") {
        mensaje += "- No ha seleccionado ninguna materia prima <br>";
        ban = false;
    } //################# SOLUCIONAR ERROR AL INSERTAR MATERIA #################################################
    if (document.getElementById('existe_tabla').value == "no") {
        mensaje += "- No ha seleccionado ninguna tarea <br>";
        ban = false;
    }
    if (ban) {
        guardar(boton);
    }
    // else {
    //     document.getElementById('mensajeincompleto').innerHTML = "";
    //     document.getElementById('mensajeincompleto').innerHTML = mensaje;
    //     document.getElementById('incompleto').hidden = false;
    // }
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

    $("#modal_finalizar").modal('show');
}


<?php
if ($accion == 'Editar' && $etapa->estado == "PLANIFICADO") { 

?>

    var inputs = $("#editFinal").html();
    $("#editPlani").html(inputs);

    function editProducto() {
        $("#editPlani").empty();
        var select = $("#nuevaEtapa").html();
        $("#editPlani").html(select);
    }

    <?php
} ?>
</script>