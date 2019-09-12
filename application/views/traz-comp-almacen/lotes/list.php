<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Movimientos de Stock</h3>
        </div><!-- /.box-header -->

        <div class="box-body">
          <table id="stock" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">N° Lote</th>
                <th>Codigo</th>
                <th>Producto</th>
                <th class="text-center">Cantidad</th>
                <th>Deposito</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(!$list) return;           
                	foreach($list as $f)
      		        {
                    echo '<tr>';
                    echo '<td class="text-center">'.($f['codigo']==1?'S/L':$f['codigo']).'</td>';
                    echo '<td>'.$f['artBarCode'].'</td>';
                    echo '<td>'.$f['artDescription'].'</td>';
                    echo '<td class="text-center">'.$f['cantidad'].'</td>';
                    echo '<td>'.$f['depositodescrip'].'</td>';
                    echo '<td>'.($f['lotestado'] == 'AC' ? '<small class="label pull-left bg-green">Activo</small>' : ($f['lotestado'] == 'IN' ? '<small class="label pull-left bg-red">Inactivo</small>' : '<small class="label pull-left bg-yellow">Suspendido</small>')).'</td>';
   	                echo '</tr>';
      		        }
                
              ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<script>
$(function () {

  $('#stock').DataTable({
    "aLengthMenu": [ 10, 25, 50, 100 ],
    "order": [[0, "asc"]],
  });

});

var idStk = 0;
var acStk = '';

function LoadStk(id_, action){
  idStk = id_;
  acStk = action;
  LoadIconAction('modalAction',action);
  WaitingOpen('Cargando Movimiento');
  $.ajax({
    type: 'POST',
    data: { id : id_, act: action },
    url: 'index.php/stock/getMotion', 
    success: function(result){
      WaitingClose();
      $("#modalBodyStock").html(result.html);
      setTimeout("$('#modalStock').modal('show')",800);
      $(".select2").select2({
        allowClear: true
      });
    },
    error: function(result){
      WaitingClose();
      alert("error");
    },
    dataType: 'json'
  });
}
  
$('#btnSave').click(function(){
  if(acStk == 'View')
  {
    $('#modalStock').modal('hide');
    return;
  }

  var hayError = false;
  if($('#stkCant').val() == '')
  {
    hayError = true;
  }

  if($('#stkMotive').val() == '')
  {
    hayError = true;
  }

  if(hayError == true){
    $('#error').fadeIn('slow');
    return;
  }

  $('#error').fadeOut('slow');
  WaitingOpen('Guardando cambios');
  $.ajax({
    type: 'POST',
    data: { 
      id : idStk, 
      act: acStk, 
      prodId: $('#prodId').val(),
      cant: $('#stkCant').val(),
      motive: $('#stkMotive').val()
    },
    url: 'index.php/stock/setMotion', 
    success: function(result){
      WaitingClose();
      $('#modalStock').modal('hide');
      setTimeout("cargarView('Stock', 'index', '"+$('#permission').val()+"');",1000);
    },
    error: function(result){
      WaitingClose();
      alert("error");
    },
    dataType: 'json'
  });
});
</script>

<!-- Modal -->
<div class="modal fade" id="modalStock" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Movimiento</h4> 
      </div>

      <div class="modal-body" id="modalBodyStock">  
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>