<?php
    if( empty($productos_etapa) && sizeof($productos_etapa) == 0){
?>
<button class='btn btn-success' onclick='btnFinalizar()'>Finalizar Etapa</button>
<script>
function btnFinalizar() {
    wo();
    validarCantidadReportes().then((result) => {
        wc();
        if(!result){
            Swal.fire({
                title: 'Atención!',
                html: '<h5><b>No se agregó ningún reporte de producción.</b></h5><br><b style="font-size: 13px;">¿Esta seguro de finalizar la etapa?</b><br> <b style="font-size: 13px;">Esta acción no puede ser revertida.</b>',
                type: 'question',
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonText: 'Finalizar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    finalizarEtapa();
                }
            });
        }else{
            finalizarEtapa();
        }
    }).catch((err) => {
        wc();
        error('Error','Se produjo un error al validar la cantidad de reportes de produccion asociados');
    });
}
//////////////////////////////////////////
// Validacion de si la etapa posee algun reporte de produccion
// Debe tener al menos 1 reporte de produccion asociado para poder finalizar la Etapa
async function validarCantidadReportes(){
    var batch_id = $("#batch_id").val();
    var aprobacion = new Promise((acepta,rechaza) =>{
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: {
                batch_id,
            },
            url: '<?php echo base_url(PRD) ?>general/Lote/validarCantidadReportes',
            success: function(result) {
                if(result.status){
                    var data = JSON.parse(result.data);
                    if (!data.reportes.cantidad > 0) {
                        acepta(true);
                    }else{
                        acepta(false);
                    }
                }else{
                    rechaza(false)
                }
            },
            error: function() {
                rechaza(false);
            }
        });
    });
    return await aprobacion;
}
/////////////////////////////////////
//Cierra la etapa con batch_id
function finalizarEtapa(){
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Etapa/finalizarLote',
        data: {
            batch_id: $('#batch_id').val()
        },
        success: function(res) {
            if(res.status){
                back();
                hecho('Hecho','Etapa finalizada exitosamente!');
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