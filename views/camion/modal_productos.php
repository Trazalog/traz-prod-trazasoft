<div class="modal" id="modal_productos" tabindex="-1" style="z-index:5000;" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Productos</h4>
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
  <script>
  $(document).off('click', '.tabla_productos_nuevo').on('click', '.tabla_productos_nuevo',function(){
    producto = $(this).closest('tr').data('json');
    document.getElementById('inputproductos').value = producto[0].titulo;
    $("#modal_productos").modal('hide');
  });
  </script>
  </div>