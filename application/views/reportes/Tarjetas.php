<section class="content-header">
    <h1>
        Tarjetas
    </h1>
</section>
<section class="content">
    <!-- /.row -->
    <!-- =========================================================== -->
    <div class="row">
        <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group col-sm-4">
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="search" placeholder="Buscar">
                    </div>
                    <button type="submit" class="btn btn-default col-sm-3">Buscar</button>
                </div>
            </div>
            <!-- /.box-body -->
        </form>
        <!-- /.col -->
        <div id="contenedorTarjetas">
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $lote ?></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php //echo $datos_lote->etapa; 
                        ?>
                        <!-- <br> -->
                        <?php foreach ($datos_lote as $key => $o) { ?>
                            <label class="text-withe" for="flt-<?php echo $key ?>"><?php echo ucfirst($key) ?>:</label> <?php echo $o ?>
                            <br>
                        <?php } ?>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.col -->
    </div>
</section>
<script>
    $('#contenedorTarjetas').html();
</script>