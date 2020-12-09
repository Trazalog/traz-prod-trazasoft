<?php

use \koolreport\widgets\koolphp\Table;
// use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\PieChart;
// use \koolreport\inputs\Select2;

?>

<body>
    <!--_________________BODY REPORTE___________________________-->

    <div id="reportContent" class="report-content">
        <div class="row">

            <div class="col-md-12">


                <div class="box box-solid">

                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-list"></i>

                                Reportes
                            </h3>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <!--_________________FILTRO_________________-->

                        <div class="col-md-12">
                            <a href="#" data-toggle="control-sidebar" title="Filtros">
                                <i class="fa fa-fw fa-filter fa-lg text-black pull-left"></i>
                            </a>
                        </div>

                        <div class="col-md-12"><br></div>

                        <!--_________________TABLA_________________-->

                        <div class="box-body">

                            <div class="col-md-12">

                                <?php
                                Table::create(array(
                                    "dataStore" => $this->dataStore('data_prodResponsable_table'),
                                    // "themeBase" => "bs4",
                                    // "showFooter" => true, // cambiar true por "top" para ubicarlo en la parte superior
                                    "headers" => array(
                                        array(
                                            "Reporte de Producción por Recurso" => array("colSpan" => 6),
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
                                        "table" => "table-striped table-scroll table-hover  table-responsive dataTables_wrapper form-inline table-scroll table-responsive dt-bootstrap dataTable",
                                        "th" => "sorting"
                                        // "tr" => "cssItem"
                                        // "tf" => "cssFooter"
                                    )
                                ));
                                ?>

                            </div>
                        </div>

                        <!--_________________FIN TABLA_________________-->


                        <div class="col-md-12">
                            <br>
                            <div class="box box-primary">
                            </div>
                        </div>

                        <!--_________________ CHARTS_________________-->

                        <div class="row">
                            <div class="col-md-12">

                                <!--_________________ CHARTS 1_________________-->
                                <div class="col-md-6">


                                    <div class="box-header with-border">
                                        <h3 class="box-title center">
                                            <i class="fa fa-pie-chart"></i>
                                            Cantidad de productos
                                        </h3>
                                    </div>

                                    <!--_________________ BODY CHART 1_________________-->

                                    <div class="box-body">
                                        <div style="margin-bottom:50px;">
                                            <?php
                                            PieChart::create(array(
                                                // "title" => "Cantidad de productos",
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





                                <!--_________________ CHARTS 2_________________-->


                                <div class="col-md-6">

                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            <i class="fa fa-pie-chart"></i>
                                            Productos con mayor cantidad
                                        </h3>
                                    </div>

                                    <!--_________________ BODY CHART 2_________________-->

                                    <div class="box-body">
                                        <div style="margin-bottom:50px;">
                                            <?php
                                            ColumnChart::create(array(
                                                // "title" => "Productos con mayor cantidad",
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

                            <!--_________________ FIN CHARTS_________________-->







                        </div>


                        <!--_________________ FIN BODY REPORTE ____________________________-->

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

        DataTable($('.dataTable'))
    </script>
</body>