<div class="box box-primary">
	<div class="box-header with-border">
		<h4 class="box-title">Fórmulas</h4><br>
		<button class="btn btn-primary" onclick="linkTo('<?php echo base_url(PRD) ?>general/Formula/agregarFormula')" style="margin-top:10px;">Nueva fórmula</button>
	</div>

	<div class="box-body table-scroll table-responsive">
		<table id="tbl-formulas" class="table table-striped table-hover">
			<!--Cabecera del datatable-->
			<thead>
				<th hidden></th>
				<th>Descripción</th>
				<th>U.M.</th>
				<th>Cantidad</th>
				<th>Fecha</th>
				<!-- <th>Archivo</th> -->
				<th class="sorting_disabled oculto"></th>
			</thead>
			<!--________________________________________________________________________-->

			<!--Cuerpo del Datatable-->
			<tbody>
				<?php
				foreach ($formulas as $fila) {
					$id = $fila->form_id;
					$descripcion = $fila->descripcion;
					echo "<tr  value='$id' id='$id' data-descripcion='$descripcion'>";
					echo "<td hidden></td>";

					echo '<td style="font-weight: lighter;">' . $fila->descripcion . '</td>';
					echo '<td style="font-weight: lighter;">' . $fila->unme_id . '</td>';
					echo '<td style="font-weight: lighter;">' . $fila->cantidad . '</td>';
					echo '<td style="font-weight: lighter;">' . $fila->fec_alta . '</td>';
					// echo '<td style="font-weight: lighter;">' . $fila->archivo . '</td>';

					echo '<td width="15%" class="text-center" style="font-weight: lighter;">';
					echo "<i class='fa fa-fw fa-search-plus text-light-blue' style='cursor: pointer;' title='Ver detalles'  onclick='verDetalles($id)'></i>";
					// echo '<i class="fa fa-fw fa-refresh text-green" style="cursor: pointer;" title="Editar fórmula"  onclick="editarFormula(this)"></i>';
					echo "<i class='fa fa-fw fa-refresh text-green' style='cursor: pointer;' title='Editar fórmula'  onclick='editarFormula($id)'></i>";
					// echo '<i class="fa fa-fw fa-trash text-red" style="cursor: pointer;" title="Eliminar fórmula"  onclick="eliminarFormula(this)"></i>';
					echo "<i class='fa fa-fw fa-trash text-red' style='cursor: pointer;' data-toggle='modal' data-target='#modal-delete'  title='Eliminar fórmula' onclick='validarEliminar($id)'></i>";
					echo '</td>';

					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Está seguro que desea eliminar la fórmula:</h4>
			</div>
			<div class="modal-body">
				<p id="nameFormula"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
				<button id="botDeleteModal" type="button" class="btn btn-danger" onclick="eliminarFormula(this)">Eliminar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!--________________________________________________________________________-->

<!--Script Data Table-->
<script>
	DataTable('#tbl-formulas');
	$('.oculto').removeClass('sorting');
	// $('#tbl-formulas').dataTable();
	$("#modal-delete").modal('hide');

	function ajax(tipo, id) {
		if (!id) {
			alert('Sin Detalles a Mostrar');
			return;
		}
		// wo();
		linkTo('<?php echo base_url(PRD) ?>general/Formula/modificarFormula/' + tipo + '/' + id);
	}

	function verDetalles(id) {
		console.log('id: ' + id);
		ajax(1, id);
	}

	function editarFormula(id) {
		console.log('id: ' + id);
		ajax(2, id);
	}

	function validarEliminar(id) {
		var eliminar = 'eliminarFormula(' + id + ')';
		var a = document.getElementById(id);
		var descripcion = a.dataset.descripcion;
		// descripcion = descripcion.data('descripcion');
		console.log('descripcion: ' + descripcion);
		console.log('id: ' + id);
		$('#nameFormula').text(descripcion);
		$('#botDeleteModal').val(id);
	}

	function eliminarFormula(e) {
		$("#modal-delete").modal('hide');
		var id = e.value;
		console.log('id: ' + id);
		if (!id) {
			alert('Sin Detalles a Mostrar');
			return;
		}
		wo();
		$.ajax({
			type: "GET",
			url: "<?php echo base_url(PRD)?>general/Formula/deleteFormula/" + id,
			success: function(rsp) {
				alert("Fórmula eliminada!");
				// $('#tbl-formulas tr').each(function() {
				// 	console.log('tr: ' + this.value);
				// 	if ($(this).val() == id) {
				// 		console.log('encontrada id: ' + id);
				// 		$(this).remove();
				// 	}
				// });
				linkTo('<?php echo base_url(PRD) ?>general/Formula');
				// $(this).parents("tr").remove();

			},
			error: function() {
				alert("Se produjo un error al eliminar la fórmula.");
			},
			complete: function() {
				wc();
			}
		});
	}
</script>
<!--________________________________________________________________________-->