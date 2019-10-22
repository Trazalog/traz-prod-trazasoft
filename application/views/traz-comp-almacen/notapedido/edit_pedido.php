<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
      <h4><i class="icon fa fa-ban"></i> Error!</h4>
      Revise que todos los campos obligatorios esten seleccionados
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-success" id="error2" style="display: none">
      <h4></h4>
      EL EQUIPO POSEE COMPONENTES ASOCIADOS
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-success" id="error3" style="display: none">
      <h4></h4>
      EL EQUIPO NO POSEE COMPONENTES ASOCIADOS
    </div>
  </div>
</div>

<style>
  input.celda {
    border: none;
  }
</style>


<div class="panel panel-default">
  <div class="panel-heading">
    <h2 class="panel-title"><span class="fa fa-th-large"></span> Detalle de Insumos</h2>
  </div>

  <div class="panel-body">

    <ul class="nav nav-tabs">
      <li class="nav active" data-tipo="comun"><a data-toggle="tab" href="#one">Pedidos</a></li>
      <!-- <li class="nav"><a data-toggle="tab" href="#one"><input type="text" placeholder="Ingrese Artículo..."></a></li> -->
      <li class="nav hidden" data-tipo="especial"><a data-toggle="tab" href="#two">Pedidos Especiales</a></li>
    </ul>

    <div class="tab-content">

      <!-- Show this tab by adding `active` class -->
      <div class="tab-pane fade in active" id="one">
        <!-- sacar u ocultar -->
       
        <form id="form_insumos">
          <table id="tbl_insumos" class="table table-bordered table-striped">
            <thead>
           
                <th width="1%">Seleccionar</th>
                <th>Insumo</th>
                <th id="culo">Cantidad</th>
         
            </thead>
            <tbody>
              <?php
                $i = 0;
                if (count($plantilla) > 0) {
                  
                    foreach ($plantilla as $p) {

                        echo '<tr>';
                        echo '<td class="text-center">';
                        echo '<input class="check" type="checkbox" name="artId[' . $i . ']" value="' . $p['arti_id'] . '" id="' . $p['arti_id'] . '"/>';
                        echo '</td>';
                        echo '<td>' . $p['descripcion'] .'<input type="text" class="celda insum_Desc hidden" id="insum_Desc" value=" ' . $p['descripcion'] . ' " /></td>';
                        echo '<td>';
                        echo '<input type="text" name="cant_insumos[' . $i . ']" class="cant_insumos" id="cant_insumos" placeholder="Ingrese cantidad..."/>';
                        echo '</td>';
                        echo '</tr>';
                        $i++;
                    }
                }
              ?>
            </tbody>
          </table>
        </form>
      </div>
      <!-- <div class="tab-pane fade" id="two">


      </div> -->

    </div>
    <button type="button" class="botones btn btn-primary" onclick="guardar_pedido()"
      style="float: right;margin-top:10px">Guardar Pedido</button>

  </div><!-- /.panel-body -->
</div><!-- /.panel -->

<script>
  $('.cant_insumos').prop('disabled',true);
  $('.check').on('change',function() {
    var tr = $(this).closest('tr');
    $(tr).find('.cant_insumos').prop('disabled',!$(this).prop('checked'));
  });

  $("#fechaEnt").datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'es',
  });

  function guardar_pedido(){
    
      if($('#pema_id').val()=='' || $('#pema_id').val()==0){

        set_pedido();

      }else{

        edit_pedido();

      }
  }

  function set_pedido() {
    /////  VALIDACIONES
    var hayError = false;
    $('#error').hide();

    var tabla = $('#tbl_insumos tbody tr');
    var nombreIns = new Array();
    var idinsumos = new Array();
    var cantidades = new Array();
    id = '';
    cant = '';

    //Procesar Formulario
    $.each(tabla, function (index) {
      var check = $(this).find('input.check');
      var cant = $(this).find('input.cant_insumos');

      if (check.prop('checked') && (cant != "")) { // SI CAMPO CHEKEADO Y CANTIDAD COMPLETA
        id = check.attr('value');
        idinsumos.push(id);
        cant = check.parents("tr").find("input.cant_insumos").val();
        cantidades.push(cant);
        nom = check.parents("tr").find("input.insum_Desc").val();
        nombreIns.push(nom);
        //Vaciar Campos
        check.parents("tr").find("input.cant_insumos").val('');
      }
      // checked y vacio cant
      if (check.prop('checked') && (cant == "")) {
        hayError = true;
      }

    });

    if (hayError == true) {
      $('#error').fadeIn('slow');
      return;
    }
    $('.check').prop('checked',false);
    if(idinsumos.length==0){$('.modal').modal('hide');return;}
    wo("Guardando pedido...");

    $.ajax({
      data: { idinsumos, cantidades, idOT: $('#ot').val(), peex_id: $('#peex_id').val()},
      type: 'POST',
      dataType: 'json',
      url: 'index.php/<?php echo ALM ?>Notapedido/setNotaPedido',
      success: function (result) {
        $('#pema_id').val(result.pema_id);
        get_detalle();
        $('.modal').modal('hide');
        $('input.check').attr('checked', false);
      },
      error: function (result) {
        alert("Error en guardado...");
      },
        finally:function() {
            wc();
        }
    });
  }


  function edit_pedido() {
    /////  VALIDACIONES
    var hayError = false;
    $('#error').hide();

    var tabla = $('#tbl_insumos tbody tr');
    var nombreIns = new Array();
    var idinsumos = new Array();
    var cantidades = new Array();
    id = '';
    cant = '';

    //Procesar Formulario
    $.each(tabla, function (index) {
      var check = $(this).find('input.check');
      var cant = $(this).find('input.cant_insumos');

      if (check.prop('checked') && (cant != "")) { // SI CAMPO CHEKEADO Y CANTIDAD COMPLETA
        id = check.attr('value');
        idinsumos.push(id);
        cant = check.parents("tr").find("input.cant_insumos").val();
        cantidades.push(cant);
        nom = check.parents("tr").find("input.insum_Desc").val();
        nombreIns.push(nom);
        //Vaciar Campos
        check.parents("tr").find("input.cant_insumos").val('');
      }
      // checked y vacio cant
      if (check.prop('checked') && (cant == "")) {
        hayError = true;
      }

    });

    var idOT = $('#id_ordTrabajo').val();

    if (hayError == true) {
      $('#error').fadeIn('slow');
      return;
    }

    $('.check').prop('checked',false);
    if(idinsumos.length==0){$('.modal').modal('hide');return;}
    wo("Guardando pedido...");

    $.ajax({
      data: { idinsumos, cantidades, idOT, pema: $('#pema_id').val()},
      type: 'POST',
      dataType: 'json',
      url: 'index.php/<?php echo ALM ?>Notapedido/editPedido',
      success: function (result) {
        get_detalle();
        $('.modal').modal('hide');
        $('input.check').attr('checked', false);
      },
      error: function (result) {
        alert("Error en guardado...");
      },
        finally:function() {
            wc();
        }
      
    });
  }
  $('#tbl_insumos').DataTable();

</script>