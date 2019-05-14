function armaTabla(idtabla, idrecipiente, json) {
    $.ajax({
        type: 'POST',
        data: { json: json, idtabla: idtabla },
        url: 'general/Tabla/armaTabla',
        async: true,
        success: function(result) {
            document.getElementById(idrecipiente).innerHTML = result;
            $('#' + idtabla).DataTable({});
        }

    });

}