<h3>Notificación Stardar Ejemplo</h3>

<form>
    <div class="form-group">
        <label>Nombre:</label>
        <input id="nombre" class="form-control req" type="text">
    </div>
    <div class="form-group">
        <label>Apellido:</label>
        <input id="apellido" class="form-control req" type="text">
    </div>
</form>

<script>
var task = <?php echo json_encode($tarea) ?> ;

function cerrarTarea() {
    alert(task.caseId);
    if ($('#nombre').val() == '' && $('#apellido').val() == '') {
        alert('Formulario Incompleto');
        return;
    }

    cerrar();
}
</script>