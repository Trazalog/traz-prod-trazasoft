<?php 
    foreach ($forms as $key => $o) {
        echo "<a class='frm-new' href='#' data-form='$o->form_id'>$o->nombre $o->descripcion</a>";
    }
?>

<script>
    detectarForm();
</script>