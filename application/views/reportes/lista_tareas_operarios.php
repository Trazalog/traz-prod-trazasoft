<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title">Tareas Operario</h2>
    </div>
    <div class="box-body">
        <table class="table table-responsibe">
            <tbody>
                <?php  foreach ($list as $key => $value) {
                    echo "<button class='btn btn-primary btn-block btn-lg' style='background-color:#FF9900;color:#000000' onclick='reporte($value->id)'>Lote: $value->lote | Orden: $value->orden | Est: $value->establecimiento</button>";
                }?>
            </tbody>
        </table>
    </div>
</div>

<script>
function reporte(id){
    
    linkTo('general/Reporte/crearReporte/'+id);
}
</script>