<?php $this->load->view('etapa/fraccionar/modal_generarQR') ?>
<div class="modal" id="modal_finalizar" data-backdrop="static" tabindex="-1" role="dialog"
    style="overflow-y: auto !important; " aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Reporte de Fraccionamiento
                </h4>
                <input class="hidden" type="text" id="num_orden_prod" value="<?php echo $etapa->orden; ?>">
            </div>

            <div class="modal-body" id="modalBodyArticle">

                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Lotes para Fraccionamiento</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tbody> 
                                <?php 
                                foreach ($lotesFracc as $lote) {
                                    echo "<tr>";
                                    echo "<td>LOTE: $lote->codigo | $lote->art_nombre</td>";
                                    echo "<td>".($lote->tipo == 'Insumo'?bolita('Insumo','orange'):"<button title='Copiar Lote' class='btn btn-link' onclick='$(\"#lotedestino\").val(\"$lote->codigo\")'><i class='fa fa-copy'></i></button></td>");
                                    echo "</tr>";
                                }?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Productos Fraccionados</div>
                    <div class="panel-body">

                        <div class="row form-group" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12">
                                <label for="Producto" class="form-label">Producto:</label>
                            </div>
                            <div class="col-md-8 col-xs-12 input-group">

                                <?php 
                                    echo selectBusquedaAvanzada('productos', 'arti_id', $articulos_fraccionar, 'arti_id', 'barcode',array('descripcion','Stock:' => 'stock'));
                                ?>
                                <span class="input-group-btn">
                                    <button class='btn btn-sm btn-primary'
                                        onclick='checkTabla("tabla_productos","modalproductos",`<?php echo json_encode($materias); ?>`,"Add")'
                                        data-toggle="modal" data-target="#modal_productos">
                                        <i class="glyphicon glyphicon-search"></i></button>
                                </span>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad:</label></div>
                            <div class="col-md-4 col-xs-12"><input class="form-control" id="cantidadproducto"
                                    type="text" value="" placeholder="Inserte Cantidad"></div>
                            <div class="col-md-5"></div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12"><label class="form-label">Codigo Lote Destino:</label></div>
                            <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="lotedestino"
                                    value="" placeholder="Inserte Lote destino"></div>
                           
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12"><label class="form-label">Destino:</label></div>
                            <div class="col-md-6 col-xs-12">
                                <?php if ($accion == 'Editar') {
       
                                echo selectBusquedaAvanzada('productodestino', 'vreci');
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
                                <select class="form-control select2 select2-hidden-accesible"
                                    onchange="actualizaRecipiente(this.value, 'productorecipientes')"
                                    id="productoestablecimientos">
                                    <option value="" disabled selected>-Seleccione Establecimiento-</option>
                                    <?php
                                    foreach ($establecimientos as $fila) {
                                        echo '<option value="' . $fila->esta_id . '" >' . $fila->nombre . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="col-md-3 col-xs-12"></div>
                        </div>
                        <div class="row" style="margin-top: 20px">
                            <div class="col-md-3 col-xs-12">
                                <label for="establecimientos" class="form-label">Recipiente Final:</label>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <select class="form-control select2 select2-hidden-accesible" id="productorecipientes"
                                    disabled>
                                    <option value="" disabled selected>-Seleccione Establecimiento-</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-xs-12"></div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12"><label class="form-label">Requiere Fraccionada:</label>
                            </div>
                            <div class="col-md-1 col-xs-12"><input type="checkbox" id="fraccionado" value=""></div>
                            <div class="col-md-8 "></div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12"></div>
                            <div class="col-md-3 col-xs-12"><button class="btn btn-success btn-block"
                                    onclick="AgregarProductoFinal()">Agregar</button></div>
                            <div class="col-md-6 "></div>
                        </div>
                        <div class="row">


                            <input type="hidden" value="no" id="productos_existe">
                            <div class="col-xs-12 table-responsive" id="productosasignadosfin">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnfinalizar"
                            onclick="FinalizarEtapa()">Finalizar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


<script>
actualizaRecipiente(<?php echo $etapa->esta_id ?>);
function actualizaRecipiente(establecimiento) {
    $('#productodestino').empty();
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
                alert('No hay Recipientes Asociados');
                return;
            }
            fillSelect('#productodestino', result.data);


        },
        error: function() {
            alert('Error al Traer Recipientes');
        },
        complete: function() {
            wc();
        }
    });

}


function AgregarProductoFinal() {
    cantidad = document.getElementById('cantidadproducto').value;
    if (cantidad == 0) {
        producto = {};
        producto.id = '-';
        producto.titulo = '-';
        producto.cantidad = '-';
        producto.lotedestino = '-';
        producto.destino = '-';
        producto.titulodestino = '-';
        producto.destinofinal = '-';
        producto.fraccionado = '-';
        agregaProductoFinal(producto);
        document.getElementById('cantidadproducto').value = "";
        document.getElementById('lotedestino').value = "";
        document.getElementById('productodestino').value = "";
        document.getElementById('productoestablecimientos').value = "";
        document.getElementById('inputproductos').value = "";
        document.getElementById('fraccionado').checked = false;
        document.getElementById('productorecipientes').value = "";
        document.getElementById('productorecipientes').disabled = true;
  
    } else {
        ban = true;
        msj = "";

        producto = document.getElementById('productos').value;

        // validacion de campos vacios    
        if (producto == "") {
            msj += "Falto ingresar Producto de salida \n";
            ban = false;
        }
        cantidad = document.getElementById('cantidadproducto').value;
        if (cantidad == "") {
            msj += "Falto ingresar Cantidad del Producto de salida \n";
            ban = false;
        }
        lotedestino = document.getElementById('lotedestino').value;
        if (lotedestino == "") {
            msj += "Falto ingresar lote destino \n";
            ban = false;
        }
        destino = document.getElementById('productodestino').value;
        if (destino == "") {
            msj += "Falto ingresar el destino del producto \n";
            ban = false;
        }

        if (!ban) {
            alert(msj);
        } else {

            establecimiento = "";
            var producto = {};
            producto.establecimientofinal = "";
            if (document.getElementById('productoestablecimientos').value != "") {
                establecimientos = '<?php echo json_encode($establecimientos); ?>';
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

            recipientes = '<?php echo json_encode($recipientes); ?>';
            recipientes = JSON.parse(recipientes);
            console.log("recipientes: ");
            console.table(recipientes);
            idrecipiente = document.getElementById('productodestino').value;
            //indexrec = recipientes.findIndex(y => y.id == idrecipiente);    
            indexrec = recipientes.findIndex(y => y.reci_id == idrecipiente);
            producto.id = JSON.parse($("#productos option[value='" + $('#productos').val() + "']").attr('data-json'))
            .id;
            producto.titulo = document.getElementById('productos').value;
            producto.cantidad = cantidad;
            producto.lotedestino = lotedestino;
            producto.destino = destino;
            producto.titulodestino = $('#productodestino').find('option:selected').html();  
            producto.destinofinal = establecimiento + " " + recipientefinal;
            fraccionado = document.getElementById('fraccionado').checked;
            if (fraccionado) {
                producto.fraccionado = 'Si';
            } else {
                producto.fraccionado = 'No';
            }

            producto.forzar = "false";
            agregaProductoFinal(producto);
            document.getElementById('cantidadproducto').value = "";
            document.getElementById('lotedestino').value = "";
            document.getElementById('productodestino').value = "";
            document.getElementById('productoestablecimientos').value = "";
            document.getElementById('productos').value = "";
            document.getElementById('fraccionado').checked = false;
            document.getElementById('productorecipientes').value = "";
            document.getElementById('productorecipientes').disabled = true;
        }
    }
}

function agregaProductoFinal(producto) {
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
        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.id + "' class='reci-"+producto.destino+"' data-forzar='false'>";
        html +=
            "<td><i id='generarQR' class='fa fa-fw fa-qrcode text-light-blue generarQR' style='cursor: pointer; margin-left: 15px;' title='QR' onclick='QR(this)'></i><i class='fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar' style='cursor: pointer; margin-left: 15px;' title='Eliminar'></i></td>";
        html += '<td>' + producto.loteorigen + '</td>';
        html += '<td>' + producto.titulo + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '<td>' + producto.lotedestino + '</td>';
        html += '<td>' + producto.titulodestino + '</td>';
        html += '<td>' + producto.destinofinal + '</td>';
        html += '<td>' + producto.fraccionado + '</td>';
        html += '</tr>';
        html += '</tbody></table>';
        document.getElementById('productosasignadosfin').innerHTML = "";
        document.getElementById('productosasignadosfin').innerHTML = html;
        $('#tabla_productos_asignados').DataTable({});
        document.getElementById('productos_existe').value = 'si';

    } else if (existe == 'si') {
        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.id + "' class='reci-"+producto.destino+"' data-forzar='false'>";
        html +=
            "<td><i id='generarQR' class='fa fa-fw fa-qrcode text-light-blue generarQR' style='cursor: pointer; margin-left: 15px;' title='QR' onclick='QR(this)'></i><i class='fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar' style='cursor: pointer; margin-left: 15px;' title='Eliminar'></i></td>";
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
        document.getElementById('productosasignadosfin').innerHTML = "";
        document.getElementById('productosasignadosfin').innerHTML = tabla;
        $('#tabla_productos_asignados').DataTable({});

    }
}

function copiaOrigen() {
    document.getElementById('lotedestino').value = document.getElementById('loteorigen').value;
}
// finaliza reporte de fraccionamiento
function FinalizarEtapa() {
    if(bak_recipiente) $('.reci-'+bak_recipiente).attr('data-forzar',true);

    existe = document.getElementById('productos_existe').value;
    if (existe == "no") {
        alert("No ha agregado ningun producto final");
    } else {
        // ops = document.getElementById('loteorigen').options;
        // var lotes = [];
        // for (i = 0; i < ops.length; i++) {
        //     lotes.push(ops[i].value);
        // }
        // lotes.shift();
        // lotesasignados = [];
        // for (i = 0; i < lotes.length; i++) {
        //     if ($('#tabla_productos_asignados tr > td:nth-child(2):contains(' + lotes[i] + ')').length > 0) {
        //         lotesasignados.push(lotes[i]);
        //     }
        // }
        // diferencia = lotes.filter(x => !lotesasignados.includes(x));
 
        var productos = [];
        $('#tabla_productos_asignados tbody').find('tr').each(function() {
            var json = $(this).attr('data-json');
            temp = JSON.parse(json);
            temp.forzar = $(this).attr('data-forzar');
            productos.push(temp);
        });
        batch_id = <?php echo $etapa->id; ?> ;
        num_orden_prod = $('#num_orden_prod').val();

          var data = {
            productos,
            batch_id: batch_id,
            num_orden_prod: num_orden_prod
          }
        
        wo();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data,
            url: '<?php echo base_url(PRD) ?>general/Etapa/finalizaFraccionar',
            success: function(result) {
                
                if (result.msj) {
                    bak_recipiente = result.reci_id;
                    getContenidoRecipiente(result.reci_id);
                } else {
                if (result.status) {
                    $("#modal_finalizar").modal('hide');
                    $('#mdl-unificacion').modal('hide');
                    hecho();
                   linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');
                } else {
                    alert("Hubo un error en el fraccionamiento")
                }
                }

            },
            error: function() {
                alert('Error al finalizar etapa');
            },
            complete: function() {
                wc();
            }
        });
    }
}

function QR(elemento) {
    var data = $(elemento).closest("tr").attr("data-json");
    generarQR(data);
};

function generarQR(data) {
    data = JSON.parse(data);

    wo();
    $.ajax({
        type: 'POST',
        async: false,
        data: {
            data
        },
        url: '<?php echo base_url(PRD) ?>general/CodigoQR/generarQRFraccionamiento',
        success: function(rsp) {
            rsp = JSON.parse(rsp);

            $('#imagenQR').attr('src', rsp.filename);
            $('#contenidoQR').html('<h3>Datos lote</h3>' +
                '<p>Lote origen: ' + rsp.loteorigen +
                '<br>Producto: ' + rsp.titulo +
                '<br>Cantidad: ' + rsp.cantidad +
                '<br>Lote destino: ' + rsp.lotedestino +
                '<br>Destino: ' + rsp.titulodestino +
                '<br>Destino final: ' + rsp.destinofinal +
                '<br>Fraccionado: ' + rsp.fraccionado +
                '<br><button type="button" class="btn btn-default btn-flat btn-dropbox" onclick="imprimirElemento();" id="idPrint"><i class="fa fa-print"></i></button></p>'
                );

            $("#modal_generarQR").modal('show');
        },
        error: function(rsp) {
            alert('Error');
        },
        complete: function() {
            wc();
        }
    });
};

function imprimirElemento() {
    var elemento2 = $("#idQR").html();
    $('#idPrint').remove();
    var elemento = $("#idQR").html();
    $("#idQR").empty();

    var ventana = window.open('', 'PRINT', 'height=600,width=800');
    ventana.document.write('<html><head><title>Código QR</title>');
    ventana.document.write('<link rel="stylesheet" href="<?php base_url(); ?>application/css/codigoQR.css">');
    ventana.document.write('</head><body >');
    ventana.document.write(elemento);
    ventana.document.write('</body></html>');
    ventana.document.close();
    ventana.focus();
    ventana.print();
    // ventana.close();
    $("#idQR").html(elemento2);
    return true;
}

$(document).off('click', '.tabla_productos_asignados_borrar').on('click', '.tabla_productos_asignados_borrar', {
    idtabla: 'tabla_productos_asignados',
    idrecipiente: 'productosasignados',
    idbandera: 'productos_existe'
}, remover);
</script>