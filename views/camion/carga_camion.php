<?php $this->load->view('camion/modal_lotes')?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Carga Camión</h3>
        <div class="box-tools pull-right">
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="form-inline">
                    <div class="col-xs-12 col-md-5">
                        <div class="form-group">
                            <label for="establecimientos" class="form-label">Establecimiento<?php hreq() ?>:</label>
                            <select class="form-control select2 select2-hidden-accesible" onchange="Actualiza(this.value); ActualizaLotes();" id="establecimientos">
                                <option value="" disabled selected>-Seleccione establecimiento-</option>
                                <?php
                                foreach($establecimientos as $fila)
                                {  
                                    echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label for="fecha" class="form-label">Fecha<?php hreq() ?>:</label>
                            <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control">
                        </div>
                    </div>
                    <!-- /.fecha seleccionada -->
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="">Camiones ingresados<?php hreq() ?>:</label>
                            <select id="camiones" class="form-control" onchange="DatosCamion()" disabled>
                            </select>
                        </div>
                    </div>
                    <!-- /.camiones -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <h3 style="margin-top: 5px;"><small>Datos del Camión</small></h3>
                <div class="form-inline">
                    <input type="hidden" id="idcamion">
                    <div class="col-xs-12 col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label class="form-label">Fecha:</label>
                            <input class="form-control" id="fechacamion" type="text" disabled>
                        </div>
                    </div>
                    <!-- /.fecha info camion -->
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Patente:</label>
                            <input class="form-control" id="patentecamion" type="text" disabled>
                        </div>
                    </div>
                    <!-- /.patente -->
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Conductor:</label>
                            <input class="form-control" id="conductorcamion" type="text" disabled>
                        </div>
                    </div>
                    <!-- /.conductor -->
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
        <div class="row firstRowOrder">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="form-inline">
                    <div class="col-xs-12 col-md-6">
                        <div class="col-xs-6 col-md-3">
                            <label class="form-label">Cód. Lote<?php hreq() ?>:</label>
                        </div>
                        <div class="col-md-9 ba">
                            <?php echo selectBusquedaAvanzada('inputlotes'); ?>
                        </div>
                    </div>
                    <!-- /.lote -->
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Fecha:</label>
                            <input class="form-control" type="text" disabled id="fechalote">
                        </div>
                    </div>
                    <!-- /.fecha -->
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Envase:</label>
                            <input class="form-control" type="text" id="envaselote" disabled>
                        </div>
                    </div>
                    <!-- /.envase -->
                    
                </div><!-- /.form-inline -->
            </div><!-- /.col -->
        </div><!-- /.firstRowOrder -->
        <div style="margin-top:10px" class="row secondRowOrder">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="form-inline">
                    <div class="col-xs-6 col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label for="establecimientos" class="form-label">Cliente<?php hreq() ?>:</label>                                
                            <select class="form-control sel2 select2-hidden-accesible" id="clientes">
                                <option value="" disabled selected>-Seleccione cliente-</option>
                                <?php
                                    foreach($clientes as $fila){  
                                        echo '<option value="'.$fila->clie_id.'" " data-nombre="'.$fila->nombre.'">'.$fila->nombre.'</option>';
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- /.cliente -->
                    <div class="col-xs-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Cantidad<?php hreq() ?>:</label>
                            <input class="form-control" type="number" placeholder="Ingrese cantidad" id="cantidadcarga">
                        </div>
                    </div>
                    <!-- /.cantidad -->
                     <?php if($listasPrecios): ?>
                    <div class="col-xs-12 col-md-5">
                        <div class="form-group">
                            <label for="lista_precios" class="form-label">Lista precios<?php hreq() ?>:</label>                                
                            <select class="form-control sel2 select2-hidden-accesible" id="lista_precios">
                                <option value="" data-foo='' disabled selected>-Seleccione lista de precios-</option>
                                <?php
                                    foreach($listasPrecios as $lista){
                                        $descripcion = $lista->detalles_lista_precio->detalle_lista_precio[0]->descripcion ? '<small><cite>'.$lista->detalles_lista_precio->detalle_lista_precio[0]->descripcion.' </cite></small><label class="text-blue">♦ </label>' : '';
                                        $version = $lista->detalles_lista_precio->detalle_lista_precio[0]->nro_version ? '<small><cite> Versión: v'.$lista->detalles_lista_precio->detalle_lista_precio[0]->nro_version.'</cite></small>' : '';
                                        $aux = $descripcion ? $descripcion : '';
                                        $aux .= $version ? $version : '';
                                        echo "<option data-foo='$aux' data-json='".json_encode($lista)."' value='$lista->lipr_id' data-nombre='$lista->nombre'>$lista->nombre</option>";
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- /.lista precio -->
                </div>
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
            <div class="col-xs-6 col-md-3 col-md-offset-5 col-lg-2">
                <button class="btn btn-block btn-primary" type="button" onclick="Cargar();">Cargar camión<?php #echo $lang["CargarCamion"];?></button>
            </div>
        </div>
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
                    onclick="linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');">Cancelar</button>
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
$(document).ready(function () {
    $(".sel2").select2();
    $('#lista_precios').select2({
        placeholder: "-Seleccione lista de precios-",
        allowClear: true,
        // width: '100%',
        templateResult: formatCustom
    });
});

function Blanquealote() {
    document.getElementById('inputlotes').value = "";
}

function Actualiza(establecimiento) {
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
            // document.getElementById('btnlotes').disabled = false;
        },error:function(){
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
    // document.getElementById('productolote').value = lote.tituloproducto;
    // document.getElementById('stocklote').value = lote.stock;
}

function Cargar() {
    var carga = {};

    ban = true;
    msj = "";
    if (document.getElementById('establecimientos').value == "") {
        ban = false;
        msj += "- No ha ingresado establecimiento \n";
    }
    if (document.getElementById('camiones').value == "") {
        ban = false;
        msj += "- No ha seleccionado camión \n";
    }
    if (document.getElementById('clientes').value == "") {
        ban = false;
        msj += "- No ha seleccionado cliente \n";
    }
    if (document.getElementById('inputlotes').value == "") {
        ban = false;
        msj += "- No ha seleccionado lote \n";
    } else {
        carga = JSON.parse($('#inputlotes').attr('data-json'));
        console.log(carga);
        var cantidad = parseFloat(document.getElementById('cantidadcarga').value);
        console.log("Cantidad: " + cantidad);
        
        if (document.getElementById('cantidadcarga').value == "" || cantidad > carga.stock) {
            ban = false;
            msj += "- No ha cargado la cantidad o dicha cantidad es superior al stock \n";
        }
    }
    if(verListaPrecios){
        var dataArticulo = validaArticuloListaPrecio();
        if(!dataArticulo){
            ban = false
            msj += "- Artículo seleccionado no se encuentra en la lista de precios seleccionada \n";
        }
    }
    if (!ban) {
        alert(msj);
    } else {
        existe = document.getElementById('existe_tabla').value;
        carga.nombreCli= nombreCli;
        carga.cliente =document.getElementById('clientes').value;
        carga.cantidad = document.getElementById('cantidadcarga').value;
        carga.patente = document.getElementById('patentecamion').value;
        carga.motr_id = data_camion.id;
        if(verListaPrecios){
            carga.importeTotal = carga.cantidad * dataArticulo.precio;
            carga.listaPrecio = $("#lista_precios option:selected").text();
            carga.precio = dataArticulo.precio;
            carga.core_id = dataArticulo.core_id;
        }else{
            carga.core_id = 1;// TODO: tengo que resolver como manejar el caso de empresas sin lista de precios
            carga.precio = 0;
            carga.importeTotal = 0;
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
                // Genero el remito e imprimo
                await generaRemito();
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
</script>