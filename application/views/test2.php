<div class="row">
    <div class="col-md-12">
        <div class="box  box-primary">
            <div class="box-header">
                <h3 class="box-title">Registro Etapas<h/3>
            </div>
            <div class="box-body">
                <button class="btn btn-primary">Agregar</button>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Información</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" data-toggle="validator" id="myForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Etapa:</label>
                                    <div class="form-group " id="inp1">
                                        <!-- <input type="text" class="form-control " id="nom_etapa"
                                            placeholder="Campo obligatorio"> -->
                                            <select class="form-control " id="nom_etapa">
                                                <option disabled selected>- Seleccionar etapa -</option>
                                                <?php
                                                    foreach($etapa as $et){
                                                        $aux = json_encode($et);
                                                        echo "<option id='$et->id' value='$aux'>$et->nombre</option>";
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Nombre Recipiente:</label>
                                    <div class="form-group " id="inp2">
                                        <input type="text" class="form-control " id="reci_etapa"
                                            placeholder="Campo obligatorio">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Fecha:</label>
                                    <div class="form-group " id="inp3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="datepicker"
                                                placeholder="Campo obligatorio">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Usuario:</label>
                                    <div class="form-group " id="inp4">
                                        <input type="text" class="form-control" id="usu_etapa"
                                            placeholder="Campo obligatorio">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary pull-right" id="btnGuardar">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover table-bordered" id="table_id">
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Nombre recipiente</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-center">No hay etapas</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <span class="help-block"><i class="fa fa-check"></i>Help block with success</span> -->
<script>
//Date picker
$('#datepicker').datepicker({
    autoclose: true
})

$('#table_id').dataTable();

$('#btnGuardar').on('click', function() {
    var aux = $('#nom_etapa').val();
    aux = JSON.parse(aux);
    var data = ['' + aux.nombre, '' + $('#reci_etapa').val(), '' + $('#datepicker').val(), '' + $(
        '#usu_etapa').val(),'' + aux.id];
    console.log(data);
    $('#inp1').removeClass('has-success has-error');
    $('#inp2').removeClass('has-success has-error');
    $('#inp3').removeClass('has-success has-error');
    $('#inp4').removeClass('has-success has-error');

    if (data[0] && data[1] && data[2] && data[3]) {
        $('#inp1').addClass('has-success');
        $('#inp2').addClass('has-success');
        $('#inp3').addClass('has-success');
        $('#inp4').addClass('has-success');
        // var aux = JSON.parse(data);
        agregarFila(data);
    } else {
        if (!data[0]) $('#inp1').addClass('has-error');
        if (!data[1]) $('#inp2').addClass('has-error');
        if (!data[2]) $('#inp3').addClass('has-error');
        if (!data[3]) $('#inp4').addClass('has-error');
    }
});

/*******AGREGA MATERIAL A LA TABLA*******/
function agregarFila(data) {
    $('#table_id tfoot').attr('hidden', true);
    // var etap_id = $('#etap_id').val();
    // var data = JSON.parse($("#mate_id").val());
    //var aux = $('#table_id').find('#'+data.arti_id).length; // tambien funciona
    var aux = $('#' + data[4]).length;
    if (aux == 0) {
        var htmlTags = '<tr id="' + data[4] + '">' +
            '<td>' + data[0] + '</td>' +
            '<td>' + data[1] + '</td>' +
            '<td><button id="borrar" onclick="conf(eliminar,' + data[4] +
            ')" class="btn bg-red"><i class="fa fa-trash"></i></button></td>' +
            '</tr>';
        $('#table_id tbody').append(htmlTags);
        var arti_id = data.arti_id;
        wbox('#tabla');
        $.ajax({
            type: 'POST',
            data: {
                etap_id,
                arti_id
            },
            url: 'general/Etapa/agregaMaterial',
            success: function() {},
            error: function() {},
            complete: function() {
                wbox();
            }
        });
    } else error('El material ya esta asignado', '');
}


/*******ELIMINA MATERIAL DE LA TABLA*******/
var eliminar = function(valor) {
    arti_id = valor;
    wbox('#tabla');
    var etap_id = $('#etap_id').val();
    $.ajax({
        type: 'POST',
        data: {
            etap_id,
            arti_id
        },
        url: 'general/Etapa/eliminarMaterial',
        success: function() {},
        error: function() {},
        complete: function() {
            wbox();
        }
    });
    $('#' + valor).remove();
}


//CARGA LA TABLA CON LAS ETAPAS
$.ajax({
    dataType: 'JSON',
    type: 'GET',
    url: 'Test/obtenerEtapas',
    success: function(res) {
        console.log(res);
        $('#table_id tbody').empty();
        res.forEach(function(e) {
            var htmlTags = '<tr id="' + e.id + '">' +
            '<td>' + e.titulo + '</td>' +
            '<td>' + e.nom_recipiente + '</td>' +
            '<td><button id="borrar" onclick="conf(eliminar,' + e.id +
            ')" class="btn bg-red"><i class="fa fa-trash"></i></button></td>' +
            '</tr>';
            $('#table_id tbody').append(htmlTags);
            $('#table_id tfoot').attr('hidden', true);
        });
    },
    error: function() {},
    complete: function() {
        wbox();
    }
    });


</script>