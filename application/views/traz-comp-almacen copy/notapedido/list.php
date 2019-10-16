    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Pedido Materiales</h3>
            <?php
            if(!viewOT)
            {
            echo '<button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;"
                onclick="linkTo(\'<?php echo ALM ?>Notapedido/crearPedido\')">Agregar</button>';
            }else{
                echo '<button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;"
                onclick="AbrirModal()">Agregar</button>';
            }
            if(isset($descripcionOT))
            {
                echo '<input type="hidden" value="'.$descripcionOT.'" id="descripcionOT">';
            }
                ?>
        </div><!-- /.box-header -->
        <div class="box-body" id="deposito_contenedor">
            <table id="deposito" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Pedido</th>
                        <th class="<?php echo(!viewOT?"hidden":null)?>">Ord.Trabajo</th>
                        <th class="text-center">Fecha</th>
                        <th>Detalle</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            if($list) {
                                foreach($list as $z)
                                {
                                $id = $z['id_notaPedido'];
                                echo '<tr id="'.$id.'" class="'.$id.'" data-json=\''.json_encode($z).'\'>';
                                echo '<td class="text-center">';
                                echo '<i onclick="ver(this)" class="fa fa-fw fa-search text-light-blue buscar" style="cursor: pointer;margin:5px;" title="Detalle Pedido Materiales"></i>';
                                echo '</td>';           
                                echo '<td class="text-center">'.bolita($z['id_notaPedido'],'blue').'</td>';
                                echo '<td class="text-center '.(!viewOT?"hidden":null).'">'.bolita($z['id_ordTrabajo'],'yellow','Orden de Trabajo N°'.$z['id_ordTrabajo']).'</td>';
                               
                                echo '<td class="text-center">'.fecha($z['fecha']).'</td>';
                                echo '<td>'.(viewOT?$z['descripcion']:$z['justificacion']).'</td>';
                                echo '<td class="text-center">'.estadoPedido($z['estado']).'</td>';
                                echo '</tr>';
                                }
                            }
                            ?>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

<script>
  var tablaDetalle=$('#tabladetalle').DataTable({}); 
  function AbrirModal()
  {
    tablaDetalle2.clear().draw();
    document.getElementById('info').innerHTML="";
    document.getElementById('inputarti').value="";
    document.getElementById('add_cantidad').value="";
    $('#agregar_pedido').modal('show');
  }
function ver(e) {
    var tr = $(e).closest('tr')
    var id_nota = $(tr).attr('id');
    var json = JSON.parse(JSON.stringify($(tr).data('json')));
    rellenarCabecera(json);
    getEntregasPedidoOffline(id_nota);
    if (id_nota == null) {
        alert('PEMA_ID: '+id_nota);
        return;
    }
 
    $.ajax({
        type: 'GET',
        url: 'index.php/<?php echo ALM ?>Notapedido/getNotaPedidoId?id_nota='+id_nota,
        success: function(data) {
          
            tablaDetalle.clear().draw();
            for (var i = 0; i < data.length; i++) {
                var tr = "<tr style='color:'>" +
                    "<td>" + data[i]['barcode'] + "</td>" +
                    "<td>" + data[i]['artDescription'] + "</td>" +
                    "<td class='text-center' width='15%'><b>" + data[i]['cantidad'] + "</b></td>" +
                    "<td class='text-center' width='15%'><b>" + data[i]['entregado'] + "</b></td>" +
                    "</tr>";
                    tablaDetalle.row.add($(tr)).draw();
            }
            //DataTable('#tabladetalle');
            $('#detalle_pedido').modal('show');
        },
        error: function(result) {

            console.log(result);
        },
        dataType: 'json'
    });

}
function ConsultarEntrega(e)
{
    var tr = $(e).closest('tr');
    var id = $(tr).data('id');
    var json = JSON.parse(JSON.stringify($(tr).data('json')));
    rellenarCabecera(json);
    $.ajax({
        type: 'GET',
        url: 'index.php/<?php echo ALM ?>new/Entrega_Material/detalle?id='+id,
        success: function(result) {
            var tabla = $('#modal_detalle_entrega table');
    
            $(tabla).find('tbody').html('');
            result.forEach(e => {
                $(tabla).append(
                    '<tr>' +
                    '<td>' + e.barcode + '</td>' +
                    '<td>' + e.descripcion + '</td>' +
                    '<td>' + e.lote + '</td>' +
                    '<td>' + e.deposito + '</td>' +
                    '<td class="text-center">' + e.cantidad + '</td>' +
                    '</tr>'
                );
            });
         
            $('#modal_detalle_entrega').modal('show');
           
        },
        error: function(result) {
            alert('Error');
        },
        dataType: 'json'
    });
}
function EstadoPedido(e)
 {

    var id = $(e).closest('tr').data('pema');
    if (id == '' || id == null) return;
    $.ajax({
        type: 'GET',
        url: 'index.php/<?php echo ALM ?>new/Pedido_Material/estado?id='+id,
        success: function(result) {
            var tabla = $('#tablapedido');
            $(tabla).DataTable().destroy();
            $(tabla).find('tbody').html('');
            result.forEach(e => {
                $(tabla).append(
                    '<tr>' +
                    '<td>' + e.barcode + '</td>' +
                    '<td class="text-center"><b>' + e.cantidad + '</b></td>' +
                    '<td class="text-center"><b>' + (e.cantidad - e.resto) +
                    '</b></td>' +
                    '<td class="text-center"><i class="fa '+
                    (e.resto == 0?'fa-battery-full':(e.resto < e.cantidad?'fa-battery-2':(e.resto == e.cantidad?'fa-battery-0':'')))+
                    '"></i></td>'+
                    '</tr>'
                );
            });

            $('#detalle_pedido2').modal('show');
        },
        error: function(result) {
            alert('Error');
        },
        dataType: 'json'
    });
    DataTable('#tablapedido');
 }
function getEntregasPedidoOffline(pema) {
    $.ajax({
        type: 'GET',
        url: 'index.php/<?php echo ALM ?>new/Entrega_Material/getEntregasPedidoOffline?pema='+pema,
        success: function(data) {
         
          document.getElementById('tab_2').innerHTML =data;
          DataTable('#entregas');
        }
    });
}
//Ver Orden
function rellenarCabecera(json) {
    $('#detalle_pedido .pedido').val(json.id_notaPedido);
    $('#detalle_pedido .descrip').val(json.justificacion);
    $('#detalle_pedido .fecha').val(json.fecha);
    $('#detalle_pedido .estado').val(json.estado);
    $('#detalle_pedido .orden').val(json.id_ordTrabajo);
}


var tablaDeposito = $('#deposito').DataTable({});
</script>

<!-- Modal Agregar -->
<div class="modal fade" id="agregar_pedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
            </div> <!-- /.modal-header  -->
             <div class="modal-body table-responsive" id="modalBodyArticle">
                <?php 
                
                $this->load->view(ALM.'notapedido/generar_pedido');?>
            </div> <!-- /.modal-body -->
                        
                    </div> <!-- /.modal-content -->
                </div>
    </div> <!-- /.modal-dialog modal-lg -->
<!-- Fin Modal Agregar -->
<!-- Modal ver nota pedido-->
<div class="modal fade" id="detalle_pedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" >
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">
                        <h4><span class="fa fa-search text-light-blue"></span> Detalle Pedido Material</h4>
                    </a></li>
                <li><a href="#tab_2" data-toggle="tab">
                        <h4><span class="fa fa-check text-light-blue"></span>Entrega Asociadas al Pedido</h4>
                    </a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="modal-content">

                        <div class="modal-header">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-lg-3">
                                    <label for="">Pedido:</label>
                                    <input class="form-control pedido" type="text" value="???" readonly>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-lg-3 <?php echo (!viewOT ? "hidden" : null) ?>">
                                    <label for="">Orden de Trabajo:</label>
                                    <input class="form-control orden" type="text" value="???" readonly>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-lg-3">
                                    <label for="">Fecha:</label>
                                    <input class="form-control fecha" type="text" value="???" readonly>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-lg-3">
                                    <label for="">Estado:</label>
                                    <input class="form-control estado" type="text" value="???" readonly>
                                </div><br>
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                    <label for="">Descripcion:</label>
                                    <input class="form-control descrip" type="text" value="???" readonly>
                                </div>
                            </div>

                        </div> <!-- /.modal-header  -->

                        <div class="modal-body table-responsive" id="modalBodyArticle">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="tabladetalle" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod. Artículo</th>
                                                <th>Descripción</th>
                                                <th class="text-center">Pedido</th>
                                                <th class="text-center">Entregado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- /.modal-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div> <!-- /.modal footer -->

                    </div> <!-- /.modal-content -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">

                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>

    </div> <!-- /.modal-dialog modal-lg -->
</div> <!-- /.modal fade -->
<!-- / Modal -->