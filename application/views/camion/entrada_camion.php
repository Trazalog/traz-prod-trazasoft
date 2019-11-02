<?php $this->load->view('camion/modal_productos')?>
<div class="box">
    <div class="box-header with-border">
        <h3><?php echo $lang["EntrarCamion"]; ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""
                data-original-title="Collapse">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title=""
                data-original-title="Remove">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <input type="hidden" id="accioncamion">
            <div class="col-md-6 col-xs-12">
                <div id="cargacamion" onclick="cargacamion()">
                    <img src="<?php echo base_url('icon/truck.png'); ?>" alt="Smiley face" height="42" width="42">
                    <label for="">CARGA</label>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div id="descargacamion" onclick="descargacamion()">
                    <img src="<?php echo base_url('icon/order.png'); ?>" alt="Smiley face" height="42" width="42">
                    <label for="">DESCARGA</label>
                </div>
            </div>
        </div>
        <form id="frm-info">
            <div class="row" style="margin-top: 40px">
                <div class="col-md-1 col-xs-12">
                    <label class="form-label">Boleta*:</label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <input type="text" class="form-control" placeholder="Inserte Numero de Boleta" name="boleta">
                </div>
                <div class="col-md-5">
                </div>
            </div>
            <div class="row" style="margin-top:40px">
                <div class="col-md-2 col-xs-12">
                    <label for="establecimientos" class="form-label">Establecimiento*:</label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <select class="form-control select2 select2-hidden-accesible" id="establecimientos"
                        name="establecimiento">
                        <option value="" disabled selected>-Seleccione Establecimiento-</option>
                        <?php
foreach ($establecimientos as $fila) {
    echo '<option value="' . $fila->esta_id . '" >' . $fila->nombre . '</option>';
}
?>
                    </select>
                </div>
                <div class="col-md-1 col-xs-12">
                    <label for="fecha" class="form-label">Fecha*:</label>
                </div>
                <div class="col-md-3 col-xs-12">
                    <input type="date" id="fecha" value="<?php echo $fecha; ?>" class="form-control" name="fecha">
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row" style="margin-top:40px">
                <div class="col-md-1 col-xs-12">
                    <label class="form-label">Proveedor*:</label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <input list="proveedores" class="form-control" id="proveedor" name="proveedor" autocomplete="off">
                    <datalist id="proveedores">
                        <?php foreach ($proveedores as $fila) {
    echo "<option data-json='" . json_encode($fila) . "' value='" . $fila->id . "'>" . $fila->titulo . "</option>";
}
?>
                    </datalist>
                </div>
                <div class="col-md-5 col-xs-12"><input type="text" disabled id="nombreproveedor" class="form-control">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Datos Camión</h3>
    </div>
    <div class="box-body">
        <form id="frm-camion">
            <div class="row" style="margin-top:40px">
                <div class="col-md-1 col-xs-12"><label class="form-label">Patente*:</label></div>
                <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="patente" name="patente">
                </div>
                <div class="col-md-1 col-xs-12"><label class="form-label">Acoplado*:</label></div>
                <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="acoplado" name="acoplado">
                </div>
                <div class="col-md-1 col-xs-12"><label class="form-label">Conductor*:</label></div>
                <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="conductor" name="conductor">
                </div>
                <div class="col-md-1 col-xs-12"><label class="form-label">Tipo*:</label></div>
                <div class="col-md-2 col-xs-12"><input type="text" class="form-control" id="tipo" name="tipo"></div>
            </div>
            <div class="row" style="margin-top:40px">
                <div class="col-md-1 col-xs-12"><label class="form-label">Bruto*:</label></div>
                <div class="col-md-3 col-xs-12"><input type="number" class="form-control" onchange=actualizaNeto()
                        id="bruto" name="bruto"></div>
                <div class="col-md-1 col-xs-12"><label class="form-label">Tara*:</label></div>
                <div class="col-md-3 col-xs-12"><input type="number" class="form-control" id="tara"
                        onchange=actualizaNeto() name="tara"></div>
                <div class="col-md-1 col-xs-12"><label class="form-label">Neto:</label></div>
                <div class="col-md-3 col-xs-12"><input type="text" class="form-control" id="neto" name="neto" readonly>
                </div>
            </div>
        </form>

        <hr>
        <button id="add-camion" class="btn btn-primary" style="float:right" onclick="addCamion()">Agregar</button>
    </div>
</div>
<div class="box" id="boxproductos">
    <div class="box-header">
        <h4>Datos Productos entrantes</h4>
    </div>
    <div class="box-body">
        <table class="table table-striped">
            <thead>
                <th>Codigo de Lote</th>
                <th>Recipiente</th>
            </thead>
            <tbody id="lotes-camion">

            </tbody>
        </table>
    </div>

    <!-- /.box-body -->
    <div class="box-footer">
        <div class="row">
            <div class="col-md-10 col-xs-6"></div>
            <div class="col-md-2 col-xs-6">
                <button class="btn btn-success btn-block" onclick="guardarDecarga()">Guardar</button>
            </div>
        </div>

    </div>
    <!-- /.box-footer-->
</div>

<script>
$('#patente').keyup(function(e) {
    if (e.keyCode === 13) {
        console.log('Obtener Lotes Patentes');

        if (this.value == null || this.value == '') return;
        //wo();
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: 'index.php/general/Lote/obtenerLotesCamion?patente=' + this.value,
            success: function(rsp) {

                if(rsp.data == null) return;
                rsp.data.forEach(function(e) {
                    $("#lotes-camion").append(
                        `<tr data-json='${JSON.stringify(e)}'>
                        <td class="lote">${e.lote_id}</td>
                        <td><select class="recipiente"><option value="false"> - Seleccionar - </option></select></td>
                    </tr>`
                    );
                });

                recipientes.forEach(e => { 
                   $('select.recipiente').append(`<option value="${e.id}">${e.titulo}</option>`);
                });
            },
            error: function(rsp) {
                alert('No hay Lotes Asociados');
            },
            complete: function() {
                wc();
            }
        });
    }
});

$('#establecimientos').on('change', function(){
    obtenerRecipientes();
});

var recipientes = null;
function obtenerRecipientes() {
    console.log('Obtener Recipientes');
    
    var establecimiento = $('#establecimientos').val();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'index.php/general/Recipiente/listarPorEstablecimiento',
        data:{establecimiento},
        success: function(rsp) {
            console.table(rsp);
            recipientes = rsp;
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        }
    });
}


function guardarDecarga() {
    console.log('Guardar Descarga');
    var array = [];
    var item = null;
    $('.recipiente').each(function(e) {
        item = JSON.parse($(this).closest('tr').attr('data-json'));
        item.reci_id = this.value;
        array.push(item);
    });

    array = JSON.stringify(array);

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'index.php/general/Camion/guardarDescarga',
        data: 
            array,
        success: function(rsp) {
            alert('Descarga Guardada')
        },
        error: function(rsp) {
            alert('Error: ' + rsp.msj);
            console.log(rsp.msj);
        }
    });
}

function addCamion() {
    console.log('addCamion');

    var frmCamion = new FormData($('#frm-camion')[0]);
    var frmInfo = new FormData($('#frm-info')[0]);
    var dataForm = mergeFD(frmInfo, frmCamion);
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'index.php/general/Camion/setEntrada',
        contentType: false,
        processData: false,
        cache: false,
        data: dataForm,
        success: function(rsp) {
            if (rsp.status) {
                $('#frm-camion')[0].reset();
                $('#frm-info')[0].reset();
                alert('Datos guardados con Éxito');
            } else {
                alert('Fallo el Guardado de Datos');
            }
        },
        error: function(rsp) {
            console.log(rsp.msj);
        },
        complete: function() {
            wc();
        }
    });
}
</script>


<script>
function checkTabla(idtabla, idrecipiente, json, acciones) {
    lenguaje = <?php echo json_encode($lang) ?> ;
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

function Guardar() {
    entrada = {};
    ban = true;
    msj = "";
    entrada.idestablecimiento = $("#establecimientos option:selected").attr('value');
    if (entrada.idestablecimiento == "") {
        ban = false;
        msj += "No selecciono establecimiento \n";
    } else {
        entrada.tituloestablecimiento = $("#establecimientos option:selected").text();
    }
    entrada.fecha = document.getElementById('fecha').value;
    if (entrada.fecha == "") {
        ban = false;
        msj += "No selecciono fecha \n";
    }
    entrada.proveedor = document.getElementById('proveedor').value;
    if (entrada.proveedor == "") {
        ban = false;
        msj += "No selecciono proveedor \n";
    }
    entrada.patente = document.getElementById('patente').value;
    if (entrada.patente == "") {
        ban = false;
        msj += "No ingreso patente \n";
    }
    entrada.acoplado = document.getElementById('acoplado').value;
    if (entrada.acoplado == "") {
        ban = false;
        msj += "No ingreso acoplado \n";
    }
    entrada.conductor = document.getElementById('conductor').value;
    if (entrada.conductor == "") {
        ban = false;
        msj += "No ingreso conductor \n";
    }
    entrada.tipo = document.getElementById('tipo').value;
    if (entrada.tipo == "") {
        ban = false;
        msj += "No selecciono tipo \n";
    }
    entrada.bruto = document.getElementById('bruto').value;
    if (entrada.bruto == "") {
        ban = false;
        msj += "No Ingreso peso bruto \n";
    }
    entrada.tara = document.getElementById('tara').value;
    if (entrada.tara == "") {
        ban = false;
        msj += "No ingreso tara \n";
    }
    entrada.neto = document.getElementById('neto').value;
    if (entrada.neto == "") {
        ban = false;
        msj += "No ingreso neto \n";
    }
    if (document.getElementById('productos_existe').value == 'no') {
        ban = false;
        msj += "No ingreso ningun producto \n";
    }
    if (!ban) {
        alert(msj);
    } else {
        entrada.productos = recuperarDatos('tabla_productos_asignados');
        entrada = JSON.stringify(entrada);
        $.ajax({
            type: 'POST',
            async: false,
            data: {
                entrada: entrada
            },
            url: 'general/Camion/GuardarEntrada',
            success: function(result) {
                if (result == 'ok') {
                    linkTo('general/Etapa/index');
                } else {
                    alert('Ups');
                }
            }

        });
    }

}

function cargacamion() {
    document.getElementById('cargacamion').style.borderStyle = "solid";
    document.getElementById('cargacamion').style.borderColor = "blue";
    document.getElementById('descargacamion').style.borderColor = "white";
    document.getElementById('accioncamion').value = "carga";
    document.getElementById('boxproductos').hidden = true;
    $('#add-camion').show();
}

function descargacamion() {
    document.getElementById('descargacamion').style.borderStyle = "solid";
    document.getElementById('cargacamion').style.borderColor = "white";
    document.getElementById('descargacamion').style.borderColor = "blue";
    document.getElementById('accioncamion').value = "descarga";
    document.getElementById('boxproductos').hidden = false;
    $('#add-camion').hide();
}

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
$(document).off('click', '.tabla_productos_asignados_borrar').on('click', '.tabla_productos_asignados_borrar', {
    idtabla: 'tabla_productos_asignados',
    idrecipiente: 'productosasignados',
    idbandera: 'productos_existe'
}, remover);
</script>