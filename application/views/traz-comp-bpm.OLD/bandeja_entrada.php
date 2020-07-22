<!-- Main content -->
<div class="row">
    <div id="bandeja" class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-list"></i>

                    Bandeja de Tareas
                </h3>
            </div>
            <div class="box-body">

                <div class="table-responsive ">
                    <table class="table table-hover table-striped" id="tareas">
                        <thead>
                            <!-- <tr> -->
                            <th></th>
                            <th>Tarea</th>
                            <th class="oculto">Descripción</th>
                            <th class="oculto">Estado</th>
                            <th class="oculto">Fec. Venc.</th>
                            <!-- </tr> -->
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list as $f) {

                                    $id = $f->taskId;
                                    $asig = $f->idUsuarioAsignado;

                                    echo "<tr id='$f->caseId' class='item' id='$id' data-caseId='' data-json='".json_encode($f)."'  style='cursor: pointer;'>";

                                    if ($asig != "") {
                                        echo '<td class="' . ($device == 'android' ? 'hidden"' : '') . '"><i class="fa fa-user text-primary" title="' . formato_fecha_hora($f->fec_asignacion) . '"></i></td>';
                                    } else {
                                        echo '<td class="' . ($device == 'android' ? 'hidden"' : '') . '"><i class="fa fa-user" style="color: #d6d9db;" title="No Asignado"></i></td>';
                                    }

                                    echo '</td>';
																		// TAREA	
																		echo "<td class='mailbox-name'>
																						<a href='#'>
																						<b  style='color:$f->color'> $f->nombreProceso </b> 
																						</a>|  $f->nombreTarea 
																					</td>";
																		// DESCRIPCION					
																		echo '<td class="mailbox-subject oculto">
																						<p>' . substr($f->nombreTarea, 0, 500) . ' | Justificacion: '.$f->justificacion.'</p>
																						<p class="label label-danger">Fecha: '.formatFechaPG($f->fecha).'</p> 
																						<p class="label label-primary">Cod. Lote: '.$f->lote_id.'</p> 
																						<p class="label label-warning">Nº Pedido: '.$f->pema_id.'</p>
																					</td>';
																		// INFO																		
																		echo '<td class="mailbox-subject oculto">
																						<p class="label label-primary">'.$f->estado.'</p>
																					</td>';																	
																	
																		// FEC. VENCIMIENTO
																		if ($f->fec_vencimiento == " ") {
																			echo '<td class="mailbox-date oculto">' . formato_fecha_hora($f->fec_vencimiento) . '</td>';
																		} else {
																			echo '<td class="mailbox-date oculto">Sin fecha</td>';
																		}																	
																		
                                    echo '</tr>';

                                }
                            ?>

                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
            </div>
            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->

    </div>
    <!-- /. box -->
    <div id="miniView" class="view col-xs-8">

    </div>
</div>

<script>
$('.item').single_double_click(function() {
    // $('body').addClass('sidebar-collapse');
    // $('.oculto').hide();
    // $('#bandeja').removeClass().addClass('col-xs-4');
    // $('#miniView').empty();
    // $('#miniView').load('<?php #echo base_url(BPM) ?>Tarea/detalleTarea/' + $(this).attr('id'));
    linkTo('<?php echo ALM   ?>Proceso/detalleTarea/' + $(this).attr('id'));
}, function() {
    linkTo('<?php echo ALM   ?>Proceso/detalleTarea/' + $(this).attr('id'));

});

function closeView() {
    $('#miniView').empty();
    $('.oculto').show();
    $('#bandeja').removeClass().addClass('col-md-12');
}

$('input').iCheck({
    checkboxClass: 'icheckbox_flat',
    radioClass: 'iradio_flat'
});
DataTable('#tareas');
</script>