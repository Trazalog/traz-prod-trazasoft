       <!-- jQuery 3 -->
       <script src="<?php echo base_url()?>lib/bower_components/jquery/dist/jquery.min.js"></script>
       <!-- jQuery UI 1.11.4 -->
       <script src="<?php echo base_url()?>lib/bower_components/jquery-ui/jquery-ui.min.js"></script>
       <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
       <script>
$.widget.bridge('uibutton', $.ui.button);
       </script>
       <!-- Bootstrap 3.3.7 -->
       <script src="<?php echo base_url()?>lib/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
       <!-- iCheck -->
       <link rel="stylesheet" href="<?php  echo base_url();?>lib/plugins/iCheck/all.css">
       <script src="<?php  echo base_url();?>lib/plugins/iCheck/icheck.min.js"></script>
       <!-- jQuery Knob Chart -->
       <script src="<?php echo base_url()?>lib/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
       <!-- daterangepicker -->
       <script src="<?php echo base_url()?>lib/bower_components/moment/min/moment.min.js"></script>

       <script src="<?php echo base_url()?>lib/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
       <!-- datepicker -->
       <script src="<?php echo base_url()?>lib/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
       </script>
       <!-- Bootstrap WYSIHTML5 -->
       <script src="<?php echo base_url()?>lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
       <!-- Slimscroll -->
       <script src="<?php echo base_url()?>lib/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
       <!-- FastClick -->
       <script src="<?php echo base_url()?>lib/bower_components/fastclick/lib/fastclick.js"></script>

       <script src="<?php echo base_url()?>lib/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>

       <script src="<?php echo base_url()?>lib/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
       <!-- AdminLTE App -->
       <script src="<?php echo base_url()?>lib/dist/js/adminlte.min.js"></script>
       <script type="text/javascript"
           src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>

       <script src="<?php base_url();?>lib/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
      
      
       <!--Datatables-->
       <script src="<?php base_url() ?>lib/bower_components/datatables1/datatables.js"></script>
       <script src="<?php base_url() ?>lib/bower_components/datatables1/dataTables.bootstrap.min.js"></script>


       <!-- Select2 -->
       <script src="<?php echo base_url()?>lib/bower_components/select2/dist/js/select2.full.min.js"></script>
       <!-- <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script> -->
       <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
       <!-- <script src="<?php echo base_url()?>lib/dist/js/pages/dashboard.js"></script> -->
       <!-- AdminLTE for demo purposes -->
       <!-- <script src="<?php echo base_url()?>lib/dist/js/demo.js"></script> -->
       <!--Arma Tablas -->
       <script src="<?php echo base_url('lib/props/tabla.js'); ?>"></script>
       <!--Validator
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>-->

       <script>
function conexion() {
    return true;
}

function mdlClose(id = false) {
    if (id) $('#' + id).modal('hide');
    else {
        $('.modal').modal('hide');
    }
    $('.modal-backdrop').remove();
}

function showFD(formData) {
    for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }
}

function mergeFD(f1, f2) {
    for (var pair of f2.entries()) {
        f1.append(pair[0], pair[1]);
    }
    return f1;
}
       </script>

       <?php 
        $this->load->view(FRM . 'scripts');
        ?>