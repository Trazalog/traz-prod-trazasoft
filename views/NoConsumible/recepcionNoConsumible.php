<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">Recepción de un No Consumible</h4>
    </div>
    <div class="box-body">
    <br>
      <div class="row">

        <label for="" class="col-md-2">Establecimiento:</label>
        <div class="col-md-3">
            <select class="form-control select2 select2-hidden-accesible" id="establecimiento"
                name="establecimiento" onchange="selectEstablecimiento()" <?php echo req() ?>>
                <option value="" disabled selected>Seleccionar</option>
                <?php
                    if(is_array($tipoEstablecimiento)){
                      foreach ($tipoEstablecimiento as $i) {
                        echo "<option value = $i->esta_id>$i->nombre</option>";
                      }
                    }
                ?>
            </select>
            <span id="estabSelected" style="color: forestgreen;"></span>
        </div>

        <label class="col-md-1 control-label" for="depositos">Depósito:</label>
        <div class="col-md-2">
            <select class="form-control select2 select2-hidden-accesible" id="depositos" name="depositos"
                onchange="selectDeposito()" <?php echo req() ?>>
            </select>
            <span id="deposSelected" style="color: forestgreen;"></span>
        </div>

      </div>

      <br>

      <div class="row">
        <div class="col-md-4">
          <label>Escanear No Consmible</label>
          <div class="input-group">
            <input id="codigo" class="form-control" placeholder="Busque Código..." autocomplete="off" onchange="consultar()">
            <span class="input-group-btn">
                <button class="btn btn-primary" style="cursor:not-allowed">
                    <i class="glyphicon glyphicon-search"></i></button>
            </span>
          </div>
        </div>
      </div>

      <br>

      <div class="box-body table-scroll table-responsive">
          <table id="tbl_NoConsumibles" class="table table-striped table-hover">
              <thead>
                  <tr>
                    <th>Borrar</th>
                    <th>Código</th>
                    <th>Descripción</th>
                  </tr>
              </thead>
              <tbody>    </tbody>
          </table>
      </div>

      <div class="col-md-12">
        <button class="btn btn-primary pull-right" onclick="guardar()">Guardar</button>
      </div>

    </div>

</div>

<script>
  // selecciona el establecimientoy cargar los depositos
  function selectEstablecimiento() {
      var esta_id = $('#establecimiento').val();
      $('#estabSelected').text('');
      $('#deposSelected').text('');
      $('#recipSelected').text('');

      wo();
      $.ajax({
        type: 'GET',
        data: {
          esta_id: esta_id
        },
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Establecimiento/obtenerDepositos/',
        success: function(rsp) {
          var datos = "<option value='' disabled selected>Seleccionar</option>";
          for (let i = 0; i < rsp.length; i++) {
            datos += "<option value=" + rsp[i].depo_id + ">" + rsp[i].descripcion + "</option>";
          }
          selectSearch('establecimiento', 'estabSelected');
          $('#depositos').html(datos);
        },
        error: function(rsp) {
          if (rsp) {
            alert(rsp.responseText);
          } else {
            alert("No se pudieron cargar los depositos del establecimiento seleccionado.");
          }
        },
        complete: function(rsp) {
          wc();
        },
      });
  }

  function selectDeposito() {
      selectSearch('depositos', 'deposSelected');
  }

  /* selectSearch: busca en un select un valor selecionado y lo coloca en el "spanSelected" */
  function selectSearch(select, span) {
      var option = $('#' + select).val();
      $('#' + select).find('option').each(function() {
        if ($(this).val() == option) {
          $('#' + span).text($(this).text());
        }
      });
  }

  // consulta la informacion de No Consum por codigo
  function consultar(){

      wo('Buscando Informacion');
      var codigo = $("#codigo").val();
      // if(codigo = ""){
      //   return;
      // }

      $.ajax({
          type: 'POST',
          dataType:'json',
          data:{codigo: codigo },
          url: '<?php echo base_url(PRD) ?>general/Noconsumible/consultarInfo',
          success: function(result) {
              wc();
              var lotes = result.lotes;

              if(Object.entries(lotes).length === 0){
                $("#codigo").val("");
                alertify.error('El recipiente escaneado se encuentra vacío...');
              }else{
                agregar(result);
              }
          },
          error: function(result){
              wc();
          },
          complete: function(){
              wc();
          }
      });
  }

  // Agrega registro en tabla temporal
  function agregar(info){

      $("#establecimiento").prop('disabled', 'disabled');
      $("#depositos").prop('disabled', 'disabled');

      var lotes = info.lotes.lote;
      var datos = {};
      var cantEnvases = 0;

      $.each(lotes, function(key,value) {
        datos.noco_id = info.codigo;
        datos.batch_id = value.batch_id;
        cantEnvases++;
      });

      if (cantEnvases > 1) {
        alert('Error en datos de No Consumible, intente escanear otro Codigo');
        $("#codigo").val("");
        return;
      }

      var table = $('#tbl_NoConsumibles').DataTable();
      var row = `<tr data-json='${JSON.stringify(datos)}'>
              <td> <i class='fa fa-fw fa-minus text-light-blue' style='cursor: pointer; margin-left: 15px;'></i> </td>
              <td>${info.codigo}</td>
              <td>${info.descripcion}</td>
          </tr>`;
      table.row.add($(row)).draw();

      $("#codigo").val("");
  }

  // guarda la recepcion
  function guardar() {

    if($("#tbl_NoConsumibles tbody tr td").length <= 1){

        alert('Por agregue datos a la tabla');
        return;
    }else{

        var datos = [];
        var rows = $('#tbl_NoConsumibles tbody tr');
        $.each(rows, function(i,e) {
            var datajson = $(this).attr("data-json");
            var data = JSON.parse( datajson );
            datos.push(data);
        });

        var deposito = {};
        deposito = $('#depositos').val();

        wo("Liberando...");
        $.ajax({
              type: 'POST',
              data:{datos,deposito},
              dataType: 'json',
              url: '<?php echo base_url(PRD) ?>general/Noconsumible/liberarNoConsumible',
              success: function(result) {
                    wc();
                    $('#tbl_NoConsumibles tbody tr').remove().draw();
                    $('#btn_guardar').attr("disabled", "");
                    alertify.success("No Consumibles Liberados Exitosamente....!");
              },
              error: function(result){
                    wc();
                    alertify.error("Error liberando No Consumibles");
              },
              complete: function(){
                    wc();
              }
        });
    }
  }

  // Remueve fila de tabla temporal
  $(document).on("click",".fa-minus",function() {

    $('#tbl_NoConsumibles').DataTable().row( $(this).closest('tr') ).remove().draw();

      if($("#tbl_NoConsumibles tbody tr td").length <= 1){
        $("#establecimiento").prop('disabled', false);
        $("#depositos").prop('disabled', false);
      }

      if( tabla.data().any() ) {
        $("#establecimiento").prop('disabled', false);
        $("#depositos").prop('disabled', false);
      }
	});

</script>