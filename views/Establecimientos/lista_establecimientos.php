<!--__________________HEADER TABLA___________________________-->
<table id="tabla_establecimiento" class="table table-bordered table-striped">
  <thead class="thead-dark" bgcolor="#eeeeee">

    <th>Acciones</th>
    <th>Nombre</th>
    <th>Localidad</th>
    <th>País</th>
    <th>Dirección</th>
    <th>Estado</th>
    <th>Fecha de alta</th>


  </thead>

  <!--__________________BODY TABLA___________________________-->

  <tbody>
    <?php
    if ($establecimientos)

      foreach ($establecimientos as $fila) {
        echo "<tr id='$fila->esta_id' data-json='" . json_encode($fila) . "'>";
        echo    '<td>';
        echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                             <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                             <button onclick="eliminar(' . $fila->esta_id . ')" type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
        echo   '</td>';
        echo   "<td>$fila->nombre</td>";
        echo   "<td>$fila->localidad</td>";
        echo   "<td>$fila->pais</td>";
        echo   "<td>$fila->calle $fila->altura</td>";
        echo   "<td>" . estado($fila->estado) . "</td>";
        echo   "<td>" . formatFechaPG($fila->fec_alta) . "</td>";
        echo '</tr>';
      }

    ?>

  </tbody>
</table>

<!--__________________FIN TABLA___________________________-->




<script>
  function eliminar(id) {
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: 'index.php/general/Establecimiento/eliminar/' + id,
      data: {
        id
      },
      success: function(rsp) {
        alert('Hecho');
      },
      error: function(rsp) {
        alert('Error');
      }
    });
  }


  DataTable($('#tabla_establecimiento'))
</script>
