<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Remitos</h3>
            </div><!-- /.box-header -->

            <!--_________________FILTRO_________________-->
            <form id="frm-filtros">
                <div class="row" style="width: 100%">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 2%;">
                        <!-- _____ FECHA DESDE _____ -->
                        <div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <label>Fecha Desde:</label>
                            <div class="input-group date">
                                <a class="input-group-addon" id="daterange-btn" title="Más fechas">
                                    <i class="fa fa-magic"></i>
                                    <span></span>
                                </a>
                                <input type="date" class="form-control pull-right" id="datepickerDesde" name="datepickerDesde" placeholder="Desde">
                            </div>
                        </div>
                        <!-- _____ FIN FECHA DESDE _____ -->

                        <!-- _____ FECHA HASTA _____ -->
                        <div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <label>Fecha Hasta:</label>
                            <input type="date" class="form-control pull-right" id="datepickerHasta" name="datepickerHasta" placeholder="Hasta">
                        </div>
                        <!-- _____ FIN FECHA HASTA _____ -->

                        <!-- CLIENTES -->
                        <div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <label>Clientes</label>
                            <div class="input-group">
                                <select class="form-control select2 select2-hidden-accesible clientes" name="clie_id" id="cliente" data-bv-notempty>
                                                <option value="" disabled selected></option>	
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" style="background-color: #00c0ef;">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <!-- BOTÓN FILTRAR -->
                        <div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2" style="padding-top: 25px;">
                            <button type="button" id="btn-filtrar" class="btn btn-primary" style="background-color: #00c0ef;">
                                <i class="fa fa-filter"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
                <br>
            </form>

            <hr>

            <!--_________________TABLA_________________-->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="remitos" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Nro Remito</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->

 <!-- MODAL REMITO -->
 <?php $this->load->view(PRD. "remito/modal_remito") ?>
<!-- FIN MODAL REMITO -->

 <!-- MODAL PRECIOS -->
 <?php $this->load->view(PRD. "remito/modal_lista_precios") ?>
<!-- FIN MODAL PRECIOS -->

<script>
    $(document).ready(function() {
        $('#remitos').DataTable({
        serverSide: true, // Activar paginado desde el servidor
        processing: true,
        paging: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        ajax: {
            url: '<?php echo base_url(PRD) ?>general/Remito/getRemitosPaginado',
            type: 'POST',
            data: function (d) {
                d.page = d.start / d.length + 1; // Calcular la página actual
                d.limit = d.length; // Cantidad de registros por página 
                d.fechaDesde = $('#datepickerDesde').val(); // Fecha Desde
                d.fechaHasta = $('#datepickerHasta').val(); // Fecha Hasta
                d.cliente = $('#cliente').val(); // Cliente seleccionado
            },
            error: function(xhr, error, code) {
                console.error("Error en la consulta:", xhr.responseText);
            }
        },
        columns: [
            {  data: null, 
            render: function (data, type, row) {
                // Aquí puedes personalizar los botones que quieres en la columna acciones
                return `
                    <i class="fa fa-search" style="cursor: pointer;margin: 3px;" title="Ver Detalles" onclick="ver(this)"></i>
                    <i class="fa fa-print" style="cursor: pointer;margin: 3px;" title="Imprimir" onclick="ReimprimirRemito(this)"></i>
                `;
            } },
            { data: 'nro_remito' },
            { data: 'cliente' },
            { data: 'fec_alta' ,
                render: function (data, type, row) {
                // Convertir la fecha al formato día-mes-año
                const fecha = new Date(data);
                const dia = ('0' + fecha.getDate()).slice(-2); // Asegurar dos dígitos para el día
                const mes = ('0' + (fecha.getMonth() + 1)).slice(-2); // Asegurar dos dígitos para el mes
                const anio = fecha.getFullYear();
                return `${dia}-${mes}-${anio}`;
            }
            },
            { data: 'importe_total', 
                    render: function (data, type, row) {
                    // Truncar a dos decimales
                    return `$ ${parseFloat(data).toFixed(2)}`;
                }
            }
        ],
        responsive: true,
        language: {
            url: '<?php echo base_url() ?>lib/bower_components/datatables.net/js/es-ar.json'
        },
        dom: 'Bfrtip', // Esto es necesario para mostrar los botones
        buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                },
                title: 'Excel Stock',
                filename: 'Excel_Stock',
                text: '<button class="btn btn-success">Exportar a Excel <i class="fa fa-file-excel-o"></i></button>'
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                },
                title: 'Excel Stock',
                filename: 'Excel_Stock',
                text: '<button class="btn btn-danger">Exportar a PDF <i class="fa fa-file-pdf-o"></i></button>'
            },
            {
                extend: 'copy',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                },
                title: 'Excel Stock',
                filename: 'Excel_Stock',
                text: '<button class="btn btn-primary">Copiar <i class="fa fa-file-text-o"></i></button>'
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                },
                title: 'Excel Stock',
                filename: 'Excel_Stock',
                text: '<button class="btn btn-default">Imprimir <i class="fa fa-print"></i></button>'
            }
        ]
    });
        
        $('#cliente').select2({
        ajax: {
            url: '<?php echo base_url(PRD) ?>general/Remito/buscaClientes',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    patron: params.term, // parámetro búsqueda que recibe el controlador
                    page: params.page
                };
            },
            processResults: function (data, params) {
                
                params.page = params.page || 1;
                
                var results = [];
                $.each(data, function(i, obj) {
                    results.push({
                        id: obj.clie_id,
                        text: obj.nombre,
                    });
                });
                return {
                    results: results,
                    pagination: {
                        more: (params.page * 30) < results.length
                    }
                };
            }
        },
        language: "es",
        placeholder: 'Buscar cliente',
        minimumInputLength: 3,
        maximumInputLength: 8,
        dropdownCssClass: "clientes",
        templateResult: function (cliente) {

            if (cliente.loading) {
                return "Buscando clientes...";
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'></div>" +
                    "<div class='select2-result-repository__description'></div>" +
                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").text(cliente.text);
            $container.find(".select2-result-repository__description").text(cliente.id);

            return $container;
        },
        templateSelection: function (cliente) {
            return cliente.text || cliente.id;
        },
        language: {
            noResults: function() {
                return '<option>No hay coincidencias</option>';
            },
            inputTooShort: function () {
                return 'Ingrese 3 o mas dígitos para comenzar la búsqueda'; 
            },
            inputTooLong: function () {
                return 'Hasta 8 dígitos permitidos'; 
            }
        },
        escapeMarkup: function(markup) {
            return markup;
        },
    });
    });

    $('#btn-filtrar').on('click', function() {
        // Obtener los valores de los filtros
        var fechaDesde = $('#datepickerDesde').val();
        var fechaHasta = $('#datepickerHasta').val();
        var cliente = $('#cliente').val();

        // Validar que al menos un filtro no esté vacío
        if (!fechaDesde && !fechaHasta && !cliente) {
                alert('Por favor, seleccione al menos un filtro.'); 
                return; 
            }

        // Volver a cargar el DataTable con los nuevos parámetros
        $('#remitos').DataTable().ajax.reload(null, false); 
    });


// reimprime el remito    
async function ReimprimirRemito(element){

    wo();
    // Usar DataTables para obtener la fila donde se hizo clic
    var table = $('#remitos').DataTable();

    // Obtener la fila del botón donde se hizo clic
    var row = table.row($(element).closest('tr')).data();

    //console.log(row);
    $("#nroRemito").text(row.nro_remito);
    $("#clienteRemito").text(row.cliente);

    const fecha = new Date(row.fec_alta);
    const dia = ('0' + fecha.getDate()).slice(-2); // Asegurar dos dígitos para el día
    const mes = ('0' + (fecha.getMonth() + 1)).slice(-2); // Asegurar dos dígitos para el mes
    const anio = fecha.getFullYear();
    fecha_alta=`${dia}-${mes}-${anio}`
    $("#fechaRemito").text(fecha_alta);

    await dataLineasRemito(row.remi_id)
    wc();
    $('#modalRemito').modal('show');
}


// trae las lineas del remito
async function dataLineasRemito(remi_id){
        try {
       
        const response = await $.ajax({
            type: 'POST',
            data: {remi_id},
            url: '<?php echo base_url(PRD) ?>general/Remito/getLineasRemito'
        });

        // Parsear los datos obtenidos en la respuesta
        const productos = JSON.parse(response);

        var tablaDetalle = $('#tabla_detalle tbody');

        var total = 0;

        // Limpiar la tabla antes de agregar nuevas filas
        tablaDetalle.empty();
        // Recorrer el arreglo de datos y agregar cada fila a la tabla
        productos.forEach(function(datos) {

             // Convertir cantidad y precio a números
            var cantidad = parseFloat(datos.cantidad);
            var precio = parseFloat(datos.precio);
            
            var importe = precio * cantidad;
            
            // Formatear la cantidad, mostrando decimales solo si no es un entero
            var cantidadFormateada = Number.isInteger(cantidad) ? cantidad : cantidad.toFixed(1);

            // Crear una nueva fila con los datos y añadirla a la tabla
            var fila = `
                        <tr>
                            <td>${cantidadFormateada}</td>  
                            <td>${datos.descripcion}</td>    
                            <td>$${precio.toFixed(2)}</td>
                            <td>$${importe.toFixed(2)}</td>
                        </tr>
                    `;

            // Agregar la fila a la tabla
            tablaDetalle.append(fila);
            total += importe;
        });
        $('#footer_table2').val(`$ ${total.toFixed(2)}`);

    } catch (error) {
        // Manejar el error
        wc();
        alert('Error al obtener los datos');
        WaitingClose();
    }

    }

// ver articulos versionados
async function ver(element)
    {
        wo();
        var table = $('#remitos').DataTable();

        var row = table.row($(element).closest('tr')).data();

        var remi_id = row.remi_id

        var dataArticulos = await dataVersionesArticulos(remi_id);
        //console.log(dataArticulos);

        if(dataArticulos){

            $("#nombreVer").val(dataArticulos[0].nombre);
            $("#tipoVer").val(dataArticulos[0].tipo);
            $("#versionVer").val(dataArticulos[0].nro_version != null ? "v"+dataArticulos[0].nro_version  : 1);
            $("#detalleVer").val(dataArticulos[0].descripcion  != null ? dataArticulos[0].descripcion : "Versión original");
            var fecha = new Date(row.fec_alta);
            var dia = ('0' + fecha.getDate()).slice(-2); // Asegurar dos dígitos para el día
            var mes = ('0' + (fecha.getMonth() + 1)).slice(-2); // Asegurar dos dígitos para el mes
            var anio = fecha.getFullYear();

            // Formatear la fecha como YYYY-MM-DD
            var fecFormateada = `${anio}-${mes}-${dia}`;

            // Asignar el valor al input de tipo date
            $("#vigenteDesdeVer").val(fecFormateada);

            //tomo los articulos divididos por coma y los transformo en array
            var articulos = dataArticulos[0].articulos;
            var articulosArray = articulos.split(','); 
            //console.log(articulosArray);
            
            // Creo un array para almacenar los objetos con barcode, descripcion y precio
            var articulosDetalles = articulosArray.map(articulo => {

                // Dividir cada artículo por el delimitador '|'
                var partes = articulo.split('|');
                var precioString = partes[2].trim(); // Eliminar espacios en blanco
                var precioNumero = parseFloat(precioString); // Convertir a número

                return {
                    barcode: partes[0].trim(),       // Código de barras
                    descripcion: partes[1].trim(),    // Descripción
                    precio: isNaN(precioNumero) ? null : precioNumero.toFixed(2)        // Precio
                };
            });

            // Destruir DataTable si ya está inicializado
            if ($.fn.DataTable.isDataTable('#tablaDetalleVer')) {
                tablaDetalleVer.destroy();
            }

            $('#tablaDetalleVer tbody').empty();

            // Agregar los artículos a la tabla
            articulosDetalles.forEach(detalle => {
                $('#tablaDetalleVer tbody').append(`
                    <tr>
                        <td>${detalle.barcode}</td>
                        <td>${detalle.descripcion}</td>
                        <td>$ ${detalle.precio}</td>
                    </tr>
                `);
            });

            // Inicializar DataTable nuevamente
            tablaDetalleVer = $('#tablaDetalleVer').DataTable({
            responsive: true,
            language: {
                url: '<?php echo base_url(); ?>lib/bower_components/datatables.net/js/es-ar.json'
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2] // Índices de las columnas que quieres exportar.
                    },
                    footer: true,
                    title: 'Detalle de la Lista de Precios',
                    filename: 'Detalle_Lista_Precios',
                    text: '<button class="btn btn-success ml-2 mb-2 mt-3">Exportar a Excel <i class="fa fa-file-excel-o"></i></button>'
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    footer: true,
                    title: 'Detalle de la Lista de Precios',
                    filename: 'Detalle_Lista_Precios',
                    text: '<button class="btn btn-danger ml-2 mb-2 mt-3">Exportar a PDF <i class="fa fa-file-pdf-o"></i></button>'
                },
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    footer: true,
                    title: 'Detalle de la Lista de Precios',
                    filename: 'Detalle_Lista_Precios',
                    text: '<button class="btn btn-primary ml-2 mb-2 mt-3">Copiar <i class="fa fa-copy"></i></button>'
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    footer: true,
                    title: 'Detalle de la Lista de Precios',
                    filename: 'Detalle_Lista_Precios',
                    text: '<button class="btn btn-default ml-2 mb-2 mt-3">Imprimir <i class="fa fa-print"></i></button>'
                }
            ]
        });
            wc();
            $('#modalVerListaPrecio').modal('show');
        } 

        
       
    }


// trae todos los datos de la lista de versiones junto con los articulos
async function dataVersionesArticulos(remi_id)
{
    try {
       
       const response = await $.ajax({
           type: 'POST',
           data: {remi_id},
           url: '<?php echo base_url(PRD) ?>general/Remito/getVersionArticulos'
       });

       // Parsear los datos obtenidos en la respuesta
       const dataArticulos = JSON.parse(response);

       return dataArticulos;
       
        } catch (error) {
            // Manejar el error
            wc();
            alert('Error al obtener los datos');
            WaitingClose();
        }

}
    
</script>
