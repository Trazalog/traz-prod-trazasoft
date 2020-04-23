<ul class="sidebar-menu menu tree" data-widget="tree">
	<li class="header"></li>
	<li><a class="link" href="#" data-link="traz-comp-bpm/Tarea"><i class="fa fa-list-alt"></i>Mis Tareas</a></li>
	<?php $this->load->view('layout/aux_menu_alm') ?>

	<!-- <li><a class="link" href="#" data-link="general/Etapa/fraccionar"><i class="fa fa-circle-o"></i>Fraccionar</a></li> -->

	<li class="treeview">
		<a href="#">
			<i class="fa fa-fw fa-tasks"></i> <span>Producción</span>
			<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
			</span>
		</a>
		<ul class="treeview-menu">
			<li><a class="link" href="#" data-link="general/Etapa"><i class="fa fa-sitemap"></i>Producción de Lotes</a></li>
			<li><a class="link" href="#" data-link="general/Reporte/tareasOperario"><i class="fa fa-arrow-left"></i>Prod. de Lotes | Operario</a>
			</li>
			<li><a class="link" href="#" data-link="general/Formula"><i class="fa fa-magic"></i>Fórmulas</a>
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
			<li><a class="link" href="#" data-link="general/Camion/recepcionCamion"><i class="fa fa-exchange"></i> Entrada | Recepción</a></li>
			<li><a class="link" href="#" data-link="general/Camion/cargarCamion"><i class="fa fa-upload"></i>Carga
					Camión</a>
			</li>
			<li><a class="link" href="#" data-link="general/Camion/salidaCamion"><i class="fa fa-download"></i>Descarga
					Camión</a></li>
			<li><a class="link" href="#" data-link="general/Camion/salidaCamion"><i class="fa  fa-external-link"></i>Salida Camion</a>
			</li>
			<li><a class="link" href="#" data-link="general/Camion/cargadeCamion"><i class="fa fa-list-ul"></i>Listado
					Carga
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
			<li><a href="#" class="link" data-link="Reportes/produccion"><i class="fa fa-bar-chart-o"></i>Producción</a></li>
			<li><a href="#" class="link" data-link="Reportes/prodResponsable"><i class="fa fa-bar-chart-o"></i>Prod. Responsable</a></li>
			<!-- <li><a href="#" class="link" data-link="Reportes/tarjetas"><i class="fa fa-circle-o"></i>Tarjetas</a></li> -->
		</ul>
	</li>
	<!-- <li><a class="link" href="#" data-link="general/CodigoQR/generarQR"><i class="fa fa-qrcode"></i>Código QR</a>
	</li> -->
</ul>
||
