<style>
  .input-group-addon:hover{
    background-color: #13668c !important;
    cursor: pointer;
  }
</style>
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
      <h4 class="box-title">Salida No Consumibles</h4>
  </div>
  <div class="box-body" id="div_vale_entrada">
    <form class="form-horizontal" id="frm-MovimientoNoConsumible">
      <div class="row">
        <div class="col-md-4">
          <label for="codigo">Código No Consumible:</label>
          <input id="codigoNoCon" name="codigoNoCon" type="text" placeholder="" class="form-control input-md">
        </div>
        <!-- <label for="" class="col-md-2">Establecimiento:</label>
        <div class="col-md-2">
            <select class="form-control select2 select2-hidden-accesible" id="establecimiento"
                name="establecimiento" onchange="selectEstablecimiento()" <?php //echo req() ?>>
                <option value="" disabled selected>- Seleccionar - </option>
                <?php
                  //if(is_array($tipoEstablecimiento)){
                  //foreach ($tipoEstablecimiento as $i) {
                  //echo "<option value = $i->esta_id>$i->nombre</option>";
                    //   }
                    // }
                  ?>
            </select>
            <span id="estabSelected" style="color: forestgreen;"></span>
        </div> -->
        <div class="col-md-4">
          <div id='div_destino'>
            <label for="destino">Destino:</label>
            <div class="input-group">
              <select name="destino" id="destino" class="form-control">
                <option value="" disabled selected> - Seleccionar - </option>
              <?php 
                  if(is_array($destinoNoConsumible)){
                  foreach ($destinoNoConsumible as $i) {
                  echo "<option value ='".$i->tabl_id."' > $i->valor </option>";
                        }
                      }
                  ?>
              </select>
              <span style="color: #fff;;background-color: #3c8dbc;border-color: #367fa9;" class="input-group-addon" data-toggle="modal" data-target="#mdl-destino"><i class="fa fa-plus"></i></span>
            </div>
            <span id="destinoSelected" style="color: forestgreen;"></span>
          </div>
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary" style="margin-top:25px;"  onclick="agregarFilaNoCon()">Agregar</button>
        </div>
      </div>
    </form>

    <table class="table table-striped table-hover"  id="tablaNoCon">
        <br><br>
        <thead>
            <th></th>
            <th>Codigo</th>
            <!-- <th>Descripcion</th> -->
            <th>Fecha de Salida</th>
            <!-- <th>Establecimiento</th> -->
            <th>Destino</th>
        </thead>
        <tbody>

        </tbody>
    </table>
    <hr>
<!-- 
        
        <button id="guardarMovimientoSalida" class="btn btn-primary btn-sm" style="float:right"
            onclick="guardarSalidaNoCon()"></i>Guardar Salida</button>
        <button id="guardarMovimientoSalida" class="btn btn-primary btn-sm" style="float:right" onclick="imprimirMovimientoSalida()" disabled><i
                class="fa fa-echo"> </i> Imprimir Vale</button> -->

  </div><!-- box-header with-border -->
</div><!-- box box-primary tag-descarga-->


  <!-- Modal  No Consumible-->
  <div class="modal fade bd-example-modal-md" tabindex="-1" id="mdl-destino" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mdl-titulo">Agregar Destino</h4>
                </div>

                <div class="modal-body" id="modalBody">

                    <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        Revise que todos los campos esten completos
                    </div>

                    <form class="form-horizontal" id="frm-destino">
                        <fieldset id="read-only">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="destino">Destino<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-4">
                                        <input id="valor" name="valor" type="text" placeholder="Ingrese destino..."
                                            class="form-control input-md" required>
                                    </div>
                                    <label class="col-md-2 control-label" for="descripcion">Descripción<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-4">
                                    <input id="descripcion" name="descripcion" type="text" placeholder="Ingrese descripción..."
                                            class="form-control input-md" required>
                                    </div>
                                </div>
                            </fieldset>
                    </form>
                </div> <!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-accion" class="btn btn-primary btn-guardar"
                        onclick="guardarDestino()">Agregar</button>
                </div>
            </div>
        </div>
    </div>




<script>

  function agregarFilaNoCon() {

    codigo = $('#codigoNoCon').val();
    destino = $('#destino').val();
    destinoSelected = $('#destino option:selected').text();

    if(destino == null){
      Swal.fire('Error', "No se seleccionó destino!",'error');
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
          '<td value="' + codigo + '">' + codigo + '</td>' +
          '<td>'+  dia + "/" + mes + "/" + anio  +'</td>' +
          '<td value="' + destino + '">' + destinoSelected + '</td>' +
        '</tr>';

        $('#tablaNoCon tbody').append(html);
        $('#frm-MovimientoNoConsumible')[0].reset();
        alertify.success("Se agrego no consumible exitosamente");

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

  // function selectDestino() {
  //   selectSearch('destino', 'recipSelected');
  // }

  /* selectSearch: busca en un select un valor selecionado y lo coloca en el "spanSelected" */
  // function selectSearch(select, span) {
    //   var option = $('#' + select).val();
    //   $('#' + select).find('option').each(function() {
    //     if ($(this).val() == option) {
    //       $('#' + span).text($(this).text());
    //     }
    //   });
  // }



  // function guardarSalidaNoCon() {
      //     //Datos de la tabla de recipientes
      //     var datosTabla = new Array();
      //     $('#tablaNoCon tr').each(function(row, tr) {
      //       datosTabla[row] = {
      //         "codigo": $(tr).find('td:eq(1)').attr('value'),
      //         //"establecimiento": $(tr).find('td:eq(4)').attr('value'),
      //         "destino": $(tr).find('td:eq(3)').attr('value')
      //       }
      //     });

      //     console.log('datos: ' + datos);
      //     //wo();
      //     $.ajax({
      //       type: 'POST',
      //       url: '<?php //echo base_url(PRD) ?>general/Noconsumible/guardarMovimientoSalida',
      //       data: {
      //         datosTabla
      //       },
      //       success: function(rsp) {
      //           //  Swal.fire(
      //           //   'Agregado/s!',
      //           //   'El Proceso se Realizó Correctamente.',
      //           //   'success'
      //           // )
      //           console.log('No consumible guardado.');
      //       },
      //       error: function() {
      //         Swal.fire(
      //                       'Oops...',
      //                         'Algo salio mal!',
      //                         'error'
      //                               )
      //       },
      //       complete: function() {
      //         wc();
      //       }
      //     });
  // }


  initForm();
  // guarda nuevo destino externo
  function guardarDestino() {

    var formData = new FormData($('#frm-destino')[0]);
    if(!frm_validar('#frm-destino')){
      alertify.error("No se completaron los campos obligatorios");
      return;
    }

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Noconsumible/guardarDestino',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(rsp) {

          if (rsp.status) {

            $('#mdl-destino').modal('hide');
              Swal.fire(
                  'Guardado!',
                  'El destino se guardo correctamente.',
                  'success'
                );
              $('#frm-destino')[0].reset();
              destinoExterno();
          } else {
            if(rsp.data.includes("already exists")){
              alertify.error("Este destino ya fue ingresado!");
            }else{
              alertify.error("Se produjo un error al agregar!");
            }
          }
        },
        error: function(rsp) {
          Swal.fire(
              'Error...',
                'Hubo un error al guardar el nuevo destino...',
                'error'
          );
        },
        complete: function() {
          //   wc();
        }
    });
  }

  // recarga select de destinos externos
  function destinoExterno() {
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '<?php echo base_url(PRD) ?>general/Noconsumible/seleccionarDestino',
      data:{},
      success: function(resp) {

            $('#destino').empty();
            $('#destino').append('<option value="" disabled selected>-Seleccione opcion-</option>');
            for(var i=0; i<resp.length; i++)
            {
                $('#destino').append("<option value='" + resp[i].tabl_id + "'>" +resp[i].valor+"</option");
            }
      },
      error: function(rsp) {
        Swal.fire(
                'Error ...',
                  'Hubo un error alguardar el nuevo destino...',
                  'error'
                        );
          $('#mdl-destino').modal('hide');
          console.log(rsp.msj);
      },
      complete: function() {
        //   wc();
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