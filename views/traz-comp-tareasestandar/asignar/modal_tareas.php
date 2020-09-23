<div class="modal" id="modal_tareas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Tareas</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
      <input type="hidden" id="idtareaasignada" value=1>  
      <div class="row">
          <div class="col-xs-12 table-responsive" id="modaltareas">
          
          </div>
      </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
  </div>
  <script>
 $(document).off('click','.tablatareas_nuevo').on('click', '.tablatareas_nuevo', function () {
    tarea = $(this).closest('tr').data('json');
   $(this).closest('tr').css({backgroundColor: "cyan"});
   idetapa =<?php echo $idetapa;?>;
      $.ajax({
      type: 'POST',
      data: { idtarea:tarea[0].id, idetapa:idetapa },
      url: 'tareas/Tarea/insertaTarea', 
      success: function(result){
      tarea[0].id = result;
      tarea[0].asignado = "Sin Asignar";
      tarea[0].estado ="Planificado";
      insertaTarea(tarea);
      }
  }
);
 });
 function insertaTarea(tarea)
 {
   var existe = document.getElementById('existe_tabla').value;
   html= "";
   id =tarea[0].id;
   if(existe == "no")
   {
    
    html +='<table id="tabla_tareas_asignadas" class="table">';
      html +="<thead>";
      html +="<tr>";
      html +="<th>Acciones</th>";
      html +="<th>Titulo</th>";
      html +="<th>Duracion</th>";
      html +="<th>Caracteristicas</th>";
      html +="<th>Asignado a</th>";
      html +="<th>Estado</th>";
      html +='</tr></thead><tbody>';
      html += "<tr data-json='"+JSON.stringify(tarea[0])+"'id='"+id+"'>";
      html += '<td>';
      if(tarea[0].estado != 'Terminado' ||tarea[0].estado != 'Anulado' ){
        html += '<i class="fa fa-fw fa-minus text-light-blue tabla_tareas_asignadas_borrar" style="cursor: pointer; margin-left: 15px;" title="Remover Tarea"></i>';
      }
      html += '<i class="fa fa-fw  fa-male text-light-blue tabla_tareas_asignadas_encargado" style="cursor: pointer; margin-left: 15px;" title="Asignar Encargado"></i>';
      html += '<i class="fa fa-fw fa-truck text-light-blue tabla_tareas_asignadas_trabajo" style="cursor: pointer; margin-left: 15px;" title="Asignar Recurso de trabajo"></i>';
      html += '<i class="fa fa-fw fa-leaf text-green tabla_tareas_asignadas_recursos" style="cursor: pointer; margin-left: 15px;" title="Asignar Recurso Material"></i></td>';
      html += '<td>'+tarea[0].titulo+'</td>';
      html += '<td>'+tarea[0].duracion+'</td><td>';
      if(tarea[0].formula != ""){
      html += ' <i class="fa fa-edit" title="Formula"></i>';
      }
      if(tarea[0].formulario != ""){
      html +='  <i class="fa fa-edit" title="Formulario"></i> ';
      }
      html +=' <i class="fa fa-fw fa-leaf text-green tabla_tareas_asignadas_recursos" style="display:none" title="Recursos Materiales asignados"></i> ';
      html +='  <i class="fa fa-fw fa-truck text-light-blue tabla_tareas_asignadas_trabajo" style="display:none" title="Recursos de trabajo asignados"></i> </td>';
      html += '<td>'+tarea[0].asignado+'</td>';
      html += '<td class="estadotarea">'+tarea[0].estado+'</td>';
      html += '</tr>';
      html += '</tbody></table>';
      document.getElementById('divtabla').innerHTML = "";
      document.getElementById('divtabla').innerHTML = html;
      $('#tabla_tareas_asignadas').DataTable({});
       document.getElementById('existe_tabla').value = 'si';
   }else if(existe == 'si')
   {
      html += "<tr data-json='"+JSON.stringify(tarea[0])+"'id='"+id+"'>";
      html += "<td>";
      if(tarea[0].estado == 'Planificado' || tarea[0].estado == 'En Curso' ){
        html += '<i class="fa fa-fw fa-minus text-light-blue tabla_tareas_asignadas_borrar" style="cursor: pointer; margin-left: 15px;" title="Remover Tarea"></i>';
      }
      html += '<i class="fa fa-fw  fa-male text-light-blue tabla_tareas_asignadas_encargado" style="cursor: pointer; margin-left: 15px;" title="Asignar Encargado"></i>';
      html += '<i class="fa fa-fw fa-truck text-light-blue tabla_tareas_asignadas_trabajo" style="cursor: pointer; margin-left: 15px;" title="Asignar Recurso de trabajo"></i>';
      html += '<i class="fa fa-fw fa-leaf text-green tabla_tareas_asignadas_recursos" style="cursor: pointer; margin-left: 15px;" title="Asignar Recurso Material"></i></td>';
      html += '<td>'+tarea[0].titulo+'</td>';
      html += '<td>'+tarea[0].duracion+'</td><td>';
      if(tarea[0].formula != ""){
      html += ' <i class="fa fa-edit" title="Formula"></i>';
      }
      if(tarea[0].formulario != ""){
      html +='  <i class="fa fa-edit" title="Formulario"></i> ';
      }
      html +=' <i class="fa fa-fw fa-leaf text-green tabla_tareas_asignadas_recursos" style="display:none" title="Recursos Materiales asignados"></i> ';
      html +=' <i class=" fa fa-fw fa-truck text-ligth-blue tabla_tareas_asignadas_trabajo" style="display:none" title="Recursos de trabajo asignados"></i> </td>';
      html += '<td>'+tarea[0].asignado+'</td>';
      html += '<td class="estadotarea">'+tarea[0].estado+'</td>';
      html += '</tr>';
      $('#tabla_tareas_asignadas tbody').append(html);
      tabla = document.getElementById('tabla_tareas_asignadas').innerHTML;
      tabla = '<table id="tabla_tareas_asignadas" class="table table-bordered table-hover">' + tabla + '</table>';
      $('#tabla_tareas_asignadas').dataTable().fnDestroy();
      document.getElementById('divtabla').innerHTML = tabla;
      $('#tabla_tareas_asignadas').DataTable({});
   }
   id++;
   document.getElementById('idtareaasignada').value = id;
   }

</script>


