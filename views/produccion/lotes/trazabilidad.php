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
                            <th style="width: 0%;"></th>
                            <th style="width: 4%;">Cod. Lote</th>
                            <th style="width: 4%;">Batch id</th>
                            <th style="width: 5%;">Estado</th>
                            <th style="width: 4%;">N° Orden</th>
                            <th style="width: 4%;">Etapa</th>
                            <th style="width: 8%;">Recipiente</th>
                            <!-- <th>Articulo</th> -->
                            <!-- <th style="width: 19%;">Path</th> -->
                            <th style="width: 7%;">Alta lote</th>
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
/*Presiona Enter y llame a la funcion buscarBatch*/
$('#batch').on('keypress', function (e) {
         if(e.which === 13){
            buscarBatch();
         }
   });
/** Fin del KeyPress */

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
            var aux = [];
            if (rsp.data) {
                crearArbol(rsp.arbol_json);
                crearTabla(rsp.data);
            } else {
                alert('No hay datos para mostrar')
            }
        },
        error: function(rsp) {
            $("#tree").empty();
            $('.zmrcntr').empty();
            $('#tabla').empty();

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

    return;
}

function format(d) { //child row
    // console.log('entra a format');
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td><b>Artículo: </b></td>' +
        '<td>' + d.arti_descripcion + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><b>Cantidad: </b></td>' +
        '<td>' + d.cantidad + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><b>Camino: </b></td>' +
        '<td>' + d.path_lote_id + '</td>' +
        '</tr>' +
        '</table>';
}

function crearTabla(data) {

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
                "data": "batch_id"
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

// //limpio arreglo para que no repita batchs
// function uniq_fast(a) {
//     var seen = {};
//     var out = [];
//     var len = a.length;
//     var j = 0;
//     for(var i = 0; i < len; i++) {
//          var item = a[i].batch_id;
//          if(seen[item] !== 1) {
//                seen[item] = 1;
//                out[j++] = item;
//          }
//     }
//     return out;
// }

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