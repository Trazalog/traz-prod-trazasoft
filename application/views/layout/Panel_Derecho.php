  <!-- Control Sidebar -->
  <aside id="panel-derecho" class="control-sidebar control-sidebar-dark">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li class="active">
              <a href="#control-sidebar-home-tab" data-toggle="tab" class="col-md-10"><i class="fa fa-cogs"></i> Panel de
                  Opciones</a>
              <a href="#" class="col-md-2" id="closePanel"><i class="fa fa-close text-red fa-lg"></i></a>
          </li>
          <!-- <li>
              <a href="#"><i class="fa fa-close col-md-1"></i></a>
          </li> -->
          <!-- <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li> -->
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
              <h3 class="control-sidebar-heading">Aplicar Filtro:</h3>
              <div id="panel-derecho-body"></div>
          </div>
          <!-- /.tab-pane -->
      </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's backgr -->
  <div class="control-sidebar-bg"></div>


  <script>
      //   function openPanel() {
      //       if ($('.control-sidebar').hasClass('control-sidebar-open')) {
      //           $('.control-sidebar').removeClass('control-sidebar-open');
      //       } else {
      //           $('.control-sidebar').addClass('control-sidebar-open');
      //       }
      //   }
      $('#panelFiltro').click(function() {
          $('#panel-derecho').addClass('control-sidebar-open');
      });
      $('#closePanel').click(function() {
          $('#panel-derecho').removeClass('control-sidebar-open');
      });

    //   $(document).click(function(e) {
    //       var container = $("#panel-derecho");

    //       // if the target of the click isn't the container nor a descendant of the container
    //       if (!container.is(e.target) && container.has(e.target).length === 0) {
    //           container.removeClass('control-sidebar-open');
    //       }
    //   });
  </script>
  <!-- <script>
      if ($('.control-sidebar').hasClass('control-sidebar-open')) {
          $('.control-sidebar').removeClass('control-sidebar-open');
      } else {
          $('.control-sidebar').addClass('control-sidebar-open');
      }
  </script> -->