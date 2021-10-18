<div class="box box-primary tag-descarga">
    <div class="box-header with-border">
        <!-- <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" id="minimizar_vale_entrada" data-widget="collapse"
                data-toggle="tooltip" title="" data-original-title="Collapse">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title=""
                data-original-title="Remove">
                <i class="fa fa-times"></i></button>
        </div> -->
        <h4 class="box-title">Entrada No Consumibles</h4>
    </div>
    <div class="box-body" id="div_vale_entrada">
    <form class="form-horizontal" id="frm-MovimientoNoConsumible">
            <label for="codigo" class="col-md-2 control-label">Código No Consumible:</label>
            <div class="col-md-2">
                <input id="codigoNoCon" name="codigoNoCon" type="text" placeholder="" class="form-control input-md">
            </div>

            <label class="col-md-1 control-label" for="depositos">Depósito:</label>
            <div class="col-md-2">
                <select class="form-control select2 select2-hidden-accesible" id="depositos" name="depositos"
                    onchange="selectDeposito()" <?php echo req() ?>>
                </select>
                <span id="deposSelected" style="color: forestgreen;"></span>
            </div>
            <div class="col-md-2" style="text-align:center;">
                <button type="button" class="btn btn-primary" style="" onclick="agregarFilaNoCon()">Agregar</button>
            </div>
        </form>

        <table class="table table-striped table-hover"  id="tablaNoCon">
            <br><br>
            <thead>
                <th>Quitar</th>
                <th>Código</th>
                <th>Fecha de Salida</th>
                <th>Depósito</th>
            </thead>
            <tbody>

            </tbody>
        </table>
        <hr>

<!--         
        <button id="guardarMovimientoEntrada" class="btn btn-primary btn-sm" style="float:right"
            onclick="guardarEntradaNoCon()"></i>Guardar Entrada</button>
        <button id="guardarMovimientoEntrada" class="btn btn-primary btn-sm" style="float:right" onclick="imprimirMovimientoEntrada()" disabled><i
                class="fa fa-echo"> </i> Imprimir Vale</button> -->

    </div>
</div>

<script>
  $(document).ready(function () {
    $("#depositos").attr("disabled","disabled");
  });
  // Agrega fila en tabla temporal para guardar
  function agregarFilaNoCon() {


    var codigo = $('#codigoNoCon').val();
    var estabSelected =  $('#estabSelected').text();
    var depositos = $('#depositos').val();
    var deposSelected = $('#deposSelected').text();

    if(depositos == null){
      Swal.fire('Error', "No se seleccionó deposito!",'error');
      return;
    }

    //Validamos el codigo del no consumible ingresado
    if(codigo != ''){
      validaNoCon(codigo).then((result) => {
    
        datos = new FormData($('frm-MovimientoNoConsumible')[0]);
        datos = formToObject(datos);

        var objFecha = new Date();

        var dia  = objFecha.getDate();
        var mes  = objFecha.getMonth();
        var anio = objFecha.getFullYear();

        html = '<tr>' +
          '<td><i class = "fa fa-times text-danger btn btnEliminar"></i></td>' +
          '<td value=' + codigo + '>' + codigo + '</td>' +
          '<td>'+  dia + "/" + mes + "/" + anio  +'</td>' +
          '<td value=' + depositos + '>' + $('#deposSelected').text() + '</td>' +
          '</tr>';
        $('#tablaNoCon tbody').append(html);
        $('#frm-MovimientoNoConsumible')[0].reset();
      }).catch((err) => {

      Swal.fire('Error', err,'error');

    });
    }else{
      Swal.fire('Error', 'No se ingreso un código de no consumible!','error');
    }
  }
  //Quitar fila de tabla
  $("#tablaNoCon").on("click", ".btnEliminar", function() {
      $(this).parents("tr").remove();
    });

  // Al seleccionar establecimiento, busca los depositos
  function selectEstablecimiento() {
    var esta_id = $('#establecimientos').val();
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

        $("#depositos").attr("disabled",false);

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
        $("#depositos").attr("disabled","disabled");
      },
      complete: function(rsp) {
        wc();
      },
    })
  }
  // Al seleccionar depositos lo indica bajo el select
  function selectDeposito() {
    selectSearch('depositos', 'deposSelected');
  }
  // function selectRecipiente() {
   //   selectSearch('tipo_residuo', 'recipSelected');
  // }
  /* selectSearch: busca en un select un valor selecionado y lo coloca en el "spanSelected" */
  function selectSearch(select, span) {
    var option = $('#' + select).val();
    $('#' + select).find('option').each(function() {
      if ($(this).val() == option) {
        $('#' + span).text($(this).text());
      }
    });
  }
  // Guarada el ingreso de no consumible
  function guardarEntradaNoCon() {
    //Datos de la tabla de No consumibles
    var datosTabla = new Array();
    $('#tablaNoCon tr').each(function(row, tr) {
      datosTabla[row] = {
        "noco_id": $(tr).find('td:eq(1)').attr('value'),
        "establecimiento": $("#establecimientos").val(),
        "depositos": $(tr).find('td:eq(3)').attr('value')
      }
    });
    datosTabla.shift(); //borra encabezado de la tabla o primera fila
    var datos = JSON.stringify(datosTabla);
    
    wo();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(PRD) ?>general/Noconsumible/guardarMovimientoEntrada',
      data: {
        datos: datos
      },
      success: function(rsp) {
        console.log('Entrada no consumibles se realizó correctamente');
      },
      error: function() {
        Swal.fire(
          'Oops...',
          'Se produjo un error al realizar la entrada de no consumibles',
          'error'
        )
      },
      complete: function() {
        wc();
      }
    });
  }
  
// consultamos la informacion de No Con por codigo ingresado
async function validaNoCon(codigo){

  wo();

  var consultaNoCon = new Promise((resolve, reject) => {
    
    $.ajax({
        type: 'POST',
        dataType:'json',
        data:{codigo: codigo },
        url: '<?php echo base_url(PRD) ?>general/Noconsumible/consultarInfo',
        success: function(result) {
          wc();
          var lotes = result.lotes;
          if(!$.isEmptyObject(result)){

            if(Object.entries(lotes).length === 0){
              reject('El recipiente escaneado se encuentra vacío...');
            }else{
              resolve(result);
            }

          }else{
            reject('El recipiente escaneado no se encuentra cargado...');
          }
        },
        error: function(result){
          wc();
          reject('Se produjo un error al consultar el no consumible');
        },
        complete: function(){
            wc();
        }
    });
  });

  return await consultaNoCon;
}
</script>
