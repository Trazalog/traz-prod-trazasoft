<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<div class="row">
	<div class="col-xs-2">
      <label style="margin-top: 7px;">Producto <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-9">
      <select class="form-control select2" id="prodId" style="width: 100%;" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>>
        <?php 
          foreach ($data['products'] as $p) {
            echo '<option value="'.$p['prodId'].'" '.($data['motion']['prodId'] == $p['prodId'] ? 'selected' : '').'>'.$p['prodDescription'].'</option>';
          }
        ?>
      </select>
    </div>
</div><br>
<div class="row">
	<div class="col-xs-2">
      <label style="margin-top: 7px;">Ajuste <strong style="color: #dd4b39">*</strong>: </label>
  </div>
	<div class="col-xs-9">
      <input type="text" class="form-control" placeholder="Cantidad" id="stkCant" value="<?php echo $data['motion']['stkCant'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
  </div>
</div><br>
<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Motivo <strong style="color: #dd4b39">*</strong>: </label>
  </div>
  <div class="col-xs-9">
      <input type="text" class="form-control" placeholder="Motivo" id="stkMotive" value="<?php echo $data['motion']['stkMotive'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
  </div>
</div>
</div>