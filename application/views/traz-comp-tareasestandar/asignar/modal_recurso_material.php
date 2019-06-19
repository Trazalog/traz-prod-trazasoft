<div class="modal" id="modal_recurso_material" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Recursos Materiales</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
      
      <div id="formula"></div> 
      <div class="row form-group" style="margin-top:20px;">
   <div class="col-md-2 col-xs-12">
     <label for="template" class="form-label">Recurso:</label>
   </div>
   <div class="col-md-5 col-xs-12 input-group">
      <input list="recursos" id="inputrecursosmateriales" class="form-control">
       <datalist id="recursos">
       <?php foreach($recursosmateriales as $fila)
           {
             echo  '<option value="'.$fila->titulo.'">';
            }
            ?>
        </datalist>
        <span class="input-group-btn">
          <button class='btn btn-sm btn-primary' onclick='checkTabla("tablarecursosmateriales","modalrecursosmateriales",`<?php echo json_encode($recursosmateriales);?>`,"Add")' 
             data-toggle="modal" data-target="#modal_recurso_asigna">
            <i class="glyphicon glyphicon-search"></i></button>
           </span> 
      </div>
      <div class="col-md-5"></div>
    </div>
      <div class="row">
      <input type="hidden" id="recursomaterialexiste" value="no">
          <div class="col-xs-12 table-responsive" id="recursosmaterialesasignados">
          </div>
          <input type="hidden" id="rowactual">
      </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="SubmitMateriales()">Aceptar</button>
      </div>
    </div>
    </div>
  </div>
  <script>
   $(document).off('click', '.tablarecursosmaterialesasignados_borrar').on('click', '.tablarecursosmaterialesasignados_borrar',{ idtabla:'tablarecursosmaterialesasignados', idrecipiente:'recursosmaterialesasignados', idbandera:'recursomaterialexiste' }, remover);
   $("#inputrecursosmateriales").on('change', function () {
    recursos = <?php echo json_encode($recursosmateriales)?>;
 titulo = document.getElementById('inputrecursosmateriales').value;
 ban = false;
i=0;
      while(!ban && i<recursos.length)
      {
        if(titulo == recursos[i].titulo)
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
       agregaRecursoMaterial(recurso);
     } else{
       alert('No existe ese recurso');
     }
 
  });
  function SubmitMateriales()
  
  {
    row= document.getElementById('rowactual').value;
    $('#tabla_tareas_asignadas tbody').find('tr#'+row).find('td').eq(3).find('i.tabla_tareas_asignadas_recursos').show();
    $('#modal_recurso_material').modal('hide');
    
  }
  </script>