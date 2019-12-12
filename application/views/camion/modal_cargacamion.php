<!--RBASAÑES-->

<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <!--Header del modal-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
            </div>
            <!--_____________________________________________________________-->

            <!--Body del modal-->
            <div class="modal-body">
                <div class="row">
                <!--DATOS ESPECIFICOS DEL MODAL-->
                    <!--Articulo-->
                    <div class="form-group">
                        <label for="articulo" class="form-label">Articulo:</label>
                        <input type="text" id="articulo" class="form-control input-sm" readonly>
                    </div>
                    <!--_____________________________________________________-->
                </div>
            </div>
            <!--_____________________________________________________________-->

            <!--Footer del modal-->
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!--_____________________________________________________________-->

        </div>
    </div>

    <!--Script ventana modal de articulos-->
        <!--<script>-->
            <!--$(document).off('click', '.tabla_productos_nuevo').on('click', '.tabla_productos_nuevo',function(){
            producto = $(this).closest('tr').data('json');
            document.getElementById('inputproductos').value = producto[0].titulo;
            $("#modal_productos").modal('hide');
            });-->
        <!--</script>-->
    <!--_____________________________________________________________-->

</div>