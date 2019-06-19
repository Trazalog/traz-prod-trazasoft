<div class="modal" id="modal_lotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Tareas</h4>
      </div>

      <div class="modal-body" id="modalBodyArticle">
      <div class="row">
          <div class="col-xs-12 table-responsive" id="modallotes">
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
  $(document).off('click','.tablalote_nuevo').on('click', '.tablalote_nuevo', function()
  {
    var lote = $(this).closest('tr').data('json');
    agregalote(lote);
    document.getElementById('inputlote').value = "";
    $("#modal_lotes").modal('hide');
  });
 
  function agregalote(lote)
  {
  
   existe = document.getElementById('loteexiste').value;
  var html = '';
  lote = JSON.stringify(lote);
  lote =JSON.parse(lote);
  document.getElementById('inputlote').value = lote.lote.titulo;
   if(existe == 'no')
   {
   
      html +='<table id="tablalotesasignados" class="table">';
      html +="<thead>";
      html +="<tr>";
      html +="<th>Acciones</th>";
      html +="<th>Lote</th>";
      html +="<th>Stock</th>";
      html +="<th>Establecimiento</th>";
      html +="<th>Recipiente</th>";
      html +="<th>Cantidad</th>";
      html +='</tr></thead><tbody>';
      html += '<tr data-json="'+lote.lote+'" "id='+lote.lote.id+'">';
      html += '<td><i class="fa fa-fw fa-minus text-light-blue tablalotesasignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
      html += '<td>'+lote.lote.titulo+'</td>';
      html += '<td>'+lote.lote.stock+'</td>';
      html += '<td>'+lote.lote.establecimiento+'</td>';
      html += '<td>'+lote.lote.recipiente+'</td>';
      html += '<td><input class="form-control" type="text" placeholder="Inserte Cantidad" id="cantidadlote'+lote.lote.id+'"></td>';
      html += '</tr>';
      html += '</tbody></table>';
      document.getElementById('lotesasignados').innerHTML = "";
      
      //$('#tablalotesasignados').dataTable().fnDestroy();
      document.getElementById('lotesasignados').innerHTML = html;
      $('#tablalotesasignados').DataTable({});
        document.getElementById('loteexiste').value = 'si';
        
   } else  if(existe == 'si')
   {
      html += '<tr data-json="'+lote.lote+'" "id='+lote.lote.id+'">';
      html += '<td><i class="fa fa-fw fa-minus text-light-blue tablalotesasignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i></td>';
      html += '<td>'+lote.lote.titulo+'</td>';
      html += '<td>'+lote.lote.stock+'</td>';
      html += '<td>'+lote.lote.establecimiento+'</td>';
      html += '<td>'+lote.lote.recipiente+'</td>';
      html += '<td><input class="form-control" type="text" placeholder="Inserte Cantidad" id="cantidadlote'+lote.lote.id+'"></td>';
      html += '</tr>';
      $('#tablalotesasignados tbody').append(html);
      tabla = document.getElementById('tablalotesasignados').innerHTML;
      tabla = '<table id="tablalotesasignados" class="table">' + tabla + '</table>';
      $('#tablalotesasignados').dataTable().fnDestroy();
      document.getElementById('lotesasignados').innerHTML="";
      document.getElementById('lotesasignados').innerHTML = tabla;
      $('#tablalotesasignados').DataTable({});
       
   }
  }

</script>