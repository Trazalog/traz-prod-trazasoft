<!-- ______ TABLA PRINCIPAL DE PANTALLA ______ -->
<table id="tabla_etapas_productivas" class="table table-bordered table-striped">
	<thead class="thead-dark" bgcolor="#eeeeee">
		<th>Acciones</th>
		<th>Nombre</th>
		<th>Proceso Productivo</th>								
		<th>Nombre Recipiente</th>
		<th>Tipo</th>
		<th>Orden</th>
		<th>Formulario</th>
	</thead>
	<tbody >
		<?php
			if($listarEtapasProductivas)
			{
				foreach($listarEtapasProductivas as $rsp)
				{
          $cadena_nombre = $rsp->nombre;
          $nombre_nuevo = str_replace("_", " ", $cadena_nombre);
					echo "<tr data-json='".json_encode($rsp)."'>";
						echo "<td class='text-center text-light-blue'>";
              echo '<i title="Ver detalle" class="fa fa-eye btnInfo" style="cursor: pointer; margin: 3px;" aria-hidden="true" data-toggle="modal" data-target="#modaleditar" ></i>&nbsp';
              echo '<i title="Editar" class="fa fa-pencil-square-o btnEditar"  aria-hidden="true" style="cursor: pointer; margin: 3px;" data-toggle="modal" data-target="#modaleditar"></i>&nbsp';
              echo '<i title="Ver Artículos" class="fa fa-list btnArticulos"  aria-hidden="true" style="cursor: pointer; margin: 3px;"></i>&nbsp';
              echo '<i title="Eliminar" class="fa fa-trash btnEliminar" aria-hidden="true" style="cursor: pointer; margin: 3px;"></i>&nbsp';
						echo "</td>";
						echo '<td>'.$nombre_nuevo.'</td>';
						echo '<td>'.$rsp->proc_prod.'</td>';
						echo '<td>'.$rsp->recipiente.'</td>';
						echo '<td>'.$rsp->tipo.'</td>';
						echo '<td>'.$rsp->orden.'</td>';
						echo '<td>'.$rsp->formulario.'</td>';
					echo '</tr>';
				}
			}
		?>
	</tbody>
</table>
<!--_______ FIN TABLA PRINCIPAL DE PANTALLA ______-->

<script>
  // extrae datos de la tabla
  $(".btnEditar").on("click", function(e) {
    $(".modal-header h4").remove();
    //guardo el tipo de operacion en el modal
    $("#operacion").val("Edit");
    //pongo titlo al modal
    $(".modal-header").append('<h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-fw fa-pencil"></span> Editar Etapa Productiva </h4>');
    data = $(this).parents("tr").attr("data-json");
    datajson = JSON.parse(data);
    habilitarEdicion();
    llenarModal(datajson);
  });

  // extrae datos de la tabla
  $(".btnInfo").on("click", function(e) {
    $(".modal-header h4").remove();
    //guardo el tipo de operacion en el modal
    $("#operacion").val("Info");
    //pongo titlo al modal
    $(".modal-header").append('<h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-fw fa-pencil"></span> Info Etapa Productiva </h4>');
    data = $(this).parents("tr").attr("data-json");
    datajson = JSON.parse(data);
    blockEdicion();
    llenarModal(datajson);
  });

  //cambia encabezado para agregar una herramienta
  $("#btnAdd").on("click", function(e) {
    $("#operacion").val("Add");
    $(".modal-header h4").remove();
    $(".modal-header").append('<h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-fw fa-pencil text-light-blue"></span> Agregar Etapa Productiva </h4>');
    ///FIXME: LIMPIAR LOS CAMPOS Y SELECTS
  });
  
  $(".btnArticulos").on("click", function(e) {
    $(".modal-header h4").remove();
    $("#operacion").val("Articulos");
    //pongo titulo al modal
    $(".modal-header").append('<h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-fw fa-pencil"></span> Artículos de la Etapa Productiva </h4>');
    datajson = $(this).parents("tr").attr("data-json");
    data = JSON.parse(datajson);
    var etap_id = data.etap_id;
    // guardo etap_id en modal para usar en funcion agregar articulo
    $("#id_etap").val(etap_id);
    $.ajax({
        type: 'GET',
        url: 'index.php/<?php echo PRD ?>general/Etapa/listarArticulosYTipos?etap_id='+etap_id,
        success: function(result) {
          var tablaArticulos = $("#tabla_articulos").DataTable();
          tablaArticulos.clear().draw();
          if (result) {
            $.each(result, function(index, value) {
              // use data table row.add, then .draw for table refresh
              rowInstanciada = tablaArticulos.row.add(["<button type='button' title='Eliminar Artículo' class='btn btn-primary btn-circle btnEliminar' onclick='eliminarArticulo(this)'><span class='glyphicon glyphicon-trash' aria-hidden='true' ></span></button>", value.barcode, value.descripcion, value.tipo, value.unidad_medida, value.es_caja, value.cantidad_caja]).draw().node();
              $(rowInstanciada).attr('data-json', JSON.stringify(value));
            });
          };
          $('#modalarticulos').modal('show');
        },
        error: function(result) {
            alert('Error');
        },
        dataType: 'json'
    });
  });

  // llena modal paa edicio y muestra
  function llenarModal(datajson){
    $('#etap_id').val(datajson.etap_id);
    $('#nombre_edit').val(datajson.nombre);
    $('#nom_recipiente_edit').val(datajson.recipiente);
    $('#orden_edit').val(datajson.orden);
    $('#tipo_edit').val(datajson.tipo);
    $('#proc_id_edit option[value="'+ datajson.proc_id +'"]').attr("selected",true);
    $('#tiet_id_edit option[value="'+ datajson.tiet_id +'"]').attr("selected",true);
    $('#form_id_edit option[value="'+ datajson.form_id +'"]').attr("selected",true);
  }

  // deshabilita botones, selects e inputs de modal
  function blockEdicion(){
    $(".habilitar").attr("readonly","readonly");
    $("#proc_id_edit").attr('disabled', 'disabled');
    $("#tiet_id_edit").attr('disabled', 'disabled');
    $("#form_id_edit").attr('disabled', 'disabled');
    $('#btnsave_edit').hide();
  }

  // habilita botones, selects e inputs de modal
  function habilitarEdicion(){
    $('.habilitar').removeAttr("readonly");//
    $("#proc_id_edit").removeAttr("disabled");
    $("#tiet_id_edit").removeAttr("disabled");
    $("#form_id_edit").removeAttr("disabled");
    $('#btnsave_edit').show();
  }

  // Levanta modal prevencion eliminar herramienta
  $(".btnEliminar").on("click", function() {
    $(".modal-header h4").remove();
    $(".modal-header").append('<h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-fw fa-times text-light-blue"></span> Eliminar Herramienta </h4>');
    datajson = $(this).parents("tr").attr("data-json");
    data = JSON.parse(datajson);
    var etap_id = data.etap_id;
    // guardo etap_id en modal para usar en funcion eliminar
    $("#id_etap").val(etap_id);
    //levanto modal
    $("#modalaviso").modal('show');
  });

  // Elimina herramienta
  function eliminar(){
    var etap_id = $("#id_etap").val();
    wo();
    $.ajax({
        type: 'POST',
        data:{etap_id: etap_id},
        url: 'index.php/<?php echo PRD ?>general/Etapa/borrarEtapa',
        success: function(result) {
          $("#cargar_tabla").load("<?php echo base_url(PRD); ?>general/Etapa/listarEtapas");
          wc();
          $("#modalaviso").modal('hide');
          alertify.success("Etapa Productiva eliminada con éxito");
        },
        error: function(result){
          wc();
          $("#modalaviso").modal('hide');
          alertify.error('Error en eliminado de Etapa Productiva...');
        }
    });
  }

  // Config Tabla
  DataTable($('#tabla_etapas_productivas'));
</script>

<!-- Modal aviso eliminar etapa productiva-->
<div class="modal fade" id="modalaviso">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-blue">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-trash text-light-blue"></span> Eliminar Etapa Productiva</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12">
              <h4>¿Desea realmente eliminar esta Etapa Productiva?</h4>
              <input type="text" id="id_etap" class="hidden">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="eliminar()">Aceptar</button>
        </div>
      </div>
    </div>
</div>
<!-- /  Modal aviso eliminar -->
