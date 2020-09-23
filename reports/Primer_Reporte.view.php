<?php

use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;

use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\PieChart;

?>
<!-- <!DOCTYPE html>
<html lang="en"> -->

<!-- <head> -->
<!-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
<!-- <title>KooleReport Trazasoft</title> -->

<style>
    .cssHeader {
        background-color: #82E0AA;
        text-align: center !important;
        /* font-size: 1.2em; */
    }

    .cssItem {
        background-color: #F9E79F;
    }

    .centrar {
        text-align: center;
        /* font-size: 1.5em; */
    }

    /* .cssFooter {
        font-size: 1.2em;
    } */
</style>
<!-- </head> -->

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="report-content">
                    <div>
                        <!-- <button href="#" data-toggle="control-sidebar"><i class="fa fa-filter"></i>Filtros</button> -->
                        <a href="#" data-toggle="control-sidebar" title="Filtros">
                            <i class="fa fa-fw fa-filter fa-lg text-black"></i>
                        </a>
                        <!-- <button class="btn btn-link" onclick="openPanel()" title="Filtrar">
                            <i class="fa fa-fw fa-filter fa-lg text-black"></i>
                        </button> -->
                    </div>

                    <?php
                    Table::create(array(
                        "dataStore" => $this->dataStore('primer_reporte'),
                        // "themeBase" => "bs4",
                        // "showFooter" => true, // cambiar true por "top" para ubicarlo en la parte superior
                        // "headers" => array(
                        //     array(
                        //         "Materias" => array("colSpan" => 11, "class" => "centrar"),
                        //         // "Other Information" => array("colSpan" => 2),
                        //     )
                        // ), // Para desactivar encabezado reemplazar "headers" por "showHeader"=>false
                        "columns" => array(
                            "titulo" => array(
                                "label" => "Título"
                            ),
                            // "id" => array(
                            //     "label" => "ID"
                            // ),
                            // "descripcion" => array(
                            //     "label" => "Descripción"
                            // ),                            
                            // "es_loteado" => array(
                            //     "label" => "Es loteado"
                            // ),
                            "unidad_medida" => array(
                                "label" => "Unidad Medida"
                            ),
                            "estado" => array(
                                "label" => "Estado"
                            ),
                            // "costo" => array(
                            //     "label" => "Costo"
                            // ),                            
                            // "cantidad_caja" => array(
                            //     "label" => "Cantidad Caja"
                            // ),
                            "stock" => array(
                                "label" => "Stock"
                            ),
                            // "barcode" => array(
                            //     "label" => "Barcode"
                            // ),
                            // "punto_pedido" => array(
                            //     "label" => "Punto Pedido"
                            // )
                        ),
                        "cssClass" => array(
                            "table" => "table-bordered table-striped table-hover dataTable",
                            "th" => "sorting"
                            // "tr" => "cssItem"
                            // "tf" => "cssFooter"
                        )
                    ));
                    ?>
                    <div style="margin-bottom:50px;">
                        <?php
                        PieChart::create(array(
                            "title" => "Materias",
                            "dataStore" => $this->dataStore('grafico_torta'),
                            "columns" => array(
                                "titulo",
                                "stock" => array(
                                    "type" => "number",
                                )
                            ),
                            "colorScheme" => array(
                                "#2f4454",
                                "#2e1518",
                                "#da7b93",
                                "#376e6f",
                                "#1c3334"
                            )
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
    <script>
        $('#panel-derecho-body').load('<?php echo base_url() ?>index.php/Reportes/panelFiltroEjemplo');
    </script>
</body>

<!-- </html> -->