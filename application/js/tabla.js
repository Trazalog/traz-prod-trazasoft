function armaTabla(idtabla, idrecipiente, json, acciones = "") {
    $.ajax({
        type: 'POST',
        data: { json: json, idtabla: idtabla, acciones: acciones },
        url: 'general/Tabla/armaTabla',
        async: true,
        success: function(result) {
            document.getElementById(idrecipiente).innerHTML = result;
            $('#' + idtabla).DataTable({});
        }

    });

}

function insertaFila(idtabla, json, acciones = "") {

    $.ajax({
        type: 'POST',
        data: { json: json, idtabla: idtabla, acciones: acciones },
        url: 'general/Tabla/insertaFila',
        async: true,
        success: function(result) {
            $('#' + idtabla + ' tbody').append(result);
        }

    });

}