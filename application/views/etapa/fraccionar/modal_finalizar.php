<div class="modal" id="modal_finalizar" data-backdrop="static" tabindex="-1" role="dialog" style="overflow-y: auto !important; " aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Reporte de Fraccionamiento</h4>
        <input class="hidden" type="text" id="num_orden_prod" value="<?php echo $etapa->orden;?>">
      </div>

      <div class="modal-body" id="modalBodyArticle">
      <!-- <div class="row">
          <div class="col-md-3 col-xs-12"><label class="form-label">Lote a fraccionar:</label></div>
          <div class="col-md-9 col-xs-12" id="divloteorigen"></div>
      </div> -->
      
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Lotes para Fraccionamiento</div>
        <div class="panel-body">

        <div class="row">
          <div class="col-md-3 col-xs-12"><label class="form-label">Lote a fraccionar:</label></div>
          <div class="col-md-9 col-xs-12" id="selLoteOrigen"></div>
          <div class="col-md-8 col-xs-12">
            <?php if($accion == 'Editar'){
                    echo '<select class="form-control" id="loteorigen">';
                    echo '<option value="" disabled selected>-Seleccione Lote-</option>';
                    foreach($lotesFracc as $lote)
                    {
                        echo '<option value="'.$lote->codigo.'" >LOTE: '.$lote->codigo.' / '.$lote->art_nombre.'</option>';
                    }
                    echo '</select>';
                  }
            ?>
          </div>      
      </div>




        </div>

      </div>


  <div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Productos Fraccionados</div>
    <div class="panel-body">
      
   <div class="row form-group" style="margin-top:20px">
   <div class="col-md-3 col-xs-12">
     <label for="Producto" class="form-label">Producto:</label>
   </div>
   <div class="col-md-8 col-xs-12 input-group">
      <input list="productos" id="inputproductos" class="form-control" autocomplete="off">
      <datalist id="productos">
      <?php foreach($materias as $fila)
        {
          echo  "<option data-json='".json_encode($fila)."'value='".$fila->titulo."'>";
        }
        ?>
      </datalist>
      <span class="input-group-btn">
        <button class='btn btn-sm btn-primary' 
          onclick='checkTabla("tabla_productos","modalproductos",`<?php echo json_encode($materias);?>`,"Add")' data-toggle="modal" data-target="#modal_productos">
          <i class="glyphicon glyphicon-search"></i></button>
      </span> 
   </div>
    <div class="col-md-3"></div>
    </div>
    <div class="row" style="margin-top:20px">
        <div class="col-md-3 col-xs-12"><label class="form-label">Cantidad:</label></div>
        <div class="col-md-4 col-xs-12"><input class="form-control" id="cantidadproducto" type="text" value="" placeholder ="Inserte Cantidad"></div>
        <div class="col-md-5"></div>
    </div>
    <div class="row" style="margin-top:20px">
        <div class="col-md-3 col-xs-12"><label class="form-label">Codigo Lote Destino:</label></div>
        <div class="col-md-4 col-xs-12"><input class="form-control" type="text" id="lotedestino" value="" placeholder ="Inserte Lote destino"></div>
        <div class="col-md-4 col-xs-12"><button class="btn btn-primary btn-block" onclick="copiaOrigen()">Copiar Lote Origen</button></div>
        <div class="col-md-1"></div>
    </div>
    <div class="row" style="margin-top:20px">
        <div class="col-md-3 col-xs-12"><label class="form-label">Destino:</label></div>
        <div class="col-md-6 col-xs-12">
        <?php if($accion == 'Editar'){
                    echo '<select class="form-control" id="productodestino">';
                    echo '<option value="" disabled selected>-Seleccione Destino-</option>';
                    foreach($recipientes as $recipiente)
                    {
                        echo '<option value="'.$recipiente->reci_id.'" >'.$recipiente->nombre.'</option>';
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
               <div class="col-md-3 col-xs-12"></div>
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
               <div class="col-md-3 col-xs-12"></div>
            </div>
     <div class="row" style="margin-top:20px">
          <div class="col-md-3 col-xs-12"><label class="form-label">Requiere Fraccionada:</label></div>
          <div class="col-md-1 col-xs-12"><input  type="checkbox" id="fraccionado" value=""></div>
          <div class="col-md-8 "></div>
      </div>
      <div class="row" style="margin-top:20px">
          <div class="col-md-3 col-xs-12"></div>
          <div class="col-md-3 col-xs-12"><button class="btn btn-success btn-block" onclick="AgregarProductoFinal()">Agregar</button></div>
          <div class="col-md-6 "></div>
      </div>
      <div class="row">
       
      
      <input type="hidden" value="no" id="productos_existe">
             <div class="col-xs-12 table-responsive" id="productosasignadosfin">
             </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnfinalizar" onclick="FinalizarEtapa()">Finalizar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
  </div>


  </div>  
  </div> 


  <script>
  
  function AgregarProductoFinal()
  {
    cantidad = document.getElementById('cantidadproducto').value;
    if( cantidad == 0)
    {
      //if(document.getElementById('loteorigen').value != "")
     // {
        producto ={};
        producto.id = '-';
        producto.titulo = '-';
        producto.cantidad = '-';
        producto.loteorigen = document.getElementById('loteorigen').value;
        producto.lotedestino = '-';
        producto.destino = '-';
        producto.titulodestino = '-';
        producto.destinofinal = '-';
        producto.fraccionado= '-';
        agregaProductoFinal(producto);
        document.getElementById('cantidadproducto').value ="";
        document.getElementById('lotedestino').value ="";
        document.getElementById('productodestino').value ="";
        document.getElementById('productoestablecimientos').value ="";
        document.getElementById('inputproductos').value ="";
        document.getElementById('fraccionado').checked = false;
        document.getElementById('productorecipientes').value="";
        document.getElementById('productorecipientes').disabled = true;
      // }else{
      //   alert('Seleccione lote origen');
      // }
    }else{
      ban = true;
      msj="";
        //  if(document.getElementById('loteorigen').value == "")
        //  {
        //   msj +="Falto seleccionar Lote Origen \n";
        //     ban = false;
        //  }
      producto = document.getElementById('inputproductos').value;
     
      // validacion de campos vacios    
        if(producto == "")
        {
            msj +="Falto ingresar Producto de salida \n";
            ban = false;
        }
        cantidad = document.getElementById('cantidadproducto').value;
        if(cantidad== "")
        {
          msj +="Falto ingresar Cantidad del Producto de salida \n";        
            ban = false;
        }
        lotedestino = document.getElementById('lotedestino').value;
        if(lotedestino == "")
        {
            msj +="Falto ingresar lote destino \n"; 
            ban = false;
        }
        destino = document.getElementById('productodestino').value;
        if(destino == "")
        {
          msj +="Falto ingresar el destino del producto \n";        
            ban = false;
        }

     if(!ban){
      alert(msj);
     } else{
       
        establecimiento = "";
        var producto = {};   
        producto.establecimientofinal = "";
        if(document.getElementById('productoestablecimientos').value != "")
        {
          establecimientos = '<?php echo json_encode($establecimientos);?>';
          establecimientos = JSON.parse(establecimientos);
          idestablecimiento = document.getElementById('productoestablecimientos').value;
          index = establecimientos.findIndex(x => x.esta_id == idestablecimiento);
          establecimiento = establecimientos[index].nombre;
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
        console.log("recipientes: ");  
        console.table(recipientes);
        idrecipiente= document.getElementById('productodestino').value;
        //indexrec = recipientes.findIndex(y => y.id == idrecipiente);    
        indexrec = recipientes.findIndex(y => y.reci_id == idrecipiente);    
        producto.id = JSON.parse($("#productos option[value='" + $('#inputproductos').val() + "']").attr('data-json')).id;
        producto.titulo = document.getElementById('inputproductos').value;
        producto.cantidad = cantidad;
        producto.loteorigen = document.getElementById('loteorigen').value;
        producto.lotedestino = lotedestino;
        producto.destino = destino;
        // producto.titulodestino = recipientes[indexrec].titulo;
        producto.titulodestino = recipientes[indexrec].nombre;
        producto.destinofinal = establecimiento +" "+ recipientefinal;
        fraccionado = document.getElementById('fraccionado').checked;
        if(fraccionado)
        {
          producto.fraccionado = 'Si';
        }else{
          producto.fraccionado = 'No';
        }
        agregaProductoFinal(producto);
        document.getElementById('cantidadproducto').value ="";
        document.getElementById('lotedestino').value ="";
        document.getElementById('productodestino').value ="";
        document.getElementById('productoestablecimientos').value ="";
        document.getElementById('inputproductos').value ="";
        document.getElementById('fraccionado').checked = false;
        document.getElementById('productorecipientes').value="";
        document.getElementById('productorecipientes').disabled = true;
     }
    }
  }
  function agregaProductoFinal(producto)
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
          document.getElementById('productosasignadosfin').innerHTML = "";
          document.getElementById('productosasignadosfin').innerHTML = html;
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
          document.getElementById('productosasignadosfin').innerHTML = "";
          document.getElementById('productosasignadosfin').innerHTML = tabla;
          $('#tabla_productos_asignados').DataTable({});
          
      }
  }
  function copiaOrigen()
  {
    document.getElementById('lotedestino').value =  document.getElementById('loteorigen').value;
  }
  // finaliza reporte de fraccionamiento
  function FinalizarEtapa()
  {
    existe = document.getElementById('productos_existe').value;
    if(existe == "no")
    {
      alert("No ha agregado ningun producto final");
    }else{
        ops = document.getElementById('loteorigen').options;
        var lotes =[];
        for(i=0;i<ops.length;i++)
        {
          lotes.push(ops[i].value);
        }
        lotes.shift();
        lotesasignados =[];
        for(i=0;i<lotes.length;i++)
        {
          if($('#tabla_productos_asignados tr > td:nth-child(2):contains('+lotes[i]+')').length > 0)
          {
            lotesasignados.push(lotes[i]);
          }
        }
        diferencia = lotes.filter(x => !lotesasignados.includes(x));
        // if(diferencia.length == 0)
        // {
          var productos =[];
          var acum_cant = 0;
          $('#tabla_productos_asignados tbody').find('tr').each(function(){
            json="";
            json = $(this).attr('data-json');
            temp = JSON.parse(json);
            acum_cant += parseFloat(temp.cantidad);
            productos.push(json);
          });   
          batch_id = <?php echo $etapa->id;?>;
          productos = JSON.stringify(productos);
          num_orden_prod = $('#num_orden_prod').val();   
          $('#Lote').val();

          $.ajax({
              type: 'POST',
              async: false,
              data: { productos: productos,
                      batch_id:batch_id,
                      cantidad_padre: acum_cant,
                      num_orden_prod:num_orden_prod },
              //url: 'general/Etapa/Finalizar',
              url: 'general/Etapa/finalizaFraccionar', 
              success: function(result){
                document.getElementById('btnfinalizar').style.display = "none";
                $("#modal_finalizar").modal('hide');
                if(result = "ok"){
                  linkTo('general/Etapa/index');
                }else{
                  $("#modal_finalizar").modal('hide');
                  alert("Hubo un error en el fraccionamiento")
                }
               
              }        
          });
        // }else{
        //   msj="";
        //   for(i=0;i<diferencia.length;i++)
        //   {
        //     msj+="Falto darle salida al lote de origen "+diferencia[i]+"\n";
        //   }
        //   alert(msj);
        // }
    }
  }
  $(document).off('click', '.tabla_productos_asignados_borrar').on('click', '.tabla_productos_asignados_borrar',{ idtabla:'tabla_productos_asignados', idrecipiente:'productosasignados', idbandera:'productos_existe' }, remover);
</script>
  