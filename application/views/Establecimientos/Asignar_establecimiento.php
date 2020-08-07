<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->
<div class="box box-primary animated fadeInLeft">
  <div class="box-header with-border">
    <h4>ABM Establecimiento</h4>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-2 col-lg-1 col-xs-12">
        <button type="button" id="botonAgregar" class="btn btn-primary" aria-label="Left Align">
          Agregar
        </button><br>
      </div>
      <div class="col-md-10 col-lg-11 col-xs-12"></div>
    </div>
  </div>
</div>
<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->
<!---//////////////////////////////////////--- BOX ESTABLECIMIENTO ---///////////////////////////////////////////////////////----->
<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
  <div class="box-header with-border">
    <div class="box-tittle">
      <h5>Informacion</h5>
    </div>
    <div class="box-tools pull-right">
      <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
        <i class="fa fa-times"></i>
      </button>
    </div>
  </div>
  <!--_________________________________________________-->
  <div class="box-body">
    <br>
    <form id="formEstablecimiento" autocomplete="off">
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-1"></div>
          <div class="col-md-5 col-sm-6 col-xs-12">
            <label style="margin-left:10px" for="">Establecimiento:</label>
            <div class="col-md-12  input-group" style="margin-left:15px">
              <select class="form-control select2 select2-hidden-accesible" id="establecimiento" name="establecimiento" onchange="selectEstablecimiento()" <?php echo req() ?>>
                <option value="" disabled selected>Seleccionar</option>
                <?php
                foreach ($establecimiento as $i) {
                  echo "<option value = $i->esta_id>$i->nombre</option>";
                }
                ?>
              </select>
              <span id="estabSelected" style="color: forestgreen;"></span>
            </div>
          </div>
          <!-- ___________________________________________________ -->
          <div class="col-md-5 col-sm-6 col-xs-12">
            <label for="" style="margin-left:10px">Depósito:</label>
            <div class="col-md-12  input-group" style="margin-left:15px">
              <select class="form-control select2 select2-hidden-accesible" id="depositos" name="depositos" onchange="selectDeposito()" <?php echo req() ?>>
              </select>
              <span id="deposSelected" style="color: forestgreen;"></span>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="col-md-12 col-sm-12 col-xs-12"> <br> <br> </div>
    <!---//////////////////////////////////////--- BOX ESTABLECIMIENTO ---///////////////////////////////////////////////////////----->
    <!---//////////////////////////////////////--- RECIPIENTES---///////////////////////////////////////////////////////----->
    <div class="row">
      <div class="col-md-12">
        <form autocomplete="off" id="formDatos">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box-header with-border">
              <h4>Recipientes:</h4>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12"> <br> <br> </div>
          <div class="col-md-12"></div>
          <div class="col-md-1"></div>
          <!--_____________________________________________-->
          <!-- -- Tipo-- -->
          <div class="col-md-4 col-sm-5 col-xs-12">
            <div class="form-group">
              <label for="tipores" class="form-label">Tipo:</label>
              <select class="form-control select2 select2-hidden-accesible" id="tipo_residuo" name="tipo_residuo" onchange="selectRecipiente()" <?php echo req() ?>>
              </select>
              <span id="recipSelected" style="color: forestgreen;"></span>
            </div>
          </div>
          <!--_____________________________________________-->
          <!-- -- Nombre -- -->
          <div class="col-md-4 col-sm-5 col-xs-12">
            <div class="form-group">
              <label for="nom" class="form-label">Nombre:</label>
              <input type="text" id="nombreReci" name="nombreReci" class="form-control" <?php echo req() ?>>
            </div>
          </div>
          <!--_____________________________________________-->
          <!-- -- Box + boton -- -->
          <div class="col-md-2 col-sm-2 col-xs-4">
            <div class="form group">
              <!-- <label for="box" class="form-label">box:</label>
              <input type="text" id="box_id" name="box_id" class="form-control" <?php echo req()?>> -->
              <label for="nom" class="form-label">Box:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat"><i class="fa fa-angle-right"></i></button>
                    </span>
              </div>
            </div>
          </div>
          <!--_____________________________________________-->
      </div>
      <br>
      <div class="col-md-12">
        <hr>
      </div>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-10 col-lg-11 col-xs-12"></div>
          <div class="col-md-2 col-lg-1 col-xs-12 text-center">
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-circle" onclick="agregarFila()" aria-label=" Left Align">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              </button><br>
              <small for="agregar" class="form-label">Agregar</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <hr>
      </div>
      </form>
    </div>
    <div class="col-md-12" id="grid">
    </div>
  </div>
  <!---//////////////////////////////////////--- FIN BOX RECIPIENTES ---///////////////////////////////////////////////////////----->
  <!---//////////////////////////////////////--- TABLA---///////////////////////////////////////////////////////----->
  <div class="row">
    <div class="col-md-12">
      <div class="col-sm-12 table-scroll">
        <!--__________________HEADER TABLA___________________________-->
        <table id="tabla_recipientes" class="table table-bordered table-striped">
          <thead class="thead-dark" bgcolor="#eeeeee">
            <th style="width: 1px;"></th>
            <th>Establecimiento</th>
            <th>Depósito</th>
            <th>Tipo recipiente</th>
            <th>Nombre recipiente</th>
          </thead>
          <!--__________________BODY TABLA___________________________-->
          <tbody>
          </tbody>
        </table>
        <!--__________________FIN TABLA___________________________-->
      </div>
    </div>
    <div class="col-md-12">
      <hr>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="form-group ">
        <button type="submit" class="btn btn-primary pull-right" onclick="guardarRecipiente()">Guardar</button>
      </div>
    </div>
  </div>
  <br>
</div>
<!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->
<div class="box box-primary animated bounceInDown" id="boxRecipientesCargados" style="display: block;">
  <div class="box-header with-border">
    <div class="box-tittle">
      <h3>Recipientes cargados</h3>
    </div>
  </div>
  <!--_________________________________________________-->
  <div class="box-body">
    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="col-sm-12 table-scroll">
          <!--__________________HEADER TABLA___________________________-->
          <table id="tabla_recipientesCargados" class="table table-bordered table-striped">
            <thead class="thead-dark" bgcolor="#eeeeee">
              <tr>
                <th style="width: 1px;">Acciones</th>
                <th>Recipiente</th>
                <th>Tipo recipiente</th>
                <th>Depósito</th>
                <th>Establecimiento</th>
                <th>Fecha alta</th>
              </tr>
            </thead>
            <!--__________________BODY TABLA___________________________-->
            <tbody>
              <?php
              foreach ($recipiente as $r) {
                $id = $r->reci_id;
                echo "<tr id='$id' data-descripcion='$r->reci_nombre'>
                        <td width='1%' class='text-center' style='font-weight: lighter;'>
                          <i class='fa fa-fw fa-refresh text-green' style='cursor: pointer;' data-toggle='modal' data-target='#modal-editar' title='Editar recipiente' onclick='validarEditar($id)'></i>
                          <i class='fa fa-fw fa-trash text-red' style='cursor: pointer;' data-toggle='modal' data-target='#modal-delete' title='Eliminar recipiente' onclick='validarEliminar($id)'></i>
                        </td>
                        <td>$r->reci_nombre</td>
                        <td value = '$r->reci_tipo'>$r->reci_tipo</td>
                        <td value = '$r->depo_id'>$r->depo_descripcion</td>
                        <td value = '$r->esta_id'>$r->esta_nombre</td>
                        <td value = '$r->reci_fec_alta'>$r->reci_fec_alta</td>
                      </tr>";
              }
              ?>
            </tbody>
          </table>
          <!--__________________FIN TABLA___________________________-->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal eliminar recipiente -->
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Está seguro que desea eliminar el recipiente:</h4>
      </div>
      <div class="modal-body">
        <p id="nameRecipiente"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button id="botDeleteModal" type="button" class="btn btn-danger" onclick="eliminarRecipiente(this)">Eliminar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- Modal editar recipiente -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Editar recipiente</h4>
      </div>
      <div class="modal-body box-body">
        <div class="col-sm-12">
          <div class="form-group col-sm-6">
            <label>Tipo</label>
            <select class="form-control" name="editarRecipiente" id="editarRecipiente">
              <?php
              foreach ($tipo as $t) {
                echo "<option value='$t->nombre'>$t->nombre</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group col-sm-6">
            <label for="editarNombre">Nombre</label>
            <input type="text" class="form-control" id="editarNombre" name="editarNombre" placeholder="Nombre">
          </div>
        </div>
      </div>
      <div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button id="botEditarModal" type="button" class="btn btn-success" onclick="editarRecipiente(this)">Editar</button>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!---//////////////////////////////////////--- Modal Establecimiento---///////////////////////////////////////////////////////----->
<div class="modal fade" id="modalEstablecimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Establecimiento</h5>
      </div>
      <form method="POST" id="formModalEstablecimiento" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">

              <!--Nombre-->
              <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" class="form-control input-sm" id="Nombre" name="Nombre">
              </div>
              <!--_____________________________________________-->

              <!--Ubicacion-->
              <div class="form-group">
                <label for="Ubicacion">Ubicacion:</label>
                <br>
                <div class="col-md-6">
                  <input type="text" class="form-control input-sm" id="Ubicacion" name="Ubicacion">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control input-sm" id="Ubicacion" name="Ubicacion">
                </div>
              </div>
              <!--_____________________________________________-->

              <!--Pais-->
              <br><br>
              <div class="form-group">
                <label for="Pais">Pais:</label>
                <input type="text" class="form-control input-sm" id="Pais" name="Pais">
              </div>
              <!--_____________________________________________-->

              <!--Fecha de alta-->
              <div class="form-group">
                <label for="Fechalta">Fecha de alta:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right input-sm" id="datepicker" name="Fecha_de_alta">
                </div>
                <!-- /.input group -->
              </div>
              <!--_____________________________________________-->

              <!--Usuario-->
              <div class="form-group">
                <label for="Usuario">Usuario:</label>
                <input type="text" class="form-control input-sm" id="Usuario" name="Usuario" disabled>
              </div>
              <!--_____________________________________________-->

            </div>
            <div class="col-md-6">

              <!--Calles-->
              <div class="form-group">
                <label for="Calles">Calles:</label>
                <input type="text" class="form-control input-sm" id="Calles" name="Calles">
              </div>
              <!--_____________________________________________-->

              <!--Altura-->
              <div class="form-group">
                <label for="Altura">Altura:</label>
                <input type="text" class="form-control input-sm" id="Altura" name="Altura">
              </div>
              <!--_____________________________________________-->

              <!--Localidad-->
              <div class="form-group">
                <label for="Localidad">Localidad:</label>
                <input type="text" class="form-control input-sm" id="Localidad" name="Localidad">
              </div>
              <!--_____________________________________________-->

              <!--Estado-->
              <div class="form-group">
                <label for="Estado">Estado:</label>
                <input type="text" class="form-control input-sm" id="Estado" name="Estado">
              </div>
              <!--_____________________________________________-->

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="form-group text-right">
            <button type="submit" class="btn btn-primary" onclick="agregarDato()">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!---//////////////////////////////////////--- Modal Deposito---///////////////////////////////////////////////////////----->
<!-- <div class="modal fade" id="modalDeposito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Agregar Deposito</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="nom" class="form-label label-sm">Nombre</label>
              <input type="text" id="nom" name="nom" class="form-control input-sm" required>
            </div>
            <div class="form-group">
              <label for="localidad" class="form-label label-sm">Localidad</label>
              <input type="text" id="localidad" name="localidad" class="form-control input-sm" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="drireccion" class="form-label label-sm">Direccion</label>
              <input type="text" id="drireccion" name="drireccion" class="form-control input-sm" required>
            </div>
            <div class="form-group">
              <label for="pais" class="form-label label-sm">Pais</label>
              <input type="text" id="pais" name="pais" class="form-control input-sm" required>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="form-group text-right">
          <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
          <button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div> -->
<!---//////////////////////////////////////--- FIN Modal Deposito---///////////////////////////////////////////////////////----->
<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

<!--_____________________________________________________________-->
<!-- script que muestra box de datos al dar click en boton agregar -->
<script>
  $("#botonAgregar").on("click", function() {
    //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
    var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
    $("#nro").val(aleatorio);

    $("#botonAgregar").attr("disabled", "");
    $("#boxRecipientesCargados").hide(500);
    $('#boxRecipientesCargados').attr("style", "display: none;");
    //$("#boxDatos").removeAttr("hidden");
    $("#boxDatos").focus();
    $("#boxDatos").show();

  });
</script>
<script>
  $("#btnclose").on("click", function() {
    $("#boxDatos").hide(500);
    $("#botonAgregar").removeAttr("disabled");
    $('#formDatos').data('bootstrapValidator').resetForm();
    $("#formDatos")[0].reset();
    $('#selecmov').find('option').remove();
    $('#chofer').find('option').remove();
    $('#boxRecipientesCargados').attr("style", "display: block;");
    $("#boxRecipientesCargados").focus();
    $("#boxRecipientesCargados").show();
  });
</script>
<!--_____________________________________________________________-->
<!-- script seleccion de datos -->
<script>
  DataTable($('#tabla_recipientesCargados'));
  initForm();

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
      url: 'general/Establecimiento/obtenerDepositos/',
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
      url: 'general/Establecimiento/obtenerRecipientesDeposito/',
      success: function(rsp,rsp2) {
        console.log(rsp2);
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

  function agregarFila() {
    var esta_id = $('#establecimiento').data('descripcion');
    var depo_id = $('#descripcion').val();
    var reci_tipo = $('#tipo_residuo').val();
    var reci_nombre = $('#nombreReci').val();

    if (!validarFrm()) {
      return;
    }

    datosEsta = new FormData($('#formEstablecimiento')[0]);
    datosEsta = formToObject(datosEsta);
    datosReci = new FormData($('#formDatos')[0]);
    datosReci = formToObject(datosReci);
    // console.log('datosEsta: ');
    // console.table(datosEsta);
    // console.log('datosReci: ');
    // console.table(datosReci);

    html = '<tr>' +
      '<td><a type = "button" class = "del pull-right" style = "cursor: pointer;"><i class = "fa fa-fw fa-minus"></i></a></td>' +
      '<td value=' + datosEsta.establecimiento + '>' + $('#estabSelected').text() + '</td>' +
      '<td value=' + datosEsta.depositos + '>' + $('#deposSelected').text() + '</td>' +
      '<td value=' + datosReci.tipo_residuo + '>' + datosReci.tipo_residuo + '</td>' +
      '<td value=' + datosReci.nombreReci + '>' + datosReci.nombreReci + '</td>' +
      '</tr>';
    $('#tabla_recipientes tbody').append(html);

    limpiarCampos();
  }

  //Quitar fila de tabla
  $("#tabla_recipientes").on("click", ".del", function() {
    $(this).parents("tr").remove();
  });

  function validarFrm() {
    $('#formEstablecimiento').bootstrapValidator('validate');
    $('#formDatos').bootstrapValidator('validate');
    if (!$('#formEstablecimiento').data('bootstrapValidator').isValid()) {
      alert('Formulario establecimiento incompleto');
      return false;
    }
    if (!$('#formDatos').data('bootstrapValidator').isValid()) {
      alert('Formulario recipiente incompleto');
      return false;
    }
    return true;
  }

  function limpiarCampos() {
    $('#formEstablecimiento')[0].reset();
    $('#formEstablecimiento').data('bootstrapValidator').resetForm();
    $('#formDatos')[0].reset();
    $('#formDatos').data('bootstrapValidator').resetForm();
    $('#estabSelected').text('');
    $('#deposSelected').text('');
    $('#recipSelected').text('');
  }

  function guardarRecipiente() {
    //Datos de la tabla de recipientes
    var datosTabla = new Array();
    $('#tabla_recipientes tr').each(function(row, tr) {
      datosTabla[row] = {
        // "esta_id": $(tr).find('td:eq(1)').attr('value'),
        "depo_id": $(tr).find('td:eq(2)').attr('value'),
        "reci_tipo": $(tr).find('td:eq(3)').attr('value'),
        "reci_nombre": $(tr).find('td:eq(4)').attr('value')
      }
    });
    datosTabla.shift(); //borra encabezado de la tabla o primera fila
    var recipientes = JSON.stringify(datosTabla);
    // console.log('recipientes: ' + recipientes);
    wo();
    $.ajax({
      type: "POST",
      url: "general/Establecimiento/guardarTodo",
      data: {
        recipientes: recipientes
      },
      success: function(rsp) {
        alert("Recipientes cargados correctamente.");
        linkTo('general/Establecimiento/asignarAEstablecimiento');
      },
      error: function() {
        alert("Se produjo un error al cargar recipientes.");
      },
      complete: function() {
        wc();
      }
    });
  }

  $("#modal-delete").modal('hide');

  function validarEliminar(id) {
    // var eliminar = 'eliminarRecipiente(' + id + ')';
    var a = document.getElementById(id);
    var descripcion = a.dataset.descripcion;
    $('#nameRecipiente').text(descripcion);
    $('#botDeleteModal').val(id);
  }

  function eliminarRecipiente(e) {
    $("#modal-delete").modal('hide');
    var id = e.value;
    if (!id) {
      alert('Sin Detalles a Mostrar');
      return;
    }
    wo();
    $.ajax({
      type: "GET",
      url: "general/Recipiente/deleteRecipiente/" + id,
      dataType: "JSON",
      success: function(rsp) {
        alert("Recipiente eliminado!");
        linkTo('general/Establecimiento/asignarAEstablecimiento');
      },
      error: function(rsp) {
        alert(rsp);
      },
      complete: function() {
        wc();
      }
    });
  }

  $("#modal-editar").modal('hide');

  function validarEditar(id) {
    var a = document.getElementById(id);
    var descripcion = a.dataset.descripcion;
    $('#editarRecipiente').find('option').each(function() {
      var a = $(this).val();
      var b = $('#' + id).find('td:eq(2)').attr('value');
      if (a == b) {
        $(this).attr('selected', 'selected');
      }
    });
    $('#editarNombre').val(descripcion);
    $('#botEditarModal').val(id);
  }

  function editarRecipiente(e) {
    // console.log(e);
    $("#modal-editar").modal('hide');
    var id = e.value;
    if (!id) {
      alert('Sin Detalles a Mostrar');
      return;
    }
    var tipo = $('#editarRecipiente').val();
    var nombre = $('#editarNombre').val();
    wo();
    $.ajax({
      type: "POST",
      data: {
        'reci_id': id,
        'reci_tipo': tipo,
        'reci_nombre': nombre
      },
      dataType: "JSON",
      url: "general/Recipiente/editarRecipiente/",
      success: function(rsp) {
        alert("Recipiente modificado!");
        linkTo('general/Establecimiento/asignarAEstablecimiento');
      },
      error: function(rsp) {
        alert(rsp);
      },
      complete: function() {
        wc();
      }
    });
  }

  $('#depositos').on('change', function() {
    var aux = this.value;
    wbox('#boxes');
    $.ajax({
        type: 'GET',
        url: 'general/Establecimiento/obtenerRecipientes/' + aux,
        success: function(rsp) {
          console.log(rsp);
            $('#grid >').remove();
            $('#grid').prepend(rsp);
        },
        error: function() {},
        complete: function() {
            wbox();
        }
    });
});
</script>
