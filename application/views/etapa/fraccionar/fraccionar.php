<?php $this->load->view('camion/modal_lotes')?>
<?php $this->load->view('etapa/fraccionar/modal_productos')?>
<?php if($etapa->estado == "En Curso"){
$this->load->view('etapa/fraccionar/modal_finalizar');
}?>
<div class="box">
        <div class="box-header with-border">
          <h3><?php echo $lang["Fraccionar"];?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <div class="row" style="margin-top: 50px;" >
            <div class="col-md-1 col-xs-12">
            <label class="form-label">Fecha*:</label>
            </div>
            <div class="col-md-5 col-xs-12">
                <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control" <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
            </div>
            <div class="col-md-6 col-xs-12">
            </div>
         </div>
         <div class="row" style="margin-top: 50px">
               <div class="col-md-2 col-xs-12">
                <label for="establecimientos" class="form-label">Establecimiento*:</label>
               </div>
               <div class="col-md-4 col-xs-12">
                <select class="form-control select2 select2-hidden-accesible" onchange="actualizaRecipiente(this.value,'recipientes')" id="establecimientos" <?php if($etapa->estado == 'En Curso'){echo 'disabled';}?>>
                    <option value="" disabled selected>-Seleccione Establecimiento-</option>
                    <?php
                    foreach($establecimientos as $fila)
                    {
                      if($accion == 'Editar' && $fila->nombre == $etapa->establecimiento->titulo)
                      {
                      echo '<option value="'.$fila->esta_id.'" selected >'.$fila->nombre.'</option>';
                      }else
                      {
                        echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
                      }
                    } 
                    ?>
                </select>
               </div>
               <div class="col-md-1 col-xs-12">
                <label for="Recipiente" class="form-label"><?php echo $etapa->titulorecipiente;?>*:</label>
               </div>
               <div class="col-md-5 col-xs-12">
               <?php if($accion == 'Nuevo'){
                    echo '<select class="form-control" id="recipientes" disabled></select>';
                    }if($accion == 'Editar'){
                      if($etapa->estado == 'En Curso'){
                        echo '<select class="form-control" id="recipientes" disabled>';
                      }else
                      {
                        echo '<select class="form-control" id="recipientes">';
                      }
                      echo '<option value="" disabled selected>-Seleccione Recipiente-</option>';
                      foreach($recipientes as $recipiente)
                      {
                        if($recipiente->titulo == $etapa->recipiente)
                        {
                          echo '<option value="'.$recipiente->id.'" selected>'.$recipiente->titulo.'</option>';
                        }else{
                          echo '<option value="'.$recipiente->id.'" >'.$recipiente->titulo.'</option>';
                        }
                      }
                      echo '</select>';
                    }
                    ?>
            </div> 
           </div>
           <div class="row" style="margin-top: 40px">
            <div class="col-xs-12">
                 <i class="glyphicon glyphicon-plus" onclick="despliega()"></i><a onclick="despliega()" class="">Datos Adicionales</a>
                 <div id="desplegable" hidden>
                  <h3>Lo que vaya aca</h3>
                </div>
             </div>
           </div>
       </div>
    </div>
    <div class="box">
      <div class="box-header"><h4>Productos a Fraccionar</h4></div>
        <div class="box-body">
          <?php if($etapa->estado != 'En Curso'){?>
            <div class="row" style="margin-top: 40px">
              <div class="col-md-6 col-xs-12">
                <div class="row">
                  <div class="col-md-3 col-xs-12">
                      <label  class="form-label">Articulos:</label>      
                    </div>
                    <div class="col-md-9 col-xs-10 input-group">
                      <input list="productos" id="inputproductos" class="form-control" autocomplete="off">
                          <datalist id="productos">
                          <?php foreach($materias as $fila)
                          {
                          echo  "<option data-json='".json_encode($fila)."' value='".$fila->titulo."'>";
                          }
                          ?>
                          </datalist>
                      <span class="input-group-btn">
                          <button class='btn btn-sm btn-primary' 
                              onclick='checkTabla("tabla_productos","modalproductos",`<?php echo json_encode($materias);?>`,"Add")' data-toggle="modal" data-target="#modal_productos">
                              <i class="glyphicon glyphicon-search"></i></button>
                          </span>
                    </div>
                </div>
              </div>
              <div class="col-md-1 col-xs-12">
                <label  class="form-label">Stock:</label>  
              </div>
              <div class="col-md-3 col-xs-12">
                <input type="number" disabled id="stock" value="" class="form-control">
              </div>
              <div class="col-md-2 col-xs-12"></div>
            </div>
          
            <div class="row" style="margin-top: 50px">
                <div class="col-md-1 col-xs-12">
                    <label class="form-label">Empaque:</label>
                </div>
                <div class="col-md-5 col-xs-12">
                <select class="form-control select2 select2-hidden-accesible"  id="empaques" onchange="ActualizaEmpaques()">
                <option value="" disabled selected>-Seleccione Empaque-</option>
                    <?php
                      foreach($empaques as $fila)
                      { 
                        if($accion == 'Editar' && $etapa->empaque->titulo == $fila->titulo)
                        {
                          echo "<option data-json='".json_encode($fila)."' selected value='".$fila->id."'>".$fila->titulo."</option>";
                        }
                          else{
                          echo "<option data-json='".json_encode($fila)."' value='".$fila->id."'>".$fila->titulo."</option>";
                          }
                      } 
                    ?> 
                    </select>  
                </div>
                <div class="col-md-1 col-xs-12">
                <label class="form-label">Unidad:</label>
                </div>
                <div class="col-md-5 col-xs-12">
                    <input type="text" id="unidad" class="form-control" disabled>
                </div>
            </div>
            <div class="row" style="margin-top: 50px">
                <div class="col-md-1 col-xs-12">
                    <label class="form-label">Cantidad:</label>
                </div>
                <div class="col-md-5 col-xs-12">
                    <input type="number" id="cantidad"disabled onchange="CalculaStock()" class="form-control">
                </div>
                <div class="col-md-1 col-xs-12">
                <label class="form-label">Volumen:</label>
                </div>
                <div class="col-md-5 col-xs-12">
                    <input type="number" id="volumen" class="form-control" disabled>
                </div>
            </div>
            <hr>
              
                <div class="row">
                  <div class="col-md-2 col-xs-12" >  
                      <label class="form-label">Stock Necesario:</label>
                  </div>
                  <div class="col-md-2 col-xs-12">
                    <input type="number" id="calculo" class="form-control" disabled>
                  </div>
                  <div class="col-md-5"></div>
                  <div class="col-md-3 col-xs-12">
                      <button class="btn btn-block btn-success" onclick=ControlaProducto()>Agregar</button>
                  </div>
                </div>
                      <?}?>
                <div class="row" style="margin-top: 40px">
                  <input type="hidden" value="no" id="productoexiste">
                  <div class="col-xs-12 table-responsive" id="productosasignados"></div>
                </div>
            </div>
        
          <!-- /.box-body -->
          <div class="box-footer">
          <div class="row">
              <div class="col-md-8"></div>
              <div class="col-md-2 col-xs-6">
              <?php if($etapa->estado != 'En Curso')
              {
                echo '<button class="btn btn-primary btn-block" onclick="guardar()">Guardar</button>';
              }
              ?>
              </div>
              <div class="col-md-2 col-xs-6">
                <?php if($etapa->estado == 'planificado')
                {
                  echo '<button class="btn btn-primary btn-block" onclick="valida()">Iniciar Etapa</button>';
                }else if($etapa->estado == 'En Curso')
                {
                  echo '<button class="btn btn-primary btn-block" id="btnfinalizar" onclick="finalizar()">Finalizar Etapa</button>';
                }
                ?> 
            </div>
           </div>   
        </div>
        <!-- /.box-footer-->
 </div>
 <script>
 accion = '<?php echo $accion;?>';
if (accion == "Editar")
{
  var productos = <?php echo json_encode($etapa->productos);?>;

  for(i=0;i<productos.length;i++)
  { 
   producto =JSON.stringify(productos[i]);
   AgregaProducto(producto);
  }
}
 function actualizaRecipiente(establecimiento, recipientes)
  {
   establecimiento = establecimiento;
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
        document.getElementById(recipientes).disabled = false;
        document.getElementById(recipientes).innerHTML = html;
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
      $("#inputproductos").on('change', function(){
   ban =$("#productos option[value='" + $('#inputproductos').val() + "']").length;
   estado = '<?php echo $etapa->estado;?>';
   if(ban == 0)
    {
      alert('Producto Inexistente');
      document.getElementById('inputproductos').value = "";
      if(estado != 'En Curso')
      {
        document.getElementById('stock').value = "";
      }
    }else{
      if(estado == 'En Curso')
      {
       
      }else{
        producto = JSON.parse($("#productos option[value='" + $('#inputproductos').val() + "']").attr('data-json'));
        ActualizaProducto(producto);
      }
      }
 });

function ActualizaProducto(producto)
 {
 
  document.getElementById('inputproductos').value = producto.titulo;
  document.getElementById('stock').value = producto.stock;
 }
 function ActualizaEmpaques()
 {
  empaque = $( "#empaques option:selected" ).attr('data-json');
  empaque = JSON.parse(empaque);
  document.getElementById('unidad').value = empaque.unidad;
  document.getElementById('volumen').value = empaque.volumen;
  document.getElementById('cantidad').disabled = false;
 }
 function CalculaStock()
 {
  stock= document.getElementById('volumen').value * document.getElementById('cantidad').value;
  document.getElementById('calculo').value = stock;
 }
 function checkTabla(idtabla, idrecipiente, json, acciones)
{
  lenguaje = <?php echo json_encode($lang)?>;
  if(document.getElementById(idtabla)== null)
  {
    armaTabla(idtabla,idrecipiente,json,lenguaje,acciones);
  }
}
function ControlaProducto()
{
  msj="";
  ban = true;
  if(document.getElementById('inputproductos').value == "")
  {
    ban = false;
    msj +="No ha seleccionado Producto \n"
  }
  if(document.getElementById('empaques').value == "")
  {
    ban = false;
    msj +="No ha seleccionado Empaque \n"
  }
  if(document.getElementById('cantidad').value == "")
  {
    ban = false;
    msj +="No ha Ingresado Cantidad \n"
  }
  if(!ban)
  {
    alert(msj);
  }else{
  
    producto = JSON.parse($("#productos option[value='" + $('#inputproductos').val() + "']").attr('data-json'));
    empaque = $( "#empaques option:selected" ).attr('data-json');
    empaque = JSON.parse(empaque);
    producto.empaque = empaque.id;
    producto.empaquetitulo = empaque.titulo;
    producto.cantidad = document.getElementById('cantidad').value;
    producto = JSON.stringify(producto);
    AgregaProducto(producto);
    document.getElementById('inputproductos').value = "";
    document.getElementById('empaques').value = "";
    document.getElementById('cantidad').value = "";
    document.getElementById('unidad').value = "";
    document.getElementById('volumen').value = "";
    document.getElementById('cantidad').disabled = true;
  }
}
function AgregaProducto(producto)
{
  estado = '<?php echo $etapa->estado;?>';
  existe = document.getElementById('productoexiste').value;
  var html = '';
  producto = JSON.parse(producto);
  if(existe == 'no')
    {
        html +='<table id="tablaproductos" class="table">';
        html +="<thead>";
        html +="<tr>";
        if(estado != 'En Curso')
        {
          html +="<th>Acciones</th>";
        }
        if(estado == 'En Curso')
        {
          html +="<th>Lote</th>";
        }
        html +="<th>Titulo</th>";
        html +="<th>Empaque</th>";
        html +="<th>Cantidad</th>";
        html +='</tr></thead><tbody>';
        html += "<tr data-json='"+JSON.stringify(producto)+"' id='"+producto.id+"'>";
        if(estado != 'En Curso')
        {
         html += '<td><i class="fa fa-fw fa-minus text-light-blue tablaproductos_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
        }
        if(estado == 'En Curso')
        {
          html +="<td>"+producto.lote+"</td>";
        }
        html += '<td>'+producto.titulo+'</td>';
        html += '<td>'+producto.empaquetitulo+'</td>';
        html += '<td>'+producto.cantidad+'</td>';
        html += '</tr>';
        html += '</tbody></table>';
        
        document.getElementById('productosasignados').innerHTML = "";
        document.getElementById('productosasignados').innerHTML = html;
        $('#tablaproductos').DataTable({});
         document.getElementById('productoexiste').value = 'si';
     
          
    } else  if(existe == 'si')
    {
     
        html += "<tr data-json='"+JSON.stringify(producto)+"' id='"+producto.id+"'>";
        if(estado != 'En Curso')
        {
        html += '<td><i class="fa fa-fw fa-minus text-light-blue tablaproductos_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
        }
        if(estado == 'En Curso')
        {
          html +="<td>"+producto.lote+"</td>";
        }
        html += '<td>'+producto.titulo+'</td>';
        html += '<td>'+producto.empaquetitulo+'</td>';
        html += '<td>'+producto.cantidad+'</td>';
        html += '</tr>';
        $('#tablaproductos tbody').append(html);
        tabla = document.getElementById('tablaproductos').innerHTML;
        tabla = '<table id="tablaproductos" class="table table-bordered table-hover">' + tabla + '</table>';
        $('#tablaproductos').dataTable().fnDestroy();
        document.getElementById('productosasignados').innerHTML = "";
        document.getElementById('productosasignados').innerHTML = tabla;
        $('#tablaproductos').DataTable({});
    }
}

 function guardar()
  {
      fecha= document.getElementById('fecha').value;
      establecimiento= document.getElementById('establecimientos').value;
      recipiente= document.getElementById('recipientes').value;
      idetapa = <?php echo $etapa->id;?>;
      existe = document.getElementById('productoexiste').value;
      var productos =[];
    if(existe == "si")
    {
      $('#tablaproductos tbody').find('tr').each(function(){
        json="";
        json = $(this).attr('data-json');
        productos.push(json);
      });
      productos = JSON.stringify(productos);
    } 
     $.ajax({
      type: 'POST',
      data: { idetapa:idetapa, fecha:fecha,establecimiento: establecimiento, recipiente:recipiente, productos:productos },
      url: 'general/Etapa/guardarFraccionar', 
      success: function(result){
        if(result == "ok")
        {
          linkTo('general/Etapa/index');
         
        }else{
          alert('Ups! algo salio mal')
        }
        
      }
    
  }
);    
  }
  function finalizar()
  {
  html ='<select class="form-control" id="loteorigen">';   
  html += '<option value="" disabled selected>-Seleccione Lote-</option>';
  cont = 0;
  $('#tablaproductos tbody').find('tr').each(function(){
    lote = JSON.parse($(this).attr('data-json'));
    html+= "<option data-json='"+JSON.stringify(lote)+"' value='"+lote.lote+"'>"+lote.titulo+" "+lote.lote+"</option>";
      });
  html+='</select>';
  document.getElementById('divloteorigen').innerHTML = html;
$("#modal_finalizar").modal('show');
  }
 $(document).off('click', '.tablaproductos_borrar').on('click', '.tablaproductos_borrar',{ idtabla:'tablaproductos', idrecipiente:'productosasignados', idbandera:'productoexiste' }, remover);
 </script>