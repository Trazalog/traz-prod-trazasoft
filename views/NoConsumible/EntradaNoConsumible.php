<div class="box box-primary tag-descarga">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" id="minimizar_vale_entrada" data-widget="collapse"
                data-toggle="tooltip" title="" data-original-title="Collapse">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title=""
                data-original-title="Remove">
                <i class="fa fa-times"></i></button>
        </div>
        <h4 class="box-title">Vale de Entrada</h4>
    </div>
    <div class="box-body" id="div_vale_entrada">
    <form class="form-horizontal" id="frm-MovimientoNoConsumible">
            <label for="codigo" class="col-md-1">Codigo No Consumible:</label>
            <div class="col-md-2">
                <input id="codigoNoCon" name="codigoNoCon" type="text" placeholder="" class="form-control input-md">
            </div>
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
            <div class="col-md-1">
                <button class="btn btn-primary" style="margin-top:23px; float:right;"  onclick="agregarFilaNoCon()">Agregar</button>
            </div>
        </form>

        <table class="table table-striped table-hover"  id="tablaNoCon">
            <br><br>
            <thead>
                <th></th>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Fecha de Salida</th>
                <th>Establecimiento</th>
                <th>Deposito</th>
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


function agregarFilaNoCon() {
   

    var codigo = $('#codigoNoCon').val();
    var establecimiento = $('#establecimiento').val();
    var estabSelected =  $('#estabSelected').text();
    var depositos = $('#depositos').val();
    var deposSelected = $('#deposSelected').text();


    datos = new FormData($('frm-MovimientoNoConsumible')[0]);
    datos = formToObject(datos);

    var objFecha = new Date();

    var dia  = objFecha.getDate();
    var mes  = objFecha.getMonth();
    var anio = objFecha.getFullYear();

    html = '<tr>' +
      '<td><a type = "button" class = "del pull-right" style = "cursor: pointer;"><i class = "fa fa-times text-danger"></i></a></td>' +
      '<td value=' + codigo + '>' + codigo + '</td>' +
      '<td></td>' +
      '<td>'+  dia + "/" + mes + "/" + anio  +'</td>' +
      '<td value=' + establecimiento + '>' + $('#estabSelected').text() + '</td>' +
      '<td value=' + depositos + '>' + $('#deposSelected').text() + '</td>' +
      '</tr>';
    $('#tablaNoCon tbody').append(html);
    $('#frm-MovimientoNoConsumible')[0].reset();
  }
 //Quitar fila de tabla
 $("#tablaNoCon").on("click", ".del", function() {
    $(this).parents("tr").remove();
  });


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
    })
  }

  function selectDeposito() {
    var esta_id = $('#establecimiento').val();
    var depo_id = $('#depositos').val();
    $('#deposSelected').text('');
    $('#recipSelected').text('');
    wo();
    $.ajax({
      type: 'GET',
      data: {
        esta_id: esta_id,
        depo_id: depo_id
      },
      dataType: 'JSON',
      url: '<?php echo base_url(PRD) ?>general/Establecimiento/obtenerRecipientesDeposito/',
      success: function(rsp) {
        var datos = "<option value='' disabled selected>Seleccionar</option>";
        for (let i = 0; i < rsp.length; i++) {
          datos += "<option value=" + rsp[i].nombre + ">" + rsp[i].nombre + "</option>";
        }
        selectSearch('depositos', 'deposSelected');
        $('#tipo_residuo').html(datos);
      },
      error: function(rsp) {
        if (rsp) {
          alert(rsp.responseText);
        } else {
          alert("No se pudieron cargar los recipientes.");
        }
      },
      complete: function(rsp) {
        wc();
      },
    })
  }

  function selectRecipiente() {
    selectSearch('tipo_residuo', 'recipSelected');
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


function guardarEntradaNoCon() {
    //Datos de la tabla de
    var datosTabla = new Array();
    $('#tablaNoCon tr').each(function(row, tr) {
      datosTabla[row] = {
        "codigo": $(tr).find('td:eq(1)').attr('value'),     
        "establecimiento": $(tr).find('td:eq(4)').attr('value'),
        "depositos": $(tr).find('td:eq(5)').attr('value')

      }
    });
    datosTabla.shift(); //borra encabezado de la tabla o primera fila
    var datos = JSON.stringify(datosTabla);
     console.log('datos: ' + datos);
    wo();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(PRD) ?>general/Noconsumible/guardarMovimientoEntrada',
      data: {
        datos: datos
      },
      success: function(rsp) {
           Swal.fire(
            'Agregado/s!',
            'El Proceso se Realizó Correctamente.',
            'success'
          )
      },
      error: function() {
        Swal.fire(
                      'Oops...',
                        'Algo salio mal!',
                        'error'
                              )
      },
      complete: function() {
        wc();
      }
    });
  }

</script>
