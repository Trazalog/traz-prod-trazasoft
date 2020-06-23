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


    <form method="POST" id="formEstablecimiento" autocomplete="off">
      <div class="row">

        <div class="col-md-12">

          <div class="col-md-1"></div>

          <div class="col-md-5 col-sm-6 col-xs-12">

            <label style="margin-left:10px" for="">Establecimiento:</label>
            <div class="col-md-12  input-group" style="margin-left:15px">



              <select class="form-control select2 select2-hidden-accesible" id="establecimiento" name="establecimiento" required>
                <option value="" disabled selected>-Seleccione opcion-</option>
                <?php
                foreach ($tipoResiduo as $i) {
                  echo '<option>' . $i->nombre . '</option>';
                }
                ?>
              </select>


              <span class="input-group-btn">
                <button class='btn btn-primary' data-toggle="modal" data-target="#modalEstablecimiento">
                  <i class="fa fa-plus"></i></button>
              </span>

            </div>
          </div>


          <!-- ___________________________________________________ -->

          <div class="col-md-5 col-sm-6 col-xs-12">
            <label for="" style="margin-left:10px">Deposito:</label>
            <div class="col-md-12  input-group" style="margin-left:15px">

              <select class="form-control select2 select2-hidden-accesible" id="depositos" name="establecimiento" required>
                <option value="" disabled selected>-Seleccione opcion-</option>
                <?php
                foreach ($tipoResiduo as $i) {
                  echo '<option>' . $i->nombre . '</option>';
                }
                ?>
              </select>

              <span class="input-group-btn">
                <button class='btn btn-primary' data-toggle="modal" data-target="#modalDeposito">
                  <i class="fa fa-plus"></i></button>
              </span>
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

        <form autocomplete="off" id="formDatos" method="POST">


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

          <div class="col-md-5 col-sm-6 col-xs-12">



            <div class="form-group">
              <label for="tipores" class="form-label">Tipo residuo:</label>
              <select class="form-control select2 select2-hidden-accesible" id="tipores" name="tipo_residuo" required>
                <option value="" disabled selected>-Seleccione opcion-</option>
                <?php
                foreach ($tiporesiduo as $i) {
                  echo '<option>' . $i->nombre . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <!--_____________________________________________-->
          <!-- -- Nombre -- -->

          <div class="col-md-5 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="nom" class="form-label">Nombre:</label>
              <input type="number" id="nom" name="nom" class="form-control" required>
            </div>
          </div>
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
              <button type="submit" class="btn btn-primary btn-circle" onclick="Guardar_Recipiente() aria-label=" Left Align">
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

  </div>


  <!---//////////////////////////////////////--- FIN BOX RECIPIENTES ---///////////////////////////////////////////////////////----->


  <!---//////////////////////////////////////--- TABLA---///////////////////////////////////////////////////////----->






  <div class="row">
    <div class="col-md-12">
      <div class="col-sm-12 table-scroll">


        <!--__________________HEADER TABLA___________________________-->

        <table id="tabla_recipientes" class="table table-bordered table-striped">
          <thead class="thead-dark" bgcolor="#eeeeee">

            <th>Acciones</th>
            <th>Dato</th>
            <th>Tipo</th>
            <th>Nombre</th>



          </thead>

          <!--__________________BODY TABLA___________________________-->

          <tbody>
            <tr>
              <td>

              </td>
              <td>residuo radioactivo</td>
              <td>3</td>
              <td>23</td>

            </tr>


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
        <button type="submit" class="btn btn-primary pull-right" id="btnsave">Guardar</button>
      </div>
    </div>

  </div>

  <br>






</div>
</div>





<!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->

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
      <form method="POST" id="formEstablecimiento" autocomplete="off">
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



<!---//////////////////////////////////////--- FIN Modal Establecimiento---///////////////////////////////////////////////////////----->




<!---//////////////////////////////////////--- Modal Deposito---///////////////////////////////////////////////////////----->

<div class="modal fade" id="modalDeposito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div>


<!---//////////////////////////////////////--- FIN Modal Deposito---///////////////////////////////////////////////////////----->




<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->


<!--_____________________________________________________________-->
<!-- script bootstrap validator FORMULARIO DATOS -->

<script>
  $('#formDatos').bootstrapValidator({
    message: 'This value is not valid',
    /*feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },*/
    fields: {
      contenedor: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          /*stringLength: {
              min: 6,
              max: 30,
              message: 'The username must be more than 6 and less than 30 characters long'
          },*/
          regexp: {
            regexp: /^(0|[1-9][0-9]*)$/,
            message: 'la entrada debe ser un numero natural'
          }
        }
      },
      tipo_residuo: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          }
          /*stringLength: {
              min: 6,
              max: 30,
              message: 'The username must be more than 6 and less than 30 characters long'
          },*/
        }
      },
      porcent_llenado: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /[+]?[0-9]*\.?[0-9]*/,
            message: 'la entrada debe ser un numero entero o flotante'
          }
          /*stringLength: {
              min: 6,
              max: 30,
              message: 'The username must be more than 6 and less than 30 characters long'
          },*/
        }
      },
      metroscubicos: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /[+]?[0-9]*\.?[0-9]*/,
            message: 'la entrada debe ser un numero entero o flotante'
          }
          /*stringLength: {
              min: 6,
              max: 30,
              message: 'The username must be more than 6 and less than 30 characters long'
          },*/
        }
      }
    }
  }).on('success.form.bv', function(e) {
    e.preventDefault();
    guardar();
  });
</script>


<!--_____________________________________________________________-->
<!-- script bootstrap validator FORMULARIO ESTABLECIMIENTO -->

<script>
  $('#formEstablecimiento').bootstrapValidator({
    message: 'This value is not valid',
    /*feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },*/
    fields: {
      Nombre: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /[A-Za-z]/,
            message: 'la entrada debe ser un numero entero'
          }
        }
      },
      Ubicacion: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /[A-Za-z]/,
            message: 'la entrada debe ser un numero entero'
          }
        }
      },
      Pais: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
        }
      },
      Fecha_de_alta: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /^(0|[1-9][0-9]*)$/,
            message: 'la entrada debe ser un numero entero'
          }
        }
      },
      Usuario: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /[A-Za-z]/,
            message: 'la entrada debe ser un numero entero'
          }
        }
      },
      Calles: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /[A-Za-z]/,
            message: 'la entrada no debe ser un numero entero'
          }
        }
      },
      Altura: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /[A-Za-z]/,
            message: 'la entrada no debe ser un numero entero'
          }
        }
      },
      Localidad: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /[A-Za-z]/,
            message: 'la entrada no debe ser un numero entero'
          }
        }
      },
      Estado: {
        message: 'la entrada no es valida',
        validators: {
          notEmpty: {
            message: 'la entrada no puede ser vacia'
          },
          regexp: {
            regexp: /[A-Za-z]/,
            message: 'la entrada no debe ser un numero entero'
          }
        }
      }
    }
  }).on('success.form.bv', function(e) {
    e.preventDefault();
    agregarDato();
  });
</script>





<!--_____________________________________________________________-->
<!-- Script Agregar datos de FORMULARIO ESTABLECIMIENTO-->

<script>
  function Guardar_Recipiente() {
    datos = $('#formEstablecimiento').serialize();
    //console.log(datos);
    //--------------------------------------------------------------
    if ($("#formEstablecimiento").data('bootstrapValidator').isValid()) {
      $.ajax({
        type: "POST",
        data: datos,
        url: "ajax/Registrarinspector/guardarDato",
        success: function(r) {
          if (r == "ok") {
            //console.log(datos);
            $('#formEstablecimiento')[0].reset();
            alertify.success("Agregado con exito");
          } else {
            console.log(r);
            $('#formEstablecimiento')[0].reset();
            alertify.error("error al agregar");
          }
        }
      });
    }
  }
</script>



<!--_____________________________________________________________-->
<!-- script que muestra box de datos al dar click en boton agregar -->

<script>
  $("#botonAgregar").on("click", function() {
    //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
    var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
    $("#nro").val(aleatorio);

    $("#botonAgregar").attr("disabled", "");
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
  });
</script>


<!--_____________________________________________________________-->
<!-- script Datatables -->
<script>
  DataTable($('#tabla_recipientes'))
</script>
