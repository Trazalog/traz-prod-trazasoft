<div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $lang["SalidaCamion"];?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
        <div class="row">
         <div class="col-xs-2">
                <label for="establecimientos" class="form-label">Establecimiento:</label>
               </div>
               <div class="col-xs-4">
                <select class="form-control select2 select2-hidden-accesible" id="establecimientos">
                    <option value="" disabled selected>-Seleccione Establecimiento-</option>
                    <?php
                    foreach($establecimientos as $fila)
                    {
                        echo '<option value="'.$fila->id.'" >'.$fila->titulo.'</option>';
                    } 
                    ?>
                </select>
               </div>
               <div class="col-xs-1">
                <label for="fecha" class="form-label">Fecha:</label>
               </div>
               <div class="col-xs-3">
                <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control">
               </div>
               <div class="col-xs-2"></div>
         </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
 </div>