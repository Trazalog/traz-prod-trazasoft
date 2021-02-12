<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">Recepción de un No Consumible</h4>
    </div>
    <div class="box-body">

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

      <!-- <button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;" data-toggle="modal" data-target="#mdl-NoConsumible">Agregar</button> -->

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
        <button class="btn btn-primary pull-right" onclick="guardar()">Agregar</button>
      </div>

    </div>

</div>

<script>
  // conslta la informacion de No Consum por codigo
  function consultar(){

    wo('Buscando Informacion');
    var codigo = $("#codigo").val();

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

    wo("Liberando...");
    if( !$('#tbl_NoConsumibles').DataTable().data().any() )
		{
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

        $.ajax({
            type: 'POST',
            data:{datos},
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
              alertify.error("Error en liberando No Consumibles");
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
	});

</script>