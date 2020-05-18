<?php

use \koolreport\widgets\koolphp\Table;
// use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\PieChart;
// use \koolreport\inputs\Select2;
use \koolreport\widgets\koolphp\Card;

?>





<body>

    <!--_________________BODY REPORTE___________________________-->

    <div id="reportContent" class="report-content">
        <div class="row">

            <div class="col-md-12">


                <div class="box box-solid">

                    <div class="box box-primary">

                        <div class="box-header">
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
                            <a href="#" data-toggle="control-sidebar" title="Filtros" id="panelFiltro">
                                <i class="fa fa-fw fa-filter fa-lg text-black pull-left"></i>
                            </a>
                        </div>

                        <div class="col-md-12"><br></div>

                        <!--_________________TABLA_________________-->

                        <div class="box-body">

                            <div class="col-md-12">

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


                                    <div class="box-header">
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





                                <!--_________________ CHARTS 2_________________-->


                                <div class="col-md-6">

                                    <div class="box-header">
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

                                <!--_________________ CHARTS 2_________________-->


                                <!-- <div class="col-md-6">

                                    <div class="box-header">
                                        <h3 class="box-title">
                                            <i class="fa fa-pie-chart"></i>
                                            TARGETAS
                                        </h3>
                                    </div> -->

                                <!--_________________ TARGET_________________-->

                                <!-- <div class="box-body">
                                        <div style="margin-bottom:50px;">
                                            <?php
                                            //Card::create(array(
                                            //     "value" => $this->dataStore('ejemplo'),
                                            //     "format" => array(
                                            //         "value" => array(
                                            //             "prefix" => "$%&"
                                            //         )
                                            //     ),
                                            //     "title" => "Cantidad",
                                            //     "cssClass" => array(
                                            //         "card" => "bg-primary",
                                            //         "title" => "text-white",
                                            //         "value" => "text-white"
                                            //     )
                                            // ));
                                            ?>
                                        </div>
                                    </div> -->
                                <!-- </div> -->
                            </div>

                            <!--_________________ FIN CHARTS_________________-->







                        </div>


                        <!--_________________ FIN BODY REPORTE ____________________________-->

                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script> -->

    <!-- <script>
        $('tr > td').each(function() {
            if ($(this).text() == 0) {
                $(this).text('-');
                $(this).css('text-align', 'center');
            }
            if ($(this).text()) {

            }
        });

        $('#panel-derecho-body').load('<?php //echo base_url() ?>index.php/Reportes/filtroProduccion');
        var id = $('.dataTable').getElementById();
        var table = DataTable($('.dataTable').getElementById());

        // var table = DataTable($('#DataTables_Table_1'))
        // var d = new Date();
        // var date = getFechaHoraFormateada(d);
        table = DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    className: 'btn btn-primary',
                    text: '<i class="fa fa-print"></i>',
                    title: function() {
                        return 'Reporte de Producción'
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-default')
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-primary',
                    text: '<i class="fa fa-download"></i> Excel',
                    title: function() {
                        return 'Reporte de Producción'
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-default')
                    },
                    filename: function() {
                        return ' reporte_produccion';
                    },
                }
            ],
            "columnDefs": [{
                "targets": [0],
                "type": "num",
            }],
            "order": [
                [0, "asc"]
            ],
        });
    </script> -->

    <!-- <script>
        DataTable($('.dataTable'))

        var d = new Date();
        var date = getFechaHoraFormateada(d);
        var table = $('.dataTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    className: 'btn btn-primary',
                    text: '<i class="fa fa-print"></i>',
                    title: function() {
                        return 'Reporte de Producción'
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-default')
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-primary',
                    text: '<i class="fa fa-download"></i> Excel',
                    title: function() {
                        return 'Reporte de Producción'
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-default')
                    },
                    filename: function() {
                        return date + ' reporte_produccion';
                    },
                }
            ],
            "columnDefs": [{
                "targets": [0],
                "type": "num",
            }],
            "order": [
                [0, "asc"]
            ],
        });
    </script> -->
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

    <script>
        DataTable($('.dataTable'))
    </script>
</body>