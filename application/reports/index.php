<?php 

require_once "PrimerReporte.php";
$primerreporte = new PrimerReporte;
$primerreporte->run()->render();