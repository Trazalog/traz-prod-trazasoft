<div class="box box-primary">
	<div class="box-header with-border">
		<section class="content-header">
			<h1 class="box-title">
				<font style="vertical-align: inherit;">
					<font style="vertical-align: inherit;">
						Fórmulas
					</font>
				</font><small>
					<font style="vertical-align: inherit;"></font>
				</small>
			</h1>
		</section>
	</div>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">Datos de la fórmula</font>
							</font>
						</h3>
					</div>
					<input hidden type="text" value="<?php echo $tipo ?>" id="tipo" name="tipo" readonly>
					<input hidden type="text" value="<?php echo $form_id ?>" id="form_id" name="form_id" readonly>
					<!-- form start -->
					<form role="form" id="form-Formulas" name="form-Formulas" data-toggle="validator">
						<!-- <input type="text" id="unme_id" name="unme_id" value="<?php echo $unme_id ?>" hidden> -->
						<div class="box-body">
							<div class="form-group col-md-12">
								<label for="descripcion">Descripción <?php hreq() ?></label>
								<input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese descripción" value="<?php echo $formula->descripcion ?>" required>
							</div>
							<div class="form-group col-md-4">
								<label for="unme_id">U.M. <?php hreq() ?></label>
								<?php
								if ($tipo == 1) {
									echo
										"<input type='text' class='form-control' id='unme_id' name='unme_id' placeholder='Ingrese descripción' value='$formula->unme_id' required>";
								} else {
									echo
										"<select class='form-control' id='unme_id' name='unme_id' required>
										<option disabled>Seleccione unidad</option>";

									foreach ($um as $key) {
										$selected = ($formula->unme_id == $key->tabl_id) ? 'selected' : '';
										echo "
												<option value='$key->tabl_id' $selected >$key->descripcion ($key->valor)</option>
												";
									}
									echo "</select>";
								}
								?>
							</div>
							<div class="form-group col-md-4">
								<label for="cantidad">Cantidad <?php hreq() ?></label>
								<input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ingrese cantidad" value="<?php echo $formula->cantidad ?>" required>
							</div>
							<div class="form-group col-md-4">
								<label for="exampleInputPassword1">Fecha <?php hreq() ?></label>
								<!-- <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $formula->fec_alta ?>" required> -->
								<!-- <input type="text" id="usuario_app" name="usuario_app" value="<?php echo $formula->usuario_app ?>" hidden> -->
							</div>
							<div class="form-group col-md-12">
								<label for="aplicacion">Aplicación <?php hreq() ?></label>
								<textarea class="form-control" id="aplicacion" name="aplicacion" rows="3" placeholder="Procedimiento de aplicación..." required><?php echo $formula->aplicacion ?></textarea>
							</div>
							<div class="form-group col-md-12">
								<label for="archivo">Archivo</label>
								<input type="file" id="archivo">
								<p class="help-block">Seleccione un archivo PDF.</p>
							</div>
						</div>
						<!-- /.box-body -->
					</form>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">Artículos de la fórmula</font>
							</font>
						</h3>
					</div>
					<form role="form" id="form-Articulos" name="form-Articulos">
						<div class="box-body">
							<div class="form-group col-md-12 ba">
								<label for="articulo">Artículo <?php hreq() ?></label>
								<?php
									echo selectBusquedaAvanzada('articulo','articulo',$articulos,'arti_id', 'barcode',array("descripcion","Medida"=>"unidad_medida","Stock" =>"stock"));
								?>
							</div>
							<div class="form-group col-md-5">
								<label for="cantidad-articulo">Cantidad <?php hreq() ?></label>
								<input type="number" class="form-control" id="cantidad-articulo" name="cantidad-articulo" placeholder="Ingrese cantidad">
							</div>
							<div class="form-group col-md-5">
								<label for="um-articulo">U.M. <?php hreq() ?></label>
								<input type="text" class="form-control" id="um-articulo" name="um-articulo" readonly>
							</div>
							<?php
							if ($tipo == 2) {
								echo
									"<div class='form-group col-md-1'>
									<label for=''></label>
									<a class='btn btn-social-icon' style='margin-top: 4px;' onclick='agregarFila()'><i class='fa fa-fw fa-plus-square'></i></a>
								</div>";
							}
							?>
							<div class="dataTables_wrapper form-inline dt-bootstrap">
								<div class="row">
									<div class="col-sm-12"></div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<table id="tabla-Formula" class="table table-bordered table-hover dataTable" role="grid">
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
												<?php
												foreach ($articulosFormula as $key) {
													$cantidad = $key->cantidad;
													echo "
														<tr>
															<td>$key->descripcion</td>
															<td hidden>$key->arti_id</td>
															<td>$key->unidad_medida</td>
															<td value='$cantidad' data-valor='$cantidad'>$cantidad";
													if ($tipo == 2) {
														echo
															"<a type='button' class='del pull-right' style='cursor: pointer;'><i class='fa fa-fw fa-minus'></i></a>";
													}
													echo "	</td>
														</tr>
													";
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div><!-- /.box box-primary -->
			</div> <!-- /.col-md-6 -->
		</div> <!-- /.row -->
	</section>
	<div class="box-footer">
		<?php
			if ($tipo == 2) {
				echo '<button class="btn btn-success pull-right" onclick="validaDatos()" style="margin-top: 20px;">Editar</button>';
				echo '<button class="btn btn-danger pull-right" onclick="linkTo(\'' .base_url(PRD).'general/Formula\')" style="margin-top: 20px; margin-right: 10px;">Cancelar</button>';
			}else{
				echo '<button class="btn btn-danger pull-right" onclick="linkTo(\'' .base_url(PRD).'general/Formula\')" style="margin-top: 20px; margin-right: 10px;">Cerrar</button>';
			}
		?>
	</div>
</div> <!-- /.box box-primary -->

<script>
	if ($('#tipo').val() == 1) {
		//1: ver
		//2: editar
		// $('#form-Formulas')[0].attr('readonly');
		$('#descripcion').attr('readonly', '');
		$('#unme_id').attr('readonly', '');
		$('#cantidad').attr('readonly', '');
		$('#fecha').attr('readonly', '');
		$('#aplicacion').attr('readonly', '');
		$('#archivo').attr('disabled', '');
		$('#articulo').attr('disabled', '');
		$('#um-articulo').attr('readonly', '');
		$('#cantidad-articulo').attr('readonly', '');
	}

	//Fecha actual
	Date.prototype.toDateInputValue = (function() {
		var local = new Date(this);
		local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
		return local.toJSON().slice(0, 10);
	});
	$('#fecha').val(new Date().toDateInputValue());

	//Seteo unidad de medida del artículo
	$('#articulo').change(function() {
		var id = $(this).val();
		$(this).children('option').each(function() {
			if (id == $(this).val()) {
				dataJson = JSON.parse($(this).attr('data-json'));
				$('#um-articulo').val(dataJson.unidad_medida);
			}
		});
	});

	//Agregar fila a tabla
	function agregarFila() {
		dataJson = JSON.parse($('#articulo').attr('data-json'));
		var cantidad = $('#cantidad-articulo').val();
		debugger;
		if (! _isset(dataJson.arti_id) || ! _isset(cantidad)) {
			error('Error','Complete artículo y cantidad.');
			return;
		}
		$('#articulo').val(null).trigger('change');
		$('.ba #detalle').text('');
		$('#cantidad-articulo').val('');
		$('#um-articulo').val('');
		html = '<tr>' +
			'<td>' + dataJson.descripcion + '</td>' +
			'<td hidden>' + dataJson.arti_id + '</td>' +
			'<td>' + dataJson.unidad_medida + '</td>' +
			'<td value=' + cantidad + ' data-valor=' + cantidad + '>' + cantidad + '<a type="button" class="del pull-right" style="cursor: pointer;"><i class="fa fa-fw fa-minus"></i></a></td>' +
			'</tr>';
		$('#tabla-Formula tbody').append(html);
	}

	//Quitar fila de tabla
	$("#tabla-Formula").on("click", ".del", function() {
		$(this).parents("tr").remove();
	});

	function validaDatos() {
		var descripcion = $('#descripcion').val();
		var unme_id = $('#unme_id').val();
		var cantidad = $('#cantidad').val();
		// var fecha = $('#fecha').val();
		var aplicacion = $('#aplicacion').val();
		if (!descripcion || !unme_id || !cantidad || !aplicacion) {
			error('Error','Debe completar todos los campos con *.');
			return;
		}
		crearFormula();
	}

	//Convertir a base64 el archivo PDF
	function getFile(file) {
		var reader = new FileReader();
		return new Promise((resolve, reject) => {
			reader.onerror = () => {
				reader.abort();
				reject(new Error("Error parsing file"));
			}
			reader.onload = function() {

				//This will result in an array that will be recognized by C#.NET WebApi as a byte[]
				let bytes = Array.from(new Uint8Array(this.result));

				//if you want the base64encoded file you would use the below line:
				let base64StringFile = btoa(bytes.map((item) => String.fromCharCode(item)).join(""));

				//Resolve the promise with your custom file structure
				resolve({
					bytes: bytes,
					base64StringFile: base64StringFile,
					fileName: file.name,
					fileType: file.type
				});
			}
			reader.readAsArrayBuffer(file);
		});
	}

	async function crearFormula() {
		// var datosFormula = $('#form-Formulas').serialize();

		//Datos de la fórmula
		var datosFormula = new FormData($('#form-Formulas')[0]);
		var file = document.querySelector('#archivo').files[0];
		if (file) {
			var archivo = await getFile(file);
			datosFormula.append('archivo', archivo.base64StringFile);
		}

		//Datos de la tabla de artículos
		var datosTabla = new Array();
		$('#tabla-Formula tr').each(function(row, tr) {
			datosTabla[row] = {
				"arti_id": $(tr).find('td:eq(1)').text(),
				// "unme_id": $(tr).find('td:eq(2)').text(),
				"cantidad": $(tr).find('td:eq(3)').data('valor')
			}
		});
		datosTabla.shift(); //borra encabezado de la tabla
		if (datosTabla.length < 2) {
			error('Error','La fórmula debe contener al menos dos ingredientes.');
			return;
		}

		var articulos = JSON.stringify(datosTabla);
		showFD(datosFormula);
		datosFormula = formToObject(datosFormula);
		var form_id = $('#form_id').val();

		wo();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(PRD)?>general/Formula/setFormula/" + form_id,
			data: {
				datosFormula: datosFormula,
				articulos: articulos
			},
			success: function(rsp) {
				hecho('Hecho',"Fórmula editada correctamente.");
				linkTo('<?php echo base_url(PRD) ?>general/Formula');
			},
			error: function() {
				error('Error',"Se produjo un error al crear la fórmula.");
			},
			complete: function() {
				wc();
			}
		});
		return; //comentar para finalizar
	}
</script>
