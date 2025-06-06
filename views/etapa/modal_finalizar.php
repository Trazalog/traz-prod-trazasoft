<style>
/* Aumentar el tamaño del modal qr*/
#modalCodigos .modal-dialog {
    max-width: 50%; 
    width: auto; 
}
</style>
<div class="modal" id="modal_finalizar" role="dialog" style="overflow-y: auto !important; " aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <!-- modal viejo -->
        <div id="pnl-1" class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span>Reporte de Producción</h4>
            </div>
            <input class="hidden" type="text" id="num_orden_prod" value="<?php echo $etapa->orden; ?>">
            <input class="hidden" type="text" id="batch_id_padre" value="<?php echo $etapa->id; ?>">
            <input class="hidden" type="text" id="LoteAsociarNoConsumible">
            <div class="modal-body" id="modalBodyArticle">
                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Establecimiento:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text" value="<?php echo $etapa->establecimiento ?>" disabled></div>
                    <div class="col-md-5"></div>
                </div>
                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Código Lote Origen:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="loteorigen" value="<?php echo $etapa->lote; ?>" disabled></div>
                    <div class="col-md-5"></div>
                </div>
                <div class="row form-group <?php echo ($producto ? '' : 'hidden') ?>" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Producto:</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" type="text" id="prod_origen" value="<?php echo $producto[0]->descripcion; ?>" disabled></div>
                    <div class="col-md-5"></div>
                </div>
                <div class="row form-group <?php echo ($producto ? '' : 'hidden') ?>" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="cant_origen" value="<?php echo $etapa->existencia->cantidad . ' (' . $producto[0]->uni_med . ')'; ?>" disabled></div>
                    <div class="col-md-5"></div>
                </div>
                <div class="row form-group <?php echo ($producto ? '' : 'hidden') ?>" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad a Extraer:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="cant_descontar" value="<?php echo ($producto ? '' : 0) ?>" placeholder="Inserte cantidad a Extraer"></div>
                    <div class="col-md-5"></div>
                </div>
                <input class="hidden" type="text" id="unificar">
                <!-- Recursos de Trabajo -->
                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Operario:</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control datalist" list="operarios" id="operario"><datalist id="operarios"><?php foreach ($rec_trabajo as $o) {
                            echo "<option value='$o->descripcion' data-json='" . json_encode($o) . "'></option>";
                        } ?></datalist>
                    </div>
                    <div class="col-md-5"></div>
                </div>
                <!-- Fin | Recursos de Trabajo -->
                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12">
                        <label for="inputproducto" class="form-label">Producto <?php hreq() ?>:</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 col-md-8 col-lg-8 ba">
                            <select style="width: 100%" class="form-control select2-hidden-accesible habilitar requerido" id="inputproducto">
                                <option value="" data-foo='' disabled selected>-Seleccione opción-</option>
                                <?php
                                foreach ($productos_salida_etapa as $articulo) {
                                    echo "<option value='$articulo->arti_id' data-json='" . json_encode($articulo) . "' data-foo='<small><cite>$articulo->descripcion</cite></small>  <label>♦ </label>   <small><cite>$articulo->stock</cite></small>  <label>♦ </label> <small><cite>$articulo->um</cite></small>' >$articulo->barcode</option>";
                                }
                                ?>
                            </select>
                            <?php
                            echo "<label id='detalle' class='select-detalle' class='text-blue'></label>";
                            ?>
                        </div>
                    </div>
                    <!--__________________________-->
                    <div class="col-md-3"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad <?php hreq() ?>:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" id="cantidadproducto" type="text" value="" placeholder="Inserte Cantidad"></div>
                    <div class="col-md-2 col-xs-2">
                        <input type="text" class="form-control" value=" - " id="um" disabled>
                    </div>
                    <div class="col-md-5"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Lote Destino <?php hreq() ?>:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="lotedestino" value="" placeholder="Inserte Lote destino"></div>
                    <div class="col-md-4 col-xs-12"><button class="btn btn-primary btn-block" onclick="copiaOrigen()">Copiar Lote Origen</button></div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Destino <?php hreq() ?>:</label></div>
                    <div class="col-md-6 col-xs-12">
                        <?php if ($accion == 'Editar') {
                            echo selectBusquedaAvanzada('productodestino', false);
                        }
                        ?>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <!-- <div class="row" style="margin-top: 20px">
                    <div class="col-md-3 col-xs-12">
                        <label for="establecimientos" class="form-label">Establecimiento Final:</label>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <select class="form-control select2" id="productoestablecimientos">
                            <option disabled selected>-Seleccione Establecimiento-</option>
                            <?php
                            // foreach($establecimientos as $fila)
                            // {
                            //     echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
                            // } 
                            ?>
                        </select>

                    </div>
                    <div class="col-md-3"></div>
                </div> -->
                <!-- <div class="row" style="margin-top: 20px">
                    <div class="col-md-3 col-xs-12">
                        <label for="establecimientos" class="form-label">Recipiente Final:</label>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="productorecipientes" disabled>
                            <option value="false" disabled selected>-Seleccione Establecimiento-</option>
                        </select>
                    </div>
                    <div class="col-md-3"></div>
                </div> -->
                <!-- <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Requiere Fraccionada:</label></div>
                    <div class="col-md-1 col-xs-12"><input type="checkbox" id="fraccionado" value=""></div>
                    <div class="col-md-8"></div>
                </div> -->
                <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"></div>
                    <div class="col-md-3 col-xs-12"><button class="btn btn-success btn-block" onclick="AgregarProducto()"><i class="fa fa-plus"></i> Agregar</button></div>
                    <div class="col-md-6"></div>
                </div>
                <div class="row">
                    <input type="hidden" value="no" id="productos_existe">
                    <div class="col-xs-12 table-responsive" id="productosasignados">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-2 col-xs-6">
                        <button type="button" class="btn btn-success btn-block " onclick="FinalizarEtapa()"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal viejo -->
        <!-- modal asignar no consumible -->
        <div id="pnl-2" class="modal-content hidden">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" onclick="switchPane()">&times;</button>
                <h4 class="modal-title">Asignar no Consumibles</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Escanear No Consumible</label>
                        <div class="input-group">
                            <input id="codigoNoCoEscaneado" class="form-control" placeholder="Busque Código..." autocomplete="off" onchange="consultarNoCo()">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" style="cursor:not-allowed">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table id="tbl-noco" class="table table-hover table-striped">
                            <thead>
                                <td>Código</td>
                                <td>Descripción</td>
                                <td></td>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <td colspan="3">Tabla vacía</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" onclick="resetNoco()">Cancelar</button>
                <button type="button" class='btn btn-success' onclick='asociarNocos()'>Hecho</button>
            </div>
        </div>
        <!-- fin modal asignar no consumible -->
    </div>
</div>
<?php
// carga el modal de impresion de QR
$this->load->view(COD . 'componentes/modalGenerico');
?>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#inputproducto').select2({
                matcher: matchCustom,
                templateResult: formatCustom,
                dropdownParent: $('#inputproducto').parent()
            }).on('change', function() {
                selectEvent(this);
            });
        }, 5000);
    });
    // Filtrar Recipientes por Establecimineto
    $('#productodestino').find('option').each(function() {
        var data = getJson(this);
        var esta = $('#establecimientos').val();
        if (data.esta_id != esta) $(this).remove();
    });
    $('.datalist').on('change', function() {
        this.dataset.json = $('#' + this.getAttribute('list')).find('[value="' + this.value + '"]').attr(
            'data-json');
    });
    //Captura la unidad de medida y la actualiza en el campo
    $('#modal_finalizar').find('#inputproducto').on('change', function() {
        let data = $(this).find(':selected').data('json');
        if (data && data.um) {
            $('#um').val(data.um);
        } else {
            $('#um').val(''); 
        }
    });
    function AgregarProducto() {
        ban = '';
        if (!_isset($("#inputproducto").val())) {
            ban = "Debe seleccionar un producto!";
        }
        var cantidad = $("#cantidadproducto").val();
        if (!_isset(cantidad)) {
            ban = "Debe completar la cantidad!";
        }
        var lotedestino = $("#lotedestino").val();
        if (!_isset(lotedestino)) {
            ban = "Debe completar lote de destino!";
        }
        destino = $("#productodestino").val();
        if (!_isset(destino)) {
            ban = "Debe seleccionar un destino!";
        }
        if (ban != '') {
            error("Error", ban);
        } else {
            establecimiento = "";
            var producto = {};
            // producto.establecimientofinal = "";
            // if (document.getElementById('productoestablecimientos').value != '' && document.getElementById(
            //         'productoestablecimientos').value != "-Seleccione Establecimiento-") {
            //     establecimientos = '<?php echo json_encode($establecimientos); ?>';
            //     establecimientos = JSON.parse(establecimientos);
            //     idestablecimiento = document.getElementById('productoestablecimientos').value;
            //     index = establecimientos.findIndex(x => x.esta_id == idestablecimiento);
            //     establecimiento = establecimientos[index].nombre;
            // producto.establecimientofinal = document.getElementById('productoestablecimientos').value;
            // }
            // recipientefinal = "";
            // producto.recipientefinal = "";
            // if (document.getElementById('productorecipientes').value != "") {
            //     recipientefinal = document.getElementById('productorecipientes').options[document.getElementById(
            //         'productorecipientes').selectedIndex].innerHTML;
            //     producto.recipientefinal = document.getElementById('productorecipientes').value;
            // }
            dataProducto = JSON.parse($("#inputproducto").attr('data-json'));
            recipientes = '<?php echo json_encode($recipientes); ?>';
            recipientes = JSON.parse(recipientes);
            idrecipiente = document.getElementById('productodestino').value;
            //indexrec = recipientes.findIndex(y => y.reci_id == idrecipiente);
            producto.id = dataProducto.arti_id;
            producto.titulo = $('#inputproducto').find('option:selected').text();
            producto.cantidad = cantidad;
            producto.loteorigen = document.getElementById('loteorigen').value;
            producto.lotedestino = lotedestino;
            producto.destino = destino;
            producto.titulodestino = $('#productodestino').find('option:selected').text();
            producto.descripcion = dataProducto.descripcion;
            // producto.destinofinal = establecimiento + " " + recipientefinal;
            // producto.destinofinal = establecimiento;

            var json = $('#operarios').find('[value="' + $('#operario').val() + '"]').attr('data-json');
            if (json) {
                producto.recu_id = JSON.parse(json).recu_id;
                producto.tipo_recurso = 'HUMANO';
            } else {
                producto.recu_id = 0;
                producto.tipo_recurso = '';
            }
            producto.unificar = $('#unificar').val();
            // fraccionado = document.getElementById('fraccionado').checked;
            // if (fraccionado) {
            //     producto.fraccionado = 'Si';
            // } else {
            //     producto.fraccionado = 'No';
            // }
            agregaProducto(producto);
            $("#inputproducto").val("");
            document.getElementById('cantidadproducto').value = "";
            document.getElementById('lotedestino').value = "";
            //document.getElementById('productodestino').value = "";
            $('#productodestino').val('').trigger('change');
            // document.getElementById('productoestablecimientos').value = "";
            $('#inputproducto').val("").trigger('change');
            // document.getElementById('fraccionado').checked = false;
            // document.getElementById('productorecipientes').value = "";
            // document.getElementById('productorecipientes').disabled = true;
        }
    }
    var contador = 0;

    function agregaProducto(producto) {
        // console.log('Agrega Producto');
        // console.log(producto);
        existe = document.getElementById('productos_existe').value;
        var html = '';
        contador++;
        if (existe == 'no') {
            html += '<table id="tabla_productos_asignados" class="table">';
            html += "<thead>";
            html += "<tr>";
            html += "<th>Acciones</th>";
            html += "<th>Lote</th>";
            html += "<th>Producto</th>";
            html += "<th>Cantidad</th>";
            html += "<th>Lote Destino</th>";
            html += "<th>Destino</th>";
            // html += "<th>Destino Final</th>";
            // html += "<th>Fracc</th>";
            html += '</tr></thead><tbody>';
            html += "<tr class='recipiente-" + producto.destino + "' data-json='" + JSON.stringify(producto) + "' id='" + contador + "' data-forzar='false'>";
            html +=
                '<td><i class="fa fa-fw fa-qrcode text-light-blue generarQR" style="cursor: pointer; margin-left: 15px;" title="QR" onclick="QR(this)"></i><i class="fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i><i class="fa fa-fw fa-cubes text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Asignar No consumible" onclick="switchPane();$(\'#LoteAsociarNoConsumible\').val(' + producto.destino + ')"></i></td>';
            html += '<td>' + producto.loteorigen + '</td>';
            html += '<td>' + producto.titulo + '</td>';
            html += '<td>' + producto.cantidad + '</td>';
            html += '<td>' + producto.lotedestino + '</td>';
            html += '<td>' + producto.titulodestino + '</td>';
            // html += '<td>' + producto.destinofinal + '</td>';
            // html += '<td>' + producto.fraccionado + '</td>';
            html += '</tr>';
            html += '</tbody></table>';
            document.getElementById('productosasignados').innerHTML = "";
            document.getElementById('productosasignados').innerHTML = html;
            $('#tabla_productos_asignados').DataTable({});
            document.getElementById('productos_existe').value = 'si';
        } else if (existe == 'si') {
            html += "<tr class='recipiente-" + producto.destino + "' data-json='" + JSON.stringify(producto) + "' id='" + contador + "' data-forzar='false'>";
            html +=
                '<td><i class="fa fa-fw fa-qrcode text-light-blue generarQR" style="cursor: pointer; margin-left: 15px;" title="QR" onclick="QR(this)"></i><i class="fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i><i class="fa fa-fw fa-cubes text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Asignar No consumible" onclick="switchPane();$(\'#LoteAsociarNoConsumible\').val(' + producto.destino + ')"></i></td>';
            html += '<td>' + producto.loteorigen + '</td>';
            html += '<td>' + producto.titulo + '</td>';
            html += '<td>' + producto.cantidad + '</td>';
            html += '<td>' + producto.lotedestino + '</td>';
            html += '<td>' + producto.titulodestino + '</td>';
            // html += '<td>' + producto.destinofinal + '</td>';
            // html += '<td>' + producto.fraccionado + '</td>';
            html += '</tr>';
            $('#tabla_productos_asignados tbody').append(html);
            tabla = document.getElementById('tabla_productos_asignados').innerHTML;
            tabla = '<table id="tabla_productos_asignados" class="table table-bordered table-hover">' + tabla + '</table>';
            $('#tabla_productos_asignados').dataTable().fnDestroy();
            document.getElementById('productosasignados').innerHTML = "";
            document.getElementById('productosasignados').innerHTML = tabla;
            $('#tabla_productos_asignados').DataTable({});
        }
    }

    function copiaOrigen() {
        document.getElementById('lotedestino').value = document.getElementById('loteorigen').value;
    }

    // $("#inputproducto").on('change', function() {
    //  document.getElementById('idproducto').value = $(this).val();   
    // });

    function validarCantidad() {
        var NUMERIC_REGEXP = /[-]{0,1}[\d]*[.]{0,1}[\d]+/g;
        var cantOrigen = parseFloat($('#cant_origen').val().match(NUMERIC_REGEXP));
        if ($('#cant_descontar').val() == null || $('#cant_descontar').val() == '') {
            alert('Cantidad a Extraer debe ser mayor a Cero');
            return false;
        }
        if (parseFloat($('#cant_descontar').val()) > cantOrigen) {
            alert('Cantidad a Extraer supera cantidad existente');
            return false;
        }
        return true;
    }

    var unificar_lote = false;
    // Genera Informe de Etapa
    var FinalizarEtapa = function() {
        if (!validarCantidad()) return;
        existe = document.getElementById('productos_existe').value;
        if (existe == "no") {
            notificar("Advertencia!", "No ha agregado ningun producto final", 'warning');
        } else {
            var productos = [];
            $('#tabla_productos_asignados > tbody > tr').each(function() {
                json = "";
                json = JSON.parse($(this).attr('data-json'));
                if (unificar_lote && unificar_lote == json.destino && this.dataset.forzar == 'false') {
                    this.dataset.forzar = "true";
                    unificar_lote = false;
                }
                json.forzar = this.dataset.forzar;
                productos.push(json);
            });
            // console.log(productos);
            productos = JSON.stringify(productos);
            cantidad_padre = $('#cant_descontar').val();
            num_orden_prod = $('#num_orden_prod').val();
            cantidad = $('#cant_origen').val();
            select = document.getElementById("productodestino");
            batch_id_padre = $('#batch_id_padre').val();
            destino = select.value;
            wo();
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                async: false,
                data: {
                    productos,
                    cantidad_padre,
                    num_orden_prod,
                    destino,
                    batch_id_padre
                },
                url: '<?php echo base_url(PRD) ?>general/Etapa/Finalizar',
                success: function(rsp) {
                    // console.log(rsp);
                    if (rsp.status) {
                        $('#modal_finalizar').modal('hide');
                        $('#mdl-unificacion').modal('hide');
                        if (rsp.data.estado.toUpperCase() == 'FINALIZADO') {
                            hecho('Hecho', 'Etapa finalizada exitosamente.');
                        } else {
                            hecho('Hecho', 'Se generó el Reporte de Producción correctamente.');
                        }
                        linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');
                    } else {
                        if (rsp.msj) {
                            unificar_lote = rsp.reci_id;
                            getContenidoRecipiente(unificar_lote);
                        } else {
                            alert('Fallo al finalizar la etapa');
                        }
                    }
                },
                complete: function() {
                    wc();
                }
            });
        }
    }
    $(document).off('click', '.tabla_productos_asignados_borrar').on('click', '.tabla_productos_asignados_borrar', {
        idtabla: 'tabla_productos_asignados',
        idrecipiente: 'productosasignados',
        idbandera: 'productos_existe'
    }, remover);

    obtenerDepositos($('#establecimientos').val());

    function obtenerDepositos(establecimiento, recipientes) {
        establecimiento = establecimiento;
        if (!establecimiento) return;
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: {
                establecimiento,
                tipo: 'DEPOSITO'
            },
            url: '<?php echo base_url(PRD) ?>general/Recipiente/listarPorEstablecimiento/true',
            success: function(result) {
                // console.log(result);
                if (!result.status) {
                    alert('Fallo al Traer Depositos');
                    return;
                }
                if (!result.data) {
                    alert('No hay Depositos Asociados');
                    return;
                }
                fillSelect('#productodestino', result.data);
            },
            error: function() {
                alert('Error al Traer Depositos');
            }
        });
    }
    //////////////////////////////////////////
    // Configuracion y creacion código QR
    // Características para generacion del QR
   async function QR(e) {
        //Limpio el modal
        $("#infoEtiqueta").empty();
        $("#contenedorCodigo").empty();
        $("#infoFooter").empty();

        // configuración de código QR
        var config = {};
        config.titulo = "Código QR";
        config.pixel = "7";
        config.level = "L";
        config.framSize = "2";

        //Obtengo los datos del lote
        datos = $(e).closest('tr').attr('data-json');
        var datosLote = JSON.parse(datos);
        datosLote.fecha = moment().format('YYYY-MM-DD');
        datosLote.batch = $('#batch_id_padre').val();

        //Cargo la vista del QR con datos en el modal
        $("#infoEtiqueta").load("<?php echo PRD ?>general/CodigoQR/cargaModalQRLote", datosLote);
        var dataQR = {};
        dataQR.lote = datosLote.loteorigen;
        dataQR.cod_producto = datosLote.titulo;
        dataQR.descripcion = datosLote.descripcion;
        dataQR.cantidad = datosLote.cantidad;
        dataQR.fecha = datosLote.fecha;
        dataQR.batch = datosLote.batch;

        await logoEmpresaReporteProduccion();

        // agrega codigo QR al modal impresion
        getQR(config, dataQR, 'codigosQR/Traz-prod-trazasoft/Lotes');

        // levanta modal completo para su impresion
        verModalImpresion();
    }

    //trae el logo de la empresa si esta cargado en core.tablas
    async function logoEmpresaReporteProduccion() {

        try {
        // Realizar la llamada AJAX de manera sincrónica usando fetch
        const response = await $.ajax({
            type: 'POST',
            data: {},
            url: '<?php echo base_url(PRD) ?>general/CodigoQR/getLogoEmpresa'
        });

        // Parsear los datos obtenidos en la respuesta
        const resp = JSON.parse(response);

        //si tiene logo lo pega sino elimina el selector 
        if(resp)
            document.getElementById('logo').src = resp;
        else 
            document.querySelector('.logo-container').remove();

      
        wc();

    } catch (error) {
        wc();
    }
    }


    function asociarNocos() {
        var dataNoconsum = [];
        var LoteAsociarNoConsumible2 = $("#LoteAsociarNoConsumible").val();
        aux = JSON.parse($(`.recipiente-${LoteAsociarNoConsumible2}`).attr('data-json'));
        $('#tbl-noco tbody  tr').each(function() {
            dataNoCo = getJson(this);
            var datos = {};
            datos.codigo = dataNoCo.codigo;
            datos.descripcion = dataNoCo.descripcion;
            dataNoconsum.push(datos);
        });
        // console.log(dataNoconsum);
        aux.NoConsumibles = {
            "NC": dataNoconsum
        };
        // console.log(aux);
        auxParseado = JSON.stringify(aux);
        // console.log(auxParseado);
        $(`.recipiente-${LoteAsociarNoConsumible2}`).attr('data-json', auxParseado);
        switchPane();
    }

    // Limpia tabla nocons y abre modal padre
    function resetNoco() {
        $('#tbl-noco tbody').empty();
        $('#tbl-noco tfoot').show();
        switchPane()
    }
    // Alterna entre modales	
    function switchPane(tag) {
        $('#tbl-reportes .ver-mas').toggle(); // oculta info extra	
        if ($('#pnl-1').hasClass('hidden')) {
            $('#pnl-1').removeClass('hidden');
            $('#pnl-2').addClass('hidden');
        } else {
            // var datito = document.getElementById('" + contador + "').value;	
            // var datito = ('.recipiente-"+producto.destino+"').val();	
            // dataNoCo = getJson(this);	
            // console.log(s_batchId);	
            // data.push(dataNoCo.codigo);	
            // infoFila += `<li>${dataNoCo.codigo} : ${dataNoCo.descripcion}</li>`;	
            $('#pnl-2').removeClass('hidden');
            $('#pnl-1').addClass('hidden');
        }
    }
    // consulta la información de No Consum por código	
    function consultarNoCo() {
        wo('Buscando Informacion');
        var codigo = $("#codigoNoCoEscaneado").val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                codigo: codigo
            },
            url: '<?php echo base_url(PRD) ?>general/Noconsumible/consultarInfo',
            success: function(result) {
                wc();
                if (!$.isEmptyObject(result)) {
                    if (result.estado != 'ALTA') {
                        agregarNocoEscaneado(result);
                    } else {
                        error('Error', 'El no consumible se encuentra inhabilitado!');
                    }
                } else {
                    alertify.error('El recipiente escaneado no se encuentra cargado...');
                }
            },
            error: function(result) {
                wc();
            },
            complete: function() {
                $('#codigoNoCoEscaneado').val('');
                wc();
            }
        });
    }
    // Agrega el NoCo escaneado a la tabla	
    function agregarNocoEscaneado(data) {
        $('#tbl-noco tfoot').hide();
        if ($('#tbl-noco tbody').find(`.${data.codigo}`).length > 0) {
            Swal.fire(
                'Alerta',
                ' El no consumible ya se encuentra en la lista',
                'warning'
            )
            return;
        }
        $('#tbl-noco tbody').append(`	
        <tr class='${data.codigo}' data-json='${JSON.stringify(data)}'>	
            <td>${data.codigo}</td>	
            <td>${data.descripcion}</td>	
            <td><button class="btn btn-link" onclick="$(this).closest('tr').remove()"><i class="fa fa-times text-danger"></i></button></td>	
        </tr>	
    `)
        $('#codigoNoCoEscaneado').val('');
    }
</script>