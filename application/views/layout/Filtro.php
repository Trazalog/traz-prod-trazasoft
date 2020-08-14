<style>
    .form-control,
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        border-radius: 0px !important;
    }
</style>
<div id="filtros" class="row">
    <div class="col-md-12">
        <div>
            <!--class="box-body" -->
            <form id="formulario">
                <div class="form-group">
                    <?php foreach ($filtro as $key => $o) { ?>

                        <div class="form-group">
                            <label class="text-withe" for="flt-<?php echo $key ?>"><?php echo ucfirst($key) ?>:</label>
                            <select id="flt-<?php echo $key ?>" name="<?php echo $key ?>" class="form-control">
                                <option value="" selected>Todos</option>
                                <?php foreach ($o as $opt) {
                                    if ($opt->id) {
                                        echo "<option value='$opt->id'>$opt->nombre</option>";
                                    } else {
                                        echo "<option value='$opt->nombre'>$opt->nombre</option>";
                                    }
                                    // echo "<option id='$opt->nombre' value='$opt->nombre' hiden>$opt->nombre</option>";
                                } ?>
                            </select>
                        </div>
                        <!-- <a href='#' class='flt-clear pull-right text-red'><small><i class='fa fa-trash-o'></i> Limpiar </small></a> -->
                    <?php } ?>
                    <?php if (isset($desde) && $desde) { ?>
                        <div class="form-group">
                            <label for='flt-desde'><?php echo $numero ?> desde:</label>
                            <input id='flt-desde' name="desde" placeholder='Ingrese valor' class='form-control'>
                            <!-- <a href='#' class='flt-clear pull-right text-red'><small><i class='fa fa-trash-o'></i> Limpiar </small></a> -->
                        </div>
                    <?php } ?>
                    <?php if (isset($hasta) && $hasta) { ?>
                        <div class="form-group">
                            <label for='flt-hasta'><?php echo $numero ?> hasta:</label>
                            <input id='flt-hasta' name="hasta" placeholder='Ingrese valor' class='form-control'>
                            <!-- <a href='#' class='flt-clear pull-right text-red'><small><i class='fa fa-trash-o'></i> Limpiar </small></a> -->
                        </div>
                    <?php } ?>
                    <?php if (isset($calendarioDesde) && $calendarioDesde) { ?>
                        <div class="form-group">
                            <label for="datepickerDesde">Fecha desde:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datepicker" id="datepickerDesde" name="datepickerDesde" placeholder="Seleccione fecha">
                            </div>
                            <!-- <a href='#' class='flt-clear pull-right text-red'><small><i class='fa fa-trash-o'></i> Limpiar </small></a> -->
                            <!-- <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control datemask" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask id="datepickerDesde" name="datepickerDesde">
                            </div> -->
                        </div>
                        <!-- <br><br> -->
                    <?php } ?>
                    <?php if (isset($calendarioHasta) && $calendarioHasta) { ?>
                        <div class="form-group">
                            <label for="datepickerHasta">Fecha hasta:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datepicker" id="datepickerHasta" name="datepickerHasta" placeholder="Seleccione fecha">
                            </div>
                            <!-- <a href='#' class='flt-clear pull-right text-red'><small><i class='fa fa-trash-o'></i> Limpiar </small></a> -->
                            <!-- <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control datemask" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask id="datepickerHasta" name="datepickerHasta">
                            </div> -->
                        </div>
                        <!-- <input type="text" value="-100,100" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="green" data-value="-100,100" style="display: none;"> -->
                    <?php } ?>
                    <br>
                    <!-- <div class="form-group">
                        <label>Rango Fechas:</label>
                        <div class="input-group">
                        <button type="button" class="btn btn-default pull-right form-control" id="daterange-btn">
                            <span>
                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;Seleccione &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
                            </span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                        </div>
                    </div>                     -->
                    <!-- <div class="form-group">
                    <a href='#' class='flt-clear pull-right text-red'><small><i class='fa fa-trash-o'></i> Limpiar Todo</small></a>
                </div>
                <br> -->
                    <div class="form-group">
                        <button type="button" value="Limpiar" class="btn btn-block btn-danger btn-flat flt-clear">Limpiar Todo</button>
                        <button type="button" value="Filtrar" class="btn btn-block btn-success btn-flat" onclick="filtrar()">Filtrar</button>
                        <input type="hidden" value="<?php echo $op ?>" id="op" hidden="true">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- bootstrap datepicker -->

<script>    

    $('.flt-clear').click(function() {
        $('#formulario')[0].reset();
        // $('.report-content')[0].reset();        
    });

    //Initialize Select2 Elements
    // $('.select2').select2()

    //Date range picker
    // $('#reservation').daterangepicker()
    //Date range picker with time picker
    // $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'MM/DD/YYYY hh:mm A' }})
    //Date range as a button
    // $('#daterange-btn').daterangepicker(
    //   {
    //     ranges   : {
    //       'Hoy'       : [moment(), moment()],
    //       'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //       'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
    //       'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
    //       'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
    //       'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //     },
    //     startDate: moment().subtract(29, 'days'),
    //     endDate  : moment()
    //   },
    //   function (start, end) {
    //     $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    //   }
    // )

    $('.datepicker').datepicker({
        autoclose: true
    })

    //Datemask dd/mm/yyyy
    // $('.datemask').inputmask('dd/mm/yyyy', {
    //     'placeholder': 'dd/mm/yyyy'
    // })

    function filtrar() {
        var data = new FormData($('#formulario')[0]);
        data = formToObject(data);
        console.log(data);
        wo();
        // $('#reportContent').remove();
        var url = $('#op').val();
        $.ajax({
            type: 'POST',

            data: {
                data
            },
            url: 'Reportes/' + url,
            success: function(result) {
                // $('#reportContent').remove();
                // $('#reportContent').add('reportContentFiltrado');
                //  alert('OK');
                console.log(result);
                $('#reportContent').empty();
                $('#reportContent').html(result);
            },
            error: function() {
                alert('Error');
            },
            complete: function(data) {
                wc();
            }
        });
    }
</script>
