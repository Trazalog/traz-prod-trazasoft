<?php $this->load->view('camion/modal_lotes')?>
<?php $this->load->view('etapa/fraccionar/modal_productos')?>
<?php $this->load->view('etapa/modal_unificacion_lote'); ?>
<?php if($etapa->estado == "En Curso"){
    $this->load->view('etapa/fraccionar/modal_finalizar');
    echo "<script>$('.formulario .form-control').attr('disabled', true)</script>";
}
if($etapa->estado == "FINALIZADO"){
    echo "<script>$('.formulario .form-control').attr('disabled', true)</script>";
}
?>

<style>
.panel-disabled{
    background-color: rgb(0,0,0,0.3) !important;
    z-index:99999999 !important;
}
</style>
<div class="formulario">
    <input class="hidden" type="text" id="batch_id" value="<?php echo $etapa->id ?>">
    <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title"><?php echo $etapa->titulo; ?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Información</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label class="form-label">Fecha<?php hreq() ?>:</label>
                                    <input type="<?php if($accion != 'Editar'){echo 'date';} ?>" id="fecha"
                                        value="<?php echo $fecha;?>" class="form-control"
                                        <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
                                </div>
                                <div class="col-xs-6">
                                    <label for="Lote" class="form-label">Código Lote:*</label>
                                    <input type="text" id="lote_id" class="form-control" 
                                    <?php if($accion=='Editar' ){echo ( 'value="'.$etapa->lote.'"');}?>
                                        placeholder="Inserte código de lote"
                                        <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="op" class="form-label">Orden de Producción:</label>
                                        <input type="text" id="ordenproduccion" class="form-control"
                                            <?php if($accion=='Editar' ){echo ( 'value="'.$ordenProd.'"');}?>
                                            placeholder="Inserte orden de producción"
                                            <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Ubicación</div>
                            <div class="panel-disabled"></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label for="establecimientos" class="form-label">Establecimiento<?php hreq() ?>:</label>
                                    <select class="form-control select2 select2-hidden-accesible"
                                        onchange="actualizaRecipiente(this.value,'recipientes')" id="establecimientos"
                                        <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
                                        <option value="" disabled selected>-Seleccione Establecimiento-</option>
                                        <?php
                                                foreach($establecimientos as $fila)
                                                {
                                            
                                                    if($accion == 'Editar' && $fila->nombre == $etapa->establecimiento)
                                                    {
                                                    echo '<option value="'.$fila->esta_id.'" selected >'.$fila->nombre.'</option>';
                                                    }else
                                                    {
                                                    echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
                                                    }
                                                        }
                                                ?>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label for="Recipiente"
                                        class="form-label">Linea*:</label>
                                    <?php
                                            echo selectBusquedaAvanzada('recipientes', 'vreci');
                                            ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($accion == 'Editar'){?>
        <div class="box-body">
              <enma></enma>
        </div>

        <div class="box-body">
            <input type="hidden" id="materiasexiste" value="no">
            <table id="prodFracc" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Titulo</th>
                        <th>Cant a Descontar</th>
                        <th>Empaque</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php											
                          foreach($matPrimas as $fila)
                          {
                              echo '<tr  id="" data-json:>';
                              echo '<td>' .$fila->descripcion. '</td>';
                              echo '<td>' .$fila->cantidad.' ('.$fila->uni_med.')'.'</td>';
                              echo '<td>' .$fila->nombre. '</td>';
                              echo '<td>' .$fila->cant_emp. '</td>';         
                              echo '</tr>'; 																
                          }		
                      ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
        <!-- Producto fraccionado -->
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Detalle Fraccionamiento</div>
                <div class="panel-body">
                    <?php  if($etapa->estado != 'En Curso'){?>
                    <div class="row">
                        <div class="col-xs-6 ba">
                            <div class="form-group">
                                <label class="form-label">Producto:</label>
                                <?php 
                        echo selectBusquedaAvanzada('inputproductos', 'arti_id', $articulos_fraccionar, 'arti_id', 'barcode',array('descripcion','Stock:' => 'stock'));
                    ?>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="form-label">Stock:</label>
                                <input type="number" disabled id="stock" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="form-label">Unidad de Medida:</label>
                                <input type="text" disabled id="uni_medida" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="form-label">Empaque:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="empaques"
                                    onchange="ActualizaEmpaques()">
                                    <option value="" disabled selected>- Seleccionar -</option>
                                    <?php
                            foreach($empaques as $fila)
                            { 
                            if($accion == 'Editar' && $etapa->empaque->titulo == $fila->titulo)
                            {
                                echo "<option data-json='".json_encode($fila)."' selected value='".$fila->id."'>".$fila->titulo."</option>";
                            }
                                else{
                                echo "<option data-json='".json_encode($fila)."' value='".$fila->id."'>".$fila->titulo."</option>";
                                }
                            } 
                        ?>
                                </select>
                            </div>
                        </div> 
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="form-label">Capacidad:</label>
                                <input type="number" id="volumen" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="form-label">Peso Tara:</label>
                                <input type="number" id="tara" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="form-label">Cantidad:</label>
                                <input type="number" id="cantidad" disabled onchange="CalculaStock()"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="form-label">Stock Necesario:</label>
                                <input type="number" id="calculo" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <button style="margin-top:23px;" class="btn btn-success" onclick="ControlaProducto()"><i class="fa fa-plus"></i> Agregar</button>
                        </div>
                        <?php  }?>
                        <div class="col-xs-12">
                            <input type="hidden" value="no" id="productoexiste">
                            <div class="col-xs-12 table-responsive" id="productosasignados"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><?php } ?>
        <!-- /.box-body -->
        <div class="modal-footer">
            <?php if($etapa->estado != 'En Curso' && $etapa_estado != 'FINALIZADO')
              {
           
                echo '<button class="btn btn-primary" onclick="guardar()">Iniciar</button>';
              }
       
              if($etapa->estado == 'En Curso')
              {
                  echo '<button class="btn btn-primary" id="btnfinalizar" onclick="finalizar()">Reporte Fraccionamiento</button>';
                  $this->load->view('etapa/btn_finalizar_etapa');
              }
             ?>
            <button class="btn btn-default" onclikc="back()">Cerrar</button>
            <!-- /.box-footer-->
        </div>
    </div>
</div>


<script>
actualizarEntrega()
function actualizarEntrega() {
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url:'<?php echo base_url(PRD) ?>general/Etapa/validarPedidoMaterial/'+ $('#batch_id').val(),
        success: function(res) {
            if(res.tarea){
                $('enma').load('<?php echo BPM . 'Proceso/detalleTarea/' ?>' + res.tarea);
            }
            else $('enma').empty();
        },
        error: function(res) {
            error();wbox();
        }
    });
}


$('#recipientes').attr('disabled', true);
$('#prodFracc').DataTable({});

actualizaRecipiente($('#establecimientos').val());

function actualizaRecipiente(establecimiento, recipientes) {
    if (!establecimiento) return;
    $('#recipientes').attr('disabled', true);
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
            $('#recipientes').val('<?php echo  $etapa->reci_id ?>');
            $('#recipientes').attr('disabled', false);
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

// elige producto y muestra el stock en
$("#inputproductos").on('change', function() {


    //// stock
    document.getElementById('stock').value = getJson(this).stock;
//// uni_medida
    document.getElementById('uni_medida').value = getJson(this).um;

});

function ActualizaEmpaques() {

    empaque = $("#empaques option:selected").attr('data-json');
    empaque = JSON.parse(empaque);
    //document.getElementById('unidad').value = ;
    document.getElementById('volumen').value = empaque.volumen ;
    document.getElementById('tara').value = empaque.tara ;
    document.getElementById('cantidad').disabled = false;
    CalculaStock();
}

function CalculaStock() {
    stock = document.getElementById('volumen').value * document.getElementById('cantidad').value;
    document.getElementById('calculo').value = stock;
}

function checkTabla(idtabla, idrecipiente, json, acciones) {
    lenguaje = <?php echo json_encode($lang) ?> ;
    if (document.getElementById(idtabla) == null) {
        armaTabla(idtabla, idrecipiente, json, lenguaje, acciones);
    }
}

function ControlaProducto() {
    msj = "";
    ban = true;
    if (document.getElementById('inputproductos').value == "") {
        ban = false;
        msj += "No ha seleccionado Producto \n"
    }
    if (document.getElementById('empaques').value == "") {
        ban = false;
        msj += "No ha seleccionado Empaque \n"
    }
    if (document.getElementById('cantidad').value == "") {
        ban = false;
        msj += "No ha Ingresado Cantidad \n"
    }
    if (!ban) {
        alert(msj);
    } else {

        producto = getJson($('#inputproductos'));
        empaque = $("#empaques option:selected").attr('data-json');
        empaque = JSON.parse(empaque);
        producto.empaque = empaque.id;
        producto.empaquetitulo = empaque.titulo;
        producto.envase_arti_id = empaque.arti_id;
        producto.cantidad = document.getElementById('cantidad').value;
        producto.cant_descontar = document.getElementById('calculo').value;
        producto = JSON.stringify(producto);
        AgregaProducto(producto);
        document.getElementById('inputproductos').value = "";
        document.getElementById('empaques').value = "";
        document.getElementById('cantidad').value = "";
        document.getElementById('uni_medida').value = "";
        document.getElementById('volumen').value = "";
        document.getElementById('stock').value = "";
        document.getElementById('cantidad').disabled = true;
    }
}

function AgregaProducto(producto) {
    estado = '<?php echo $etapa->estado ?>';
    existe = document.getElementById('productoexiste').value;
    var html = '';
    producto = JSON.parse(producto);
    if (existe == 'no') {
        html += '<table id="tablaproductos" class="table">';
        html += "<thead>";
        html += "<tr>";
        if (estado != 'En Curso') {
            html += "<th>Acciones</th>";
        }
        if (estado == 'En Curso') {
            html += "<th>Lote</th>";
        }
        html += "<th>Título</th>";
        html += "<th>Cant a Descontar</th>";
        html += "<th>Empaque</th>";
        html += "<th>Cantidad</th>";
        html += '</tr></thead><tbody>';
        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.arti_id + "'>";
        if (estado != 'En Curso') {
            html +=
                '<td><i class="fa fa-fw fa-minus text-light-blue tablaproductos_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
        }
        if (estado == 'En Curso') {
            html += "<td>" + producto.lote + "</td>";
        }
        html += '<td>' + producto.barcode + '</td>';
        html += '<td>' + producto.cant_descontar + '</td>';
        html += '<td>' + producto.empaquetitulo + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '</tr>';
        html += '</tbody></table>';

        document.getElementById('productosasignados').innerHTML = "";
        document.getElementById('productosasignados').innerHTML = html;
        $('#tablaproductos').DataTable({});
        document.getElementById('productoexiste').value = 'si';


    } else if (existe == 'si') {

        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.arti_id + "'>";
        if (estado != 'En Curso') {
            html +=
                '<td><i class="fa fa-fw fa-minus text-light-blue tablaproductos_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
        }
        if (estado == 'En Curso') {
            html += "<td>" + producto.lote + "</td>";
        }
        html += '<td>' + producto.barcode + '</td>';
        html += '<td>' + producto.cant_descontar + '</td>';
        html += '<td>' + producto.empaquetitulo + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '</tr>';
        $('#tablaproductos tbody').append(html);
        tabla = document.getElementById('tablaproductos').innerHTML;
        tabla = '<table id="tablaproductos" class="table table-bordered table-hover">' + tabla + '</table>';
        $('#tablaproductos').dataTable().fnDestroy();
        document.getElementById('productosasignados').innerHTML = "";
        document.getElementById('productosasignados').innerHTML = tabla;
        $('#tablaproductos').DataTable({});
    }
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

    if (ban) {
        guardar();
    } else {
        document.getElementById('mensajeincompleto').innerHTML = "";
        document.getElementById('mensajeincompleto').innerHTML = mensaje;
        document.getElementById('incompleto').hidden = false;
    }


}

function guardar() {
    //CHUKA
    fecha = document.getElementById('fecha').value;
    establecimiento = document.getElementById('establecimientos').value;
    recipiente = document.getElementById('recipientes').value;
    idetapa = <?php echo $etapa->id ?> ;
    existe = document.getElementById('productoexiste').value;
    ordProduccion = document.getElementById('ordenproduccion').value;
    lote_id = document.getElementById('lote_id').value;
    var productos = [];
    var acum_cant = 0;
    if (existe == "si") {
        $('#tablaproductos tbody').find('tr').each(function() {
            json = "";
            json = $(this).attr('data-json');
            temp = JSON.parse(json);
            acum_cant += parseFloat(temp.cant_descontar);
            productos.push(json);
        });
        alert("cant total a descontar: " + acum_cant);
        // productos = JSON.stringify(productos);
    }

    var data = {
        idetapa: idetapa,
        fecha: fecha,
        establecimiento: establecimiento,
        recipiente: recipiente,
        productos: productos,
        cant_total_desc: acum_cant,
        ordProduccion: ordProduccion,
        lote_id : lote_id,
        forzar: 'false'
    };

    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data,
        url: '<?php echo base_url(PRD) ?>general/Etapa/guardarFraccionar',
        success: function(rsp) {
            if (rsp.status) {
                Swal.fire(
        'Hecho',
        'Salida Guardada exitosamente.',
        'success'
      );
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
        error: function() {
            alert('Error al iniciar etapa fraccionamiento');
        },
        complete: function() {
            wc();
        }
    });
}

function guardarForzado(data) {
    wo();
    data.forzar = 'true';
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data,
        url: '<?php echo base_url(PRD) ?>general/Etapa/guardarFraccionar',
        success: function(rsp) {
            $('#mdl-unificacion').modal('hide');
            if (rsp.status) {
                Swal.fire(
        'Hecho',
        'Salida Guardada exitosamente.',
        'success'
      );
               linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');
            } else {
                alert('Fallo al iniciar la etapa fraccionamiento');
            }
        },
        error: function() {
            alert('Error al guardar fraccionamiento');
        },
        complete: function() {
            wc();
        }
    });
}

// finalizar solo llena select y levanta modal 
function finalizar() {
    getLotesFraccionar();
    $("#modal_finalizar").modal('show');
}
$(document).off('click', '.tablaproductos_borrar').on('click', '.tablaproductos_borrar', {
    idtabla: 'tablaproductos',
    idrecipiente: 'productosasignados',
    idbandera: 'productoexiste'
}, remover);

//Obtiene los lotes a fraccionar cuando se llama a la funcion finalizar que abre el modal del reporte de fraccionamiento
function getLotesFraccionar(){
    wo();
    $("#lotesFraccionar").find("tbody td").remove();
    data = {};
    data.batch_id = $("#batch_id").val();

    $.ajax({
        type: "POST",
        url: "<?php echo PRD ?>general/Etapa/getLotesFraccionar",
        data: data,
        dataType: "JSON",
        success: function (resp) {
            if(resp.status){
                $.each(resp.data, function (i, val) {
                    button = (val.tipo == 'Insumo') ? bolita('Insumo', 'orange') : `<button title='Copiar Lote' class='btn btn-link' onclick='$(\"#lotedestino\").val(\"${val.codigo}\")'><i class='fa fa-copy'></i></button>`;  
                    
                    var opcion = `<tr>
                    <td>LOTE: ${val.codigo} | ${val.art_nombre}</td>
                    <td>Cantidad: ${val.cant_entreg}</td>
                    <td>${button}</td>
                    </tr>`;

                    $("#lotesFraccionar").find("tbody").append(opcion);
                });
            }else{
                console.log("No hay lotes a fraccionar");
            }
            wc();
        },
        error: function (resp){
            wc();
        }
    });
}
</script>   