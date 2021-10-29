<?php

use \koolreport\widgets\koolphp\Table;
// use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\PieChart;
// use \koolreport\inputs\Select2;

?>

<!--_________________BODY REPORTE___________________________-->

<div id="reportContent" class="report-content">
    <div class="row">
        <div class="box box-solid">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-list"></i>
                        Reportes
                    </h3>
                </div>
                <br><br>
                <!--_________________FILTRO_________________-->
                <form id="frm-filtros">
                    <!-- DESDE -->
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label style="padding-left: 20%;">Desde</label>
                            <div class="input-group date">
                                <a class="input-group-addon" id="daterange-btn" title="Más fechas">
                                    <i class="fa fa-magic"></i>
                                    <span></span>
                                </a>
                                <input type="date" class="form-control pull-right" id="datepickerDesde" name="fec_desde" placeholder="Desde">
                            </div>
                        </div>
                    </div>
                    <!-- /DESDE -->

                    <!-- HASTA -->
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Hasta</label>
                            <input type="date" class="form-control" id="datepickerHasta" name="fec_hasta" placeholder="Hasta">
                        </div>
                    </div>
                    <!-- /HASTA -->

                    <!-- RESPONSABLE -->
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Responsable</label>
                            <select class="form-control" id="responsable" name="responsable">
                                <option value="" selected>Seleccione responsable</option>
                            </select>
                        </div>
                    </div>
                    <!-- /RESPONSABLE -->
                    
                    <!-- ETAPAS -->
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Etapas</label>
                            <select class="form-control" id="etapa" name="etapa">
                                <option value="" selected>Seleccione Etapas</option>
                            </select>
                        </div>
                    </div>
                    <!-- /ETAPAS -->

                    <!-- PRODUCTO -->
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-7">
                        <div class="form-group">
                            <label>Producto</label>
                            <select class="form-control" id="producto" name="producto">
                                <option value="" selected>Seleccione producto</option>
                            </select>
                        </div>
                    </div>
                    <!-- PRODUCTO -->

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                        <div style="float:right; padding-top: 24px" class="form-group">
                            <button type="button" class="btn btn-success btn-flat" onclick="filtrar()">Filtrar</button>
                            <button style="margin-left: 5px" type="button" class="btn btn-danger btn-flat flt-clear">Limpiar</button>
                            <input type="hidden" value="<?php echo $op ?>" id="op" hidden="true">
                        </div>
                    </div>
                </form>
                <div class="col-md-12">
                    <hr>
                </div>
                
                <!--_________________FILTRO_________________-->

                <!-- <div class="col-md-12">
                    <a href="#" data-toggle="control-sidebar" title="Filtros">
                        <i class="fa fa-fw fa-filter fa-lg text-black pull-left"></i>
                    </a>
                </div>

                <div class="col-md-12"><br></div> -->

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
                <!-- /.row -->

                <!--_________________ FIN BODY REPORTE ____________________________-->

            </div>
            <!-- /.box .box-primary -->
        </div>
        <!-- /.box .box-solid -->
    </div>
    <!-- /.row -->
</div>
<!-- /#reportContent -->
<script>
    filtroProdResponsable();
    fechaMagic();
    //Funcion de datatable para extencion de botones exportar
    //excel, pdf, copiado portapapeles e impresion
    $(document).ready(function() {
      $('.dataTable').DataTable({
        responsive: true,
        language: {
        url: '<?php base_url() ?>lib/bower_components/datatables.net/js/es-ar.json' //Ubicacion del archivo con el json del idioma.
        },
        dom: 'lBfrtip',
        buttons: [{
          //Botón para Excel
          extend: 'excel',
          exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
          },
          footer: true,
          title: 'Producción por recurso',
          filename: 'produccion_recurso',
          //Aquí es donde generas el botón personalizado
          text: '<button class="btn btn-success ml-2 mb-2 mb-2 mt-3">Exportar a Excel <i class="fa fa-file-excel-o"></i></button>'
        },
        // //Botón para PDF
        {
          extend: 'pdf',
          exportOptions: {
              columns: [0, 1, 2, 3, 4, 5]
          },
          footer: true,
          title: 'Producción por recurso',
          filename: 'produccion_recurso',
          text: '<button class="btn btn-danger ml-2 mb-2 mb-2 mt-3">Exportar a PDF <i class="fa fa-file-pdf-o mr-1"></i></button>'
        },
        {
          extend: 'copy',
          exportOptions: {
              columns: [0, 1, 2, 3, 4, 5]
          },
          footer: true,
          title: 'Producción por recurso',
          filename: 'produccion_recurso',
          text: '<button class="btn btn-primary ml-2 mb-2 mb-2 mt-3">Copiar <i class="fa fa-file-text-o mr-1"></i></button>'
        },
        {
          extend: 'print',
          exportOptions: {
              columns: [0, 1, 2, 3, 4, 5]
          },
          footer: true,
          title: 'Producción por recurso',
          filename: 'produccion_recurso',
          text: '<button class="btn btn-default ml-2 mb-2 mb-2 mt-3">Imprimir <i class="fa fa-print mr-1"></i></button>'
        }]
      });
    });

    $('tr > td').each(function() {
        if ($(this).text() == 0) {
            $(this).text('-');
            $(this).css('text-align', 'center');
        }
    });
    //Panel_Derecho.php mostraria los filtros
    // $('#panel-derecho-body').load('<?php echo base_url(PRD) ?>Reportes/filtroProdResponsable');

    // DataTable($('.dataTable'))

    $('.flt-clear').click(function() {
      $('#frm-filtros')[0].reset();
    });

    function fechaMagic() {
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#datepickerDesde').val(start.format('YYYY-MM-DD'));
          $('#datepickerHasta').val(end.format('YYYY-MM-DD'));
        }
      );
    }
    function filtroProdResponsable() {
      wo();
      $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "<?php echo base_url(PRD) ?>Reportes/filtroProdResponsable",
        success: function(rsp) {
          
          if (_isset(rsp.responsables)) {
            var opcResponsables = '';

            rsp.responsables.forEach(element => {
                opcResponsables += "<option value=" + element.nombre + ">" + element.nombre + "</option>";
            });

            $('#responsable').html(opcResponsables);
          }

          if (_isset(rsp.productos)) {
            var opcProductos = '';

            rsp.productos.forEach(element => {
                opcProductos += "<option value=" + element.id + ">" + element.nombre + "</option>";
            });
            $('#producto').html(opcProductos);

          }

          if (_isset(rsp.etapas)) {
            var opcEtapas = '';

            rsp.etapas.forEach(element => {
                opcEtapas += "<option value=" + element.nombre + ">" + element.nombre + "</option>";
            });

            $('#etapa').html(opcEtapas);
          }

        },
        error: function(rsp) {
          alert('Error tremendo');
        },
        complete: function() {
          wc();
        }
      })
    }
    </script>