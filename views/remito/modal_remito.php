<div class='modal fade' id='modalRemito' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>

    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' onclick='cierraModalRemito()' aria-label='Close'><span
                        aria-hidden='true'>&times;</span></button>
                <h4 class='modal-title' id='myModalLabel'>Impresión de Remito</h4>
            </div>
            <div class='modal-body' id='modalBodyRemito'>
                <div class="container-fluid">
                    <div class="row">
                        <input type="hidden" name="nro_contador_remito" id="nro_contador_remito" >
                        <div class="col-xs-5 col-md-5">
                            <img  style="width: 230px; height: 80px" src="<?php echo base_url() ?>imagenes/armo/logo_remito.jpg" id='armoLogo'>
                            <h5 style="margin: 0px"><small>Costa canal 23232 - Pocito - San Juan - Argentina</small></h5>
                            <h5 style="margin: 0px"><small>Teléfono 343232423</small></h5>
                            <h5 style="margin: 0px"><small>aromas@aromasdelmonte.com</small></h5>
                            <h5 style="margin: 0px"><small>www.aromasdelmonte.com</small></h5>
                        </div>
                        <div class="col-xs-7 col-md-7">
                            <h3 style="margin-top: 5px"><b>REMITO</b></h3>
                            <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10">
                                <strong>N° <span id="nroRemito"></span></strong>
                                <p>Documento no válido como factura</p>
                                <p>FECHA <span id="fechaRemito"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4>Cliente <span id="clienteRemito"></span></h4>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 centrar">
                        <div id="sec_productos">
                            <!-- ______ TABLA ARTICULOS ______ -->
                            <table id="tabla_detalle" class="table table-bordered table-striped">
                                <thead class="thead-dark" bgcolor="#eeeeee">
                                    <th style="width: 5%;">Cantidad</th>
                                    <th>Descripción</th>
                                    <th>P. Unitario</th>
                                    <th>Importe</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6" style="text-align: right;">
                                    <label class="control-label" for="footer_table">Total:</label>
                                    <div class="input-group" style="display:inline-flex;">
                                        <input id="footer_table2" name="footer_table2" type="text" class="form-control input-md" readonly>
                                    </div>
                                </div>
                                <!--_______ FIN TABLA ARTICULOS ______-->
                            </div>
                        </div>
                        <!-- <h3><strong>TEXTO CONFIGURABLE</strong></h3> -->
                        <!-- <p>OBSERVACIONES</p> -->
                    </div>
                    <!-- / Bloque de cotizacion -->
                </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-default' onclick='cierraModalRemito()'>Cancelar</button>
                <button type='button' class='btn btn-primary' onclick='imprimirRemito()'>Imprimir</button>
            </div>
        </div>
    </div>
</div>
<script>
function cierraModalRemito() {
    $('#modalRemito').modal('hide');
}

//impresion del remito
function imprimirRemito() {
        var base = "<?php echo base_url()?>";
        $('#modalBodyRemito').printThis({
            debug: false,
            importCSS: true,
            importStyle: true,
            pageTitle: "TRAZALOG TOOLS",
            printContainer: true,
            loadCSS: base + "lib/bower_components/bootstrap/dist/css/bootstrap.min.css",
            copyTagClasses: true,
            printDelay: 4000,
            afterPrint: function() {
            },
            base: base
        });
}


</script>