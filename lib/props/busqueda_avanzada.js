function selectEvent(e) {
    //Mostrar Detalle debajo del Select
    var detalle = $(e).find('option:selected').attr('data-foo');

    if(detalle !='') {
        var aux = $(e) .closest('.form-group').find('#detalle').html(detalle);
    }

    //Asignar data-json del Option al Select
    $(e).attr('data-json', $(e).find('option:selected').attr('data-json'));
}

function stringMatch(term, candidate) {
    return candidate && candidate.toLowerCase().indexOf(term.toLowerCase()) >= 0;
}

function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
        return data;
    }
    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
        return null;
    }
    // Match text of option
    if (stringMatch(params.term, data.text)) {
        return data;
    }
    // Match attribute "data-foo" of option
    if (stringMatch(params.term, $(data.element).attr('data-foo'))) {
        return data;
    }
    // Return `null` if the term should not be displayed
    return null;
}

function formatCustom(state) {
    return $(
        '<div style="font-weight: bold;"><div>' + state.text + '</div><div class="foo text-black">' +
        $(state.element).attr('data-foo') +
        '</div></div>'
    );
}