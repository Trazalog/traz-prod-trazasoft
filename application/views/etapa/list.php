<style>
	.flotante {
		display: scroll;
		position: fixed;
		bottom: 80%;
		right: 2%;
		z-index: 9999;
	}

	.btn-circle.btn-xl {
		width: 40px;
		height: 40px;
		padding: 4px 10px;
		border-radius: 35px;
		font-size: 24px;
		line-height: 1.33;
	}

	.btn-circle {
		width: 30px;
		height: 30px;
		padding: 6px 0px;
		border-radius: 15px;
		text-align: center;
		font-size: 12px;
		line-height: 1.42857;
	}
</style>


<div class="box table-responsive">
	<div class="box-header">
		<h3 class="box-title">Etapas</h3>
		<div class="row" style="width:900px;">
			<div class="col-xs-10">
				<?php

				for ($i = 0; $i < count($etapas); $i++) {
					if ($i < count($etapas) - 1) {
						echo "<button class='btn btn-primary btn-arrow-right outline' onclick='muestra(`" . $etapas[$i]->titulo . "`,`" . json_encode($list) . "`)'> " . $etapas[$i]->titulo . "  </button>";
					} else {
						echo "<button class='btn btn-primary btn-arrow-right-final outline' onclick='muestra(`" . $etapas[$i]->titulo . "`,`" . json_encode($list) . "`)'> " . $etapas[$i]->titulo . "  </button>";
					}
				}
				?>
				<button class="btn btn-primary outline" onclick='muestra(`todas`,`<?php echo json_encode($list); ?>`)'>
					Todas</button>
			</div>
			<div class="flotante">
				<button style="background: #1D976C;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #93F9B9, #1D976C);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #93F9B9, #1D976C); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
" type="button" class=" btn dropdown-toggle btn-circle btn-xl" data-toggle="dropdown" aria-expanded="false"> <b style="color:#ffffff">+</b></button>
				<ul class="dropdown-menu dropdown-menu-right" id="nuevo">
					<li class="header text-center text-info"><b>Crear Nueva Etapa</b></li>
					<?php

					foreach ($etapas as $fila) {
						echo "<li  data-value='" . $fila->id . "'><a data-json='" . json_encode($fila) . "'><i class='fa fa-chevron-circle-right text-info'></i>" . $fila->titulo . "</a></li>";

						//var_dump($etapas);
					}
					?>

					<!-- <li  data-value="1"><a data-json="">"siembra"</a></li> -->




				</ul>
			</div>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div class="row">
			<div class="col-xs-12">
				<table id="etapas" class="table table-bordered table-hover">
					<thead class="thead-dark">

						<th width="6%">Acciones</th>
						<th>Etapa</th>
						<th>Lote</th>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Establecimiento</th>
						<th>Recipiente</th>
						<th>OP</th>
						<th>Fecha</th>
						<th>Estado</th>

					</thead>
					<tbody>
						<?php

						foreach ($list as $fila) {

							$id = $fila->id;
							echo '<tr  id="' . $id . '" data-json=\'' . json_encode($fila) . '\'>';

							echo '<td width="6%" class="text-center">';
							echo "<i data-toggle='modal' data-target='#modal-asignarResponsable' class='fa fa-fw fa-user text-green ml-1' style='cursor: pointer;' title='Asignar responsable' onclick='asignarResponsable($id)'></i>";
							echo '<i class="fa fa-fw fa-cogs text-light-blue ml-1" style="cursor: pointer;" title="Editar" onclick=linkTo("general/Etapa/editar?id=' . $id . '")></i>';
							echo '<i class="fa fa-fw fa-times-circle text-red ml-1" style="cursor: pointer;" title="Eliminar" onclick="seleccionar(this)"></i>';
							echo '</td>';

							echo '<td>' . $fila->titulo . '</td>';
							echo "<td>$fila->lote</td>";
							echo '<td>' . $fila->producto . '</td>';
							echo '<td>' . $fila->cantidad . ' ' . $fila->unidad . '</td>';
							echo '<td>' . $fila->establecimiento . '</td>';
							echo '<td>' . $fila->recipiente . '</td>';
							echo '<td>' . $fila->orden . '</td>';
							echo  "<td>" . formatFechaPG($fila->fecha) . "</td>";
							echo '<td>' . estado($fila->estado) . '</td>';
							echo '</tr>';
						}

						?>
					</tbody>
				</table>


			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->
<div class="modal fade" id="modal-asignarResponsable" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Asignar responsable</h4>
			</div>
			<div class="modal-body">
				<form id="frm-asignarResponsable">
					<input type="text" hidden id="idEtapa" name="idEtapa">
					<div class="form-group col-md-6">
						<label for="user">Usuario*</label>
						<select id="user" name="user" class="form-control" required>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="turno">Turno*</label>
						<select class="form-control" id="turno" name="turno" required>
							<option selected disabled>Seleccione turno</option>
							<option value="M">Mañana</option>
							<option value="T">Tarde</option>
							<option value="JC">Jornada completa</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
				<button id="botAsignarRespModal" type="button" class="btn btn-success pull-right" style="margin-right: 10px;" onclick="addRespToEtapa(this)">Asignar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
</body>
<script>
	if (mobileAndTabletcheck()) $('#etapas tbody').find('tr').on('click', function() {
		$(this).find('.fa-pencil').click();
	});

	DataTable('#etapas');

	function muestra(op, etapas) {
		etapas = JSON.parse(etapas);
		html = "";
		html = '<thead class="thead-dark">' +
			'<tr>' +
			'<th>Acciones</th>' +
			'<th>Etapa</th>' +
			'<th>Lote</th>' +
			'<th>Producto Origen</th>' +
			'<th>Cantidad</th>' +
			'<th>Establecimiento</th>' +
			'<th>Recipiente</th>' +
			'<th>OP</th>' +
			'</tr>' +
			'</thead>' +
			'<tbody>';

		if (op === 'todas') {

			for (var i = 0; i < etapas.length; i++) {
				html = html + '<tr  id="' + etapas[i].id + '" ><td>' +
					'<i class="fa fa-fw fa-pencil text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Editar" onclick=linkTo("general/Etapa/editar?id=' +
					etapas[i].id + '")></i>' +
					'<i class="fa fa-fw fa-times-circle text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Eliminar" onclick="seleccionar(this)"></i>' +
					'</td>' +
					'<td>' + etapas[i].titulo + '</td>' +
					'<td>' + etapas[i].lote + ' </td>' +
					'<td>' + etapas[i].producto + '</td>' +
					'<td>' + etapas[i].cantidad + ' ' + etapas[i].unidad + '</td>' +
					'<td>' + etapas[i].establecimiento + '</td>' +
					'<td>' + etapas[i].recipiente + '</td>' +
					'<td>' + etapas[i].orden + '</td>' +
					'</tr>';
			}
		} else {
			for (var i = 0; i < etapas.length; i++) {
				if (etapas[i].titulo === op) {
					html = html + '<tr  id="' + etapas[i].id + '" ><td>' +
						'<i class="fa fa-fw fa-pencil text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Editar" onclick=linkTo("general/Etapa/editar?id=' +
						etapas[i].id + '")></i>' +
						'<i class="fa fa-fw fa-times-circle text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Eliminar" onclick="seleccionar(this)"></i>' +
						'</td>' +
						'<td>' + etapas[i].titulo + '</td>' +
						'<td>' + etapas[i].lote + ' </td>' +
						'<td>' + etapas[i].producto + '</td>' +
						'<td>' + etapas[i].cantidad + ' ' + etapas[i].unidad + '</td>' +
						'<td>' + etapas[i].establecimiento + '</td>' +
						'<td>' + etapas[i].recipiente + '</td>' +
						'<td>' + etapas[i].orden + '</td>' +
						'</tr>';
				}
			}
		}

		html = html + '</tbody>';

		document.getElementById('etapas').innerHTML = '';
		document.getElementById('etapas').innerHTML = html;
		$("#etapas").dataTable().fnDestroy();
		if (mobileAndTabletcheck()) $('#etapas tbody').find('tr').on('click', function() {
			$(this).find('.fa-pencil').click();
		});
		$("#etapas").dataTable({});


	}


	var ul = document.getElementById('nuevo');
	ul.onclick = function(event) {
		target = JSON.parse(event.target.getAttribute('data-json'));
		console.log(target);
		linkTo(target.link);
	}

	function asignarResponsable(idEtapa) {
		$('#modal-asignarResponsable').find('#idEtapa').attr('value', idEtapa);
		// wo();
		$.ajax({
			type: "GET",
			url: "general/Etapa/getUsers",
			success: function(rsp) {
				// alert("Fórmula creada correctamente.");
				console.log('Usuarios BPM');
				var htmlUser = '<option selected disabled>Seleccione operario</option>';
				rsp = JSON.parse(rsp);
				for (let i = 0; i < rsp.length; i++) {
					htmlUser += '<option value="' + rsp[i].id + '" >' + rsp[i].lastname + ', ' + rsp[i].firstname + '</option>';
				}
				$('#modal-asignarResponsable').find('#user').html(htmlUser);
			},
			error: function() {
				// alert("Se produjo un error al crear la fórmula.");
				console.log('No se pudieron traer los usuarios');
			},
			complete: function() {
				// wc();
			}
		});
	}

	function addRespToEtapa() {
		var data = new FormData($('#frm-asignarResponsable')[0]);
		showFD(data);
		data = formToObject(data);
		console.table(data);

		wo();
		$.ajax({
			type: "POST",
			url: "general/Etapa/setUserEtapa",
			data: {
				data
			},
			success: function(rsp) {
				// alert("Fórmula creada correctamente.");
				// linkTo('general/Formula');
			},
			error: function() {
				alert("Se produjo un error al crear cargar operario.");
			},
			complete: function() {
				wc();
			}
		});
	}
</script>
