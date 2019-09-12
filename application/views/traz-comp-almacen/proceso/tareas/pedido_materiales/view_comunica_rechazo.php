<h4>Motivo Rechazo</h4>
<p1 id="motivo" class="text-danger"> <?php echo $info->motivo ?> </p1>
<hr>
<form id="generic_form">
    <div class="form-group">
        <center>
            <h4 class="text-danger"> ¿Desea Repertir el Pedido de Materiales? </h4>
            <label class="radio-inline">
                <input type="radio" name="result" value="true"
                    onclick="$('#view_pedidoMateriales').show();$('#hecho').prop('disabled',false);"> Si
            </label>
            <label class="radio-inline">
                <input id="rechazo" type="radio" name="result" value="false"
                    onclick="$('#view_pedidoMateriales').hide();$('#hecho').prop('disabled',false);"> No, Gracias
            </label>
        </center>
    </div>
</form>
<hr>
<div id="view_pedidoMateriales">
<?php echo $this->load->view(CMP_ALM.'/proceso/tareas/componentes/pedido_materiales',null,true); ?>
</div>
<script>

$('#view_pedidoMateriales').hide();
 function cerrarTarea() {

var id = $('#idTarBonita').val();

var dataForm = new FormData($('#generic_form')[0]);

dataForm.append('pema_id', $('#pema_id').val());

$.ajax({
    type: 'POST',
    data: dataForm,	
    cache: false,
    contentType: false,
    processData: false,
    url: '<?php base_url() ?>index.php/almacen/Proceso/cerrarTarea/'+id,
    success: function (data) {
        linkTo('Tarea');
    },
    error: function (data) {
       alert("Error");
    }
});

}
</script>