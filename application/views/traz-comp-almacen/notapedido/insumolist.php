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
      <li class="nav" data-tipo="especial"><a data-toggle="tab" href="#two">Pedidos Especiales</a></li>
    </ul>

    <div class="tab-content">

      <!-- Show this tab by adding `active` class -->
      <div class="tab-pane fade in active" id="one">
        <!-- sacar u ocultar -->
        <input type="text" id="id_ordTrabajo" name="id_ordTrabajo" class="form-control hidden"
            value="<?php echo $ot ?>" disabled>
        <form id="form_insumos">
            <table id="tbl_insumos" class="table table-bordered table-hover">
                <thead>
                    
                <th width="1%">Seleccionar</th>
                        <th>Insumo</th>
                        <th>Cantidad</th>
                   
                </thead>
                <tbody>
                    <?php
                      $i = 0;
                      if (count($plantilla) > 0) {
                          //dump_exit($plantilla);
                          foreach ($plantilla as $p) {

                              echo '<tr id="" class="">';
                              echo '<td class="text-center">';
                              echo '<input class="check" type="checkbox" name="artId[' . $i . ']" value="' . $p['arti_id'] . '" id="' . $p['arti_id'] . '">';
                              echo '</td>';
                              echo '<td>' . $p['descripcion'];
                              echo '<input type="text" class="celda insum_Desc hidden" id="insum_Desc" value=" ' . $p['descripcion'] . ' " placeholder="">';
                              echo '</td>';
                              echo '<td>';
                              echo '<input type="text" name="cant_insumos[' . $i . ']" class="cant_insumos" id="cant_insumos" value="" placeholder="Ingrese cantidad...">';
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

      <!-- I removed `in` class here so it will have a fade in effect when showed -->
      <div class="tab-pane fade" id="two">
          <?php $this->load->view('almacen/notapedido/viewPedidoEspecial_')?>

      </div>

    </div>
    <button type="button" class="botones btn btn-primary" onclick="enviarOrden()" style="float: right;margin-top:10px">Guardar Pedido</button>

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


  //va a listado de nota de pedido
  $("#listado").click(function (e) {
    WaitingOpen();
    $('#content').empty();
    $("#content").load("<?php echo base_url(); ?>index.php/<?php echo ALM ?>Notapedido/index/<?php echo $permission; ?>");
    WaitingClose();
  });



  // Guarda Nota de Pedido
  function enviarOrden() {
    $('.modal').modal('hide');
    if($('.nav.active').data('tipo')=='comun'){
       guardar_pedido();
    }else{
      guardar_pedido_esp();
    }
  }


  function guardar_pedido(){
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
        WaitingOpen("Guardando pedido...");

        if(!conexion()){//SI NO HAY CONEXION LO GUARDA EN SESSION STORAGE
          console.log("Sin Conexión");
          var aux = sessionStorage.getItem('list_pedidos_'+idOT);
          if(aux==null)aux=[];else aux = JSON.parse(aux);
          aux.push({nombreIns, idinsumos, cantidades, idOT });
          sessionStorage.setItem('list_pedidos_'+idOT,JSON.stringify(aux));
          console.log(sessionStorage.getItem('list_pedidos_'+idOT));
          cargarNotasOffline();
        }

        $('.check').prop('checked',false);
        if(idinsumos.length==0){$('.modal').modal('hide'); return;}

        $.ajax({
          data: { idinsumos, cantidades, idOT },
          type: 'POST',
          dataType: 'json',
          url: 'index.php/<?php echo ALM ?>Notapedido/setNotaPedido',
          success: function (result) {
            WaitingClose();
            cargarPedidos();
            $('.modal').modal('hide');
            $('input.check').attr('checked',false);
          },
          error: function (result) {
            WaitingClose();
            alert("Error en guardado...");
          },
        });
  }

  function guardar_pedido_esp() {
    var pedido = $('#pedido').val();
    var justif = $('#justificacion').val();
    var ot = $('#id_ordTrabajo').val();

    $.ajax({
      type: 'POST',
      data: {
        pedido,
        justif,
        ot
      },
      url: 'index.php/<?php echo ALM ?>Notapedido/setPedidoEspecial',
      success: function (data) {
        cargarPedidos();
        $('.modal').modal('hide');
      },
      error: function (result) {
   
        alert("Error");
     
      }
    });
}

  $('#tbl_insumos').DataTable();



</script>