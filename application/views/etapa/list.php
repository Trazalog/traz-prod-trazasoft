
      <div class="box table-responsive"> 
      <div class="box-header">
          <h3 class="box-title">Etapas</h3>
          <div class="row" style="width:900px;">
           <div class="col-xs-10">
              <?php
                       
                for($i=0;$i<count($etapas);$i++)
                {
                  if($i<count($etapas)-1){
                  echo "<button class='btn btn-primary btn-arrow-right outline' onclick='muestra(`".$etapas[$i]->titulo."`,`".json_encode($list)."`)'> ".$etapas[$i]->titulo."  </button>";
                  }else{
                    echo "<button class='btn btn-primary btn-arrow-right-final outline' onclick='muestra(`".$etapas[$i]->titulo."`,`".json_encode($list)."`)'> ".$etapas[$i]->titulo."  </button>";
                  }
                  
                }
              ?>
              <button class="btn btn-primary outline" onclick='muestra(`todas`,`<?php echo json_encode($list);?>`)'> Todas</button>
           </div>
            <div class="col-xs-2">
                <button type="button" class=" btn btn-primary btn-block glyphicon glyphicon-plus dropdown-toggle"  data-toggle="dropdown"  aria-expanded="false" >Nuevo
                <span class="fa fa-caret-down"></span></button>
                <ul class="dropdown-menu" id="nuevo">
                <?php
                    
                    foreach($etapas as $fila)
                    {
                      echo "<li  data-value='".$fila->id."'><a data-json='".json_encode($fila)."'>".$fila->titulo."</a></li>";
                      
                      //var_dump($etapas);
                    }
                ?>

                      <!-- <li  data-value="1"><a data-json="">"siembra"</a></li> -->




              </ul>
            </div>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-xs-12">
            <table id="etapas" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                  <th>Acciones</th>
                  <th>Etapa</th>
                  <th>Producto Origen</th>
                  <th>Cantidad</th>
                  <th>Establecimiento</th>
                  <th>Recipiente</th>
                  <th>OP</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        
                      foreach($list as $fila)
                      {
                    
                          $id=$fila->id;
                          echo '<tr  id="'.$id.'" data-json:'.json_encode($fila).'>';

                          echo '<td>';
                          echo '<i class="fa fa-fw fa-pencil text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Editar" onclick=linkTo("general/Etapa/editar?id='.$id.'")></i>';
                          echo '<i class="fa fa-fw fa-times-circle text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Eliminar" onclick="seleccionar(this)"></i>';
                          echo '</td>';
                          
                          echo '<td>'.$fila->titulo.'</td>';
                          echo '<td>'.$fila->producto.'</td>';
                          echo '<td>'.$fila->cantidad.' '.$fila->unidad.'</td>';  
                          echo '<td>'.$fila->establecimiento.'</td>';
                          echo '<td>'.$fila->recipiente.'</td>';
                          echo '<td>'.$fila->orden.'</td>';
                          echo '</tr>';
                        
                      }
        
                  ?>
              </tbody> 
            </table>
              
         
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
  </body>
  <script>
  
  $('#etapas').DataTable({
  
  }); 
  function muestra(op,etapas)
  {
     etapas= JSON.parse(etapas);
     html="";
     html= '<thead class="thead-dark">'+
              '<tr>'+
                '<th>Acciones</th>'+
               ' <th>Etapa</th>'+
                '<th>Producto Origen</th>'+
               ' <th>Cantidad</th>'+
                '<th>Establecimiento</th>'+
                '<th>Recipiente</th>'+
                '<th>OP</th>'+
              '</tr>'+
            '</thead>'+
            '<tbody>';  
            
     if(op === 'todas')
     {
         
                  	for(var i=0; i<etapas.length; i++)
                    {
                        html= html + '<tr  id="'+etapas[i].id+'" ><td>'+
                         '<i class="fa fa-fw fa-pencil text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Editar" onclick=linkTo("general/Etapa/editar?id='+etapas[i].id+'")></i>'+
                         '<i class="fa fa-fw fa-times-circle text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Eliminar" onclick="seleccionar(this)"></i>'+
                         '</td>'+
                         '<td>'+etapas[i].titulo+'</td>'+
      	                 '<td>'+etapas[i].producto+'</td>'+
                         '<td>'+etapas[i].cantidad+' '+etapas[i].unidad+'</td>'+  
                         '<td>'+etapas[i].establecimiento+'</td>'+
                         '<td>'+etapas[i].recipiente+'</td>'+
                         '<td>'+etapas[i].orden+'</td>'+
      	                 '</tr>';
                    }
     }
     else
     {
        for(var i=0; i<etapas.length; i++)
                {
              if(etapas[i].titulo === op)
              {
                        html= html + '<tr  id="'+etapas[i].id+'" ><td>'+
                         '<i class="fa fa-fw fa-pencil text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Editar" onclick=linkTo("general/Etapa/editar?id='+etapas[i].id+'")></i>'+
                         '<i class="fa fa-fw fa-times-circle text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Eliminar" onclick="seleccionar(this)"></i>'+
                         '</td>'+
                         '<td>'+etapas[i].titulo+'</td>'+
      	                 '<td>'+etapas[i].producto+'</td>'+
                         '<td>'+etapas[i].cantidad+' '+etapas[i].unidad+'</td>'+  
                         '<td>'+etapas[i].establecimiento+'</td>'+
                         '<td>'+etapas[i].recipiente+'</td>'+
                         '<td>'+etapas[i].orden+'</td>'+
      	                 '</tr>';
              }
          		        
                    }
    
     }
     
     html= html + '</tbody>';
     
     document.getElementById('etapas').innerHTML='';
     document.getElementById('etapas').innerHTML = html;
     $("#etapas").dataTable().fnDestroy();
     $("#etapas").dataTable({});

  }
  var ul = document.getElementById('nuevo');
   ul.onclick = function(event) {
                  target= JSON.parse(event.target.getAttribute('data-json'));
                  console.log(target);
                      linkTo(target.link);
                }
  </script>
  