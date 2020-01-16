function getSnapshot() {
    wo();
    var key = $('#snapshot').attr('data-key');
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'traz-comp/Snapshot/obtener',
        data: {
            key
        },
        success: function (rsp) {

            if (!rsp.status) {
                console.log('Snapshot: Falla al Obtener Datos Temporales');
                return;
            }

            const data = JSON.parse(rsp.data);

            if (!data) return;

            fillForm(data, true);

        },
        error: function (rsp) {
            console.log('GET Snapshot: Error');

        },
        complete: function () {
            wc();
        }
    });
}

function fillForm(data, refresh = false) {
    Object.keys(data).forEach(function (key) {

        var input = $('[name="' + key + '"]')[0];

        if (input) {

            //Radio
            if (input.getAttribute('type') == 'radio') {
                $('[name="' + key + '"][value="' + data[key] + '"]').attr('checked', true);
            }

            if (input.getAttribute('type') == 'checkbox') {
                input.checked = true;
            } else {
                input.value = data[key];
            }
        }
    });

    if(refresh) $('select').select2().trigger('change');
}

function saveSnapshot() {
    var datos = {};

    $('#snapshot').find(
        'input[type="text"],input[type="number"], input[type="checkbox"]:checked, input[type="radio"]:checked, select, textarea').each(
            function (e) {
                const name = this.getAttribute('name');
                datos[name] = $(this).val();
            });

    datos['key'] = $('#snapshot').attr('data-key');

    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'traz-comp/Snapshot/guardar',
        data: {
            datos
        },
        success: function (rsp) {
            console.log('Snapshot Guardado');
        },
        error: function (rsp) {
            console.log('POST Snapshot: Error');
        },
        complete: function () {
            wc();
        }
    });
}