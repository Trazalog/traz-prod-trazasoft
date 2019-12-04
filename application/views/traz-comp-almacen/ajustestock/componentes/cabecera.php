<div class="box box-primary tag-descarga">
    <div class="box-header">
        <h3 class="box-title">Ajuste de Stock</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Establecimiento:</label>
                    <select class="form-control" id="establecimiento"
                        name="establecimiento" required>
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php                                               
                        foreach ($establecimientos as $i) {
                            echo '<option value="'.$i->nombre.'" class="emp" data-json=\''.json_encode($i).'\'>'.$i->nombre.'</option>';                            
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Deposito:</label>
                    <select class="form-control" id="deposito" name="deposito"
                        required>
                        <option value="" disabled selected>-Seleccione opcion-</option>

                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tipo de ajuste:</label>
                    <select class="form-control" id="tipoajuste" name="tipoajuste"
                        required>
                        <option value="" disabled selected>-Seleccione opcion-</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$.ajax({
    type: 'GET',
    dataType: 'json',
    url: 'general/Tipoajuste/obtenerAjuste',
    success: function(result) {

        if (!result.status) {
            alert("fallo");
            return;
        }
        result = result.data;
        var option_ajuste = '<option value="" disabled selected>-Seleccione opcion-</option>';
        for (let index = 0; index < result.length; index++) {
            option_ajuste += '<option value="' + result[index].nombre + '" data="' + result[index].tipo + '">' + result[index].nombre +
                '</option>';
        }
        $('#tipoajuste').html(option_ajuste);
    },
    error: function() {
        alert('Error');
    }
});

$("#establecimiento").on('change', function() {
    //console.log($("#establecimiento>option:selected").attr("data-json"));
    json = JSON.parse($("#establecimiento>option:selected").attr("data-json"));
    idestablecimiento = json.esta_id;
    //console.log(idestablecimiento);
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: 'general/Establecimiento/obtenerDepositos?esta_id=' + idestablecimiento,
        success: function(result) {
            if (result != null) {
                //console.log(result[0].descripcion);
                var option_depo = '<option value="" disabled selected>-Seleccione opcion-</option>';
                for (let index = 0; index < result.length; index++) {
                    option_depo += '<option value="' + result[index].descripcion + '">' + result[index].descripcion +
                        '</option>'
                }
                $('#deposito').html(option_depo);
            } else {
                var option_depo = '<option value="" disabled selected>Sin depositos</option>';
                $('#deposito').html(option_depo);
                console.log("El establecimiento no tiene depositos");
            }
        },
        error: function() {
            alert('Error');
        }
    });
});

$("#boxEntrada :input").prop("disabled", true);
$("#boxSalida :input").prop("disabled", true);

$("#tipoajuste").on('change', function() {
    //console.log($("#tipoajuste>option:selected").val());
    if($("#tipoajuste>option:selected").attr("data") == "ENTRADA"){
        //console.log("entro a entrada");
        $("#boxEntrada :input").prop("disabled", false);
        $("#boxEntrada").removeClass("box-default");
        $("#boxEntrada").addClass("box-primary");
        $('#boxEntrada').css('opacity', '');
        $('#boxSalida').css('opacity', '0.5');

        $("#boxSalida :input").prop("disabled", true);
        $("#boxSalida").removeClass("box-primary");
    }
    if($("#tipoajuste>option:selected").attr("data") == "SALIDA"){
        //console.log("entro a salida");
        $("#boxSalida :input").prop("disabled", false);
        $("#boxSalida").removeClass("box-default");
        $("#boxSalida").addClass("box-primary");

        $("#boxEntrada :input").prop("disabled", true);
        $("#boxEntrada").removeClass("box-primary");
        $('#boxSalida').css('opacity', '');
        $('#boxEntrada').css('opacity', '0.5');   
    }
    if($("#tipoajuste>option:selected").attr("data") == "E/S"){
        //console.log("entro a entrada/salida");
        $("#boxSalida :input").prop("disabled", false);
        $("#boxEntrada :input").prop("disabled", false);
        $("#boxEntrada").removeClass("box-default");
        $("#boxEntrada").addClass("box-primary");
        $("#boxSalida").removeClass("box-default");
        $("#boxSalida").addClass("box-primary");
        $('#boxEntrada').css('opacity', '');
        $('#boxSalida').css('opacity', '');
    }
});

</script>