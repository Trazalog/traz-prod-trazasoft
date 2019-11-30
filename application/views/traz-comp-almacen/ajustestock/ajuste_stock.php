<form autocomplete="off" method="POST" id="formTotal">
    <?php 
        $this->load->view(ALM.'ajustestock/componentes/cabecera');
    ?>

    <div class="row">
        <div class="col-md-6">
            <?php 
                $this->load->view(ALM.'ajustestock/componentes/entrada');
            ?>
        </div>
        <div class="col-md-6">
            <?php
            $this->load->view(ALM.'ajustestock/componentes/salida');
            ?>
        </div>
    </div>

    <?php 
        $this->load->view(ALM.'ajustestock/componentes/justificacion');
    ?>
</form>

<script>

obtenerArticulos();

function obtenerArticulos() {
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'index.php/<?php echo ALM ?>Articulo/obtener',
        success: function(rsp) {
            //console.log(rsp);

            if (!rsp.status) {
                alert('No hay Articulos Disponibles');
                return;
            }
            rsp.data.forEach(function(e, i) {
                $('.articulos').append(
                    `<option value="${e.id}" data="${e.unidad_medida}">${e.barcode} | ${e.titulo}</option>`
                );
            });
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        }
    });
}

$(".select2").select2();

$("#articuloent").on('change', function() {
    $("#unidadesent").val($("#articuloent>option:selected").attr("data"));
});
$("#articulosal").on('change', function() {
    $("#unidadsal").val($("#articulosal>option:selected").attr("data"));
});


function guardar() {

        
        var formdata = new FormData($("#formTotal")[0]);
        // var formdata2 = FormData($("#frm-salida")[0]);
        var formobj1 = formToObject(formdata);
        // var formobj2 = formToObject(formdata2);
        // var formobjmerge = mergeFD(formobj1, formobj2);
        console.log(formobj1);
        // showFD(formobj1);

        // $.ajax({
        //     type: 'POST',
        //     data: formobjmerge,
        //     dataType: 'JSON',
        //     url: '',
        //     success: function(rsp) {
        //         console.log(rsp);

        //     },
        //     error: function(rsp) {
        //         alert('Error: ' + rsp.msj);
        //         console.log(rsp.msj);
        //     },
        //     complete: function() {
        //         me.data('requestRunning', false);
        //     }
        // });
    // });
}
</script>