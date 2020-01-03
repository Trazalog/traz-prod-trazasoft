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
                    <div class="form-group">
                        <label>Rango Fechas:</label>
                        <div class="input-group">
                        <button type="button" class="btn btn-default pull-right form-control" id="daterange-btn">
                            <span>
                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;Seleccione &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
                            </span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                        </div>
                    </div>                    
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
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'MM/DD/YYYY hh:mm A' }})
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Hoy'       : [moment(), moment()],
          'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
          'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
          'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
          'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

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
<!-- <div class="datepicker datepicker-dropdown dropdown-menu datepicker-orient-left datepicker-orient-bottom" style="top: 491px; left: 810px; z-index: 10; display: block;">
    <div class="datepicker-days" style="">
        <table class="table-condensed">
            <thead>
                <tr>
                    <th colspan="7" class="datepicker-title" style="display: none;"></th>
                </tr>
                <tr>
                    <th class="prev">«</th>
                    <th colspan="5" class="datepicker-switch">March 2019</th>
                    <th class="next">»</th>
                </tr>
                <tr>
                    <th class="dow">Su</th>
                    <th class="dow">Mo</th>
                    <th class="dow">Tu</th>
                    <th class="dow">We</th>
                    <th class="dow">Th</th>
                    <th class="dow">Fr</th>
                    <th class="dow">Sa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="old day" data-date="1550966400000">24</td>
                    <td class="old day" data-date="1551052800000">25</td>
                    <td class="old day" data-date="1551139200000">26</td>
                    <td class="old day" data-date="1551225600000">27</td>
                    <td class="old day" data-date="1551312000000">28</td>
                    <td class="day" data-date="1551398400000">1</td>
                    <td class="day" data-date="1551484800000">2</td>
                </tr>
                <tr>
                    <td class="day" data-date="1551571200000">3</td>
                    <td class="day" data-date="1551657600000">4</td>
                    <td class="day" data-date="1551744000000">5</td>
                    <td class="day" data-date="1551830400000">6</td>
                    <td class="day" data-date="1551916800000">7</td>
                    <td class="day" data-date="1552003200000">8</td>
                    <td class="day" data-date="1552089600000">9</td>
                </tr>
                <tr>
                    <td class="day" data-date="1552176000000">10</td>
                    <td class="day" data-date="1552262400000">11</td>
                    <td class="day" data-date="1552348800000">12</td>
                    <td class="day" data-date="1552435200000">13</td>
                    <td class="day" data-date="1552521600000">14</td>
                    <td class="day" data-date="1552608000000">15</td>
                    <td class="day" data-date="1552694400000">16</td>
                </tr>
                <tr>
                    <td class="day" data-date="1552780800000">17</td>
                    <td class="day" data-date="1552867200000">18</td>
                    <td class="day" data-date="1552953600000">19</td>
                    <td class="day" data-date="1553040000000">20</td>
                    <td class="day" data-date="1553126400000">21</td>
                    <td class="day" data-date="1553212800000">22</td>
                    <td class="day" data-date="1553299200000">23</td>
                </tr>
                <tr>
                    <td class="day" data-date="1553385600000">24</td>
                    <td class="day" data-date="1553472000000">25</td>
                    <td class="day" data-date="1553558400000">26</td>
                    <td class="day" data-date="1553644800000">27</td>
                    <td class="day" data-date="1553731200000">28</td>
                    <td class="day" data-date="1553817600000">29</td>
                    <td class="day" data-date="1553904000000">30</td>
                </tr>
                <tr>
                    <td class="day" data-date="1553990400000">31</td>
                    <td class="new day" data-date="1554076800000">1</td>
                    <td class="new day" data-date="1554163200000">2</td>
                    <td class="new day" data-date="1554249600000">3</td>
                    <td class="new day" data-date="1554336000000">4</td>
                    <td class="new day" data-date="1554422400000">5</td>
                    <td class="new day" data-date="1554508800000">6</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" class="today" style="display: none;">Today</th>
                </tr>
                <tr>
                    <th colspan="7" class="clear" style="display: none;">Clear</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="datepicker-months" style="display: none;">
        <table class="table-condensed">
            <thead>
                <tr>
                    <th colspan="7" class="datepicker-title" style="display: none;"></th>
                </tr>
                <tr>
                    <th class="prev">«</th>
                    <th colspan="5" class="datepicker-switch">2019</th>
                    <th class="next">»</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7"><span class="month">Jan</span><span class="month">Feb</span><span class="month focused">Mar</span><span class="month">Apr</span><span class="month">May</span><span class="month">Jun</span><span class="month">Jul</span><span class="month">Aug</span><span class="month">Sep</span><span class="month">Oct</span><span class="month">Nov</span><span class="month">Dec</span></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" class="today" style="display: none;">Today</th>
                </tr>
                <tr>
                    <th colspan="7" class="clear" style="display: none;">Clear</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="datepicker-years" style="display: none;">
        <table class="table-condensed">
            <thead>
                <tr>
                    <th colspan="7" class="datepicker-title" style="display: none;"></th>
                </tr>
                <tr>
                    <th class="prev">«</th>
                    <th colspan="5" class="datepicker-switch">2010-2019</th>
                    <th class="next">»</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7"><span class="year old">2009</span><span class="year">2010</span><span class="year">2011</span><span class="year">2012</span><span class="year">2013</span><span class="year">2014</span><span class="year">2015</span><span class="year">2016</span><span class="year">2017</span><span class="year">2018</span><span class="year focused">2019</span><span class="year new">2020</span></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" class="today" style="display: none;">Today</th>
                </tr>
                <tr>
                    <th colspan="7" class="clear" style="display: none;">Clear</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="datepicker-decades" style="display: none;">
        <table class="table-condensed">
            <thead>
                <tr>
                    <th colspan="7" class="datepicker-title" style="display: none;"></th>
                </tr>
                <tr>
                    <th class="prev">«</th>
                    <th colspan="5" class="datepicker-switch">2000-2090</th>
                    <th class="next">»</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7"><span class="decade old">1990</span><span class="decade">2000</span><span class="decade focused">2010</span><span class="decade">2020</span><span class="decade">2030</span><span class="decade">2040</span><span class="decade">2050</span><span class="decade">2060</span><span class="decade">2070</span><span class="decade">2080</span><span class="decade">2090</span><span class="decade new">2100</span></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" class="today" style="display: none;">Today</th>
                </tr>
                <tr>
                    <th colspan="7" class="clear" style="display: none;">Clear</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="datepicker-centuries" style="display: none;">
        <table class="table-condensed">
            <thead>
                <tr>
                    <th colspan="7" class="datepicker-title" style="display: none;"></th>
                </tr>
                <tr>
                    <th class="prev">«</th>
                    <th colspan="5" class="datepicker-switch">2000-2900</th>
                    <th class="next">»</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7"><span class="century old">1900</span><span class="century focused">2000</span><span class="century">2100</span><span class="century">2200</span><span class="century">2300</span><span class="century">2400</span><span class="century">2500</span><span class="century">2600</span><span class="century">2700</span><span class="century">2800</span><span class="century">2900</span><span class="century new">3000</span></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" class="today" style="display: none;">Today</th>
                </tr>
                <tr>
                    <th colspan="7" class="clear" style="display: none;">Clear</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div> -->