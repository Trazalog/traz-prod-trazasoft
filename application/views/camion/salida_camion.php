<div class="box">
  <div class="box-header with-border">
    <h3><?php echo $lang["SalidaCamion"]; ?></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
        <i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-2 col-xs-12">
        <label for="establecimientos" class="form-label">Establecimiento*:</label>
      </div>
      <div class="col-md-4 col-xs-12">
        <!-- <select class="form-control select2 select2-hidden-accesible" id="establecimientos">
          <option value="" readonly selected>-Seleccione Establecimiento-</option>
          <?php
          //foreach ($establecimientos as $fila) {
          //echo '<option value="' . $fila->esta_id . '" >' . $fila->nombre . '</option>';
          //}
          ?>
        </select> -->
        <input type="text" class="form-control" id="establecimiento" name="establecimiento" value="<?php echo $camion[0]->esta_nombre ?>" readonly>
      </div>
      <div class="col-md-1 col-xs-12">
        <label for="fecha" class="form-label">Fecha*:</label>
      </div>
      <div class="col-md-3 col-xs-12">
        <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>" class="form-control">
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
</div>
<div class="box">
  <form id="frm-datosCamion">
    <div class="box-header">
      <h4>Datos camion</h4>
    </div>
    <div class="box-body">
      <div class="row" style="margin-top:40px">
        <div class="col-md-1 col-xs-12">
          <label class="form-label">Patente*:</label>
        </div>
        <?php echo "<div class='col-md-2 col-xs-12'><input type='text' class='form-control' id='patente' name='patente' value='$patente'>" ?>
        <!-- <datalist id="patentes"> -->
        <?php //foreach ($camiones as $fila) {
        //echo  "<option data-json='" . json_encode($fila) . "' value='" . $fila->patente . "'></option>";
        //}
        ?>
        <!-- </datalist> -->
        <!-- <div class="col-md-2"> -->
        <!-- <label>Patente*:</label> -->
        <!-- <div class="form-group">
          <select name="patenteSel" id="patenteSel" class="form-control select2 ">
            <option selected readonly>Ingrese patente</option>
            <?php //foreach ($camiones as $key => $op) {
            //echo "<option value='$op->motr_id'>$op->patente</option>";
            //} 
            ?>
          </select>
        </div> -->
        <!-- </div> -->
      </div>
      <div class="col-md-1 col-xs-12"><label class="form-label">Acoplado*:</label></div>
      <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="acoplado" name="acoplado" value="<?php echo $camion[0]->acoplado ?>" readonly></div>
      <div class="col-md-1 col-xs-12"><label class="form-label">Conductor*:</label></div>
      <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="conductor" name="conductor" value="<?php echo $camion[0]->conductor ?>" readonly></div>
      <div class="col-md-1 col-xs-12"><label class="form-label">Tipo*:</label></div>
      <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $camion[0]->tipo ?>" readonly></div>
    </div>
    <hr>
    <div class="row" style="margin-top:40px">
      <div class="col-md-1 col-xs-12"><label class="form-label">Bruto*:</label></div>
      <div class="col-md-3 col-xs-12"><input type="text" class="form-control" id="bruto" name="bruto" value="<?php echo $camion[0]->bruto ?>" <?php echo $readonlyBruto ?>></div>
      <div class="col-md-1 col-xs-12"><label class="form-label">Tara*:</label></div>
      <div class="col-md-3 col-xs-12"><input type="text" class="form-control" id="tara" name="tara" value="<?php echo $camion[0]->tara ?>" <?php echo $readonlyTara ?>></div>
      <div class="col-md-1 col-xs-12"><label class="form-label">Neto*:</label></div>
      <div class="col-md-3 col-xs-12"><input type="text" class="form-control" id="neto" name="neto" value="<?php echo ($camion[0]->bruto - $camion[0]->tara) ?>" readonly></div>
    </div>
    <hr>
  </form>
</div>
</div>
<div class="box">
  <div class="box-header">
    <h4>Productos</h4>
  </div>
  <div class="box-body">
    <div class="row" style="margin-top:40px">
      <div class="col-xs-12 table-responsive" id="tablaproductos"></div>
    </div>
    <div class="row" style="margin-top:40px">
      <div class="col-xs-12">
        <label for="">Observacion:</label>
        <textarea id="observacion" class="form-control" placeholder="Detalles extra" cols="30" rows="5"></textarea>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    <div class="row">
      <div class="col-md-10 col-xs-6"></div>
      <div class="col-md-2 col-xs-6">
        <button class="btn btn-success btn-block" onclick="guardarSalida()">Aceptar</button>
      </div>
    </div>
  </div>
  <!-- /.box-footer-->
</div>
<script>
  // $('.select2').select2()

  // $("#patente").on('change', function() {
  //   ban = $("#patentes option[value='" + $('#patente').val() + "']").length;

  //   if (ban == 0) {
  //     alert('Patente Inexistente');
  //     document.getElementById('patente').value = "";
  //     document.getElementById('acoplado').value = "";
  //     document.getElementById('conductor').value = "";
  //     document.getElementById('acoplado').readonly = true;
  //     document.getElementById('conductor').readonly = true;
  //   } else {
  //     camion = JSON.parse($("#patentes option[value='" + $('#patente').val() + "']").attr('data-json'));
  //     productos = [];
  //     for (i = 0; i < camion.productos.length; i++) {
  //       producto = {};
  //       producto.id = camion.productos[i].id;
  //       producto.producto = camion.productos[i].titulo;
  //       producto.empaque = camion.productos[i].empaquetitulo;
  //       producto.cantidad = camion.productos[i].cantidad;
  //       producto.lote = camion.productos[i].lote;
  //       productos.push(producto);
  //     }
  //     document.getElementById('acoplado').value = camion.acoplado;
  //     document.getElementById('conductor').value = camion.conductor;
  //     document.getElementById('acoplado').readonly = false;
  //     document.getElementById('conductor').readonly = false;
  //     lenguaje = <?php echo json_encode($lang) ?>;
  //     json = JSON.stringify(productos);
  //     armaTabla('tabla_productos', 'tablaproductos', json, lenguaje);
  //   }
  // });

  $('#patente').keyup(function(e) {
    // if ($('#accioncamion').val() != 'descarga') return;
    if (e.keyCode === 13) {
      console.log('Obtener Lotes Patentes');

      if (this.value == null || this.value == '') return;
      // alert(this.value);
      obtenerInfoCamion(this.value);
    }
  });

  function obtenerInfoCamion(patente) {
    // alert("hecho");    
    // wo();
    $.ajax({
      type: 'GET',
      dataType: 'JSON',
      url: 'index.php/general/Camion/obtenerInfo/' + patente,
      success: function(rsp) {
        // alert("Hecho");
        // alert(fillForm(rsp.data[0]));
        if (_isset(rsp.data)) {
          $('#establecimiento').val(rsp.data[0].esta_nombre);
          $('#frm-datosCamion')[0].reset();
          $('#patente').val(rsp.data[0].patente);
          $('#acoplado').val(rsp.data[0].acoplado);
          $('#conductor').val(rsp.data[0].conductor);
          $('#tipo').val(rsp.data[0].tipo);
          if (!(typeof rsp.data[0].bruto === 'undefined' || rsp.data[0].bruto == 0)) {
            $('#bruto').val(rsp.data[0].bruto).attr('readonly', '');
            $('#tara').removeAttr('readonly');
          } else if (!(typeof rsp.data[0].tara === 'undefined' || rsp.data[0].tara == 0)) {
            $('#tara').val(rsp.data[0].tara).attr('readonly', '');
            $('#bruto').removeAttr('readonly');
          }
          if (rsp.data[0].bruto > rsp.data[0].tara) {
            $('#neto').val(rsp.data[0].bruto - rsp.data[0].tara);
          } else {
            $('#neto').val(0);
          }
        } else {
          alert('Patente no encontrada, ingrese nuevamente');
          $('#frm-datosCamion')[0].reset();
          $('#establecimiento').val('');
          // fillForm(rsp.data[0]);
        }
      },
      error: function(rsp) {
        alert('Error');
      },
      complete: function() {
        // wc();
      }
    });
  }

  function _isset(variable) {
    if (typeof(variable) == "undefined" || variable == null)
      return false;
    else
    if (typeof(variable) == "object" && !variable.length)
      return false;
    else
      return true;
  }

  $('#bruto, #tara').keyup(function(e) {

    if (!(e.keyCode === 96 || e.keyCode === 97 || e.keyCode === 98 || e.keyCode === 99 || e.keyCode === 100 || e.keyCode === 101 || e.keyCode === 102 || e.keyCode === 103 || e.keyCode === 104 || e.keyCode === 105 || //numeros pad numérico del 0 al 9
        e.keyCode === 48 || e.keyCode === 49 || e.keyCode === 50 || e.keyCode === 51 || e.keyCode === 52 || e.keyCode === 53 || e.keyCode === 54 || e.keyCode === 55 || e.keyCode === 56 || e.keyCode === 57 || //numeros fila numérica del 0 al 9
        e.keyCode === 110 || //punto pad
        e.keyCode === 190 || //punto fila
        e.keyCode === 13 || //enter    
        e.keyCode === 8 || //delete
        e.keyCode === 46 || //suprimir
        e.keyCode === 9 || //tab
        e.keyCode === 18 || //alt
        e.keyCode === 17 || //crtl
        e.keyCode === 91 || //windows
        e.keyCode === 92 //windows
      )) {
      $(this).val('');
      return;
    }
    if (!isNaN($(this).val())) {
      var neto = $('#bruto').val() - $('#tara').val();
      neto = (neto < 0) ? 0 : neto;
      var pres = String(neto).length;
      $('#neto').val(trunc(neto.toPrecision(pres), 3));
    }

  });

  function trunc(x, posiciones = 0) {
    var s = x.toString()
    var l = s.length
    var decimalLength = s.indexOf('.') + 1
    var numStr = s.substr(0, decimalLength + posiciones)
    return Number(numStr)
  }

  function guardarSalida() {
    if ($('#bruto').val() <= $('#tara').val()) {
      alert("El peso bruto debe ser mayor al de la tara");
      return;
    }
    console.log('Guardar salida');
    var frmCamion = new FormData($('#frm-datosCamion')[0]);
    // frmCamion.append('estado', 'FINALIZADO');
    // showFD(frmCamion);
    data = formToObject(frmCamion);
    console.log(data);
    wo();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: 'index.php/general/Camion/finalizarSalida',
      data: {
        data
      },
      success: function(rsp) {
        alert('Salida Guardada');
        console.log(rsp.msj);
      },
      error: function(rsp) {
        alert('Error al Guardar Salida');
        console.log(rsp.msj);
      },
      complete: function() {
        wc();
      }
    });
  }
</script>