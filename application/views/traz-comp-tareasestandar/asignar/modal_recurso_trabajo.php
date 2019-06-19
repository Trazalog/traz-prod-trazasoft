<div class="modal" id="modal_recurso_trabajo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Recursos De Trabajo</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
      <div class="row">    
      </div>
      <div class="row form-group">
   <div class="col-md-2 col-xs-12">
     <label  class="form-label">Recurso:</label>
   </div>
   <div class="col-md-5 col-xs-12 input-group">
      <input list="recursostrabajo" id="inputrecursostrabajo" class="form-control">
       <datalist id="recursostrabajo">
       <?php foreach($recursostrabajo as $fila)
           {
             echo  '<option value="'.$fila->Equipo.'">';
            }
            ?>
        </datalist>
        <span class="input-group-btn">
          <button class='btn btn-sm btn-primary' onclick='checkTabla("tablarecursostrabajo","modalrecursostrabajo",`<?php echo json_encode($recursostrabajo);?>`,"Add")' 
             data-toggle="modal" data-target="#modal_trabajo_asigna">
            <i class="glyphicon glyphicon-search"></i></button>
           </span> 
      </div>
      <div class="col-md-5"></div>
    </div>
      <div class="row">
      <input type="hidden" id="recursotrabajoexiste" value="no">
          <div class="col-xs-12 table-responsive" id="recursostrabajoasignados">
          </div>
      </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="SubmitTrabajo()">Aceptar</button>
      </div>
    </div>
    </div>
  </div>
  <script>
   $(document).off('click', '.tablarecursostrabajoasignados_borrar').on('click', '.tablarecursostrabajoasignados_borrar',{ idtabla:'tablarecursostrabajoasignados', idrecipiente:'recursostrabajoasignados', idbandera:'recursotrabajoexiste' }, remover);
   $("#inputrecursostrabajo").on('change', function () {
    recursos = <?php echo json_encode($recursostrabajo)?>;
 titulo = document.getElementById('inputrecursostrabajo').value;
 ban = false;
i=0;
      while(!ban && i<recursos.length)
      {
        if(titulo == recursos[i].Equipo)
        {
          ban = true;
          recurso = recursos[i];
        }
        i++;
      }
      if(ban)
     {
       recurso = JSON.stringify(recurso);
       recurso = '['+recurso+']';
       recurso = JSON.parse(recurso);
       console.log(recurso);
      agregaRecursoTrabajo(recurso);
     } else{
       alert('No existe ese recurso');
     }
 
  });
  function SubmitTrabajo()
  
  {
    row= document.getElementById('rowactual').value;
    $('#tabla_tareas_asignadas tbody').find('tr#'+row).find('td').eq(3).find('i.tabla_tareas_asignadas_trabajo').show();
    
    $('#modal_recurso_trabajo').modal('hide');
    
  }
  </script>