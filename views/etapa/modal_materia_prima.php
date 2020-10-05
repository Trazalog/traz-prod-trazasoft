<?php $this->load->view(TAREAS_ASIGNAR.'/modal_recurso_material');?>
<div class="modal" id="modal_materia_prima" tabindex="1" style="z-index:5000;" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> <?php echo $lang['materias']?>
                </h4>
            </div>

            <div class="modal-body" id="modalBodyArticle">
                <div class="row">
                    <div class="col-xs-12" id="modalmaterias">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).off('click', '.tablamaterias_nuevo').on('click', '.tablamaterias_nuevo', function() {
    var materia = $(this).closest('tr').data('json');
    document.getElementById('inputmaterias').value = materia[0].Descripcion;
    document.getElementById('stockdisabled').value = materia[0].stock;
    materia = JSON.stringify(materia[0]);
    $('#idmateria').attr('data-json', materia);
    document.getElementById('cantidadmateria').disabled = false;
    document.getElementById('botonmateria').disabled = false;
    $("#modal_materia_prima").modal('hide');
});

function agregaMateria(materia) {
    estado = '<?php echo $etapa->estado;?>'
    existe = document.getElementById('materiasexiste').value;
    var html = '';
    var materia = JSON.stringify(materia);
    materia = JSON.parse(materia);
    document.getElementById('inputrecursosmateriales').value = materia[0].descripcion;


    //$('#tablamateriasasignadas').dataTable().fnDestroy();
    if (typeof materia[0].arti_id === 'undefined') {
        // your code here
        materia[0].arti_id = materia[0].id;
    }
    html += '<tr data-json="' + JSON.stringify(materia[0]) + '" id="' + materia[0].arti_id + '">';
    if (estado != 'En Curso') {
        html +=
            '<td><i class="fa fa-fw fa-minus text-light-blue" style="cursor: pointer; margin-left: 15px;" onclick="eliminarOrigen(this)"></i></td>';
    }
    html += '<td>' + materia[0].barcode + '</td>';
    html += '<td>' + materia[0].stock + '</td>';
    html += '<td>' + materia[0].cantidad + '</td>';
    html += '</tr>';
    $('#tablamateriasasignadas tbody').append(html);

    //$('#tablamateriasasignadas').DataTable({});
}
</script>