<?php

use \koolreport\widgets\koolphp\Table;
// use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\PieChart;
// use \koolreport\inputs\Select2;

?>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div id="reportContent" class="report-content">
                    <div>
                        <a href="#" data-toggle="control-sidebar" title="Filtros">
                            <i class="fa fa-fw fa-filter fa-lg text-black"></i>
                        </a>
                    </div>
                    <div class="box-body">
                        <?php
                        Table::create(array(
                            "dataStore" => $this->dataStore('data_prodResponsable_table'),
                            "headers" => array(
                                array(
                                    "Reporte de Producción por Recurso" => array("colSpan" => 6),
                                )
                            ), // Para desactivar encabezado reemplazar "headers" por "showHeader"=>false
                            "columns" => array(
                                "fecha" => array(
                                    "label" => "Fecha"
                                ),
                                "producto" => array(
                                    "label" => "Producto"
                                ),
                                "cantidad" => array(
                                    "label" => "Cantidad"
                                ),
                                "unidad_medida" => array(
                                    "label" => "Unidad Medida"
                                ),
                                "etapa" => array(
                                    "label" => "Etapa"
                                ),
                                "recurso" => array(
                                    "label" => "Responsable"
                                )
                            ),
                            "cssClass" => array(
                                "table" => "table-striped table-hover dataTables_wrapper form-inline dt-bootstrap"
                                // "th" => "sorting"
                                // "tr" => "cssItem"
                                // "tf" => "cssFooter"
                            )
                        ));
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-body">
                                <div style="margin-bottom:50px;">
                                    <?php
                                    PieChart::create(array(
                                        "title" => "Cantidad de productos",
                                        "dataStore" => $this->dataStore('data_prodResponsable_pieChart'),
                                        "columns" => array(
                                            "producto",
                                            "cantidad" => array(
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
                        <div class="col-md-6">
                            <div class="box-body">
                                <div style="margin-bottom:50px;">
                                    <?php
                                    ColumnChart::create(array(
                                        "title" => "Productos con mayor cantidad",
                                        "dataStore" => $this->dataStore('data_prodResponsable_pieChart'),
                                        "columns" => array(
                                            "producto",
                                            "cantidad" => array(
                                                "type" => "number",
                                                "label" => "Cantidad"
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
            </div>
        </div>
    </div>

    <script>
        $('tr > td').each(function() {
            if ($(this).text() == 0) {
                $(this).text('-');
                $(this).css('text-align', 'center');
            }
        });

        $('#panel-derecho-body').load('<?php echo base_url() ?>index.php/Reportes/filtroProdResponsable');
    </script>
</body>