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

$("#articulosal").on('change', function() {
    $idarticulo = $("#articulosal>option:selected").val();
    $iddeposito = $("#deposito>option:selected").val();
    // codigo referido a la muestra de lotes por articulos
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '<?php echo ALM ?>Lote/listarPorArticulo?arti_id=' + $idarticulo + '&depo_id=' +
            $iddeposito,
        success: function(result) {
            if (result == null) {
                var option_lote = '<option value="" disabled selected>Sin lotes</option>';
                // $('#deposito').html(option_depo);
                console.log("Sin lotes");
            } else {
                var option_lote = '<option value="" disabled selected>-Seleccione opcion-</option>';
                for (let index = 0; index < result.length; index++) {
                    option_lote += '<option value="' + result[index].lote_id + '">' + result[index]
                        .codigo +
                        '</option>';
                }
            }
            $('#lotesal').html(option_lote);
        },
        error: function() {
            alert('Error');
        }
    });
});

$("#articuloent").on('change', function() {
    $idarticulo = $("#articuloent>option:selected").val();
    $iddeposito = $("#deposito>option:selected").val();
    // codigo referido a la muestra de lotes por articulos
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '<?php echo ALM ?>Lote/listarPorArticulo?arti_id=' + $idarticulo + '&depo_id=' +
            $iddeposito,
        success: function(result) {
            if (result == null) {
                var option_lote = '<option value="" disabled selected>Sin lotes</option>';
                // $('#deposito').html(option_depo);
                console.log("Sin lotes");
            } else {
                var option_lote = '<option value="" disabled selected>-Seleccione opcion-</option>';
                for (let index = 0; index < result.length; index++) {
                    option_lote += '<option value="' + result[index].lote_id + '">' + result[index]
                        .codigo +
                        '</option>';
                }
            }
            $('#loteent').html(option_lote);
        },
        error: function() {
            alert('Error');
        }
    });
});

function guardar(){
    //esta funcion guarda el ajuste y espera un id_ajuste para luego llamar a otra funcion con este id que va a ser la encargada de guardar los datos especificos del lote (dependiendo si es entrada o salida) 
    var formdata = new FormData($("#formTotal")[0]);
    var formobj = formToObject(formdata);
    // console.log(formobj);
    $.ajax({
        type: 'POST',
        data: {
            data: formobj
        },
        url: '<?php echo ALM ?>Ajustestock/guardarAjuste',
        success: function(rsp) {
            if(!rsp){
                alert("error");
                return;
            }else{
                rsp = JSON.parse(rsp);
                //console.log(rsp);
                guardaAjusteDetalle(rsp,formobj);
            }
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        },
        complete: function() {}
    });
}

function guardaAjusteDetalle($rsp, $formobj){
    $formobj['ajus_id'] = $rsp.respuesta.ajus_id;
    $formobj['tipo_ent_sal'] = $("#tipoajuste>option:selected").attr("data");
    console.log($formobj);
    $.ajax({
        type: 'POST',
        data: {
            data: $formobj
        },
        url: '<?php echo ALM ?>Ajustestock/guardarDetalleAjuste',
        success: function(rsp) {
            if(!rsp){
                alert("error");
                return;
            }else{
                alert("Accion realizada con exito");
                setTimeout("linkTo()",1700);
            }
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        },
        complete: function() {}
    });
}
</script>