<?php

foreach ($list_deta_pema as $o) {
    echo '<tr data-id="' . $o['arti_id'] . '">';
    echo '<td>' . $o['barcode'] . '</td>';
    echo '<td>' . $o['descripcion'] . '</td>';
    echo '<td class="pedido " style="text-align:center">' . $o['cant_pedida'] . '</td>';
    echo '<td class="entregado" style="text-align:center">' . $o['cant_entregada'] . '</td>';
    echo '<td class="disponible" style="text-align:center">' . ($o['cant_disponible'] < 0 ? 0 : $o['cant_disponible']) . '</td>';
    echo '<td style="text-align:center"><a href="#" class="' . ($o['cant_pedida'] <= $o['cant_entregada'] || $o['cant_disponible'] == 0 ? 'hidden' : 'pendiente') . '" onclick="ver_info(this)"><i class="fa fa-fw fa-plus"></i></a></td>';
    echo '</tr>';

}

?>