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
                        <input name="" class="form-control " type="text" value="<?php echo $lote_origen ?>" id="origen"
                            name="origen" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Operario:</label>
                        <?php echo selectBusquedaAvanzada('operario', "operario", $operarios, 'recu_id', 'descripcion'); ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Producto:</label>
                        <?php echo selectBusquedaAvanzada('articulo', 'articulo', $articulos, 'arti_id', 'barcode','descripcion'); ?>

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
                        <label>Lote Destino:</label>
                        <input name="lote_destino" class="form-control " type="text">
                    </div>
                </div>
            </div>
        </form>
        <button class="btn btn-primary pull-right" onclick="agregar()"><i class="fa fa-plus"></i> Agregar</button>
    </div>
</div>

<div class="box box-primary" id="box-tabla" style="display:none">
    <div class="box-body table-responsive">
        <table class="table table-striped" id="datos" >
            <thead>
                <td width="5%"></td>
                <td>Operario</td>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Lote</th>
                <th>L. Destino</th>
            </thead>
            <tbody>

            </tbody>
        </table>
        <button class="btn btn-primary pull-right" onclick="guardar()"><i class="fa fa-save"></i> Guardar</button>
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
            <td>${data.operario}</td>
            <td>${data.articulo}</td>
            <td>${data.cantidad}</td>
            <td>${data.lote}</td>
            <td>${data.lote_destino}</td>
        </tr>`
    )
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
</script>