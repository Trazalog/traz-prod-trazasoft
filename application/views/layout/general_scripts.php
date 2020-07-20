       <!-- jQuery 3 -->
       <script src="<?php echo base_url() ?>lib/bower_components/jquery/dist/jquery.min.js"></script>
       <!-- jQuery UI 1.11.4 -->
       <script src="<?php echo base_url() ?>lib/bower_components/jquery-ui/jquery-ui.min.js"></script>
       <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
       <script>
$.widget.bridge('uibutton', $.ui.button);
       </script>
       <!-- Bootstrap 3.3.7 -->
       <script src="<?php echo base_url() ?>lib/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
       <!-- iCheck -->
       <link rel="stylesheet" href="<?php echo base_url(); ?>lib/plugins/iCheck/all.css">
       <script src="<?php echo base_url(); ?>lib/plugins/iCheck/icheck.min.js"></script>
       <!-- jQuery Knob Chart -->
       <script src="<?php echo base_url() ?>lib/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
       <!-- daterangepicker -->
       <!-- <script src="<--?php echo base_url() ?>lib/bower_components/moment/min/moment.min.js"></script> -->

       <!-- <script src="<--?php echo base_url() ?>lib/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->
       <!-- datepicker -->
       <!-- <script src="<--?php echo base_url() ?>lib/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->
       <!-- Bootstrap WYSIHTML5 -->
       <script src="<?php echo base_url() ?>lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
       <!-- Slimscroll -->
       <script src="<?php echo base_url() ?>lib/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
       <!-- FastClick -->
       <script src="<?php echo base_url() ?>lib/bower_components/fastclick/lib/fastclick.js"></script>


       <!-- Datatbles -->

       <script src="<?php echo base_url() ?>lib/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>

       <script src="<?php echo base_url() ?>lib/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js">
       </script>

       <!-- AdminLTE App -->
       <script src="<?php echo base_url() ?>lib/dist/js/adminlte.min.js"></script>
       <script type="text/javascript"
           src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>

       <!-- <script src="<--?php base_url(); ?>lib/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script> -->

       <!-- Moment Date Time -->
       <!-- <script src="<--?php base_url(); ?>lib/plugins/moment-datetime/moment.min.js"></script> -->

       <!-- Select2 -->
       <script src="<?php echo base_url() ?>lib/bower_components/select2/dist/js/select2.full.min.js"></script>
       <!-- <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script> -->
       <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
       <!-- <script src="<?php echo base_url() ?>lib/dist/js/pages/dashboard.js"></script> -->
       <!-- AdminLTE for demo purposes -->
       <!-- <script src="<?php echo base_url() ?>lib/dist/js/demo.js"></script> -->
       <!--Arma Tablas -->
       <script src="<?php echo base_url('lib/props/tabla.js'); ?>"></script>
       <script src="<?php echo base_url(); ?>lib\props\busqueda_avanzada.js"></script>

       <script src="<?php echo base_url(); ?>lib\props\snapshot.js"></script>
       <!--Impresión -->
       <script src="<?php echo base_url(); ?>lib/props/Impresora.js"></script>
       <script src="<?php echo base_url(); ?>lib\props\navegacion.js"></script>

       <!-- SWAL ALERT -->
       <script src="<?php echo base_url(LIB) ?>swal/dist/sweetalert2.min.js"></script>


       <script>
    function conf(fun, e, pregunta = 'Confirma realizar esta acción?', msj = "Esta acción no se pordrá revertir") {
        Swal.fire({
            title: pregunta,
            text: msj,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
        }).then((result) => {
            if (result.value) {
                fun(e);
            }
        });
    }

function hecho() {
    alert('Hecho');
}

function error() {
    alert('Error')
}

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

function _isset(variable) {
    if (typeof(variable) == "undefined" || variable == null)
        return false;
    else
    if (typeof(variable) == "object" && !variable.length)
        return false;
    else
        return true;
}

window.mobileAndTabletcheck = function() {
    var check = false;
    (function(a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i
            .test(a) ||
            /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
            .test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};
       </script>




       <?php
        $this->load->view(FRM . 'scripts');
        ?>