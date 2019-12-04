<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">
                    <label for="">Artículos:</label>
                    <?php 
                        echo select2('articulos', $listArt, 'barcode', 'arti_id', array('descripcion','Stock: %s' => 'stock', 'Unidad Medida: %s'=>'unidad_medida'));
                        ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
function selectEvent(e) {
    //Mostrar Detalle debajo del Select
    $(e).closest('.form-group').find('#detalle').html('* ' + $(e).find('option:selected').attr(
        'data-foo'));

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
        '<div><div>' + state.text + '</div><div class="foo">' +
        $(state.element).attr('data-foo') +
        '</div></div>'
    );
}
</script>