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
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-solid">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">
                Reporte de Ingresos
              </h3>
            </div>
            <hr>
            <!--_________________FILTRO_________________-->
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <label style="padding-left: 20%;">Desde</label>
                    <div class="input-group date">
                      <div class="input-group-addon" id="daterange-btn">
                        <i class="fa fa-magic"></i>
                        <span></span>
                        </button>
                      </div>
                      <input type="date" class="form-control pull-right" id="desde" name="desde" placeholder="Desde">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <label>Hasta</label>
                    <div class="input-group">
                      <input type="date" class="form-control" id="hasta" name="hasta" placeholder="Hasta">
                      <div class="input-group-addon" style="cursor: pointer;" onclick="filtro()">
                        <i class="fa fa-filter"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br>
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
  <script>
    $('tr > td').each(function() {
      if ($(this).text() == 0) {
        $(this).text('-');
        $(this).css('text-align', 'center');
      }
    });

    $('#panel-derecho-body').load('<?php echo base_url() ?>index.php/Reportes/filtroProduccion');

    // DataTable($('.dataTable'));


    // function rangoFechas() {
    //   debugger;
    // $(function() {
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
        // $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#desde').val(start.format('YYYY-MM-DD'));
        $('#hasta').val(end.format('YYYY-MM-DD'));
      }
    );

    function filtro() {
      var desde2 = $('#desde').val();
      var hasta2 = $('#hasta').val();
      // debugger;
    }
    // }
    // })
  </script>

  <!-- <div class="daterangepicker dropdown-menu ltr opensleft" style="display: none; top: 702.091px; right: 404.727px; left: auto;" _mstvisible="0">
    <div class="calendar left" _mstvisible="1">
      <div class="daterangepicker_input" _mstvisible="2"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" _mstvisible="3"><i class="fa fa-calendar glyphicon glyphicon-calendar" _mstvisible="3"></i>
        <div class="calendar-time" style="display: none;" _mstvisible="3">
          <div _mstvisible="4"></div><i class="fa fa-clock-o glyphicon glyphicon-time" _mstvisible="4"></i>
        </div>
      </div>
      <div class="calendar-table" _mstvisible="2">
        <table class="table-condensed" _msthidden="50">
          <thead _msthidden="8">
            <tr _msthidden="1">
              <th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th>
              <th colspan="5" class="month" _msthash="511780" _msttexthash="60814" _msthidden="1">Jul 2020</th>
              <th></th>
            </tr>
            <tr _msthidden="7">
              <th _msthash="511781" _msttexthash="19721" _msthidden="1">Su</th>
              <th _msthash="511782" _msttexthash="18551" _msthidden="1">Mo</th>
              <th _msthash="511783" _msttexthash="19812" _msthidden="1">Tu</th>
              <th _msthash="511784" _msttexthash="18421" _msthidden="1">We</th>
              <th _msthash="511785" _msttexthash="18460" _msthidden="1">Th</th>
              <th _msthash="511786" _msttexthash="18226" _msthidden="1">Fr</th>
              <th _msthash="511787" _msttexthash="17641" _msthidden="1">Sa</th>
            </tr>
          </thead>
          <tbody _msthidden="42">
            <tr _msthidden="7">
              <td class="weekend off available" data-title="r0c0" _msthash="517327" _msttexthash="10374" _msthidden="1">28</td>
              <td class="off available" data-title="r0c1" _msthash="517328" _msttexthash="10478" _msthidden="1">29</td>
              <td class="off available" data-title="r0c2" _msthash="517329" _msttexthash="9633" _msthidden="1">30</td>
              <td class="active start-date available" data-title="r0c3" _msthash="517330" _msttexthash="4459" _msthidden="1">1</td>
              <td class="in-range available" data-title="r0c4" _msthash="517331" _msttexthash="4550" _msthidden="1">2</td>
              <td class="in-range available" data-title="r0c5" _msthash="517332" _msttexthash="4641" _msthidden="1">3</td>
              <td class="weekend in-range available" data-title="r0c6" _msthash="517333" _msttexthash="4732" _msthidden="1">4</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend in-range available" data-title="r1c0" _msthash="517334" _msttexthash="4823" _msthidden="1">5</td>
              <td class="in-range available" data-title="r1c1" _msthash="517335" _msttexthash="4914" _msthidden="1">6</td>
              <td class="in-range available" data-title="r1c2" _msthash="517336" _msttexthash="5005" _msthidden="1">7</td>
              <td class="in-range available" data-title="r1c3" _msthash="517337" _msttexthash="5096" _msthidden="1">8</td>
              <td class="in-range available" data-title="r1c4" _msthash="517338" _msttexthash="5187" _msthidden="1">9</td>
              <td class="in-range available" data-title="r1c5" _msthash="517339" _msttexthash="9451" _msthidden="1">10</td>
              <td class="weekend in-range available" data-title="r1c6" _msthash="517340" _msttexthash="9555" _msthidden="1">11</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend in-range available" data-title="r2c0" _msthash="517341" _msttexthash="9659" _msthidden="1">12</td>
              <td class="in-range available" data-title="r2c1" _msthash="517342" _msttexthash="9763" _msthidden="1">13</td>
              <td class="in-range available" data-title="r2c2" _msthash="517343" _msttexthash="9867" _msthidden="1">14</td>
              <td class="in-range available" data-title="r2c3" _msthash="517344" _msttexthash="9971" _msthidden="1">15</td>
              <td class="in-range available" data-title="r2c4" _msthash="517345" _msttexthash="10075" _msthidden="1">16</td>
              <td class="in-range available" data-title="r2c5" _msthash="517346" _msttexthash="10179" _msthidden="1">17</td>
              <td class="weekend in-range available" data-title="r2c6" _msthash="517347" _msttexthash="10283" _msthidden="1">18</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend in-range available" data-title="r3c0" _msthash="517348" _msttexthash="10387" _msthidden="1">19</td>
              <td class="in-range available" data-title="r3c1" _msthash="517349" _msttexthash="9542" _msthidden="1">20</td>
              <td class="in-range available" data-title="r3c2" _msthash="517350" _msttexthash="9646" _msthidden="1">21</td>
              <td class="in-range available" data-title="r3c3" _msthash="517351" _msttexthash="9750" _msthidden="1">22</td>
              <td class="in-range available" data-title="r3c4" _msthash="517352" _msttexthash="9854" _msthidden="1">23</td>
              <td class="in-range available" data-title="r3c5" _msthash="517353" _msttexthash="9958" _msthidden="1">24</td>
              <td class="weekend in-range available" data-title="r3c6" _msthash="517354" _msttexthash="10062" _msthidden="1">25</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend in-range available" data-title="r4c0" _msthash="517355" _msttexthash="10166" _msthidden="1">26</td>
              <td class="in-range available" data-title="r4c1" _msthash="517356" _msttexthash="10270" _msthidden="1">27</td>
              <td class="in-range available" data-title="r4c2" _msthash="517357" _msttexthash="10374" _msthidden="1">28</td>
              <td class="in-range available" data-title="r4c3" _msthash="517358" _msttexthash="10478" _msthidden="1">29</td>
              <td class="today active end-date in-range available" data-title="r4c4" _msthash="517359" _msttexthash="9633" _msthidden="1">30</td>
              <td class="available" data-title="r4c5" _msthash="517360" _msttexthash="9737" _msthidden="1">31</td>
              <td class="weekend off available" data-title="r4c6" _msthash="517361" _msttexthash="4459" _msthidden="1">1</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend off available" data-title="r5c0" _msthash="517362" _msttexthash="4550" _msthidden="1">2</td>
              <td class="off available" data-title="r5c1" _msthash="517363" _msttexthash="4641" _msthidden="1">3</td>
              <td class="off available" data-title="r5c2" _msthash="517364" _msttexthash="4732" _msthidden="1">4</td>
              <td class="off available" data-title="r5c3" _msthash="517365" _msttexthash="4823" _msthidden="1">5</td>
              <td class="off available" data-title="r5c4" _msthash="517366" _msttexthash="4914" _msthidden="1">6</td>
              <td class="off available" data-title="r5c5" _msthash="517367" _msttexthash="5005" _msthidden="1">7</td>
              <td class="weekend off available" data-title="r5c6" _msthash="517368" _msttexthash="5096" _msthidden="1">8</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="calendar right" _mstvisible="1">
      <div class="daterangepicker_input" _mstvisible="2"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" _mstvisible="3"><i class="fa fa-calendar glyphicon glyphicon-calendar" _mstvisible="3"></i>
        <div class="calendar-time" style="display: none;" _mstvisible="3">
          <div _mstvisible="4"></div><i class="fa fa-clock-o glyphicon glyphicon-time" _mstvisible="4"></i>
        </div>
      </div>
      <div class="calendar-table" _mstvisible="2">
        <table class="table-condensed" _msthidden="50">
          <thead _msthidden="8">
            <tr _msthidden="1">
              <th></th>
              <th colspan="5" class="month" _msthash="827875" _msttexthash="59410" _msthidden="1">Aug 2020</th>
              <th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th>
            </tr>
            <tr _msthidden="7">
              <th _msthash="827876" _msttexthash="19721" _msthidden="1">Su</th>
              <th _msthash="827877" _msttexthash="18551" _msthidden="1">Mo</th>
              <th _msthash="827878" _msttexthash="19812" _msthidden="1">Tu</th>
              <th _msthash="827879" _msttexthash="18421" _msthidden="1">We</th>
              <th _msthash="827880" _msttexthash="18460" _msthidden="1">Th</th>
              <th _msthash="827881" _msttexthash="18226" _msthidden="1">Fr</th>
              <th _msthash="827882" _msttexthash="17641" _msthidden="1">Sa</th>
            </tr>
          </thead>
          <tbody _msthidden="42">
            <tr _msthidden="7">
              <td class="weekend off in-range available" data-title="r0c0" _msthash="835918" _msttexthash="10166" _msthidden="1">26</td>
              <td class="off in-range available" data-title="r0c1" _msthash="835919" _msttexthash="10270" _msthidden="1">27</td>
              <td class="off in-range available" data-title="r0c2" _msthash="835920" _msttexthash="10374" _msthidden="1">28</td>
              <td class="off in-range available" data-title="r0c3" _msthash="835921" _msttexthash="10478" _msthidden="1">29</td>
              <td class="today off active end-date in-range available" data-title="r0c4" _msthash="835922" _msttexthash="9633" _msthidden="1">30</td>
              <td class="off available" data-title="r0c5" _msthash="835923" _msttexthash="9737" _msthidden="1">31</td>
              <td class="weekend available" data-title="r0c6" _msthash="835924" _msttexthash="4459" _msthidden="1">1</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend available" data-title="r1c0" _msthash="835925" _msttexthash="4550" _msthidden="1">2</td>
              <td class="available" data-title="r1c1" _msthash="835926" _msttexthash="4641" _msthidden="1">3</td>
              <td class="available" data-title="r1c2" _msthash="835927" _msttexthash="4732" _msthidden="1">4</td>
              <td class="available" data-title="r1c3" _msthash="835928" _msttexthash="4823" _msthidden="1">5</td>
              <td class="available" data-title="r1c4" _msthash="835929" _msttexthash="4914" _msthidden="1">6</td>
              <td class="available" data-title="r1c5" _msthash="835930" _msttexthash="5005" _msthidden="1">7</td>
              <td class="weekend available" data-title="r1c6" _msthash="835931" _msttexthash="5096" _msthidden="1">8</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend available" data-title="r2c0" _msthash="835932" _msttexthash="5187" _msthidden="1">9</td>
              <td class="available" data-title="r2c1" _msthash="835933" _msttexthash="9451" _msthidden="1">10</td>
              <td class="available" data-title="r2c2" _msthash="835934" _msttexthash="9555" _msthidden="1">11</td>
              <td class="available" data-title="r2c3" _msthash="835935" _msttexthash="9659" _msthidden="1">12</td>
              <td class="available" data-title="r2c4" _msthash="835936" _msttexthash="9763" _msthidden="1">13</td>
              <td class="available" data-title="r2c5" _msthash="835937" _msttexthash="9867" _msthidden="1">14</td>
              <td class="weekend available" data-title="r2c6" _msthash="835938" _msttexthash="9971" _msthidden="1">15</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend available" data-title="r3c0" _msthash="835939" _msttexthash="10075" _msthidden="1">16</td>
              <td class="available" data-title="r3c1" _msthash="835940" _msttexthash="10179" _msthidden="1">17</td>
              <td class="available" data-title="r3c2" _msthash="835941" _msttexthash="10283" _msthidden="1">18</td>
              <td class="available" data-title="r3c3" _msthash="835942" _msttexthash="10387" _msthidden="1">19</td>
              <td class="available" data-title="r3c4" _msthash="835943" _msttexthash="9542" _msthidden="1">20</td>
              <td class="available" data-title="r3c5" _msthash="835944" _msttexthash="9646" _msthidden="1">21</td>
              <td class="weekend available" data-title="r3c6" _msthash="835945" _msttexthash="9750" _msthidden="1">22</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend available" data-title="r4c0" _msthash="835946" _msttexthash="9854" _msthidden="1">23</td>
              <td class="available" data-title="r4c1" _msthash="835947" _msttexthash="9958" _msthidden="1">24</td>
              <td class="available" data-title="r4c2" _msthash="835948" _msttexthash="10062" _msthidden="1">25</td>
              <td class="available" data-title="r4c3" _msthash="835949" _msttexthash="10166" _msthidden="1">26</td>
              <td class="available" data-title="r4c4" _msthash="835950" _msttexthash="10270" _msthidden="1">27</td>
              <td class="available" data-title="r4c5" _msthash="835951" _msttexthash="10374" _msthidden="1">28</td>
              <td class="weekend available" data-title="r4c6" _msthash="835952" _msttexthash="10478" _msthidden="1">29</td>
            </tr>
            <tr _msthidden="7">
              <td class="weekend available" data-title="r5c0" _msthash="835953" _msttexthash="9633" _msthidden="1">30</td>
              <td class="available" data-title="r5c1" _msthash="835954" _msttexthash="9737" _msthidden="1">31</td>
              <td class="off available" data-title="r5c2" _msthash="835955" _msttexthash="4459" _msthidden="1">1</td>
              <td class="off available" data-title="r5c3" _msthash="835956" _msttexthash="4550" _msthidden="1">2</td>
              <td class="off available" data-title="r5c4" _msthash="835957" _msttexthash="4641" _msthidden="1">3</td>
              <td class="off available" data-title="r5c5" _msthash="835958" _msttexthash="4732" _msthidden="1">4</td>
              <td class="weekend off available" data-title="r5c6" _msthash="835959" _msttexthash="4823" _msthidden="1">5</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="ranges" _mstvisible="1">
      <ul _mstvisible="2">
        <li data-range-key="Today" _msthash="640926" _msttexthash="32253" _mstvisible="3">Hoy</li>
        <li data-range-key="Yesterday" _msthash="640927" _msttexthash="45136" _mstvisible="3">Ayer</li>
        <li data-range-key="Last 7 Days" _msthash="640928" _msttexthash="331812" _mstvisible="3">Los últimos 7 días</li>
        <li data-range-key="Last 30 Days" _msthash="640929" _msttexthash="349297" class="active" _mstvisible="0">Los últimos 30 días</li>
        <li data-range-key="This Month" _msthash="640930" _msttexthash="95719" _mstvisible="3">Este mes</li>
        <li data-range-key="Last Month" _msthash="640931" _msttexthash="178880" _mstvisible="3">El mes pasado</li>
        <li data-range-key="Custom Range" _msthash="640932" _msttexthash="387049" _mstvisible="3">Rango personalizado</li>
      </ul>
      <div class="range_inputs" _mstvisible="2"><button class="applyBtn btn btn-sm btn-success" type="button" _msthash="905426" _msttexthash="92404" _mstvisible="3">Aplicar</button> <button class="cancelBtn btn btn-sm btn-default" type="button" _msthash="905946" _msttexthash="110357" _mstvisible="3">Cancelar</button></div>
    </div>
  </div> -->
</body>
