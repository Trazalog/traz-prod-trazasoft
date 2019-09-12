<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section>

      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Puntos de Pedido</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="stock" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Código</th>
                <th class="text-center">Punto Pedido</th>
                <th class="text-center">Cant. Stock</th>
                <th class="text-center">Cant. Disponible</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  if(!$list) return;             

                	foreach($list as $f)
      		        {
  	                echo '<tr>';
                    echo '<td>'.$f['descripcion'].'</td>';
                    echo '<td>'.$f['barcode'].'</td>';
                    echo '<td class="text-center">'.$f['punto_pedido'].'</td>';
                    echo '<td class="text-center">'.$f['cantidad_stock'].'</td>';
                    echo '<td class="text-center '.($f['cantidad_disponible']<0?"text-danger":"").'">'.$f['cantidad_disponible'].'</td>';
  	                echo '</tr>';
      		        }
                
              ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
   
</section><!-- /.content -->

<script>
  $(function () {
    //$("#groups").DataTable();
    $('#stock').DataTable({
      "aLengthMenu": [ 10, 25, 50, 100 ],
      "columnDefs": [ {
        "targets": [ 0 ], 
        "searchable": false
      },
      {
        "targets": [ 0 ], 
        "orderable": false
      } ],
      "order": [[1, "asc"]],
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