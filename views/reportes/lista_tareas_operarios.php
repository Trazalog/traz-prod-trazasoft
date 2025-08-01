<style>
	img {
			width: 50px;
			height: 50px;
	}
	.finca {
			background-color: #9DC3E6;
			border-radius: 2%;
	}
	.seleccion {
			background-color: #F4B183;
			border-radius: 2%;
	}
	.preclasificado {
			background-color: #C7E1AF;
			border-radius: 2%;
	}
	.pelado {
			background-color: #FEDB4C;
			border-radius: 2%;
	}
	.fraccionamiento {
			background-color: #90A9E1;
			border-radius: 2%;
	}
	.profileImage {
			width: 80px;
			height: 80px;
			border-radius: 25%;
			font-size: 45px;
			color: #fff;
			text-align: center;
			line-height: 75px;
			/* margin: 20px 0; */
	}
	.mt{
			margin-top: 25px
	}
	.botonera button{
		font-size: 20px;
	}
	.botonera button.ver-mas{
		font-size: 12px !important;
		border-radius: 20px;
		margin-left: 5px;
	}
</style>

<?php
    $this->load->view('etapa/modal_unificacion_lote');
?>
<!-- LISTADO TAREAS -->
	<div class="box">
			<div class="box-header text-center with-border">
					<h3>Tareas</h3>
			</div>
			<div class="xbox-body">
					<table class="table">
							<tbody>
									<?php
										if($role === '1'){
											foreach($lotes as $o){ //Si es admin puede ver todas las tareas
												# if($o->estado == 'FINALIZADO' || $o->user_id != userId()) continue;
												if($o->estado == 'FINALIZADO') continue;
												echo "<tr id='$o->id' class='data-json' onclick='verReporte(this)' data-json='".json_encode($o)."'>";
												echo "<td width='80px'><div class='profileImage ". strtolower($o->titulo)."'>". substr($o->titulo,0,($o->titulo == 'Fraccionamiento' || $o->titulo == "Preclasificado"?2:1)) ."</div></td>";
												echo "<td class='". strtolower($o->titulo)."'>";
												echo "<b>LOTE:</b> $o->lote<br>";
												echo "<b>ETAPA:</b> $o->titulo<br>";
												echo "<b>ESTABLECIMIENTO:</b> <cite>$o->establecimiento</cite><br>";
												echo "<b>FECHA:</b> ".formatFechaPG($o->fecha);
												echo "</td>";
												echo "</tr>";
											}
										}else{
											foreach ($lotes as $o) { // Sino es admin solo ve las que tiene asignada
												foreach($lotes_responsable as $responsable){
													if($responsable->user_id == $id && $o->id == $responsable->batch_id){
														echo "<tr id='$o->id' class='data-json' onclick='verReporte(this)' data-json='".json_encode($o)."'>";
														echo "<td width='80px'><div class='profileImage ". strtolower($o->titulo)."'>". substr($o->titulo,0,($o->titulo == 'Fraccionamiento' || $o->titulo == "Preclasificado"?2:1)) ."</div></td>";
														echo "<td class='". strtolower($o->titulo)."'>";
														echo "<b>LOTE:</b> $o->lote<br>";
														echo "<b>ESTABLECIMIENTO:</b> <cite>$o->establecimiento</cite><br>";
														echo "<b>FECHA:</b> ".formatFechaPG($o->fecha)."<br>";
														echo "<b>RESPONSABLE:</b> ".$first_name." ".$last_name."<br>";
														echo "<b>EMAIL:</b> ".$email."<br>";
														echo "</td>";
														echo "</tr>";
						
													}
												}
											}
										}
											
									?>
							</tbody>
					</table>
			</div>

	</div>
</div>
<!-- FIN LISTADO TAREAS -->


<script>
	var $mdl = $('#modal_finalizar');
	var s_batchId = false;

	// levanta modal de Reporte de Produccion
	function verReporte(e) {
		var data = getJson2(e);
		s_batchId = data.id;

		$mdl.modal('show');
		$('#codigo_lote').val(data.lote);
		$('#num_orden_prod').val(data.orden);
		$('#batch_id_padre').val(data.id);
		$('#cant_origen').val(data.cantidad);
		$('#depo_id').val(data.depo_id);

		obtenerDepositos(data.esta_id);
		obtenerProductoJson(data.etap_id);

		$('#inputproducto').select2({
			dropdownParent: $('#pnl-1'),
			width: '100%'
		});

		reload('#pnl-noco');
		console.log(data);
	}


	function obtenerResponsable(bacth_id){
		if (!tareaId) {
					alert('Fallo al traer la tarea');
			}
			$.ajax({
					type: 'POST',
					dataType: 'JSON',
					data: {
						bacth_id:  bacth_id,
					},
					url: '<?php echo base_url(PRD) ?>general/Reporte/ListarResponsable',
					success: function(result) {
							if (!result.status) {
									alert('Fallo al Traer Responsables de tarea:'+ bacth_id);
									return;
							}

							if (!result.data) {
									alert('No tiene responsables asignados');
									return;
							}
							console.log(result);
							fillSelect('#productodestino', result.data);
					},
					error: function() {
							alert('Error al Traer Depositos');
					}
			});
	}

	function obtenerDepositos(estaId) {
			if (!estaId) {
					alert('Fallo al traer depositos, no hay empresa asociada');
			}
			$.ajax({
					type: 'POST',
					dataType: 'JSON',
					data: {
							establecimiento: estaId,
							tipo: 'DEPOSITO'
					},
					url: '<?php echo base_url(PRD) ?>general/Recipiente/listarPorEstablecimiento/true',
					success: function(result) {
							if (!result.status) {
									alert('Fallo al Traer Depositos');
									return;
							}

							if (!result.data) {
									alert('No hay Depositos Asociados');
									return;
							}
							console.log(result);
							fillSelect('#productodestino', result.data);
					},
					error: function() {
							alert('Error al Traer Depositos');
					}
			});
	}

	function fillSelectProducto(selector, data) {
		var $select = $(selector);
		$select.empty();
		$select.append('<option value="" disabled selected>Seleccione una opción</option>');
		data.forEach(function(item) {
			$select.append('<option value="' + item.value + '" data-json=\'' + JSON.stringify(item) + '\'>' + item.label + '</option>');
		});
		$select.val(null).trigger('change');
	} 

	function obtenerProductoJson(etap_id) {
		$.ajax({
			url: '<?php echo base_url(PRD).'general/etapa/obtenerProductosSalidaJson' ?>/' + etap_id,
			type: 'GET',
			dataType: 'json',
			success: function(result) {
				if (result.status && result.data) {
					fillSelectProducto('#inputproducto', result.data);
				} else {
					fillSelectProducto('#inputproducto', []);
				}
			}
		});
	}

	$tblRep = $('#tbl-reportes').find('tbody');

	function agregar() {
			var data     = getForm('#frm-etapa');
			var art      = getJson('#inputproducto');
			var destino  = getJson('#productodestino');

			if (art && art.value) {
				data.id = art.value;
			}

			$tblRep.append(
				`<tr id="${$tblRep.find('tr').length + 1}"
					class="data-json batch-${s_batchId} cabecera"
					data-json='${JSON.stringify(data)}' data-forzar="false">
					<td>
						<b>Operario:</b> ${$('#operario option:selected').text()}<br>
						<b>Artículo:</b> ${art.barcode} x ${data.cantidad} (${art.um})
					</td>
					<td>${destino.nombre}</td>
					<td class="botonera">
						<button class="btn btn-link" title="Agregar no consumible" onclick="switchPane()">
							<i class="fa fa-download text-info"></i>
						</button>
						<button class="btn btn-link" title="Eliminar registro" onclick="$(this).closest('tr').remove()">
							<i class="fa fa-trash text-danger"></i>
						</button>
						<button class="btn btn-success ver-mas" title="Ver más" onclick="verMas(this)">
							<i class="fa fa-plus"></i>
						</button>
					</td>
				</tr>
				<tr style="display: none" class="info-extra"></tr>`
			);

		// Limpieza
			$('input[name="cantidad"]').val('');
			$('#inputproducto').val(null).trigger('change');
			$('#productodestino').val(null).trigger('change');
			$('#operario').val(null).trigger('change');

	} 
</script>


<!-- MODALES -->
	<div class="modal modal-fade" data-keyboard="false" data-backdrop="static" id="modal_finalizar">


			<div class="overlay">
					<i class="fa fa-refresh fa-spin"></i>
			</div>
			<div class="modal-dialog modal-lm">
				<!-- Modal Reporte de Produccion -->
					<div id="pnl-1" class="modal-content">
							<!-- Modal Header -->
							<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Reporte de Producción</h4>
							</div>
							<!-- Modal body -->
							<div class="modal-body">
									<form id="frm-etapa">
											<input type="text" class="hidden" id="num_orden_prod">
											<input type="text" class="hidden" id="batch_id_padre">
											<input type="text" class="hidden" id="depo_id">
											<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Código Lote:</label>
															<input type="text" id="codigo_lote" class='form-control' readonly>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label>Asignar Operario:</label>
															<select id="operario" name="recu_id" class="form-control">
																<?php foreach($rec_trabajo as $o) {echo "<option value='$o->recu_id' data-json='".json_encode($o)."'>$o->descripcion</option>";} ?>
															</select>
															<input type="text" class="hidden" name="tipo_recurso" value="HUMANO">
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label>Producto:</label>
															<?php
																echo selectBusquedaAvanzada('inputproducto', 'producto', false, false, false, false, false, false);
															?>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label>Cantidad:</label>
															<input type="number" name="cantidad" class="form-control">
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label>Destino:</label>
															<?php
																echo selectBusquedaAvanzada('productodestino', 'destino', false, false, false, false, false, 'revisarRecipiente(this)')
															?>
														</div>
													</div>
													<div class="col-md-12" id="bloque_etapa" hidden="true">
														<div class="form-group">
															<label>Etapa:</label>
															<?php
																echo selectBusquedaAvanzada('proceso', 'etapa_etap_id', false, false, false, false, false, false)
															?>
														</div>
													</div>
											</div>
									</form>
									<button class="btn btn-success" style="float: right;" onclick="agregar()"><i class="fa fa-plus"></i>Agregar</button>
									<table id="tbl-reportes" class="table table-hover table-striped">
										<thead>
											<th>Registro de reportes</th>
											<th>Destino</th>
											<th width="5%"></th>
										</thead>
										<tbody>

										</tbody>
									</table>
							</div>

							<!-- Modal footer -->
							<div class="modal-footer">
									<button type="button" class="btn" data-dismiss="modal">Cerrar</button>
									<button type="button" class="btn btn-primary" onclick="FinalizarEtapa()">Guardar</button>
									<!-- <button type="button" class='btn btn-success' onclick='conf(btnFinalizar)'>Finalizar Etapa</button> -->
							</div>
					</div>
				<!-- Modal Reporte de Produccion -->

				<!-- Modal Asociar no consumibles -->
					<div id="pnl-2" class="modal-content hidden">
							<!-- Modal Header -->
							<div class="modal-header">
									<button type="button" class="close" onclick="switchPane()">&times;</button>
									<h4 class="modal-title">Asignar no Consumibles</h4>
							</div>
							<!-- Modal body -->
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12 form-group">
										<label>Escanear No Consumible</label>
										<div class="input-group">
											<input id="codigoNoCoEscaneado" class="form-control" placeholder="Busque Código..." autocomplete="off" onchange="consultarNoCo()">
											<span class="input-group-btn">
												<button class="btn btn-primary" style="cursor:not-allowed">
													<i class="glyphicon glyphicon-search"></i>
												</button>
											</span>
										</div>
									</div>
									<div class="col-md-12">
										<table id="tbl-noco" class="table table-hover table-striped">
											<thead>
												<td>Código</td>
												<td>Descripción</td>
												<td></td>
											</thead>
											<tbody>
											</tbody>
											<tfoot class="text-center">
												<tr>
													<td colspan="3">Tabla vacía</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
							<!-- Modal footer -->
							<div class="modal-footer">
									<button type="button" class="btn" onclick="resetNoco()">Cancelar</button>
									<button type="button" class='btn btn-success' onclick='asociarNocos()'>Hecho</button>
							</div>
					</div>
				<!-- Modal Asociar no consumibles -->
			</div>
	</div>
<!-- FIN MODALES -->


<script>
	// Al cerrar modal
	$('#modal_finalizar').on('hidden.bs.modal', function() {
			$tblRep.empty();
			$('#frm-etapa').find('form-control').val('');
			$('.select2').trigger('change');
			s_batchId = false;
			$('#tbl-noco tbody tr').remove();
	});
	// Genera Informe de Etapa (BTN Guardar Reporte)
	var FinalizarEtapa = function(unificar_lote = false) {

		var productos = [];

		$tblRep.find('tr.cabecera').each(function() {

			var json = getJson2(this);
			
			if (unificar_lote && this.dataset.forzar == 'false') {
				this.dataset.forzar = "true";
				unificar_lote = false;
			}

			json.lotedestino = $('#codigo_lote').val();
			json.forzar = this.dataset.forzar;
			productos.push(json);
		});

		productos = JSON.stringify(productos);
		cantidad_padre = '0';
		num_orden_prod = $('#num_orden_prod').val();
		batch_id_padre = $('#batch_id_padre').val();
		destino = $('#productodestino').val();
		depo_id = $('#depo_id').val();
		noConsumAsociar = true;
		estado = 'EN_TRANSITO';

		wo();

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			async: false,
			data: {
				productos,
				cantidad_padre,
				num_orden_prod,
				destino,
				batch_id_padre,
				depo_id,
				noConsumAsociar,
				estado
			},
			url: '<?php echo base_url(PRD) ?>general/Etapa/Finalizar',
			success: function(rsp) {
				wc();

				if (rsp.status) {
					
					$('#modal_finalizar').modal('hide');
					$('#mdl-unificacion').modal('hide');
					hecho('Se genero el Reporte de Producción correctamente.');
				} else {
					
					if (rsp.msj) {
						reci_id = rsp.reci_id;
						getContenidoRecipiente(reci_id);

					} else {
						alert('Fallo al generar Reporte Producción');
					}
				}
			},
			complete: function() {
				wc();
			}
		});
	}
	//
	function asociarNocos() {
			var data = [];
			$(`.batch-${s_batchId}`).next(`.info-extra`).text('');// Limpio la info extra antes de agregar
			infoFila = '<td><label>No consumibles asociados:</label><ul>';
			// $(`.batch-${s_batchId}`).next(`.info-extra`).append('<td><label>No consumibles asociados:</label><ul>');

			$('#tbl-noco tbody  tr').each(function(){
				dataNoCo = getJson(this);
				data.push(dataNoCo.codigo);
				infoFila += `<li>${dataNoCo.codigo} : ${dataNoCo.descripcion}</li>`;
			});
			infoFila += '</ul></td><td></td><td></td>';
			$(`.batch-${s_batchId}`).next(`.info-extra`).html(infoFila);

			setAttr($(`.batch-${s_batchId}`), 'nocos', data);
			//resetNoco();
			switchPane();
	}
	// Limpia tabla nocons y abre modal padre
	function resetNoco(){
			$('#tbl-noco tbody').empty();
			$('#tbl-noco tfoot').show();
			switchPane()
	}
	// Alterna entre modales
	function switchPane(){
		$('#tbl-reportes .ver-mas').toggle();// oculta info extra
		if($('#pnl-1').hasClass('hidden')){
				$('#pnl-1').removeClass('hidden');
				$('#pnl-2').addClass('hidden');
		}else{
				$('#pnl-2').removeClass('hidden');
				$('#pnl-1').addClass('hidden');
		}
	}

	// Funcion que no se usa en esta pantalla
	var btnFinalizar = function() {
		wo();

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo base_url(PRD) ?>general/Etapa/finalizarLote',
			data: {
				batch_id: s_batchId
			},
			success: function(res) {
				if (res.status) {
					$('#' + s_batchId).remove();
					hecho('Etapa finalizada exitosamente');
				}
			},
			error: function(res) {
				error();
			},
			complete: function() {
				wc();
			}
		});
	}

// consulta la información de No Consum por código
function consultarNoCo(){

	wo('Buscando Informacion');
	var codigo = $("#codigoNoCoEscaneado").val();

	$.ajax({
		type: 'POST',
		dataType:'json',
		data:{codigo: codigo },
		url: '<?php echo base_url(PRD) ?>general/Noconsumible/consultarInfo',
		success: function(result) {
			wc();
			if(!$.isEmptyObject(result)){
				if(result.estado != 'ALTA'){
					agregarNocoEscaneado(result);
				}else{
					error('Error','El no consumible se encuentra inhabilitado!');
				}
			}else{
				alertify.error('El recipiente escaneado no se encuentra cargado...');
			}
		},
		error: function(result){
			wc();
		},
		complete: function(){
			$('#codigoNoCoEscaneado').val('');
			wc();
		}
	});
}
// Agrega el NoCo escaneado a la tabla
function agregarNocoEscaneado(data) {
	$('#tbl-noco tfoot').hide();
	if ($('#tbl-noco tbody').find(`.${data.codigo}`).length > 0) {
		Swal.fire(
			'Alerta',
			' El no consumible ya se encuentra en la lista',
			'warning'
		)
		return;
	}
	$('#tbl-noco tbody').append(`
		<tr class='${data.codigo}' data-json='${JSON.stringify(data)}'>
			<td>${data.codigo}</td>
			<td>${data.descripcion}</td>
			<td><button class="btn btn-link" onclick="$(this).closest('tr').remove()"><i class="fa fa-times text-danger"></i></button></td>
		</tr>
	`)
	$('#codigoNoCoEscaneado').val('');
}
//Despliega fila de info extra -->NOTA: se crea una abajo de cada registro
function verMas(tag){
	$(tag).parent().parent().next('.info-extra').toggle();
}
//Busca las etapas de un recipiente seleccionado siempre y cuando sea DEPOSITO/PRODUCTIVO
//se llama en el onchange del select de recipientes
function revisarRecipiente(elem) {
    console.log('Obtener Etapas');
    var recipiencito = JSON.parse($(elem).attr("data-json"));
    // console.log(recipiencito);  
    if (recipiencito.tipo == "DEPOSITO/PRODUCTIVO") {
        console.log(recipiencito);
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '<?php echo base_url(PRD) ?>general/Etapa/getProcesosEtapas',
            success: function(rsp) {
                if (rsp.status && _isset(rsp.data)) {
                    $('#proceso').html(rsp.data);
                    // $('#proceso').show();
                    $('#bloque_etapa').attr('hidden', false);
                    // $('#proceso').removeAttr("disabled");
                }else{
                    $('#proceso').html('');
                    error('Error!','No se encontraron Etapas en el establecimiento seleccionado');
                }
            },
            error: function(rsp) {
                alert('Error al Obtener Etapas');
            }
        });
    };   
}
</script>