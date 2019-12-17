<!--RBASAÑES-->

<div class="modal fade" id="modal_recepcioncamion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <!--Header del modal-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
            </div>
            <!--_____________________________________________________________-->

            <!--Body del modal-->
            <div class="modal-body">
                <div class="row">
                <!--DATOS ESPECIFICOS DEL MODAL-->
                
                
                <div class="box-body table-scroll table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                    <!--Cabecera del datatable-->  
                        <thead>
                            <tr>
                                <th class="articulos" id="articulos" style="width: 1000px; font-weight: lighter;">Articulos</th> 
                                <th class="cantidad" id="cantidad" style="width: 1000px; font-weight: lighter;">Cantidad</th>
                                <th class="um" id="um" style="width: 1000px; font-weight: lighter;">UM</th>
                           </tr>
                        </thead>
                    <!--________________________________________________________________________-->
                    <!--Cuerpo del Datatable-->
                    <tbody>
                        <?php
                            foreach($movimientosTransporte as $fila)
                                {
                                    $id=$fila->id;
                                    echo'<tr  id="'.$id.'" data-json=\''.json_encode($fila->articulos).'\'>';

                                    echo '<td width="5%" class="text-center">';
                                    //echo '<i class="fa fa-fw fa-search text-light-blue ml-1" style="cursor: pointer;" title="Ver" data-toggle="modal" data-target="#modal_recepcioncamion"></i>';
                                    //echo '<i class="fa fa-fw fa-times-circle text-light-blue ml-1" style="cursor: pointer;" title="Eliminar" onclick="seleccionar(this)"></i>';
                                    echo '</td>';

                                    echo '<td>'.$fila->articulo.'</td>';
                                    echo '<td>'.$fila->cantidad.'</td>';
                                    echo '<td>'.$fila->um.'</td>';
                                    echo '</tr>';

                                }
                        ?>
                    </tbody>
                    <!--________________________________________________________________________-->
                    </table>
                </div>
                <!--________________________________________________________________________-->

                </div>
            </div>
            <!--_____________________________________________________________-->

            <!--Footer del modal-->
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!--_____________________________________________________________-->

        </div>
    </div>

</div>