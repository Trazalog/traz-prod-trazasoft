<?php
    if(sizeof($productos_etapa) == 0){
?>
<button class='btn btn-success' onclick='btnFinalizar()'>Finalizar Etapa</button>
<script>
function btnFinalizar() {
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'general/Etapa/finalizarLote',
        data: {
            batch_id: $('#batch_id').val()
        },
        success: function(res) {
            if(res.status){
                back();
                hecho('Etapa finalizada exitosamente');
            }
        },
        error: function(res) {
            error();
        },
        complete: function() {
            wc();
        }
    });
}
</script>

<?php } ?>