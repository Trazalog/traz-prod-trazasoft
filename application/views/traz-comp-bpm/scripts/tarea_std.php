<script>
//Script para Vista Standar  
evaluarEstado();

function evaluarEstado() {

    if (task.idUsuarioAsignado != "") {
        habilitar();
    } else {
        deshabilitar();
    }
}

function habilitar() {

    $(".btn-soltar").show();
    $(".btn-tomar").hide();
    $('#view').css('pointer-events', 'auto');
}

function deshabilitar() {
    $(".btn-soltar").hide();
    $(".btn-tomar").show();
    $('#view').css('pointer-events', 'none');
}

function tomarTarea() {
    $.ajax({
        type: 'POST',
        data: {
            id: task.taskId
        },
        url: 'index.php/<?php echo BPM ?>Tarea/tomarTarea',
        success: function(data) {

            if (data['status']) {
                habilitar();
            } else {
                alert(data['msj']);
            }

        },
        error: function(result) {
            alert('Error');
        },
        dataType: 'json'
    });
}
// Soltar tarea en BPM
function soltarTarea() {
    $.ajax({
        type: 'POST',
        data: {
            id: task.taskId
        },
        url: 'index.php/<?php echo BPM ?>Tarea/soltarTarea',
        success: function(data) {

            // toma a tarea exitosamente
            if (data['status']) {
                deshabilitar();
            }
        },
        error: function(result) {
            console.log(result);
        },
        dataType: 'json'
    });
}

function cerrar() {
    if ($('#miniView').length == 0) {
        linkTo('<?php echo BPM ?>Tarea');
    } else {
        existFunction('closeView');
    }
}

function guardarComentario() {
    var nombUsr = $('#usrName').val();
    var apellUsr = $('#usrLastName').val();
    var comentario = $('#comentario').val();

    $.ajax({
        type: 'POST',
        data: {
            'processInstanceId': task.caseId,
            'content': comentario
        },
        url: 'index.php/<?php echo BPM ?>Tarea/guardarComentario',
        success: function(result) {
            var lista = $('#listaComentarios');
            lista.prepend(
                '<div class="item"><p class="message"><a href="#" class="name"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>' +
                nombUsr + ' ' + apellUsr +
                '</a><br><br>' + comentario + '</p></div>'

            );
            $('#comentario').val('');
        },
        error: function(result) {
            console.log("Error");
        }
    });
}
</script>