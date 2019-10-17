<div class="box box-primary">
    <div class="box-header">
        <i class="ion ion-clipboard"></i>
        <h3 class="box-title">
            Componente Tareas
        </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <div class="form-group">
                            <label>Seleccionar Plantilla:</label>
                            <select id="plantillas" class="form-control">
                                <option value="false">Mostrar Todas las Tareas</option>
                                <?php
                                    foreach ($plantillas as $o) {
                                        echo "<option value='".json_encode($o->tareas)."'>$o->nombre</option>";
                                    }
                                ?>
                            </select>
                        </div> -->
                        <div class="input-group">
                            <input list="plantillas" id="plantilla" class="form-control"
                                placeholder="- Seleccionar Plantilla -" autocomplete="off">
                            <datalist id="plantillas">
                                <?php
                                        foreach ($plantillas as $o) {
                                            echo "<option value='" . json_encode($o->tareas) . "'>$o->nombre</option>";
                                        }
                                     ?>
                            </datalist>
                            <span class="input-group-btn">
                                <button class='btn btn-primary' data-toggle="modal" data-target="#modal_articulos">
                                    <i class="glyphicon glyphicon-search"></i></button>
                            </span>

                        </div>
                        <!-- <button class="btn btn-primary " onclick="$('#add-panel').show()"> Nueva Tarea</button> -->
                                <a href="#" class="pull-right"><i class="fa fa-plus"></i> Nueva Tarea</a>

                    </div>
                </div>

                <div class="table-responsive" style="overflow-y:scroll;margin:auto; height:200px;">
                    <table class="table table-striped table-hover">
                        <tbody id="tareas-plantilla">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add-panel" style="display:none">
    <?php $this->load->view(TSK.'add') ?>
</div>

<div class="box box-primary">
    <div class="row">
        <div class="col-md-6">
            <div class="box-header">
                <i class="fa fa-list"></i>
                <h3 class="box-title">
                    Lista de Tareas
                </h3>
            </div>
            <div class="box-body">
                <ul id="lista-tareas" class="todo-list ui-sortable">

                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box-header">
                <i class="fa fa-list"></i>
                <h3 class="box-title">
                    Lista de Subtareas
                </h3>
            </div>
            <div class="box-body">
                <ul id="lista-tareas" class="todo-list ui-sortable">

                </ul>
            </div>
        </div>
    </div>
</div>

<script>
var tareas = JSON.parse('<?php echo json_encode($tareas) ?>');
var tablaTareas = $('#tareas-plantilla');

$('#plantillas').on('change', function() {
    mostrarTareas(this.value);
});

mostrarTareas(false);

function mostrarTareas(item) {
    tablaTareas.empty();
    var tareas_plantilla = JSON.parse(item);
    var html = '';
    tareas.forEach(e => {
        if (!tareas_plantilla || tareas_plantilla.includes(parseInt(e.id))) {
            html = html +
                `<tr><td>${e.nombre}</td><td><small class="label label-default"><i class="fa fa-clock-o"></i> ${e.duracion}</small></td><td class="text-right" onclick='agregarTarea(${JSON.stringify(e)})'><i class="text-primary fa fa-plus"></i></td></tr>`;
        }
    });

    tablaTareas.append(html);
}
</script>