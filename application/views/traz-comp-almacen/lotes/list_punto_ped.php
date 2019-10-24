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
DataTable($('#stock'),false);
</script>

