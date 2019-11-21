<div class="form-group">
    <select class="select" name="item" class="form-control">
        <?php 
            foreach ($list as $key => $o) {
                echo "<option value='$o->value' data-json='".json_encode($o)."'>$o->label</option>";
            }
        ?>
    </select>
</div>

<script>
$('.select').select2();
$('.select').on('change', function() {
    alert(this.value);
});
</script>