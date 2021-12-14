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
  table.dataTable tbody td {
    word-break: break-word;
    vertical-align: top;
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
                    </select>
                  </div>
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Transporte</label>
                    <select class="form-control" id="tran_id" name="tran_id">
                    </select>
                  </div>
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Producto</label>
                    <select class="form-control" id="arti_id" name="arti_id">
                    </select>
                  </div>
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Unidad de Medida</label>
                    <select class="form-control" id="u_medida" name="u_medida">
                    </select>
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </form>
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
                    "id" => array(
                      "label" => "ID"
                    ),
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
                    "unidad_medida" => array(
                      "label" => "U. Medida"
                    ),
                    "cantidad" => array(
                      "label" => "Cantidad"
                    ),
                    array(
                      "label" => "Descarga",
                      "value" => function($row) {
                        $aux = $row["deposito"] . " | " . $row['recipiente'];
                        return $aux;
                      }
                    ),
                    "codigo" => array(
                      "label" => "Lote"
                    ),
                    "estado" => array(
                      "label" => "Estado"
                    )
                  ),
                  "cssClass" => array(
                    // "table" => "table-bordered table-striped table-hover dataTable",
                    "table" => "table dataTable dt-responsive table-striped table-bordered",
                    "th" => "sorting"
                    // "tr" => "cssItem"
                    // "tf" => "cssFooter"
                  )
                ));
                ?>
              </div>
            </div>
            <!-- _________________FIN TABLA_________________-->
            <!--_________________ CHARTS_________________-->
            <!--_________________ FIN CHARTS_________________-->
          </div> <!-- FIN .box box-primary -->
          <!--_________________ FIN BODY REPORTE ____________________________-->
        </div> <!-- FIN .box box-solid -->
      </div><!-- FIN .col-xs-12 col-sm-12 col-md-12 col-lg-12 -->
    </div><!-- FIN .row -->
  </div> <!-- FIN #reportContent -->
  <script>
    filtroIngresos();
    cantidadIngresos();
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          },
          footer: true,
          title: 'Reporte Ingresos',
          filename: 'reporte_ingresos',
          //Aquí es donde generas el botón personalizado
          text: '<button class="btn btn-success ml-2 mb-2 mb-2 mt-3">Exportar a Excel <i class="fa fa-file-excel-o"></i></button>'
        },
        // //Botón para PDF
        {
          extend: 'pdf',
          exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          },
          footer: true,
          title: 'Reporte Ingresos',
          filename: 'reporte_ingresos',
          text: '<button class="btn btn-danger ml-2 mb-2 mb-2 mt-3">Exportar a PDF <i class="fa fa-file-pdf-o mr-1"></i></button>'
        },
        {
          extend: 'copy',
          exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          },
          footer: true,
          title: 'Reporte Ingresos',
          filename: 'reporte_ingresos',
          text: '<button class="btn btn-primary ml-2 mb-2 mb-2 mt-3">Copiar <i class="fa fa-file-text-o mr-1"></i></button>'
        },
        {
          extend: 'print',
          exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          },
          footer: true,
          title: 'Reporte Ingresos',
          filename: 'reporte_ingresos',
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

    // DataTable($('.dataTable'));
    // $('.dataTable').dataTable();

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
          
          if (_isset(rsp.transportista)) {
            rsp.transportista.forEach(element => {
              html_trans += "<option value=" + element.cuit + ">" + element.razon_social + "</option>";
            });
          }
          $('#tran_id').html(html_trans);

          var html_prov = '<option selected disabled>Seleccione proveedor</option>';
          
          if (_isset(rsp.proveedores)) {
            rsp.proveedores.forEach(element => {
              html_prov += "<option value=" + element.id + ">" + element.titulo + "</option>";
            });
          }
          $('#prov_id').html(html_prov);

          var html_prod = '<option selected disabled>Seleccione producto</option>';
          
          if (_isset(rsp.productos)) {
            rsp.productos.forEach(element => {
              html_prod += "<option value=" + element.id + ">" + element.nombre + "</option>";
            });
          }
          $('#arti_id').html(html_prod);

          var html_medidas = '<option selected disabled>Seleccione medida</option>';

          if (_isset(rsp.u_medidas)) {
            rsp.u_medidas.forEach(element => {
              html_medidas += "<option value=" + element.valor + ">" + element.descripcion + "</option>";
            });
          }
          $('#u_medida').html(html_medidas);
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
        var estado = $(this).find('td:eq(12)').text();
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

          case 'DESCARGADO':
            estado = 'Descargado';
            color = 'orange';
            break
          default:
            estado = 'S/E';
            color = '';
            break;
        }
        $(this).find('td:eq(12)').html(bolita(estado, color));
      })
      $('#cant_ingresos').text(count);
    }

    $('.flt-clear').click(function() {
      $('#frm-filtros')[0].reset();
    });
  </script>
</body>