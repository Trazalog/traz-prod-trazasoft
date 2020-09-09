<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Registrar Etapa</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" data-toggle="validator" id="myForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Etapa:</label>
                                    <div class="form-group " id="inp1">
                                        <input type="text" class="form-control " id="nom_etapa"
                                            placeholder="Campo obligatorio">
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
                                    <label class="control-label">Orden:</label>
                                    <div class="form-group " id="inp3">
                                        <input type="number" min="1" class="form-control" id="orden_etapa"
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
                                    <th>Orden</th>
                                    <th>Nombres</th>
                                    <th>Nombre recipiente</th>
                                    <th></th>
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

<!-- The Modal -->
<div class="modal modal-fade" id="modal">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar etapa</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" data-toggle="validator" id="myFormModal">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Etapa:</label>
                                    <div class="form-group " id="inp_modal1">
                                        <input type="text" class="form-control " name="titulo" id="nom_modal"
                                            placeholder="Campo obligatorio" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Nombre Recipiente:</label>
                                    <div class="form-group " id="inp_modal2">
                                        <input type="text" class="form-control " name="nom_recipiente" id="reci_modal"
                                            placeholder="Campo obligatorio">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Orden:</label>
                                    <div class="form-group " id="inp_modal3">
                                        <input type="number" min="1" class="form-control" name="orden" id="orden_modal"
                                            placeholder="Campo obligatorio">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary pull-right" id="btnGuardarModal" >Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
//Date picker
$('#datepicker').datepicker({
    autoclose: true
})

//CARGA LA TABLA CON LAS ETAPAS
$.ajax({
    dataType: 'JSON',
    type: 'GET',
    url: 'Test/obtenerEtapas',
    success: function(res) {
        $('#table_id tbody').empty();
        res.forEach(function(e) {
            var htmlTags = `<tr id="${e.titulo }"> 
                <td>${e.id }</td>
                <td>${e.titulo }</td>
                <td>${e.nom_recipiente }</td>
                <td><button id="borrar" onclick="conf(eliminar,'${e.titulo}')" class="btn bg-red"><i class="fa fa-trash"></i></button>  <button id="editar" onclick="editarEtapa('${e.titulo}')" class="btn bg-green" data-toggle="modal" data-target="#modal"><i class="fa fa-edit"></i></button></td></tr>`;
            $('#table_id tbody').append(htmlTags);
            $('#table_id tfoot').attr('hidden', true);
        });
        $('#table_id').dataTable();
    },
    error: function() {},
    complete: function() {
        // wbox();
    }
});

$('#btnGuardar').on('click', function() {
    var aux = $('#nom_etapa').val();
    var data = ['' + $('#nom_etapa').val(), '' + $('#reci_etapa').val(), '' + $('#orden_etapa').val()];
    $('#inp1').removeClass('has-success has-error');
    $('#inp2').removeClass('has-success has-error');
    $('#inp3').removeClass('has-success has-error');
    var aux = $('#' + data[0]).length; //busca si existe el nombre
    // var aux2 = $('#' + data[2]).length; //busca si existe el numero de orden
    // console.log('' + $('#' + data[2]).length);
    if (aux == 0 && data[1] && data[2] > 0) {
        $('#inp1').addClass('has-success');
        $('#inp2').addClass('has-success');
        $('#inp3').addClass('has-success');
        agregarFila(data);
    } else {
        if (!data[0]) $('#inp1').addClass('has-error');
        if (!data[1]) $('#inp2').addClass('has-error');
        if (!data[2]) $('#inp3').addClass('has-error');
    }
});

/*******AGREGA ETAPA A LA TABLA*******/
function agregarFila(data) {
    $('#table_id tfoot').attr('hidden', true);
    $('#table_id').dataTable().fnDestroy();
    var htmlTags = `<tr id="${data[0] }"> 
        <td>${data[2] }</td>
        <td>${data[0] }</td>
        <td>${data[1] }</td>
        <td><button id="borrar" onclick="conf(eliminar,'${data[0]}')" class="btn bg-red"><i class="fa fa-trash"></i></button>  <button id="editar" onclick="editarEtapa('${data[0]}')" class="btn bg-green" data-toggle="modal" data-target="#modal"><i class="fa fa-edit"></i></button></td></tr>`;
    $('#table_id tbody').append(htmlTags);
    $('#table_id').dataTable();
    $.ajax({
        type: 'POST',
        data: {
            data
        },
        url: 'Test/guardarEtapa',
        success: function() {},
        error: function() {},
        complete: function() {
        }
    });

}

//GUARDAR ETAPA EDITADA
$('#btnGuardarModal').on('click',function(){
    $('#inp_modal1').removeClass('has-success has-error');
    $('#inp_modal2').removeClass('has-success has-error');
    $('#inp_modal3').removeClass('has-success has-error');
    var data = ['' + $('#nom_modal').val(), '' + $('#reci_modal').val(), '' + $('#orden_modal').val()];
    var aux = $('#' + data[0]).length; //busca si existe el nombre
    if (aux == 0 && data[1] && data[2] > 0) {
        $('#inp_modal1').addClass('has-success');
        $('#inp_modal2').addClass('has-success');
        $('#inp_modal3').addClass('has-success');

        $.ajax({
            type: 'POST',
            data: {
                data
            },
            url: 'Test/guardarEtapa',
            success: function() {},
            error: function() {},
            complete: function() {
            }
        });
    } else {
        if (!data[0]) $('#inp_modal1').addClass('has-error');
        if (!data[1]) $('#inp_modal2').addClass('has-error');
        if (!data[2]) $('#inp_modal3').addClass('has-error');
    }


})

/*******ELIMINA MATERIAL DE LA TABLA*******/
var eliminar = function(valor) {
    // arti_id = valor;
    // wbox('#table_id');
    // var etap_id = $('#etap_id').val();
    etapa = valor.id;
    $.ajax({
        type: 'POST',
        data: {
            etapa
        },
        url: 'Test/eliminarEtapa',
        success: function() {},
        error: function() {},
        complete: function() {
            wbox();
        }
    });
    $('#' + etapa).remove();
}

function editarEtapa(etapa){
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: 'Test/obtenerEtapa/'+etapa,
        success: function(res) {
            console.log(res);
            var aux = '#myFormModal';
            fillForm(res,aux);
        },
        error: function() {},
        complete: function() {}
    });
}

$('#btnGuardarModal').on('click',function(){
    var data = ['' + $('#nom_modal').val(), '' + $('#reci_modal').val(), '' + $('#orden_modal').val()];
    console.log(data);
    $('#inp_modal1').removeClass('has-success has-error');
    $('#inp_modal2').removeClass('has-success has-error');
    $('#inp_modal3').removeClass('has-success has-error');

    if (data[1] && data[2] > 0) {
        $('#inp_modal1').addClass('has-success');
        $('#inp_modal2').addClass('has-success');
        $('#inp_modal3').addClass('has-success');
        var aux = $('#' + data[0]).length; //busca si existe el nombre
        if(!aux)eliminar(data);
        agregarFila(data);
    } else {
        if (!data[0]) $('#inp_modal1').addClass('has-error');
        if (!data[1]) $('#inp_modal2').addClass('has-error');
        if (!data[2]) $('#inp_modal3').addClass('has-error');
    }

});

</script>