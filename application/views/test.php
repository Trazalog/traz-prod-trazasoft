<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Etapas y materiales</h4>
    </div>
    <div class="box-body">
        <form id="frm-test">
            <div class="row">
                <!--__________________________________________________-->
                <!--DROPDOWN ETAPAS-->
                <div class="col-md-12" id="prueba">
                    <div class="col-md-4" >
                        <div class="form-group" >
                            <select class="custom-select form-control" name="etap_id" id="etap_id" requiered>
                                <?php
                                    echo "<option selected disable>seleccione una etapa</option>";
                                    foreach($etapas as $valor)
                                    {
                                        echo "<option value='$valor->id'>$valor->titulo</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p class="text-danger" hidden id="lab_et">la etapa no tiene materiales asignados</p>
                    </div>
                </div>
                <!--__________________________________________________-->
                <div class="col-md-12">
                    <!--DROPDOWN MATERIALES-->
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="custom-select form-control" name="mate_id" id="mate_id" required>
                                <?php 
                                    echo "<option selected>seleccione un material</option>";
                                    foreach($materiales as $value)
                                    {
                                        echo "<option value='".json_encode($value)."'>$value->titulo</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!--__________________________________________________-->
                    <!--BOTON AGREGAR MATERIALES A TABLA-->
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success btn-block" onclick="agregarFila()">agregar
                            material</button>
                    </div>
                    <!--__________________________________________________-->
                </div>
            </div>
        </form>
        <!--__________________________________________________-->
        <!--TABLA DINAMICA DE MATERIALES-->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover" id="tablaPrueba">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>unidad de medida</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!--__________________________________________________-->
    </div>
</div>
<script>
// function guardarSalida() {
//     var data = getForm('#frm-test');
//     console.log(data);
//     $.ajax({
//         type: 'POST',
//         data,
//         url: "Test/prueba",
//         success: function(res) {
//             console.log('succes ' + res);
//         },
//         error: function(res) {
//             console.log('error ' + res);
//         },
//         complete: function() {}
//     });
// }

/*******CARGA TABLA CON MATERIALES DE ETAPA*******/
$('#etap_id').on('change',function(){

    var etap_id = this.value;
    $.ajax({
        dataType:'JSON',
        type: 'GET',
        url:'Test/getMaterialesPorEtapa/'+etap_id,
        success: function(res) {
            $('#tablaPrueba tbody').empty();
            $('#lab_et').hide();
            $();
            console.log(res.data);
            if(res.data)
            {
                res.data.forEach(function(e){
                var htmlTags = '<tr ' + e.id + '>' +
                '<td>' + e.descripcion + '</td>' +
                '<td>' + e.um + '</td>' +
                '<td><button id="borrar" class="btn bg-red"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
                $('#tablaPrueba tbody').append(htmlTags);
                });
            }else $('#lab_et').show();
            
        },
        error: function() {
        },
        complete: function() {
        }
    });
});

/*******AGREGA MATERIAL A LA TABLA*******/
function agregarFila() {

    var data = JSON.parse($("#mate_id").val());
    console.log(''.aux);
    var aux = $('tr #'+data.id).length();
    console.log(aux);
    if()
    {
        var htmlTags = '<tr id= '+ data.id +'>' +
        '<td>' + data.titulo + '</td>' +
        '<td>' + data.unidad_medida + '</td>' +
        '<td><button id="borrar" class="btn bg-red"><i class="fa fa-trash"></i></button></td>' +
        '</tr>';
        $('#tablaPrueba tbody').append(htmlTags);
        $('#lab_et').hide();
    }
    
}

/*******ELIMINA MATERIAL DE LA TABLA*******/
$(document).on('click', '#borrar', function (event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});


</script>