<div class="row">
    <div class="col-md-6">
        <div class="box box-primary ">
            <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">
                    Componente Tareas
                </h3>
            </div>
            <div class="box-body">
                <div class="input-group">
                    <input list="plantillas" id="plantilla" class="form-control" placeholder="- Seleccionar Plantilla -"
                        autocomplete="off">
                    <datalist id="plantillas">
                        <?php
                            foreach ($plantillas as $o) {
                                echo "<option value='$o->nombre' data-json='" . json_encode($o->tareas) . "'>$o->descripcion</option>";
                            }
                            ?>
                    </datalist>
                    <span class="input-group-btn">
                        <button class='btn btn-primary' data-toggle="modal" data-target="#modal_articulos">
                            <i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div><br>
                <div class="table">
                    <table class="table table-striped table-hover">
                        <tbody id="tareas-plantilla">

                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary btn-sm" style="float:right">Agregar Todas</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-list"></i>
                <h3 class="box-title">
                    Lista de Tareas
                </h3>
            </div>
            <div class="box-body">
                <div class="box box-primary box-solid collapsed-box colapse">
                    <div class="box-header with-border"
                        onclick="if($(this).parent().hasClass('collapsed-box'))$(this).parent().removeClass('collapsed-box'); else $(this).parent().addClass('collapsed-box');">
                        <i class="fa fa-plus mr-1"></i>
                        <h3 class="box-title">Crear Nueva Tarea</h3>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php $this->load->view(TSK . 'add')?>
                    </div>
                    <!-- /.box-body -->
                </div>
                <ul id="lista-tareas" class="todo-list ui-sortable">

                </ul>
            </div>
        </div>
    </div>
</div>







<script>
var tareas = <?php echo json_encode($tareas) ?>;
var subtareas = <?php echo json_encode($subtareas) ?>;
var tablaTareas = $('#tareas-plantilla');

$('#plantilla').on('change', function() {
    var json = $('#plantillas').find('[value="' + this.value + '"]').attr('data-json');
    mostrarTareas(json);
});

mostrarTareas(false);

function mostrarTareas(item) {
    tablaTareas.empty();
    var tareas_plantilla = JSON.parse(item);
    var html = '';

    tareas.forEach(e => {
        console.log(e);
        
        if (!tareas_plantilla || tareas_plantilla.includes(parseInt(e.id))) {
             var subtask = '';
             e.subtareas.forEach(function(s,i) {
                  subtask = subtask + '<li><a href="#"><b>'+ (i+1) + ') </b> ' +subtareas[s].nombre+'</a></li>';
            });

            html = html +
                `<tr>
                    <td width="5%" class="text-left" onclick='agregarTarea(${JSON.stringify(e)})'><i class="text-primary fa fa-plus"></i></td>
                    <td>${e.nombre}</td>
                    <td class="text-right"><small class="label label-default"><i class="fa fa-clock-o"></i> ${e.duracion}</small></td>
                    <td width="5%" class="text-right">
                        <div class="input-group-btn"> 
                            <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">
                            <span class="fa fa-angle-right"></span></button>
                            <ul class="dropdown-menu subtareas">
                              <li><a href="#">Subtareas Asociadas</a></li>
                              <li role="presentation" class="divider"></li>
                             ${subtask}
                            </ul>
                        </div>
                    </td>
                </tr>`;
        }
    });

    tablaTareas.append(html);
}
</script>
