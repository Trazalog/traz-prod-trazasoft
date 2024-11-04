<?php

use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\ColumnChart;
 
?>
<style>
  .input-group-addon:hover {
    cursor: pointer;
    background-color: #04d61d !important;
  }

  .input-group-addon {
    background-color: #05b513 !important;
    color: white !important;
  }
</style>

<div id="reportContent" class="report-content">
  <div class="box box-primary">

    <div class="box-header with-border">
      <div class="box-tittle">
        <h4>Reporte Camiones</h4>
      </div>
    </div>

    <div class="box-body">
      <!-- _____ GRUPO 1 _____ -->
      <div class="col-md-12">
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">
            <label style="">Fecha Desde:</label>
            <div class="input-group date">
              <a class="input-group-addon" id="daterange-btn" title="Más fechas">
                <i class="fa fa-magic"></i>
                <span></span>
              </a>
              <input type="date" class="form-control" id="datepickerDesde" name="datepickerDesde" placeholder="Desde">
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">
            <label style="">Fecha Hasta:</label>
            <input type="date" class="form-control" id="datepickerHasta" name="datepickerHasta" placeholder="Hasta">
          </div>
        </div>
        <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
          <div class="form-group">
            <label for="cliente" class="form-label">Cliente:</label>
            <?php echo selectFromCoreEmpresa('resultado', 'Seleccione Cliente', 'clientes', '') ?>
          </div>
        </div>
      </div>
      <!-- _____ GRUPO 1 _____ -->
      <!--_______ BOTONES _______-->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div style="float:right; padding-top: 24px" class="form-group">
          <button type="button" class="btn btn-success btn-flat" onclick="filtrar()">Filtrar</button>
          <button style="margin-left: 5px" type="button" class="btn btn-danger btn-flat flt-clear">Limpiar</button>
        </div>
      </div>
      <!--_______ BOTONES _______-->
      <!--_______ TABLA _______-->
      <div class="col-md-12">
        <?php
        Table::create(array(
          "dataStore" => $this->dataStore('data_historico_table'),
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
            array(
              "label" => "Acciones",
              "value" => function ($row) {
                return "<i class='fa fa-search text-light-blue'  style='cursor: pointer;margin: 3px;' title='Ver Pedido' onclick='buscaDetalleInspeccion(this)' data-json='".json_encode($row)."'></i>";
              }
            ),
            "case_id" => array(
              "label" => "Nº Remito"
            ),
            array(
              "label" => "Cliente",
              "value" => function ($row) {
                return $row["cliente"];
              }
            ),
            array(
              "label" => "Fecha",
              "value" => function ($row) {                            
                $aux = explode("T", $row["fec_alta"]);
                $row["fec_alta"] = date("d-m-Y", strtotime($aux[0]));
                return $row["fec_alta"];
              },
              "type" => "date"
            ),                      
            array(
              "label" => "Importe",
              "value" => function ($row) {  
                 return $row["importe"];
                 }
            )
          ),
          "cssClass" => array(
            "table" => "table dataTable dt-responsive table-striped table-bordered",
            "th" => "sorting"
          )
        ));
        ?>
      </div>
      <!--_______ TABLA _______-->
    </div>
  </div>
</div>

<script>
  fechaMagic();
  $(".frm-select").select2();

  // Llena tabla con la informacion filtrada
  function filtrar() {
    wo();
    var data = buscaDatos();
    if (!data) {
      alertify.error('Seleccione fechas por favor...');
      wc();
      return;
    }
    $.ajax({
      type: 'POST',
      data: {
        data
      },
      url: "<?php echo SICP; ?>reportes/historicoCamiones",
      success: function(result) {
        $('#reportContent').empty();
        $('#reportContent').html(result);
        wc();
      },

      error: function(result) {
        wc();
      },
      complete: function() {

      }
    });
  }

  // Recolecta los datos de los filtros
  function buscaDatos() {

    desde = $("#datepickerDesde").val();
    hasta = $("#datepickerHasta").val();
    // if (desde == "" || hasta == "") {
    //   return false;
    // }
    origen = _isset($("#origen").val()) ? $("#origen").select2('data')[0].id : "";
    if (origen == "") {
      origen = 'TODOS';
    }
    destino = _isset($("#destino").val()) ? $("#destino").select2('data')[0].id : "";
    if (destino == "") {
      destino = 'TODOS';
    }
    transportista = _isset($("#transportista").val()) ? $("#transportista").select2('data')[0].id : "";
    if (transportista == "") {
      transportista = 'TODOS';
    }
    resultado = _isset($("#resultado").val()) ? $("#resultado").val() : "";
    if (resultado == "") {
      resultado = 'TODOS';
    }
    producto = _isset($("#producto").val()) ? $("#producto").select2('data')[0].id : "";
    if (producto == "") {
      producto = 'TODOS';
    }
    termico = _isset($("#termico").val()) ? $("#termico").select2('data')[0].id : "";
    if (termico == "") {
      termico = 'TODOS';
    }
    var data = {};
    data.fec_desde = desde;
    data.fec_hasta = hasta;
    data.cuit_origen = origen;
    data.cuit_destino = destino;
    data.cuit_transporte = transportista;
    data.resultado = resultado;
    data.tipo_producto = producto;
    data.termico = termico;
    return data;
  }
  var tipoActa = '';
  var reprecintado = '';
  // Levanta modal detalle de reporte
  function buscaDetalleInspeccion(tag) {
    var data =	JSON.parse($(tag).attr('data-json'));
    reprecintado = data.numerador_reprecintado;
    wo();
    $("#modalBodyDetalle").empty();
    let case_id = $(tag).parents("tr").find("td").eq(1).html();
    let caseId = case_id.trim();
    let resultado = $(tag).parents("tr").find("td").eq(10).html();
    tipoActa = resultado.trim(); 
    if ($.trim(reprecintado) !== "") {
      $("#btnreprecintado").show();
    } else {
      $("#btnreprecintado").hide();
    }
    var data = {};
    data.caseId = caseId;
    $("#modalBodyDetalle").load("<?php echo base_url(SICP); ?>reportes/detaReporte", data, function() {
      wc();
    });
    $("#modalDetalle").modal('show');

  };

  // Muestra el thumbnail en tamaño grande
  function preview(imgs) {
    // Tomo el elemento para la vista previa
    var expandImg = document.getElementById("expandedImg");
    // Le asigno la misma src al elemento de la vista previa
    expandImg.src = imgs.src;
  }

  // Imprimir ACTA
  function imprimirActa() {

    var acta = '';
    if(tipoActa == 'incorrecta'){
      acta = "#actaInfraccion";
    }
    else{
     
      acta = "#actaInspeccionPCC";
    } 

    var base = "<?php echo base_url(); ?>";
    $(acta).printThis({
      debug: false,
      importCSS: false,
      importStyle: true,
      loadCSS: "",
      base: base,
      pageTitle: "TRAZALOG TOOLS",
      /* afterPrint: function(){
            const confirm = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-primary'
					},
					buttonsStyling: false
				});

                confirm.fire({
                    title: 'Perfecto!',
                    text: "Se finalizó la tarea correctamente!",
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                  console.log("terminé");

                });
        } */
    });
  }

  function imprimirActaReprecintado() {
    acta = "#actaReprecintado";

    var base = "<?php echo base_url(); ?>";
    $(acta).printThis({
      debug: false,
      importCSS: false,
      importStyle: true,
      loadCSS: "",
      base: base,
      pageTitle: "TRAZALOG TOOLS"
    });
  }

  // cierra modal detalle de reporte
  function cerrarModal() {
    $("#modalDetalle").modal('hide');
  }

  //Funcion de datatable para extencion de botones exportar
  //excel, pdf, copiado portapapeles e impresion

  $(document).ready(function() {
    // $("#btnreprecintado").hide();
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
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
          },
          footer: true,
          title: 'Inspecciones',
          filename: 'inspecciones',
          //Aquí es donde generas el botón personalizado
          text: '<button class="btn btn-success ml-2 mb-2 mb-2 mt-3">Exportar a Excel <i class="fa fa-file-excel-o"></i></button>'
        },
        // //Botón para PDF
        {
          extend: 'pdf',
          exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
          },
          footer: true,
          title: 'Excel Remitos',
          filename: 'Excel_Remitos',
          text: '<button class="btn btn-danger ml-2 mb-2 mb-2 mt-3">Exportar a PDF <i class="fa fa-file-pdf-o mr-1"></i></button>'
        },
        {
            extend: 'copy',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
            },
            footer: true,
            title: 'Excel Remitos',
            filename: 'Excel_Remitos',
            text: '<button class="btn btn-primary ml-2 mb-2 mb-2 mt-3">Copiar <i class="fa fa-file-text-o mr-1"></i></button>'
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
            },
            footer: true,
            title: 'Excel Remitos',
            filename: 'Excel_Remitos',
            text: '<button class="btn btn-default ml-2 mb-2 mb-2 mt-3">Imprimir <i class="fa fa-print mr-1"></i></button>'
        }
      ]
    });
  });
</script>

<div class='modal fade bs-example-modal-lg' id='modalDetalle' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel'>
  <div class='modal-dialog modal-lg' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' onclick='cerrarModal()' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title' id='myModalLabel'>Detalle Inspección</h4>
      </div>
      <div class='modal-body modalBodyDetalle' id='modalBodyDetalle'>

      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' onclick='cerrarModal()'>Cancelar</button>
        <button type='button' class='btn btn-primary' onclick='imprimirActa()'>Imprimir Acta</button>
        <button type='button' class='btn btn-primary' id="btnreprecintado" onclick='imprimirActaReprecintado()'>Imprimir Reprecintado</button>
      </div>
    </div>
  </div>
</div>