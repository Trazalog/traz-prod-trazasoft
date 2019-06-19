<div class="modal" id="modal_recurso_asigna" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Recursos Materiales</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
      
      <div class="row">
          <div class="col-xs-12 table-responsive" id="modalrecursosmateriales">
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
  $(document).off('click','.tablarecursosmateriales_nuevo').on('click', '.tablarecursosmateriales_nuevo', function()
  {
    var recursomaterial = $(this).closest('tr').data('json');
    agregaRecursoMaterial(recursomaterial);
    $("#modal_recurso_asigna").modal('hide');
  });
  function agregaRecursoMaterial(recursomaterial,accion)
  {
  
   existe = document.getElementById('recursomaterialexiste').value;
  var html = '';
  recursomaterial = JSON.stringify(recursomaterial);
  recursomaterial =JSON.parse(recursomaterial);
  document.getElementById('inputrecursosmateriales').value = recursomaterial[0].titulo;
  if(typeof(recursomaterial[0].cantidad) == "undefined")
  {
    cantidad = "";
  }else{
    cantidad=  recursomaterial[0].cantidad;
  }
   if(existe == 'no')
   {
   
      html +='<table id="tablarecursosmaterialesasignados" class="table">';
      html +="<thead>";
      html +="<tr>";
      html +="<th>Acciones</th>";
      html +="<th>Lote</th>";
      html +="<th>Titulo</th>";
      html +="<th>Cantidad</th>";
      html +='</tr></thead><tbody>';
      html += '<tr data-json="'+recursomaterial[0]+'" id="'+recursomaterial[0].id+'">';
      html += '<td><i class="fa fa-fw fa-minus text-light-blue tablarecursosmaterialesasignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
      html += '<td>'+recursomaterial[0].lote+'</td>';
      html += '<td>'+recursomaterial[0].titulo+'</td>';
      html += '<td><input class="form-control" type="text" placeholder="Inserte Cantidad" id="cantidadlote'+recursomaterial[0].id+'" value="'+cantidad+'"></td>';
      html += '</tr>';
      html += '</tbody></table>';
      document.getElementById('recursosmaterialesasignados').innerHTML = "";
      document.getElementById('recursosmaterialesasignados').innerHTML = html;
      $('#tablarecursosmaterialesasignados').DataTable({});
        document.getElementById('recursomaterialexiste').value = 'si';
        
   } else  if(existe == 'si')
   {
      html += '<tr data-json="'+recursomaterial[0]+'" id="'+recursomaterial[0].id+'">';
      html += '<td><i class="fa fa-fw fa-minus text-light-blue tablarecursosmaterialesasignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
      html += '<td>'+recursomaterial[0].lote+'</td>';
      html += '<td>'+recursomaterial[0].titulo+'</td>';
      html += '<td><input class="form-control" type="text" placeholder="Inserte Cantidad" id="cantidadlote'+recursomaterial[0].id+'" value="'+cantidad+'"></td>';
      html += '</tr>';
      $('#tablarecursosmaterialesasignados tbody').append(html);
      tabla = document.getElementById('tablarecursosmaterialesasignados').innerHTML;
      tabla = '<table id="tablarecursosmaterialesasignados" class="table table-bordered table-hover">' + tabla + '</table>';
      $('#tablarecursosmaterialesasignados').dataTable().fnDestroy();
      document.getElementById('recursosmaterialesasignados').innerHTML = "";
      document.getElementById('recursosmaterialesasignados').innerHTML = tabla;
      $('#tablarecursosmaterialesasignados').DataTable({});
       
   }
  }
  </script>