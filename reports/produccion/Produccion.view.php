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
            <div class="box-header with-border">
              <h3 class="box-title">
                Reporte de Producción
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
                            <input type="date" class="form-control pull-right" id="datepickerDesde" name="datepickerDesde" placeholder="Desde">
                        </div>
                    </div>
                </div>
                <!-- /DESDE -->

                <!-- HASTA -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                    <div class="form-group">
                        <label>Hasta</label>
                        <input type="date" class="form-control" id="datepickerHasta" name="datepickerHasta" placeholder="Hasta">
                    </div>
                </div>
                <!-- /HASTA -->
                
                <!-- ETAPAS -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                    <div class="form-group">
                        <label>Etapas</label>
                        <select class="form-control" id="etapa" name="etapa">
                        </select>
                    </div>
                </div>
                <!-- /ETAPAS -->

                <!-- PRODUCTO -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-7">
                    <div class="form-group">
                        <label>Producto</label>
                        <select class="form-control select2" id="producto" name="producto">
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
                    array(
                      "label" => "Fecha",
                      "value" => function($row) {
                        $aux = explode("+",$row["fecha"]);
                        $row["fecha"] = date("d-m-Y",strtotime($aux[0]));
                        return $row["fecha"];
                      },
                      "type" => "date"
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
                    "responsable" => array(
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
  <script>
    filtroProduccion();
    fechaMagic();
    //Funcion de datatable para extencion de botones exportar
    //excel, pdf, copiado portapapeles e impresion
    $(document).ready(function() {
      $('.select2').select2();
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
          title: 'Asignación de recursos',
          filename: 'asignacion_recursos',
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
          title: 'Asignación de recursos',
          filename: 'asignacion_recursos',
          text: '<button class="btn btn-danger ml-2 mb-2 mb-2 mt-3">Exportar a PDF <i class="fa fa-file-pdf-o mr-1"></i></button>'
        },
        {
          extend: 'copy',
          exportOptions: {
              columns: [0, 1, 2, 3, 4, 5]
          },
          footer: true,
          title: 'Asignación de recursos',
          filename: 'asignacion_recursos',
          text: '<button class="btn btn-primary ml-2 mb-2 mb-2 mt-3">Copiar <i class="fa fa-file-text-o mr-1"></i></button>'
        },
        {
          extend: 'print',
          exportOptions: {
              columns: [0, 1, 2, 3, 4, 5]
          },
          footer: true,
          title: 'Asignación de recursos',
          filename: 'asignacion_recursos',
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
    
    // $('#panel-derecho-body').load('<?php echo base_url() ?>index.php/Reportes/filtroProduccion');

    $('.flt-clear').click(function() {
      $('#frm-filtros')[0].reset();
      $('#producto').val(null).trigger('change');
    });

    function filtrar() {
      var data = new FormData($('#frm-filtros')[0]);
      data = formToObject(data);
      wo();
      var url = 'produccion';
      $.ajax({
        type: 'POST',

        data: {
          data
        },
        url: '<?php echo base_url(PRD) ?>Reportes/' + url,
        success: function(result) {
          $('#reportContent').empty();
          $('#reportContent').html(result);
        },
        error: function() {
          alert('Error');
        },
        complete: function(result) {
          wc();
        }
      });
    }

    function filtroProduccion() {
      wo();
      $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "<?php echo base_url(PRD) ?>Reportes/filtroProduccion",
        success: function(rsp) {

          if (_isset(rsp.articulos)) {
            var opcArticulos = '<option value="" selected>TODOS</option>';

            rsp.articulos.forEach(element => {
                opcArticulos += "<option value=" + element.arti_id + ">" + element.descripcion + "</option>";
            });
            $('#producto').html(opcArticulos);

          }

          if (_isset(rsp.etapas)) {
            var opcEtapas = '<option value="" selected>TODOS</option>';

            rsp.etapas.forEach(element => {
                opcEtapas += "<option value=" + element.id + ">" + element.titulo + "</option>";
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
</body>
