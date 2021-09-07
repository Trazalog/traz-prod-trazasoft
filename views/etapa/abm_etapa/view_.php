<!-- /// ---- HEADER ----- /// -->
<div class="box box-primary animated fadeInLeft">
  <div class="box-header with-border">
    <h4>Etapas Productivas</h4>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-2 col-lg-1 col-xs-12">
        <button type="button" id="botonAgregar" class="btn btn-primary" aria-label="Left Align">
          Agregar
        </button><br>
      </div>
      <div class="col-md-10 col-lg-11 col-xs-12">
      </div>
    </div>
  </div>
</div>
<!-- /// ----- HEADER -----/// -->

<!---///--- BOX 1 NUEVO ---///----->
<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
  <div class="box-header with-border">
    <div class="box-tittle">
      <h4>Nueva Etapa Productiva</h4>
    </div>
    <div class="box-tools pull-right border ">
      <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
          data-toggle="tooltip" title="" data-original-title="Remove">
        <i class="fa fa-times"></i>
      </button>
    </div>
  </div>
  <!--_____________________________________________-->
  <div class="box-body">
    <form class="formEtapas" id="formEtapas">
      <!--Nombre-->
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
          <label for="nombre">Nombre <strong style="color: #dd4b39">*</strong>:</label>
          <input type="text" id="nombre" name="nombre" class="form-control requerido" placeholder="Ingrese Nombre...">
        </div>
      </div>
      <!--________________-->
      <!--Proceso Productivo-->
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
          <label for="proc_id">Proceso Productivo<strong style="color: #dd4b39">*</strong>:</label>
          <select type="text" id="proc_id" name="proc_id" class="form-control selec_habilitar requerido" >
            <option value="-1" disabled selected>-Seleccione opción-</option>
            <?php
              foreach ($listarProcesos as $proceso) {
                echo '<option  value="'.$proceso->proc_id.'">'.$proceso->nombre.'</option>';
              }
            ?>
          </select>
        </div>
      </div>
      <!--________________-->
      <!--Tipo-->
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
          <label for="tiet_id">Tipo<strong style="color: #dd4b39">*</strong>:</label>
          <select type="text" id="tiet_id" name="tiet_id" class="form-control selec_habilitar requerido" >
            <option value="-1" disabled selected>-Seleccione opción-</option>
            <?php
              foreach ($listarTipos as $tipo) {
                echo '<option value="'.$tipo->tabl_id.'">'.$tipo->valor.'</option>';
              }
            ?>
          </select>
        </div>
      </div>
      <!--________________-->
      <!--Recipiente-->
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
          <label for="nom_recipiente">Recipiente <strong style="color: #dd4b39">*</strong>:</label>
          <input type="text" id="nom_recipiente" name="nom_recipiente" class="form-control requerido" placeholder="Ingrese Codigo...">
        </div>
      </div>
      <!--________________-->
      <!--Orden-->
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
          <label for="orden">Orden <strong style="color: #dd4b39">*</strong>:</label>
          <input type="number" id="orden" name="orden" class="form-control requerido" placeholder="Ingrese Orden...">
        </div>
      </div>
      <!--________________-->
      <!--Formulario-->
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
          <label for="form_id">Formulario :</label>
          <select type="text" id="form_id" name="form_id" class="form-control selec_habilitar requerido" >
            <option value="-1" disabled selected>-Seleccione opción-</option>
            <?php
              foreach ($listarFormularios as $formulario) {
                echo '<option  value="'.$formulario->form_id.'">'.$formulario->nombre.'</option>';
              }
            ?>
          </select>
        </div>
      </div>
      <!--________________-->
    </form>
  </div>
  <!--_________________ GUARDAR_________________-->
  <div class="modal-footer">
    <div class="form-group text-right">
      <button type="button" class="btn btn-primary" onclick="guardar('nueva')" >Guardar</button>
    </div>                
  </div>
  <!--__________________________________-->
</div>
<!---///--- FIN BOX NUEVO ---///----->

<!---/////---BOX 2 DATATABLE ---/////----->
<div class="box box-primary">
  <div class="box-body">
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">						
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <div class="row">
        <div class="col-sm-12 table-scroll" id="cargar_tabla">
        </div>
      </div>						
    </div>
  </div>
</div>
<!---/////--- FIN BOX 2 DATATABLE---//////----->

<!---///////--- MODAL EDICION E INFORMACION ---///////--->
<div class="modal fade bs-example-modal-lg" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close close_modal_edit" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white;">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <form class="formEdicion" id="formEdicion">
          <div class="form-horizontal">
            <div class="row">
              <form class="frm_circuito_edit" id="frm_circuito_edit">
              <input type="text" class="form-control habilitar hidden" name="etap_id" id="etap_id">
                <div class="col-sm-6">
                  <!--_____________ Nombre _____________-->
                    <div class="form-group">
                      <label for="nombre_edit" class="col-sm-4 control-label">Nombre:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control habilitar requerido" name="nombre" id="nombre_edit">
                      </div>
                    </div>
                  <!--___________________________-->
                  <!--_____________ Proceso Productivo _____________-->
                    <div class="form-group">
                      <label for="proc_id_edit" class="col-sm-4 control-label">Proceso Productivo:</label>
                      <div class="col-sm-8">
                        <!-- <input type="text" class="form-control habilitar" id="vehiculo_edit">  -->
                        <select class="form-control select2 select2-hidden-accesible habilitar requerido" name="proc_id" id="proc_id_edit">
                          <option value="" disabled selected>-Seleccione opción-</option>	
                          <?php
                            foreach ($listarProcesos as $proceso) {
                              echo '<option  value="'.$proceso->proc_id.'">'.$proceso->nombre.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  <!--__________________________-->
                  <!--_____________ Tipo _____________-->
                    <div class="form-group">
                      <label for="tiet_id_edit" class="col-sm-4 control-label">Tipo:</label>
                      <div class="col-sm-8">
                        <!-- <input type="text" class="form-control habilitar" id="vehiculo_edit">  -->
                        <select class="form-control select2 select2-hidden-accesible habilitar requerido" name="tiet_id" id="tiet_id_edit">
                          <option value="" disabled selected>-Seleccione opción-</option>	
                          <?php
                            foreach ($listarTipos as $tipo) {
                              echo '<option  value="'.$tipo->tabl_id.'">'.$tipo->valor.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  <!--__________________________-->
                  <!--_____________ Recipiente _____________-->
                    <div class="form-group">
                      <label for="nom_recipiente_edit" class="col-sm-4 control-label">Recipiente:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control habilitar requerido" name="nom_recipiente" id="nom_recipiente_edit">
                      </div>
                    </div>
                  <!--__________________________-->
                  <!--_____________ Orden _____________-->
                    <div class="form-group">
                      <label for="orden_edit" class="col-sm-4 control-label">Orden:</label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control habilitar requerido" name="orden" id="orden_edit">
                      </div>
                    </div>
                  <!--__________________________-->
                  <!--_____________ Formulario _____________-->
                    <div class="form-group">
                      <label for="form_id_edit" class="col-sm-4 control-label">Formulario:</label>
                      <div class="col-sm-8">
                        <!-- <input type="text" class="form-control habilitar" id="vehiculo_edit">  -->
                        <select class="form-control select2 select2-hidden-accesible habilitar requerido" name="form_id" id="form_id_edit">
                          <option value="" disabled selected>-Seleccione opción-</option>	
                          <?php
                            foreach ($listarFormularios as $formulario) {
                              echo '<option  value="'.$formulario->form_id.'">'.$formulario->nombre.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  <!--__________________________-->               
                </div>
              </form>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="form-group text-right">
          <button type="" class="btn btn-primary habilitar" data-dismiss="modal" id="btnsave_edit" onclick="guardar('editar')">Guardar</button>
          <button type="button" class="btn btn-default cerrarModalEdit" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!---///////--- FIN MODAL EDICION E INFORMACION ---///////--->

<!---///////--- MODAL ARTICULOS ---///////--->
<div class="modal fade bs-example-modal-lg" id="modalarticulos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close close_modal_edit" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white;">&times;</span>
          <input type="text" id="id_etap" class="hidden">
        </button>
      </div>
      <div class="modal-body ">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">						
          <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6"></div>
          </div>
          <div class="row">            
            <div class="col-sm-12 table-scroll">
            <button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;" onclick="nuevoNCmodal()">Agregar</button>
              <table id="tabla_articulos" class="table table-bordered table-striped">
                <thead class="thead-dark" bgcolor="#eeeeee">
                  <th>Acción</th>
                  <th>Código</th>
                  <th>Nombre</th>								
                  <th>Tipo</th>
                  <th>Unidad Medida</th>
                  <th>Es caja</th>
                  <th>Cant. x Caja</th>
                </thead>
                <tbody >
                  <!--TABLE BODY -->
                </tbody>
              </table>
            </div>
          </div>						
        </div>
      </div>
      <div class="modal-footer">
        <div class="form-group text-right">
          <button type="button" class="btn btn-default cerrarModalEdit" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>  
</div>
<!---///////--- FIN MODAL ARTICULOS ---///////--->

<script>
  // carga tabla genaral de circuitos
  $("#cargar_tabla").load("<?php echo base_url(PRD); ?>/general/Etapa/listarEtapas");
  // Config Tabla
  DataTable($('#tabla_articulos'));

  // muestra box de datos al dar click en boton agregar
  $("#botonAgregar").on("click", function() {
    $("#botonAgregar").attr("disabled", "");
    //$("#boxDatos").removeAttr("hidden");
    $("#boxDatos").focus();
    $("#boxDatos").show();
  });

	// muestra box de datos al dar click en X
	$("#btnclose").on("click", function() {
    $("#boxDatos").hide(500);
    $("#botonAgregar").removeAttr("disabled");
    //$('#formDatos').data('bootstrapValidator').resetForm();
    $("#formDatos")[0].reset();
  });

  // al cambiar de establecimiento llena select con pañoles
  $("#esta_id").change(function(){
    wo();
    //limpia las opciones de pañol
    $('#pano_id').empty();
    var esta_id = $(this).val();
    $.ajax({
      type: 'POST',
      data:{esta_id:esta_id },
      url: 'index.php/<?php echo PRD ?>Etapa/obtenerPanoles',
      success: function(result) {
        $('#pano_id').empty();
        panol = JSON.parse(result);
        var html = "";
        if (panol == null) {
          html = html + '<option value="-1" disabled selected>- El Establecimiento no tiene Pañol Asociado -</option>';
        }else{
          html = html + '<option value="-1" disabled selected>-Seleccione Pañol-</option>';
          $.each(panol, function(i,h){
            html = html + "<option data-json= '" + JSON.stringify(h) + "'value='" + h.pano_id + "'>" + h.descripcion + "</option>";
          });
        }
        $('#pano_id').append(html);
        wc();
      },
      error: function(result){
        wc();
        alert('No hay Pañoles asociados a este Establecimiento...');
      }
    });
  });

  // valida campos obligatorios
  function validarCampos(form){
    var mensaje = "";
    var ban = true;
    $('#' + form).find('.requerido').each(function() {
      if (this.value == "" || this.value=="-1") {
        ban = ban && false;
        return;
      }
    });
    if (!ban){
      if(!alertify.errorAlert){
        alertify.dialog('errorAlert',function factory(){
          return{
            build:function(){
              var errorHeader = '<span class="fa fa-times-circle fa-2x" '
              +    'style="vertical-align:middle;color:#e10000;">'
              + '</span>Error...!!';
              this.setHeader(errorHeader);
            }
          };
        },true,'alert');
      }
      alertify.errorAlert("Por favor complete los campos Obligatorios(*)..." );
    }
    return ban;
  }

  // Da de alta una herramienta nueva en pañol
  function guardar(operacion){

    var recurso = "";
    if (operacion == "editar") {
      if( !validarCampos('formEdicion') ){
        return;
      }
      var form = $('#formEdicion')[0];
      var datos = new FormData(form);
      var datos = formToObject(datos);
      recurso = 'index.php/<?php echo PRD ?>general/Etapa/editarEtapa';
    } else {
      // if( !validarCampos('formEtapas') ){
      //   return;
      // }
      var form = $('#formEtapas')[0];
      var datos = new FormData(form);
      var datos = formToObject(datos);
      recurso = 'index.php/<?php echo PRD ?>general/Etapa/guardarEtapa';
    }
    wo();
    $.ajax({
      type: 'POST',
      data:{ datos },
      //dataType: 'JSON',
      url: recurso,
      success: function(result) {
        $("#cargar_tabla").load("<?php echo base_url(PRD); ?>general/Etapa/listarEtapas");
        wc();
        $("#boxDatos").hide(500);
        $("#formEtapas")[0].reset();
        $("#botonAgregar").removeAttr("disabled");
        if (operacion == "editar") {
          alertify.success("Etapa Editada Exitosamente");
        }else{
          alertify.success("Etapa Agregada con Exito");
        }
      },
      error: function(result){
        wc();
        alertify.error("Error agregando Etapa");
      }
    });
  }

</script>