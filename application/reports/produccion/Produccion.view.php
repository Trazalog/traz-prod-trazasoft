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
                            "dataStore" => $this->dataStore('data_produccion_table'),
                            // "themeBase" => "bs4",
                            // "showFooter" => true, // cambiar true por "top" para ubicarlo en la parte superior
                            "headers" => array(
                                array(
                                    "Reporte de Producción" => array("colSpan" => 6),
                                    // "Other Information" => array("colSpan" => 2),
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
                                // "table" => "table-bordered table-striped table-hover dataTable",
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
                                        "dataStore" => $this->dataStore('data_produccion_pieChart'),
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
                                        "dataStore" => $this->dataStore('data_produccion_pieChart'),
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
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->

    <script>
        // $('.report-content').click(function() {
        //     $('#formulario')[0].reset();
        // });

        $('tr > td').each(function() {
            if ($(this).text() == 0) {
                $(this).text('-');
                $(this).css('text-align', 'center');
            }
        });

        $('#panel-derecho-body').load('<?php echo base_url() ?>index.php/Reportes/filtroProduccion');
    </script>
</body>