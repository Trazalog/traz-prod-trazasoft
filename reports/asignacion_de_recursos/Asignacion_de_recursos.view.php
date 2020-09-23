<?php

use \koolreport\widgets\koolphp\Table;
// use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
// use \koolreport\widgets\google\PieChart;
// use \koolreport\inputs\Select2;
// use \koolreport\widgets\koolphp\Card;
?>

<body>
  <!--_________________BODY REPORTE___________________________-->
  <div id="reportContent" class="report-content">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-solid">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">
                Reporte de Asignación de recursos
              </h3>
            </div>
            <br><br>
            <!--_________________FILTRO_________________-->
            <form id="frm-filtros">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> -->
                  <!-- <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6"> -->
                  <!-- <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label style="padding-left: 20%;">Desde</label>
                    <div class="input-group date">
                      <a class="input-group-addon" id="daterange-btn" title="Más fechas">
                        <i class="fa fa-magic"></i>
                        <span></span>
                      </a>
                      <input type="date" class="form-control pull-right" id="datepickerDesde" name="datepickerDesde" placeholder="Desde">
                    </div>
                  </div> -->
                  <!-- /.form-group -->
                  <!-- <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6"> -->
                  <!-- <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Hasta</label>
                    <div class="input-group">
                      <input type="date" class="form-control" id="datepickerHasta" name="datepickerHasta" placeholder="Hasta">
                      <a class="input-group-addon" style="cursor: pointer;" onclick="filtro()" title="Más filtros">
                        <i class="fa fa-filter"></i>
                      </a>
                    </div>
                  </div> -->
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Lote</label>
                    <select class="form-control" id="lote_id" name="lote_id">
                    </select>
                  </div>
                  <div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <label class="col-lg-12">&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-flat flt-clear col-lg-6">Limpiar</button>
                    <button type="button" class="btn btn-success btn-flat col-lg-6" onclick="filtrar()">Filtrar</button>
                    <input type="hidden" value="<?php echo $op ?>" id="op" hidden="true">
                  </div>
                </div>
              </div>
              <br>
            </form>
            <!-- <br> -->
            <hr>
            <!--_________________TABLA_________________-->
            <div class="box-body">
              <div class="col-md-12">
                <?php
                Table::create(array(
                  "dataStore" => $this->dataStore('data_asignacion_recurso_table'),
                  // "themeBase" => "bs4",
                  // "showFooter" => true, // cambiar true por "top" para ubicarlo en la parte superior
                  // "headers" => array(
                  //   array(
                  //     "Reporte de Producción" => array("colSpan" => 6),
                  //     // "Other Information" => array("colSpan" => 2),
                  //   )
                  // ), // Para desactivar encabezado reemplazar "headers" por "showHeader"=>false
                  // "showHeader" => false,
                  "columns" => array(
                    "fecha" => array(
                      "label" => "Fecha"
                    ),
                    "tarea" => array(
                      "label" => "Tarea"
                    ),
                    "articulo" => array(
                      "label" => "Artículo"
                    ),
                    "cantidad" => array(
                      "label" => "Cantidad"
                    ),
                    "unidad_medida" => array(
                      "label" => "UM"
                    ),
                    "tipo" => array(
                      "label" => "Tipo"
                    )
                  ),
                  "cssClass" => array(
                    "table" => "table-scroll table-responsive dataTables_wrapper form-inline dt-bootstrap dataTable table table-bordered table-striped table-hover display",
                    "th" => "sorting"
                  )
                ));
                ?>
              </div>
            </div>
            <!--_________________FIN TABLA_________________-->
            <!-- <div class="col-md-12">
              <br>
              <div class="box box-primary">
              </div>
            </div> -->
            <!--_________________ CHARTS_________________-->
            <!-- <div class="row">
              <div class="col-md-12">
                <!--_________________ CHARTS 1_________________-->
            <!-- <div class="col-md-6">
              <div class="box-header">
                <h3 class="box-title center">
                  <i class="fa fa-pie-chart"></i>
                  Cantidad de ingresos
                </h3>
              </div>
              <!--_________________ BODY CHART 1_________________-->
            <!-- <div class="box-body">
              <div style="margin-bottom:50px;">
                <?php
                // ColumnChart::create(array(
                //   // "title" => "Productos con mayor cantidad",
                //   "dataStore" => $this->dataStore('data_asignacion_recurso_clumnChart'),
                //   "columns" => array(
                //     "nombre" => array(
                //       "label" => "Proveedor"
                //     ),
                //     "cantidad" => array(
                //       "type" => "number",
                //       "label" => "Cantidad"
                //     )
                //   ),
                //   "colorScheme" => array(
                //     "#2f4454",
                //     "#2e1518",
                //     "#da7b93",
                //     "#376e6f",
                //     "#1c3334"
                //   )
                // ));
                ?>
              </div>
            </div>
          </div> -->
            <!--_________________ CHARTS 2_________________-->
            <!-- <div class="col-md-6">
              <div class="box-header">
                <h3 class="box-title">
                  <i class="fa fa-pie-chart"></i>
                  Productos con mayor cantidad
                </h3>
              </div>
              <!--_________________ BODY CHART 2_________________-->
            <!-- <div class="box-body">
            <div style="margin-bottom:50px;">
              <?php
              // ColumnChart::create(array(
              //   // "title" => "Productos con mayor cantidad",
              //   "dataStore" => $this->dataStore('data_asignacion_recurso_pieChart'),
              //   "columns" => array(
              //     "producto",
              //     "cantidad" => array(
              //       "type" => "number",
              //       "label" => "Cantidad"
              //     )
              //   ),
              //   "colorScheme" => array(
              //     "#2f4454",
              //     "#2e1518",
              //     "#da7b93",
              //     "#376e6f",
              //     "#1c3334"
              //   )
              // ));
              ?>
            </div>
          </div> -->
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
                                    </div>
        <!-- </div> -->
        </div>
        <!--_________________ FIN CHARTS_________________-->
      </div>
      <!--_________________ FIN BODY REPORTE ____________________________-->
    </div>
  </div>
  </div>
  <script>
    filtroAsignacionDeRecursos();
    // fechaMagic();

    $('tr > td').each(function() {
      if ($(this).text() == 0) {
        $(this).text('-');
        $(this).css('text-align', 'center');
      }
    });

    // DataTable($('.dataTable'));
    $('.dataTable').dataTable();

    function filtrar() {
      var data = new FormData($('#frm-filtros')[0]);
      data = formToObject(data);
      wo();
      var url = 'asignacionDeRecursos';
      $.ajax({
        type: 'POST',
        data: {
          data
        },
        url: 'Reportes/' + url,
        success: function(result) {
          $('#reportContent').empty();
          $('#reportContent').html(result);
        },
        error: function() {
          alert('Error tremendo');
        },
        complete: function(result) {
          wc();
        }
      });
    }

    // function filtro() {
    //   var filtrosExt = $('#filtrosExt').attr('data');
    //   // debugger;
    //   if (filtrosExt == "false") {
    //     $('#filtrosExt').removeAttr('hidden');
    //     $('#filtrosExt').attr('data', "true");
    //   } else {
    //     $('#filtrosExt').attr('hidden', '');
    //     $('#filtrosExt').attr('data', "false");
    //   }
    // }

    function filtroAsignacionDeRecursos() {
      wo();
      $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "Reportes/filtroAsignacionDeRecursos",
        success: function(rsp) {
          var html_lote = '<option selected disabled>Seleccione lote</option>';
          // debugger;
          if (_isset(rsp.lote)) {
            rsp.lote.forEach(element => {
              html_lote += "<option value=" + element.id + ">" + element.lote + "</option>";
            });
          }
          $('#lote_id').html(html_lote);
        },
        error: function(rsp) {
          alert('Error tremendo');
        },
        complete: function() {
          wc();
        }
      })
    }

    $('.flt-clear').click(function() {
      $('#frm-filtros')[0].reset();
    });
  </script>
</body>