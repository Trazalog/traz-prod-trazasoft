
<input class="hidden" type="number" id="peex_id" value="<?php echo $peex_id ?>">

<hr>
<h3>Pedido Extraordinario <small>Detalle del Pedido</small></h3>
<p class="text-danger"><?php echo @explode('&',$detalle)[0] ?></p>
<p class="text-danger"><?php echo @explode('&',$detalle)[1] ?></p>
<hr>

<form id="generic_form">
    <div class="form-group">
        <center>
            <h4 class="text-danger"> ¿Se Aprueba o Rechaza el Pedido de Materiales? </h4>
            <label class="radio-inline">
                <input type="radio" name="result" value="true" onclick="$('#motivo').hide();$('#hecho').prop('disabled',false);"> Aprobar
            </label>
            <label class="radio-inline">
                <input id="rechazo" type="radio" name="result" value="false" onclick="$('#motivo').show();$('#hecho').prop('disabled',false);"> Rechazar
            </label>
        </center>

    </div>

    <div id="motivo" class="form-group motivo">
        <textarea class="form-control" name="motivo_rechazo" placeholder="Motivo de Rechazo..."></textarea>
    </div>
</form>

<script>
    $('#motivo').hide();
    $('#hecho').prop('disabled',true);

    function cerrarTarea() {

        if($('#rechazo').prop('checked') && $('#motivo textarea').val() == ''){alert('Completar Motivo de Rechazo'); return;}

        var id = $('#idTarBonita').val();

        var dataForm = new FormData($('#generic_form')[0]);

        dataForm.append('peex_id', $('#peex_id').val());
        
        $.ajax({
            type: 'POST',
            data: dataForm,	
            cache: false,
			contentType: false,
			processData: false,
            url: '<?php base_url() ?>index.php/<?php echo ALM ?>Proceso/cerrarTarea/'+id,
            success: function (data) {
                //wc();
                back();

            },
            error: function (data) {
               alert("Error");
            }
        });

    }


</script>