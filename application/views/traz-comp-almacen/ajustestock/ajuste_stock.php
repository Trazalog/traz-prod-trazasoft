<?php 
    $this->load->view(ALM.'ajustestock/componentes/cabecera');
?>

<div class="row">
    <div class="col-md-6">
        <?php 
            $this->load->view(ALM.'ajustestock/componentes/entrada');
        ?>
    </div>
    <div class="col-md-6">
        <?php
        $this->load->view(ALM.'ajustestock/componentes/salida');
        ?>
    </div>
</div>

<?php 
    $this->load->view(ALM.'ajustestock/componentes/justificacion');
?>