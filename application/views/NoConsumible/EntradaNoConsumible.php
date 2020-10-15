<div class="box box-primary tag-descarga">
<div class="box-header with-border">
<div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" id="minimizar_vale_entrada" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
        <i class="fa fa-times"></i></button>
    </div>
<h4 class="box-title">Vale de Entrada</h4>
    </div>
    <div class="box-body" id="div_vale_entrada">
    <form action="">
    <label for="consumible" class="col-md-1">Consumible:</label>
    <div class="col-md-1">
    <input id="consumible" name="consumible" type="text" placeholder="" class="form-control input-md">
    </div>
    <label for="destino" class="col-md-1">Deposito:</label>
    <div class="col-md-2">
    <input id="destino" name="destino" type="text" placeholder="Ingrese depoito" class="form-control input-md">
    </div>
    <div class="col-md-1">
     <button class="btn btn-primary" style="margin-top:23px; float:right;"><i class="fa fa-plus"></i></button>
    </div>  
    </form>

        <table class="table table-striped table-hover">
        <br><br>
            <thead>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Fecha de Salida</th>
                <th>deposito</th>
            </thead>
            <tbody id="">

            </tbody>
        </table>
        <hr>
        <button id="guardarEstado" class="btn btn-primary btn-sm" style="float:right"
            onclick="guardarEstado()" ></i>Guardar</button>
        <button id="guardarEstado" class="btn btn-primary btn-sm" style="float:right"
            onclick="imprimirEstado()" ><i class="fa fa-print"> </i> Imprimir</button>
       
    </div>
</div>

<script>
// var fila = null;

// function agregarFila(data) {

//     var lote_origen = $('#new_codigo').hasClass('hidden')?$('#codigo').select2('data')[0].text:$('#new_codigo').val();

//     $('#lotes').append(
//         `<tr data-json='${JSON.stringify(data)}' class='${loteSistema?'lote-sistema':'lote'}'>
//             <td class="text-center"><i class="fa fa-times text-danger" onclick="fila = $(this).closest('tr'); $('#eliminar_fila').modal('show');"></i></td>
//             <td>${lote_origen}</td>
//             <td>${$('.frm-destino #art-detalle').val()}</td>
//             <td>${data.destino.cantidad + ' | ' + data.destino.unidad_medida}</td>
//             <td>${data.destino.lote_id}</td>
//             <td>${loteSistema?'<i class="fa fa-barcode text-blue" title="Lote Trazable"></i>':''}</td>
//         </tr>`
//     );

//     $('#guardarDescarga').attr('disabled', false);
// }

// function guardarDescargaOrigen() {

//      //Guardar Datos de Camión parametro = FALSE es para NO mostrar el MSJ de Datos Guardados
//     if($('#lotes tr').length != 0) addCamion(false);

//     var array = [];
//     $('#lotes tr.lote').each(function() {
//         array.push(JSON.parse(this.dataset.json));
//     });

//     if(array.length == 0) return;


//     $.ajax({
//         type: 'POST',
//         dataType: 'JSON',
//         url: 'index.php/general/Camion/guardarDescarga',
//         data: {
//             array
//         },
//         success: function(rsp) {
//             if(rsp.status){
//               alert('Hecho');
//               linkTo();
//             }else{
//                 alert('Falla al Guardar Descarga');
//             }
//         },
//         error: function(rsp) {
//             alert('Error: ' + rsp.msj);
//             console.log(rsp.msj);
//         }
//     });
// }

// function guardarLoteSistema(){
    
//     var frmCamion = obtenerFormularioCamion();

//     var array = [];
//     $('#lotes tr.lote-sistema').each(function() {
//         const e = JSON.parse(this.dataset.json);
//         e.loteSistema = loteSistemaData;
//         array.push(e);
//     });
    
//     if (array.length == 0) return;
  
//     wo();
//     $.ajax({
//         type: 'POST',
//         dataType: 'JSON',
//         url: 'index.php/general/Camion/guardarLoteSistema',
//         data: {
//             array,
//             frmCamion
//         },
//         success: function(rsp) {
//             if(rsp.status == true){
//               alert('Hecho');
//               linkTo();
//             }else{
//                 alert('Falla al Guardar Lotes Sistema');
//             }
//         },
//         error: function(rsp) {
//             alert('Error: ' + rsp.msj);
//             console.log(rsp.msj);
//         },
//         complete:function(){
//             wc();
//         }
//     });

// }

// function eliminarFila() {
//     var json = getJson($(fila));
//     if (!json) return;
//     $('.frm-origen #cantidad').val(parseFloat($('.frm-origen #cantidad').val()) + parseFloat(json.destino.cantidad));
//     $(fila).remove();

//     $('#guardarDescarga').attr('disabled', $('#lotes tr').length == 0);
// }

$("#consumible").autocomplete({
			source: "autocompleta_denunciante.php",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				$('#consumible').val(ui.item.dni);
			
			 }
		});


</script>

<div class="modal fade" id="eliminar_fila" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center">¿Desea Eliminar Registro?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="eliminarFila()">Si</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>