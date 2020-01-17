<div id="variables" class="hidden">
    <input class="form-control" type="text" id="loteorigen" value="<?php echo $etapa->lote;?>" readonly>
    <input class="form-control" type="text" id="num_orden_prod" value="<?php echo $etapa->orden;?>" readonly>
    <input class="form-control" type="text" id="batch_id_padre" value="<?php echo $etapa->id;?>" readonly>
    <input class="form-control" type="text" id="cant_origen"
        value="<?php echo $producto[0]->stock.' ('.$producto[0]->uni_med.')';?>" disabled>
</div>


<div class="box box-primary">
    <div class="box-header">
        <i class="fa fa-list"></i>
        <div class="box-title"> Reporte Producción Operario </div>
    </div>
    <div class="box-body">

        <form id="frm-reporte">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Lote Origen:</label>
                        <input name="" class="form-control " type="text" value="<?php echo $etapa->lote ?>" id="origen"
                            name="origen" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Operario:</label>
                        <?php echo selectBusquedaAvanzada('operario', "recu_id", $operarios, 'recu_id', 'descripcion'); ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Producto:</label>
                        <?php echo selectBusquedaAvanzada('articulo', 'arti_id', $articulos, 'arti_id', 'barcode','descripcion'); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input name="cantidad" class="form-control " type="number">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lote:</label>
                        <input name="lote" class="form-control " type="text" id="lote">
                        <a href="#" class="pull-right" onclick="$('#lote').val($('#origen').val());">#Copiar Lote
                            Origen</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Destino:</label>
                        <?php echo selectBusquedaAvanzada('destino', 'destino', $recipientes, 'reci_id', 'nombre', array('Estado:'=>'estado','Lote:'=>'lote_id', 'barcode', 'descripcion')); ?>
                    </div>
                </div>
            </div>

            <input value="false" class="hidden" name="forzar_agregar">
            <input value="HUMANO" class="hidden" name="tipo_recurso">

        </form>
        <button class="btn btn-primary pull-right" onclick="agregar()"><i class="fa fa-plus"></i> Agregar</button>
    </div>
</div>

<div class="box box-primary" id="box-tabla" style="display:none">
    <div class="box-body table-responsive">
        <table class="table table-striped" id="datos">
            <thead>
                <td width="5%"></td>
                <td>Operario</td>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Lote</th>
                <th>Destino</th>
            </thead>
            <tbody>

            </tbody>
        </table>
        <button class="btn btn-primary pull-right" onclick="FinalizarEtapa()"><i class="fa fa-save"></i>
            Guardar</button>
    </div>
</div>

<script>
function agregar() {
    $('#box-tabla').show();
    var data = new FormData($('#frm-reporte')[0]);
    data = formToObject(data);

    $('#datos tbody').append(
        `<tr data-json='${JSON.stringify(data)}'>
            <td><button class="btn btn-link" onclick="$(this).closest('tr').remove();"><i class="fa fa-times"></i></button></td>
            <td>${$('option[value="'+data.recu_id+'"]').html()}</td>
            <td>${$('option[value="'+data.arti_id+'"]').html()}</td>
            <td>${data.cantidad}</td>
            <td>${data.lote}</td>
            <td>${$('option[value="'+data.destino+'"]').html()}</td>
        </tr>`
    );

    $('#frm-reporte')[0].reset();
    $('select').select2().trigger('change');
}

function guardar() {
    var data = [];
    $('#datos tbody tr').each(function() {
        data.push(JSON.parse(this.dataset.json));
    });

    if (!data.lenght) {
        alert('Sin Datos para Registrar.');
        return;
    }

    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'index.php/Test/guardar',
        data: {
            data
        },
        success: function(rsp) {
            alert('Hecho');
        },
        error: function(rsp) {
            alert('Error');
        },
        complete: function() {
            wc();
        }
    });
}

function FinalizarEtapa() {

    var productos = [];

    $('#datos tbody tr').each(function() {
        productos.push(JSON.parse(this.dataset.json));
    });

    if (productos.lenght == 0) {
        alert('Sin Datos para Registrar.');
        return;
    }

    productos = JSON.stringify(productos);
    lote_id = $('#loteorigen').val();
    batch_id_padre = $('#batch_id_padre').val();
    cantidad_padre = 0;
    num_orden_prod = $('#num_orden_prod').val();
    destino = $('#articulo').val();

    $.ajax({
        type: 'POST',
        data: {
            productos,
            lote_id,
            batch_id_padre,
            cantidad_padre,
            num_orden_prod,
            destino
        },
        url: 'general/Etapa/Finalizar',
        success: function(result) {
            $('#datos tbody').empty();
            alert('Hecho');
        },
        error: function() {
            alert('Error');
        }
    });
}
</script>