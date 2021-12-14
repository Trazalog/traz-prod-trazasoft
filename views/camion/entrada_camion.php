<?php $this->load->view('camion/modal_productos')?>
<style>
	.input-group-addon:hover{
    cursor: pointer;
    background-color: #04d61d !important;
	}
	.input-group-addon{
		background-color: #05b513 !important;
		color: white;
	}
</style>
<!-- Bloque Carga|recepcion MP -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Entrada | Recepción MP</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <input type="hidden" id="accioncamion">
            <input type="hidden" id="esExterno" name="esExterno" value="externo">
            <div class="col-md-6 col-xs-12">
                <div id="cargacamion" onclick="cargacamion();">
                    <img src="<?php echo base_url('lib/icon/truck.png'); ?>" alt="Smiley face" height="42" width="42">
                    <label for="">Entrada</label>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div id="descargacamion" onclick="descargacamion()">
                    <img src="<?php echo base_url('lib/icon/order.png'); ?>" alt="Smiley face" height="42" width="42">
                    <label for="">RECEPCIÓN MP</label>
                </div>
            </div>
        </div>
        <form id="frm-info">
                <input type="text" name="accion" id="accion" class="hidden">
                <div class="row" style="margin-top: 40px">
                        <div class="col-md-1 col-xs-12">
                                <label class="form-label">Boleta<?php hreq() ?>:</label>
                        </div>
                        <div class="col-md-6 col-xs-12">
                                <input id="boleta" type="text" class="form-control" placeholder="Inserte Numero de Boleta" name="boleta">
                        </div>
                        <div class="col-md-5">
                        </div>
                </div>
                <div class="row" style="margin-top:40px">
                        <div class="col-md-2 col-xs-12">
                            <label for="establecimientos" class="form-label">Establecimiento<?php hreq() ?>:</label>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <select class="form-control select2 select2-hidden-accesible" id="establecimientos" name="establecimiento" onchange="selectEstablecimiento()" <?php echo req() ?>>
                                    <option value="" disabled selected>-Seleccione Establecimiento-</option>
                                    <?php
                                        foreach ($establecimientos as $fila) {
                                                echo '<option value="' . $fila->esta_id . '" >' . $fila->nombre . '</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                        <div class="col-md-1 col-xs-12">
                            <label for="fecha" class="form-label">Fecha<?php hreq() ?>:</label>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <input type="date" id="fecha" value="<?php echo $fecha; ?>" class="form-control" name="fecha">
                        </div>
                        <div class="col-md-2"></div>
                </div>
                <div class="row" style="margin-top:40px">
                        <div class="col-md-1 col-xs-12">
                            <label class="form-label tag-descarga">Proveedor<?php hreq() ?>:</label>
                        </div>
                        <div class="col-md-3 col-xs-12">
                                <input list="proveedores" class="form-control tag-descarga" id="proveedor" name="proveedor" autocomplete="off">
                                <datalist id="proveedores">
                                        <?php foreach ($proveedores as $fila) {
                                        echo "<option data-json='" . json_encode($fila) . "' value='" . $fila->id . "'>" . $fila->titulo . "</option>";
                                }
                                ?>
                                </datalist>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <input type="text" disabled id="nombreproveedor" class="form-control tag-descarga">
                        </div>
                </div>
        </form>
    </div>
</div>
<!-- / Bloque Carga|recepcion MP -->

<!-- Bloque Datos Camión (en las 2 opciones) -->
<div class="box panel-req" style="display:none">
    <div class="box-header with-border">
        <h3 class="box-title">Datos Camión</h3>
    </div>
    <div class="box-body" id="div_datos_camion">
        <form id="frm-camion">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Transportista <?php hreq() ?>:</label>
                        <select style="width: 50%" class="form-control select select2" id="transportista" name="cuit" required>
                            <option disabled selected>Seleccionar</option>
                            <?php
                                foreach ($transportistas as $o) {
                                        echo "<option value='$o->cuit'>$o->razon_social</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1 col-xs-12"><label class="form-label">Patente<?php hreq() ?>:</label></div>
                <div id="patenteRecepcion" class="col-md-2 col-xs-12">
                    <div class="input-group">
                        <input type="text" class="form-control" id="patente" name="patente" required>
                        <span id="btn-buscaPatente" class="input-group-addon" onclick="ejecutarEnter()"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                <div id="patenteEntrada" class="col-md-2 col-xs-12">
                    <div class="input-group">
                        <input type="text" class="form-control" id="patEntrada" name="patente" required>
                    </div>
                </div>
                <div class="col-md-1 col-xs-12"><label class="form-label">Acoplado:</label></div>
                <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="acoplado" name="acoplado">
                </div>
                <div class="col-md-1 col-xs-12"><label class="form-label">Conductor<?php hreq() ?>:</label></div>
                <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="conductor" name="conductor" required>
                </div>
                <div class="col-md-1 col-xs-12"><label class="form-label">Tipo<?php hreq() ?>:</label></div>
                <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="tipo" name="tipo" required></div>
            </div>
            <div class="row" style="margin-top:40px">
                <div class="col-md-1 col-xs-12">
                    <label class="form-label">Bruto<?php hreq() ?>:</label>
                </div>
                <div class="col-md-3 col-xs-12">
                    <input type="number" class="form-control" id="bruto" name="bruto" onchange="calculaNeto()" required>
                </div>
                <div class="col-md-1 col-xs-12">
                    <label class="form-label">Tara<?php hreq() ?>:</label>
                </div>
                <div class="col-md-3 col-xs-12">
                    <input type="number" class="form-control" id="tara" name="tara" onchange="calculaNeto()" required>
                </div>
                <div class="col-md-1 col-xs-12">
                    <label class="form-label">Neto:</label>
                </div>
                <div class="col-md-3 col-xs-12">
                    <input type="text" class="form-control" id="neto" name="neto" readonly>
                </div>
            </div>
        </form>

        <hr>
        <button id="add-camion" class="btn btn-primary btn-sm" style="float:right" onclick="addCamion()"><i class="fa fa-plus"></i> Agregar</button>
    </div>
</div>
<!-- / Bloque Datos Camión (en las 2 opciones) -->

<!-- Solo opcion RECEPCIÓN MP -->
<div class="row">
    <!-- Bloque Ingreso -->
    <div class="col-md-6 tag-descarga" style="display:none">
        <?php
            $this->load->view('entrada_movilidad/comp/origen');
        ?>
    </div>
    <!-- / Bloque Ingreso -->

    <!-- Bloque Destino -->
    <div class="col-md-6 tag-descarga" style="display:none">
        <?php
            $this->load->view('entrada_movilidad/comp/destino');
        ?>
    </div>
    <!-- / Bloque Destino -->

    <!-- Bloque Listado de Recepcion MP -->
    <div class="col-md-12 tag-descarga" style="display:none">
        <?php 
            $this->load->view('entrada_movilidad/comp/tabla_descarga');
        ?>
    </div>
    <!-- / Bloque Listado de Recepcion MP -->

    <!-- Bloque Entrada No Consumibles -->
    <div class="col-md-12 tag-descarga" style="display:none">
        <?php
            $this->load->view('NoConsumible/EntradaNoConsumible');
        ?>
    </div>
    <!-- / Bloque Entrada No Consumibles -->
</div>
<!-- Solo opcion RECEPCIÓN MP -->

<script>
$('#minimizar_datos_camion').click(function() {
        $('#div_datos_camion').toggle(1000);
});
$('#minimizar_ingreso').click(function() {
        $('#div_ingreso').toggle(1000);
});
$('#minimizar_destino').click(function() {
        $('#div_destino').toggle(1000);
});
$('#minimizar_vale_entrada').click(function() {
        $('#div_vale_entrada').toggle(1000);
});

$('.select').select2();
$('#frm-camion').on('reset', function() {
    $(this).find('.select').val(null).trigger('change');
});

function reset() {
    $('#new_codigo').removeClass('hidden').attr('disabled', false);
    $('#frm-origen #codigo').attr('disabled', true).next(".select2-container").hide();
    $('#frm-origen')[0].reset();
    $('#frm-destino')[0].reset();
    $('.inp-descarga').attr('readonly', false);
    $("#frm-info")[0].reset();
    $("#frm-camion")[0].reset();
    $('#lotes').empty();
}
var recipienteSelect = null;

//Ejecuta la funcion del keyup para obtenerInfoCamion()
function ejecutarEnter(){
    e = $.Event('keyup');
    e.keyCode= 13; // enter
    $('#patente').trigger(e);

}
$('#patente').keyup(function(e) {

    if ($('#accioncamion').val() != 'descarga') return;
    this.value = this.value.replace(' ', '');
    if (e.keyCode === 13) {
        console.log('Obtener Lotes Patentes');
        if (this.value == null || this.value == '') return;
        var patente = this.value;
        obtenerInfoCamion(patente);
    }
});

function obtenerLotesCamion(patente) {
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Lote/obtenerLotesCamion/true',
        data: {
            patente
        },
        success: function(rsp) {

            if (!rsp.data) {
                $("#esExterno").val('externo');
                alert('No existen Lotes Asociados');
                return;
            }
            $("#esExterno").val('');
            $('#codigo').attr('disabled', false).next(".select2-container").show();
            $('#new_codigo').addClass('hidden').attr('disabled', true);

            fillSelect("#codigo", rsp.data);

            alert('Lotes Encontrados: ' + (parseInt($('#codigo').find('option').length) - 1));

        },
        error: function(rsp) {
            alert('No hay Lotes Asociados');
        },
        complete: function() {
            wc();
        }
    });
}

function obtenerInfoCamion(patente) {
    var estado = 'TRANSITO';
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {
            estado
        },
        url: `<?php echo base_url(PRD) ?>general/Camion/obtenerInfo/${patente}`,
        success: function(rsp) {
            
            if (!$.isEmptyObject(rsp)){
                
                fillForm(rsp);
                obtenerLotesCamion(patente); 
        
            }else{
                $('#frm-camion')[0].reset();
                $("#patente").val(patente);
                $("#esExterno").val('externo');
            }
        },
        error: function(rsp) {
            alert('Error');
        },
        complete: function(){
            wc();
        }
    });
}

// $('#establecimientos').on('change', function() {
//     obtenerRecipientes();
// });

function unificarLote() {
    var rese = $(recipienteSelect).val();
    $('.recipiente').each(function() {
        if (this.value == rese) this.dataset.unificar = true;
    });
}

function obtenerFormularioCamion() {
    var frmCamion = new FormData($('#frm-camion')[0]);
    var frmInfo = new FormData($('#frm-info')[0]);
    var dataForm = mergeFD(frmInfo, frmCamion);
    dataForm.append('estado', 'EN CURSO');
    return formToObject(dataForm);
}
// Valida ambos formularios tanto ENTRADA como RECEPCION MP
// Cuando valida RECEPCION MP se muestran mas campos en frm-info
// el parametro 'msj' me permite saber si es ENTRADA o RECEPCION MP
function validarFormulario(msj) {
    var ban = true;
    if(msj){
        $('#frm-info').find('.form-control').each(function() {
            if(this.id != 'proveedor' && this.id != 'nombreproveedor'){
                if (this.value == "") {
                    ban = false;
                }
            }
        });
    }else{
        $('#frm-info').find('.form-control').each(function() {
            if (this.value == "") {
                ban = false;
            }
        });
    }
    //Valído formulario de Datos Camión IDEM Entrada y Recepcion
    if(!frm_validar("#frm-camion")){ban = false;}
    
    if (!ban) Swal.fire('Error..','Complete los campos obligatorios(*)','error');
    return ban;
}

// Guarda Entrada de Camión
//Guardar Datos de Camión parametro = FALSE es para NO mostrar el MSJ de Datos Guardados
function addCamion(msj = true) {
    if (!validarFormulario(msj)) return;
    var frmCamion = new FormData($('#frm-camion')[0]);
    var frmInfo = new FormData($('#frm-info')[0]);
    var dataForm = mergeFD(frmInfo, frmCamion);
    dataForm.append('estado', 'EN CURSO');
    showFD(dataForm);
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '<?php echo base_url(PRD) ?>general/Camion/setEntrada',
        contentType: false,
        processData: false,
        cache: false,
        data: dataForm,
        success: function(rsp) {
            if (rsp.status) {
                if ($('#bloque_descarga:visible').length == 0) {
                    $('#frm-camion')[0].reset();
                    $('#frm-info')[0].reset();
                }
                if ($("#esExterno").val() != 'externo') Swal.fire('Correcto','Datos guardados con éxito','success');

                //Llamo al guardado de la descarga
                guardarDescargaOrigen();
            } else {
                if (rsp.msj) alert(rsp.msj)
                else alert('Fallo al guardar datos del camión');
            }
        },
        error: function(rsp) {
            alert('Error al guardar datos del camión');
        },
        complete: function() {
            wc();
        }
    });
}
</script>
<script>
function checkTabla(idtabla, idrecipiente, json, acciones) {
    lenguaje = <?php echo json_encode($lang) ?>;
    if (document.getElementById(idtabla) == null) {
        armaTabla(idtabla, idrecipiente, json, lenguaje, acciones);
    }
}
$("#inputproductos").on('change', function() {
    ban = $("#productos option[value='" + $('#inputproductos').val() + "']").length;
    if (ban == 0) {
        alert('Producto Inexistente');
        document.getElementById('inputproductos').value = "";

    }
});
$("#proveedor").on('change', function() {
    ban = $("#proveedores option[value='" + $('#proveedor').val() + "']").length;

    if (ban == 0) {
        alert('Proveedor Inexistente');
        document.getElementById('proveedor').value = "";
        document.getElementById('nombreproveedor').value = "";
    } else {
        document.getElementById('nombreproveedor').value = JSON.parse($("#proveedores option[value='" + $(
            '#proveedor').val() + "']").attr('data-json')).titulo;
    }
});

function AgregarProducto() {
    ban = true;
    msj = "";
    productonombre = document.getElementById('inputproductos').value;
    if (productonombre == "") {
        msj += "No Ingreso Producto \n";
        ban = false;
    }
    cantidad = document.getElementById('cantidad').value;
    if (cantidad == "") {
        msj += "No Ingreso Cantidad \n";
        ban = false;
    }
    empaque = document.getElementById('empaques').value;
    if (empaque == "") {
        msj += "No seleeciono Empaque \n";
        ban = false;
    }
    peso = document.getElementById('pesoreal').value;
    if (peso == "") {
        msj += "No Ingreso Peso \n";
        ban = false;
    }
    if (!ban) {
        alert(msj);
    } else {
        empaque = JSON.parse($("#empaques option:selected").attr('data-json'));
        producto = JSON.parse($("#productos option[value='" + $('#inputproductos').val() + "']").attr('data-json'));
        producto.cantidad = cantidad;
        producto.empaqueid = empaque.id;
        producto.empaquetitulo = empaque.titulo;
        producto.peso = peso;
        agregaProducto(producto);
        document.getElementById('inputproductos').value = "";
        document.getElementById('cantidad').value = "";
        document.getElementById('pesoreal').value = "";
        document.getElementById('pesoestimado').value = "";
        document.getElementById('empaques').value = "";
        document.getElementById('cantidad').disabled = true;
    }
}

function agregaProducto(producto) {
    existe = document.getElementById('productos_existe').value;
    var html = '';
    if (existe == 'no') {

        html += '<table id="tabla_productos_asignados" style="width: 90%;" class="table">';
        html += "<thead>";
        html += "<tr>";
        html += "<th>Acciones</th>";
        html += "<th>Producto</th>";
        html += "<th>Empaque</th>";
        html += "<th>Cantidad</th>";
        html += "<th>Peso</th>";
        html += '</tr></thead><tbody>';
        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.id + "'>";
        html +=
            '<td><i class="fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
        html += '<td>' + producto.titulo + '</td>';
        html += '<td>' + producto.empaquetitulo + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '<td>' + producto.peso + '</td>';
        html += '</tr>';
        html += '</tbody></table>';
        document.getElementById('productosasignados').innerHTML = "";
        document.getElementById('productosasignados').innerHTML = html;
        $('#tabla_productos_asignados').DataTable({});
        document.getElementById('productos_existe').value = 'si';

    } else if (existe == 'si') {
        html += "<tr data-json='" + JSON.stringify(producto) + "' id='" + producto.id + "'>";
        html +=
            '<td><i class="fa fa-fw fa-minus text-light-blue tabla_productos_asignados_borrar" style="cursor: pointer; margin-left: 15px;" title="Eliminar"></i></td>';
        html += '<td>' + producto.titulo + '</td>';
        html += '<td>' + producto.empaquetitulo + '</td>';
        html += '<td>' + producto.cantidad + '</td>';
        html += '<td>' + producto.peso + '</td>';
        html += '</tr>';
        $('#tabla_productos_asignados tbody').append(html);
        tabla = document.getElementById('tabla_productos_asignados').innerHTML;
        tabla = '<table id="tabla_productos_asignados" class="table table-bordered table-hover">' + tabla + '</table>';
        $('#tabla_productos_asignados').dataTable().fnDestroy();
        document.getElementById('productosasignados').innerHTML = "";
        document.getElementById('productosasignados').innerHTML = tabla;
        $('#tabla_productos_asignados').DataTable({});

    }
}

function ActualizaEmpaques() {
    document.getElementById('cantidad').value = "";
    document.getElementById('cantidad').disabled = false;
}

function ActualizaPesoEstimado() {
    empaque = JSON.parse($("#empaques option:selected").attr('data-json'));
    cantidad = document.getElementById('cantidad').value;
    calc = empaque.volumen * cantidad;
    document.getElementById('pesoestimado').value = calc + empaque.unidad;
}

function cargacamion() {
    //Reseteo todos los formularios
    reset();
    $('#accion').val('carga');
    $('.panel-req').show();

    document.getElementById('cargacamion').style.borderStyle = "solid";
    document.getElementById('cargacamion').style.borderColor = "blue";
    document.getElementById('descargacamion').style.borderColor = "white";
    document.getElementById('accioncamion').value = "carga";
    $('#patente').attr('disabled','disabled');
    $('#patenteRecepcion').hide();
    $('#patEntrada').attr('disabled',false);
    $('#patenteEntrada').show();
    //document.getElementById('boxproductos').hidden = true;

    $('#add-camion').show();
    //$('.btn-cargar').hide();
    $('.tag-descarga').hide();
}

function descargacamion() {
    reset();
    $('#accion').val('descarga');
    $('.panel-req').show();

    document.getElementById('descargacamion').style.borderStyle = "solid";
    document.getElementById('cargacamion').style.borderColor = "white";
    document.getElementById('descargacamion').style.borderColor = "blue";
    document.getElementById('accioncamion').value = "descarga";
    // document.getElementById('boxproductos').hidden = false;
    $('#add-camion').hide();
    //$('.btn-cargar').show();
    $('#patente').attr('disabled',false);
    $('#patenteRecepcion').show();
    $('#patEntrada').attr('disabled','disabled');
    $('#patenteEntrada').hide();
    $('.tag-descarga').show();
}
//Se pidio que se remueva esta condicion onkeyup="actualizarNeto" sobre bruto y tara
//El camion puede esta vacío es decir BRUTO = 0
//se utiliza funcion actualizaNeto()
function actualizaNeto() {
    bruto = document.getElementById('bruto').value;
    tara = document.getElementById('tara').value;
    if (tara == "" || bruto == "") {
        document.getElementById('neto').value = "";
    } else {
        neto = bruto - tara;
        if (neto < 0) {
            alert('Revise bruto y tara algun dato es incorrecto');
            document.getElementById('neto').value = "";
        } else {
            document.getElementById('neto').value = neto;
        }
    }
}
// suma tara con peso neto de carga
function calculaNeto(){
    if (!_isset($('#bruto').val()) || (parseFloat($('#bruto').val()) <= parseFloat($('#tara').val()))) {
        $('#neto').val(0);
        return;
    }else{
        $('#neto').val(parseFloat($('#bruto').val()) - parseFloat($('#tara').val()));
    }
}

$(document).off('click', '.tabla_productos_asignados_borrar').on('click', '.tabla_productos_asignados_borrar', {
    idtabla: 'tabla_productos_asignados',
    idrecipiente: 'productosasignados',
    idbandera: 'productos_existe'
}, remover);

//Busco los datos de movimientos no FINALIZADOS del camión por patente
//onchange id="patEntrada"
function getEstadosFinalizadosCamion(){

    // var estado = 'TRANSITO';
    var patente = $("#patEntrada").val();
    
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {
            patente
        },
        url: `<?php echo base_url(PRD) ?>general/Camion/getEstadosFinalizadosCamion`,
        success: function(rsp) {
            
            if (!$.isEmptyObject(rsp)){
                
                Swal.fire('Error..','La patente ingresada se encuentra ACTIVA','error');
                $("#patente").val('');
            }
        },
        error: function(rsp) {
            alert('Error');
        },
        complete: function(){
            wc();
        }
    });

}
</script>
<div class="modal" id="unificar_lotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="text-center">¿Desea Unificar Lotes?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="unificarLote()">Si</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>