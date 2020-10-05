<div class="modal" id="modal_lotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Lotes</h4>
            </div>

            <div class="modal-body" id="modalBodyArticle">
                <div class="row">
                    <div class="col-xs-12 table-responsive" id="modallotes">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
    <script>
    $(document).off('click', '.tabla_lotes_nuevo').on('click', '.tabla_lotes_nuevo', function() {
        lote = $(this).closest('tr').data('json');
        document.getElementById('inputlotes').value = lote.titulo;
        ActualizaLote(lote);
        $("#modal_lotes").modal('hide');
    });
    </script>
</div>