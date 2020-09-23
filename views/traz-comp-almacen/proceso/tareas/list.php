
<style>
.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 12px/150% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; }.datagrid table td, .datagrid table th { padding: 13px 20px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #3B8BBA), color-stop(1, #45A4DB) );background:-moz-linear-gradient( center top, #3B8BBA 5%, #45A4DB 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#3B8BBA', endColorstr='#45A4DB');background-color:#3B8BBA; color:#FAF2F8; font-size: 13px; font-weight: bold; border-left: 1px solid #A3A3A3; } .datagrid table tbody td { color: #002538; font-size: 13px;border-bottom: 1px solid #E1EEF4;font-weight: normal; }.datagrid table tbody .alt td { background: #EBEBEB; color: #00273B; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }
</style>


            </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">

       
          <h1 class="box-title">Mis Tareas</h1>
      

        </div><!-- /.box-header -->
        <div class="box-body">
        <div class="datagrid">
          <table id="sector" class="table table-hover table-striped">
            <thead>
              <tr>
          
                <?php  

                  echo '<th width="7%"'.($device == 'android' ? 'class= "hidden"' :'class= ""').' >Estado</td>';

                  echo '<th>Tarea</th>';

                  echo '<th>Descripción</th>';

                  #echo '<th width="7%"'.($device == 'android' ? 'class= "hidden"' :'class= ""').' >Id S.S</td>';    
                  echo '<th width="7%"'.($device == 'android' ? 'class= "hidden"' :'class= ""').' >Id OT</td>';          
                                  

                  echo '<th '.($device == 'android' ? 'class= "hidden"' :'class= ""').' >Fecha Asignación</td>';                 
                                  

                  echo '<th '.($device == 'android' ? 'class= "hidden"' :'class= ""').' >Fecha Vto.</td>';
                  
                  echo '<th>caseId</td>';

                  // echo '<th '.($device == 'android' ? 'class= "hidden"' :'class= ""').' >Prioridad</td>';
                                  
                 
              
              ?>  
              </tr>
            </thead>
            <tbody>
              <?php                
                foreach($list as $f){

             //     if($f['processId']==BPM_PROCESS_ID_PEDIDOS_NORMALES || $f['processId']==BPM_PROCESS_ID_PEDIDOS_EXTRAORDINARIOS){
                  
                  $id=$f["id"];
                  $asig = $f['assigned_id'];

                  echo '<tr id="'.$id.'" class="'.$id.'" style="cursor: pointer;">';                   

                  if ( $asig != "")  {
                    echo '<td '.($device == 'android' ? 'class= "celda nomTarea hidden"' :'class= "celda nomTarea"').' style="text-align: left"><i class="fa fa-user" style="color: #5c99bc ; cursor: pointer;"" title="Asignado" data-toggle="modal" data-target="#modalSale"></i></td>';
                  }else{
                    echo '<td '.($device == 'android' ? 'class= "celda nomTarea hidden"' :'class= "celda nomTarea"').' style="text-align: left"><i class="fa fa-user" style="color: #d6d9db ; cursor: pointer;"" title="Sin Asignar" data-toggle="modal" data-target="#modalSale"></i></td>';
                  }
                  
                    echo '</td>';

                    echo '<td class="celda nomTarea" style="text-align: left">'.$f['displayName'].'</td>';  
                     
                    echo '<td class="celda tareaDesc" style="text-align: left">'.substr($f['displayDescription'],0,500).'</td>';                
                      
                    #echo '<td '.($device == 'android' ? 'class= "celda nomTarea hidden"' :'class= "celda nomTarea"').' style="text-align: left"><span data-toggle="tooltip" class="badge bg-blue" >'.$f['ss'].'</span></td>';   
                    
                    echo '<td>???</td>';#echo '<td '.($device == 'android' ? 'class= "celda nomTarea hidden"' :'class= "celda nomTarea"').' style="text-align: left"><span data-toggle="tooltip" class="badge bg-orange" >'.$f['ot'].'</span></td>';                  
              
                    echo '<td '.($device == 'android' ? 'class= "celda nomTarea hidden tddate"' :'class= "celda nomTarea tddate"').' style="text-align: left">'.formato_fecha_hora($f['assigned_date']).'</td>'; 

                    echo '<td '.($device == 'android' ? 'class= "celda nomTarea hidden tddate"' :'class= "celda nomTarea tddate"').' style="text-align: left">'.formato_fecha_hora($f['dueDate']).'</td>';
                  
                    echo '<td>'.$f['caseId'].'</td>';


                    echo '</tr>';

              //  }
            }
              ?>

            </tbody>
          </table>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->


<div class="modal fade" id="finalizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="glyphicon glyphicon-check btncolor " style="color: #6aa61b" > </span> Finalización </h4>
        </div>
        <center>
        <div>Debe completar el formulario asociado a esta tarea para terminarla</div>
        </center>
        
    </div>
  </div>
</div>

<script>

 
//Tomo valor de la celda y carga detalle de la tarea
  $('tbody tr').click( function () {
    var id = $(this).attr('id');
    linkTo("<?php echo ALM ?>Proceso/detalleTarea/" + id);  
  });

  $('#ferchu').DataTable();
</script>




















