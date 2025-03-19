<style>
#toggle-table {
    cursor: pointer; /* Cambia el cursor a una mano para indicar que es clickeable */
    display: flex; /* Alinea el ícono y el texto */
    align-items: center; /* Centra verticalmente */
    gap: 10px; /* Espacio entre el texto y el ícono */
}

#content-table {
    display: none; /* Inicialmente oculto */
}
</style>

<div class="modal" id="mdl-unificacion" tabindex="-1" role="dialog" style='z-index:9999;'>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">¿Desea unificar lotes?</h4>
            </div>

            <div class="modal-body">
                <h5 id="toggle-table">Detalle del contenido
                    <span id="toggle-icon">↓</span>
                </h5>
                <table class="table table-striped table-hover" id="content-table">
                    <thead>
                        <tr>
                            <th>Lote</th>
                            <th>Artículo</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody id="contenido-recipiente">
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <?php
                    if(!$etapa || $etapa->estado == "En Curso"){
                        echo '<button type="button" class="btn btn-primary" onclick="FinalizarEtapa(true)">Unificar</button>';
                    }else{
                        echo '<button type="button" class="btn btn-primary" onclick="guardarForzado(bak_data)">Unificar</button>';
                    }
                ?>
               
            </div>
        </div>
    </div>
</div>

<script>
var bak_data = false;
var bak_recipiente = false;

    $('#toggle-table').click(function() {
        $('#content-table').toggle(); // Mostrar u ocultar la tabla

        // Cambiar el texto del ícono
        const icon = $('#toggle-icon');
        if (icon.text() === '↓') {
            icon.text('↑'); // Cambiar a flecha arriba
        } else {
            icon.text('↓'); // Cambiar a flecha abajo
        }
    });

    // Función para obtener el contenido del recipiente
    function getContenidoRecipiente(reci_id) {
        wo();
        $('#contenido-recipiente').empty();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo base_url(PRD) ?>Recipiente/obtenerContenido/' + reci_id,
            success: function(result) {
                if (result.status) {
                    if (result.data) {
                        result.data.forEach(function(e) {
                            $('#contenido-recipiente').append(
                                `<tr><td>${e.lote_id}</td><td>${e.barcode}</td><td>${e.cantidad}</td></tr>`
                            );
                        });
                    } else {
                        $('#contenido-recipiente').append(
                            `<tr><td colspan='3'>Recipiente sin contenido</td></tr>
                             <tr><td colspan='3'>Los lotes a crear serán unificados en un mismo recipiente</td></tr>`
                        );
                    }
                    $('#mdl-unificacion').modal('show');
                } else {
                    alert('Fallo al obtener contenido del recipiente');
                }
            },
            error: function() {
                alert('Error al traer el contenido del recipiente');
            },
            complete: function() {
                wc();
            }
        });
    }

</script>