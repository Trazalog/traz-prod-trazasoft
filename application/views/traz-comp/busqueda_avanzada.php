<div class="input-group">
     <input list="articulos" id="inputarti" class="form-control" placeholder="Seleccionar Articulo"
         onchange="getItem(this)" autocomplete="off">
     <datalist id="articulos">
         <?php foreach($items as $o)
           {
             echo  "<option value='".$o->codigo."' data-json='".$o->json."'>".$o->descripcion." | Stock: ".$o->stock."</option>";
             unset($o->json);
            }
            ?>
     </datalist>
     <span class="input-group-btn">
         <button class='btn btn-primary' data-toggle="modal" data-target="#modal_articulos">
             <i class="glyphicon glyphicon-search"></i></button>
     </span>
 </div>
 <br>
 <label id="info" class="text-blue"></label>


 <div class="modal" id="modal_articulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                         aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Listado de Articulos</h4>
             </div>

             <div class="modal-body" id="modalBodyArticle">
    
                     <div class="table-responsive" id="modalarticulos">

                   
                 </div>
             </div>

             <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
             </div>
         </div>
     </div>
 </div>



 <script>
checkTabla("tabla_articulos", "modalarticulos", `<?php echo json_encode($items);?>`, "Add");

function checkTabla(idtabla, idrecipiente, json, acciones) {
    lenguaje = <?php echo json_encode($lang)?>;
    if (document.getElementById(idtabla) == null) {
        armaTabla(idtabla, idrecipiente, json, lenguaje, acciones);
    }

    $('#modal_articulos').on('shown.bs.modal', function() {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

}

var selectItem = null;
$(document).off('click', '.tabla_articulos_nuevo').on('click', '.tabla_articulos_nuevo', function() {
    $('#modal_articulos').modal('hide');
    var item = $(this).closest('tr').data('json')[0];
    $('#inputarti').val(item.Codigo);
    var option = $('#articulos').find("[value='" + item.Codigo + "']");
    $('label#info').html($(option).html());
    var json = JSON.stringify($(option).data('json'));
    selectItem = JSON.parse(json);
    if(existFunction('eventSelect'))eventSelect();
});


function getItem(item) {
    if (item == null) return;
    var option = $('#articulos').find("[value='" + item.value + "']");
    var json = JSON.stringify($(option).data('json'));
    selectItem = JSON.parse(json);
    $('label#info').html($(option).html());
    if(existFunction('eventSelect'))eventSelect();
}

function clearSelect(){
    $('#inputarti').val(null);
}
 </script>