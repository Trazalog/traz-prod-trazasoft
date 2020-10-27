<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">Listado de No Consumibles</h4>
    </div>
    <div class="box-body">
        <button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;" data-toggle="modal" data-target="#mdl-NoConsumible">Agregar</button>
        <div class="box-body table-scroll table-responsive">
            <table id="tbl-NoConsumibles" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Fecha de Alta</th>
                        <th>Fecha de Vencimiento</th>
                        <th width="10%">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($ListarNoConsumible as $rsp)
                {   $codigo = $rsp->codigo;
                    $estadoNoconsumible = $rsp->estado;
                    $tipo = $rsp->tipo;
                    $descripcion = $rsp->descripcion;
                    $fec_alta = $rsp->fec_alta;
                    $fec_vencimiento = $rsp->fec_vencimiento;
                   echo "<tr id='$codigo' data-json='" . json_encode($rsp) . "'>";
                 
                    echo "<td class='text-center text-light-blue'>";
                    echo '<i class="fa fa-search" style="cursor: pointer;margin: 3px;" title="Ver Detalles" data-toggle="modal" data-target="#mdl-VerNoConsumible" onclick="ver(this)"></i>';
                    echo '<i class="fa fa-fw fa-pencil " style="cursor: pointer; margin: 3px;" title="Editar" data-toggle="modal" data-target="#mdl-EditarNoConsumible" onclick="editar(this)"></i>';      
                    echo '<i class="fa fa-fw fa-times-circle eliminar" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="eliminar(this)"></i>'; 
                    echo '<i class="fa fa-undo" style="cursor: pointer;margin: 3px;" title="Trazabilidad" onclick="trazabilidad(this)"></i>';             
                    echo "</td>";
                    echo '<td>'.$codigo.'</td>';
                    echo '<td>'.$tipo.'</td>';
                    echo '<td>'.$descripcion.'</td>';
                    echo '<td>'.$fec_alta.'</td>';
                    echo '<td>'.$fec_vencimiento.'</td>';
                    echo '<td>'.estadoNoCon($estadoNoconsumible).'</td>';
                    echo '</tr>';
           }

            ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    DataTable('#tbl-NoConsumibles');
    DataTable('#tbl-trazabilidad');
    </script>
  <script>
    initForm();
    function guardarNoConsumible() {

        var formData = new FormData($('#frm-NoConsumible')[0]);
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo base_url(PRD) ?>general/Noconsumible/guardarNoConsumible',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(rsp) {
                if (rsp.status) {
               //   mdlClose('mdl-NoConsumible');
                      $('#mdl-NoConsumible').modal('hide');
                                Swal.fire(
                        'Guardado!',
                        'El registro se Guardo Correctamente',
                        'success'
                                       )
                    $('#frm-NoConsumible')[0].reset();
                    linkTo();
                } else {
                    Swal.fire(
                      'Oops...',
                        'Algo salio mal!',
                        'error'
                              )
                }

            },
            error: function(rsp) {
                Swal.fire(
                      'Oops...',
                        'Algo salio mal!',
                        'error'
                              )
                console.log(rsp.msj);
            },
            complete: function() {
                wc();
            }
        });
    }



    function editarNoConsumible() {

        var formData = new FormData($('#frm-EditarNoConsumible')[0]);
    
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo base_url(PRD) ?>general/Noconsumible/editarNoConsumible',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(rsp) {
                
               // mdlClose('mdl-EditarNoConsumible');
                $('#mdl-EditarNoConsumible').modal('hide');
                        Swal.fire(
                    'Modificado!',
                    'La Modificacion se Realizó Correctamente.',
                    'success'
                                )
                  $('#frm-EditarNoConsumible')[0].reset();
                linkTo();
            },
            error: function(rsp) {
                Swal.fire(
                      'Oops...',
                        'Algo salio mal!',
                        'error'
                              )
                console.log(rsp.msj);
            },
            complete: function() {
                wc();
            }
        });
    }

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



    function ver(e) {
        var json = JSON.parse(JSON.stringify($(e).closest('tr').data('json')));
        Object.keys(json).forEach(function(key, index) {
            $('[name="' + key + '"]').val(json[key]);
        });
    }

    function editar(e) {
        var json = JSON.parse(JSON.stringify($(e).closest('tr').data('json')));
        Object.keys(json).forEach(function(key, index) {
            $('[name="' + key + '"]').val(json[key]);
        });
    }



    // Eliminar No Consumible
    var selected = null;

    function eliminar(e) {
        selected = $(e).closest('tr').attr('id');
        $('#mdl-eliminar').modal('show');
    }

    function eliminarNoConsumible() {
        $.ajax({
            type: 'POST',
            data: {
               codigo: selected
            },
            url: '<?php echo base_url(PRD) ?>general/Noconsumible/eliminarNoConsumible/',
            success: function(data) {
                Swal.fire(
            'Eliminado!',
            'Se Elimino Correctamente.',
            'success'
          )
        
                linkTo();
            },
            error: function(result) {
                console.log('entra por el error');
                console.log(result);
            }

        });
    }
////////////////////

function trazabilidad(e) {
        selected = $(e).closest('tr').attr('id');
        $('#mdl-trazabilidad').modal('show');
        ListarTrazabilidadNoConsumible();
    }
  //  


  function ListarTrazabilidadNoConsumible() {
      wo();
      $('#tnc').empty();
        $.ajax({
            type: 'POST',
            data: {
                codigo: selected
            },
           
            url: '<?php echo base_url(PRD) ?>general/Noconsumible/ListarTrazabilidadNoConsumible',
            success: function(data) {
                $('#tnc').html(data) 
            },
            error: function(result) {
                console.log('entra por el error');
                console.log(result);
            },complete:function(){
                wc()
            }

        });
    }


    </script>
    <!-- Modal  No Consumible-->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="mdl-NoConsumible" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mdl-titulo">ABM No Consumibles</h4>
                </div>

                <div class="modal-body" id="modalBody">

                    <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        Revise que todos los campos esten completos
                    </div>

                    <form class="form-horizontal" id="frm-NoConsumible">
                        <fieldset id="read-only">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="codigo">Código<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-4">
                                        <input id="codigo" name="codigo" type="text" placeholder="Ingrese código..."
                                            class="form-control input-md" required>
                                    </div>
                                    <label class="col-md-2 control-label" for="tipo_no_consumible">Tipo No Consumible<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-4">
                                          <select name="tipo_no_consumible" class="form-control">
                                                    <option value="0"> - Seleccionar - </option>
                                        <?php 
                                        if(is_array($tipoNoConsumible)){
                                            foreach ($tipoNoConsumible as $i) {
                                                echo "<option value = $i->tabl_id>$i->valor</option>";
                                              }
                                        }
                                        ?>
                                           </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="descripcion">Descripción<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="descripcion" name="descripcion"
                                        <?php echo req() ?>></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                 
                                    <label class="col-md-4 control-label" for="fec_vencimiento">Fecha de
                                        vencimiento<strong class="text-danger">*</strong>:</label>
                                    <div class="col-md-8">
                                        <input id="fec_vencimiento" name="fec_vencimiento" type="date"
                                            placeholder="" class="form-control input-md"  <?php echo req() ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                               
                                     <label class="col-md-4 control-label" for="">Establecimiento:</label>
                                        <div class="col-md-8">
                                        <select class="form-control select2 select2-hidden-accesible" id="establecimiento" name="establecimiento" onchange="selectEstablecimiento()" <?php echo req() ?>>
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
                                 </div>
                                 <br>
                                    <!-- ___________________________________________________ -->
                                <div class="form-group">  
                                        <label class="col-md-4 control-label" for="depositos">Depósito:</label>
                                        <div class="col-md-8">
                                        <select class="form-control select2 select2-hidden-accesible" id="depositos" name="depositos" onchange="selectDeposito()" <?php echo req() ?>>
                                        </select>
                                        <span id="deposSelected" style="color: forestgreen;"></span>
                                        </div>
                                    
                                </div>
                            </fieldset>
                    </form>
                </div> <!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-accion" class="btn btn-primary btn-guardar"
                        onclick="guardarNoConsumible()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
<!-------------------------------------------------------->
<!-------------------------------------------------------->

<!-- Modal Editar No Consumible-->
<div class="modal fade bd-example-modal-md" tabindex="-1" id="mdl-EditarNoConsumible" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mdl-titulo">Editar No Consumibles</h4>
                </div>

                <div class="modal-body" id="modalBody">

                    <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        Revise que todos los campos esten completos
                    </div>

                    <form class="form-horizontal" id="frm-EditarNoConsumible">
                        <fieldset id="read-only">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="codigo">Código<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-4">
                                        <input id="codigo" name="codigo" type="text" class="form-control input-md"  <?php echo req() ?>>
                                    </div>
                                    <label class="col-md-2 control-label" for="tipos_no_consumibles">Tipo No Consumible<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-4">
                                          <select name="tipo_no_consumible" class="form-control"  <?php echo req() ?>>
                                                    <option value="0"> - Seleccionar - </option>
                                        <?php 
                                        if(is_array($tipoNoConsumible)){
                                            foreach ($tipoNoConsumible as $i) {
                                                echo "<option value = $i->tabl_id>$i->valor</option>";
                                              }
                                        }
                                        ?>
                                           </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="descripcion">Descripción<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="descripcion" name="descripcion"
                                        <?php echo req() ?>></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                  
                                    <label class="col-md-4 control-label" for="fecha_vencimiento">Fecha de
                                        vencimiento<strong class="text-danger">*</strong>:</label>
                                    <div class="col-md-8">
                                        <input id="fec_vencimiento" name="fec_vencimiento" type="date"
                                            placeholder="" class="form-control input-md"  <?php echo req() ?>>
                                    </div>
                                </div>
                            </fieldset>
                    </form>
                </div> <!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-accion" class="btn btn-primary btn-guardar"
                        onclick="editarNoConsumible()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
<!-------------------------------------------------------->

    <!-- Modal  Ver No Consumible-->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="mdl-VerNoConsumible" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mdl-titulo">Detalle No Consumibles</h4>
                </div>

                <div class="modal-body" id="modalBody">

                    <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        Revise que todos los campos esten completos
                    </div>

                    <form class="form-horizontal" id="frm-NoConsumible">
                        <fieldset id="read-only">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="codigo">Código<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-4">
                                        <input id="codigo" name="codigo" type="text" placeholder="Ingrese código..."
                                            class="form-control input-md" readonly>
                                    </div>
                                    <label class="col-md-2 control-label" for="tipo">Tipo No Consumible<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-4">
                                    <input id="tipo" name="tipo" type="text" placeholder="Ingrese código..."
                                            class="form-control input-md" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="descripcion">Descripción<strong
                                            class="text-danger">*</strong>:</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="descripcion" name="descripcion"
                                         readonly></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="fec_alta">Fecha de
                                        alta<strong class="text-danger">*</strong>:</label>
                                    <div class="col-md-8">
                                        <input id="fec_alta" name="fec_alta" type="text"
                                            placeholder="" class="form-control input-md" readonly>
                                    </div>
                                </div>
                                    <br>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="fec_vencimiento">Fecha de
                                        vencimiento<strong class="text-danger">*</strong>:</label>
                                    <div class="col-md-8">
                                        <input id="fec_vencimiento" name="fec_vencimiento" type="text"
                                            placeholder="" class="form-control input-md" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                     <div class="col-md-6 col-md-offset-6">
                                        <button id="btn-generar_qr" name="btn-generar_qr" class="btn btn-primary">Generar
                                            QR</button>
                                        <br> <br>
                                        <button id="btn-imprimir_qr" name="btn-imprimir_qr" class="btn btn-primary">Imprimir
                                            QR</button>
                                    </div> 
                                </div>
                            </fieldset>
                    </form>
                </div> <!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<!-------------------------------------------------------->




<!-------------------------------------------------------->
<!-- Modal trazabilidad -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="mdl-trazabilidad" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mdl-titulo">Trazabilidad: Nombre No Consumible</h4>
                </div>

                <div class="modal-body" id="modalBodyArticle">

                    <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        Revise que todos los campos esten completos
                    </div>
                   
                        <fieldset id="read-only">
                            <fieldset>
                            <table id="tbl-trazabilidad" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Descripcion</th>
                        <th>Codigo</th>
                        <th>Tipo</th>
                        <th>Responsable</th>
                        <th>Deposito/Destino</th>
                        <th>Fecha de Alta</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="tnc">

                </tbody>
            </table>
                            </fieldset>
                    </form>
                </div> <!-- /.modal-body --> 
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
</div>

  

    <!-- Modal eliminar-->
<div class="modal" id="mdl-eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="modalAction"
                        class="fa fa-fw fa-times-circle text-light-blue"></span> Eliminar Artículo</h4>
            </div> <!-- /.modal-header  -->

            <div class="modal-body" id="modalBodyArticle">
                <p>¿Realmente desea ELIMINAR el No Consumible? </p>
            </div> <!-- /.modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSave" data-dismiss="modal"
                    onclick="eliminarNoConsumible()">Eliminar</button>
            </div> <!-- /.modal footer -->

        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog modal-lg -->
</div> <!-- /.modal fade -->
<!-- / Modal -->