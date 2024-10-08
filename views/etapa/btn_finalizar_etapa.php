<?php
    if( empty($productos_etapa) && sizeof($productos_etapa) == 0){
?>
<button class='btn btn-success' onclick='btnFinalizar()'>Finalizar Etapa</button>
<script>
function btnFinalizar() {
    debugger;  
    validarFormularioControlCalidad().then((result) => {
        if(result){
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
        }else{
            notificar('Nota','<b>Para realizar un reporte de producción el formulario de calidad debe estar aprobado</b>','warning');
        }
    }).catch((err) => {
        wc();
        error("Error","Se produjo un error al validar el formulario de calidad");
        console.log(err);
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
    debugger;
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
/////////////
//Valida que la variable QC_OK del formulario de calidad este Aprobada
//Si sale por el else, es una etapa de fraccionamiento
async function validarFormularioControlCalidad(){
    wo();
    origenFormulario = _isset($("#origen").attr('data-json')) ? JSON.parse($("#origen").attr('data-json')) : null;
    debugger;
    if(_isset(origenFormulario)){
        let validacionForm = new Promise((resolve,reject) => {
            wo();
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '<?php echo base_url(PRD) ?>general/etapa/validarFormularioCalidad/' + origenFormulario.orta_id + '/' + origenFormulario.origen,
                success: function(res) {
                    if (res.status) {
                        resolve(true);
                    } else {
                        resolve(false);
                    }
                },
                error: function(res) {
                    reject(false);
                }
            });
        });
    return await validacionForm;
    }else{
        return new Promise((res) => res(true));
    }
}
</script>

<?php } ?>