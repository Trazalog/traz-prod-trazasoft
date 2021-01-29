<style>
.center-arbol {
    display: block;
    margin-right: auto;
    margin-left: auto;
}

.scrolls {
    overflow-x: scroll;
    overflow-y: hidden;
    /* height: 80px; */
    white-space: nowrap
}
</style>
<section class="content">
    <div class="row">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4>Trazabilidad de Bloques</h4>
            </div>
            <div class="box-body">
                <div class=" form-group col-sm-5">
                    <div class="col-sm-2">
                        <h5>Lote</h5>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="batch" name="batch"
                            placeholder="Ingrese código de batch">
                    </div>
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-block btn-primary btn-flat"
                            onclick="buscarBatch()">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" hidden>
        <div class="box box-warning">
            <div class="box-header with-border">
                <a class="btn btn-social-icon btn-vk pull-left" onclick="print('tree')"><i class="fa fa-print"></i></a>
                <h3 class="box-title"></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-toggle="collapse" data-target="#boxTree"
                        aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body panel-collapse collapse in" id="boxTree" aria-expanded="true">
                <div id="tree" class="scrolls">
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="row" hidden>
        <div class="box box-default">
            <div class="box-header with-border">
                <a class="btn btn-social-icon btn-vk pull-left" onclick="print('tabla')"><i class="fa fa-print"></i></a>
                <h3 class="box-title"></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-toggle="collapse" data-target="#boxTabla"
                        aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body panel-collapse collapse in" id="boxTabla" aria-expanded="true">
                <table id="tabla" class="table table-bordered table-striped table-hover display">
                    <thead>
                        <tr>
                            <th style="width: 1%;"></th>
                            <th style="width: 8%;">Cod. Lote</th>
                            <th style="width: 9%;">Estado</th>
                            <th style="width: 10%;">N° Orden</th>
                            <th style="width: 8%;">Etapa</th>
                            <th style="width: 10%;">Recipiente</th>
                            <!-- <th>Articulo</th> -->
                            <!-- <th style="width: 19%;">Path</th> -->
                            <th style="width: 10%;">Alta lote</th>
                            <!-- <th type="hidden">Articulo</th>
              <th style="width: 19%;" type="hidden">Path</th> -->
                        </tr>
                    </thead>
                    <tbody id="tbodyTabla">

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</section>

<script>
var table = '';

function buscarBatch() {
    var nodos = '';
    var batch = $('#batch').val();
    wo();
    $.ajax({
        type: 'GET',
        data: {
            batch: batch
        },
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/Lote/trazabilidadBatch',
        success: function(rsp) {
            $('#tree').parents('div .row').prop('hidden', '');
            $('#tabla').parents('div .row').prop('hidden', '');
            // console.log(rsp.data);
            var aux = [];
            if (rsp.data) {
                rsp.data.forEach(function(e) {
                    if (!aux[e.batch_id_padre]) aux[e.batch_id_padre] = [];
                    aux[e.batch_id_padre].push(e);
                    // console.log(e);
                });

                var reducido = reduceDatos(rsp.data, aux);
                nodos = formarJson(rsp.data, reducido);
                crearArbol(nodos);
                crearTabla(rsp.data);
            } else {
                alert('No hay datos para mostrar')
            }
        },
        error: function(rsp) {
            $("#tree").empty();
            $('.zmrcntr').empty();
            $('#tabla').empty();

            // if (!_isset(table)) {
            //   console.log('entra');
            //   table = $('#tabla').dataTable().fnDestroy();
            // }
            // alert("¡Batch no se encontrado! Intente nuevamente.");
            Swal.fire({
                icon: 'error',
                title: rsp.responseText
            })
        },
        complete: function(rsp) {
            wc();
        }
    })
}

function crearArbol(nodos) {
    $("#tree").empty();
    $('.zmrcntr').empty();
    // console.log('nodosssss');
    // console.log(nodos);
    $("#tree").jHTree({
        callType: 'obj',
        structureObj: nodos,
        nodeDropComplete: function(event, data) {
            //----- Do Something @ Server side or client side -----------
            // alert("Node ID: " + 4 + " Parent Node ID: " + 6);
            //-----------------------------------------------------------
        }
    });

    // $("#tree").jHTree({
    //   callType: 'obj',
    //   structureObj: nodos,
    //   zoomer: true
    // });
    return;
}

function reduceDatos(data, aux) {
    var array = [data.length];
    // console.table(array);
    for (let i = 0; i < data.length; i++) {
        array[i] = new Array();
        array[i]['head'] = data[i].lote_id;
        array[i]['id'] = data[i].batch_id;
        array[i]['contents'] = "Estado: " + data[i].lote_estado + "<br>Alta: " + data[i].lote_fec_alta + "<br>Etapa: " +
            data[i].etap_nombre + "<br>Recipiente: " + data[i].reci_nombre + "<br>Tipo: " + data[i].reci_tipo;
        array[i]['children'] = aux[data[i].batch_id];
    }
    var aux2 = [];
    array.forEach(function(e) {
        if (!(!e.children || e.children == null || e.children == '' || e.children == 'undefined')) {
            aux2[e.id] = [];
            var aux3 = [];
            var h = 0;
            e.children.forEach(function(o) {
                aux3[h] = [];
                aux3[h]['head'] = o.lote_id;
                aux3[h]['id'] = o.batch_id;
                aux3[h]['contents'] = "Estado: " + o.lote_estado + "<br>Alta: " + o.lote_fec_alta +
                    "<br>Etapa: " + o.etap_nombre + "<br>Recipiente: " + o.reci_nombre + "<br>Tipo: " +
                    o.reci_tipo;
                h++;
            })
        }
    });
    // console.log(aux2);
    for (let i = 0; i < data.length; i++) {
        var id = array[i]['id'];
        array[i]['children'] = aux2[id];
    }

    // console.log('array:');
    // console.log(array);
    return array;
}

function formarJson(entero, reducido) {
    for (let i = entero.length - 2; i >= 0; i--) {
        // console.log("reducido[i]['children']: ");
        // console.log(reducido[i]['children']);
        for (let j = i + 1; j < entero.length; j++) {
            if (entero[i].batch_id == entero[j].batch_id_padre) {
                var o = Object.assign({}, reducido[j])
                reducido[i]['children'].push(o);
            }
        }
    }
    var data = Object.assign({}, reducido[0]);
    // console.log('data: ');
    // console.log(data);
    // console.table(data);
    var rsp = JSON.stringify(reducido[0]);
    // console.log('rsp: ');
    // console.log(rsp);
    // console.table(rsp);

    var array = [];
    array.push(data);
    // console.log('array');
    // console.log(array);
    var json = JSON.stringify(array);
    // console.log('json');
    // console.log(json);
    return array;
}

function format(d) { //child row
    // console.log('entra a format');
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td><b>Artículo: </b></td>' +
        '<td>' + d.arti_descripcion + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><b>Path: </b></td>' +
        '<td>' + d.path_lote_id + '</td>' +
        '</tr>' +
        '</table>';
}

function crearTabla(data) {
    // dataGlobal = data;
    // var datosTabla = '';
    // for (let i = 0; i < data.length; i++) {
    //   datosTabla += "<tr>" +
    //     "<td></td>" +
    //     "<td>" + data[i].lote_id + "</td>" +
    //     "<td>" + data[i].lote_estado + "</td>" +
    //     "<td>" + data[i].lote_num_orden_prod + "</td>" +
    //     "<td>" + data[i].etap_nombre + "</td>" +
    //     "<td>" + data[i].reci_nombre + "</td>" +
    //     // "<td>" + data[i].arti_descripcion + "</td>" +
    //     // "<td>" + data[i].path_lote_id + "</td>" +
    //     "<td>" + data[i].lote_fec_alta + "</td>" +
    //     "</tr>" +
    //     //child row
    //     '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
    //     '<tr>' +
    //     '<td>Artículo:</td>' +
    //     '<td>' + data[i].arti_descripcion + '</td>' +
    //     '</tr>' +
    //     '<tr>' +
    //     '<td>Path:</td>' +
    //     '<td>' + data[i].path_lote_id + '</td>' +
    //     '</tr>' +
    //     '</table>';
    // }
    // console.log('datosTabla');
    // console.log(data);
    // $('#tbodyTabla').html(datosTabla);
    // $('#tabla').dataTable();
    // DataTable('#tabla');
    // var data = {
    //   "data": data
    // }
    // console.log(data);
    // table = DataTable('#tabla') {

    if (!_isset(table)) {
        console.log('entra');
        // table = $('#tabla').dataTable().fnDestroy();
    }

    table = $('#tabla').DataTable({
        "bDestroy": true,
        "data": data,
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": "<i class ='fa fa-fw fa-plus-circle' style='color: #39ac39; cursor: pointer;'></i>"
            },
            {
                "data": "lote_id"
            },
            {
                "data": "lote_estado"
            },
            {
                "data": "lote_num_orden_prod"
            },
            {
                "data": "etap_nombre"
            },
            {
                "data": "reci_nombre"
            },
            {
                "data": "lote_fec_alta"
            }
        ]
    });
}

// Add event listener for opening and closing details
$('#tabla').on('click', 'td.details-control', function() {
    var tr = $(this).closest('tr');
    var row = table.row(tr);

    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.find('td:eq(0)').empty();
        tr.find('td:eq(0)').html(
            "<i class ='fa fa-fw fa-plus-circle' style='color: #39ac39; cursor: pointer;'></i>");
    } else {
        // Open this row      
        row.child(format(row.data())).show();
        tr.find('td:eq(0)').empty();
        tr.find('td:eq(0)').html(
            "<i class ='fa fa-fw fa-minus-circle' style='color: #e60000; cursor: pointer;'></i>");
    }
});
</script>