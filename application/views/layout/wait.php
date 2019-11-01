<!-- indicador de carga -->
<div class="waiting" id="waiting">
    <div style="top: 45%; left: 45%; position: fixed;">
        <!--<div class="progress progress active">
            <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
        </div>-->
        <div class="box box-success" style="width: 200px; text-align: center;">
            <br>
            <br>
            <br>
            <div class="box-header">
                <h3 class="box-title" id="waitingText">Cargando...</h3>
            </div>
            <!-- Loading (remove the following to stop the loading)-->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- end loading -->
        </div>
    </div>
</div>

<style>
.waiting {
    background: none;
    display: block;
    position: fixed;
    z-index: 50000;
    overflow: auto;
    bottom: 0;
    left: 0;
    right: 0;
    top: 0;
    display: none;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
    /* AA, RR, GG, BB */
    /*CSS3*/
    background: rgba(0, 0, 0, 0.5);
    /*0.5 De Transparencia*/
}
</style>

<script>
function wo(texto) {
    if (texto == '' || texto == null) {
        $('#waitingText').html('Cargando ...');
    } else {
        $('#waitingText').html(texto);
    }
    $('#waiting').fadeIn('slow');
}
/* Cierra cuadro cargando ajax */
function wc() {
    $('#waiting').fadeOut('slow');
}
</script>