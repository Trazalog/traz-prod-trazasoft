<input type="hidden" id="permission" value="<?php echo $permission;?>">
<?php if(viewOT)info_header('Orden de Trabajo N°'.$ot,info_orden($ot)); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div role="tabpanel" class="tab-pane">
                            <div class="form-group">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home"
                                            role="tab" data-toggle="tab">Tareas</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                            data-toggle="tab">Comentarios</a></li>
                                    <li
                                        <?php echo ($device == 'android' ? 'class= "hidden"' :'class= ""') ?>role="presentation">
                                        <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Trazabilidad
                                        </a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div role="tabpanel" class="tab-pane active" id="home"><br>
                                        <?php
													echo "<button class='btn btn-block btn-success' id='btontomar' style='width: 100px; margin-top: 10px ;display: inline-block;' onclick='tomarTarea()'>Tomar tarea</button>";
													
													echo "<button class='btn btn-block btn-danger grupNoasignado' id='btonsoltr' style='width: 100px; margin-top: 10px; display: inline-block;' onclick='soltarTarea()'>Soltar tarea</button>";											
													echo "</br>"; 
													echo "</br>"; 			
												?>

                                        <div class="panel-body">

                                            <!-- botones Tomar y soltar tareas -->


                                            <input type="text" class="form-control hidden" id="asignado"
                                                value="<?php echo $TareaBPM["assigned_id"] ?>">
                                            <form>
                                                <div class="panel panel-default">
                                                    <!-- <h4 class="panel-heading">INFORMACION:</h4> -->
                                                    <div class="panel-heading">INFORMACION:</div>

                                                    <div class="form-group">
                                                        <div class="col-sm-6 col-md-6">
                                                            <label for="tarea">Tarea</label>
                                                            <input type="text" class="form-control" id="tarea"
                                                                value="<?php echo $TareaBPM['displayName'] ?>" disabled>
                                                            <!-- id de listarea -->
                                                            <input type="text" class="hidden" id="tbl_listarea"
                                                                value="<?php #echo #$datos[0]['id_listarea'] ?>">
                                                            <!-- id de task en bonita -->
                                                            <input type="text" class="hidden" id="idTarBonita"
                                                                value="<?php echo $idTarBonita ?>">
                                                            <input type="text" class="hidden" id="esTareaStd"
                                                                value="<?php #echo #$infoTarea['visible'] ?>">
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <div class="col-sm-6 col-md-6">
                                                            <label for="fecha">Fecha de Creación</label>
                                                            <input type="text" class="form-control" id="fecha"
                                                                placeholder=""
                                                                value="<?php echo $TareaBPM['last_update_date'] ?>"
                                                                disabled>
                                                        </div>
                                                    </div><br>


                                                    <div class="form-group ">
                                                        <div class="col-sm-6 col-md-6 ">
                                                            <label for="ot ">Orden de Trabajo:</label>
                                                            <input type="text " class="form-control " id="ot"
                                                                placeholder=" "
                                                                value="<?php #echo $datos[0][ 'id_orden'] ?>" disabled>
                                                        </div>
                                                    </div><br>

                                                    <div class="form-group">
                                                        <div class="col-sm-6 col-md-6">
                                                            <label for="duracion_std">Duracion Estandar
                                                                (minutos):</label>
                                                            <input type="text" class="form-control" id="duracion_std"
                                                                placeholder=""
                                                                value="<?php #echo $datos[0]['duracion_std']  ?>"
                                                                disabled>
                                                        </div></br>
                                                    </div>

                                                    <br>

                                                    <div class="form-group">
                                                        <div class="col-sm-12 col-md-12">
                                                            <label for="detalle">Detalle</label>
                                                            <textarea class="form-control" id="detalle" rows="3"
                                                                disabled><?php echo $TareaBPM['displayDescription']?></textarea>
                                                        </div>
                                                    </div></br> </br> </br> </br> </br>



                                            </form>


                                        </div>
                                    </div>
                                    <div id="view" class="oculto" style="margin-left:3%;">
                                     
                                        <?php echo $view ?>
                       
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="profile">
                                    <div class="panel-body">
                                        <!-- COMENTARIOS -->
                                        <?php echo $comentarios ?>
                                    </div>
                                </div>

                                <div role="tabpanel"
                                    <?php echo ($device == 'android' ? 'class= "hidden"' :'class= "tab-pane"') ?>
                                    id="messages">
                                    <!-- <div role="tabpanel" class="tab-pane" id="messages" > -->

                                    <div class="panel-body">
                                        <div class="panel panel-primary">
                                            <?php timeline($timeline) ?>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- /.row -->


            <div class="modal-footer">
            <?php echo (isset($estadoOT) && $estadoOT==false?'<h4 class="text-danger text-center">La Orden de Trabajo Asociada al Pedido de Materiales ha sido Cerrada</h4><h5 class="text-center">No se podran realizar mas Entregas</h5>':null) ?>  
              <button type="button" id="cerrar" class="btn btn-primary" onclick="back();">Cerrar</button>
                <button type="button" class="btn btn-success" id="hecho" onclick="cerrarTarea()" <?php echo (isset($estadoOT) && $estadoOT==false?'disabled':null) ?> >Hecho</button>
            </div> <!-- /.modal footer -->

        </div><!-- /.box body -->
    </div> <!-- /.box  -->
</div><!-- /.col -->
</div><!-- /.row -->

<?php $this->load->view(ALM.'proceso/tareas/scripts/tarea_std'); ?>
<script>
$('.fecha').datepicker({
    autoclose: true
}).on('change', function(e) {
    // $('#genericForm').bootstrapValidator('revalidateField',$(this).attr('name'));
    console.log('Validando Campo...' + $(this).attr('name'));
    $('#genericForm').data('bootstrapValidator').resetField($(this), false);
    $('#genericForm').data('bootstrapValidator').validateField($(this));
});
</script>


<div class="modal fade bs-example-modal-lg" id="modalFormSubtarea" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12" id="contFormSubtarea">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>