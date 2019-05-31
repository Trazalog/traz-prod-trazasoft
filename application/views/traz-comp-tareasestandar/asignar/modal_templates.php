<div class="modal" id="modal_templates" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Tareas</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
      <div class="row">
          <div class="col-xs-12" id="modaltemplates">
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
 $(document).off('click','.tablatemplate_nuevo').on('click', '.tablatemplate_nuevo', function () {
   var tareas = $(this).closest('tr').data('json');
   
   $(this).closest('tr').css({backgroundColor: "cyan"});
  
   for(i=0; i<tareas[0].tareas.length;i++)
   {
    fila=tareas[0].tareas[i];
    idetapa =<?php echo $idetapa;?>;
    $.ajax({
      type: 'POST',
      async: false,
      data: { idtarea:fila.id, idetapa:idetapa },
      url: 'tareas/Tarea/insertaTarea', 
      success: function(result){
      fila.id = result;
      fila.asignado = "Sin Asignar";
      fila.estado ="Incompleto";
      fila = JSON.stringify(fila);
      fila = '['+fila+']';
      fila = JSON.parse(fila);
      insertaTarea(fila);
      }
    
  }
);
   }
   document.getElementById('inputtemplate').value = tareas[0].titulo;
   $("#modal_templates").modal('hide');
  });
</script>
  