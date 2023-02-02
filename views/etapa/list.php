<style>
  .flotante {
    /* display: scroll; */
    position: absolute;
    /* bottom: 80%; */
    right: 2%;
    /* z-index: 9999; */
    float: right;
  }

  .btn-circle.btn-xl {
    width: 40px;
    height: 40px;
    padding: 4px 10px;
    border-radius: 35px;
    font-size: 24px;
    line-height: 1.33;
  }
</style>
<?php
    $this->load->view('layout/mycss');
?>

<div class="box table-responsive">
  <div class="box-header with-border">
    <h4 class="box-title">Etapas</h4>
    <div class="flotante">
      <button style="background: #1D976C;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to bottom, #93F9B9, #1D976C);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to bottom, #93F9B9, #1D976C); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */" 
      type="button" class=" btn dropdown-toggle btn-circle btn-xl" data-toggle="dropdown" aria-expanded="false" title="Crear Nueva Etapa" onclick="crearNuevaEtapa()">
        <b style="color:#ffffff">+</b>
      </button>
      <ul class="dropdown-menu dropdown-menu-right" id="nuevo">
        <li class="header text-center text-info"><b>Crear Nueva Etapa</b></li>
        <?php

        foreach ($etapas as $fila) {
          echo "<li  data-value='" . $fila->id . "'><a data-json='" . json_encode($fila) . "'><i class='fa fa-chevron-circle-right text-info'></i>" . $fila->titulo . "</a></li>";
        }
        ?>
      </ul>
    </div>
  </div>
  <!-- FILA FILTROS -->
  <div class="row" style="margin-left:10px;margin-top:10px">
    <div class="col-md-3">
      <div class="form-group">
        <label for="procesoProductivo">Procesos productivos:</label>
        <select class="form-control select2 select2-hidden-accesible" name="procesoProductivo" id="procesoProductivo" onChange="seProcProductivo(this)">
          <!-- <option value="" disabled selected>-Seleccionar-</option>	 -->
          <?php
          if(!empty($procesosProductivos)){
            foreach ($procesosProductivos as $procesos) {
                echo "<option data-json='".json_encode($procesos)."' value='".$procesos->proc_id."'>".$procesos->nombre."</option>";
            }
          }
          ?>
        </select>
      </div>
    </div>
    <div id="botonToggleOnOff" style="text-align: center;" class="form-group col-xs-3 col-sm-3 col-md-3 col-lg-3">
      <div class="form-check">
        <label class="checkboxtext">Mostrar Batch Finalizados</label>
      </div>
      <label class="switch">
        <input type="checkbox" id="etapa_finalizada" name="etapa_finalizada" onclick="muestraBatchsFinalizados()">
        <span class="slider round"></span>
      </label>
    </div>
  </div>
  <div class="row">
    <hr>
  </div>
  <!-- FIN FILA FILTROS -->
    <div class="row" style="margin-top:5px;">
      <div class="col-md-12">
        <div id="contenedorMenuEtapasProductivas">
          <?php
          // for ($i = 0; $i < count($etapas); $i++) {
          //   if ($i < count($etapas) - 1) {
          //     echo "<button class='btn btn-primary btn-arrow-right outline' data-json='" . json_encode($etapas[$i]) . "' onclick='muestra(`" . $etapas[$i]->titulo . "`,this)'> " . $etapas[$i]->titulo . "  </button>";
          //   } else {
          //     echo "<button class='btn btn-primary btn-arrow-right-final outline' data-json='" . json_encode($etapas[$i]) . "' onclick='muestra(`" . $etapas[$i]->titulo . "`,this)'> " . $etapas[$i]->titulo . "  </button>";
          //   }
          // }
          ?>
          <!-- <button class="btn btn-primary outline" onclick='muestra(`todas`,this)'  data-toggle="tooltip" title="Para agregar una etapa productiva dirigirse al módulo Configuraciones y seleccionar 'Etapas productivas'" >Todas</button> -->
        </div>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-xs-12">
        <h4 class="box-title" style="margin-bottom: 20px; margin-top: 0px;">Producción de Lotes</h4>
        <table id="etapas" class="table table-bordered table-hover">
          <thead class="thead-dark">
            <th width="6%">Acciones</th>
            <th>Etapa</th>
            <th>ID Batch</th>
            <th>Lote</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Establecimiento</th>
            <th>Recipiente</th>
            <th>OP</th>
            <th>Fecha</th>
            <th>Estado</th>
          </thead>
          <tbody>
            <?php
            foreach ($list as $fila) {
              if($fila->estado == 'ANULADO') continue;
              $id = $fila->id;
              echo '<tr  id="' . $id . '" data-json=\'' . json_encode($fila) . '\'>';
                echo '<td width="6%" class="text-center">';
                echo "<i data-toggle='modal' data-target='#modal-asignarResponsable' class='fa fa-fw fa-user-plus text-green ml-1' style='cursor: pointer;' title='Asignar responsable' onclick='asignarResponsable($id)'></i>";
                echo '<i class="fa fa-fw fa-cogs text-light-blue ml-1" style="cursor: pointer;" title="Gestionar" onclick=linkTo("'.base_url(PRD).'general/Etapa/editar?id=' . $id . '")></i>';             
                if($fila->estado == 'PLANIFICADO' || $fila->realizo_entrega_materiales == 'false')
                echo '<i class="fa fa-fw fa-times-circle text-red ml-1" style="cursor: pointer;" title="Eliminar" onclick="conf(eliminarEtapa,\''.$id.'\',\'¿Desea eliminar la Etapa?\')"></i>';
                echo '</td>';
                echo '<td>' . $fila->titulo . '</td>';
                echo "<td>$fila->id</td>";
                echo "<td>$fila->lote</td>";
                echo '<td>' . $fila->producto . '</td>';
                echo '<td>' . $fila->cantidad . ' ' . $fila->unidad . '</td>';
                echo '<td>' . $fila->establecimiento . '</td>';
                echo '<td>' . $fila->recipiente . '</td>';
                echo '<td>' . $fila->orden . '</td>';
                echo  "<td>" . formatFechaPG($fila->fecha) . "</td>";
                echo '<td>' . estado($fila->estado) . '</td>';
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
</div><!-- /.row -->
<div class="modal fade" id="modal-asignarResponsable" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Asignar responsable</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="frm-asignarResponsable">
            <input type="text" hidden id="idLoteBatch" name="idLoteBatch">
            <div class="form-group col-md-5">
              <label for="user">Usuario*</label>
              <select id="user" name="user" class="form-control" data-user required>
              </select>
            </div>
            <div class="form-group col-md-5">
              <label for="turno">Turno*</label>
              <select id="turno" name="turno" class="form-control" data-descripcion required>
              </select>
            </div>
            <div class="form-group col-md-1">
              <label for=""></label>
              <a class="btn btn-social-icon" style="margin-top: 4px;" onclick="agregarFila()"><i class="fa fa-fw fa-plus-square"></i></a>
            </div>
          </form>
        </div>
        <div class='dataTables_wrapper form-inline dt-bootstrap'>
          <div class='row'>
            <div class='col-sm-12'>
              <table id='tabla-Operario' class='table table-bordered table-hover dataTable' role='grid'>
                <?php
                $operario = 1; //a futuro cambiarlo por si existe operario, sino no mostrar la tabla
                if (isset($operario)) {
                  echo
                    "<thead>
											<tr role='row'>
												<th>
													<font style='vertical-align: inherit;'>
														<font style='vertical-align: inherit;'>Usuario</font>
													</font>
												</th>
												<th>
													<font style='vertical-align: inherit;'>
														<font style='vertical-align: inherit;'>Turno</font>
													</font>
												</th>
											</tr>
										</thead>
										<tbody>

										</tbody>";
                }
                ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
        <button id="botAsignarRespModal" type="button" class="btn btn-success pull-right" style="margin-right: 10px;" onclick="addRespToEtapa(this)">Asignar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
</body>
<script>
  //Variable para autocreacion de Etapa
  var etapaSeleccionada = '';
  if (mobileAndTabletcheck()) $('#etapas tbody').find('tr').on('click', function() {
    $(this).find('.fa-pencil').click();
  });
  var listadoLotes = '<?php echo json_encode($list) ?>';
  DataTable('#etapas');

  function muestra(op,tag) {
    debugger;
    if(_isset($(tag).attr('data-json'))){
      etapaSeleccionada = JSON.parse($(tag).attr('data-json')).link;
    }else{
      etapaSeleccionada = '';
    }
    etapas = JSON.parse(listadoLotes);
    html = "";
    html = '<thead class="thead-dark">' +
      '<tr>' +
      '<th>Acciones</th>' +
      '<th>Etapa</th>' +
      '<th>ID Batch</th>' +
      '<th>Lote</th>' +
      '<th>Producto</th>' +
      '<th>Cantidad</th>' +
      '<th>Establecimiento</th>' +
      '<th>Recipiente</th>' +
      '<th>OP</th>' +
      '<th>Fecha</th>' +
      '<th>Estado</th>' +
      '</tr>' +
      '</thead>' +
      '<tbody>';

    if (op === 'todas') {
      for (var i = 0; i < etapas.length; i++) {
        html = html + '<tr  id="' + etapas[i].id + '" ><td>' +
          `<i data-toggle='modal' data-target='#modal-asignarResponsable' class='fa fa-fw fa-user-plus text-green ml-1' style='cursor: pointer;' title='Asignar responsable' onclick='asignarResponsable(${etapas[i].id})
          '></i>`+
          '<i class="fa fa-fw fa-cogs text-light-blue" style="cursor: pointer;" title="Gestionar" onclick=linkTo("<?php echo base_url(PRD) ?>general/Etapa/editar?id=' +
          etapas[i].id + '")></i>';
        if (etapas[i].estado == 'PLANIFICADO' && etapas[i].realizo_entrega_materiales == 'false') {
          html = html + '<i class="fa fa-fw fa-times-circle text-red" style="cursor: pointer;" title="Eliminar" onclick="conf(eliminarEtapa,' + etapas[i].id + ',\'¿Desea eliminar la Etapa?\')"></i>';
        }
        html = html + '</td>' +
          '<td>' + etapas[i].titulo + '</td>' +
          '<td>' + etapas[i].id + '</td>' +
          '<td>' + etapas[i].lote + ' </td>' +
          '<td>' + etapas[i].producto + '</td>' +
          '<td>' + etapas[i].cantidad + ' ' + etapas[i].unidad + '</td>' +
          '<td>' + etapas[i].establecimiento + '</td>' +
          '<td>' + etapas[i].recipiente + '</td>' +
          '<td>' + etapas[i].orden + '</td>' +
          '<td>' + etapas[i].fecha.substr(0,10).split(/[-/]/).reverse().join("/") + '</td>' +
          '<td>';
          switch (etapas[i].estado) {
            case 'AC':
                html = html + '<span data-toggle="tooltip" class="badge bg-green estado">Activo</span>';
                break;
            case 'IN':
                 html = html + '<span data-toggle="tooltip" class="badge bg-red estado">Inactivo</span>';
                break;
            case 'CARGADO':
                 html = html + '<span data-toggle="tooltip" class="badge bg-yellow estado">Cargado</span>';
                break;
            case 'EN CURSO':
                 html = html + '<span data-toggle="tooltip" class="badge bg-green estado">En Curso</span>';
                break;
            case 'DESCARGADO':
                 html = html + '<span data-toggle="tooltip" class="badge bg-yellow estado">Descargado</span>';
                break;
            case 'TRANSITO':
                 html = html + '<span data-toggle="tooltip" class="badge bg-orange estado">En Transito</span>';
                break;
            case 'FINALIZADO':
                 html = html + '<span data-toggle="tooltip" class="badge bg-red estado">Finalizado</span>';
                break;
            case 'En Curso':
                 html = html + '<span data-toggle="tooltip" class="badge bg-green estado">En Curso</span>';
                break;
            case 'PLANIFICADO':
                 html = html + '<span data-toggle="tooltip" class="badge bg-blue estado">Planificado</span>';
                break;
            default:
                 html = html + '<span data-toggle="tooltip" class="badge bg- estado">S/E</span>';
                break;
            }
          html = html + '</td>' +
          '</tr>';
      }
    } else {
      for (var i = 0; i < etapas.length; i++) {
        if (etapas[i].titulo === op) {
          html = html + '<tr  id="' + etapas[i].id + '" ><td>' +
          `<i data-toggle='modal' data-target='#modal-asignarResponsable' class='fa fa-fw fa-user-plus text-green ml-1' style='cursor: pointer;' title='Asignar responsable' onclick='asignarResponsable(${etapas[i].id})'></i>`+
            '<i class="fa fa-fw fa-cogs text-light-blue" style="cursor: pointer;" title="Gestionar" onclick=linkTo("<?php echo base_url(PRD) ?>general/Etapa/editar?id=' +
            etapas[i].id + '")></i>';
        if (etapas[i].estado == 'PLANIFICADO' || etapas[i].realizo_entrega_materiales == 'false') {
          html = html + '<i class="fa fa-fw fa-times-circle text-red" style="cursor: pointer;" title="Eliminar" onclick="conf(eliminarEtapa,' + etapas[i].id + ',\'¿Desea eliminar la Etapa?\')"></i>';
        }
        html = html + '</td>' +
            '<td>' + etapas[i].titulo + '</td>' +
            '<td>' + etapas[i].id + '</td>' +
            '<td>' + etapas[i].lote + ' </td>' +
            '<td>' + etapas[i].producto + '</td>' +
            '<td>' + etapas[i].cantidad + ' ' + etapas[i].unidad + '</td>' +
            '<td>' + etapas[i].establecimiento + '</td>' +
            '<td>' + etapas[i].recipiente + '</td>' +
            '<td>' + etapas[i].orden + '</td>' +
            '<td>' + etapas[i].fecha.substr(0,10).split(/[-/]/).reverse().join("/") + '</td>' +
            '<td>';
            switch (etapas[i].estado) {
              case 'AC':
                  html = html + '<span data-toggle="tooltip" class="badge bg-green estado">Activo</span>';
                  break;
              case 'IN':
                  html = html + '<span data-toggle="tooltip" class="badge bg-red estado">Inactivo</span>';
                  break;
              case 'CARGADO':
                  html = html + '<span data-toggle="tooltip" class="badge bg-yellow estado">Cargado</span>';
                  break;
              case 'EN CURSO':
                  html = html + '<span data-toggle="tooltip" class="badge bg-green estado">En Curso</span>';
                  break;
              case 'DESCARGADO':
                  html = html + '<span data-toggle="tooltip" class="badge bg-yellow estado">Descargado</span>';
                  break;
              case 'TRANSITO':
                  html = html + '<span data-toggle="tooltip" class="badge bg-orange estado">En Transito</span>';
                  break;
              case 'FINALIZADO':
                  html = html + '<span data-toggle="tooltip" class="badge bg-red estado">Finalizado</span>';
                  break;
              case 'En Curso':
                  html = html + '<span data-toggle="tooltip" class="badge bg-green estado">En Curso</span>';
                  break;
              case 'PLANIFICADO':
                  html = html + '<span data-toggle="tooltip" class="badge bg-blue estado">Planificado</span>';
                  break;
              default:
                  html = html + '<span data-toggle="tooltip" class="badge bg- estado">S/E</span>';
                  break;
              }
            html = html + '</td>' +
            '</tr>';
        }
      }
    }

    html = html + '</tbody>';

    document.getElementById('etapas').innerHTML = '';
    document.getElementById('etapas').innerHTML = html;
    $("#etapas").dataTable().fnDestroy();
    if (mobileAndTabletcheck()) $('#etapas tbody').find('tr').on('click', function() {
      $(this).find('.fa-pencil').click();
    });
    $("#etapas").dataTable({});
    //Reviso el estado del boton luego de filtrar
    muestraBatchsFinalizados();
  }


  var ul = document.getElementById('nuevo');
  ul.onclick = function(event) {
    target = JSON.parse(event.target.getAttribute('data-json'));
    linkTo(`<?php echo base_url(PRD) ?>${target.link}`);
  }

  //carga modal asignación de responsable/usuario/operario
  function asignarResponsable(batch_id) {
    $('#tabla-Operario tbody').empty();
    $('#modal-asignarResponsable').find('#idLoteBatch').attr('value', batch_id);

    //trae los usuarios a responsables
    $.ajax({
      type: "GET",
      url: "<?php echo base_url(PRD)?>general/Etapa/getUsers",
      success: function(rsp) {
        var htmlUser = '<option selected disabled>Seleccione operario</option>';
        rsp = JSON.parse(rsp);
        for (let i = 0; i < rsp.length; i++) {
          htmlUser += '<option value="' + rsp[i].id + '" >' + rsp[i].last_name + ', ' + rsp[i].first_name + '</option>'; //seg.users
        }
        $('#modal-asignarResponsable').find('#user').html(htmlUser);
      },
      error: function() {
        error('Error','Error al cargar usuarios.');
      }
    });
    //trae los turnos de produccion de lote
    $.ajax({
      type: "GET",
      url: "<?php echo base_url(PRD)?>general/Etapa/getTurnosProd",
      success: function(t) {
        var htmlTurnos = '<option selected disabled>Seleccione turno</option>';
        t = JSON.parse(t);
        for (let i = 0; i < t.length; i++) {
          htmlTurnos += '<option value="' + t[i].tabl_id + '" >' + t[i].descripcion + '</option>';
        }
        $('#modal-asignarResponsable').find('#turno').html(htmlTurnos);
      },
      error: function() {
        error('Error','Error al cargar turnos.');
      }
    });

    //obtiene y carga usuarios cargados con anterioridad
    $.ajax({
      type: "GET",
      url: "<?php echo base_url(PRD)?>general/Etapa/getUserLote/" + batch_id,
      success: function(rsp) {
        var htmlUserLote = '';
        rsp = JSON.parse(rsp);
        if(_isset(rsp)){
          for (let i = 0; i < rsp.length; i++) {
            htmlUserLote += '<tr>' +
            '<td value=' + rsp[i].user_id + ' data-user=' + rsp[i].user_id + '>' + rsp[i].last_name + ', ' + rsp[i].first_name +
            '<td value=' + rsp[i].turn_id + ' data-turno=' + rsp[i].turn_id + '>' + rsp[i].descripcion + '<a type="button" class="del pull-right" style="cursor: pointer;"><i class="fa fa-fw fa-minus"></i></a></td>' +
            '</tr>';
          }
          $('#tabla-Operario tbody').append(htmlUserLote);
        }
      },
      error: function() {
        error('Error','Error al cargar responsables.');
      }
    });
  }

  //Agregar fila a tabla usuarios modal
  function agregarFila() {
    var user = $('#user').val();
    var user_text = '';
    $('#user').children('option').each(function() {
      if ($(this).val() == user) {
        user_text = $(this).text();
      }
    });

    var turno = $('#turno').val();
    var turno_text = '';
    $('#turno').children('option').each(function() {
      if ($(this).val() == turno) {
        turno_text = $(this).text();
      }
    });

    if (!user || !turno) {
      alert('Complete usuario y turno.');
      return;
    }
    //restable a índice 0 luego de cargar un usuario
    $('#user').prop('selectedIndex', 0);
    $('#turno').prop('selectedIndex', 0);
    //carga la tabla
    html = '<tr>' +
      '<td value=' + user + ' data-user=' + user + '>' + user_text + '</td>' +
      '<td value=' + turno + ' data-turno=' + turno + '>' + turno_text + '<a type="button" class="del pull-right" style="cursor: pointer;"><i class="fa fa-fw fa-minus"></i></a></td>' +
      '</tr>';
    $('#tabla-Operario tbody').append(html);
  }

  //Quitar fila de tabla usuarios modal
  $("#tabla-Operario").on("click", ".del", function() {
    $(this).parents("tr").remove();
  });

  function addRespToEtapa() {
    var batch_id = $('#idLoteBatch').val();
    //Datos de la tabla de artículos
    var datosTabla = new Array();
    $('#tabla-Operario tr').each(function(row, tr) {
      datosTabla[row] = {
        "user_id": $(tr).find('td:eq(0)').data('user'),
        "turn_id": $(tr).find('td:eq(1)').data('turno')
      }
    });
    datosTabla.shift(); //borra encabezado de la tabla

    if (datosTabla.length < 1) {
      alert('Debe asignar un responsable.');
      return;
    }
    var responsables = JSON.stringify(datosTabla);

    console.table(datosTabla);
    console.log('responsables: ' + responsables);

    wo();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(PRD)?>general/Etapa/setUserLote",
      data: {
        batch_id: batch_id,
        responsables: responsables
      },
      success: function(rsp) {
        rsp = JSON.stringify(rsp)
        alert(rsp);
      },
      error: function() {
        alert("Se produjo un error al cargar operario.");
      },
      complete: function() {
        wc();
        $('#modal-asignarResponsable').modal('hide')
      }
    });
  }
/////////////////////////////////////////////////////////////////////////////////////////////
// Se llama desde la funcion conf(). Si se confirma la accion se elimina el lote seleccionado
 var eliminarEtapa = (id) => {
   wo();
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:`<?php echo base_url(PRD) ?>general/Lote/verificaEntregaMateriales/${id}`,
    success:(res) => {
      if(res == 'false'){
        $.ajax({
          type:'POST',
          dataType:'JSON',
          url:`<?php echo base_url(PRD) ?>general/etapa/eliminarEtapa/${id}`,
          success:(res) => {
            if(res.status){
              linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');
              hecho();
            }else{
              error('Error','Se produjo un error al eliminar la etapa.');
            }
          },
          error:(res) => {
            error();
          },
          complete:() => {
            wc();               
          }
        });
      }else{
        error('Error','El lote posee entregas de materiales.');
      }
    },
    error:(res) => {
        error();
    },
    complete:() => {
      wc();                  
    }
  });
}
  // Oculta/Muestra de Batchs Finalizados
  function muestraBatchsFinalizados(){
    debugger;
    estado = $('#etapa_finalizada').is(':checked');
    if(estado){
      $('#etapas').DataTable().columns().search('').draw();
    }else{
      $('#etapas').DataTable().columns(10).search('En Curso|Planificado',true,false).draw();
    }
  }
  $(document).ready(function () {
    muestraBatchsFinalizados();
    $("#procesoProductivo").trigger('change');
  });
  /////////////////////////////////////////////////////////////
  // Si esta seleccionada una Etapa en el Menu, directamente crea la Etapa seleccionada 
  function crearNuevaEtapa(){
    if(_isset(etapaSeleccionada)){
      linkTo(`<?php echo base_url(PRD) ?>${etapaSeleccionada}`);
    }
  }
  function seProcProductivo(tag){
    wo();
    var data = {"proc_id" : JSON.parse($(tag).find(":selected").attr("data-json")).proc_id };
    $.ajax({
      type: 'POST',
      data: data,
      cache: false,
      dataType: "json",
      url: "<?php echo PRD; ?>general/Etapa/filtrarEtapas",
      success: function(rsp) { 
        if(_isset(rsp)){
          var etapasFiltradas = '';
          rsp.forEach((element,i) => {
            if(i != rsp.length-1){
              etapasFiltradas += "<button class='btn btn-primary btn-arrow-right outline' data-json='" + JSON.stringify(element) + "' onclick='muestra(\"" + element.nombre + "\",this)'> " + element.nombre + "  </button>";
            }else{
              etapasFiltradas += "<button class='btn btn-primary btn-arrow-right-final outline' data-json='" + JSON.stringify(element) + "' onclick='muestra(\"" + element.nombre + "\",this)'> " + element.nombre + "  </button>";
            }
          });
          etapasFiltradas += "<button class='btn btn-primary outline' onclick='muestra(`todas`,this)'>Todas</button>";
          $("#contenedorMenuEtapasProductivas").empty();
          $("#contenedorMenuEtapasProductivas").html(etapasFiltradas);
        }else{
          $("#contenedorMenuEtapasProductivas").empty();
          notificar('Nota',"El proceso productivo seleccionado no posee etapas",'warning');
        }
      },
      error: function(rsp) {
          error('Error',"Se produjo un error al obtener el listado filtrado de etapas");
      },
      complete: () => {wc()}
    });
  }
</script>
