<?php $this->load->view('etapa/modal_materia_prima'); ?>
<?php $this->load->view('etapa/modal_lotes'); ?>
<?php $this->load->view('etapa/modal_producto'); ?>

<script>
function validarEtapa() {
    if ($('#estado_etapa').val() != 'PLANIFICADO') {
        //Inhabilitar la edicion del los formularios
        $('#frm-etapa').find('.form-control').prop('disabled', true);
    }
}
</script>

<input class="hidden" type="text" id="estado_etapa" value="<?php echo $etapa->estado ?>">
<input class="hidden" type="text" id="accion" value="<?php echo $accion ?>">
<?php if ($etapa->estado == "En Curso") {
        $this->load->view('etapa/modal_finalizar');
    } ?>
<div id="snapshot" data-key="<?php echo $key ?>" id="frm-etapa">

    <!-- Cabecera -->
    <div class="box box-primary">

        <div class="box-header">
            <h3 class="box-title">
                <?php echo $accion . ' ' . $etapa->titulo ?>
            </h3>
            <button class="btn btn-success btn-xs pull-right" onclick="deleteSnapshot()">Limpiar Campos</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <input type="hidden" value="<?php echo isset($etapa)?$etapa->id:null ?>" id="batch_id" name="batch_id">
                <div class="col-md-1 col-xs-12">
                    <label for="Lote" class="form-label">Codigo Lote:*</label>
                </div>
                <div class="col-md-5 col-xs-12">
                    <input name="vcode" type="text" id="Lote" <?php if ($accion == 'Editar') {
                        echo 'value="' . $etapa->lote . '"';
                    } ?> class="form-control" placeholder="Inserte Lote" <?php if ($etapa->estado == 'En Curso' || $etapa->estado == 'FINALIZADO') {
                                                                        echo 'disabled';
                                                                    } ?>>
                </div>
                <div class="col-md-1 col-xs-12">
                    <label for="fecha" class="form-label">Fecha:</label>
                </div>
                <div class="col-md-5 col-xs-12">

                    <?php
                    if ($accion == 'Editar' || $accion == 'Nuevo') {
                        echo '<input type="" id="fecha" class="form-control" value="' . $fecha . '" disabled >';
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
                    <?php
                     
                        echo selectBusquedaAvanzada('recipientes', 'vreci');
                    
                    ?>
                </div>
            </div>
            <div class="row" style="margin-top: 50px">
                <div class="col-md-2 col-xs-12">
                    <label for="op" class="form-label">Orden de Produccion:</label>
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
            <div class="row" style="margin-top: 40px">
                <div class="col-xs-12">
                    <i class="glyphicon glyphicon-plus"></i><a onclick="despliega()" class="">Datos Adicionales</a>
                    <div id="desplegable" hidden>
                        <h3></h3>
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

                        <!-- /.box-body -->
                        <div class="modal-footer">

                            <?php 

                            if($etapa->estado != 'FINALIZADO'){

                                if ($etapa->estado == 'En Curso') {
                                    
                                    echo '<button class="btn btn-primary" id="btnfinalizar" onclick="finalizar()">Reporte de Producción</button>';
                                    
                                } else {
                                    
                                    echo "<button class='btn btn-primary' onclick='guardar(\"iniciar\")'>Iniciar Etapa</button>";
                                    echo "<button class='btn btn-primary' onclick='guardar(" . '"guardar"' . ")'>Guardar</button>";
                                }
                            }

                            
                            ?>
                            <button class="btn btn-danger" onclick="back()">Cerrar</button>
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
actualizaRecipiente($('#establecimientos').val(), 'recipientes');



function actualizaRecipiente(establecimiento, recipientes) {

    var reci_id = <?php echo $etapa->reci_id ? $etapa->reci_id : null ?> ;

    $('#recipientes').empty();
    establecimiento = establecimiento;
    if (!establecimiento) return;
    wo();
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

            if (reci_id) {
                $('#recipientes').val(reci_id);
                $('#recipientes').trigger('change');
                if ($('#estado_etapa').val() != 'PLANIFICADO') {
                    //Inhabilitar la edicion del los formularios
                    $('#recipientes').prop('disabled', true);
                }
            }

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
        url: 'general/Etapa/guardar/iniciar',
        data: {
            data
        },
        success: function(rsp) {
            console.log(rsp);
            if (rsp.status) {
                alert('Salida Guardada exitosamente.');
                linkTo('general/Etapa/index');
            } else {
                alert('Fallo al iniciar la etapa');
            }
        },
        error: function(rsp) {
            alert('Error al iniciar etapa');
        },
        complete: function() {
            wc();
        }
    });
}
// envia datos para iniciar etapa y acer orden de pedido a almacenes
function guardar(boton) {

    var recipiente = idprod = '';
    var tabla = $('#tablamateriasasignadas tbody tr');
    var materiales = [];
    var materia = [];

    $.each(tabla, function(index) {
        var cantidad = $(this).find("td").eq(3).html();
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
        idetapa: idetapa,
        lote: lote,
        fecha: fecha,
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
        url: 'general/Etapa/guardar/' + boton,
        data: {
            data
        },
        success: function(rsp) {
            console.log(rsp);
            if (rsp.status) {
                alert('Salida Guardada exitosamente.');
                linkTo('general/Etapa/index');
            } else {
                if (rsp.msj) {
                    conf(guardarForzado, data, '¿Confirma Unificación de Lotes?', rsp.msj + " | Detalle del Contenido: LOTE: " + rsp.lote_id + " | PRODUCTO: " + rsp.barcode);
                } else {
                    alert('Fallo al iniciar la etapa');
                }
            }
        },
        error: function(rsp) {
            alert('Error al iniciar etapa');
        },
        complete: function() {
            wc();
        }
    });
}
// envia datos para iniciar etapa y acer orden de pedido a almacenes
// function guardar(boton) {

//     var recipiente = idprod = '';
//     var tabla = $('#tablamateriasasignadas tbody tr');
//     var materiales = [];
//     var materia = [];

//     $.each(tabla, function(index) {
//         var cantidad = $(this).find("td").eq(3).html();
//         var id_materia = $(this).attr("id");
//         if (id_materia != null) {
//             materia.push({
//                 id_materia,
//                 cantidad
//             });
//         }
//     });

//     var lote = $('#Lote').val();
//     var fecha = $('#fecha').val();
//     var establecimiento = document.getElementById('establecimientos').value;

//     var op = document.getElementById('ordenproduccion').value;
//     var idetapa = <--?php echo $idetapa ?> ;
//     var cantidad = $('#cantidad_producto').val();

//     var prod = getJson($('#idproducto'));
//     var prod = prod ? prod.id : 0;


//     var recipiente = getJson($('#recipientes'));
//     var recipiente = recipiente ? recipiente.reci_id : 0;

//     var estadoEtapa = $('#estadoEtapa').val();
//     var batch_id = $('#batch_id').val();

//     var data = {
//         idetapa: idetapa,
//         lote: lote,
//         fecha: fecha,
//         establecimiento: establecimiento,
//         recipiente: recipiente,
//         op: op,
//         materia: materia,
//         cantidad: cantidad,
//         idprod: prod,
//         estadoEtapa: estadoEtapa,
//         batch_id: batch_id
//     };

//     wo();
//     $.ajax({
//         type: 'POST',
//         dataType: 'JSON',
//         url: 'general/Etapa/guardar/' + boton,
//         data: {
//             data
//         },
//         success: function(rsp) {
//             console.log(rsp);

//             if (rsp.status) {
//                 alert('Salida Guardada exitosamente.');
//                 linkTo('general/Etapa/index');
//             } else {
//                 alert('Fallo al guardar. Msj: ' + rsp);
//             }
//         },
//         error: function(rsp) {
//             alert('Error al Guardar Salida. Msj: ' + rsp);
//             console.log("error: " + rsp);
//         },
//         complete: function() {
//             wc();
//         }
//     });
// }


// selecciona id de producto y guarda en input hidden
$("#inputproductos").on('change', function() {

    band = false;
    i = 0;
    $('#idproducto').val("");
    articulos = <?php echo json_encode($materias) ?> ;
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
$(document).off('click', '.tablamateriasasignadas_borrar').on('click', '.tablamateriasasignadas_borrar', {
    idtabla: 'tablamateriasasignadas',
    idrecipiente: 'materiasasignadas',
    idbandera: 'materiasexiste'
}, remover);

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