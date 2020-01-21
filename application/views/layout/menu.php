<ul class="sidebar-menu menu tree" data-widget="tree">
    <li class="header"></li>
    <li><a class="link" href="#" data-link="traz-comp-bpm/Tarea"><i class="fa fa-list-alt"></i>Mis Tareas</a></li>
    <?php   $this->load->view('layout/aux_menu_alm') ?>

    <!-- <li><a class="link" href="#" data-link="general/Etapa/fraccionar"><i class="fa fa-circle-o"></i>Fraccionar</a></li> -->

    <li class="treeview">
        <a href="#">
            <i class="fa fa-fw fa-tasks"></i> <span>Producción</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a class="link" href="#" data-link="general/Etapa"><i class="fa fa-sitemap"></i>Etapas</a></li>
            <li><a class="link" href="#" data-link="general/Reporte/tareasOperario"><i
                        class="fa fa-arrow-left"></i>Producción</a>
            </li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-fw fa-truck"></i> <span>Logística</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a class="link" href="#" data-link="general/Camion/salidaCamion"><i
                        class="fa  fa-external-link"></i>Salida Camion</a>
            </li>
            <li><a class="link" href="#" data-link="general/Camion/cargarCamion"><i class="fa fa-upload"></i>Cargar
                    Camión</a>
            </li>
            <li><a class="link" href="#" data-link="general/Camion/salidaCamion"><i class="fa fa-download"></i>Descarga
                    Camión</a></li>
            <li><a class="link" href="#" data-link="general/Camion/recepcionCamion"><i class="fa fa-exchange"></i>Carga
                    |
                    Recepción</a>
            <li><a class="link" href="#" data-link="general/Camion/cargadeCamion"><i
                        class="fa fa-list-ul"></i>Listado Carga
                    Camion</a>
            </li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-fw fa-bar-chart"></i> <span>Reportes</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
            <!-- <li><a href="#" class="link" data-link="Reportes/index"><i class="fa fa-circle-o"></i>Ejemplo</a></li> -->
            <li><a href="#" class="link" data-link="Reportes/produccion"><i class="fa fa-circle-o"></i>Producción</a>
            </li>
            <li><a href="#" class="link" data-link="Reportes/prodResponsable"><i class="fa fa-circle-o"></i>Prod.
                    Responsable</a></li>
        </ul>
    </li>
</ul>
||