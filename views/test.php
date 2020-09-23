<style>
img {
    width: 50px;
    height: 50px;
}

.finca {
    background-color: #9DC3E6;
    border-radius: 2%;
}

.seleccion {
    background-color: #F4B183;
    border-radius: 2%;
}

.preclasificado {
    background-color: #C7E1AF;
    border-radius: 2%;
}

.pelado {
    background-color: #FEDB4C;
    border-radius: 2%;
}

.fraccionamiento {
    background-color: #90A9E1;
    border-radius: 2%;
}

.profileImage {
    width: 80px;
    height: 80px;
    border-radius: 25%;
    font-size: 45px;
    color: #fff;
    text-align: center;
    line-height: 75px;
    /* margin: 20px 0; */
}
</style>

<?php
    $this->load->view('etapa\modal_unificacion_lote');
?>
<div class="box box-primary">
    <div class="box-header text-center">
        <h3>Tareas</h3>
    </div>
    <div class="xbox-body">
        <table class="table">
            <tbody>
                <?php
                    foreach ($lotes as $o) {
                        if($o->estado == 'FINALIZADO' || $o->user_id != xuserId()) continue;
                        echo "<tr id='$o->id' class='data-json' onclick='verReporte(this)' data-json='".json_encode($o)."'>";
                        echo "<td width='80px'><div class='profileImage ". strtolower($o->titulo)."'>". substr($o->titulo,0,($o->titulo == 'Fraccionamiento' || $o->titulo == "Preclasificado"?2:1)) ."</div></td>";
                        echo "<td class='". strtolower($o->titulo)."'>";
                        echo "LOTE: $o->lote<br>";
                        echo "ESTABLECIMIENTO: <cite>$o->establecimiento</cite><br>";
                        echo "FECHA: ".formatFechaPG($o->fecha);
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
var $mdl = $('#modal_finalizar');
var s_batchId =  false;
function verReporte(e) {
    var data = getJson2(e);
    s_batchId = data.id;
    $mdl.modal("show");
    $('#codigo_lote').val(data.lote);
    $('#num_orden_prod').val(data.orden);
    $('#batch_id_padre').val(data.id);
    $('#cant_origen').val(data.cantidad);
    reload('#articulos-salida', data.etap_id);
    obtenerDepositos(data.esta_id);
}

function obtenerDepositos(estaId) {
    if (!estaId) return;
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {
            establecimiento: estaId,
            tipo: 'DEPOSITO'
        },
        url: 'general/Recipiente/listarPorEstablecimiento/true',
        success: function(result) {
            if (!result.status) {
                alert('Fallo al Traer Depositos');
                return;
            }

            if (!result.data) {
                alert('No hay Depositos Asociados');
                return;
            }

            fillSelect('#productodestino', result.data);
        },
        error: function() {
            alert('Error al Traer Depositos');
        }
    });
}
$tblRep = $('#tbl-reportes').find('tbody');

function agregar() {
    var data = getForm('#frm-etapa');
    var art = getJson('#inputproducto');
    var destino = getJson('#productodestino');
    $tblRep.append(
        `<tr id="${$tblRep.find('tr').length + 1}" class='data-json' data-json='${JSON.stringify(data)}' data-forzar='false'><td>Operario: ${$('#operario option:selected').text()}<br>Artículo: ${art.barcode} x ${data.cantidad}(${art.um})</td><td>${destino.nombre}</td><td><button class="btn btn-link" onclick="$(this).closest('tr').remove()"><i class="fa fa-times text-danger"></i></button></td></tr>`
    );
    $('#frm-etapa').find('.form-control:not(#codigo_lote)').val('');
    $('.select2').trigger('change');
}
</script>
<!-- The Modal -->
<div class="modal modal-fade" id="modal_finalizar">
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reporte de Producción</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="frm-etapa">
                    <input type="text" class="hidden" id="num_orden_prod">
                    <input type="text" class="hidden" id="batch_id_padre">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Codigo Lote:</label>
                                <input type="text" id="codigo_lote" class='form-control' readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Asignar Operario:</label>
                                <select id="operario" name="recu_id" class="form-control">
                                    <?php foreach($rec_trabajo as $o) {echo "<option value='$o->recu_id' data-json='".json_encode($o)."'>$o->descripcion</option>";} ?>
                                </select>
                                <input type="text" class="hidden" name="tipo_recurso" value="HUMANO">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Producto:</label>
                                <?php  echo componente('articulos-salida','general/etapa/obtenerProductosSalida') ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Cantidad:</label>
                                <input type="number" name="cantidad" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Destino:</label>
                                <?php
                                  echo selectBusquedaAvanzada('productodestino', 'destino');
                                ?>
                            </div>
                        </div>
                    </div>
                </form>
                <button class="btn btn-success" style="float: right;" onclick="agregar()"><i class="fa fa-plus"></i> Agregar</button>
                <table id="tbl-reportes" class="table table-hover table-striped">
                    <thead>
                        <th>
                            Registro de reportes
                        </th>
                        <th>Destino</th>
                        <th width="5%"></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="FinalizarEtapa()">Guardar Reporte</button>
                <button type="button" class='btn btn-success' onclick='conf(btnFinalizar)'>Finalizar Etapa</button>
            </div>
        </div>
    </div>
</div>

<script>
$('#modal_finalizar').on('hidden.bs.modal',function(){
    $tblRep.empty();
    $('#frm-etapa').find('form-control').val('');
    $('.select2').trigger('change');
    s_batchId = false;
});

var unificar_lote = false;
// Genera Informe de Etapa
var FinalizarEtapa = function() {

    var productos = [];
    $tblRep.find('tr').each(function() {
        var json = getJson2(this);
        if (unificar_lote && unificar_lote == json.destino && this.dataset.forzar == 'false') {
            this.dataset.forzar = "true";
            unificar_lote = false;
        }
        json.forzar = this.dataset.forzar;
        productos.push(json);
    });

    productos = JSON.stringify(productos);
    cantidad_padre = '0';
    num_orden_prod = $('#num_orden_prod').val();
    batch_id_padre = $('#batch_id_padre').val();
    destino = $('#productodestino').val();

    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: false,
        data: {
            productos,
            cantidad_padre,
            num_orden_prod,
            destino,
            batch_id_padre
        },
        url: 'general/Etapa/Finalizar',
        success: function(rsp) {
            console.log(rsp);
            if (rsp.status) {
                $('#modal_finalizar').modal('hide');
                $('#mdl-unificacion').modal('hide');
                hecho('Se genero el Reporte de Producción correctamente.');
            } else {
                if (rsp.msj) {
                    unificar_lote = rsp.reci_id;
                    getContenidoRecipiente(unificar_lote);

                } else {
                    alert('Fallo al generar Reporte Producción');
                }
            }
        },
        complete: function() {
            wc();
        }
    });
}

var btnFinalizar = function() {
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'general/Etapa/finalizarLote',
        data: {
            batch_id: s_batchId
        },
        success: function(res) {
            if(res.status){
                $('#'+s_batchId).remove();
                hecho('Etapa finalizada exitosamente');
            }
        },
        error: function(res) {
            error();
        },
        complete: function() {
            wc();
        }
    });
}
</script>
