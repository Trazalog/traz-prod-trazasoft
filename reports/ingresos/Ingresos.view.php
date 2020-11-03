<?php

use \koolreport\widgets\koolphp\Table;
// use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
// use \koolreport\widgets\google\PieChart;
// use \koolreport\inputs\Select2;
// use \koolreport\widgets\koolphp\Card;
?>
<style>
  .truck {
    padding-bottom: 0%;
    margin-bottom: -4%;
    padding-top: 4%;
    margin-top: -20%;
  }
</style>

<body>
  <!--_________________BODY REPORTE___________________________-->
  <div id="reportContent" class="report-content">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-solid">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">
                Reporte de Ingresos
              </h3>
            </div>
            <br><br>
            <!--_________________FILTRO_________________-->
            <form id="frm-filtros">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> -->
                  <!-- <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6"> -->
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label style="padding-left: 20%;">Desde</label>
                    <div class="input-group date">
                      <a class="input-group-addon" id="daterange-btn" title="Más fechas">
                        <i class="fa fa-magic"></i>
                        <span></span>
                      </a>
                      <input type="date" class="form-control pull-right" id="datepickerDesde" name="datepickerDesde" placeholder="Desde">
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <!-- <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6"> -->
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Hasta</label>
                    <div class="input-group">
                      <input type="date" class="form-control" id="datepickerHasta" name="datepickerHasta" placeholder="Hasta">
                      <a class="input-group-addon" style="cursor: pointer;" onclick="filtro()" title="Más filtros">
                        <i class="fa fa-filter"></i>
                      </a>
                    </div>
                  </div>
                  <div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <label class="col-lg-12">&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-flat flt-clear col-lg-6">Limpiar</button>
                    <button type="button" class="btn btn-success btn-flat col-lg-6" onclick="filtrar()">Filtrar</button>
                    <input type="hidden" value="<?php echo $op ?>" id="op" hidden="true">
                  </div>
                  <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
                    <div class="small-box bg-yellow">
                      <div class="inner truck">
                        <h3 id="cant_ingresos">0</h3>
                        <h4>Cantidad de ingresos</h4>
                      </div>
                      <div class="icon">
                        <i class="fa fa-truck"></i>
                      </div>
                      <br>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row" id="filtrosExt" data="false" hidden>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> -->
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Proveedor</label>
                    <select class="form-control" id="prov_id" name="prov_id">
                      <!-- <?php
                            echo "<option selected disabled>Seleccione proveedor</option>"
                            ?> -->
                    </select>
                  </div>
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Transporte</label>
                    <select class="form-control" id="tran_id" name="tran_id">
                      <!-- <?php
                            echo "<option selected disabled>Seleccione transporte</option>"
                            ?> -->
                    </select>
                  </div>
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Producto</label>
                    <select class="form-control" id="arti_id" name="arti_id">
                      <!-- <?php
                            echo "<option selected disabled>Seleccione producto</option>"
                            ?> -->
                    </select>
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </form>
            <!-- <br> -->
            <hr>
            <!--_________________TABLA_________________-->
            <div class="box-body">
              <div class="col-md-12">
                <?php
                Table::create(array(
                  "dataStore" => $this->dataStore('data_ingresos_table'),
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
                    "boleta" => array(
                      "label" => "Nº bol."
                    ),
                    "fecha" => array(
                      "label" => "Fecha"
                    ),
                    "nombre" => array(
                      "label" => "Proveedor"
                    ),
                    "razon_social" => array(
                      "label" => "Transporte"
                    ),
                    "patente" => array(
                      "label" => "Dominio"
                    ),
                    "neto" => array(
                      "label" => "Neto"
                    ),
                    "descripcion" => array(
                      "label" => "Producto"
                    ),
                    "cantidad" => array(
                      "label" => "Cantidad"
                    ),
                    "estado" => array(
                      "label" => "Estado"
                    )
                  ),
                  "cssClass" => array(
                    // "table" => "table-bordered table-striped table-hover dataTable",
                    "table" => "table-scroll table-responsive dataTables_wrapper form-inline dt-bootstrap dataTable table table-bordered table-striped table-hover display",
                    "th" => "sorting"
                    // "tr" => "cssItem"
                    // "tf" => "cssFooter"
                  )
                ));
                ?>
              </div>
            </div>
            <!-- _________________FIN TABLA_________________-->
            <!-- <div class="col-md-12">
              <br>
              <div class="box box-primary">
              </div>
            </div> -->
            <!--_________________ CHARTS_________________-->
            <!-- <div class="row">
              <div class="col-md-12"> -->
            <!--_________________ CHARTS 1_________________-->
            <!-- <div class="col-md-6">
              <div class="box-header with-border">
                <h3 class="box-title center">
                  <i class="fa fa-pie-chart"></i>
                  Cantidad de ingresos
                </h3>
              </div> -->
            <!--_________________ BODY CHART 1_________________-->
            <!-- <div class="box-body">
              <div style="margin-bottom:50px;">
                <?php
                ColumnChart::create(array(
                  "title" => "Proveedores",
                  "dataStore" => $this->dataStore('data_ingresos_clumnChart'),
                  "columns" => array(
                    "nombre" => array(
                      "label" => "Proveedor"
                    ),
                    "neto" => array(
                      "type" => "number",
                      "label" => "Neto"
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
          </div> -->
            <!-- </div>
        </div> -->
            <!--_________________ FIN CHARTS_________________-->
          </div>
          <!--_________________ FIN BODY REPORTE ____________________________-->
        </div>
      </div>
    </div>
  </div>
  <script>
    filtroIngresos();
    cantidadIngresos();
    fechaMagic();

    $('tr > td').each(function() {
      if ($(this).text() == 0) {
        $(this).text('-');
        $(this).css('text-align', 'center');
      }
    });

    // DataTable($('.dataTable'));
    $('.dataTable').dataTable();

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

    function filtrar() {
      var data = new FormData($('#frm-filtros')[0]);
      data = formToObject(data);
      wo();
      var url = 'ingresos';
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

    function filtro() {
      var filtrosExt = $('#filtrosExt').attr('data');
      if (filtrosExt == "false") {
        $('#filtrosExt').removeAttr('hidden');
        $('#filtrosExt').attr('data', "true");
      } else {
        $('#filtrosExt').attr('hidden', '');
        $('#filtrosExt').attr('data', "false");
      }
    }

    function filtroIngresos() {
      wo();
      $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "<?php echo base_url(PRD) ?>Reportes/filtroIngresos",
        success: function(rsp) {
          var html_trans = '<option selected disabled>Seleccione transportista</option>';
          // debugger;
          if (_isset(rsp.transportista)) {
            rsp.transportista.forEach(element => {
              html_trans += "<option value=" + element.cuit + ">" + element.razon_social + "</option>";
            });
          }
          $('#tran_id').html(html_trans);

          var html_prov = '<option selected disabled>Seleccione proveedor</option>';
          // debugger;
          if (_isset(rsp.proveedores)) {
            rsp.proveedores.forEach(element => {
              html_prov += "<option value=" + element.id + ">" + element.titulo + "</option>";
            });
          }
          $('#prov_id').html(html_prov);

          var html_prod = '<option selected disabled>Seleccione producto</option>';
          // debugger;
          if (_isset(rsp.productos)) {
            rsp.productos.forEach(element => {
              html_prod += "<option value=" + element.id + ">" + element.nombre + "</option>";
            });
          }
          $('#arti_id').html(html_prod);
        },
        error: function(rsp) {
          alert('Error tremendo');
        },
        complete: function() {
          wc();
        }
      })
    }

    function cantidadIngresos() {
      wo();
      $('#cant_ingresos').text('0');
      if ($('.dataTable tbody tr').find('td').text() == "No data available in table") {
        $('#cant_ingresos').text(0);
        return;
      }
      var count = 0;
      $('.dataTable tbody').children('tr').each(function() {
        count++;
        var estado = $(this).find('td:eq(8)').text();
        var color = '';
        switch (estado.trim()) {
          case 'CARGADO':
            estado = 'Cargado';
            color = 'blue';
            break;
          case 'EN CURSO':
            estado = 'En Curso';
            color = 'green';
            break;
          case 'FINALIZADO':
            estado = 'Finalizado';
            color = 'yellow';
            break;

          default:
            estado = 'S/E';
            color = '';
            break;
        }
        $(this).find('td:eq(8)').html(bolita(estado, color));
      })
      $('#cant_ingresos').text(count);
    }

    $('.flt-clear').click(function() {
      $('#frm-filtros')[0].reset();
    });
  </script>
</body>