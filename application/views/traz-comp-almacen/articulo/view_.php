<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<!-- Código de Articulo -->
<div class="row">
  <div class="col-xs-12 col-sm-4">
    <label style="margin-top: 7px;">Código <strong style="color: #dd4b39">*</strong>: </label>
  </div>
  <div class="col-xs-12 col-sm-8">
    <input type="text" class="form-control" id="artBarCode" value="<?php echo $data['article']['barcode'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
  </div>
</div><br>

<!-- Código del Artículo -->
<div class="row">
  <div class="col-xs-12 col-sm-4">
    <label style="margin-top: 7px;">Descripción <strong style="color: #dd4b39">*</strong>: </label>
  </div>
  <div class="col-xs-12 col-sm-8">
    <input type="text" class="form-control" id="artDescription" value="<?php echo $data['article']['descripcion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
  </div>
</div><br>

<!-- Descripción del Artículo -->
<div class="row">
  <div class="col-xs-10 col-sm-4">
    <label style="margin-top: 7px;">Se Compra x Caja: </label>
  </div>
  <div class="col-xs-2 col-sm-1">
    <input type="checkbox" id="artIsByBox" style="margin-top:10px;" <?php echo($data['article']['es_caja'] == true ? 'checked': ''); ?> <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
  </div>
  <div class="col-xs-12 col-sm-3">
    <label style="margin-top: 7px;" class="unidades">Unidades <strong style="color: #dd4b39">*</strong>: </label>
  </div>
  <div class="col-xs-12 col-sm-4">
    <input type="text" class="form-control unidades" id="artCantBox" value="<?php echo $data['article']['cantidad_caja'];?>" <?php echo (($data['article']['es_caja'] != true || ($data['action'] == 'View' || $data['action'] == 'Del'))? 'disabled="disabled"' : '');?>  >
  </div>
</div><br>
<div class="row hidden">
  <div class="col-xs-12 col-sm-4">
    <label style="margin-top: 7px;">Estado: </label>
  </div>
  <div class="col-xs-12 col-sm-8">
    <select class="form-control hidden" id="artEstado"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
    <option value="1">Activo</option>;
    </select>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-4">
    <label style="margin-top: 7px;">Unidad de medida <strong style="color: #dd4b39">*</strong>: </label>
  </div>
  <div class="col-xs-12 col-sm-8">
    <select  class="form-control" id="unidmed" name="unidmed" value="">
    </select>
  </div>
</div><br>

<div class="row">
  <div class="col-xs-12 col-sm-4">
    <label style="margin-top: 7px;">Punto de pedido:</label>
  </div>
  <div class="col-xs-12 col-sm-8">
    <input type="text" name="puntped" id="puntped" class="form-control">
  </div>
</div><br>
  
<div class="row">
    <div class="col-xs-12 col-sm-4">
        <label style="margin-top: 7px;">¿Lotear Artículo?</label>
    </div>
    <div class="col-xs-12 col-sm-8">
        <input type="checkbox" name="es_loteado" id="es_loteado"  <?php echo($data['article']['es_loteado'] == true ? 'checked': ''); ?>>
    </div>
</div> <!-- /.modal-body -->
 
<script>


$('#artIsByBox').click(function() {
  if($(this).is(':checked')){
    $('#artCantBox').prop('disabled',false);
  } else {
    $('#artCantBox').val('');
    $('#artCantBox').prop('disabled',true);
  }
});


traer_unidad();
function traer_unidad(){
  $.ajax({
    type: 'POST',
    data: { },
    url: 'index.php/almacen/Articulo/getdatosart', 
    success: function(data){
      var opcion  = "<option value='-1'>Seleccione...</option>" ; 
      $('#unidmed').append(opcion); 
      for(var i=0; i < data.length ; i++) 
      {    
        var nombre = data[i]['descripcion'];
        var opcion  = "<option value='"+data[i]['id_unidadmedida']+"'>" +nombre+ "</option>" ; 
        $('#unidmed').append(opcion); 
      }
    },
    error: function(result){
      console.log(result);
    },
    dataType: 'json'
  });
}

</script>