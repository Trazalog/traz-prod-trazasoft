<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">Listado de No Consumibles</h4>
    </div>
    <div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button class="btn btn-primary" style="margin-top: 10px;" onclick="nuevoNCmodal()">Agregar</button>
					<button class="btn btn-primary" style="margin-top: 10px;" onclick="modalLoteNCs()">Agregar Masivo</button>
				</div>
			</div>
			<div class="box-body table-scroll table-responsive">
				<table id="tbl-NoConsumibles" class="table table-striped table-hover">
					<thead>
							<tr>
								<th width="15%">Acciones</th>
								<th>Código</th>
								<!-- <th>Tipo</th> -->
								<th width="25%">Descripción</th>
								<th>Fecha de Alta</th>
								<th>Fecha de Vencimiento</th>
								<th width="20%">Lotes</th>
								<th width="10%">Producto</th>
								<th width="10%">Estado</th>
							</tr>
					</thead>
					<tbody>
						<?php
							foreach($ListarNoConsumible as $rsp){

								$codigo = $rsp->codigo;
								$estadoNoconsumible = $rsp->estado;
								$tipo = $rsp->tipo;
								$descripcion = $rsp->descripcion;
								$fec_alta = $rsp->fec_alta;
								$fec_vencimiento = $rsp->fec_vencimiento;
								$producto_codigo = $rsp->producto_codigo;
								$lotes = $rsp->lotes;
								echo "<tr id='$codigo' data-json='" . json_encode($rsp) . "'>";
									echo "<td class='text-center text-light-blue'>";
									echo '<i class="fa fa-eye" style="cursor: pointer;margin: 3px;" title="Ver Detalles" onclick="verInfo(this)"></i>';
									echo '<i class="fa fa-edit" style="cursor: pointer; margin: 3px;" title="Editar" onclick="editarInfo(this)"></i>';
									echo '<i class="fa fa-trash eliminar" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="eliminar(this)"></i>';
									echo '<i class="fa fa-fw fa-sitemap" style="cursor: pointer;margin: 3px;" title="Trazabilidad" onclick="trazabilidad(this)"></i>';
									echo '<i class="fa fa-qrcode" style="cursor: pointer;margin: 3px;" title="Código QR" onclick="solicitarQR(this)"></i>';
									echo '<i '.($estadoNoconsumible == 'ALTA' ? 'class="fa fa-fw fa-toggle-off text-light-blue" title="Habilitar"': 'class="fa fa-fw fa-toggle-on text-light-blue" title="Inhabilitar"').' title="Habilitar" style="cursor: pointer; margin-left: 15px;" onclick="cambioEstado(this)"></i>';
									echo "</td>";
									echo '<td>'.$codigo.'</td>';
									//echo '<td>'.$tipo.'</td>';
									echo '<td>'.$descripcion.'</td>';
									echo '<td>'.formatFechaPG($fec_alta).'</td>';
									echo '<td>'.formatFechaPG($fec_vencimiento).'</td>';
									echo '<td>'.$lotes.'</td>';
									echo '<td>'.$producto_codigo.'</td>';
									echo '<td>'.estadoNoCon($estadoNoconsumible).'</td>';
								echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
    </div>

<script>
	//Limpio formulario al cierre de los modales
	$("#mdl-NoConsumible").on("hidden.bs.modal", function () {
  		$('#frm-NoConsumible')[0].reset();
	});
	$("#mdl-VerNoConsumible").on("hidden.bs.modal", function () {
  		$('#frm-NoConsumible')[0].reset();
	});

	  

	function limpiarform(){
		$('#frm-NoConsumible').data('bootstrapValidator').resetForm();
	}
	

	DataTable('#tbl-NoConsumibles');
	DataTable('#tbl-trazabilidad');

  	initForm();

	function nuevoNCmodal(){
		$("#mdl-NoConsumible").modal('show');
	}	

	function guardarNoConsumible() {

		if($("#fec_vencimiento").val() < $("#fec_alta_nuevo").val()){
			wc();
			error('Error...','La fecha de vencimiento no puede ser anterior a la fecha de alta');
			$("#fec_vencimiento").val('');
			return;
		}

		if(!frm_validar('#frm-NoConsumible')){
			alertify.error('Debes completar los campos obligatorios (*)');
        	wc();
        	return;
    	}
		var formData = new FormData($('#frm-NoConsumible')[0]);
		wo();

		validarNoConsumible(formData).then((result) => {
			if(result == "false"){
				$.ajax({
					type: 'POST',
					dataType: 'JSON',
					url: '<?php echo base_url(PRD) ?>general/Noconsumible/guardarNoConsumible',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(rsp) {
						wc();
						$("#mdl-NoConsumible").modal('hide');
						const confirm = Swal.mixin({
							customClass: {
								confirmButton: 'btn btn-primary'
							},
							buttonsStyling: false
						});

						if (rsp) {
							confirm.fire({
								title: 'Correcto',
								text: "No consumible dado de alta correctamente!",
								type: 'success',
								showCancelButton: false,
								confirmButtonText: 'Ok'
							}).then((result) => {
								
								linkTo('<?php echo base_url(PRD) ?>general/Noconsumible/index');
								
							});
						} else {
							wc();
							error('Error...','No pudo darse de alta el No consumible!')
						}
					},
					error: function(rsp) {
						wc();
						$("#mdl-NoConsumible").modal('hide');
						error('Error...','No pudo darse de alta el No consumible!')
						console.log(rsp.msj);
					}
				});
			}else{
				error("Error","El código del No Consumible ingresado ya se encuentra creado!");
			}
		}).catch((err) => {
			if(err){
				console.log(err);
				error("Error","Se produjo un error al validar el código del No Consumible");
			}
		});
	}

	function editarNoConsumible() {

		if($("#fec_vencimiento_Edit").val() < $("#fec_alta").val()){
			wc();
			error('Error...','La fecha de vencimiento no puede ser anterior a la fecha de alta');
			$("#fec_vencimiento_Edit").val('');
			return;
		}
		wo();
		var formData = new FormData($('#frm-NoConsumible_Editar')[0]);
		
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo base_url(PRD) ?>general/Noconsumible/editarNoConsumible',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(rsp) {

				const confirm = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-primary'
					},
					buttonsStyling: false
				});
				$('#mdl-VerNoConsumible').modal('hide');
				confirm.fire({
					title: 'Correcto',
					text: "Se edito no consumible correctamente!",
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'Ok'
				}).then((result) => {
					linkTo('<?php echo base_url(PRD) ?>general/Noconsumible/index');
				});
			},
			error: function(rsp) {
				error('Oops...','Algo salio mal!');
				console.log(rsp.msj);
			},
			complete: function() {
				wc();
			}
		});
	}

	function selectEstablecimiento(tag) {
		var esta_id = $(tag).val();
		$('#estabSelected').text('');
		$('#deposSelected').text('');
		$('#recipSelected').text('');

		wo();
		$.ajax({
			type: 'GET',
			data: {
				esta_id: esta_id
			},
			dataType: 'JSON',
			url: '<?php echo base_url(PRD) ?>general/Establecimiento/obtenerDepositos/',
			success: function(rsp) {

				$('.selectedDeposito').empty();

				var datos = "<option value='' disabled selected>Seleccionar</option>";
				for (let i = 0; i < rsp.length; i++) {
					datos += "<option value=" + rsp[i].depo_id + ">" + rsp[i].descripcion + "</option>";
				}
				//selectSearch('establecimiento', 'estabSelected');
				$('.selectedDeposito').html(datos);
			},
			error: function(rsp) {
				if (rsp) {
					$('.selectedDeposito').empty();
					error('Error',rsp.responseText);
				} else {
					$('.selectedDeposito').empty();
					error('Error',"No se pudieron cargar los depositos del establecimiento seleccionado.");
				}
			},
			complete: function(rsp) {
				wc();
			},
		})
  	}

  	function selectDeposito() {
		var esta_id = $('#establecimiento').val();
		var depo_id = $('#depositos').val();
		$('#deposSelected').text('');
		$('#recipSelected').text('');
		wo();
		$.ajax({
			type: 'GET',
			data: {
				esta_id: esta_id,
				depo_id: depo_id
			},
			dataType: 'JSON',
			url: '<?php echo base_url(PRD) ?>general/Establecimiento/obtenerRecipientesDeposito/',
			success: function(rsp) {
				var datos = "<option value='' disabled selected>Seleccionar</option>";
				for (let i = 0; i < rsp.length; i++) {
					datos += "<option value=" + rsp[i].nombre + ">" + rsp[i].nombre + "</option>";
				}
				//selectSearch('depositos', 'deposSelected');
				$('#tipo_residuo').html(datos);
			},
			error: function(rsp) {
				if (rsp) {
					alert(rsp.responseText);
				} else {
					alert("No se pudieron cargar los recipientes.");
				}
			},
			complete: function(rsp) {
				wc();
			},
		})
  	}

  function selectRecipiente() {
    selectSearch('tipo_residuo', 'recipSelected');
  }

  /* selectSearch: busca en un select un valor selecionado y lo coloca en el "spanSelected" */
  function selectSearch(select, span) {
    var option = $('#' + select).val();
    $('#' + select).find('option').each(function() {
      if ($(this).val() == option) {
        $('#' + span).text($(this).text());
      }
    });
  }

////// Bloque ver y editar
	function verInfo(data){
		blockEdicion();
		$(".bloq_fec_alta").show();
		llenarCampos(data);
		$("#mdl-VerNoConsumible").modal('show');
	}

	function editarInfo(data) {
		habilitarEdicion();
		llenarCampos(data);
		$(".bloq_fec_alta").show();
		$("#mdl-VerNoConsumible").modal('show');
	}

	function blockEdicion(){
		$("select.habilitar").prop("disabled", true);
		$(".habilitar").attr("readonly","readonly");
		$('.deshabilitar').attr("readonly","readonly");//codigo
		$('#btnsave').hide();
	}

	function habilitarEdicion(){
		$("select.habilitar").prop("disabled", false);
		$('.habilitar').removeAttr("readonly");
		$('.deshabilitar').attr("readonly","readonly");//codigo
		$('#btnsave').show();
	}

	function llenarCampos(e) {
		var json = JSON.parse(JSON.stringify($(e).closest('tr').data('json')));

		Object.keys(json).forEach(function(key, index) {
			$('[name="' + key + '"]').val(json[key]);
		});
		$("#fec_alta").val(dateFormat(json['fec_alta']));
		$("#fec_vencimiento_Edit").val(dateFormat(json['fec_vencimiento']));
		$('[name="tinc_id"]').val(json['tinc_id']);
	}
////// Fin Bloque ver y editar

////// Refrezca la tabla cuando cambia el estado del no consumible
function refrezcaListado(){
	$.ajax({
				type: 'GET',
				dataType: 'JSON',
				url: '<?php echo base_url(PRD) ?>general/Noconsumible/getListadoNoconsumible',
				success: function(result) {
							console.log(result);
							tabla = $('#tbl-NoConsumibles').DataTable();
							tabla.clear().draw(); //limpio la tabla
							$.each(result, function(i, value){
								var fcha_alta = value.fec_alta,
									fcha_vencimiento = value.fec_vencimiento;

									fila = "<tr data-json= '"+ JSON.stringify(value) +"'>" +
            					        '<td class="text-center text-light-blue"> <i class="fa fa-eye" style="cursor: pointer;margin: 3px;" title="Ver Detalles" onclick="verInfo(this)"></i>' +
																				'<i class="fa fa-edit" style="cursor: pointer; margin: 3px;" title="Editar" onclick="editarInfo(this)"></i>'+
																				'<i class="fa fa-trash eliminar" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="eliminar(this)"></i>'+
																				'<i class="fa fa-fw fa-sitemap" style="cursor: pointer;margin: 3px;" title="Trazabilidad" onclick="trazabilidad(this)"></i>'+
																				'<i class="fa fa-qrcode" style="cursor: pointer;margin: 3px;" title="Código QR" onclick="solicitarQR(this)"></i>'+
																				'<i '+ (value.estado == 'ALTA' ? 'class="fa fa-fw fa-toggle-off text-light-blue" title="Habilitar"': 'class="fa fa-fw fa-toggle-on text-light-blue" title="Inhabilitar"')+' title="Habilitar" style="cursor: pointer; margin-left: 15px;" onclick="cambioEstado(this)"></i>'+
            					        '<td>' + value.codigo + '</td>' +
            					        '<td>' + value.descripcion + '</td>' +
            					        '<td>' + dateFormat(fcha_alta).replaceAll("-", "/") +'</td>' +
            					        '<td>' + (_isset(fcha_vencimiento) ? dateFormat(fcha_vencimiento).replaceAll("-", "/") : "") +'</td>' +
            					        '<td> ' + (value.lotes ? value.lotes : "") + '</td>' +
            					        '<td>' + (value.producto_codigo ?  value.producto_codigo : "") + ' </td>' +
            					        '<td>' +  colorEstado(value.estado) + '</td>'
            					    '</tr>';
            					tabla.row.add($(fila)).draw();
							});
				},
				error: function(result){
					wc();
					error('error','Error en Cambio de estado');
				},
				complete: function(){
					wc();
				}
		});
}
//////FIN Refrezca la tabla cuando cambia el estado del no consumible


//////color bolita de Estado
function colorEstado(estado){
	switch (estado) {

		case 'ALTA':
			return bolita('Alta', 'blue');
			break;
		case 'VENCIDO':
			return bolita('Vencido', 'red');
			break;
		case 'ACTIVO':
			return bolita('Activo', 'green');
			break;
		case 'EN_TRANSITO':
			return bolita('En Tránsito', 'warning');
			break;
	}
}
//////fin color bolita de Estado

////// Cambio de Estado
	function cambioEstado(row){

		var json = JSON.parse(JSON.stringify($(row).closest('tr').data('json')));
		//alert(json['estado']);
		var data = {};
		data.codigo = json['codigo'];

		if ( (json['estado'] == 'ALTA') || (json['estado'] == 'ACTIVO') ) {

				if (json['estado'] == 'ALTA'){
					data.estado = 'ACTIVO';
				}else{
					data.estado = 'ALTA';
				}
		} else {
			error('Cambio de estado bloqueado','No es posible cambiar el estado del No Consumible');
			return;
		}
		wo();
		$.ajax({
				type: 'POST',
				dataType: 'JSON',
				data:{data},
				url: '<?php echo base_url(PRD) ?>general/Noconsumible/cambioEstado',
				success: function(result) {
							wc();
							/* linkTo('<?php echo base_url(PRD) ?>general/Noconsumible/index'); */
							refrezcaListado();
				},
				error: function(result){
					error('error','Error en Cambio de estado');
					wc();
					
				},
				complete: function(){
					wc();
				}
		});


	}
////// Fin Cambio de Estado

////// Eliminar No Consumible
	var selected = null;

	function eliminar(e) {
			selected = $(e).closest('tr').attr('id');
			$('#mdl-eliminar').modal('show');
	}

	function eliminarNoConsumible() {
		wo();
		$.ajax({
			type: 'POST',
			data: {
					codigo: selected
			},
			url: '<?php echo base_url(PRD) ?>general/Noconsumible/eliminarNoConsumible/',
			success: function(data) {
				const confirm = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-primary'
					},
					buttonsStyling: false
				});
				$('#mdl-eliminar').modal('hide');
				confirm.fire({
					title: 'Correcto',
					text: "Se eliminó no consumible correctamente!",
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'Ok'
				}).then((result) => {
					
					linkTo('<?php echo base_url(PRD) ?>general/Noconsumible/index');
					
				});
			},
			error: function(result) {
					console.log('entra por el error');
					console.log(result);
			},
			complete: function(result){
				wc();
			}
		});
	}
////// Fin Eliminar No Consumible

////// Trazabilidad
	function trazabilidad(e) {
				selected = $(e).closest('tr').attr('id');

				ListarTrazabilidadNoConsumible();
	}

	function ListarTrazabilidadNoConsumible() {
			wo();
			$('#tnc').empty();
				$.ajax({
						type: 'POST',
						data: {
								codigo: selected
						},

						url: '<?php echo base_url(PRD) ?>general/Noconsumible/ListarTrazabilidadNoConsumible',
						success: function(data) {
								$('#tnc').html(data);
								$('#mdl-trazabilidad').modal('show');
						},
						error: function(result) {
								console.log('entra por el error');
								console.log(result);
						},complete:function(){
								wc()
						}

				});
	}
////// Fin Trazabilidad

/////// Validación código del no consumible
async function validarNoConsumible(datos){
    let validacion = new Promise((resolve, reject) => {
      $.ajax({
        type: 'POST',
        data: datos,
		cache: false,
		contentType: false,
		processData: false,
        dataType: 'JSON',
        url: "<?php echo base_url(PRD) ?>general/Noconsumible/validarNoConsumible",
        success: function(rsp) {
          resolve(rsp.existe);
        },
        error: function(rsp){
          reject(rsp.existe);
        },
        complete: function(){
          wc();
        }
      });
    });
    return await validacion;
  }
////////////////
//////// Configuracion y creacion código QR
// Características para generacion del QR
function solicitarQR(e){
	//Limpio el modal
	$("#QRsGenerados").empty();

	// configuración de código QR
	var config = {};
	config.titulo = "Código No Consumible";
	config.pixel = "3";
	config.level = "L";
	config.framSize = "2";

	//Obtengo los datos del No Consumible
	datos = $(e).closest('tr').attr('data-json');
	var datosNoCo = JSON.parse(datos);

	//Cargo la vista del QR con datos en el modal
	var dataQR = {};
	dataQR.codigo = datosNoCo.codigo;
	dataQR.descripcion = datosNoCo.descripcion;
	dataQR.fec_alta = datosNoCo.fec_alta;

	// agrega codigo QR al modal impresion
	obtenerQR(config, dataQR, 'codigosQR/Traz-prod-trazasoft/NoConsumibles');

	// levanta modal completo para su impresion
	$("#modalPlantillaQR").modal('show');
}
////////////// FIN Creación QR
</script>


<!-- Modal  NUEVO No Consumible-->
	<div class="modal fade bd-example-modal-md" tabindex="-1" id="mdl-NoConsumible" role="dialog"
			aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
										aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="mdl-titulo">ABM No Consumibles</h4>
				</div>

				<div class="modal-body" id="modalBody">

					<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
							<h4><i class="icon fa fa-ban"></i> Error!</h4>
							Revise que todos los campos esten completos
					</div>

					<form class="form-horizontal" id="frm-NoConsumible">
							<fieldset id="read-only">
								<fieldset>
									<div class="form-group">
											<label class="col-md-2 control-label" for="codigo">Código<?php echo hreq() ?>:</label>
											<div class="col-md-4">
													<input id="codigo" name="codigo" type="text" placeholder="Ingrese código..."
															class="form-control input-md" required maxlength="14">
											</div>
											<label class="col-md-2 control-label" for="tipo_no_consumible">Tipo No Consumible<?php echo hreq() ?>:</label>
											<div class="col-md-4" title="Para agregar el tipo de No Consumible, debes dirigirte al módulo Configuraciones y selecciona el ABM Lista de valores">
												<select name="tipo_no_consumible" class="form-control" required>
												
													<option value="" > - Seleccionar - </option>
													<?php 
													if(is_array($tipoNoConsumible)){
														foreach ($tipoNoConsumible as $i) {
															echo "<option value = $i->tabl_id>$i->valor</option>";
														}
													}
													?>

												</select>
											</div>
											

									</div>

									<div class="form-group">
											<label class="col-md-2 control-label" for="descripcion">Descripción<?php echo hreq() ?>:</label>
											<div class="col-md-10">
													<textarea class="form-control" id="descripcion" name="descripcion" maxlength="80"
													<?php echo req() ?>></textarea>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label" for="fec_alta">Fecha de
													alta<strong class="text-danger">*</strong>:</label>
											<div class="col-md-8">
											<?php $fcha = date("Y-m-d");?>
													<input id="fec_alta_nuevo" name="fec_alta" type="date"
															value='<?= $fcha ?>' placeholder="" class="form-control input-md" disabled>
											</div>
									</div>

									<div class="form-group">
										
											<label class="col-md-4 control-label" for="fecha_vencimiento">Fecha de
													vencimiento<?php echo hreq() ?>:</label>
											<div class="col-md-8">
													<input id="fec_vencimiento" name="fec_vencimiento" type="date"
															placeholder="" class="form-control input-md"  <?php echo req() ?>>
											</div>
									</div>
									<div class="form-group">
									
												<label class="col-md-4 control-label" for="">Establecimiento<?php echo hreq() ?>:</label>
													<div class="col-md-8" title="Para agregar un establecimiento, debes dirigirte al módulo Configuraciones y seleccionar el ABM Establecimientos: botón 'Agregar' ">
													<select class="form-control select2 select2-hidden-accesible" id="establecimiento" name="establecimiento" onchange="selectEstablecimiento(this)" <?php echo req() ?>>
															<option value="" disabled selected>Seleccionar</option>
															<?php
																if(is_array($tipoEstablecimiento)){
																			foreach ($tipoEstablecimiento as $i) {
																			echo "<option value = $i->esta_id>$i->nombre</option>";
																			}
																}
															?>
													</select>
													<span id="estabSelected" style="color: forestgreen;"></span>
													</div>
										</div>
										<br>
											<!-- ___________________________________________________ -->
									<div class="form-group">
													<label class="col-md-4 control-label" for="depositos">Depósito<?php echo hreq() ?>:</label>
													<div class="col-md-8" title="Para agregar un depósito, debes dirigirte al módulo Configuraciones, seleccionar el ABM Establecimientos y, en el botón Depósitos del establecimiento deseado ">
													<select class="form-control select2 select2-hidden-accesible selectedDeposito" id="depositos" name="depositos" onchange="selectDeposito()" <?php echo req() ?>>
													</select>
													<span id="deposSelected" style="color: forestgreen;"></span>
													</div>
											
									</div>
								</fieldset>
					</form>
				</div> <!-- /.modal-body -->
				<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='limpiarform()'>Cancelar</button>
						<button type="button" id="btn-accion" class="btn btn-success btn-guardar" onclick="guardarNoConsumible()">Guardar</button>
				</div>
			</div>
		</div>
	</div>
<!-------------------------------------------------------->


<!-- Modal  Ver/Editar No Consumible-->
	<div class="modal fade bd-example-modal-md" tabindex="-1" id="mdl-VerNoConsumible" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
									aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="mdl-titulo">Detalle No Consumibles</h4>
				</div>

				<div class="modal-body" id="modalBody">
					<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
							<h4><i class="icon fa fa-ban"></i> Error!</h4>
							Revise que todos los campos esten completos
					</div>

					<form class="form-horizontal" id="frm-NoConsumible_Editar">
						<div class="form-group">
							<label class="col-md-2 control-label" for="codigo">Código<strong class="text-danger">*</strong>:</label>
							<div class="col-md-4">
								<input id="codigo" name="codigo" type="text" placeholder="Ingrese código..." class="form-control input-md deshabilitar" >
							</div>

							<label class="col-md-2 control-label" for="tipo">Tipo No Consumible<strong class="text-danger">*</strong>:</label>

							<div class="col-md-4">
								<select name="tinc_id" class="form-control habilitar"  <?php echo req() ?>>
									<option value="0"> - Seleccionar - </option>
									<?php
										if(is_array($tipoNoConsumible)){
											foreach ($tipoNoConsumible as $i) {
													echo "<option value = $i->tabl_id>$i->valor</option>";
												}
										}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
								<label class="col-md-2 control-label" for="descripcion">Descripción<strong
												class="text-danger">*</strong>:</label>
								<div class="col-md-10">
										<textarea class="form-control habilitar" id="descripcion" name="descripcion" maxlength="80"></textarea>
								</div>
						</div>

						<div class="form-group bloq_fec_alta">
								<label class="col-md-4 control-label" for="fec_alta">Fecha de
										alta<strong class="text-danger">*</strong>:</label>
								<div class="col-md-8">
										<input id="fec_alta" name="fec_alta" type="date"
												placeholder="" class="form-control input-md deshabilitar" >
								</div>
						</div>
								<br>
						<div class="form-group">
								<label class="col-md-4 control-label" for="fec_vencimiento">Fecha de
										vencimiento<strong class="text-danger">*</strong>:</label>
								<div class="col-md-8">
										<input id="fec_vencimiento_Edit" name="fec_vencimiento" type="date"
												placeholder="" class="form-control input-md habilitar" >
								</div>
						</div>
						<div class="form-group">
								<label class="col-md-4 control-label" for="deposito">Depósito<strong class="text-danger">*</strong>:</label>
								<div class="col-md-8">
										<input id="deposito_ver" type="text" name="deposito" placeholder="" class="form-control input-md deshabilitar" >
								</div>
						</div>
						<div class="form-group">
								<label class="col-md-4 control-label" for="establecimiento">Establecimiento<strong class="text-danger">*</strong>:</label>
								<div class="col-md-8">
										<input id="establecimiento_ver" type="text" name="establecimiento" placeholder="" class="form-control input-md deshabilitar" >
								</div>
						</div>
						<div class="form-group">
								<label class="col-md-4 control-label" for="lotes">Lote asociado<strong class="text-danger">*</strong>:</label>
								<div class="col-md-8">
										<input id="lotes_ver" type="text" name="lotes" placeholder="" class="form-control input-md deshabilitar" >
								</div>
						</div>
						<div class="form-group">
								<label class="col-md-4 control-label" for="producto">Producto<strong class="text-danger">*</strong>:</label>
								<div class="col-md-8">
										<input id="producto_ver" type="text" name="producto" placeholder="" class="form-control input-md deshabilitar" >
								</div>
						</div>
						<!-- <div class="form-group">
								<div class="col-md-6 col-md-offset-6">
									<button id="btn-generar_qr" name="btn-generar_qr" class="btn btn-primary">Generar	QR</button>
										<br> <br>
									<button id="btn-imprimir_qr" name="btn-imprimir_qr" class="btn btn-primary">Imprimir QR</button>
								</div>
						</div> -->
					</form>
				</div> <!-- /.modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btnsave" class="btn btn-success btn-guardar"	onclick="editarNoConsumible()">Guardar</button>
				</div>

			</div>
		</div>
	</div>
<!-------------------------------------------------------->

<!-- Modal trazabilidad -->
	<div class="modal fade bd-example-modal-lg" tabindex="-1" id="mdl-trazabilidad" role="dialog"
					aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
							<div class="modal-content">
									<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
															aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="mdl-titulo">Trazabilidad</h4>
									</div>

									<div class="modal-body" id="modalBodyArticle">

											<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
													<h4><i class="icon fa fa-ban"></i> Error!</h4>
													Revise que todos los campos esten completos
											</div>
										
													<fieldset id="read-only">
															<fieldset>
															<table id="tbl-trazabilidad" class="table table-striped table-hover">
									<thead>
											<tr>
													<th>Descripción</th>
													<th>Código</th>
													<th>Tipo</th>
													<th>Responsable</th>
													<th>Depósito/Destino</th>
													<th>Lotes</th>
													<th>Fecha de Alta</th>
													<th>Estado</th>
											</tr>
									</thead>
									<tbody id="tnc">

									</tbody>
							</table>
															</fieldset>
											</form>
									</div> <!-- /.modal-body --> 
									
									<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									</div>
							</div>
					</div>
	</div>
<!-------------------------------------------------------->

<!-- Modal eliminar-->
	<div class="modal" id="mdl-eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><span id="modalAction" class="fa fa-fw fa-times-circle text-light-blue"></span> Eliminar Artículo</h4>
				</div> <!-- /.modal-header  -->

				<div class="modal-body" id="modalBodyArticle">
					<p>¿Realmente desea ELIMINAR el No Consumible? </p>
				</div> <!-- /.modal-body -->

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-success" id="btnSave" data-dismiss="modal" onclick="eliminarNoConsumible()">Eliminar</button>
				</div> <!-- /.modal footer -->

			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog modal-lg -->
	</div> <!-- /.modal fade -->
<!-- / Modal -->
<?php
    // carga el modal de impresion de QR
    $this->load->view( COD.'componentes/modalGenerico');
	//Modal alta masiva de NC's
    $this->load->view('NoConsumible/mdl_altaMasivaNCs');
?>
