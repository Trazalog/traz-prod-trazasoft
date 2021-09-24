<section class="content-header">
	<h1>
		<font style="vertical-align: inherit;">
			<font style="vertical-align: inherit;">
				Fórmulas
			</font>
		</font><small>
			<font style="vertical-align: inherit;"></font>
		</small>
	</h1>
</section>
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
				<!-- form start -->
				<form role="form" id="form-Formulas" name="form-Formulas" data-toggle="validator">
					<!-- <input type="text" id="unme_id" name="unme_id" value="<?php echo $unme_id ?>" hidden> -->
					<div class="box-body">
						<div class="form-group col-md-12">
							<label for="descripcion">Descripción *</label>
							<input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese descripción" required>
						</div>
						<div class="form-group col-md-4">
							<label for="unme_id">U.M. *</label>
							<select class="form-control" id="unme_id" name="unme_id" required>
								<option selected disabled>Seleccione unidad</option>
								<?php
								foreach ($um as $key) {
									echo "
										<option value='$key->tabl_id'>$key->descripcion ($key->valor)</option>
										";
								}
								?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="cantidad">Cantidad *</label>
							<input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ingrese cantidad" required>
						</div>
						<div class="form-group col-md-4">
							<label for="exampleInputPassword1">Fecha *</label>
							<!-- <input type="date" class="form-control" id="fecha" name="fecha" required> -->
							<input type="text" id="usuario_app" name="usuario_app" value=" 69" hidden>
						</div>
						<div class="form-group col-md-12">
							<label for="aplicacion">Aplicación *</label>
							<textarea class="form-control" id="aplicacion" name="aplicacion" rows="3" placeholder="Procedimiento de aplicación..." required></textarea>
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
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">
						<font style="vertical-align: inherit;">
							<font style="vertical-align: inherit;">Artículos de la fórmula</font>
						</font>
					</h3>
				</div>
				<form role="form" id="form-Articulos" name="form-Articulos">
					<div class="box-body">
						<div class="form-group col-md-5">
							<label for="articulo">Artículo</label>
							<select class="form-control" id="articulo" name="articulo" data-descripcion>
								<option selected disabled>Seleccione artículo</option>
								<?php
								foreach ($articulos as $key) {
									echo "
										<option value='$key->arti_id' data-um='$key->unidad_medida' >$key->descripcion</option>
										";
								}
								?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="cantidad-articulo">Cantidad</label>
							<input type="number" class="form-control" id="cantidad-articulo" name="cantidad-articulo" placeholder="Ingrese cantidad">
						</div>
						<div class="form-group col-md-2">
							<label for="um-articulo">U.M.</label>
							<input type="text" class="form-control" id="um-articulo" name="um-articulo" readonly>
						</div>
						<div class="form-group col-md-1">
							<label for=""></label>
							<a class="btn btn-social-icon" style="margin-top: 4px;" onclick="agregarFila()"><i class="fa fa-fw fa-plus-square"></i></a>
						</div>
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

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<br>
					<!-- <div class="box-footer"> -->
					<button type="submit" class="btn btn-success pull-right" onclick="validaDatos()" style="margin-top: 20px;">
						Crear
					</button>
					<!-- </div> -->
				</form>
			</div>
		</div>
	</div>
</section>

<script>
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
				var un = $(this).data('um');
				var descripcion = $(this).text();
				$('#um-articulo').val(un);
				$('#articulo').data('descripcion', descripcion); //cargo descripcion en el select
			}
		});
	});

	//Agregar fila a tabla
	function agregarFila() {
		var descripcion = $('#articulo').data('descripcion');
		var articulo = $('#articulo').val();
		var cantidad = $('#cantidad-articulo').val();
		var um = $('#um-articulo').val();
		if (!articulo || !cantidad) {
			alert('Complete artículo y cantidad.');
			return;
		}
		$('#articulo').prop('selectedIndex', 0);
		$('#cantidad-articulo').val('');
		$('#um-articulo').val('');
		html = '<tr>' +
			'<td>' + descripcion + '</td>' +
			'<td hidden>' + articulo + '</td>' +
			'<td>' + um + '</td>' +
			'<td>' + cantidad + '<a type="button" class="del pull-right" style="cursor: pointer;"><i class="fa fa-fw fa-minus"></i></a></td>' +
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
			alert('Debe completar todos los campos con *.')
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
				"cantidad": $(tr).find('td:eq(3)').text()
			}
		});
		datosTabla.shift(); //borra encabezado de la tabla
		if (datosTabla.length < 2) {
			alert('La fórmula debe contener al menos dos ingredientes.');
			return;
		}

		var articulos = JSON.stringify(datosTabla);
		console.log('datosFormula: ' + datosFormula);
		showFD(datosFormula);
		datosFormula = formToObject(datosFormula);
		console.log('articulos: ' + articulos);

		wo();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(PRD)?>general/Formula/setFormula",
			data: {
				datosFormula: datosFormula,
				articulos: articulos
			},
			success: function(rsp) {
				alert("Fórmula creada correctamente.");
				linkTo('<?php echo base_url(PRD) ?>general/Formula');
			},
			error: function() {
				alert("Se produjo un error al crear la fórmula.");
			},
			complete: function() {
				wc();
			}
		});
		// return; //comentar para finalizar
	}
</script>
