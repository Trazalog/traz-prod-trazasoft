<div class="modal" id="modal_finalizar" tabindex="-1" role="dialog" style="overflow-y: auto !important; " aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Finalizar Etapa</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
      <div class="row">
          <div class="col-md-3 col-xs-12"><label class="form-label">Codigo Lote Origen:</label></div>
          <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="loteorigen" value="<?php echo $etapa->lote;?>" disabled></div>
          <div class="col-md-5"></div>
      </div>
      <div class="row form-group" style="margin-top:20px">
   <div class="col-md-3 col-xs-12">
     <label for="Producto" class="form-label">Producto*:</label>
  </div>
   <div class="col-md-6 col-xs-12 input-group">
      <input list="Productos" id="inputproducto" class="form-control" autocomplete="off">
      <input type="hidden" id="idproducto" value="" data-json="">
       <datalist id="Productos">
        <?php foreach($materias as $fila)
         {
           echo  '<option value="'.$fila->titulo.'">';
          }
          ?>
        </datalist>
        <span class="input-group-btn">
          <button class='btn btn-sm btn-primary' 
            onclick='checkTabla("tablaproductos","modalproductos",`<?php echo json_encode($materias);?>`,"Add")' data-toggle="modal" data-target="#modal_producto">
            <i class="glyphicon glyphicon-search"></i></button>
           </span> 
      </div>
      <div class="col-md-3"></div>
      </div>
      <div class="row" style="margin-top:20px">
          <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad*:</label></div>
          <div class="col-md-4 col-xs-12"><input class="form-control" id="cantidadproducto" type="text" value="" placeholder ="Inserte Cantidad"></div>
          <div class="col-md-5"></div>
      </div>
      <div class="row" style="margin-top:20px">
          <div class="col-md-3 col-xs-12"><label class="form-label">Lote Destino*:</label></div>
          <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="lotedestino" value="" placeholder ="Inserte Lote destino"></div>
          <div class="col-md-4 col-xs-12"><button class="btn btn-primary btn-block" onclick="copiaOrigen()">Copiar Lote Origen</button></div>
          <div class="col-md-1"></div>
      </div>
      <div class="row" style="margin-top:20px">
          <div class="col-md-3 col-xs-12"><label class="form-label">Destino*:</label></div>
          <div class="col-md-6 col-xs-12">
          <?php if($accion == 'Editar'){
                      echo '<select class="form-control" id="productodestino">';
                      echo '<option value="" disabled selected>-Seleccione Destino-</option>';
                      foreach($recipientes as $recipiente)
                      {
                          echo '<option value="'.$recipiente->id.'" >'.$recipiente->titulo.'</option>';
                      }
                      echo '</select>';
                    }
                    ?>
          </div>
          <div class="col-md-3"></div>
      </div>
      <div class="row" style="margin-top: 20px">
               <div class="col-md-3 col-xs-12">
                <label for="establecimientos" class="form-label">Establecimiento Final:</label>
               </div>
               <div class="col-md-6 col-xs-12">
                <select class="form-control select2 select2-hidden-accesible" onchange="actualizaRecipiente(this.value, 'productorecipientes')" id="productoestablecimientos">
                    <option value="" disabled selected>-Seleccione Establecimiento-</option>
                    <?php
                    foreach($establecimientos as $fila)
                    {
                        echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
                    } 
                    ?>
                </select>
                
               </div>
               <div class="col-md-3"></div>
            </div>
            <div class="row" style="margin-top: 20px">
               <div class="col-md-3 col-xs-12">
                <label for="establecimientos" class="form-label">Recipiente Final:</label>
               </div>
               <div class="col-md-6 col-xs-12">
                <select class="form-control select2 select2-hidden-accesible"  id="productorecipientes" disabled>
                <option value="" disabled selected>-Seleccione Establecimiento-</option>
                </select>
               </div>
               <div class="col-md-3"></div>
            </div>
     <div class="row" style="margin-top:20px">
          <div class="col-md-3 col-xs-12"><label class="form-label">Requiere Fraccionada:</label></div>
          <div class="col-md-1 col-xs-12"><input  type="checkbox" id="fraccionado" value=""></div>
          <div class="col-md-8"></div>
      </div>
      <div class="row" style="margin-top:20px">
          <div class="col-md-3 col-xs-12"></div>
          <div class="col-md-3 col-xs-12"><button class="btn btn-success btn-block" onclick="AgregarProducto()">Agregar</button></div>
          <div class="col-md-6"></div>
      </div>
      <div class="row">
      <input type="hidden" value="no" id="productos_existe">
             <div class="col-xs-12 table-responsive" id="productosasignados">
             </div>
         </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-8"></div>
          <div class="col-md-2 col-xs-6">
           <button type="button" class="btn btn-success btn-block " onclick="FinalizarEtapa()">Aceptar</button>
          </div>
          <div class="col-md-2 col-xs-6">
          <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script>
  function AgregarProducto()
  {
     ban = true;
     productoid = document.getElementById('idproducto').value;
     if(productoid == "")
     {
         ban = false;
     }
     cantidad = document.getElementById('cantidadproducto').value;
     if(cantidad== "")
     {
         ban = false;
     }
     lotedestino = document.getElementById('lotedestino').value;
     if(lotedestino == "")
     {
         ban = false;
     }
     destino = document.getElementById('productodestino').value;
     if(destino == "")
     {
         ban = false;
     }
     if(!ban){
    alert("falto algun dato obligatorio");
     } else{
        establecimiento = "";
        var producto = {};   
        producto.establecimientofinal = "";
        if(document.getElementById('productoestablecimientos').value != "")
        {
        establecimientos = '<?php echo json_encode($establecimientos);?>';
        establecimientos = JSON.parse(establecimientos);
        idestablecimiento = document.getElementById('productoestablecimientos').value;
        index = establecimientos.findIndex(x => x.id == idestablecimiento);
        establecimiento = establecimientos[index].titulo;
        producto.establecimientofinal = document.getElementById('productoestablecimientos').value;
        }
        recipientefinal ="";
        producto.recipientefinal ="";
        if(document.getElementById('productorecipientes').value != "")
        {
          recipientefinal = document.getElementById('productorecipientes').options[document.getElementById('productorecipientes').selectedIndex].innerHTML;
          producto.recipientefinal =document.getElementById('productorecipientes').value;
        }

        recipientes = '<?php echo json_encode($recipientes);?>';
        recipientes = JSON.parse(recipientes);
        idrecipiente= document.getElementById('productodestino').value;
        indexrec = recipientes.findIndex(y => y.id == idrecipiente);    
        producto.id = productoid;
        producto.titulo = document.getElementById('inputproducto').value;
        producto.cantidad = cantidad;
        producto.loteorigen = document.getElementById('loteorigen').value;
        producto.lotedestino = lotedestino;
        producto.destino = destino;
        producto.titulodestino = recipientes[indexrec].titulo;
        producto.destinofinal = establecimiento +" "+ recipientefinal;
        fraccionado = document.getElementById('fraccionado').checked;
        if(fraccionado)
        {
          producto.fraccionado = 'Si';
        }else{
          producto.fraccionado = 'No';
        }
        agregaProducto(producto);
        document.getElementById('idproducto').value = "";
        document.getElementById('cantidadproducto').value ="";
        document.getElementById('lotedestino').value ="";
        document.getElementById('productodestino').value ="";
        document.getElementById('productoestablecimientos').value ="";
        document.getElementById('inputproducto').value ="";
        document.getElementById('fraccionado').checked = false;
        document.getElementById('productorecipientes').value="";
        document.getElementById('productorecipientes').disabled = true;
     }
  }
  function agregaProducto(producto)
  {
  existe = document.getElementById('productos_existe').value;
  var html = '';
   if(existe == 'no')
   {
   
      html +='<table id="tabla_productos_asignados" style="width: 90%;" class="table">';
      html +="<thead>";
      html +="<tr>";
      html +="<th>Acciones</th>";
      html +="<th>Lote</th>";
      html +="<th>Producto</th>";
      html +="<th>Cantidad</th>";
      html +="<th>Lote Destino</th>";
      html +="<th>Destino</th>";
      html +="<th>Destino Final</th>";
      html +="<th>Fracc</th>";
      html +='</tr></thead><tbody>';
      html += "<tr data-json='"+JSON.stringify(producto)+"' id='"+producto.id+"'>";
      html += '<td><i class="fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
      html += '<td>'+producto.loteorigen+'</td>';    
      html += '<td>'+producto.titulo+'</td>';
      html += '<td>'+producto.cantidad+'</td>';
      html += '<td>'+producto.lotedestino+'</td>';
      html += '<td>'+producto.titulodestino+'</td>';
      html += '<td>'+producto.destinofinal+'</td>';
      html += '<td>'+producto.fraccionado+'</td>';
      html += '</tr>';
      html += '</tbody></table>';
      document.getElementById('productosasignados').innerHTML = "";
      document.getElementById('productosasignados').innerHTML = html;
      $('#tabla_productos_asignados').DataTable({});
        document.getElementById('productos_existe').value = 'si';
        
   } else  if(existe == 'si')
   {
      html += "<tr data-json='"+JSON.stringify(producto)+"' id='"+producto.id+"'>";
      html += '<td><i class="fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
      html += '<td>'+producto.loteorigen+'</td>';   
      html += '<td>'+producto.titulo+'</td>';
      html += '<td>'+producto.cantidad+'</td>';
      html += '<td>'+producto.lotedestino+'</td>';
      html += '<td>'+producto.titulodestino+'</td>';
      html += '<td>'+producto.destinofinal+'</td>';
      html += '<td>'+producto.fraccionado+'</td>';
      html += '</tr>';
      $('#tabla_productos_asignados tbody').append(html);
      tabla = document.getElementById('tabla_productos_asignados').innerHTML;
      tabla = '<table id="tabla_productos_asignados" class="table table-bordered table-hover">' + tabla + '</table>';
      $('#tabla_productos_asignados').dataTable().fnDestroy();
      document.getElementById('productosasignados').innerHTML = "";
      document.getElementById('productosasignados').innerHTML = tabla;
      $('#tabla_productos_asignados').DataTable({});
       
   }
  }
  function copiaOrigen()
  {
    document.getElementById('lotedestino').value =  document.getElementById('loteorigen').value;
  }
  $("#inputproducto").on('change', function () {
    materias = <?php echo json_encode($materias)?>;
 titulo = document.getElementById('inputproducto').value;
 ban = false;
i=0;
      while(!ban && i<materias.length)
      {
        if(titulo == materias[i].titulo)
        {
          ban = true;
          materia = materias[i];
        }
        i++;
      }
      if(ban)
     {
       console.log(materia);
      document.getElementById('idproducto').value = materia.id;
     } else{
       alert('No existe esa Producto');
       
     }
 
  });
  function FinalizarEtapa()
  {
    existe = document.getElementById('productos_existe').value;
    if(existe == "no")
    {
      alert("No ha agregado ningun producto final");
    }else{
      var productos =[];
      $('#tabla_productos_asignados tbody').find('tr').each(function(){
        json="";
        json = $(this).attr('data-json');
        productos.push(json);
      });
      productos = JSON.stringify(productos);
      $.ajax({
      type: 'POST',
      async: false,
      data: { productos: productos },
      url: 'general/Etapa/Finalizar', 
      success: function(result){
      document.getElementById('btnfinalizar').style.display = "none";
      $("#modal_finalizar").modal('hide');
      }
     
    });
    }
  }
  $(document).off('click', '.tabla_productos_asignados_borrar').on('click', '.tabla_productos_asignados_borrar',{ idtabla:'tabla_productos_asignados', idrecipiente:'productosasignados', idbandera:'productos_existe' }, remover);
</script>
  