<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Salida Camión</h3>
    </div>
    <div class="box-body">
        <form id="frm-salida-camion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos Generales</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha:</label>
                                <input id="fecha_salida" type="date" name="fecha_salida" class="form-control" value="<?php echo isset($datosCamion->fecha_entrada) ? date('d-m-Y', strtotime($datosCamion->fecha_entrada)) : '' ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Establecimiento Origen:</label>
                                <?php echo selectFromFont('esta_id', 'Seleccionar', REST_ALM."/establecimiento", array('value'=>'esta_id', 'descripcion'=>'nombre')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Establecimiento Destino:</label>
                                <?php echo selectFromFont('destino_esta_id', 'Seleccionar', REST_ALM."/establecimiento", array('value'=>'esta_id', 'descripcion'=>'nombre')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos Camión</h3>
                </div>
                <div class="panel-body">
                    <input id="motr_id" name="motr_id" class="hidden" value="<?php echo isset($datosCamion->motr_id) ? $datosCamion->motr_id : '' ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Patente:</label>
								<input id="patente" name="patente" class="form-control" value="<?php echo isset($datosCamion->patente) ? $datosCamion->patente : '' ?>">
							</div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Acoplado:</label>
                                <input id="acoplado" type="text" name="acoplado" class="form-control" value="<?php echo isset($datosCamion->acoplado) ? $datosCamion->acoplado : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Conductor:</label>
                                <input id="conductor" type="text" name="conductor" class="form-control" value="<?php echo isset($datosCamion->conductor) ? $datosCamion->conductor : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo:</label>
                                <input id="tipo" type="text" name="tipo" class="form-control" value="<?php echo isset($datosCamion->tipo) ? $datosCamion->tipo : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Peso Bruto:</label>
                                <input id="bruto" type="number" name="bruto" class="form-control" value="<?php echo isset($datosCamion->bruto) ? $datosCamion->bruto : '' ?>" onchange="calculaNeto()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Peso Tara:</label>
                                <input type="text" id="tara" name="tara" class="form-control" value="<?php echo isset($datosCamion->tara) ? $datosCamion->tara : '' ?>" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Peso Neto:</label>
                                <input type="text" id="neto" name="neto" class="form-control" value="<?php echo isset($datosCamion->neto) ? $datosCamion->neto : '' ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Contenido Camión</h3>
                </div>
                <div class="panel-body">
                    <table id="tbl-lotes" class="table table-striped table-hover">
                        <thead>
                            <th>Lista productos</th>
                            <th width="20%">Cantidad</th>
                        </thead>
                        <tbody>
							<?php foreach ($datosCamion->articulos->articulo as $fila) {
								echo "<tr  data-json='".json_encode($fila)."'>";
								echo '<td style="font-weight: lighter;">'.$fila->articulo.'</td>';
								echo '<td style="font-weight: lighter;">'.$fila->cantidad.'</td>';
								echo '</tr>';
							}
							?>
                        </tbody>
                    </table>
                    <!-- <div class="form-group">
                        <label>Obsevación:</label>
                        <textarea class='form-control' rows='3' placeholder='Ingrese Texto...'></textarea>
                    </div> -->
                </div>
            </div>
        </form>
    </div>
    <?php 
    	$this->load->view('NoConsumible/SalidaNoConsumible');
    ?>
    <div class="box-footer">
				<button class="btn btn-success" style="float:right" onclick="validarSalida()">Guardar</button>
    </div>
</div>


<script>
	$(document).ready(function () {
		estaSelected  = "<?php echo isset($datosCamion->esta_id) ? $datosCamion->esta_id : '' ?>";
		if(estaSelected != ''){
			$("#esta_id").val(estaSelected);
		}
	});
	var $tLotes = $('#tbl-lotes').find('tbody');
	$('.date').datepicker({
			dateFormat: 'dd-mm-yy'
	});
	// al ingresar patente busca info de camion ingresado (obtenerInfoCamion(patente))
		$('#patente').keyup(function(e) {
				this.value = this.value.replace(' ', '');
				if (e.keyCode === 13) {
						if (this.value == null || this.value == '') return;
						var patente = this.value;
						console.log($('#esta_id').val());
						if ($('#esta_id').val() && $('#esta_id').val() != "0") obtenerInfoCamion(patente);
						else {
								alert('Debes seleccionar un establecimineto origen');
						}
				}
		});
	// obtiene los lotes cargados en camion seleccionado
		function obtenerLotesCamion(patente) {
				$tLotes.empty();
				wo();
				$.ajax({
						type: 'POST',
						dataType: 'JSON',
						url: '<?php echo base_url(PRD) ?>general/Lote/obtenerLotesCamion/false',
						data: {
								patente
						},
						success: function(rsp) {
								if (!rsp.data) {
										alert('No existen Lotes Asociados');
										return;
								}
								rsp.data.forEach(function(e) {
										$tLotes.append(
												`<tr><td>${e.barcode}<br><cite>${e.descripcion}</cite></td><td>${e.cantidad}(${e.um})</td></tr>`
												);
								});
						},
						error: function(rsp) {
								alert('No hay Lotes Asociados');
						},
						complete: function() {
								wc();
						}
				});
		}
	// suma tara con peso neto de carga
	function calculaNeto(){
		if (!_isset($('#bruto').val()) || (parseFloat($('#bruto').val()) <= parseFloat($('#tara').val()))) {
			$('#neto').val(0);
			return;
		}else{
			$('#neto').val(parseFloat($('#bruto').val()) - parseFloat($('#tara').val()));
		}
	}
	// busca info del camion y llama a buscar los lotes cargados (obtenerLotesCamion(patente))
	function obtenerInfoCamion(patente) {
			var estado = 'CARGADO|EN CURSO|CARGADO|DESCARGADO';
			wo();
			$.ajax({
					type: 'POST',
					dataType: 'JSON',
					url: '<?php echo base_url(PRD) ?>general/Camion/obtenerInfo/' + patente,
					data:{estado},
					success: function(rsp) {
							console.log(rsp);
							if (rsp) {
									fillForm(rsp);
									if(rsp.estado == 'CARGADO'){
											$('#bruto').val(0);
											$('#neto').val(0);
									}
									$('#bruto').attr('readonly', rsp.estado == 'DESCARGADO');
									obtenerLotesCamion(patente)
							} else {
									alert('Camión no registrado')
							}
					},
					error: function(rsp) {
							alert('Error');
					},
					complete: function() {
							wc();
					}
			});
	}
	// valida campos vacios y llama a guardar la salida
	function validarSalida(){

			if(!$('#destino_esta_id').val()){
				conf(guardarSalida, false, 'No se ha seleccionado destino','El camión se pondrá en estado finalizado');
			}else{
					guardarSalida();
			}

	}
	// guarda la salida de camion y los no consumibles asociados
	var guardarSalida = function() {

			// Noconsumibles
				var datosTabla = new Array();
				$('#tablaNoCon tr').each(function(row, tr) {
					datosTabla[row] = {
						"codigo": $(tr).find('td:eq(1)').attr('value'),
						//"establecimiento": $(tr).find('td:eq(4)').attr('value'),
						"destino": $(tr).find('td:eq(3)').attr('value')
					}
				});

			// datos salida camion
				var data = getForm('#frm-salida-camion');

			wo();
			$.ajax({
					type: 'POST',
					dataType: 'JSON',
					url: '<?php echo base_url(PRD) ?>general/camion/guardarSalida',
					data:{datosTabla, data},
					success: function(res) {

							wc();
							console.log(res);
							if(res.status){
									hecho();linkTo('<?php echo PRD ?>general/Camion/recepcionCamion');
							}else{
									error();
							}
					},
					error: function(res) {
						wc();
							error();
					},
					complete: function() {
							wc();
					}
			});
	}
</script>