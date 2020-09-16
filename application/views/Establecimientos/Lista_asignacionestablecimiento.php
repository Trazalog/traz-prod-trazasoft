<!--__________________HEADER TABLA___________________________-->
<table id="tabla_establecimiento" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

        <th>Acciones</th>
        <th>Nombre</th>
        <th>Estado</th>
        <th>Localidad</th>
        <th>Fecha de alta</th>


    </thead>

    <!--__________________BODY TABLA___________________________-->

    <tbody>
    <?php
    if($recipientes)
                    {
                        foreach($recipientes as $fila)
                        {
                        echo '<tr data-json:'.json_encode($fila).'>';
                        echo    '<td>';
                        echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                            <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                            
                        echo   '</td>';
                        echo    '<td>'.$fila.'</td>';
                        echo    '<td>'.$fila.'</td>';
                        echo    '<td>circuito</td>';
                        echo    '<td>'.$fila.'</td>';
                        echo '</tr>';
                    }
                    }
                    ?>
        
    </tbody>
</table>

<!--__________________FIN TABLA___________________________-->




<script>
DataTable($('#tabla_establecimiento'))
</script>
