<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Trazalog Tools</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>lib/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>lib/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>lib/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url() ?>lib/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url() ?>lib/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet"
        href="<?php echo base_url()?>lib/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet"
        href="<?php echo base_url() ?>lib/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

    <link rel="stylesheet" href="<?php base_url() ?>lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="<?php base_url() ?>lib/bower_components/bootstrap-daterangepicker/daterangepicker.css">

    <!-- Bootstrap datetimepicker -->
    <link rel="stylesheet"
        href="<?php echo base_url()?>lib/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>lib/bower_components/select2/dist/css/select2.min.css">

    <link rel="stylesheet" href="<?php base_url();?>application/css/etapa/list.css">

    <link rel="stylesheet"
        href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css" />

    <link rel="stylesheet" href="<?php echo base_url() ?>lib/bower_components/select2/dist/css/boostrap.css">
    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


 

</head>

<?php $this->load->view('layout/wait') ?>


<body class="hold-transition skin-blue sidebar-mini">
    <div id="frm-list"></div>
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="#" class="logo" onclick="linkTo()">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>TST</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Trazalog Tools</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <?php 
      
        $this->load->view('layout/perfil');
      
      ?>


            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?php 
             
                $this->load->view('layout/menu');
            ?>

            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section id="content" class="content">





            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b>1.0
            </div>
            <!--<strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved. -->
        </footer>
        <?php $this->load->view('layout/general_scripts') ?>
        <?php
          $this->load->view("layout/Panel_Derecho");
        ?>

    </div>
    <!-- ./wrapper -->

 

    <script>
    linkTo("<?php echo DEFAULT_VIEW ?>");

    function collapse(e) {
        e = $(e).closest('.box');

        if (e.hasClass('collapsed-box')) {
            $(e).removeClass('collapsed-box');
        } else {
            $(e).addClass('collapsed-box');
        }

    }

    jQuery.fn.single_double_click = function(single_click_callback, double_click_callback, timeout) {
        return this.each(function() {
            var clicks = 0,
                self = this;
            jQuery(this).click(function(event) {
                clicks++;
                if (clicks == 1) {
                    setTimeout(function() {
                        if (clicks == 1) {
                            single_click_callback.call(self, event);
                        } else {
                            double_click_callback.call(self, event);
                        }
                        clicks = 0;
                    }, timeout || 300);
                }
            });
        });
    }
    </script>

</body>

</html>