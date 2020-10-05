<ul class="sidebar-menu menu tree" data-widget="tree">
  <li class="header"></li>
  <li><a class="link" href="#" data-link="traz-comp-bpm/Proceso"><i class="fa fa-list-alt"></i>Mis Tareas</a></li>
  <?php $this->load->view('layout/aux_menu_alm') ?>



  <li class="treeview">
    <a href="#">
      <i class="fa fa-fw fa-tasks"></i> <span>Producción</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Etapa"><i class="fa fa-sitemap"></i>Producción de Lotes</a></li>
      <li><a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Reporte/tareasOperario"><i class="fa fa-arrow-left"></i>Prod. de Lotes | Operario</a>
      </li>
      <li><a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Formula"><i class="fa fa-magic"></i>Fórmulas</a>
      </li>
      <li>
        <a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Establecimiento/asignarAEstablecimiento"><i class="fa fa-database"></i>Configurar establecimientos</a>
      </li>
      <li><a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Lote/informeTrazabilidad"><i class="fa fa-sort-amount-desc"></i>Trazabilidad</a></li>
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
      <li><a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Camion/recepcionCamion"><i class="fa fa-exchange"></i> Entrada | Recepción</a></li>
      <li><a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Camion/cargarCamion"><i class="fa fa-upload"></i>Carga camión</a></li>
      <li><a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Camion/salidaCamion"><i class="fa fa-download"></i>Descarga camión</a></li>
      <li><a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Camion/salidaCamion"><i class="fa  fa-external-link"></i>Salida camión</a></li>
      <li><a class="link" href="#" data-link="<?php echo base_url(PRD) ?>general/Camion/cargadeCamion"><i class="fa fa-list-ul"></i>Listado carga camión</a></li>
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
      <!-- <li><a href="#" class="link" data-link="Reportes/index"><i class="fa fa-fw fa-genderless"></i>Ejemplo</a></li> -->
      <li><a href="#" class="link" data-link="Reportes/produccion"><i class="fa fa-fw fa-genderless"></i>Producción</a></li>
      <li><a href="#" class="link" data-link="Reportes/prodResponsable"><i class="fa fa-fw fa-genderless"></i>Prod. Responsable</a></li>
      <li><a href="#" class="link" data-link="Reportes/ingresos"><i class="fa fa-fw fa-genderless"></i>Ingresos</a></li>
      <li><a href="#" class="link" data-link="Reportes/asignacionDeRecursos"><i class="fa fa-fw fa-genderless"></i>Asignación de recursos</a></li>
      <li><a href="#" class="link" data-link="Reportes/salidas"><i class="fa fa-fw fa-genderless"></i>Salidas</a></li>
      <!-- <li><a href="#" class="link" data-link="Reportes/tarjetas"><i class="fa fa-fw fa-genderless"></i>Tarjetas</a></li> -->
    </ul>
  </li>

	<li><a class="link" href="#" data-link="<?php echo TST ?>Tarea"><i class="fa fa-tasks"></i>ABM Tareas</a></li>
</ul>
||
