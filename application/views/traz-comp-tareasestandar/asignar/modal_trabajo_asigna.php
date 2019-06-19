<div class="modal" id="modal_trabajo_asigna" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Recursos De Trabajo</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
      
      <div class="row">
          <div class="col-xs-12 table-responsive" id="modalrecursostrabajo">
          </div>
      </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
  </div>
  <script>
  $(document).off('click','.tablarecursostrabajo_nuevo').on('click', '.tablarecursostrabajo_nuevo', function()
  {
    var recursotrabajo = $(this).closest('tr').data('json');
    agregaRecursoTrabajo(recursotrabajo);
    $("#modal_trabajo_asigna").modal('hide');
  });
  function agregaRecursoTrabajo(recursotrabajo)
  {
  
  existe = document.getElementById('recursotrabajoexiste').value;
  var html = '';
  recursotrabajo = JSON.stringify(recursotrabajo);
  recursotrabajo =JSON.parse(recursotrabajo);
  document.getElementById('inputrecursostrabajo').value = recursotrabajo[0].Equipo;
   if(existe == 'no')
   {
   
      html +='<table id="tablarecursostrabajoasignados" class="table">';
      html +="<thead>";
      html +="<tr>";
      html +="<th>Acciones</th>";
      html +="<th>Identificador</th>";
      html +="<th>Equipo</th>";
      html +="<th>Capacidad</th>";
      html +="<th>Disponible</th>";
      html +='</tr></thead><tbody>';
      html += '<tr data-json="'+recursotrabajo[0]+'" id="'+recursotrabajo[0].id+'">';
      html += '<td><i class="fa fa-fw fa-minus text-light-blue tablarecursostrabajoasignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
      html += '<td>'+recursotrabajo[0].id+'</td>';
      html += '<td>'+recursotrabajo[0].Equipo+'</td>';
      html += '<td>'+recursotrabajo[0].Capacidad+'</td>';
      html += '<td>'+recursotrabajo[0].disponible+'</td>';
      html += '</tr>';
      html += '</tbody></table>';
      document.getElementById('recursostrabajoasignados').innerHTML = "";
      document.getElementById('recursostrabajoasignados').innerHTML = html;
      $('#tablarecursostrabajoasignados').DataTable({});
        document.getElementById('recursotrabajoexiste').value = 'si';
        
   } else  if(existe == 'si')
   {
      html += '<tr data-json="'+recursotrabajo[0]+'" id="'+recursotrabajo[0].id+'">';
      html += '<td><i class="fa fa-fw fa-minus text-light-blue tablarecursostrabajoasignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
      html += '<td>'+recursotrabajo[0].id+'</td>';
      html += '<td>'+recursotrabajo[0].Equipo+'</td>';
      html += '<td>'+recursotrabajo[0].Capacidad+'</td>';
      html += '<td>'+recursotrabajo[0].disponible+'</td>';
      html += '</tr>';
      $('#tablarecursostrabajoasignados tbody').append(html);
      tabla = document.getElementById('tablarecursostrabajoasignados').innerHTML;
      tabla = '<table id="tablarecursostrabajoasignados" class="table t">' + tabla + '</table>';
      $('#tablarecursostrabajoasignados').dataTable().fnDestroy();
      document.getElementById('recursostrabajoasignados').innerHTML ="";
      document.getElementById('recursostrabajoasignados').innerHTML = tabla;
      $('#tablarecursostrabajoasignados').DataTable({});
       
   }
  }
  </script>