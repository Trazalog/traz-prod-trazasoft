<div class="modal" id="modal_generarQR" tabindex="-1" style="z-index:5000;" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Código QR</h4>
            </div>

            <div class="modal-body" id="modalBodyArticle">
                <!-- <div class="box-body"> -->
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" id="idQR">
                            <div class="col-md-7 col-sm-7 col-xs-12" id="contenidoImgQR">
                                <?php echo '<img id="imagenQR" src="" />'; ?>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12" id="contenidoQR">

                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            </div>

            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div> -->
        </div>
    </div>
</div>
<script>
    // $(document).off('click', '.tabla_productos_nuevo').on('click', '.tabla_productos_nuevo', function() {
    //     estado = '<?php echo $etapa->estado; ?>';
    //     producto = $(this).closest('tr').data('json');
    //     document.getElementById('inputproductos').value = producto[0].Descripcion;

    //     console.table(producto[0]);
    //     if (estado != 'En Curso') {
    //         ActualizaProducto(producto[0]);
    //     }
    //     $("#modal_productos").modal('hide');
    // });
</script>