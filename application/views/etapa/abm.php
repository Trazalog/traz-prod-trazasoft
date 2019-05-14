<div class="row">
    <div class="col-xs-12">
      <div class="box container-fluid">
        <div class="box-header">
          <h3 class="box-title"><?=$accion.' '.$op ?></h3>         
        </div><!-- /.box-header -->
        <div class="box-body">
           <div class="row">
               <div class="col-xs-1">
                <label for="Lote" class="form-label">Lote</label>
               </div>
               <div class="col-xs-5">
                <input type="text" id="Lote" class="form-control" placeholder="Inserte Lote">
               </div>
               <div class="col-xs-1">
                <label for="fecha" class="form-label">Fecha:</label>
               </div>
               <div class="col-xs-5">
                <input type="date" id="fecha" class="form-control">
               </div>
           </div>  
           <div class="row" style="margin-top: 50px">
               <div class="col-xs-2">
                <label for="establecimientos" class="form-label">Establecimiento:</label>
               </div>
               <div class="col-xs-4">
                <select class="form-control select2 select2-hidden-accesible" onchange="actualizaRecipiente()" id="establecimientos">
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
                <label for="Lote" class="form-label">Recipiente:</label>
               </div>
               <div class="col-xs-5" >
                    <select class="form-control" id="recipientes" disabled>
                    </select>
               </div>
           </div>   
           <div class="row" style="margin-top: 50px">
               <div class="col-xs-2">
                <label for="op" class="form-label">Orden de Produccion:</label>
               </div>
               <div class="col-xs-4">
               <input type="text" id="op" class="form-control" placeholder="Inserte Orde de Produccion">
               </div>
               <div class="col-xs-6">
               </div>
           </div>  
           <div class="row" style="margin-top: 40px">
           <div class="col-xs-12">
           <i class="glyphicon glyphicon-plus"></i><a onclick="despliega()" class="">Datos Adicionales</a>
             <div id="desplegable" hidden>
                  <h3>Lo que vaya aca</h3>
             </div>
             </div>
           </div>
           <div class="row" hidden id="incompleto">
            <div class="col-xs-12">
            <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-ban"></i> Datos incompletos</h4>
                 Algun dato no ha sido completado Revise el Formulario por favor.
                </div>
            </div>
           </div>
           <div class="row" style="margin-top: 40px ">
             <div class="col-xs-12">
             <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Calendario</a></li>
                  <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tareas</a></li>
                </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <p>Aca iria el Calendario</p>
              </div>
              <div class="tab-pane" id="tab_2">
             <div class="row form-group">
              <div class="col-xs-1">
                  <label for="tarea" class="form-label">Tarea:</label>
              </div>
              <div class="col-xs-5 input-group">
                  <select name="tarea" id="tarea" class="form-control select2">
                    <option disabled value="" selected>-Seleccione Tarea-</option>
                  </select>
                  <span class="input-group-btn">
                  <button class='btn btn-sm btn-primary' onclick='armaTabla("tabla1","divtabla",`<?php echo json_encode($establecimientos);?>`)'><i class="glyphicon glyphicon-search"></i></button>
                  </span>
              </div>
              <div class="col-xs-6"></div>
             </div>
             <div class="row form-group">
              <div class="col-xs-1">
                  <label for="template" class="form-label">Template:</label>
              </div>
              <div class="col-xs-5 input-group">
                  <select name="template" id="template" class="form-control select2">
                    <option disabled value="" selected>-Seleccione Template-</option>
                  </select>
                  <span class="input-group-btn">
                  <button class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i>Agregar</button>
                  </span>
              </div>
              <div class="col-xs-6"></div>
             </div>
             <div class="row">
                <div class="col-sm-12" id="divtabla">
                </div>
              </div>
              </div>
             
              </div>
              
            </div>
          </div>
         </div>
        </div>
           <div class="row">
             <div class="col-xs-10"></div>
             <div class="col-xs-2">
              <button class="btn btn-primary btn-block" onclick="guardar()">Guardar</button>
             </div>
           </div>   
         
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
  <script>

  function actualizaRecipiente()
  {
     
   establecimiento = document.getElementById('establecimientos').value;
   
    $.ajax({
      type: 'POST',
      data: { establecimiento:establecimiento },
      url: 'general/Recipiente/listarPorEstablecimiento', 
      success: function(result){
      result = JSON.parse(result);
      var html="";
       html = html +'<option value="" disabled selected>-Seleccione Recipiente-</option>';
       for(var i =0;i<result.length;i++)
       {
           html = html + '<option value="'+result[i].id+'">'+result[i].titulo+'</option>';
       }
        document.getElementById('recipientes').disabled = false;
        document.getElementById('recipientes').innerHTML = html;
      }
     
    });
    
  } 
  function despliega()
  {
    estado= document.getElementById('desplegable').hidden;
    if(estado)
    {
      document.getElementById('desplegable').hidden = false;
    } else{
      document.getElementById('desplegable').hidden = true;
    }
  }
  function guardar()
  {
    if (valida())
    {
     alert('todo bien');
    }else{
      document.getElementById('incompleto').hidden = false;
    }
  }
  function valida()
  {
    lote= document.getElementById('Lote').value;
    fecha= document.getElementById('fecha').value;
    establecimientos= document.getElementById('establecimientos').value;
    recipientes= document.getElementById('recipientes').value;
    op= document.getElementById('op').value;
    if (lote =="" || fecha =="" || establecimientos =="" || recipientes =="" || op =="")
    {
      return false;
    }else{
      return true;
    }
  }
  </script>
  