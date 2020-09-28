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
                <div class="col-md-12 col-xs-12" id="idQR">
                    <div class="col-md-4 col-xs-12" id="contenidoImgQR">
                        <?php //echo '<img id="imagenQR" src="' . $dir . basename($filename) . '" /><hr/>'; 
                        ?>
                        <?php echo '<img id="imagenQR" src="" />'; ?>
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
        if (e.keyCode === 13) {
            console.log('Obtener datos lote: ' + this.value);

            if (this.value == null || this.value == '') return;
            wo();
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '<?php echo base_url(PRD) ?>general/CodigoQR/generarQR/' + this.value,
                success: function(rsp) {
                    // alert(fillForm(rsp.data[0]));
                    if (_isset(rsp.data)) {
                        $('#imagenQR').attr('src', rsp.filename);
                        $('#contenidoQR').html('<h3>Datos lote</h3>' +
                            '<p>Código: ' + rsp.data[0].codigo +
                            '<br>Tel.: ' + rsp.data[0].tel +
                            '<br>Email: ' + rsp.data[0].email +
                            '<br><button type="button" class="btn btn-default btn-flat btn-dropbox" onclick="imprimirElemento();" id="idPrint"><i class="fa fa-print"></i></button></p>');
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
                    wc();
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

    function imprimirElemento() {
        var elemento2 = $("#idQR").html();
        $('#idPrint').remove();
        var elemento = $("#idQR").html();
        $("#idQR").empty();
        
        var ventana = window.open('', 'PRINT', 'height=600,width=800');
        ventana.document.write('<html><head><title>Código QR</title>');
        ventana.document.write('<link rel="stylesheet" href="<?php base_url(); ?>application/css/codigoQR.css">');
        ventana.document.write('</head><body >');
        ventana.document.write(elemento);
        ventana.document.write('</body></html>');
        ventana.document.close();
        ventana.focus();
        ventana.print();
        // ventana.close();
        $("#idQR").html(elemento2);
        return true;
    }
</script>