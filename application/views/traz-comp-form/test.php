<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">
                    Planitllas Formularios
                </div>
            </div>
            <div class="box-body">
                <?php 
            foreach ($forms as $key => $o) {
                echo "<a class='frm-new' href='#' data-form='$o->form_id'>$o->nombre $o->descripcion</a><hr>";
            }
        ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header">
                <div class="box-title">
                    Instancias Formularios
                </div>
            </div>
            <div class="box-body">
                <?php 
            foreach ($forms_guardados as $key => $o) {
                echo "<a class='frm-open' href='#' data-info='$o->info_id'>$o->info_id - $o->nombre $o->descripcion</a><hr>";
            }
        ?>
            </div>
        </div>

    </div>

</div>




<script>
detectarForm();
</script>