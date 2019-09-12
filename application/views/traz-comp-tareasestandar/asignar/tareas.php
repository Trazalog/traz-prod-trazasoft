<?php $this->load->view(TAREAS_ASIGNAR.'/modal_tareas');?>
<?php $this->load->view(TAREAS_ASIGNAR.'/modal_templates');?>
<?php $this->load->view(TAREAS_ASIGNAR.'/modal_recurso_material');?>
<?php $this->load->view(TAREAS_ASIGNAR.'/modal_recurso_asigna');?>
<?php $this->load->view(TAREAS_ASIGNAR.'/modal_recurso_trabajo');?>
<?php $this->load->view(TAREAS_ASIGNAR.'/modal_trabajo_asigna');?>
<div class="row form-group">
   <div class="col-md-1 col-xs-12">
       <label for="tarea" class="form-label">Tarea:</label>
    </div>
     <div class="col-md-5 col-xs-11 input-group margin">
         <input list="tareas" id="inputtarea" class="form-control" autocomplete="off">
           <datalist id="tareas">
           <?php foreach($tareas as $fila)
           {
             echo  '<option value="'.$fila->titulo.'">';
            }
            ?>
            </datalist>
            <span class="input-group-btn">
              <button class='btn btn-primary' 
                  onclick='checkTabla("tablatareas","modaltareas",`<?php echo json_encode($tareas);?>`,"Add")' data-toggle="modal" data-target="#modal_tareas">
                  <i class="glyphicon glyphicon-search"></i></button>
             </span> 
       </div>
       <div class="col-md-6"></div>
 </div>
 <div class="row form-group">
   <div class="col-md-1 col-xs-12">
     <label for="template" class="form-label">Template:</label>
   </div>
   <div class="col-md-5 col-xs-11 input-group margin">
      <input list="templates" id="inputtemplate" class="form-control" autocomplete="off">
       <datalist id="templates">
        <?php foreach($templates as $fila)
         {
           echo  '<option value="'.$fila->titulo.'">';
          }
          ?>
        </datalist>
        <span class="input-group-btn">
          <button class='btn btn-primary' 
            onclick='checkTabla("tablatemplate","modaltemplates",`<?php echo json_encode($templates);?>`,"Add")' data-toggle="modal" data-target="#modal_templates">
            <i class="glyphicon glyphicon-search"></i></button>
           </span> 
      </div>
      <div class="col-md-6"></div>
    </div>
   <div class="row">
    <input type="hidden" id="existe_tabla" value="no">
      <div class="col-sm-12 table-responsive" id="divtabla">
      </div>
     </div>
    <script>
    var accion ='<?php echo $accion;?>';
    if (accion == "Editar")
{
  tareas = <?php echo json_encode($etapa->tareas);?>;
  for(i=0;i<tareas.length;i++)
  { 
    tarea = tareas[i];
    tarea = JSON.stringify(tarea);
    tarea = '['+tarea+']';
    tarea = JSON.parse(tarea);
    insertaTarea(tarea);
  }
}
  $(document).off('click', '.tabla_tareas_asignadas_borrar').on('click', '.tabla_tareas_asignadas_borrar',function()
  {
    fila = $(this).closest('tr');
    tarea = JSON.parse(fila.attr('data-json'));
    if(tarea.estado == 'En Curso')
    {
      tarea.estado = 'Anulado';
      fila.find('.tabla_tareas_asignadas_borrar').remove();
      fila.attr('data-json', JSON.stringify(tarea));
      fila.find('.estadotarea').html(tarea.estado);
    }
    if(tarea.estado == 'Planificado')
    {
      id = fila.attr('id');
      fila.remove();
      tabla = document.getElementById('tabla_tareas_asignadas').innerHTML;
      tabla = '<table id="' + 'tabla_tareas_asignadas' + '" class="table table-bordered table-hover">' + tabla + '</table>';
      $('#' + 'tabla_tareas_asignadas').dataTable().fnDestroy();
      document.getElementById('divtabla').innerHTML = tabla;
      $('#' + 'tabla_tareas_asignadas').DataTable({});
      if ($(this).closest('tbody').children().length == 1) {
          document.getElementById('divtabla').innerHTML = "";
          document.getElementById('existe_tabla').value = 'no';
      }
      }
  });

function checkTabla(idtabla, idrecipiente, json, acciones)
{
  lenguaje = <?php echo json_encode($lang)?>;
  if(document.getElementById(idtabla)== null)
  {
    armaTabla(idtabla,idrecipiente,json,lenguaje,acciones);
  }
}
$("#inputtarea").on('change', function () {
   
        tareas = <?php echo json_encode($tareas);?>;
    //tareas = JSON.parse(tareas);
    key = document.getElementById('inputtarea').value;
    var i = 0;
    ban = false;
    while( !ban && i<tareas.length)
    {
      if(key == tareas[i].titulo)
      {
        tarea = tareas[i];
        ban = true;
      }
      i++;
    }
    if(!ban){
      alert("tarea Inexistente");
    }else{
      idetapa =<?php echo $idetapa;?>;
      $.ajax({
      type: 'POST',
      data: { idtarea:tarea.id, idetapa:idetapa },
      url: 'tareas/Tarea/insertaTarea', 
      success: function(result){
      tarea.id = result;
      tarea.asignado = "Sin Asignar";
      tarea.estado ="Planificado";
      tarea = JSON.stringify(tarea);
      tarea = '['+tarea+']';
      tarea = JSON.parse(tarea);
      insertaTarea(tarea);
      }
    
  }
);
     
    }
  
});
$("#inputtemplate").on('change', function () {
    
        templates = <?php echo json_encode($templates);?>;
    key = document.getElementById('inputtemplate').value;
    var i = 0;
    ban = false;
    while( !ban && i<templates.length)
    {
      if(key == templates[i].titulo)
      {
        ret = templates[i];
        ban = true;
      }
      i++;
    }
    if(!ban){
      alert("template Inexistente");
    }else{
     
    ret = ret.tareas;
    idetapa =<?php echo $idetapa;?>;
    for(j=0;j<ret.length;j++)
    {
      var fila = ret[j];
      $.ajax({
      type: 'POST',
        async:false,
      data: { idtarea:fila.id, idetapa:idetapa },
      url: 'tareas/Tarea/insertaTarea', 
      success: function(result){
      fila.id = result;
      fila.asignado = "Sin Asignar";
      fila.estado ="Planificado";
      fila = JSON.stringify(fila);
      fila = '['+fila+']';
      fila = JSON.parse(fila);
      insertaTarea(fila);
      }
    
  }
);

    }
  }
});
$(document).off('click', '.tabla_tareas_asignadas_recursos').on('click', '.tabla_tareas_asignadas_recursos', function()
  {
   document.getElementById('rowactual').value= $(this).closest('tr').attr('id');
   idtarea=$(this).closest('tr').attr('id');
   formula= JSON.parse($(this).closest('tr').attr('data-json')).formula;
 
   if(formula.length>0){
    html = "";
    html+= "<h4>Formula:</h4>"
    for(i=0;i<formula.length;i++)
    {
      html+= "<div class='row' style='margin-top:20px;'>";
      html+= "<div class='col-md-2 col-xs-12'>";
      html+=  "<label class='form-label'>"+formula[i].titulo+"</label></div>";
      html+= "<div class='col-md-10 col-xs-12'>";
      html+= "<input type='text' class='form-control' disabled value='"+formula[i].cantidad+" "+formula[i].unidad+"'>";
      html+= "</div></div>";
    }
    document.getElementById('formula').innerHTML = html;
   }
   idetapa =<?php echo $idetapa?>;
   $.ajax({
      type: 'POST',
      data: { idtarea:idtarea, idetapa:idetapa },
      url: 'tareas/Tarea/listarRecursosMateriales', 
      success: function(result){
        if(result != "")
        {
          recursos = JSON.parse(result);
          for(i=0; i<recursos.length; i++)
          {
            material = JSON.stringify(recursos[i]);
            material = '['+material+']';
            material = JSON.parse(material);
            agregaRecursoMaterial(material);
          }
        }
       // tarea = JSON.parse($(this).closest('tr').attr('data-json'));
       
        $("#modal_recurso_material").modal('show');
      }
    
  }
);
  });
  $(document).off('click', '.tabla_tareas_asignadas_trabajo').on('click', '.tabla_tareas_asignadas_trabajo', function()
  {
   document.getElementById('rowactual').value= $(this).closest('tr').attr('id');
   idtarea=$(this).closest('tr').attr('id');
   idetapa =<?php echo $idetapa?>;
   $.ajax({
      type: 'POST',
      data: { idtarea:idtarea, idetapa:idetapa },
      url: 'tareas/Tarea/listarRecursosTrabajo', 
      success: function(result){
        if(result != "")
        {
          recursos = JSON.parse(result);
          for(i=0; i<recursos.length; i++)
          {
            trabajo = JSON.stringify(recursos[i]);
            trabajo = '['+trabajo+']';
            trabajo = JSON.parse(trabajo);
            agregaRecursoTrabajo(trabajo);
          }
        }
        $("#modal_recurso_trabajo").modal('show');
      }
    
  }
);
  });
    </script>