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
					echo "<tr data-json='".json_encode($rsp)."'>";
					// echo "<tr id='$rsp->etap_id' data-json='" . json_encode($rsp) . "'>";
						echo "<td class='text-center text-light-blue'>";
							echo '<button type="button" title="Editar"  class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modaleditar" id="btnEditar" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp';
							echo '<button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modaleditar" ><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp';
							echo '<button type="button" title="Ver Artículos" class="btn btn-primary btn-circle btnArticulos" ><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></button>&nbsp';
							echo '<button type="button" title="Eliminar" class="btn btn-primary btn-circle btnEliminar" id="btnBorrar"  ><span class="glyphicon glyphicon-trash" aria-hidden="true" ></span></button>&nbsp';
						echo "</td>";
            // echo '<td class="hide"/>'.$rsp->etap_id.'</td>';
						echo '<td>'.$rsp->nombre.'</td>';
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
    $("#modalarticulos td").remove();
    $(".modal-header h4").remove();
    //guardo el tipo de operacion en el modal
    $("#operacion").val("Articulos");
    //pongo titlo al modal
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
          if (result) {
            var tabla = $('#modalarticulos table');    
            $(tabla).find('tbody').html('');
            result.forEach(e => {
                if (e.es_caja == true){
                  e.es_caja = "SI";
                }else{
                  e.es_caja = "NO";
                };
                $(tabla).append(
                  "<tr data-json= ' "+ JSON.stringify(e) +" '>" +
                    "<td><button type='button' title='Eliminar Artículo' class='btn btn-primary btn-circle btnEliminar' onclick='eliminarArticulo(this)' id='btnBorrar'><span class='glyphicon glyphicon-trash' aria-hidden='true' ></span></button>" +
                    "<td>" + e.barcode + "</td>" +
                    "<td>" + e.descripcion + "</td>" +
                    "<td>" + e.tipo + "</td>" +
                    "<td>" + e.unidad_medida + "</td>" +
                    "<td>" + e.es_caja + "</td>" +
                    "<td class='text-center'>" + e.cantidad_caja + "</td>" +
                  "</tr>"
                );
            });            
          };
          $('#modalarticulos').modal('show'); 
        },
        error: function(result) {
            alert('Error');
        },
        dataType: 'json'
    });
    //levanto modal
    // $("#modalarticulos").modal('show');
  });  
  // llena modal paa edicio y muestra
  function llenarModal(datajson){
    $('#etap_id').val(datajson.etap_id);
    //$('#pano_id').val(datajson.pano_id);
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

  // function eliminarArticulo(e) {
  //   var data = JSON.parse($(e).closest('tr').attr('data-json'));
  //   var arti_id = data.arti_id;
  //   var tipo = data.tipo;
  //   // var etap_id = data.etap_id;
  //   $('#arti_id').val(data.arti_id);
  //   $('#tipo').val(data.tipo);
  //   var etap_id = $("#id_etap").val();
  //   // var etap_id = $("#etapa_id").val();
  //   $("#id_etapa").val(etap_id);

  //   $(".modal-header h4").remove();
  //   //pongo titulo al modal
  //   $(".modal-header").append('<h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-fw fa-pencil"></span> Eliminar Artículo </h4>');
  //   $("#modalarticulos").modal('hide');
  //   $('#modalAvisoArticulo').modal('show');
	// }

  // function eliminarArticuloDeEtapa() {
  //       var arti_id = $("#arti_id").val();
  //       var tipo = $("#tipo").val();
  //       var etap_id = $("#id_etapa_borrar").val();
  //       wo();
  //       $.ajax({
  //           type: 'POST',
  //           data:{arti_id: arti_id, tipo: tipo, etap_id: etap_id},
  //           url: 'index.php/<?php echo PRD ?>general/Etapa/borrarArticuloDeEtapa',
  //           success: function(result) {
  //             $("#cargar_tabla").load("<?php echo base_url(PRD); ?>general/Etapa/listarEtapas");
  //             alertify.success("Artículo eliminado con éxito");
  //             wc();
  //             $("#modalAvisoArticulo").modal('hide');
  //           },
  //           error: function(result){
  //             wc();
  //             $("#modalAvisoArticulo").modal('hide');
  //             alertify.error('Error en eliminado de Artículo...');
  //           }
  //       });        
  //   }

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

<!-- Modal aviso eliminar articulo-->
<!-- <div class="modal fade" id="modalAvisoArticulo">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-blue">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-trash text-light-blue"></span> Eliminar Artículo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12">
              <h4>¿Desea realmente eliminar el artículo de la etapa productiva?</h4>
              <input type="text" id="arti_id" class="hidden">
              <input type="text" id="tipo" class="hidden">
              <input type="text" id="id_etapa_borrar" class="hidden">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="eliminarArticuloDeEtapa()">Aceptar</button>
        </div>
      </div>
    </div>
</div> -->
<!-- /  Modal aviso eliminar -->
