<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Etapas</h3>
          <div class="row">
          </div>
          <div class="row mt-4">
          <button class="btn btn-app" onclick='muestra(`siembra`,`<?php echo json_encode($list->etapas);?>`)'> Siembra  </button>
         <button class="btn btn-app" onclick='muestra(`zaranda`,`<?php echo json_encode($list->etapas);?>`)'> Zaranda  </button>
         <button class="btn btn-app" onclick='muestra(`limpieza`,`<?php echo json_encode($list->etapas);?>`)'> Limpieza  </button>
         <button class="btn btn-app" onclick='muestra(`estacionamiento`,`<?php echo json_encode($list->etapas);?>`)'> Estacionamiento  </button>
         <button class="btn btn-app" onclick='muestra(`fraccionamiento`,`<?php echo json_encode($list->etapas);?>`)'> Fraccionamiento </button>
         <button class="btn btn-app" onclick='muestra(`todas`,`<?php echo json_encode($list->etapas);?>`)'> Todas</button>
          </div>
         
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="etapas" class="table table-bordered table-hover">
            <thead>
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
                       
                  	foreach($list->etapas as $fila)
                    {
                  
                        $id=$fila->id;
                        echo '<tr  id="'.$id.'" >';

                        echo '<td>';
                        echo '<i class="fa fa-fw fa-pencil text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Editar" data-toggle="modal" data-target="#modaleditar"></i>';
                        echo '<i class="fa fa-fw fa-times-circle text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Eliminar" onclick="seleccionar(this)"></i>';
                        echo '</td>';
                        
                        echo '<td>'.$fila->etapa.'</td>';
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
  <script>
  $('#etapas').DataTable({
    "aLengthMenu": [10, 25, 50, 100],
    "columnDefs": [{
      "targets": [0],
      "searchable": false
    },
    {
      "targets": [0],
      "orderable": false
    }],
    "order": [[1, "asc"]],
  }); 
  function muestra(op,etapas)
  {
     etapas= JSON.parse(etapas);
     html="";
     html= '<thead>'+
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
                         '<i class="fa fa-fw fa-pencil text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Editar" data-toggle="modal" data-target="#modaleditar"></i>'+
                         '<i class="fa fa-fw fa-times-circle text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Eliminar" onclick="seleccionar(this)"></i>'+
                         '</td>'+
                         '<td>'+etapas[i].etapa+'</td>'+
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
              if(etapas[i].etapa === op)
              {
                        html= html + '<tr  id="'+etapas[i].id+'" ><td>'+
                         '<i class="fa fa-fw fa-pencil text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Editar" data-toggle="modal" data-target="#modaleditar"></i>'+
                         '<i class="fa fa-fw fa-times-circle text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Eliminar" onclick="seleccionar(this)"></i>'+
                         '</td>'+
                         '<td>'+etapas[i].etapa+'</td>'+
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

$("#etapas").dataTable({
   // ... skipped ...
});

  }
  </script>