<?php $this->load->view('etapa/modal_materia_prima'); ?>
<?php $this->load->view('etapa/modal_lotes'); ?>
<?php $this->load->view('etapa/modal_producto'); ?>
<?php $this->load->view('etapa/modal_unificacion_lote'); ?>

<input class="hidden" type="text" id="verificaEntregaMateriales" value="<?php echo $etapa->realizo_entrega_materiales ?>">
<input class="hidden" type="text" id="estado_etapa" value="<?php echo $etapa->estado ?>">
<input class="hidden" type="text" id="accion" value="<?php echo $accion ?>">
<?php if ($etapa->estado == "En Curso") {
    $this->load->view('etapa/modal_finalizar');
} ?>
<div id="snapshot" data-key="<?php echo $key ?>" id="frm-etapa">
    <!-- Cabecera -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <?php echo 'Gestionar' . ' ' . $etapa->titulo . ($etapa->realizo_entrega_materiales == 'false' ? ' <i class="fa fa-edit"></i>' : ''); ?>
            </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <input type="hidden" value="<?php echo isset($etapa) ? $etapa->id : null ?>" id="batch_id" name="batch_id">
                <div class="col-md-1 col-xs-12">
                    <label for="Lote" class="form-label">Código Lote:*</label>
                </div>
                <div class="col-md-5 col-xs-12">
                    <input name="vcode" type="text" id="Lote" <?php echo ($accion == 'Editar') ? 'value="' . $etapa->lote . '"' : ''; ?> class="form-control" placeholder="Inserte Lote" <?php echo (($etapa->estado == 'En Curso' && $etapa->realizo_entrega_materiales == 'true') || $etapa->estado == 'FINALIZADO') ? 'disabled' : ''; ?>>
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
                    <select class="form-control select2 select2-hidden-accesible" name="vestablecimiento" onchange="actualizaRecipiente(this.value,'recipientes')" id="establecimientos" <?php if (($etapa->estado == 'En Curso' && $etapa->realizo_entrega_materiales == 'true') || $etapa->estado == 'FINALIZADO') {
                                                                                                                                                                                                echo 'disabled';
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
                    <label for="op" class="form-label">Orden de Producción:</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <input type="text" id="ordenproduccion" class="form-control" name="vorden" <?php if ($accion == 'Editar' || $etapa->estado == 'PLANIFICADO') {
                                                                                                    echo ('value="' . $etapa->orden . '"');
                                                                                                } ?> placeholder="Inserte Orden de Produccion" <?php if (($etapa->estado == 'En Curso' && $etapa->realizo_entrega_materiales == 'true') || $etapa->estado == 'FINALIZADO') {
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
                    <a onclick="despliega()" class=""><i class="glyphicon glyphicon-plus"></i>Datos Adicionales</a>
                    <div id="desplegable" class="panel panel-default" hidden>
                        <div class="panel-heading">Formulario Etapa</div>
                        <div class="panel-body"><?php echo getForm($etapa->info_id) ?></div>
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
    <tareas>
        <script>
            $('tareas').load('<?php echo base_url(TST) ?>Tarea/planificar/BATCH/' + $('#batch_id').val());
        </script>
    </tareas>
    <!-- FIN TAREAS -->
    <div class="box box-primary">
        <div class="box-body">
            <!-- /.box-body -->
            <div class="modal-footer">
                <?php
                if ($etapa->estado != 'FINALIZADO') {
                    if ($etapa->estado == 'En Curso') {
                        echo '<button class="btn btn-primary" id="btnfinalizar" onclick="finalizar()">Reporte de Producción</button>';
                        $this->load->view('etapa/btn_finalizar_etapa');
                    } else {
                        echo "<button class='btn btn-primary' onclick='guardar(\"iniciar\")'>Iniciar Etapa</button>";
                        echo "<button class='btn btn-primary' onclick='guardar(" . '"guardar"' . ")'>Guardar</button>";
                    }
                }
                ?>
                <button class="btn btn-default" onclick="back()">Cerrar</button>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
<!-- ./ Tareas-->
</div>


<script>
    initForm();
    $('.frm').find('.frm-save').hide();
    actualizaRecipiente($('#establecimientos').val(), 'recipientes');

    function actualizaRecipiente(establecimiento, recipientes) {

        var reci_id = <?php echo $etapa->reci_id ? $etapa->reci_id : null ?>;

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
                    error('Error', 'Fallo al traer los recipientes');
                    return;
                }

                if (!result.data) {
                    error('Error', 'No hay Recipientes Asociados.');
                    return;
                }
                fillSelect('#recipientes', result.data);

                if (reci_id) {
                    $('#recipientes').val(reci_id);
                    $('#recipientes').trigger('change');
                    if ($('#estado_etapa').val() == 'FINALIZADO' || ($('#estado_etapa').val() == 'En Curso' && $('#verificaEntregaMateriales').val() == 'true')) {
                        //Inhabilitar la edicion del los formularios
                        $('#recipientes').prop('disabled', true);
                    }
                }

            },
            error: function() {
                error('Error', 'Fallo al traer los recipientes');
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

        // if($('#cantidad_producto').val() == ''){
        //     alert('Por favor ingresar cantidad para el Producto');
        //     return false;
        // }
        
        $('.frm').find('.frm-save').click();

        var recipiente = idprod = '';
        var tabla = $('#tablamateriasasignadas tbody tr');
        var materiales = [];
        var materia = [];

        $.each(tabla, function(index) {
            var cantidad = $(this).find("td").eq(6).html();
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
        var idetapa = <?php echo $idetapa ?>;
        var cantidad = $('#cantidad_producto').val();

        var prod = getJson($('#idproducto'));
        var prod = prod ? prod.arti_id : 0;

        var recipiente = getJson($('#recipientes'));
        console.log(recipiente);
        if (!recipiente) {
            
          // Redirigir al campo select
            $('html, body').animate({
                scrollTop: $('#recipientes').offset().top
            }, 800);
            
            $('#recipientes').focus(function () {
                $(this).css('background-color', 'yellow');
            }); // Darle el foco al campo select

            
        }else {
              // var recipiente = recipiente ? recipiente.reci_id : 0;
            recipiente = recipiente.reci_id;
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
            url: '<?php echo base_url(PRD) ?>general/Etapa/guardar/' + boton,
            data: {
                data
            },
            success: function(rsp) {
                if (rsp.status) {
                    hecho('Hecho', 'Salida Guardada exitosamente.');
                    linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');
                } else {
                    if (rsp.msj) {
                        bak_data = data;
                        getContenidoRecipiente(recipiente);
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
      
    }

    // selecciona id de producto y guarda en input hidden
    $("#inputproductos").on('change', function() {

        band = false;
        i = 0;
        $('#idproducto').val("");
        articulos = <?php echo json_encode($materias) ?>;
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


    /////////////
    //Valida que la variable QC_OK del formulario de calidad este Aprobada
    //Si sale por el else, es una etapa de fraccionamiento
    function validarFormularioControlCalidad() {
        wo();
        origenFormulario = _isset($("#origen").attr('data-json')) ? JSON.parse($("#origen").attr('data-json')) : null;
        // debugger;
        console.log(origenFormulario);

        let validacionForm = new Promise((resolve, reject) => {
            wo();
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '<?php echo base_url(PRD) ?>general/etapa/validarFormularioCalidad/' + origenFormulario.orta_id + '/' + origenFormulario.origen,
                success: function(res) {
                   
                    resolve(res);
                },
                error: function(res) {
                    reject(false);
                }
            });
        });
        return validacionForm;

    }
    // levanta modal para finalizar la etapa solamente
    function finalizar() {
        //validar control de calidad
        let tablaTarea = document.getElementById("tareas-calendario");
        let filas = tablaTarea.rows;
        if (filas.length > 1) {
            validarFormularioControlCalidad().then((result) => {
                console.log(result);
                wc();
                if (result.status) {

                    $("#modal_finalizar").modal('show');
                } else {
                    notificar('Nota', '<b>Para realizar un reporte de producción el formulario de calidad debe estar aprobado</b>', 'warning');
                }
            }).catch((err) => {
                wc();
                error();
                console.log(err);
            });
        } else {
            notificar('Nota', '<b>Para realizar un reporte de producción debe haber tareas asignadas</b>', 'warning');
        }

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