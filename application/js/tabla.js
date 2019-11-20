function armaTabla(idtabla, idrecipiente, json, lenguaje, acciones = "") {

    console.log(lenguaje);	
    $.ajax({
        type: 'POST',
        data: { json: json, idtabla: idtabla, acciones: acciones, lenguaje: lenguaje },
        url: 'general/Tabla/armaTabla',
        async: true,
        success: function(result) {
            document.getElementById(idrecipiente).innerHTML = "";
            document.getElementById(idrecipiente).innerHTML = result;
            $('#' + idtabla).DataTable({});
        }

    });

}

function insertaFila(idtabla, idrecipiente, json, acciones = "") {

    $.ajax({
        type: 'POST',
        data: { json: json, idtabla: idtabla, acciones: acciones },
        url: 'general/Tabla/insertaFila',
        async: true,
        success: function(result) {
            $('#' + idtabla + ' tbody').append(result);
            tabla = document.getElementById(idtabla).innerHTML;
            tabla = '<table id="' + idtabla + '" class="table table-bordered table-hover">' + tabla + '</table>';
            $('#' + idtabla).dataTable().fnDestroy();
            document.getElementById(idrecipiente).innerHTML = tabla;
            $('#' + idtabla).DataTable({});
        }

    });

}

function remover(event) {
    id = $(this).closest('tr').attr('id');
    $(this).closest('tr').remove();
    tabla = document.getElementById(event.data.idtabla).innerHTML;
    tabla = '<table id="' + event.data.idtabla + '" class="table table-bordered table-hover">' + tabla + '</table>';
    $('#' + event.data.idtabla).dataTable().fnDestroy();
    document.getElementById(event.data.idrecipiente).innerHTML = tabla;
    $('#' + event.data.idtabla).DataTable({});
    if ($(this).closest('tbody').children().length == 1) {
        document.getElementById(event.data.idrecipiente).innerHTML = "";
        document.getElementById(event.data.idbandera).value = 'no';
    }
}

function recuperarDatos(idtabla) {
    var ret = [];
    $('#' + idtabla + ' tbody').find('tr').each(function() {
        json = "";
        json = $(this).attr('data-json');
        ret.push(json);
    });
    ret = JSON.stringify(ret);
    return ret;
}