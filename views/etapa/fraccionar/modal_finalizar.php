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
                    <div class="panel-heading" data-toggle="collapse" href="#bodyInfoLotes" role="button" aria-expanded="false" aria-controls="bodyInfoLotes" title="Click para desplegar">
                        Información de Lotes
                    </div>
                    <div id="bodyInfoLotes" class="panel-body collapse">
                        <div class="row">
                            <div class="col-md-3">
                                <h3 style="font-weight: bold"> Información:</h3>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha:</label>
                                    <input type="date" id="fechaMdl" value="<?php echo $fecha; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Código Lote:</label>
                                    <input type="text" id="codigoLoteMdl" value="<?php echo $etapa->lote; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Orden de Producción:</label>
                                    <input type="text" id="ordenProduccionMdl" value="<?php echo $ordenProd; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h3 style="font-weight: bold">Ubicación:</h3>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Establecimiento:</label>
                                    <input type="text" id="establecimientoMdl" value="<?php echo $etapa->establecimiento; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Línea:</label>
                                    <input type="text" id="lineaMdl" value="<?php echo $etapa->recipiente; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" href="#bodyInfoTareas" role="button" aria-expanded="false" aria-controls="bodyInfoTareas" title="Click para desplegar">
                        Información de Tarea
                    </div>
                    <div id="bodyInfoTareas" class="panel-body collapse">
                        <?php foreach($matPrimas as $mat){ ?>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="control-label">Producto:</label>
                                    <input type="text" value="<?php echo $mat->descripcion; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Stock:</label>
                                    <input type="text" value="<?php echo $mat->stock; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Unidad de Medida:</label>
                                    <input type="text" value="<?php echo $mat->uni_med; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Empaque:</label>
                                    <input type="text" value="<?php echo $mat->nombre; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Capacidad:</label>
                                    <input type="text" value="<?php echo $mat->cant_emp; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Peso Tara:</label>
                                    <input type="text" value="<?php echo $mat->tara_emp; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Cantidad:</label>
                                    <input type="text" value="<?php echo $mat->cantidad; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Stock Necesario:</label>
                                    <input type="text" value="<?php echo $mat->cantidad * $mat->capacidad; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?php } ?>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" href="#bodyLotesFraccionar" role="button" aria-expanded="false" aria-controls="bodyLotesFraccionar" title="Click para desplegar">
                        Lotes para Fraccionamiento
                    </div>
                    <div id="bodyLotesFraccionar" class="panel-body collapse">
                        <table id="lotesFraccionar" class="table table-striped">
                            <tbody> 
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Productos Fraccionados</div>
                    <div class="panel-body">

                        <div class="row form-group" style="margin-top:20px">
                            <!--_____________ Producto _____________-->
                            <div class="col-md-3 col-xs-12">
                                <label for="Producto" class="form-label">Producto (<?php hreq() ?>):</label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 col-md-8 col-lg-8 ba">
                                    <select style="width: 100%" class="form-control select2-hidden-accesible habilitar requerido" name="arti_id" id="productos">
                                    <option value="" data-foo='' disabled selected>-Seleccione opción-</option>	
                                    <?php
                                        foreach ($articulos_fracc_salida as $articulo) {
                                        echo "<option value='$articulo->barcode' data-json='". json_encode($articulo) . "' data-foo='<small><cite>$articulo->descripcion</cite></small>  <label>♦ </label>   <small><cite>$articulo->stock</cite></small>  <label>♦ </label> <small><cite>$articulo->um</cite></small>' >$articulo->barcode</option>";
                                        }
                                    ?>
                                    </select>
                                    <?php 
                                    echo "<label id='detalle' class='select-detalle' class='text-blue'></label>";
                                    echo "<script>$('#productos').select2({matcher: matchCustom,templateResult: formatCustom, dropdownParent: $('#productos').parent()}).on('change', function() { selectEvent(this);})</script>";
                                    ?>
                                </div>
                            </div>
                            <!--__________________________-->
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad (<?php hreq() ?>):</label></div>
                            <div class="col-md-4 col-xs-12"><input class="form-control" id="cantidadproducto"
                                    type="text" value="" placeholder="Inserte Cantidad"></div>
                            <div class="col-md-5"></div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12">
                                <label class="form-label">Código Lote Destino (<?php hreq() ?>):</label>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <input class="form-control" type="text" id="lotedestino" value="" placeholder="Inserte Lote destino">
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row form-group" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12">
                                <label class="form-label">Destino (<?php hreq() ?>):</label>
                            </div>
                            <?php if ($accion == 'Editar') { ?>
                                <!--_____________ Destino _____________-->
                                <div class="form-group">
                                    <div class="col-sm-12 col-md-8 col-lg-8 ba">
                                        <select style="width: 100%" class="form-control select2-hidden-accesible habilitar requerido" name="vreci" id="productodestino">
                                        </select>
                                        <?php 
                                            echo "<label id='detalle' class='select-detalle' class='text-blue'></label>";
                                            echo "<script>$('#productodestino').select2({matcher: matchCustom,templateResult: formatCustom, dropdownParent: $('#productodestino').parent()}).on('change', function() { selectEvent(this);})</script>";
                                        ?>
                                    </div>
                                </div>
                                <!--__________________________-->
                            <?php } ?>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row form-group" style="margin-top: 20px">
                            <div class="col-md-3 col-xs-12">
                                <label for="establecimientos" class="form-label">Establecimiento Final:</label>
                            </div>
                            <div class="col-md-8 col-xs-12 col-sm-12">
                                <select style="width: 100%" class="form-control s2MdlFinalizar select2-hidden-accesible" id="productoestablecimientos">
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
                        <!-- <div class="row" style="margin-top: 20px">
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
                        </div> -->
                        <!-- <div class="row" style="margin-top:20px">
                            <div class="col-md-3 col-xs-12"><label class="form-label">Requiere Fraccionada:</label>
                            </div>
                            <div class="col-md-1 col-xs-12"><input type="checkbox" id="fraccionado" value=""></div>
                            <div class="col-md-8 "></div>
                        </div> -->
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
<?php
    // carga el modal de impresion de QR
    $this->load->view( COD.'componentes/modalGenerico');
?>

<script>
$(document).ready(function () {
    $(".s2MdlFinalizar").select2({
      tags: true,
      dropdownParent: $(".s2MdlFinalizar").parent()
    });
});
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
            tipo: 'DEPOSITO'
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
    if (cantidad <= 0) {
        error('Error','No puede ingresar una cantidad menor o igual a 0');
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
            // if (document.getElementById('productorecipientes').value != "") {
            //     recipientefinal = document.getElementById('productorecipientes').options[document.getElementById(
            //         'productorecipientes').selectedIndex].innerHTML;
            //     producto.recipientefinal = document.getElementById('productorecipientes').value;
            // }
            dataProducto = JSON.parse($("#productos").attr('data-json'));
            recipientes = '<?php echo json_encode($recipientes); ?>';
            recipientes = JSON.parse(recipientes);
            console.log("recipientes: ");
            console.table(recipientes);
            idrecipiente = document.getElementById('productodestino').value;
            //indexrec = recipientes.findIndex(y => y.id == idrecipiente);    
            indexrec = recipientes.findIndex(y => y.reci_id == idrecipiente);
            producto.arti_id = JSON.parse($("#productos option[value='" + $('#productos').val() + "']").attr('data-json')).arti_id;
            producto.titulo = document.getElementById('productos').value;
            producto.cantidad = cantidad;
            producto.lotedestino = lotedestino;
            producto.destino = destino;
            producto.titulodestino = $('#productodestino').find('option:selected').html();
            producto.descripcion = dataProducto.descripcion;
            // producto.destinofinal = establecimiento + " " + recipientefinal;
            producto.destinofinal = establecimiento;

            // fraccionado = document.getElementById('fraccionado').checked;
            // if (fraccionado) {
            //     producto.fraccionado = 'Si';
            // } else {
            //     producto.fraccionado = 'No';
            // }

            producto.forzar = "false";
            agregaProductoFinal(producto);
            document.getElementById('cantidadproducto').value = "";
            document.getElementById('lotedestino').value = "";
            // document.getElementById('productodestino').value = "";
            document.getElementById('productoestablecimientos').value = "";
            document.getElementById('productos').value = "";
            // document.getElementById('fraccionado').checked = false;
            // document.getElementById('productorecipientes').value = "";
            // document.getElementById('productorecipientes').disabled = true;
        }
    }
}

function agregaProductoFinal(producto) {
    existe = document.getElementById('productos_existe').value;
    var html = '';
    if (existe == 'no') {

        html += '<table id="tabla_productos_asignados" class="table">';
        html += "<thead>";
        html += "<tr>";
        html += "<th>Acciones</th>";
        // html += "<th>Lote</th>";
        html += "<th>Producto</th>";
        html += "<th>Cantidad</th>";
        html += "<th>Lote Destino</th>";
        html += "<th>Destino</th>";
        html += "<th>Destino Final</th>";
        // html += "<th>Fracc</th>";
        html += '</tr></thead><tbody>';
        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.arti_id + "' class='reci-"+producto.destino+"' data-forzar='false'>";
        html +=
            "<td><i class='fa fa-fw fa-qrcode text-light-blue generarQR' style='cursor: pointer; margin-left: 15px;' title='QR' onclick='QR(this)'></i><i class='fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar' style='cursor: pointer; margin-left: 15px;' title='Eliminar'></i></td>";
        // html += '<td>' + producto.loteorigen + '</td>';
        html += '<td>' + producto.titulo + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '<td>' + producto.lotedestino + '</td>';
        html += '<td>' + producto.titulodestino + '</td>';
        html += '<td>' + producto.destinofinal + '</td>';
        // html += '<td>' + producto.fraccionado + '</td>';
        html += '</tr>';
        html += '</tbody></table>';
        document.getElementById('productosasignadosfin').innerHTML = "";
        document.getElementById('productosasignadosfin').innerHTML = html;
        $('#tabla_productos_asignados').DataTable({});
        document.getElementById('productos_existe').value = 'si';

    } else if (existe == 'si') {
        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.arti_id + "' class='reci-"+producto.destino+"' data-forzar='false'>";
        html +=
            "<td><i class='fa fa-fw fa-qrcode text-light-blue generarQR' style='cursor: pointer; margin-left: 15px;' title='QR' onclick='QR(this)'></i><i class='fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar' style='cursor: pointer; margin-left: 15px;' title='Eliminar'></i></td>";
        // html += '<td>' + producto.loteorigen + '</td>';
        html += '<td>' + producto.titulo + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '<td>' + producto.lotedestino + '</td>';
        html += '<td>' + producto.titulodestino + '</td>';
        html += '<td>' + producto.destinofinal + '</td>';
        // html += '<td>' + producto.fraccionado + '</td>';
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
                if (_isset(result.msj)) {
                    bak_recipiente = result.reci_id;
                    getContenidoRecipiente(result.reci_id);
                } else {
                    $("#modal_finalizar").modal('hide');
                    $('#mdl-unificacion').modal('hide');
                    hecho();
                    linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');
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
//////////////////////////////////////////
// Configuracion y creacion código QR
// Características para generacion del QR
function QR(e){
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
    datosLote.batch = $("#batch_id").val();

	//Cargo la vista del QR con datos en el modal
	$("#infoEtiqueta").load("<?php echo PRD ?>general/CodigoQR/cargaModalQRLote", datosLote);
	var dataQR = {};
	dataQR.codigo = datosLote.codigo;

	// agrega codigo QR al modal impresion
	getQR(config, dataQR, 'codigosQR/Traz-prod-trazasoft/Lotes');

	// levanta modal completo para su impresion
	verModalImpresion();
}
////////////// FIN Creación QR

$(document).off('click', '.tabla_productos_asignados_borrar').on('click', '.tabla_productos_asignados_borrar', {
    idtabla: 'tabla_productos_asignados',
    idrecipiente: 'productosasignados',
    idbandera: 'productos_existe'
}, remover);
</script>