<input type="hidden" id="permission" value="<?php echo $permission;?>">


<div class="nada">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-body">
          <div class="row">
            <div class="col-xs-12">

              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">Datos de Orden</h4>
                </div>

                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                      <label for="">Comprobante <strong style="color: #dd4b39">*</strong> :</label>
                      <input type="text" align=\"right\" class="form-control" id="comprobante" min="1" size="30"
                        placeholder="Ingrese numero de comprobante...">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                      <label for="fecha">Fecha <strong style="color: #dd4b39">*</strong> :</label>
                      <input type="text" class="form-control" id="fecha_orden" name="fecha">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                      <label for="">Solicitante <strong style="color: #dd4b39">*</strong> :</label>
                      <input type="text" id="solicitante" name="solicitante" class="form-control input"
                        placeholder="Ingrese Nombre...">
                      <!--<select id="solicitante" name="solicitante" class="form-control"   />-->
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4 hidden">
                      <label for="">id Orden de Trabajo <strong style="color: #dd4b39">*</strong> :</label>
                      <input type="text" id="idOT" name="idOT" class="form-control" value="0"
                        placeholder="Ingrese id de OT" />
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 hidden">
                      <label for="">Descripción de OT <strong style="color: #dd4b39">*</strong> :</label>
                      <textarea id="ot" name="ot" class="form-control"></textarea>
                    </div>
                  </div><br>

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                      <a href="#insum" aria-controls="home" role="tab" data-toggle="tab"
                        class="fa fa-file-text-o icotitulo"> Insumos</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="insum">
                      <div class="row">
                        <br>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                          <label for="">Seleccionar Artículo <strong style="color: #dd4b39">*</strong> :</label>
                          <div class="input-group">              
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-primary" onclick="$('#articulos').modal('show')">Artículos</button>
                            </div>
                            <input type="text" id="art_select" class="form-control" disabled>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                          <label for="">Cantidad <strong style="color: #dd4b39">*</strong> :</label>
                          <input type="text" id="cantidad" name="cantidad" class="form-control">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                          <label for="">Deposito <strong style="color: #dd4b39">*</strong> :</label>
                          <select id="deposito" name="deposito" class="form-control"></select>
                        </div>

                        <div class="col-xs-12">
                          <br>
                          <button type="button" class="btn btn-primary" id="agregar" style="float:right"><i
                              class="fa fa-check">Agregar</i></button>
                        </div>
                      </div><br>

                      <div class="row">
                        <div class="col-xs-12">
                          <table class="table table-bordered" id="tablainsumo">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Código</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Deposito</th>
                                <th>OT</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </div>

                    </div>
                    <!--div que cierra el panel-->
                  </div><!-- div que cierra el tab conte -->
                </div><!-- </div> CIERRE div del body-->
              </div>

            </div>
          </div>
        </div><!-- /.box-body -->

        <div class="modal-footer">
          <button type="button" class="btn btn-default delete" onclick="limpiar()">Limpiar</button>
          <button type="button" class="btn btn-primary" onclick="guardar()">Guardar</button>
        </div> <!-- /.modal footer -->

      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
  </section><!-- /.content -->

  <script>
    $("#fecha_orden").datetimepicker({
      format: 'YYYY-MM-DD',
      locale: 'es',
    });

    var idslote = new Array();

    // autocomplete para codigo
    var dataF = function () {
      var tmp = null;
      $.ajax({
        'async': false,
        'type': "POST",
        'global': false,
        'dataType': 'json',
        'url': "index.php/almacen/Ordeninsumo/getcodigo",
        'success': function (data) {

          tmp = data;
          for (var i = 0; i < data.length; i++) {
            idslote[i] = data[i]['loteid'];
          }
        }
      });
      return tmp;
    }();

    $("#codigo").autocomplete({
      source: dataF,
      delay: 100,
      minLength: 1,
      /*response: function(event, ui) {
        var noResult = { value:"",label:"No se encontraron resultados" };
        ui.content.push(noResult);
      },*/
      focus: function (event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox
        $(this).val(ui.item.label);
        $("#descripcion").val(ui.item.artDescription);
      },
      select: function (event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox and hidden field
        //$(this).val(ui.item.value);//label
        $("#codigo").val(ui.item.label); //value
        $("#descripcion").val(ui.item.artDescription);
        $("#id_herr").val(ui.item.value);
        traer_deposito(ui.item.value);

      },
    });


    // autocomplete para OT
    var dataOT = function () {
      var tmp = null;
      $.ajax({
        'async': false,
        'type': "POST",
        'global': false,
        'dataType': 'json',
        'url': "index.php/almacen/Ordeninsumo/getOT",
        'success': function (data) {
          tmp = data;
          console.table(tmp);
        }
      });
      return tmp;
    }();


    function traer_deposito(artId) {
      $('#deposito').empty();
      $.ajax({
        type: 'POST',
        data: { artId: artId },
        url: 'index.php/almacen/Ordeninsumo/getdeposito',
        success: function (data) {
          var opcion = "<option value='-1'>Seleccione...</option>";
          $('#deposito').append(opcion);
          for (var i = 0; i < data.length; i++) {
            var nombre = data[i]['depositodescrip'];
            var opcion = "<option value='" + data[i]['depositoId'] + "'>" + nombre + "</option>";
            $('#deposito').append(opcion);
          }
        },
        error: function (result) {
          console.log(result);
        },
        dataType: 'json'
      });
    }

    function limpiar() {
      $("#comprobante").val("");
      $("#fecha_orden").val("");
      $("#solicitante").val("");
      $("#destino").val("");
      $("#codigo").val("");
      $("#descripcion").val("");
      $("#cantidad").val("");
      $("#deposito").val("");
      $('#tablainsumo tbody tr').remove();
    }

    function guardar() {
      console.log("estoy guardando");
      var parametros = {
        'fecha': $('#fecha_orden').val(),
        'solicitante': $('#solicitante').val(),
        'comprobante': $('#comprobante').val(),
        'destino': $('#deposito').val(),
        'ortr_id': $('#idOT').val(),
      };

      var idsinsumo = new Array();
      $("#tablainsumo tbody tr").each(function (index) {
        var i = $(this).attr('id');
        idsinsumo.push(i);
      });

      comp = {};
      depo = {};
      art = {};
      var campo1, campo2, campo3, campo4, campo5, campo6, campo7, campo8, campo9;
      var i = 0;//$(this).attr('id'); 

      $("#tablainsumo tbody tr").each(function (index) {
        $(this).children("td").each(function (index2) {
          console.log("i: " + i);
          switch (index2) {
            case 0: campo1 = $(this).text();
              break;
            case 1: campo2 = $(this).text();
              break;
            case 2: campo3 = $(this).text();
              break;
            case 3: campo4 = $(this).text();
              comp[i] = campo4;
              break;
            case 4: campo5 = $(this).text();
              break;
            case 5: campo6 = $(this).text();
              break;
            case 6: campo7 = $(this).text();
              break;
            case 7: campo8 = $(this).text();
              depo[i] = campo8;
              break;
            case 8: campo9 = $(this).text();
              art[i] = campo9;
              break;
          }
        });
        i++;
      });

      alert(parametros);
      alert(idsinsumo);
      alert($('#comprobante').val());
      alert("Fecha: "+$('#fecha_orden').val());
      alert($('#solicitante').val());

      if (!(parametros != 0 && idsinsumo != 0 && $('#comprobante').val() != "" && $('#fecha_orden').val() != "" && $('#solicitante').val() != "")) {alert('Campos Obligatorios Incompletos');return;}
     
        $.ajax({
          type: 'POST',
          data: { data: parametros, comp: comp, idslote: idslote, depo: depo, art: art },
          url: 'index.php/almacen/Ordeninsumo/guardar',  //index.php/
          success: function (data) {
        
           $('.modal').modal('hide');
          },
          error: function (result) {
            alert('Error al Guardar');
          },
          // dataType: 'json'
        });
        limpiar();

    }


    //agrega insumos a la tabla detainsumos
    var i = 1;
    $('#agregar').click(function (e) {
      var $codigo = seleccion_art.label;
      var id_her = seleccion_art.value;
      var descripcion = $('#art_select').val();
      var cantidad = $('#cantidad').val();
      var deposito = $("select#deposito option:selected").html();
      var id_deposito = $('#deposito').val();
      var idOT = $('#idOT').val();
      var ot = $('#ot').html();
      var tr = "<tr id='" + i + "'>" +
        "<td ><i class='fa fa-ban elirow text-light-blue' style='cursor: 'pointer'></i></td>" +
        "<td>" + $codigo + "</td>" +
        "<td>" + descripcion + "</td>" +
        "<td>" + cantidad + "</td>" +
        "<td>" + deposito + "</td>" +
        "<td>" + ot + "</td>" +
        "<td class='hidden' id='" + idOT + "'>" + idOT + "</td>" +
        "<td class='hidden' id='" + id_deposito + "'>" + id_deposito + "</td>" +
        "<td class='hidden' id='" + id_her + "'>" + id_her + "</td>" +
        "</tr>";
      i++;
      /* mando el codigo y el id _ deposito entonces traigo esa cantidad de lote*/
      var hayError = false;
      var Error1 = false;
      var Error2 = false;
      var Error3 = false;
      if ($codigo != 0 && cantidad > 0 && id_deposito > 0) {
        $.ajax({
          type: 'POST',
          data: { id_her: id_her, id_deposito: id_deposito },
          url: 'index.php/almacen/Ordeninsumo/alerta',
          success: function (data) {
            console.log("exito en la alerta");
            console.log(data);
            var datos = parseInt(data);
            console.log(datos);
            // $('#error3').fadeOut('slow');
            if (cantidad <= datos) {
              if (Error1 == false) {
                // $('#error1').fadeOut('slow');
              }
              // $('#error2').fadeIn('slow');
              $('#tablainsumo tbody').append(tr);
              // $('#error2').delay(1000).fadeOut('slow');
            }
            else {
              alert("No hay insumos suficientes,la cantidad de insumos disponibles es: " + data);
              var Error1 = true;
             // $('#error1').fadeIn('slow');
              return;
            }
          },
          error: function (result) {
            alert('Error');
          //  $('#error3').fadeIn('slow');
            console.log(result);
          },
          dataType: 'json'
        });
      }
    

      $(document).on("click", ".elirow", function () {
        var parent = $(this).closest('tr');
        $(parent).remove();
      });

      $('#codigo').val('');
      $('#descripcion').val('');
      $('#cantidad').val('');
      $('#deposito').val('');
    });

    function regresa() {
      WaitingOpen();
      $('#content').empty();
      $("#content").load("<?php echo base_url(); ?>index.php/almacen/Ordeninsumo/index/<?php echo $permission; ?>");
      WaitingClose();
    }

    function filtrar() {
      console.log("Buscando...");
      
      // Declare variables
      var input, filter, ul, li, a, i, txtValue;
      input = document.getElementById('myInput');
      filter = input.value.toUpperCase();
      ul = document.getElementById("myUL");
      li = ul.getElementsByTagName('li');

      // Loop through all list items, and hide those who don't match the search query
      for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          li[i].style.display = "";
        } else {
          li[i].style.display = "none";
        }
      }
    }

    var seleccion_art = '';
    function seleccion_articulo(e){
      traer_deposito($(e).data('id'));  
      seleccion_art = JSON.parse(JSON.stringify($(e).data('json')));
      $('#art_select').val($(e).find('a').html());
      $('#articulos').modal('hide');
    }

  </script>



 
  <div class="modal" id="articulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <div class="input-group input-group-sm">
            <input id="myInput" type="text" class="form-control" onkeyup="filtrar()" placeholder="Buscar Artículos...">
            <span class="input-group-btn">
              <button type="button"  class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div> <!-- /.modal-header  -->

        <div class="modal-body" id="modalBodyArticle">

          <ul id="myUL" class="nav nav-pills nav-stacked">

            <?php 

            foreach($list as $o){
              echo '<li onclick="seleccion_articulo(this)" data-id="'.$o['value'].'" data-json=\''.json_encode($o).'\'><a href="#">'.$o['label'].' | '.$o['artDescription'].'</a></li>';
            }
          
          ?>

          </ul>
        </div> <!-- /.modal-body -->

        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="$('#articulos').modal('hide');">Listo</button>
        </div> <!-- /.modal footer -->

      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog modal-lg -->
  </div> <!-- /.modal fade -->