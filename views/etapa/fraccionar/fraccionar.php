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
                <div class="col-xs-6 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Información</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="form-label">Fecha<?php hreq() ?>:</label>
                                        <input type="<?php if($accion != 'Editar'){echo 'date';} ?>" id="fecha"
                                            value="<?php echo $fecha;?>" class="form-control"
                                            <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="Lote" class="form-label">Código Lote<?php hreq() ?>:</label>
                                        <input type="text" id="lote_id" class="form-control" 
                                        <?php if($accion=='Editar' ){echo ( 'value="'.$etapa->lote.'"');}?>
                                            placeholder="Inserte código de lote"
                                            <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
                                    </div>
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
                <div class="col-xs-6 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Ubicación</div>
                            <div class="panel-disabled"></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="establecimientos" class="form-label">Establecimiento<?php hreq() ?>:</label>
                                        <select class="form-control sel select2-hidden-accesible"
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
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="Recipiente"
                                            class="form-label">Línea<?php hreq() ?>:</label>
                                        <?php
                                            echo selectBusquedaAvanzada('recipientes', 'vreci');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tipo:</label>
                                        <input type="text" class="form-control" id="tipoRecipiente" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Estado:</label>
                                        <input type="text" class="form-control" id="estadoRecipiente" disabled>
                                    </div>
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
        <h3> Pedido materiales</h3>
        <div class="box-body">
            <input type="hidden" id="materiasexiste" value="no">
            <table id="detaPedido" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <th>Origen</th>
                    <th>Código</th>
                    <th>Articulo</th>
                    <th>Stock Actual</th>
                    <th>Cantidad receta</th>
                    <th>Cantidad artículo</th>
                </thead>
                <tbody>
                    <?php											
                          foreach($detaEmpaque as $fila)
                          {
                            echo"<tr data-json=' " .json_encode($fila). " ' id='".$fila->arti_id."'>";
                            ($fila->receta) ? $tipo =  $fila->receta : $tipo = "Unitario";
                            echo"<td>$tipo</td>";
                            echo"<td>$fila->barcode</td>";
                            echo"<td>$fila->descripcion</td>";
                            echo"<td>$fila->stock</td>";
                            echo"<td>$fila->cantidad_receta</td>";
                            echo"<td>$fila->cantidad</td>";
                            echo"</tr>";																
                          }		
                      ?>
                </tbody>
            </table>
        </div>
        <hr>
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
                                <label class="form-label">Producto<?php hreq() ?>:</label>
                                <?php 
                                    echo selectBusquedaAvanzada('inputproductos', 'arti_id', $articulos_fraccionar, 'arti_id', 'barcode',array('descripcion','Stock Físico:' => 'stock','Stock Disponible:' => 'stock_disponible'));
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
                    </div>
                    <div class="row">
                        <div class="col-xs-6 ba">
                            <div class="form-group">
                                <label class="form-label">Empaque<?php hreq() ?>:</label>
                                <?php
                                    echo selectBusquedaAvanzada('empaques', 'empaques', $empaques, 'id', 'titulo',array('Receta:' => 'receta','Uso:' => 'aplicacion_receta','Cantidad:' => 'cantidad'),false,"crearTablaReceta(this),false");
                                ?>
                            </div>
                        </div> 
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="form-label">Cantidad<?php hreq() ?>:</label>
                                <input type="number" id="cantidad" disabled onchange="CalculaStock()"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="form-label">Capacidad:</label>
                                <input type="number" id="volumen" class="form-control" disabled>
                                <input type="hidden" id="cantidadReceta">
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="form-label">Peso Tara:</label>
                                <input type="number" id="tara" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="form-label">Stock Necesario:</label>
                                <input type="number" id="calculo" class="form-control" disabled>
                            </div>
                        </div>
		            </div>
                    <hr>
                    <!-- TABLA DE ARTICULOS DE UNA RECETA -->
                    <div class="row">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
		                    			<div class="col-sm-10">
		                    				<table id="tabla-Formula" class="table table-bordered table-hover dataTable" role="grid"  hidden>
		                    					<thead>
		                    						<tr role="row">
		                    							<th>
		                    								<font style="vertical-align: inherit;">
		                    									<font style="vertical-align: inherit;">Artículo</font>
		                    								</font>
		                    							</th>
		                    							<th>
		                    								<font style="vertical-align: inherit;">
		                    									<font style="vertical-align: inherit;">U.M.</font>
		                    								</font>
		                    							</th>
		                    							<th>
		                    								<font style="vertical-align: inherit;">
		                    									<font style="vertical-align: inherit;">Cantidad</font>
		                    								</font>
		                    							</th>
		                    						</tr>
		                    					</thead>
		                    					<tbody>  
		                    					</tbody>
		                    				</table>
		                    			</div>
                    </div>
		                    		
                        <div class="col-xs-12 col-md-12">
                            <hr>
                            <button style="" class="btn btn-success pull-right" onclick="ControlaProducto()" ><i class="fa fa-plus"></i> Agregar</button>
                        </div>
                    </div>
                        <?php  }?>
                        <div class="col-xs-12">
                            <h2>Productos</h2>
                            <input type="hidden" value="no" id="productoexiste">
                            <div class="col-xs-12 table-responsive" id="productosasignados"></div>
                        </div>
                    <!-- </div> -->
                </div>
            </div>
        </div><?php } ?>
        <!-- /.box-body -->
        <div class="modal-footer">
            <button class="btn btn-danger pull-right" onclick="linkTo('<?php echo base_url(PRD).'general/Etapa' ?>')">Cerrar</button>
            <?php if($etapa->estado != 'En Curso' && $etapa_estado != 'FINALIZADO'){           
                echo '<button class="btn btn-primary" onclick="validaCamposFraccionamiento()">Iniciar</button>';
              }       
              if($etapa->estado == 'En Curso'){
                echo '<button class="btn btn-primary" id="btnfinalizar" onclick="finalizar()">Reporte Fraccionamiento</button>';
                $this->load->view('etapa/btn_finalizar_etapa');
              }
             ?>            
            <!-- /.box-footer-->
        </div>
    </div>
</div>
<?php
    //Modal apra vel el datalle del producto cargado en la tabla
    $this->load->view('etapa/fraccionar/modal_verDetalleFraccionamiento');
?>


<!-- Modal Editar cantidad de articulo -->
<div class="modal modal-fade" id="mdl-editar">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar cantidad artículo</h4>
            </div>
            <form id="formEditarCant" action="#">
            <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cantidad(<strong style="color: #dd4b39">*</strong>):</label>
                        <input id="cantArticulo" class="form-control" type="text" name="cantidad" required>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="aceptarCantidad">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- FIN MODAL Editar -->

<script>
$(document).ready(function () {
    $('#recipientes').attr('disabled', true);
    $('#detaEmpaque').DataTable({});
    $('#detaPedido').DataTable({});
    $(".sel").select2();
    actualizaRecipiente($('#establecimientos').val());
    actualizarEntrega();
});

function crearTablaReceta(tag){

    empaque = $("#empaques option:selected").attr('data-json');
    if(_isset(empaque)){
        empaque = JSON.parse(empaque);
        document.getElementById('volumen').value = empaque.volumen ;
        document.getElementById('tara').value = empaque.tara ;
        document.getElementById('cantidadReceta').value = empaque.cantidad;
        document.getElementById('cantidad').disabled = false;
        CalculaStock();
    }
    var data = getJson(tag);
    //console.log('data: ' + data);
    //console.table(data);
    var form_id =  data.form_id;
    if(_isset($("#empaques").val()))
    {
        $.ajax({
            type: "GET",
            url: '<?php echo base_url(PRD) ?>general/Etapa/getArticulosEnRecetas/' + form_id,
            success: function (res) {
                wo();
                if(res != 'null'){
                    //console.log(res);
                    document.getElementById('tabla-Formula').hidden = false;
                    $('#tabla-Formula').css('background','#d2d6de');
                    articulos = JSON.parse(res);
                    id_form = form_id;
                    var html='';
                    $('#tabla-Formula > tbody').empty();//limpia los registros del body
	    	        $.each(articulos, function(i, item) {
                     html += '<tr>' +
	    		            '<td>' + articulos[i].descripcion + '</td>' +
	    		            '<td hidden>' + articulos[i].arti_id + '</td>' +
	    		            '<td>' + articulos[i].unidad_medida + '</td>' +
	    		            '<td>' + articulos[i].cantidad + '</td>' +
	    		            '</tr>';
	    		    });
                    $('#tabla-Formula tbody').append(html);
                
                }else{
                    //console.log("No hay articulos");
                    document.getElementById('tabla-Formula').hidden = true;
                }
                wc();
            },
            error: function(res) {
                alert('Error');
            },
        }); 
    }
}
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

///////////////////////////////////////////////////////////
//Obtiene los recipientes asociados a un establecimiento
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
                error('Error','Se produjo un error al obtener los recipientes');
                return;
            }

            if (!result.data) {
                notificar('Nota','No hay recipientes asociados a este establecimiento.', 'warning');
                return;
            }

            $('#recipientes').attr('disabled', false);
            fillSelect('#recipientes', result.data);
            reci_id = "<?php echo isset($etapa->reci_id) ? $etapa->reci_id : null ?>";
            if(_isset(reci_id)) $("#recipientes").val(reci_id).trigger('change');
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
/////////////////////////////////////////////////////////////////////
// Cuando se selecciona un producto, se muestra el stock y su unidad de medida
$("#inputproductos").on('change', function() {
    datos = JSON.parse($(this).attr('data-json'));
    if(_isset(datos.stock_disponible) && datos.stock_disponible < 0){
        notificar('Alerta','El artículo se encuentra en stock: '+ datos.stock_disponible,'warning');
    }
    //// stock
    document.getElementById('stock').value = getJson(this).stock;
    //// uni_medida
    document.getElementById('uni_medida').value = getJson(this).um;
});
/////////////////////////////////////////////////////////////////////
// Cuando se selecciona un recipiente, se muestra el tipo y estado
$("#recipientes").on('change', function() {
    //// Tipo
    document.getElementById('tipoRecipiente').value = getJson(this).tipo;
    //// Estado
    document.getElementById('estadoRecipiente').value = getJson(this).estado;
});
///////////////////////////////////////////////////////////////////////////
// Toma los datos del empaque y los muestra en la pantalla
function ActualizaEmpaques() {
    empaque = $("#empaques option:selected").attr('data-json');
    if(_isset(empaque)){
        empaque = JSON.parse(empaque);
        document.getElementById('volumen').value = empaque.volumen ;
        document.getElementById('tara').value = empaque.tara ;
        document.getElementById('cantidadReceta').value = empaque.cantidad;
        document.getElementById('cantidad').disabled = false;
        CalculaStock();
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
// Calcula el stock necesario multiplicando la cantidad de la receta por la cantidad ingresado pro el usuario
function CalculaStock() {
    stock = document.getElementById('cantidadReceta').value * document.getElementById('cantidad').value;
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
    if (document.getElementById('inputproductos').value == "0") {
        ban = false;
        msj += "No ha seleccionado <b>producto</b>.<br>"
    }
    if (document.getElementById('empaques').value == "") {
        ban = false;
        msj += "No ha seleccionado <b>empaque</b>.<br>"
    }
    if (document.getElementById('cantidad').value == "") {
        ban = false;
        msj += "No ha ingresado <b>cantidad</b>.<br>"
    }
    if (!ban) {
        error('Error',msj);
    } else {

        producto = getJson($('#inputproductos'));
        empaque = $("#empaques option:selected").attr('data-json');
        empaque = JSON.parse(empaque);
        cantidad =  document.getElementById('cantidad').value;

        //productos-articulos de una receta
        articulo = articulos;
        var prod=[];
          $.each(articulo, function(i, item) {
            articulo[i].empaque = empaque.id;
            articulo[i].cantidad_receta = cantidad;
            articulo[i].cantidad *= cantidad;
            articulo[i].tipo = empaque.receta;
            prod= JSON.stringify(articulo[i]);
            AgregaProducto(prod); 
	    });
        
        //producto unitario
        producto.empaquetitulo = empaque.titulo;
        producto.volumen = empaque.volumen;
        producto.envase_arti_id = empaque.arti_id;
        producto.cantidad =cantidad;
        producto.cantidad_receta=cantidad;
        producto.cant_descontar = document.getElementById('calculo').value;
        producto.tipo = "Unitario";
        producto = JSON.stringify(producto);
        AgregaProducto(producto);

        document.getElementById('tabla-Formula').hidden = true;
        $('#inputproductos').val(null).trigger('change');
        $('.ba #detalle').empty();
        $('#empaques').val(null).trigger('change');
        $('#empaques').attr('data-json', '');
        document.getElementById('cantidad').value = "";
        document.getElementById('uni_medida').value = "";
        document.getElementById('volumen').value = "";
        document.getElementById('stock').value = "";
        document.getElementById('tara').value = "";
        document.getElementById('calculo').value = "";
        document.getElementById('cantidad').disabled = true;
    }
}

function AgregaProducto(producto) {
    estado = '<?php echo $etapa->estado ?>';
    existe = document.getElementById('productoexiste').value;
    var html = '';
    producto = JSON.parse(producto);
    if (existe == 'no') {
        html += '<table id="tablaproductos" class="table table-responsive">';
        html += "<thead>";
        html += "<tr>";
        if (estado != 'En Curso') {
            html += "<th>Acciones</th>";
        }
        if (estado == 'En Curso') {
            html += "<th>Lote</th>";
        }
        html += "<th>Tipo de Pedido</th>";
        html += "<th>Código</th>";
        html += "<th>Descripcion</th>";
        html += "<th>Stock</th>";
        html += "<th>Cantidad Receta</th>";
        html += "<th>Cantidad Articulo</th>";
        html += '</tr></thead><tbody>';
        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.arti_id + "'>";
        if (estado != 'En Curso') {
            html += '<td><i class="fa fa-fw fa-edit text-light-blue tablaproductos_editar" style="cursor: pointer; margin-left: 10px;" title="Editar" onclick="editarProducto(this)"></i>';
            html += '<i class="fa fa-fw fa-trash text-light-blue tablaproductos_borrar" style="cursor: pointer; margin-left: 10px;" title="Eliminar"></i></td>';
        }
        if (estado == 'En Curso') {
            html += "<td>" + producto.lote + "</td>";
        }
        html += '<td>' + producto.tipo + '</td>'; 
        html += '<td>' + producto.barcode + '</td>';
        html += '<td>' + producto.descripcion + '</td>'; 
        html += '<td>' + producto.stock + '</td>';
        html += '<td>' + producto.cantidad_receta + '</td>';
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
            html += '<td><i class="fa fa-fw fa-edit text-light-blue tablaproductos_editar" style="cursor: pointer; margin-left: 10px;" title="Editar" onclick="editarProducto(this)"></i>';
            html += '<i class="fa fa-fw fa-trash text-light-blue tablaproductos_borrar" style="cursor: pointer; margin-left: 10px;" title="Eliminar"></i></td>';
        }
        if (estado == 'En Curso') {
            html += "<td>" + producto.lote + "</td>";
        }
        html += '<td>' + producto.tipo + '</td>';
        html += '<td>' + producto.barcode + '</td>';
        html += '<td>' + producto.descripcion + '</td>'; 
        html += '<td>' + producto.stock + '</td>';
        html += '<td>' + producto.cantidad_receta + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '</tr>';
        $('#tablaproductos').DataTable().row.add($(html)).draw();
    }
    editando = false;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// valida campos obligatorios Codigo Lote, Fecha, Establecimiento, Línea(recipiente) y materia prima carga en la tabla
function validaCamposFraccionamiento() {
    mensaje = "No se pudo completar la operación debido a que: <br>";
    ban = true;
    if (document.getElementById('lote_id').value == "") {
        mensaje += "- No ha ingresado <b>lote</b>. <br>";
        ban = false;
    }
    if (document.getElementById('fecha').value == "") {
        mensaje += "- No ha ingresado <b>fecha</b>. <br>";
        ban = false;
    }
    if (document.getElementById('establecimientos').value == "") {
        mensaje += "- No ha seleccionado <b>establecimiento</b>. <br>";
        ban = false;
    }
    if (document.getElementById('recipientes').value == "") {
        mensaje += "- No ha seleccionado <b>recipiente</b>. <br>";
        ban = false;
    }
    if ($('#materiasexiste').val() == "no") {
        mensaje += "- No ha cargado ninguna <b>materia prima</b> en la tabla. <br>";
        ban = false;
    }

    if (ban) {
        guardar();
    } else {
        error('Error!',mensaje);
    }
}

function guardar() {
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
            productos.push(json);
        });
    }
        var data = {
            idetapa: idetapa,
            fecha: fecha,
            establecimiento: establecimiento,
            recipiente: recipiente,
            productos: productos,
            cant_total_desc: 0,
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
                    fun = () =>{linkTo('<?php echo base_url(PRD) ?>general/Etapa/index')};
                    confRefresh(fun);
                } else {
                    if (rsp.msj) {
                        bak_data = data;
                        getContenidoRecipiente(recipiente);
                    } else {
                        error('Error','Fallo al iniciar la etapa de fraccionamiento');
                    }
                }
            },
            error: function() {
                error('Error','Se produjo un error al iniciar etapa fraccionamiento');
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
                fun = () =>{linkTo('<?php echo base_url(PRD) ?>general/Etapa/index')};
                confRefresh(fun);
            } else {
                error('Error','Fallo al iniciar la etapa de fraccionamiento');
            }
        },
        error: function() {
            error('Error','Se produjo un error al iniciar etapa fraccionamiento');
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
///////////////////////////////////////////////////////////
//Edita el detalle de un producto
function editarProducto(tag){
    var ban = true;
    var datos='';
    $('#mdl-editar').modal('show');
        datos = JSON.parse($(tag).closest('tr').attr('data-json'));
        $("#aceptarCantidad").off().on('click',function(){
            cantnuevo = document.getElementById('cantArticulo').value;
            if((cantnuevo != '') && (cantnuevo > 0) && (ban))
            {
                $('#tablaproductos').DataTable().row( $(tag).parents('tr') ).remove().draw();
                datos.cantidad = cantnuevo;
                datos = JSON.stringify(datos);
                AgregaProducto(datos);
                $('#mdl-editar').modal('hide');
                ban=false;  
            }
        });
    $('#cantArticulo').val('');
    $('#mdl-editar').bootstrapValidator('resetForm', true);
    cantnuevo ='';
}
//////////////////////////////////////////////////////////
// Permite ver todos los datos del producto cargado
function verDetalleProducto(tag){
    data = JSON.parse($(tag).closest('tr').attr('data-json'));
    $("#modalVerTitulo").val(data.barcode);
    $("#modalVerCantADescontar").val(data.cant_descontar);
    $("#modalVerEmpaque").val(data.empaquetitulo);
    $("#modalVerCantidad").val(data.cantidad);
    $("#modalVerReceta").val(data.receta);
    $("#modalVerCapacidad").val(data.volumen);
    $("#modalVerArticulo").val(data.descripcion);
    $("#modalVerUM").val(data.um);
    $("#modalVerStock").val(data.stock);
    $("#modalVerStockDisponible").val(data.stock_disponible);
    $("#mdl-verDetalleProducto").modal('show');
}
</script>   