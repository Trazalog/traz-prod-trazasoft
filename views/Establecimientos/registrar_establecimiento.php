<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
  <div class="box-header with-border">
    <h4>Registrar Establecimiento</h4>
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


<!---//////////////////////////////////////--- BOX 1---///////////////////////////////////////////////////////----->


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

  <!--____________________BOX BODY____________________-->

  <div class="box-body">

    <!--/////////////////////// FORMULARIO ///////////////////////-->


    <form class="formEstablecimiento" id="formEstablecimiento">


      <div class="col-md-6">

        <!--_____________________________________________-->
        <!--Nombre-->

        <div class="form-group">
          <label for="Nombre">Nombre:</label>
          <input type="text" class="form-control" id="Nombre" name="nombre">
        </div>

        <!--_____________________________________________-->
        <!--Estado-->

        <!-- <div class="form-group">
                <label for="Estado">Estado:</label>
                <input type="text" class="form-control" id="Estado" name="estado">
            </div>             -->

        <!--_____________________________________________-->
        <!--Pais-->
        <div class="form-group">
          <label for="Localidad">Localidad:</label>
          <input type="text" class="form-control" id="Localidad" name="localidad">
        </div>
        <div class="form-group">
          <label for="Pais">Pais:</label>
          <input type="text" class="form-control" id="Pais" name="pais">
        </div>

        <!--_____________________________________________-->
        <!--Fecha de alta-->

        <!-- <div class="form-group">
                <label for="Fechalta">Fecha de alta:</label>
                <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id="fecha-baja">
                </div>
             </div> -->

        <!--_____________________________________________-->
        <!--Usuario-->

        <!-- <div class="form-group">
                <label for="Usuario">Usuario:</label>
                <input type="text" class="form-control" id="Usuario" name="usuario" disabled>
            </div> -->



      </div>

      <!--***********************************************-->

      <div class="col-md-6">

        <!--_____________________________________________-->
        <!--Calles-->

        <div class="form-group">
          <label for="Calles">Calles:</label>
          <input type="text" class="form-control" id="Calles" name="calles">
        </div>

        <!--_____________________________________________-->
        <!--Altura-->

        <div class="form-group">
          <label for="Altura">Altura:</label>
          <input type="text" class="form-control" id="Altura" name="altura">
        </div>

        <!--_____________________________________________-->
        <!--Localidad-->



        <!--_____________________________________________-->
        <!--Ubicacion-->

        <div class="col-md-12">

          <!--_____________________________________________-->
          <!--Latitud-->

          <div class="col-md-6">

            <div class="form-group">
              <label for="Ubicacion">Latitud:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-map-marker"></i>
                </div>
                <input type="number" class="form-control" id="latitud" name="latitud">
              </div>
            </div>

          </div>

          <!--_____________________________________________-->
          <!--Longitud-->

          <div class="col-md-6">

            <div class="form-group">
              <label for="Ubicacion">Longitud:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-map-marker"></i>
                </div>
                <input type="number" class="form-control" id="Longitud" name="longitud">
              </div>
            </div>

          </div>


        </div>
        <!--_____________________________________________-->

      </div>


      <div class="col-md-12">
        <hr>
      </div>
      <!--_____________________________________________-->
      <!--Boton de guardado-->
      <div class="col-md-12">
        <button class="btn btn-primary pull-right" onclick="Guardar()">Guardar</button>
      </div>

    </form>
  </div>
</div>


<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->


<!---//////////////////////////////////////---BOX 2---///////////////////////////////////////////////////////----->




<div class="box box-primary">




  <div class="box-body">
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>



      <div class="row">
        <div class="col-sm-12 table-scroll" id="cargar_tabla">



        </div>
      </div>

      <!---//////////////////////////////////////--- FIN BOX 2---///////////////////////////////////////////////////////----->

      <!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->


      <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-blue">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h5 class="modal-title" id="exampleModalLabel">Editar Establecimiento</h5>
            </div>


            <div class="modal-body">

              <!--__________________ FORMULARIO MODAL ___________________________-->

              <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

                  <form class="formEstablecimiento" id="formEstablecimiento">

                    <div class="col-md-6">

                      <!--_____________________________________________-->
                      <!--Nombre-->

                      <div class="form-group">
                        <label for="Nombre">Nombre:</label>
                        <input type="text" class="form-control" id="Nombre" name="nombre">
                      </div>

                      <!--_____________________________________________-->
                      <!--Localidad-->

                      <div class="form-group">
                        <label for="Localidad">Localidad:</label>
                        <input type="text" class="form-control" id="Localidad" name="localidad">
                      </div>

                      <!--_____________________________________________-->
                      <!--Pais-->

                      <div class="form-group">
                        <label for="Pais">Pais:</label>
                        <input type="text" class="form-control" id="Pais" name="pais">
                      </div>

                      <!--_____________________________________________-->
                      <!--Fecha de alta-->

                      <!-- <div class="form-group">
                    <label for="Fechalta">Fecha de alta:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control pull-right" id="fecha-baja">
                    </div>
                </div> -->
                      <!--_____________________________________________-->
                      <!--Usuario-->

                      <!-- <div class="form-group">
                    <label for="Usuario">Usuario:</label>
                    <input type="text" class="form-control" id="Usuario" name="usuario">
                </div> -->


                    </div>

                    <!--***********************************************-->

                    <div class="col-md-6">

                      <!--_____________________________________________-->
                      <!--Calles-->

                      <div class="form-group">
                        <label for="Calles">Calles:</label>
                        <input type="text" class="form-control" id="Calles" name="calles">
                      </div>

                      <!--_____________________________________________-->
                      <!--Altura-->

                      <div class="form-group">
                        <label for="Altura">Altura:</label>
                        <input type="text" class="form-control" id="Altura" name="altura">
                      </div>

                      <!--_____________________________________________-->
                      <!--Ubicacion-->

                      <div class="col-md-12">

                        <div class="col-md-6">

                          <div class="form-group">
                            <label for="Ubicacion">Latitud:</label>
                            <input type="number" class="form-control" id="latitud" name="latitud">
                          </div>

                        </div>

                        <div class="col-md-6">

                          <div class="form-group">
                            <label for="Ubicacion">Longitud:</label>
                            <input type="number" class="form-control" id="Ubicacion" name="ubicacion">
                          </div>

                        </div>


                      </div>

                      <!--_____________________________________________-->
                      <!--Estado-->

                      <div class="form-group">
                        <label for="Estado">Estado:</label>
                        <input type="text" class="form-control" id="Estado" name="estado">
                      </div>


                    </div>

                    <!--***********************************************-->


                    <div class="col-md-12">
                      <hr>
                    </div>
                    <!--_____________________________________________-->


                  </form>




                  <!--__________________ FIN FORMULARIO MODAL ___________________________-->

                </div>

                <div class="modal-footer">
                  <div class="col-md-12">
                    <div class="form-group text-right">
                      <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>


            </div>
          </div>
        </div>


        <!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->




        <!---//////////////////////////////////////--- MODAL INFORMACION ---///////////////////////////////////////////////////////----->


        <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Información Establecimiento</h5>
              </div>


              <div class="modal-body">

                <!--__________________ FORMULARIO MODAL ___________________________-->

                <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                  <div class="modal-body">

                    <form class="formEstablecimiento" id="formEstablecimiento">

                      <div class="col-md-6">

                        <!--_____________________________________________-->
                        <!--Nombre-->

                        <div class="form-group">
                          <label for="Nombre">Nombre:</label>
                          <input type="text" class="form-control" id="Nombre" name="nombre" readonly>
                        </div>

                        <!--_____________________________________________-->
                        <!--Localidad-->

                        <div class="form-group">
                          <label for="Localidad">Localidad:</label>
                          <input type="text" class="form-control" id="Localidad" name="localidad" readonly>
                        </div>

                        <!--_____________________________________________-->
                        <!--Pais-->

                        <div class="form-group">
                          <label for="Pais">Pais:</label>
                          <input type="text" class="form-control" id="Pais" name="pais" readonly>
                        </div>

                        <!--_____________________________________________-->
                        <!--Fecha de alta-->

                        <div class="form-group">
                          <label for="Fechalta">Fecha de alta:</label>
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control pull-right" id="fecha-baja" readonly>
                          </div>
                        </div>
                        <!--_____________________________________________-->
                        <!--Usuario-->

                        <div class="form-group">
                          <label for="Usuario">Usuario:</label>
                          <input type="text" class="form-control" id="Usuario" name="usuario" readonly>
                        </div>


                      </div>

                      <!--***********************************************-->

                      <div class="col-md-6">

                        <!--_____________________________________________-->
                        <!--Calles-->

                        <div class="form-group">
                          <label for="Calles">Calles:</label>
                          <input type="text" class="form-control" id="Calles" name="calles" readonly>
                        </div>

                        <!--_____________________________________________-->
                        <!--Altura-->

                        <div class="form-group">
                          <label for="Altura">Altura:</label>
                          <input type="text" class="form-control" id="Altura" name="altura" readonly>
                        </div>

                        <!--_____________________________________________-->
                        <!--Ubicacion-->

                        <div class="col-md-12">

                          <div class="col-md-6">

                            <div class="form-group">
                              <label for="Ubicacion">Latitud:</label>
                              <input type="number" class="form-control" id="latitud" name="latitud" readonly>
                            </div>

                          </div>

                          <div class="col-md-6">

                            <div class="form-group">
                              <label for="Ubicacion">Longitud:</label>
                              <input type="number" class="form-control" id="Ubicacion" name="ubicacion" readonly>
                            </div>

                          </div>


                        </div>

                        <!--_____________________________________________-->
                        <!--Estado-->

                        <div class="form-group">
                          <label for="Estado">Estado:</label>
                          <input type="text" class="form-control" id="Estado" name="estado" readonly>
                        </div>


                      </div>

                      <!--***********************************************-->


                      <div class="col-md-12">
                        <hr>
                      </div>
                      <!--_____________________________________________-->


                    </form>




                    <!--__________________ FIN FORMULARIO MODAL ___________________________-->

                  </div>

                  <div class="modal-footer">
                    <div class="col-md-12">
                      <div class="form-group text-right">
                        <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>


              </div>
            </div>
          </div>


          <!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->





          <!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

          <!--_____________________________________________________________-->
          <!--GUARDAR.-->
          <script>
            obtenerEstablecimientos();

            function obtenerEstablecimientos() {

              $("#cargar_tabla").load("<?php echo base_url(PRD) ?>general/Establecimiento/Lista_establecimientos");

            }


            function Guardar() {

              var datos = new FormData($('#formEstablecimiento')[0]);
              datos = formToObject(datos);

              if ($("#formEstablecimiento").data('bootstrapValidator').isValid()) {
                wo();
                $.ajax({
                  type: "POST",
                  data: {
                    datos
                  },
                  url: "<?php echo base_url(PRD)?>general/Establecimiento/guardar",
                  success: function(r) {
                    obtenerEstablecimientos();
                    alert('Guardado con Éxito');
                  },
                  error: function() {
                    alert('Error de Guardado');
                  },
                  complete: function() {
                    wc();
                  }
                });
              }
            }
          </script>

          <!--_____________________________________________________________-->
          <!--Script Bootstrap Validacion.-->
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
              //guardar();
            });
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


          <!--_____________________________________________-->
          <!-- Script Data-Tables-->
