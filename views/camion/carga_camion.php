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
                            <select class="form-control select2 select2-hidden-accesible" id="clientes">
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
                    <div class="col-xs-12 col-md-5">
                        <div class="form-group">
                            <label for="establecimientos" class="form-label">Lista precios<?php hreq() ?>:</label>                                
                            <select class="form-control select2 select2-hidden-accesible" id="lista_precios">
                                <option value="" disabled selected>-Seleccione lista de precios-</option>
                                <?php
                                    foreach($listasPrecios as $lista){  
                                        echo '<option value="'.$lista->lipr_id.'" " data-nombre="'.$lista->nombre.'">'.$lista->nombre.'</option>';
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>
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
    if (!ban) {
        alert(msj);
    } else {
        existe = document.getElementById('existe_tabla').value;
        carga.nombreCli= nombreCli;
        carga.cliente =document.getElementById('clientes').value;
        carga.cantidad = document.getElementById('cantidadcarga').value;
        carga.patente = document.getElementById('patentecamion').value;
        carga.motr_id = data_camion.id;
        var html = '';
        if (existe == 'no') {

            html += '<table id="tabla_carga" style="width: 90%;" class="table">';
            html += "<thead>";
            html += "<tr>";
            html += "<th>Acciones</th>";
            html += "<th>Lote</th>";
            html += "<th>Envase</th>";
            html += "<th>Producto</th>";
            html += "<th>Cliente</th>";
            html += "<th>Cantidad</th>";
            html += '</tr></thead><tbody>';
            html += "<tr data-json='" + JSON.stringify(carga) + "' id='" + carga.id + "'>";
            html +=
                '<td><i class="fa fa-fw fa-minus text-light-blue tabla_carga_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
            html += '<td>' + carga.titulo + '</td>';
            html += '<td>' + carga.tituloenvase + '</td>';
            html += '<td>' + carga.tituloproducto + '</td>';
            html += '<td>' + carga.nombreCli + '</td>';
            html += '<td>' + carga.cantidad + '</td>';
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
            html += '<td>' + carga.tituloproducto + '</td>';
            html += '<td>' + carga.nombreCli + '</td>';
            html += '<td>' + carga.cantidad + '</td>';
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
        document.getElementById('productolote').value = "";
        document.getElementById('stocklote').value = "";
        document.getElementById('cantidadcarga').value = "";
        document.getElementById('inputlotes').value = "";
        document.getElementById('clientes').value = "";

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
function FinalizarCarga() {
    existe = document.getElementById('existe_tabla').value;
    if (existe == "no") {
        alert("No ha cargado ningun lote");
    } else {
        var lotes = [];
        $('#tabla_carga tbody').find('tr').each(function() {
            json = "";
            json = JSON.parse($(this).attr('data-json'));
            lotes.push(json);
        });
        lotes = JSON.stringify(lotes);
        console.log("HARCODEO FURIOSO");
        hecho("DALE PA", "EEEEH VIERNEEEE");
        return;
        wo();
        $.ajax({
            type: 'POST',
            dataType:'JSON',
            async: false,
            data: {
                lotes: lotes
            },
            url: '<?php echo base_url(PRD) ?>general/Camion/finalizarCarga',
            success: function(result) {

                console.log(result);
                
                if(result.status == true) {
                    hecho('Guardado!','El camión se cargó exitosamente!');
                    $('#tabla_carga tbody').empty();
                    Actualiza($('#establecimientos').val());
                    ActualizaLotes();

                }
                else{
                    error('Error','No se puedo registrar carga');
                }

                return;

                if (result == "ok") {
                    linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');

                } else {
                    error('Error','Se produjo un error al guardar la carga');
                }

            },error: function(rsp){
                error('Error','Error al guardar carga');
            },complete: function(){
                wc();
            }

        });
    }
}
$(document).off('click', '.tabla_carga_borrar').on('click', '.tabla_carga_borrar', {
    idtabla: 'tabla_carga',
    idrecipiente: 'tablacargas',
    idbandera: 'existe_tabla'
}, remover);
</script>