<?php $this->load->view('camion/modal_lotes')?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Carga Camión</h3>
        <div class="box-tools pull-right">
        </div>
    </div>
    <div class="box-body">
        <!--Primera fila: Camiones Establecimiento y Fecha-->
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label for="establecimientos" class="form-label" style="margin-right: 30px; min-width: 120px;">Establecimiento<?php hreq() ?>:</label>
                    <select class="form-control form-control-sm select2 select2-hidden-accesible" onchange="Actualiza(this.value); ActualizaLotes();" id="establecimientos" style="max-width: 300px;">
                        <option value="" disabled>-Seleccione establecimiento-</option>
                        <?php
                        foreach($establecimientos as $fila)
                        {  
                            echo '<option value="'.$fila->esta_id.'" '.($fila === reset($establecimientos) ? 'selected' : '').'>'.$fila->nombre.'</option>';
                        } 
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label for="fecha" class="form-label" style="margin-right: 10px; min-width: 60px;">Fecha<?php hreq() ?>:</label>
                    <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control form-control-sm" style="max-width: 300px;">
                </div>
            </div>
        </div>
        <!-- Segunda fila: Camiones ingresados y botón -->
        <div class="row" style="margin-top: 10px;">
            <div class="col-xs-12 col-md-6">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label class="form-label" for="" style="margin-right: 10px; min-width: 120px;">Camiones ingresados<?php hreq() ?>:</label>
                    <select id="camiones" class="form-control form-control-sm" onchange="DatosCamion()" disabled style="max-width: 300px;">
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <?php if($camionInterno): ?>
                    <div class="form-group" style="display: flex; align-items: center;">
                        <button type="button" class="btn btn-primary" id="generarCamionInterno" onclick="crearTransportePropio()" style="min-width: 200px;">Generar camión interno</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Tercera fila: Fecha ingreso, Patente, Conductor -->
        <div class="row" style="margin-top: 10px;">
            <div class="col-xs-12 col-md-4">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 60px; min-width: 90px;">Fecha ingreso</label>
                    <input class="form-control form-control-sm" id="fechacamion" type="text" disabled style="max-width: 300px;">
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 10px; min-width: 70px;">Patente</label>
                    <input class="form-control form-control-sm" id="patentecamion" type="text" disabled style="max-width: 300px;">
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 10px; min-width: 80px;">Conductor</label>
                    <input class="form-control form-control-sm" id="conductorcamion" type="text" disabled style="max-width: 300px;">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Datos de Carga</h3>
    </div>
    <div class="box-body">
        <!-- Primera fila: Cód. Lote, Fecha lote, Envase -->
        <div class="row firstRowOrder">
            <div class="col-xs-12 col-md-4">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 10px; min-width: 90px;">Cód. Lote<?php hreq() ?>:</label>
                    <div class="col-md-12 ba">
                            <?php echo selectBusquedaAvanzada('inputlotes'); ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 10px; min-width: 80px;">Fecha lote</label>
                    <input class="form-control form-control-sm" type="text" disabled id="fechalote" style="max-width: 200px;">
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 10px; min-width: 60px;">Envase</label>
                    <input class="form-control form-control-sm" type="text" id="envaselote" disabled style="max-width: 200px;">
                </div>
            </div>
        </div>
        <!-- Segunda fila: Cliente, Lista Precios, Cantidad -->
        <div class="row secondRowOrder" style="margin-top: 10px;">
            <div class="col-xs-12 col-md-4">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label for="clientes" class="form-label" style="margin-right: 55px; min-width: 60px;">Cliente<?php hreq() ?>:</label>
                    <select class="form-control sel2 select2-hidden-accesible" id="clientes" style="max-width: 200px;">
                        <option value="" disabled selected>-Seleccione cliente-</option>
                        <?php
                            foreach($clientes as $fila){  
                                echo '<option value="'.$fila->clie_id.'" data-nombre="'.$fila->nombre.'">'.$fila->nombre.'</option>';
                            } 
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <?php if($listasPrecios): ?>
                <div class="form-group" style="display: flex; align-items: center;">
                    <label for="lista_precios" class="form-label" style="margin-right: 10px; min-width: 80px;">Lista Precios<?php hreq() ?>:</label>
                    <select class="form-control sel2 select2-hidden-accesible" id="lista_precios" style="max-width: 350px;">
                        <option value="" data-foo='' disabled selected>-Seleccione lista de precios-</option>
                        <?php
                            foreach($listasPrecios as $lista){
                                $version = $lista->detalles_lista_precio->detalle_lista_precio[0]->nro_version ? '<label> - </label><small><cite>v'.$lista->detalles_lista_precio->detalle_lista_precio[0]->nro_version.'</cite></small><label> - </label>' : '';
                                $descripcion = $lista->detalles_lista_precio->detalle_lista_precio[0]->descripcion ? '<small><cite>'.$lista->detalles_lista_precio->detalle_lista_precio[0]->descripcion.' </cite></small>' : '';
                                $aux = $version ? $version : '';
                                $aux .= $descripcion ? $descripcion : '';
                                echo "<option data-foo='$aux' data-json='".json_encode($lista)."' value='$lista->lipr_id' data-nombre='$lista->nombre'>$lista->nombre</option>";
                            } 
                        ?>
                    </select>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group" style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 10px; min-width: 60px;">Cantidad<?php hreq() ?>:</label>
                    <input class="form-control form-control-sm" type="number" placeholder="Ingrese cantidad" id="cantidadcarga" style="max-width: 120px;" step="any">
                </div>
            </div>
        </div>
        <!-- Tercera fila: Botón Cargar Camión -->
        <div class="row" style="margin-top: 10px;">
            <div class="col-xs-12 text-center">
                <button class="btn btn-primary" type="button" onclick="Cargar();" style="width: 400px;">Cargar Camión</button>
            </div>
        </div>
        <div class="row thirdRowOrder">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <!-- <h3 style="margin-top: 5px;"><small>Datos del lote</small></h3> -->
                <div class="form-inline">
                    <!-- <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Producto:</label>
                            <input class="form-control" type="text" id="productolote" disabled>
                        </div>
                    </div> -->
                    <!-- /.producto -->
                    <!-- <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Stock:</label>
                            <input class="form-control" type="text" id="stocklote" disabled>
                        </div>
                    </div> -->
                    <!-- /.stock -->

                </div><!-- /.form-inline -->
            </div><!-- /.col -->
        </div><!-- /.thirdRowOrder -->
        <div class="row" style="margin-top: 20px">
            <input type="hidden" id="existe_tabla" value="no">
            <div class="col-xs-12 table-responsive" id="tablacargas"></div>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-2 col-xs-6">
                <button type="button" class="btn btn-block btn-success " onclick="FinalizarCarga()">Finalizar</button>
            </div>
            <div class="col-md-2 col-xs-6">
                <button type="button" class="btn btn-block btn-danger"
                    onclick="linkTo('<?php echo base_url(PRD) ?>general/Camion/recepcionCamion');">Cancelar</button>
            </div>
        </div>
    </div>
    <!-- /.box-footer-->
    <!-- MODAL REMITO -->
    <?php $this->load->view(PRD. "camion/modal_remito") ?>
    <!-- FIN MODAL REMITO -->
</div>
<script>
//Variable core.tablas para identificar remitos valorizados
var verListaPrecios = <?php echo $remitosValorizados ? $remitosValorizados[0]->valor : 'false' ?>;

//--- formato de los select ----
// --- AGREGADO PARA MOSTRAR NOMBRE - VERSION - DESCRIPCION EN EL SELECT SELECCIONADO ---
function formatCustom (state) {
    if (!state.id) {
        return state.text;
    }
    // Obtener el data-foo del option
    var foo = $(state.element).data('foo');
    if (foo) {
        // Si foo ya tiene HTML, lo devolvemos como HTML
        return $('<span>' + state.text + ' ' + foo + '</span>');
    } else {
        return state.text;
    }
}

function formatCustomSelection (state) {
    if (!state.id) {
        return state.text;
    }
    var foo = $(state.element).data('foo');
    if (foo) {
        // Mostramos nombre - version - descripcion en el seleccionado
        return $('<span>' + state.text + ' ' + foo + '</span>');
    } else {
        return state.text;
    }
}
//---Fin formato de los select ----

$(document).ready(function () {
    $(".sel2").select2();
    //inicializacion select lista de precios
    $('#lista_precios').select2({
        placeholder: "-Seleccione lista de precios-",
        allowClear: true,
        templateResult: formatCustom,
        templateSelection: formatCustomSelection
    });

    // Seleccionar el primer establecimiento por defecto
    var select = document.getElementById('establecimientos');
    if (select.options.length > 1) {
        select.selectedIndex = 1; // El índice 1 es el primer establecimiento (0 es el placeholder)
        select.dispatchEvent(new Event('change')); // Disparamos el evento change para que se ejecute Actualiza()
    }
});

function Blanquealote() {
    document.getElementById('inputlotes').value = "";
}

function Actualiza(establecimiento, esCamionInterno = false) {
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {
            establecimiento: establecimiento
        },
        url: '<?php echo base_url(PRD) ?>general/Camion/listarPorEstablecimiento',
        success: function(result) {
           console.table(result);
           document.getElementById('camiones').innerHTML = "";
           if(!result) return;
            var html = "";
            html = html + '<option value="" disabled selected>-Seleccione camión -</option>';
            for (var i = 0; i < result.length; i++) {
                html = html + "<option data-json= '" + JSON.stringify(result[i]) + "'value='" + result[i].id + "'>" + result[i].patente + "</option>";
            }
           
            document.getElementById('camiones').innerHTML = "";
            document.getElementById('camiones').innerHTML = html;
            document.getElementById('camiones').disabled = false;
            document.getElementById('inputlotes').disabled = false;

            // Accion cuando genera camion automatico
            // Solo intentar seleccionar el camión interno si esCamionInterno es true
            if(esCamionInterno) {
                debugger;
                var camionesSelect = document.getElementById('camiones');
                for(var i = 0; i < camionesSelect.options.length; i++) {
                    var option = camionesSelect.options[i];
                    if(option.text.includes('Transporte-Propio')) {
                        camionesSelect.selectedIndex = i;
                        DatosCamion();
                        break;
                    }
                }
            }
        },
        error:function(){
            document.getElementById('camiones').innerHTML = "";
        },
        complete:function(){
            wc();
        }
    });
}

var data_camion = "";
function DatosCamion() {
    camion = JSON.parse($("#camiones option:selected").attr('data-json'));
    document.getElementById('fechacamion').value = camion.fecha;
    document.getElementById('patentecamion').value = camion.patente;
    document.getElementById('conductorcamion').value = camion.conductor;
    document.getElementById('idcamion').value = camion.id;
    document.getElementById('existe_tabla').value = 'no';
    document.getElementById('tablacargas').innerHTML = "";
    data_camion = camion;
}

function ActualizaLotes() {


    establecimiento = document.getElementById('establecimientos').value;
    salida = false;//document.getElementById('checklote').checked;
    resetSelect('#inputlotes');
    wo();
    $.ajax({
        type: 'POST',
        dataType:'JSON',
        data: {
            establecimiento: establecimiento,
            salida: salida
        },
        url: '<?php echo base_url(PRD) ?>general/Lote/listarPorEstablecimientoConSalidaStock',
        success: function(result) {
       

           if(!result.status){
               error('Error','Fallo la obtención de lotes asociados');
               return;
           }

           $('#inputlotes').html(result.data);
 
        },
        error:function(){
            error('Error','Error al obtener lotes asociados al establecimiento');
        },
        complete: function(){
            wc();
        }

    });
}
$("#inputlotes").on('change', function() {
   
    var lote = JSON.parse(this.dataset.json);
    ActualizaLote(lote);
});

$("#clientes").change(function () {
    nombreCli=($(this).find(':selected').data("nombre"));
});

function ActualizaLote(lote) {
    console.log(lote);

    document.getElementById('fechalote').value = lote.fecha;
    document.getElementById('envaselote').value = lote.tituloenvase;
    //document.getElementById('stocklote').value = lote.stock;
    // document.getElementById('productolote').value = lote.tituloproducto;
    // document.getElementById('stocklote').value = lote.stock;
}

function Cargar() {
    var carga = {};

    ban = true;
    msj = "";
    if (document.getElementById('establecimientos').value == "") {
        ban = false;
        msj += "- Por favor, seleccione establecimiento \n";
    }
    if (document.getElementById('camiones').value == "") {
        ban = false;
        msj += "- Por favor, seleccione camión \n";
    }
    if (document.getElementById('clientes').value == "") {
        ban = false;
        msj += "- Por favor, seleccione cliente \n";
    }
    if (document.getElementById('inputlotes').value == "") {
        ban = false;
        msj += "- Por favor, seleccione lote \n";
    } else {
        carga = JSON.parse($('#inputlotes').attr('data-json'));
        console.log(carga);
        var cantidad = parseFloat(document.getElementById('cantidadcarga').value);
        console.log("Cantidad: " + cantidad);
        
        if (document.getElementById('cantidadcarga').value == "" || cantidad > carga.stock) {
            ban = false;
            msj += "- Por favor, cargue la cantidad o dicha cantidad es superior al stock \n";
        }
    }
    if(verListaPrecios){
        const listaPrecios = document.getElementById("lista_precios").value;
        if(!listaPrecios){
             ban = false
            msj += "- Por favor, seleccione una lista de precios \n";
        }
        else{
                var dataArticulo = validaArticuloListaPrecio();
                if(!dataArticulo){
                    ban = false
                    msj += "- Artículo seleccionado no se encuentra en la lista de precios seleccionada \n";
                }
            }
    }
    if (!ban) {
        //alert(msj);
        Swal.fire({
            title: msj,
            text: "",
            type: "info"
            });
    } else {
        existe = document.getElementById('existe_tabla').value;
        carga.nombreCli= nombreCli;
        carga.cliente =document.getElementById('clientes').value;
        carga.cantidad = document.getElementById('cantidadcarga').value;
        carga.patente = document.getElementById('patentecamion').value;
        carga.motr_id = data_camion.id;
        if(verListaPrecios){
            carga.importeTotal = (carga.cantidad * dataArticulo.precio).toFixed(2);
            var foo = $("#lista_precios option:selected").data('foo');
            var nombre = $("#lista_precios option:selected").text();
            carga.listaPrecio = nombre + (foo ? ' ' + foo : '');
            carga.precio = parseFloat(dataArticulo.precio).toFixed(2);
            carga.core_id = dataArticulo.core_id;
        }else{
            carga.core_id = 1;// TODO: tengo que resolver como manejar el caso de empresas sin lista de precios
            carga.precio = (0).toFixed(2);
            carga.importeTotal = (0).toFixed(2);
        }
        var html = '';
        if (existe == 'no') {

            html += '<table id="tabla_carga" class="table">';
            html += "<thead>";
            html += "<tr>";
            html += "<th>Acciones</th>";
            html += "<th>Lote</th>";
            html += "<th>Envase</th>";
            html += "<th>Descripción producto</th>";
            html += "<th>Cliente</th>";
            html += "<th>Lista de precios</th>";
            html += "<th>Cantidad</th>";
            html += "<th>P.Unitario</th>";
            html += "<th>Importe</th>";
            html += '</tr></thead><tbody>';
            html += "<tr data-json='" + JSON.stringify(carga) + "' id='" + carga.id + "'>";
            html +=
                '<td><i class="fa fa-fw fa-minus text-light-blue tabla_carga_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
            html += '<td>' + carga.titulo + '</td>';
            html += '<td>' + carga.tituloenvase + '</td>';
            html += '<td class="descripcion">' + carga.tituloproducto + '</td>';
            html += '<td class="cliente">' + carga.nombreCli + '</td>';
            html += '<td>' + carga.listaPrecio + '</td>';
            html += '<td>' + carga.cantidad + '</td>';
            html += '<td>' + carga.precio + '</td>';
            html += '<td>' + carga.importeTotal + '</td>';
            html += '</tr>';
            html += '</tbody></table>';
            document.getElementById('tablacargas').innerHTML = "";
            document.getElementById('tablacargas').innerHTML = html;
            $('#tabla_carga').DataTable({});
            document.getElementById('existe_tabla').value = 'si';

        } else if (existe == 'si') {
            html += "<tr data-json='" + JSON.stringify(carga) + "' id='" + carga.id + "'>";
            html +=
                '<td><i class="fa fa-fw fa-minus text-light-blue tabla_carga_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
            html += '<td>' + carga.titulo + '</td>';
            html += '<td>' + carga.tituloenvase + '</td>';
            html += '<td class="descripcion">' + carga.tituloproducto + '</td>';
            html += '<td class="cliente">' + carga.nombreCli + '</td>';
            html += '<td>' + carga.listaPrecio + '</td>';
            html += '<td>' + carga.cantidad + '</td>';
            html += '<td>' + carga.precio + '</td>';
            html += '<td>' + carga.importeTotal + '</td>';
            html += '</tr>';
            $('#tabla_carga tbody').append(html);
            tabla = document.getElementById('tabla_carga').innerHTML;
            tabla = '<table id="tabla_carga" class="table table-bordered table-hover">' + tabla + '</table>';
            $('#tabla_carga').dataTable().fnDestroy();
            document.getElementById('tablacargas').innerHTML = "";
            document.getElementById('tablacargas').innerHTML = tabla;
            $('#tabla_carga').DataTable({});

        }
        document.getElementById('fechalote').value = "";
        document.getElementById('stocklote').value = "";
        document.getElementById('envaselote').value = "";
        document.getElementById('cantidadcarga').value = "";
        document.getElementById('inputlotes').value = "";
        $('#inputlotes').val(null).trigger('change');
        $("#detalle").text("");
        $('#clientes').val(null).trigger('change');
        $('#lista_precios').val(null).trigger('change');

    }
}

function ModalLotes() {
    establecimiento = document.getElementById('establecimientos').value;
    salida = document.getElementById('checklote').checked;
    $.ajax({
        type: 'POST',
        data: {
            establecimiento: establecimiento,
            salida: salida
        },
        url: '<?php echo base_url(PRD) ?>general/Lote/listarPorEstablecimientoConSalidaStock',
        success: function(result) {
            result = JSON.parse(result);
            var html = "";
            html = " <datalist id='lotes'>";
            for (var i = 0; i < result.length; i++) {
                html = html + "<option data-json= '" + JSON.stringify(result[i]) + "'value='" + result[i]
                    .titulo + "'></option>";
            }

            html += '</datalist>';
            document.getElementById('divlotes').innerHTML = "";
            document.getElementById('divlotes').innerHTML = html;
            var html = "";
            html += '<table id="tabla_lotes" style="width: 90%;" class="table">';
            html += "<thead>";
            html += "<tr>";
            html += "<th>Acciones</th>";
            html += "<th>Lote</th>";
            html += "<th>Envase</th>";
            html += "<th>Producto</th>";
            html += "<th>Stock</th>";
            html += '</tr></thead><tbody>';

            for (i = 0; i < result.length; i++) {
                html += "<tr data-json='" + JSON.stringify(result[i]) + "' id='" + result[i].id + "'>";
                html +=
                    '<td><i class="fa fa-fw fa-plus text-light-blue tabla_lotes_nuevo" style="cursor: pointer; margin-left: 15px;" title="Agregar"></i></td>';
                html += '<td>' + result[i].titulo + '</td>';
                html += '<td>' + result[i].tituloenvase + '</td>';
                html += '<td>' + result[i].tituloproducto + '</td>';
                html += '<td>' + result[i].stock + '</td>';
                html += '</tr>';
            }
            html += '</tbody></table>';
            document.getElementById('modallotes').innerHTML = "";
            document.getElementById('modallotes').innerHTML = html;
            $('#tabla_lotes').DataTable({});
            $("#modal_lotes").modal('show');
        }

    });
}

// Guarda la Carga de Camion
async function FinalizarCarga() {
    const existe = document.getElementById('existe_tabla').value;
    if (existe == "no") {
        error("Error","No ha cargado ningun lote");
    } else {
        let lotes = [];
        $('#tabla_carga tbody').find('tr').each(function() {
            let json = JSON.parse($(this).attr('data-json'));
            lotes.push(json);
        });
        lotes = JSON.stringify(lotes);
        wo();

        try {
            const result = await $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {
                    lotes: lotes
                },
                url: '<?php echo base_url(PRD) ?>general/Camion/finalizarCarga',
            });

            if (result.status == true) {

                // id de aromas (la que tiene el botón de camión interno)
                <?php if($listasPrecios): ?>
                
                // Obtener los datos del camión actual del select
                const camionSelect = document.getElementById('camiones');
                const selectedOption = camionSelect.options[camionSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    // Datos para la salida del camión
                    const salidaData = {
                        motr_id: selectedOption.value,
                        estado: "FINALIZADO",
                        bruto: 1,
                        tara: 1,
                        neto: 1
                    };
                    debugger;
                    // Llamada AJAX para guardar la salida
                    try {
                        const salidaResult = await $.ajax({
                            type: 'POST',
                            dataType: 'JSON',
                            data: { data: salidaData },
                            url: '<?php echo base_url(PRD) ?>general/Camion/guardarSalida',
                        });

                        if (!salidaResult.status) {
                            error('Error', 'No se pudo registrar la salida del camión');
                        }
                    } catch (salidaError) {
                        error('Error', 'Error al registrar la salida del camión');
                    }
                }
                <?php endif; ?>

                // Genero el remito e imprimo solo si tiene remitos valorizados
                if(verListaPrecios) await generaRemito();
                
                $('#tabla_carga').DataTable().clear().draw();
                Actualiza($('#establecimientos').val());
                ActualizaLotes();
                //Limpio la data
                $("#patentecamion").val("");
                $("#fechacamion").val("");
                $("#conductorcamion").val("");
                $("#clientes").val("").trigger('change');
                $("#lista_precios").val("").trigger('change');
                $("#fechalote").val("");
                $("#stocklote").val("");
                hecho('Guardado!', 'El camión se cargó exitosamente!');
            } else {
                error('Error', 'No se puedo registrar carga');
            }
        } catch (rsp) {
            error('Error', 'Error al guardar carga');
        } finally {
            wc();
        }
    }
}
$(document).off('click', '.tabla_carga_borrar').on('click', '.tabla_carga_borrar', {
    idtabla: 'tabla_carga',
    idrecipiente: 'tablacargas',
    idbandera: 'existe_tabla'
}, remover);
//Valida que el articulo seleccionado se encuentre en la lista de precios seleccionada
function validaArticuloListaPrecio(){
    var selectedOption = $('#lista_precios').find(':selected');
    var dataJson = selectedOption.data('json');
    if (dataJson.detalles_lista_precio.detalle_lista_precio != null) {
        var listaPrecios = dataJson.detalles_lista_precio.detalle_lista_precio;
        var dataLote = JSON.parse($('#inputlotes').find(':selected').attr('data-json'));
        var matchedArti = listaPrecios.find(function(articulo) {
            return articulo.arti_id === dataLote.producto;
        });

        if (matchedArti) {
            return matchedArti;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

// Genera un camion automaticamente y guarda en prd.movimientos_transportes
function crearTransportePropio() {
    var select = document.getElementById('establecimientos');
    if (select.options.length > 1) { 
        select.selectedIndex = 1;
        select.dispatchEvent(new Event('change')); 

        // Datos fijos para el camión interno
        var data = {
            accion: 'carga',
            boleta: 'Transporte-Propio',
            establecimiento: select.options[1].value,
            fecha: new Date().toISOString().split('T')[0], 
            proveedor: '1000',
            cuit: '11111',
            patente: 'Transporte-Propio',
            acoplado: '',
            conductor: 'Luis González',
            tipo: 'Transporte Propio',
            bruto: '0',
            tara: '1',
            neto: '1',
            estado: 'EN CURSO',
            empr_id: '1'
        };

        // Llamada AJAX para guardar el camión
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(PRD) ?>general/Camion/setEntrada',
            data: data,
            dataType: 'JSON',
            success: function(response) {
                if(response.status) {
                    // Actualizar la lista de camiones después de guardar
                    Actualiza(select.options[1].value, true);
                    hecho('Éxito', 'Camión interno generado correctamente');
                } else {
                    error('Error', 'El camion se encuentra cargado, Por favor verifique en Camiones ingresados');
                }
            },
            error: function() {
                error('Error', 'Error al generar el camión interno');
            }
        });
    }
}

</script>