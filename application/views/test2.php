<div class="row">
    <div class="col-md-12">
        <div class="box  box-primary">
            <div class="box-header">
                <h3 class="box-title">Registro Etapas<h /3>
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
                                    <label class="control-label">Nombre:</label>
                                    <div class="form-group " id="inp1">
                                        <input type="text" class="form-control " id="nom_etapa" placeholder="Campo obligatorio">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Nombre Recipiente:</label>
                                    <div class="form-group " id="inp2">
                                        <input type="text" class="form-control " id="reci_etapa" placeholder="Campo obligatorio">
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
                                            <input type="text" class="form-control pull-right" id="datepicker" placeholder="Campo obligatorio">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Usuario:</label>
                                    <div class="form-group " id="inp4">
                                        <input type="text" class="form-control" id="usu_etapa" placeholder="Campo obligatorio">
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
    </div>
</div>
<!-- <span class="help-block"><i class="fa fa-check"></i>Help block with success</span> -->
<script>
//Date picker
$('#datepicker').datepicker({
    autoclose: true
})

$('#btnGuardar').on('click', function() {
    var nomEtapa = $('#nom_etapa').val();
    var reciEtapa = $('#reci_etapa').val();
    var fecha = $('#datepicker').val();
    var usuEtapa = $('#usu_etapa').val();

    $('#inp1').removeClass('has-success has-error');
    $('#inp2').removeClass('has-success has-error');
    $('#inp3').removeClass('has-success has-error');
    $('#inp4').removeClass('has-success has-error');

    if(nomEtapa && reciEtapa && fecha && usuEtapa){
        $('#inp1').addClass('has-success');
        $('#inp2').addClass('has-success');
        $('#inp3').addClass('has-success');
        $('#inp4').addClass('has-success');

    }else{
        if(!nomEtapa)$('#inp1').addClass('has-error');
        if(!reciEtapa)$('#inp2').addClass('has-error');
        if(!fecha)$('#inp3').addClass('has-error');
        if(!usuEtapa)$('#inp4').addClass('has-error');
    }
});
</script>