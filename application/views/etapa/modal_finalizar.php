<div class="modal" id="modal_finalizar" role="dialog" style="overflow-y: auto !important; "
    aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span>Reporte de Producción</h4>
            </div>
            <input class="hidden" type="text" id="num_orden_prod" value="<?php echo $etapa->orden;?>">
            <input class="hidden" type="text" id="batch_id_padre" value="<?php echo $etapa->id;?>">
            <div class="modal-body" id="modalBodyArticle">

                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Establecimiento:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text"
                            value="<?php echo $etapa->establecimiento ?>" disabled></div>
                    <div class="col-md-5"></div>
                </div>


                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Codigo Lote Origen:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="loteorigen"
                            value="<?php echo $etapa->lote;?>" disabled></div>
                    <div class="col-md-5"></div>
                </div>

                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Producto:</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" type="text" id="prod_origen"
                            value="<?php echo $producto[0]->descripcion;?>" disabled></div>
                    <div class="col-md-5"></div>
                </div>

                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="cant_origen"
                            value="<?php echo $producto[0]->stock.' ('.$producto[0]->uni_med.')';?>" disabled></div>
                    <div class="col-md-5"></div>
                </div>
                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad a Extraer:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="cant_descontar" value=""
                            placeholder="Inserte cantidad a Extraer"></div>
                    <div class="col-md-5"></div>
                </div>

                <input class="hidden" type="text" id="unificar">

                <!-- Recursos de Trabajo -->
                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Operario:</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control datalist" list="operarios"
                            id="operario"><datalist
                            id="operarios"><?php foreach($rec_trabajo as $o) {echo "<option value='$o->descripcion' data-json='".json_encode($o)."'></option>";} ?></datalist>
                    </div>
                    <div class="col-md-5"></div>
                </div>
                <!-- Fin | Recursos de Trabajo -->

                <div class="row form-group" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12">
                        <label for="inputproducto" class="form-label">Producto*:</label>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <?php  echo selectBusquedaAvanzada('inputproducto', false, $materias, 'id', 'titulo'); ?>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad*:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" id="cantidadproducto" type="text"
                            value="" placeholder="Inserte Cantidad"></div>
                    <div class="col-md-1 col-xs-1">
                            <input type="text" class="form-control" value=" - " id="um" disabled>
                   </div>
                    <div class="col-md-5"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Lote Destino*:</label></div>
                    <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="lotedestino" value=""
                            placeholder="Inserte Lote destino"></div>
                    <div class="col-md-4 col-xs-12"><button class="btn btn-primary btn-block"
                            onclick="copiaOrigen()">Copiar Lote Origen</button></div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Destino*:</label></div>
                    <div class="col-md-6 col-xs-12">
                        <?php if($accion == 'Editar'){
        

                      echo selectBusquedaAvanzada('productodestino', false, $recipientes, 'reci_id', 'nombre', array('Estado:'=>'estado','Lote:'=>'lote_id', 'barcode', 'descripcion'));

                        }
                        ?>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col-md-3 col-xs-12">
                        <label for="establecimientos" class="form-label">Establecimiento Final:</label>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <select class="form-control select2"
                            onchange="actualizaRecipiente(this.value, 'productorecipientes')"
                            id="productoestablecimientos">
                            <option disabled selected>-Seleccione Establecimiento-</option>
                            <?php
                    foreach($establecimientos as $fila)
                    {
                        echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
                    } 
                    ?>
                        </select>

                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col-md-3 col-xs-12">
                        <label for="establecimientos" class="form-label">Recipiente Final:</label>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="productorecipientes" disabled>
                            <option value="false" disabled selected>-Seleccione Establecimiento-</option>
                        </select>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"><label class="form-label">Requiere Fraccionada:</label></div>
                    <div class="col-md-1 col-xs-12"><input type="checkbox" id="fraccionado" value=""></div>
                    <div class="col-md-8"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-3 col-xs-12"></div>
                    <div class="col-md-3 col-xs-12"><button class="btn btn-success btn-block"
                            onclick="AgregarProducto()">Guardar</button></div>
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
                        <button type="button" class="btn btn-success btn-block "
                            onclick="FinalizarEtapa()">Aceptar</button>
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('.datalist').on('change', function() {
    this.dataset.json = $('#' + this.getAttribute('list')).find('[value="' + this.value + '"]').attr(
        'data-json');
});

$('#modal_finalizar').find('#inputproducto').on('change', function(){
    var data = getJson(this);
    $('#um').val(data.um);
});

function AgregarProducto() {
    ban = true;

    productoid = $("#inputproducto").val();
    if (productoid == "") {
        ban = false;
    }
    cantidad = document.getElementById('cantidadproducto').value;
    if (cantidad == "") {
        ban = false;
    }
    lotedestino = document.getElementById('lotedestino').value;
    if (lotedestino == "") {
        ban = false;
    }
    destino = document.getElementById('productodestino').value;
    if (destino == "") {
        ban = false;
    }
    if (!ban) {
        alert("falto algun dato obligatorio");
    } else {
        establecimiento = "";
        var producto = {};
        producto.establecimientofinal = "";
        if (document.getElementById('productoestablecimientos').value != '' && document.getElementById(
                'productoestablecimientos').value != "-Seleccione Establecimiento-") {
            establecimientos = '<?php echo json_encode($establecimientos);?>';
            establecimientos = JSON.parse(establecimientos);
            idestablecimiento = document.getElementById('productoestablecimientos').value;
            index = establecimientos.findIndex(x => x.esta_id == idestablecimiento);
            establecimiento = establecimientos[index].nombre;
            producto.establecimientofinal = document.getElementById('productoestablecimientos').value;
        }
        recipientefinal = "";
        producto.recipientefinal = "";
        if (document.getElementById('productorecipientes').value != "") {
            recipientefinal = document.getElementById('productorecipientes').options[document.getElementById(
                'productorecipientes').selectedIndex].innerHTML;
            producto.recipientefinal = document.getElementById('productorecipientes').value;
        }

        recipientes = '<?php echo json_encode($recipientes);?>';
        recipientes = JSON.parse(recipientes);
        idrecipiente = document.getElementById('productodestino').value;
        indexrec = recipientes.findIndex(y => y.reci_id == idrecipiente);
        producto.id = productoid;
        producto.titulo = $('#inputproducto').find('option:selected').text();
        producto.cantidad = cantidad;
        producto.loteorigen = document.getElementById('loteorigen').value;
        producto.lotedestino = lotedestino;
        producto.destino = destino;
        producto.titulodestino = $('#productodestino').find('option:selected').text();
        producto.destinofinal = establecimiento + " " + recipientefinal;
        producto.recu_id = JSON.parse($('#operarios').find('[value="' + $('#operario').val() + '"]').attr('data-json'))
            .recu_id;
        producto.tipo_recurso = 'HUMANO';
        producto.unificar = $('#unificar').val();
        fraccionado = document.getElementById('fraccionado').checked;
        if (fraccionado) {
            producto.fraccionado = 'Si';
        } else {
            producto.fraccionado = 'No';
        }
        agregaProducto(producto);
        $("#inputproducto").val("");
        document.getElementById('cantidadproducto').value = "";
        document.getElementById('lotedestino').value = "";
        //document.getElementById('productodestino').value = "";
        $('#productodestino').val('').trigger('change');
        document.getElementById('productoestablecimientos').value = "";
        $('#inputproducto').val("").trigger('change');
        document.getElementById('fraccionado').checked = false;
        document.getElementById('productorecipientes').value = "";
        document.getElementById('productorecipientes').disabled = true;
    }
}

function agregaProducto(producto) {

    console.log('Agrega Producto');
    console.log(producto);


    existe = document.getElementById('productos_existe').value;
    var html = '';
    if (existe == 'no') {

        html += '<table id="tabla_productos_asignados" style="width: 90%;" class="table">';
        html += "<thead>";
        html += "<tr>";
        html += "<th>Acciones</th>";
        html += "<th>Lote</th>";
        html += "<th>Producto</th>";
        html += "<th>Cantidad</th>";
        html += "<th>Lote Destino</th>";
        html += "<th>Destino</th>";
        html += "<th>Destino Final</th>";
        html += "<th>Fracc</th>";
        html += '</tr></thead><tbody>';
        html += "<tr class='res-" + producto.destino + " " + producto.id + producto.lotedestino + "' data-json='" + JSON
            .stringify(producto) + "' id='" + producto.id + "'>";
        html +=
            '<td><i class="fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
        html += '<td>' + producto.loteorigen + '</td>';
        html += '<td>' + producto.titulo + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '<td>' + producto.lotedestino + '</td>';
        html += '<td>' + producto.titulodestino + '</td>';
        html += '<td>' + producto.destinofinal + '</td>';
        html += '<td>' + producto.fraccionado + '</td>';
        html += '</tr>';
        html += '</tbody></table>';
        document.getElementById('productosasignados').innerHTML = "";
        document.getElementById('productosasignados').innerHTML = html;
        $('#tabla_productos_asignados').DataTable({});
        document.getElementById('productos_existe').value = 'si';

    } else if (existe == 'si') {
        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.id + "'>";
        html +=
            '<td><i class="fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
        html += '<td>' + producto.loteorigen + '</td>';
        html += '<td>' + producto.titulo + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '<td>' + producto.lotedestino + '</td>';
        html += '<td>' + producto.titulodestino + '</td>';
        html += '<td>' + producto.destinofinal + '</td>';
        html += '<td>' + producto.fraccionado + '</td>';
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

// Genera Informe de Etapa
function FinalizarEtapa() {

    if (!validarCantidad()) return;

    existe = document.getElementById('productos_existe').value;
    if (existe == "no") {
        alert("No ha agregado ningun producto final");
    } else {
        var productos = [];
        $('#tabla_productos_asignados tbody').find('tr').each(function() {
            json = "";
            json = JSON.parse($(this).attr('data-json'));
            productos.push(json);
        });

        productos = JSON.stringify(productos);
        lote_id = $('#loteorigen').val();
        cantidad_padre = $('#cant_descontar').val();
        num_orden_prod = $('#num_orden_prod').val();
        cantidad = $('#cant_origen').val();
        select = document.getElementById("productodestino");
        batch_id_padre = $('#batch_id_padre').val();
        destino = select.value;


        $.ajax({
            type: 'POST',
            async: false,
            data: {
                lote_id,
                productos,
                cantidad_padre,
                num_orden_prod,
                destino,
                batch_id_padre
            },
            url: 'general/Etapa/Finalizar',
            success: function(result) {
                document.getElementById('btnfinalizar').style.display = "none";
                $("#modal_finalizar").modal('hide');

                if (result == "ok") {
                    linkTo('general/Etapa/index');
                } else {
                    alert("Hubo un error en Dataservice");
                    linkTo('general/Etapa/index');
                }
            }
        });
    }
}
$(document).off('click', '.tabla_productos_asignados_borrar').on('click', '.tabla_productos_asignados_borrar', {
    idtabla: 'tabla_productos_asignados',
    idrecipiente: 'productosasignados',
    idbandera: 'productos_existe'
}, remover);

$('#productodestino').on('change', function() {
    if(this.value == '' || this.value == null) return;
    var json = getJson(this);
    if (!json) return;
    if (!validarRecipiente(json)) this.value = "";
});

function validarRecipiente(json) {
    console.log('function validarRecipiente...');

    console.log(json);


    var arti_id = $('#inputproducto').val();
    var lote_id = $('#lotedestino').val();

    if (json.estado == 'VACIO') {

        if ($('#tabla_productos_asignados').length != 0) {

            // Validar si el recipiente ha sido elegido en la tabla Anteriormente
            var recipientes =  $('#tabla_productos_asignados').find('.res-' + json.reci_id);
          
            if(recipientes.length == 0){ $('#unificar').val(false); return true;}
            var ban = true;
            recipientes.each(function() {

                ban = ban && $(this).hasClass(arti_id + lote_id);

            });

            if (ban) {
                // Pregunta si quiere Unificar los Lotes
                if (confirm('-¿Desea mezclar los Artículos en el Recipiente?') != true) {
                    // Respuesta Negativa
                    $('#recipiente').val('').trigger('change');
                    $('#unificar').val(false);
                    return false;
                }
                $('#unificar').val(true);
                return true;

            } else {
                alert('-No se pueden mezclar Distintos Articulos y Distintos Lotes en un mismo Recipiente');
                $('#recipiente').val('').trigger('change');
                //$('#lotedestino').val('').trigger('change');
                $('#unificar').val(false);
                return false;
            }

        } else {
            $('#unificar').val(false);
            return true;
        }

    }
    // Si el recipiente es NO VACIO valido Si tiene el mismo Lote y Articulo

    if (json.arti_id != arti_id || json.lote_id != lote_id) {
        alert('No se pueden mezclar Distintos Articulos y Distintos Lotes en un mismo Recipiente');
        $('#recipiente').val('').trigger('change');
        //$('#lotedestino').val('').trigger('change');
        $('#unificar').val(false);
        return false;
    }



    // Pregunta si quiere Unificar los Lotes
    if (confirm('¿Desea mezclar los Artículos en el Recipiente?') != true) {
        // Respuesta Negativa
        $('#recipiente').val('').trigger('change');
        $('#unificar').val(false);
        return false;
    }

    //Respuesta Positiva
    $('#unificar').val(true);
    return true;
}
</script>