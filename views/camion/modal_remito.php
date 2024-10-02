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
                            <img src="<?php echo base_url() ?>imagenes/armo/armo_logo.png" id='armoLogo'>
                            <h5 style="margin: 0px"><small>Costa canal 23232 - Pocito - San Juan - Argentina</small></h5>
                            <h5 style="margin: 0px"><small>Teléfono 343232423</small></h5>
                            <h5 style="margin: 0px"><small>aromas@aromasdelmonte.com</small></h5>
                            <h5 style="margin: 0px"><small>www.aromasdelmonte.com</small></h5>
                        </div>
                        <div class="col-xs-7 col-md-7">
                            <h3 style="margin-top: 5px"><b>REMITO</b></h3>
                            <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10">
                                <strong>N° <span id="nroRemito">0000023</span></strong>
                                <p>Documento no válido como factura</p>
                                <p>FECHA <span id="fechaRemito"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4>Cliente <span id="clienteRemito">Clienteee  e e ee </span></h4>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 centrar">
                        <div id="sec_productos">
                            <!-- ______ TABLA ARTICULOS ______ -->
                            <table id="tabla_detalle" class="table table-bordered table-striped">
                                <thead class="thead-dark" bgcolor="#eeeeee">
                                    <th>Cantidad</th>
                                    <th>Descripción</th>
                                    <th>P. Unitario</th>
                                    <th>Importe</th>
                                </thead>
                                <tbody>
                                <!-- <tr>
                                    <td>300</td>
                                    <td>PIM800 - Pimenton Extra 100g</td>
                                    <td>500,00</td>
                                    <td>150000,00</td>
                                </tr>
                                <tr>
                                    <td>200</td>
                                    <td>PIM900 - Pimenton Extra 100g</td>
                                    <td>300,00</td>
                                    <td>60000,00</td>
                                </tr>
                                <tr>
                                    <td>500</td>
                                    <td>AJO330 - Ajo disecado 200g</td>
                                    <td>100,00</td>
                                    <td>50000,00</td>
                                </tr> -->
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6">
                                    <label class="control-label" for="footer_table">Total:</label>
                                    <div class="input-group" style="display:inline-flex;">
                                        <input id="footer_table2" name="footer_table2" type="text" value="260000,00" class="form-control input-md" readonly>
                                    </div>
                                </div>
                                <!--_______ FIN TABLA ARTICULOS ______-->
                            </div>
                        </div>
                        <h3><strong>TEXTO CONFIGURABLE</strong></h3>
                        <p>OBSERVACIONES</p>
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

function imprimirRemito() {
    return new Promise((resolve, reject) => {
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
                resolve();
            },
            base: base
        });
    });
}
async function generaRemito() {
    wo();
    var clientesProductos = {};
    var listadoClientesCargados = [];
    $('#tablacargas tbody tr').each(function() {
        var jsonDecoded = JSON.parse($(this).attr("data-json"));

        if (!clientesProductos[jsonDecoded.cliente]) {
            clientesProductos[jsonDecoded.cliente] = [];
            listadoClientesCargados.push({ id: jsonDecoded.cliente, nombre: jsonDecoded.nombreCli });
        }

        var productoExistente = clientesProductos[jsonDecoded.cliente].find(function(producto) {
            return producto.arti_id === jsonDecoded.producto;
        });

        if (productoExistente) {
            productoExistente.cantidad += parseFloat(jsonDecoded.cantidad);
            productoExistente.importe += parseFloat(jsonDecoded.importeTotal);
        } else {
            clientesProductos[jsonDecoded.cliente].push({
                arti_id: jsonDecoded.producto,
                descripcion: jsonDecoded.tituloproducto,
                cantidad: jsonDecoded.cantidad,
                precio: jsonDecoded.precio,
                importe: jsonDecoded.importeTotal
            });
        }
    });

    var modalBody = $('#modalBodyRemito');
    modalBody.find('#tabla_detalle tbody').empty();
    var total = 0;
    //Cargo la data en el remito
    var fechaUnformatted = $("#fecha").val();
    var fechaSpliteada = fechaUnformatted.split('-');
    var formattedDate = fechaSpliteada[2] + '-' + fechaSpliteada[1] + '-' + fechaSpliteada[0];
    $("#fechaRemito").val(formattedDate);

    for (const cliente of listadoClientesCargados) {
        modalBody.find('#clienteRemito').text(cliente.nombre);
        clientesProductos[cliente.id].forEach(function(producto) {
            var row = '<tr>' +
                '<td>' + producto.cantidad + '</td>' +
                '<td>' + producto.descripcion + '</td>' +
                '<td>' + producto.precio + '</td>' +
                '<td>' + producto.importe + '</td>' +
                '</tr>';
            modalBody.find('#tabla_detalle').append(row);
            total += producto.importe;
        });

        modalBody.find('#footer_table2').val(total);
        //Obtengo el nro del contador para remito desde core.tablas
        var remitoID = await getNroContadorRemito();
        $("#nroRemito").text(remitoID);
        //Espero a que se resuelva la promesa para continuar las impresiones
        await imprimirRemito();

        modalBody.find('#tabla_detalle tbody').empty();
        modalBody.find('#clienteRemito').empty();
        total = 0;
    }
    wc();
}
async function getNroContadorRemito () {
    let nro_contador_remito = new Promise( function(resolve,reject){
        $.ajax({
            type: 'POST',
            data: {},
            cache: false,
            dataType: "json",
            url: "<?php echo PRD; ?>camion/getNroContadorRemito",
            success: function(data) { 

                if(data.status){
                    console.log(data.message);
                    resolve();
                }else{
                    console.log(data.message);
                    reject();
                }
                 
            },
            error: function(data) {
                reject();
            }
        });
    });
    return await nro_contador_remito;
}
</script>