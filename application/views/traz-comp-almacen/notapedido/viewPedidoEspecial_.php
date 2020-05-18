<form id="form_insumos">
  <div class="form-group">
    <div class="col-sm-12 col-md-12">
      <label for="pedido">Pedido</label>
      <textarea class="form-control" id="pedido" rows="3"></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-12 col-md-12">
      <label for="justificacion">Justificación</label>
      <textarea class="form-control" id="justificacion" rows="3"></textarea>
    </div>
  </div>
  <!-- <button type="button" class="botones btn btn-primary" onclick="guardar()">Guardar Pedido Especial</button> -->
</form>







<script>
  /* Funciones BPM */

  function guardar() {

    var pedido = $('#pedido').val();
    var justif = $('#justificacion').val();

    $.ajax({
      type: 'POST',
      data: {
        pedido: pedido,
        justif: justif
      },
      url: 'index.php/Notapedido/setPedidoEspecial',
      success: function (data) {
        console.log(data);
        //alert("Se Finalizando la SUBTAREA");
        refresca(id);
      },
      error: function (result) {
        console.log(result);
        alert("NO se Finalizo la SUBTAREA");
        refresca(id);
      }
    });
  }


  $('.fecha').datepicker({
    autoclose: true
  }).on('change', function (e) {
    // $('#genericForm').bootstrapValidator('revalidateField',$(this).attr('name'));
    console.log('Validando Campo...' + $(this).attr('name'));
    $('#genericForm').data('bootstrapValidator').resetField($(this), false);
    $('#genericForm').data('bootstrapValidator').validateField($(this));
  });


  /* pedido de insumos */
  // function pedirInsumos() {
  //   var iort = $('#ot').val();
  //   //var iort = 
  //   console.log("El id de OT es: " + iort);

  //   wo();
  //   $('#content').empty();
  //   $("#content").load("<?php echo base_url(); ?>index.php/Notapedido/agregarListInsumos/<?php echo $permission; ?>/" + iort);
  //   wc();
  // }

  // Volver al atras
  $('#cerrar').click(function cargarVista() {
    wo();
    $('#content').empty();
    $("#content").load("<?php echo base_url(); ?>index.php/Tarea/index/<?php echo $permission; ?>");
    wc();
  });

  /* pedido de insumos */

</script>