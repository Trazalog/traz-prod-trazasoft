<div class="box box-primary tag-descarga">
<div class="box-header with-border">
<div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" id="minimizar_vale_salida" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
        <i class="fa fa-times"></i></button>
    </div>
<h4 class="box-title">Vale de Salida</h4>
    </div>
    <div class="box-body" id="div_vale_entrada">
    <form class="form-horizontal" id="frm-MovimientoNoConsumible">
            <label for="codigo" class="col-md-1">Codigo No Consumible:</label>
            <div class="col-md-2">
                <input id="codigo" name="codigo" type="text" placeholder="" class="form-control input-md">
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
                <button class="btn btn-primary" style="margin-top:23px; float:right;"><i
                        class="fa fa-plus"></i></button>
            </div>
        </form>

        <table class="table table-striped table-hover">
            <br><br>
            <thead>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Fecha de Salida</th>
                <th>deposito</th>
            </thead>
            <tbody id="">

            </tbody>
        </table>
        <hr>

        
        <button id="guardarMovimientoSalida" class="btn btn-primary btn-sm" style="float:right"
            onclick="guardarMovimientoSalida()"></i>Guardar Salida</button>
        <button id="imprimirMovimientoSalida" class="btn btn-primary btn-sm" style="float:right" onclick="imprimirMovimientoSalida()" disabled><i
                class="fa fa-echo"> </i> Imprimir Vale</button>

    </div>
</div>

<script>
// var fila = null;

// function agregarFila(data) {

//     var lote_origen = $('#new_codigo').hasClass('hidden')?$('#codigo').select2('data')[0].text:$('#new_codigo').val();

//     $('#lotes').append(
//         `<tr data-json='${JSON.stringify(data)}' class='${loteSistema?'lote-sistema':'lote'}'>
//             <td class="text-center"><i class="fa fa-times text-danger" onclick="fila = $(this).closest('tr'); $('#eliminar_fila').modal('show');"></i></td>
//             <td>${lote_origen}</td>
//             <td>${$('.frm-destino #art-detalle').val()}</td>
//             <td>${data.destino.cantidad + ' | ' + data.destino.unidad_medida}</td>
//             <td>${data.destino.lote_id}</td>
//             <td>${loteSistema?'<i class="fa fa-barcode text-blue" title="Lote Trazable"></i>':''}</td>
//         </tr>`
//     );

//     $('#guardarDescarga').attr('disabled', false);
// }

// function guardarDescargaOrigen() {

//      //Guardar Datos de Camión parametro = FALSE es para NO mostrar el MSJ de Datos Guardados
//     if($('#lotes tr').length != 0) addCamion(false);

//     var array = [];
//     $('#lotes tr.lote').each(function() {
//         array.push(JSON.parse(this.dataset.json));
//     });

//     if(array.length == 0) return;


//     $.ajax({
//         type: 'POST',
//         dataType: 'JSON',
//         url: 'index.php/general/Camion/guardarDescarga',
//         data: {
//             array
//         },
//         success: function(rsp) {
//             if(rsp.status){
//               alert('Hecho');
//               linkTo();
//             }else{
//                 alert('Falla al Guardar Descarga');
//             }
//         },
//         error: function(rsp) {
//             alert('Error: ' + rsp.msj);
//             console.log(rsp.msj);
//         }
//     });
// }

// function guardarLoteSistema(){

//     var frmCamion = obtenerFormularioCamion();

//     var array = [];
//     $('#lotes tr.lote-sistema').each(function() {
//         const e = JSON.parse(this.dataset.json);
//         e.loteSistema = loteSistemaData;
//         array.push(e);
//     });

//     if (array.length == 0) return;

//     wo();
//     $.ajax({
//         type: 'POST',
//         dataType: 'JSON',
//         url: 'index.php/general/Camion/guardarLoteSistema',
//         data: {
//             array,
//             frmCamion
//         },
//         success: function(rsp) {
//             if(rsp.status == true){
//               alert('Hecho');
//               linkTo();
//             }else{
//                 alert('Falla al Guardar Lotes Sistema');
//             }
//         },
//         error: function(rsp) {
//             alert('Error: ' + rsp.msj);
//             console.log(rsp.msj);
//         },
//         complete:function(){
//             wc();
//         }
//     });

// }

// function eliminarFila() {
//     var json = getJson($(fila));
//     if (!json) return;
//     $('.frm-origen #cantidad').val(parseFloat($('.frm-origen #cantidad').val()) + parseFloat(json.destino.cantidad));
//     $(fila).remove();

//     $('#guardarDescarga').attr('disabled', $('#lotes tr').length == 0);
// }

///////////////////////////
///////////////////////////////////////////////////
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



///////////////////////////////////////
/////////////////////////////////////////////////////

initForm();
    function guardarMovimientoSalida() {

        var formData = new FormData($('#frm-MovimientoNoConsumible')[0]);
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo base_url(PRD) ?>general/Noconsumible/guardarMovimientoSalida',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(rsp) {
                if (rsp.status) {
                    console.log('SI entra');
                    alert('El registro se Guardo Correctamente');
                    $('#frm-MovimientoNoConsumible')[0].reset();
                    linkTo();
                } else {
                    console.log('NO entra');
                    alert('Error Tremendo');
                }

            },
            error: function(rsp) {
                alert('Error: No se pudo Guardar');
                console.log(rsp.msj);
            },
            complete: function() {
                wc();
            }
        });
    }


$("#consumible").autocomplete({
    source: "autocompleta_denunciante.php",
    minLength: 2,
    select: function(event, ui) {
        event.preventDefault();
        $('#consumible').val(ui.item.dni);

    }
});
</script>

<div class="modal fade" id="eliminar_fila" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center">¿Desea Eliminar Registro?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="eliminarFila()">Si</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>