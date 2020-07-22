<table class="table table-hover table-striped">
    <thead>
        <th>Lista articulos</th>
    </thead>
    <tbody><?php 
    foreach ($articulos as $o) {
        echo "<tr>";
            
        echo "<td>$o->barcode</td>";

        echo "</tr>";
    }
?>
    </tbody>
</table>