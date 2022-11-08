<?php
foreach($ListarTrazabilidadNoConsumible as $rsp)
    {   $codigo= $rsp->codigo;
        $estado = $rsp->estado;

echo "<tr id='$codigo' data-json='" . json_encode($rsp) . "'>";
echo '<td>'.$rsp->descripcion.'</td>';
echo '<td>'.$codigo.'</td>';
echo '<td>'.$rsp->tipo.'</td>';
echo '<td>'.$rsp->responsable.'</td>';
echo '<td>'.$rsp->deposito.'</td>';
echo '<td>'.$rsp->lotes.'</td>';
echo '<td>'.$rsp->fecAlta.'</td>';
echo '<td>'.estadoNoCon($estado).'</td>';
echo '</tr>';
    }
?>