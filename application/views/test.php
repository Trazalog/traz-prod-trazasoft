<div id="pnl-general" class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3 class="box-title">Etapas y materiales</h3>
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
                                    echo "<option selected disable value='-1'>Seleccione una etapa</option>";
                                    foreach($etapas as $valor)
                                    {
                                        echo "<option value='$valor->id'>$valor->titulo</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--__________________________________________________-->
                <div class="col-md-12">
                    <!--DROPDOWN MATERIALES-->
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="custom-select form-control"  name="mate_id" id="mate_id" required>
                                <?php 
                                    echo "<option selected >Seleccione un material</option>";
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
                            <th>Unidad de medida</th>
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
/*******ELIMINA MATERIAL DE LA TABLA*******/
var eliminar = function(valor)
{
    arti_id = valor;
    wbox('#pnl-general');
    var etap_id = $('#etap_id').val();
    $.ajax({
        type: 'POST',
        data: { etap_id,arti_id
        },
        url:'Test/eliminarMaterial',
        success: function() {
        },
        error: function() {
        },
        complete: function() {
            wbox();
        }
    });
    $('#'+valor).remove();
}

/*******CARGA TABLA CON MATERIALES DE ETAPA*******/
$('#etap_id').on('change',function(){
    var etap_id = this.value;
    if(etap_id != -1)
    {
        wbox('#pnl-general');
        $.ajax({
            dataType:'JSON',
            type: 'GET',
            url:'Test/getMaterialesPorEtapa/'+etap_id,
            success: function(res) {
                $('#tablaPrueba tbody').empty();
                $();
                console.log(res.data);
                if(res.data)
                {
                    res.data.forEach(function(e){
                    var htmlTags = '<tr id="' + e.arti_id + '">' +
                    '<td>' + e.descripcion + '</td>' +
                    '<td>' + e.um + '</td>' +
                    '<td><button id="borrar" onclick="conf(eliminar,'+e.arti_id+')" class="btn bg-red"><i class="fa fa-trash"></i></button></td>' +
                    '</tr>';
                    $('#tablaPrueba tbody').append(htmlTags);
                    });
                }else 
                {
                    error('la etapa no tiene materiales asignados','');
                }
                
            },
            error: function() {
            },
            complete: function() {
                wbox();
            }
        });
    }else
    {
        $('#tablaPrueba tbody').empty();//LIMPIA TABLA POR SELECCIONAR ETAPA NO VALIDA
    }
});

/*******AGREGA MATERIAL A LA TABLA*******/
function agregarFila() {

    var etap_id = $('#etap_id').val();
    if(etap_id != -1)
    {
        var data = JSON.parse($("#mate_id").val());
        //var aux = $('#tablaPrueba').find('#'+data.arti_id).length; // tambien funciona
        var aux = $('#'+data.arti_id).length;
        if(aux == 0)
        {
            var htmlTags = '<tr id= '+ data.arti_id +'>' +
            '<td>' + data.titulo + '</td>' +
            '<td>' + data.unidad_medida + '</td>' +
            '<td><button id="borrar" onclick="conf(eliminar,'+data.arti_id+')" class="btn bg-red"><i class="fa fa-trash"></i></button></td>' +
            '</tr>';
            $('#tablaPrueba tbody').append(htmlTags);

            var arti_id = data.arti_id;
            wbox('#pnl-general');
            $.ajax({
                    type: 'POST',
                    data: {etap_id,arti_id},
                    url:'Test/agregaMaterial',
                    success: function() {
                    },
                    error: function() {
                    },
                    complete: function() {
                        wbox();
                    }
            });
        }else error('El material ya esta asignado','');
    }
    else error('Debe seleccionar una etapa','');
}


</script>