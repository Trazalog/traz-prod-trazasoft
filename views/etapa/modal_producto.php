<div class="modal bs-example-modal-lg" id="modal_producto" tabindex="1" role="dialog" aria-labelledby="myModalLabel" style="z-index:5000;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Productos</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
         <div class="row">
             <div class="col-xs-12 table-responsive" id="modalproductos">
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
 $(document).off('click','.tablaproductos_nuevo').on('click', '.tablaproductos_nuevo', function () {
   var producto = $(this).closest('tr').data('json');
   

   document.getElementById('inputproducto').value = producto[0].Descripcion;
   document.getElementById('idproducto').value = producto[0].id;
  
   $("#modal_producto").modal('hide');
  });
  
</script>
  