<div class="box">
        <div class="box-header with-border">
          <h3><?php echo $lang["SalidaCamion"];?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
        <div class="row">
         <div class="col-md-2 col-xs-12">
                <label for="establecimientos" class="form-label">Establecimiento*:</label>
               </div>
               <div class="col-md-4 col-xs-12">
                <select class="form-control select2 select2-hidden-accesible" id="establecimientos">
                    <option value="" disabled selected>-Seleccione Establecimiento-</option>
                    <?php
                    foreach($establecimientos as $fila)
                    {
                        echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
                    } 
                    ?>
                </select>
               </div>
               <div class="col-md-1 col-xs-12">
                <label for="fecha" class="form-label">Fecha*:</label>
               </div>
               <div class="col-md-3 col-xs-12">
                <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control">
               </div>
               <div class="col-md-2"></div>
         </div>
      </div>
    </div>
    <div class="box">
      <div class="box-header"><h4>Datos camion</h4></div>
       <div class="box-body">
         <div class="row" style="margin-top:40px">
             <div class="col-md-1 col-xs-12"><label class="form-label">Patente*:</label></div>
             <div class="col-md-2 col-xs-12"><input list="patentes" class="form-control" id="patente" autocomplete="off">
                <datalist id="patentes">
                        <?php foreach($camiones as $fila)
                        {
                        echo  "<option data-json='".json_encode($fila)."' value='".$fila->patente."'></option>";
                        }
                        ?>
                    </datalist>
              </div>
             <div class="col-md-1 col-xs-12"><label class="form-label" >Acoplado*:</label></div>
             <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="acoplado" disabled></div>
             <div class="col-md-1 col-xs-12"><label class="form-label" >Conductor*:</label></div>
             <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="conductor" disabled></div>
             <div class="col-md-1 col-xs-12"><label class="form-label" >Tipo*:</label></div>
             <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="tipo" ></div>
         </div>
         <hr>
         <div class="row" style="margin-top:40px">
             <div class="col-md-1 col-xs-12"><label class="form-label">Bruto*:</label></div>
             <div class="col-md-3 col-xs-12"><input type="text" class="form-control" id="bruto"></div>
             <div class="col-md-1 col-xs-12"><label class="form-label">Tara*:</label></div>
             <div class="col-md-3 col-xs-12"><input type="text" class="form-control" id="tara"></div>
             <div class="col-md-1 col-xs-12"><label class="form-label">Neto*:</label></div>
             <div class="col-md-3 col-xs-12"><input type="text" class="form-control" id="neto"></div>
         </div>
         <hr>
      </div>
    </div>
    <div class="box">
      <div class="box-header"><h4>Productos</h4></div>
       <div class="box-body">
       <div class="row" style="margin-top:40px">
         <div class="col-xs-12 table-responsive" id="tablaproductos"></div>
       </div>
       <div class="row" style="margin-top:40px">
         <div class="col-xs-12" >
                  <label for="">Observacion:</label>
                <textarea id="observacion" class="form-control" placeholder="Detalles extra" cols="30" rows="5"></textarea>
         </div>
       </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="row">
           <div class="col-md-10 col-xs-6"></div>
           <div class="col-md-2 col-xs-6">
                <button class="btn btn-success btn-block" function="guardar()">Aceptar</button>
            </div>
          </div>
        </div>
        <!-- /.box-footer-->
 </div>
 <script>
 $("#patente").on('change', function(){
   ban =$("#patentes option[value='" + $('#patente').val() + "']").length;
   
   if(ban == 0)
    {
      alert('Patente Inexistente');
      document.getElementById('patente').value = "";
      document.getElementById('acoplado').value = "";
      document.getElementById('conductor').value = "";
      document.getElementById('acoplado').disabled = true;
      document.getElementById('conductor').disabled = true;
    }else{
        camion = JSON.parse($("#patentes option[value='" + $('#patente').val() + "']").attr('data-json'));
       productos=[];
       for(i=0;i<camion.productos.length;i++)
       {
         producto = {};
         producto.id = camion.productos[i].id;
         producto.producto = camion.productos[i].titulo;
         producto.empaque= camion.productos[i].empaquetitulo;
         producto.cantidad = camion.productos[i].cantidad;
         producto.lote = camion.productos[i].lote;
         productos.push(producto);
       }
       document.getElementById('acoplado').value = camion.acoplado;
       document.getElementById('conductor').value = camion.conductor;
       document.getElementById('acoplado').disabled = false;
       document.getElementById('conductor').disabled = false;
       lenguaje = <?php echo json_encode($lang)?>;
       json = JSON.stringify(productos);
       armaTabla('tabla_productos','tablaproductos',json,lenguaje);
    }
 });

 </script>