<?php $this->load->view('camion/modal_lotes')?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Carga Camión</h3>
        <div class="box-tools pull-right">
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-2 col-xs-12">
                <label for="establecimientos" class="form-label">Establecimiento*:</label>
            </div>
            <div class="col-md-4 col-xs-12">
                <select class="form-control select2 select2-hidden-accesible" onchange="Actualiza(this.value); ActualizaLotes();" id="establecimientos">
                    <option value="" disabled selected>-Seleccione Establecimiento-</option>
                    <?php
                     foreach($establecimientos as $fila)
                     {  
                           echo '<option value="'.$fila->esta_id.'" >'.$fila->nombre.'</option>';
                     } 
                     ?>
                </select>
            </div>
            <div class="col-md-1 col-xs-12">
                <label for="fecha" class="form-label">Fecha*:</label>
            </div>
            <div class="col-md-3 col-xs-12">
                <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control">
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Datos Camión</h3>
    </div>
    <div class="box-body">
        <div class="row" style="margin-top:40px;">
            <div class="col-md-6 col-xs-12">
                <label class="form-label" for="">Camiones ingresados*:</label>
                <select id="camiones" class="form-control" onchange="DatosCamion()" disabled>
                </select>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <input type="hidden" id="idcamion">
                    <div class="col-md-2 col-xs-12"><label class="form-label">Fecha</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" id="fechacamion" type="text" disabled>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-xs-12"><label class="form-label">Patente</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" id="patentecamion" type="text" disabled>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-xs-12"><label class="form-label">Conductor</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" id="conductorcamion" type="text"
                            disabled></div>
                    <div class="col-md-2"></div>
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
        <div class="row" style="margin-top:40px;">
            <div class="col-md-6 col-xs-12">
               <label class="form-label" for="">Codigos Lotes*: &nbsp;&nbsp;</label>  
                <div class="row">
                    <div class="col-xs-11 margin form-group ba">
                        <?php echo selectBusquedaAvanzada('inputlotes'); ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="row">
                    <div class="col-md-2 col-xs-12"><label class="form-label">Fecha</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" type="text" disabled id="fechalote">
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-xs-12"><label class="form-label">Envase</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" type="text" id="envaselote" disabled>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-xs-12"><label class="form-label">Producto</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" type="text" id="productolote" disabled>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-xs-12"><label class="form-label">Stock</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" type="text" id="stocklote" disabled>
                    </div>
                    <div class="col-md-2 "></div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-xs-12"><label class="form-label">Cantidad*</label></div>
                    <div class="col-md-8 col-xs-12"><input class="form-control" type="number"
                            placeholder="Inserte Cantidad" id="cantidadcarga"></div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-xs-3"></div>
            <div class="col-xs-6"><button class="btn btn-block btn-primary" type="button"
                    onclick="Cargar();">Cargar Camión<?php #echo $lang["CargarCamion"];?></button></div>
            <div class="col-xs-3"></div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <input type="hidden" id="existe_tabla" value="no">
        <div class="col-xs-12 table-responsive" id="tablacargas"></div>
    </div>

    <!-- /.box-body -->
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
            html = html + '<option value="" disabled selected>-Seleccione Camion-</option>';
            for (var i = 0; i < result.length; i++) {
                html = html + "<option data-json= '" + JSON.stringify(result[i]) + "'value='" + result[i].id + "'>" + result[i].patente + "</option>";
            }
           
            document.getElementById('camiones').innerHTML = "";
            document.getElementById('camiones').innerHTML = html;
            document.getElementById('camiones').disabled = false;
            document.getElementById('inputlotes').disabled = false;
            document.getElementById('btnlotes').disabled = false;
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
        url: '<?php echo base_url(PRD) ?>general/Lote/listarPorEstablecimientoConSalida',
        success: function(result) {
       

           if(!result.status){
               alert('Fallo la Obtencion de Lotes Asociados');
               return;
           }

           $('#inputlotes').html(result.data);
 
        },
        error:function(){
            alert('Error al Obtener Lotes Asociados al Establecimiento');
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

function ActualizaLote(lote) {
    console.log(lote);
    
    document.getElementById('fechalote').value = lote.fecha;
    document.getElementById('envaselote').value = lote.tituloenvase;
    document.getElementById('productolote').value = lote.tituloproducto;
    document.getElementById('stocklote').value = lote.stock;
}

function Cargar() {
    var carga = {};

    ban = true;
    msj = "";
    if (document.getElementById('establecimientos').value == "") {
        ban = false;
        msj += "- No Ha ingresado establecimiento \n";
    }
    if (document.getElementById('camiones').value == "") {
        ban = false;
        msj += "- No Ha Seleccionado Camion \n";
    }
    if (document.getElementById('inputlotes').value == "") {
        ban = false;
        msj += "- No Ha Seleccionado lote \n";
    } else {
        carga = JSON.parse($('#inputlotes').attr('data-json'));
        console.log(carga);
        var cantidad = parseFloat(document.getElementById('cantidadcarga').value);
        console.log("Cantidad: " + cantidad);
        
        if (document.getElementById('cantidadcarga').value == "" || cantidad > carga.stock) {
            ban = false;
            msj += "- No Ha Cargado la cantidad o la cantidad es superior al stock \n";
        }
    }
    if (!ban) {
        alert(msj);
    } else {
        existe = document.getElementById('existe_tabla').value;
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
            html += "<th>Cantidad</th>";
            html += '</tr></thead><tbody>';
            html += "<tr data-json='" + JSON.stringify(carga) + "' id='" + carga.id + "'>";
            html +=
                '<td><i class="fa fa-fw fa-minus text-light-blue tabla_carga_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
            html += '<td>' + carga.titulo + '</td>';
            html += '<td>' + carga.tituloenvase + '</td>';
            html += '<td>' + carga.tituloproducto + '</td>';
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
        url: '<?php echo base_url(PRD) ?>general/Lote/listarPorEstablecimientoConSalida',
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
                    alert("Hecho");
                    $('#tabla_carga tbody').empty();
                    Actualiza($('#establecimientos').val());
                    ActualizaLotes();

                }
                else{
                    alert('No se puedo Registrar Carga');
                }

                return;

                if (result == "ok") {
                    linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');

                } else {
                    alert('Ups! algo salio mal');
                }

            },error: function(rsp){
                alert('Error al Guardar Cargar');
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