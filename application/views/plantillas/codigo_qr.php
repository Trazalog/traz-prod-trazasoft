<div class="box">
    <div class="box-header">
        <h3>Código QR</h3>
        <br>
        <div class="form-group">
            <label for="codigo" class="col-sm-1 col-xs-12 control-label">Código:</label>
            <div class="col-sm-3 col-xs-12">
                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php ?>" placeholder="Ingrese código de lote">
            </div>
        </div>
    </div>
    <?php if ($visible) { ?>
        <div class="box-body">
            <div class="row">
                <!-- <h3>Código QR</h3> -->
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-4 col-xs-12">
                        <?php //echo '<img id="imagenQR" src="' . $dir . basename($filename) . '" /><hr/>'; 
                        ?>
                        <?php echo '<img id="imagenQR" src="" /><hr/>'; ?>
                    </div>
                    <div class="col-md-4 col-xs-12" id="contenidoQR">
                        <?php
                        // echo '<h3>Datos lote</h3>';
                        // echo "<p>Codigo: " . $contenido[0]->codigo . "<br>
                        //     Tel.: " . $contenido[0]->tel . "<br>
                        //     Email: " . $contenido[0]->email . "</p>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script>
    $('#codigo').keyup(function(e) {
        // if ($('#accioncamion').val() != 'descarga') return;
        if (e.keyCode === 13) {
            console.log('Obtener datos lote: ' + this.value);

            if (this.value == null || this.value == '') return;
            // alert(this.value);

            // alert("hecho");
            // wo();
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: 'index.php/general/CodigoQR/generarQR/' + this.value,
                success: function(rsp) {
                    // alert("Hecho");
                    // alert(fillForm(rsp.data[0]));
                    if (_isset(rsp.data)) {
                        $('#imagenQR').attr('src', rsp.filename);
                        $('#contenidoQR').html('<h3>Datos lote</h3>' +
                            '<p>Codigo: ' + rsp.data[0].codigo +
                            '<br>Tel.: ' + rsp.data[0].tel +
                            '<br>Email: ' + rsp.data[0].email + '</p>');
                    } else {
                        // alert('Código de lote no encontrado, ingrese nuevamente');
                        // $('#frm-datosCamion')[0].reset();
                        // $('#codigo').val('');
                        // fillForm(rsp.data[0]);
                    }
                },
                error: function(rsp) {
                    alert('Error');
                },
                complete: function() {
                    // wc();
                }
            });
        }
    });

    function _isset(variable) {
        if (typeof(variable) == "undefined" || variable == null)
            return false;
        else
        if (typeof(variable) == "object" && !variable.length)
            return false;
        else
            return true;
    }
</script>