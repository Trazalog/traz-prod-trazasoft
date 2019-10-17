<!-- Main content -->
<div class="row">
    <div class="bandeja col-xs-12 col-xs-12">
        <div class="box box-primary">  
            <div class="table-responsive "><br>
                <table class="table table-hover table-striped" id="ferchu">
                    <thead>
                        <!-- <tr> -->
                        <th></th>
                        <th>Tarea</th>
                        <th class="oculto">Descripción</th>
                        <th class="oculto">Info</th>
                        <th class="oculto">Fec. Venc.</th>
                        <!-- </tr> -->
                    </thead>
                    <tbody>


                        <?php
foreach ($list as $f) {

    if (true) { //($f['processId'] == BPM_PROCESS_ID_PEDIDOS_NORMALES || $f['processId'] == BPM_PROCESS_ID_PEDIDOS_EXTRAORDINARIOS) {

        $id = $f["taskId"];
        $asig = $f['idUsuarioAsignado'];

        echo '<tr class="item" id="' . $id . '" class="' . $id . '" style="cursor: pointer;">';

        if ($asig != "") {
            echo '<td class="' . ($device == 'android' ? 'hidden"' : '') . '"><i class="fa fa-user text-primary" title="' . formato_fecha_hora($f['fec_asignacion']) . '"></i></td>';
        } else {
            echo '<td class="' . ($device == 'android' ? 'hidden"' : '') . '"><i class="fa fa-user" style="color: #d6d9db;" title="No Asignado"></i></td>';
        }

        echo '</td>';

        echo '<td class="mailbox-name"><a href="#"><b>' . $f['nombreProceso'] . '</b> | ' . $f['nombreTarea'] . '</a></td>';

        echo '<td class="mailbox-subject oculto">' . substr($f['descripcion'], 0, 500) . '</td>';

        echo '<td class="mailbox-subject oculto"><span class="label label-primary">OT:??</span> <span class="label label-warning">SS:??</span></td>';

        echo '<td class="mailbox-date oculto">' . formato_fecha_hora($f['fec_vencimiento']) . 'dd/mm/aaaa</td>';

        echo '</tr>';

    }
}
?>

                    </tbody>
                </table>
                <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->

    </div>
    <!-- /. box -->
    <div class="view col-xs-8">

    </div>
</div>


<!-- /.col -->
</div>
<!-- /.row -->

<script>
$('table').DataTable({
    "language":{
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}});


$('.item').single_double_click(function() {
    $('body').addClass('sidebar-collapse');
    $('.oculto').hide();
    $('.bandeja').removeClass('col-xs-12');
    $('.bandeja').addClass('col-xs-4');
    $('.view').empty();
    $('.view').load('<?php base_url()?>Tarea/detalleTarea/' + $(this).attr('id'));
}, function() {
    alert('Culo de Mono');
    linkTo('<?php base_url()?>Tarea/detalleTarea/' + $(this).attr('id'));
});

$('input').iCheck({
    checkboxClass: 'icheckbox_flat',
    radioClass: 'iradio_flat'
});
</script>