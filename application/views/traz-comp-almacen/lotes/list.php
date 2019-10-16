<input type="hidden" id="permission" value="<?php echo $permission;?>">

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Movimientos de Stock</h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <table id="stock" class="table table-bordered table-hover">
                    <thead>
                        <th class="text-center">N° Lote</th>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th>Deposito</th>
                        <th>Estado</th>
                    </thead>
                    <tbody>
                        <?php
               
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
<script>
DataTable($('table#stock'));
</script>

