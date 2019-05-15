<div class="modal" id="modal_tareas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Tareas</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
      <div class="row">
          <div class="col-xs-12" id="modaltareas">
          </div>
      </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
  <script>
 $(document).on('click', '.tablatareas_nuevo', function () {
   var row = $(this).closest('tr').data('json');
   var existe = document.getElementById('existe_tabla').value;
   if(existe == "no")
   {
       row = JSON.stringify(row);
       armaTabla('tabla_tareas_asignadas','divtabla', row, 'Del');
       document.getElementById('existe_tabla').value = 'si';
   }else if(existe == 'si')
   {
       row = JSON.stringify(row);
       insertaFila('tabla_tareas_asignadas',row,'Del');
   }
});
</script>

</div>
