<?php $this->load->view('etapa/modal_detalleTarea'); ?>
<div class="nav-tabs-custom ">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Pedido Unitario</a></li>
        <li class="privado"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Con Receta</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <!-- PEDIDO UNITARIO -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Nuevo pedido <?php echo $etapa->realizo_entrega_materiales == 'false' ? '<i class="fa fa-edit"></i>' : ''; ?></h4>
                </div>
                <?php if (($etapa->estado == 'En Curso' && $etapa->realizo_entrega_materiales == 'false') || $etapa->estado != 'FINALIZADO') { ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row form-group">
                                <div class="col-md-3 col-xs-6">
                                    <label for="template" class="form-label">Artículos <?php echo hreq() ?>:</label>
                                </div>
                                <div id="materiaPrimaNuevoPedido" class="col-md-6 col-xs-12 input-group ba">
                                    <?php
                                        echo selectBusquedaAvanzada('inputmaterias', 'vmateria', $productos_entrada_etapa, 'arti_id', 'barcode', array('descripcion', 'Unidad Medida:' => 'um'));
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="row form-group">
                                <div class="col-md-3 col-xs-6">
                                    <label for="" class="form-label">Stock Actual:</label>
                                </div>
                                <div class="col-md-6 col-xs-12 input-group">
                                    <input type="number" class="form-control" disabled id="stockdisabled" name="vstock">
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="row form-group">
                                <div class="col-md-3 col-xs-6">
                                    <label for="template" class="form-label">Cantidad <?php echo hreq() ?>:</label>
                                </div>
                                <div class="col-md-6 col-xs-12 input-group">
                                    <input type="number" class="form-control" placeholder="Inserte Cantidad" id="cantidadmateria" disabled name="vcantidadmateria">
                                    <span class="input-group-btn">
                                        <button class='btn btn-success' id="botonmateria" disabled
                                            onclick="aceptarMateria()">Aceptar
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <input type="hidden" id="materiasexiste" value="no">
                        <div class="col-xs-12 table-responsive" id="materiasasignadas">
                        </div>
                    </div>
                </div>
                <?php } ?>               
            </div>
            <!-- ./ PEDIDO UNITARIO -->
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <!-- CON RECETA -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Nuevo pedido <?php echo $etapa->realizo_entrega_materiales == 'false' ? '<i class="fa fa-edit"></i>' : ''; ?></h4>
                </div>
                <?php if (($etapa->estado == 'En Curso' && $etapa->realizo_entrega_materiales == 'false') || $etapa->estado != 'FINALIZADO') { ?>
                    <div class="box-body">
                        <div class="row">

                        <div class="col-xs-12">
                                <div class="row form-group">
                                    <div class="col-md-3 col-xs-6">
                                        <label for="template" class="form-label">Receta <?php echo hreq() ?>:</label>
                                    </div>
                                    <div id="RecetasLote" class="col-md-6 col-xs-12 input-group ba">
                                        <?php
                                            echo selectBusquedaAvanzada('formulas', 'vunme', $formulas, 'form_id', 'descripcion', array('Unidad Medida:' => 'unidad_medida', 'Cantidad:' => 'cantidad'),false ,"crearTablaReceta(this)");
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="row form-group">
                                    <div class="col-md-3 col-xs-6">
                                        <label for="" class="form-label">Descripción:</label>
                                    </div>
                                    <div class="col-md-6 col-xs-12 input-group">
                                        <input type="text" class="form-control" disabled id="descridisabled" name="descripcion">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="row form-group">
                                    <div class="col-md-3 col-xs-6">
                                        <label for="" class="form-label">Unidad de medida:</label>
                                    </div>
                                    <div class="col-md-6 col-xs-12 input-group">
                                        <input type="text" class="form-control" disabled id="unmedisabled" name="unme">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="row form-group">
                                    <div class="col-md-3 col-xs-6">
                                        <label for="" class="form-label">Cantidad:</label>
                                    </div>
                                    <div class="col-md-6 col-xs-12 input-group">
                                        <input type="text" class="form-control" id="cantidadreceta" name="cantidadreceta">
                                        <span class="input-group-btn">
                                            <button class='btn btn-success' id="botonreceta" disabled
                                                onclick="aceptarReceta()">Aceptar
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>                            
                            
                        </div>

                        <div class="row">
                            <input type="hidden" id="materiasexiste" value="no">
                            <div class="col-xs-12 table-responsive" id="materiasasignadas">
                            </div>
                        </div>
                    </div>
                <?php } ?>               
            </div>
            <!-- ./ CON RECETA -->
             <!-- TABLA DE ARTICULOS DE UNA RECETA -->
            <div class="dataTables_wrapper form-inline dt-bootstrap">
					
					<div class="row">
						<div class="col-sm-8">
							<table id="tabla-Formula" class="table table-bordered table-hover dataTable" role="grid"  style="display:none">
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
                        <div class="col-md-2 col-xs-12 input-group"></div>
                        <div class="col-md-2 col-xs-12 input-group">
                            <span class="input-group-btn">
                                <button class='btn btn-success' id="botonAgregareceta" style="display:none" disabled>Agregar
                                </button>
                                </span>
                        </div>
					</div>
			</div>
             <!-- ./FIN TABLA DE ARTICULOS DE UNA RECETA -->
        </div>
    </div>
    <div class="tab-content">
        <!-- ORIGEN EDICION ETAPA -->
        <?php if ($accion == 'Editar' && $etapa->estado == 'FINALIZADO') { ?>
        <div class="box-body">
            <div class="row">
                <input type="hidden" id="materiasexiste" value="no">
                <div class="col-xs-12 table-responsive" id="materiasasignadas">
                    <table id="etapas" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($matPrimas as $fila) {
                                    echo "<tr>";
                                    echo "<td>$fila->descripcion</td>";
                                    echo "<td>$fila->cantidad($fila->uni_med)</td>";
                                    echo "</tr>";
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
                <!-- ORIGEN EDICION ETAPA -->
            </div>
        </div>
        <?php }else{
            echo'<table id="tablamateriasasignadas" class="table">';
            echo"<thead>";
            
            if($etapa->estado != 'En Curso'){
                echo"<th>Acciones</th>";
            }
            echo"<th>Origen</th>";
            echo"<th>Código</th>";
            echo"<th>Articulo</th>";
            echo"<th>Stock Actual</th>";
            echo"<th>Cantidad receta</th>";
            echo"<th>Cantidad artículo</th>";
            echo"</thead>";
            echo"<tbody>";

            //reccorrido por los productos dentro de una receta
            foreach ($matPrimas as $fila) {
                echo"<tr data-json=' " .json_encode($fila). " ' id='".$fila->arti_id."'>";
                if($etapa->estado != 'En Curso'){
                    echo '<td>';
                    echo '<i class="fa fa-trash text-light-blue" style="cursor: pointer; margin-left: 15px;" onclick="eliminarOrigen(this)" title="Eliminar"></i>';
                    echo '<i class="fa fa-edit text-light-blue" style="cursor: pointer; margin-left: 15px;" onclick="editarOrigen(this)" title="editar"></i>';
                    echo '</td>';
                }
                    ($fila->receta) ? $receta =  $fila->receta : $receta = "Unitario";
                echo"<td>$receta</td>";
                echo"<td>$fila->barcode</td>";
                echo"<td>$fila->descripcion</td>";
                echo"<td>$fila->stock</td>";
                echo"<td>$fila->cantidad_receta</td>";
                echo"<td>$fila->cantidad</td>";
                echo"</tr>";
            }
            echo"</tbody></table>";
        } ?>
        <div class="box-body">
            <enma></enma>
        </div>
    </div>
</div>

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
                    <button type="button" class="btn" data-dismiss="modal" id="cancelarEdit">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="aceptarCantidad">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- FIN MODAL Editar -->



<script>

/* $(document).ready(function () {
     $(".select2").select2(); 
}); */

function crearTablaReceta(tag){
    if(_isset($("#formulas").val()))
    {
        var data = getJson(tag);
        console.log('data: ' + data);
        console.table(data);
        var form_id = data.form_id;
        id_form = form_id;
        var unme = data.unidad_medida;
        var descripcion = data.descripcion;
        descripcionReceta= descripcion;
        document.getElementById('unmedisabled').value = unme;
        document.getElementById('descridisabled').value = descripcion;
        document.getElementById('botonreceta').disabled = false;

        $.ajax({
            type: "GET",
            url: '<?php echo base_url(PRD) ?>general/Etapa/getArticulosEnRecetas/' + form_id,
            success: function (res) {
                wo();

                if(res != 'null'){
                    //console.log(res);
                    $('#tabla-Formula').removeAttr('style');
                    $('#botonAgregareceta').removeAttr('style');
                    $('#tabla-Formula').css('background','#d2d6de');
                    articulos = JSON.parse(res);
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
                    $('#tabla-Formula').css('display', 'none');
                    $('#botonAgregareceta').css('display', 'none');
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
        url: '<?php echo base_url(PRD) ?>general/Etapa/validarPedidoMaterial/'+ $('#batch_id').val(),
        success: function(res) {
            if(res.tarea){
                $('enma').load('<?php echo BPM . 'Proceso/detalleTarea/' ?>' + res.tarea);
            }
            else $('enma').empty();
        },
        error: function(res) {
            error();
            // wbox();
        }
    });
}

// al seleccionar desde el input de Origen muestra stock y habilita input para cantidad y btn aceptar
var matSelect = null;
$("#inputmaterias").on('change', function() {
    // var descri_arti = $("#inputmaterias option:selected").text();
    // document.getElementById('descridisabled').value = descri_arti;
    var data = getJson(this);
    console.log('data: ' + data);
    console.table(data);

    var stock = data.stock;
    // var descripcion = data.descripcion;
    document.getElementById('stockdisabled').value = stock;
    // document.getElementById('descridisabled').value = descripcion;
    materia = this.dataset.json;
    // FIXME: SI SE SACA SIN QUE ANDE EL MODALCITO DE MATERIAS SE ROMPE LA CARGA EN TABLITA
    // agregaMateria(materia);
    matSelect = data;
    // FIXME: SI SE SACA SIN QUE ANDE EL MODALCITO DE MATERIAS SE ROMPE LA CARGA EN TABLITA
    //document.getElementById('stockdisabled').value = ma

    document.getElementById('cantidadmateria').disabled = false;
    document.getElementById('botonmateria').disabled = false;
});

function aceptarMateria() {

    cantidad = document.getElementById('cantidadmateria').value;
    //Validar Cantidad Materia
    if (cantidad == '') {
        alert('Por favor ingresar una cantidad para el origen');
        return;
    }

    $('#cantidadmateria').val('');
    $('#inputmaterias').val('').trigger('change');
    
    
    materia = matSelect;
    materia.cantidad = cantidad;
    materia.cantidad_receta = cantidad;
    materia.tipo = "Unitario";
    materia = JSON.stringify(materia);
    materia = '[' + materia + ']';
    materia = JSON.parse(materia);
    console.log(materia);
    agregaMateria(materia);
    $("#stockdisabled").prop('disabled', false);
    $('#stockdisabled').val('');
    $("#stockdisabled").prop('disabled', true);
    $("#materiaPrimaNuevoPedido .select-detalle").text('');
}

function aceptarReceta() {
    const d=document;
    cantidad = d.getElementById('cantidadreceta').value;
    if (cantidad == '') {
        alert('Por favor ingresar una cantidad para la receta');
        return;
    }
    $('#formulas').val('').trigger('change');
    d.getElementById('botonAgregareceta').disabled = false;
    d.getElementById('botonreceta').disabled = true;
    
    $("#botonAgregareceta").on('click', function() {
        articulo = articulos;
        $.each(articulo, function(i, item) {
            articulo[i].receta=id_form;
            articulo[i].tipo = descripcionReceta;
            articulo[i].cantidad_receta =  cantidad;
            articulo[i].cantidad *= cantidad; 
            articulo[i] = JSON.stringify(articulo[i]);
            articulo[i] = '[' + articulo[i] + ']';
            articulo[i] = JSON.parse(articulo[i]);
            agregaMateria(articulo[i]);
	    });
        $('#tabla-Formula').css('display', 'none');
        d.getElementById('botonAgregareceta').disabled = true;
        $('#botonAgregareceta').css('display', 'none');
        $("#descridisabled").prop('disabled', false);
        $('#descridisabled').val('');
        $("#descridisabled").prop('disabled', true);
        $("#unmedisabled").prop('disabled', false);
        $('#unmedisabled').val('');
        $("#unmedisabled").prop('disabled', true);
        $('#cantidadreceta').val('');
        $("#RecetasLote .select-detalle").text(''); 
        $("#formula").val(''); 
        articulos=null;
    });
}

function eliminarOrigen(e) {
    $(e).closest('tr').remove();
}


function editarOrigen(e){
    var ban= true;
    var materia = JSON.parse($(e).closest('tr').attr('data-json'));
    $('#mdl-editar').modal('show');
    $("#aceptarCantidad").off().on('click',function(){
            cantnuevo = document.getElementById('cantArticulo').value;
            if((cantnuevo != '')&&(ban)&&(cantnuevo > 0))
            {
                eliminarOrigen(e);
                materia.cantidad = cantnuevo;
                materia = JSON.stringify(materia);
                materia = '[' + materia + ']';
                materia = JSON.parse(materia);
                agregaMateria(materia);
                $('#mdl-editar').modal('hide');
                materia='';
                ban=false;    
            }
    });
    $('#cantArticulo').val('');
    $('#mdl-editar').bootstrapValidator('resetForm', true);
    cantnuevo ='';
}


</script>