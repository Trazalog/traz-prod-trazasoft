<form id="frm-new-task" autocomplete="off">
    <input autocomplete="false" name="hidden" type="text" style="display:none;">
    <div class="form-group">
        <label for="">Nueva Tarea:</label>
        <input id="nombre" class="form-control" type="text" placeholder="Ingrese Texto...">
    </div>
    <div class="form-group">
        <label for="">Descripción:</label>
        <input id="descripcion" class="form-control" type="text" placeholder="Ingrese Texto...">
    </div>
    <div class="form-group">
        <label for="">Duración:</label>
        <input id="duracion" class="form-control" type="text" placeholder="Ingrese Valor...">
    </div>
</form>

<button class="btn btn-primary pull-right" id="tsk-new"> Guardar</button>


<script>
function agregarTarea(e) {

    $('#lista-tareas').append(
        `<li id="${e.id}>" data-json='${JSON.stringify(e)}'>
                <span class="handle ui-sortable-handle">
                    <i class="fa fa-ellipsis-v"></i>
                    <i class="fa fa-ellipsis-v"></i>
                </span>
                <input type="checkbox" value="">
                <span class="text">${e.nombre}</span>
                <small class="label label-default"><i class="fa fa-clock-o"></i> ${e.duracion}</small>
                <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-times" onclick="$(this).closest('li').remove()"></i>
                </div>
            </li>`
    );
}

$('#tsk-new').click(function() {
    agregarTarea({
        nombre: $('#nombre').val(),
        descripcion: $('#descripcion').val(),
        duracion: $('#duracion').val()
    });
    $('#frm-new-task')[0].reset();
    $(this).closest('.colapse').addClass('collapsed-box');
});
</script>