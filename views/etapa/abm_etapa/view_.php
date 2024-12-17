<!-- /// ---- HEADER ----- /// -->
<div class="box box-primary animated fadeInLeft">
  <div class="box-header with-border">
    <h4>Lista de Etapas Productivas</h4>
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

<!---///--- BOX 1 NUEVA ETAPA PRODUCTIVA ---///----->
<div class="box box-primary animated bounceInDown" id="boxDatos" name="Content-Type"  scope="transport" hidden>
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
          <select type="text" id="form_id" name="form_id" class="form-control selec_habilitar" >
            <option value="1" disabled selected>-Seleccione opción-</option>
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
      <button type="button" class="btn btn-primary" onclick="guardar()" >Guardar</button>
    </div>                
  </div>
  <!--__________________________________-->
</div>
<!---///--- FIN BOX NUEVA ETAPA PRODUCTIVA ---///----->

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
                        <select class="form-control select2 select2-hidden-accesible habilitar" name="form_id" id="form_id_edit">
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
          <button type="" class="btn btn-primary habilitar" data-dismiss="modal" id="btnsave_edit" onclick="editarArticulo()">Guardar</button>
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
              <input type="text" id="id_etap" class="hidden">
            <button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;" onclick="agregarArticulo()">Agregar</button>
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

<!---///////--- MODAL AGREGAR ARTICULO ---///////--->
<div class="modal fade bs-example-modal-lg" id="modalAgregarArticulo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close close_modal_edit" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white;">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
          <div class="form-horizontal">
            <div class="row">
              <form class="frmArticulo" id="frmArticulo">
                <input type="text" class="form-control habilitar hidden" name="etap_id" id="etapa_id">
                  <!--_____________ Artículo _____________-->
                  <div class="form-group">
                      <label for="articulo_id" class="col-sm-4 control-label">Artículo:</label>
                      <div class="col-sm-12 col-md-8 col-lg-8 ba">
                        <select style="width: 60%" class="form-control select2-hidden-accesible habilitar requerido" name="arti_id" id="articulo_id">
                          <option value="" data-foo='' disabled selected>-Seleccione opción-</option>	
                          <?php
                            foreach ($listarArticulos as $articulo) {
                              echo "<option value='$articulo->arti_id' data-json='". json_encode($articulo) . "' data-foo='<small><cite>$articulo->descripcion</cite></small>  <label>♦ </label>   <small><cite>$articulo->stock</cite></small>  <label>♦ </label>' >$articulo->barcode</option>";
                            }
                            ?>
                        </select>
                        <?php 
                          echo "<label id='detalle' class='select-detalle' class='text-blue'></label>";
                          echo "<script>$('#articulo_id').select2({matcher: matchCustom,templateResult: formatCustom, dropdownParent: $('#modalAgregarArticulo')}).on('change', function() { selectEvent(this);})</script>";
                        ?>
                      </div>
                    </div>
                  <!--__________________________-->   
                  <!--_____________ Tipo _____________-->
                  <div class="form-group">
                      <label for="tipo_id" class="col-sm-4 control-label">Tipo:</label>
                      <div class="col-sm-12 col-md-8 col-lg-8">
                        <select style="width: 60%" class="form-control s2MdlAgregar select2-hidden-accesible habilitar requerido" name="tipo_id" id="tipo_id">
                          <option value="" disabled selected>-Seleccione opción-</option>	
                          <option value="1">Entrada</option>	
                          <option value="2">Producto</option>	
                          <option value="3">Salida</option>
                        </select>
                      </div>
                    </div>
                  <!--__________________________-->   
              </form>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <div class="form-group text-right">
              <button type="" class="btn btn-primary habilitar" data-dismiss="modal" id="btnsave_edit" onclick="guardarArticulo()">Guardar</button>
              <button type="" class="btn btn-default cerrarModalEdit" id="" data-dismiss="modal">Cerrar</button>
          </div>
      </div>
    </div>
  </div>
</div>
<!---///////--- FIN MODAL AGREGAR ARTICULO ---///////--->

<script>
  $(document).ready(function () {
    $(".s2MdlAgregar").select2({
      tags: true,
      dropdownParent: $("#modalAgregarArticulo")
    });
  });
  // carga tabla genaral de circuitos
  $("#cargar_tabla").load("<?php echo base_url(PRD); ?>/general/Etapa/listarEtapas");
  // Config Tabla
  // tablaArticulos = $("#tabla_articulos").DataTable();
  // tablaArticulos.clear().draw();

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
    $("#formEtapas")[0].reset();
  });

  // valida campos obligatorios
  function validarCampos(form){
    var mensaje = "", campo="";
    var ban = true, ban1=true;
    $('#' + form).find('.requerido').each(function() {

      
      if (this.value == "" || this.value=="-1") {
        ban = ban && false;

        //Especifico que campo viene vacio
        if(ban1 == true){
          if(this.name == 'nombre'){ campo = "Por favor, completa el campo Nombre";this.focus();}
          if(this.name == 'proc_id') {campo = "Por favor, selecciona un Proceso productivo"+"<br><br>Dirigirse al Módulo Configuraciones y seleccionar en ABM Lista de valores el listado 'procesos' ";this.focus();}
          if(this.name == 'tiet_id') {campo =  "Por favor, selecciona Tipo"+"<br><br>Dirigirse al Módulo Configuraciones y seleccionar en ABM Lista de valores el listado 'prd_tipo_etapa' ";this.focus();}
          if(this.name == 'nom_recipiente') {campo = "Por favor, selecciona un Recipiente"+"<br><br>Dirigirse al Módulo Configuraciones y agregar desde 'Creación de recipientes'";this.focus();}
          if(this.name == 'orden') {campo = "Por favor, selecciona un Recipiente"+"<br><br>Dirigirse al Módulo Configuraciones y seleccionar en ABM Lista de valores el listado 'formulario_prd_tipo_etapa' ";this.focus();}
          ban1 = ban1 && false; 
          return;
        }
        else 
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
      if(campo == '')
      alertify.errorAlert("Por favor complete los campos Obligatorios(*)...");
      else 
      alertify.errorAlert(campo);
    }
    return ban;
  }

  // Da de alta una herramienta nueva en pañol
  function guardar(){
    var recurso = "";
    if( !validarCampos('formEtapas') ){
      return;
    }
    var form = $('#formEtapas')[0];
    var datos = new FormData(form);
    var datos = formToObject(datos);

    nombre_nuevo = datos.nombre.replace(/ /g, "_");
    datos['nombre']  = nombre_nuevo;

    recurso = 'index.php/<?php  echo PRD ?>general/Etapa/guardarEtapa';
    
    wo();
    validarEtapa(datos).then((result) => {
     // if(!result){
        if(result=="false"){
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
              alertify.success("Etapa editada exitosamente");
            }else{
              alertify.success("Etapa agregada con éxito");
            }
          },
          error: function(result){
            wc();
            alertify.error("Error agregando Etapa");
          }
        });
      }else{
        error("Error","La etapa productiva ingresada ya se encuentra creada para este proceso!");
      }
    }).catch((err) => {
      if(err){
        console.log(err);
        error("Error","Se produjo un error al validar el nombre de la Etapa");
      }
    });
  }
  async function validarEtapa(datos){
    let validacion = new Promise((resolve, reject) => {
      $.ajax({
        type: 'POST',
        data:{ datos },
        dataType: 'JSON',
        url: "<?php echo PRD ?>general/Etapa/validarEtapa",
        success: function(rsp) {
          resolve(rsp.existe);
        },
        error: function(rsp){
          reject(rsp.existe);
        },
        complete: function(){
          wc();
        }
      });
    });
    return await validacion;
  }
  function editarArticulo(){
    if( !validarCampos('formEdicion') ) return;
    wo();
    var form = $('#formEdicion')[0];
    var datos = new FormData(form);
    var datos = formToObject(datos);
    recurso = 'index.php/<?php echo PRD ?>general/Etapa/editarEtapa';
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
        hecho('',"Etapa editada exitosamente");
      },
      error: function(result){
        wc();
        error('',"Error agregando Etapa");
      }
    });
  }

  function agregarArticulo() {
    var form = $('#frmArticulo')[0];
    form.reset();
    $(".modal-header h4").remove();
    //guardo el tipo de operacion en el modal
    $("#operacion").val("Edit");
    //pongo titulo al modal
    $(".modal-header").append('<h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-fw fa-pencil"></span> Agregar Artículo</h4>');
    $("#modalarticulos").modal('hide');
    $('#modalAgregarArticulo').modal('show');
    // guardo etap_id en modal para usar en funcion agregar articulo
    var etap_id = $("#id_etap").val();
    $("#etapa_id").val(etap_id);
  }

  function guardarArticulo () {
    if( !validarCampos('frmArticulo') ){
      return;
    }
    var recurso = "";
    var form = $('#frmArticulo')[0];
    var datos = new FormData(form);
    var datos = formToObject(datos);
    recurso = 'index.php/<?php echo PRD ?>general/Etapa/guardarArticulo';
    wo();
    $.ajax({
      type: 'POST',
      data:{ datos },
      dataType: 'JSON',
      url: recurso,
      success: function(result) {
        $("#cargar_tabla").load("<?php echo base_url(PRD); ?>general/Etapa/listarEtapas");
        setTimeout(function(){ 
          wc();
          alertify.success("Artículo agregado con éxito");
        }, 3000);
        $("#modalAgregarArticulo").hide(500);
        $('#articulo_id').val(null).trigger('change');
        $('#detalle').html('');
        $('#tipo_id').val(null).trigger('change');
      },
      error: function(result){
        wc();
        alertify.error("Error agregando Artículo");
      }
    });
  }

  function eliminarArticulo(e) {
    var data = JSON.parse($(e).closest('tr').attr('data-json'));
    var arti_id = data.arti_id;
    var tipo = data.tipo;
    
    $('#arti_id').val(arti_id);
    $('#tipo').val(tipo);
    var etap_id = $("#id_etap").val();

    // var etap_id = $("#etapa_id").val();
    $("#id_etapa_borrar").val(etap_id);

    $(".modal-header h4").remove();
    //pongo titulo al modal
    $(".modal-header").append('<h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-fw fa-pencil"></span> Eliminar Artículo </h4>');
    $("#modalarticulos").modal('hide');
    $('#modalAvisoArticulo').modal('show');
	}

  function eliminarArticuloDeEtapa() {
        var arti_id = $("#arti_id").val();
        var tipo = $("#tipo").val();
        var etap_id = $("#id_etap").val();
        // var etap_id = $("#id_etapa_borrar").val();
        wo();
        $.ajax({
            type: 'POST',
            data:{arti_id: arti_id, tipo: tipo, etap_id: etap_id},
            url: 'index.php/<?php echo PRD ?>general/Etapa/borrarArticuloDeEtapa',
            success: function(result) {
              $("#cargar_tabla").load("<?php echo base_url(PRD); ?>general/Etapa/listarEtapas");
              setTimeout(function(){ 
                alertify.success("Artículo eliminado con éxito");
                wc();
                // alert("Hello"); 
              }, 3000);
              $("#modalAvisoArticulo").modal('hide');
            },
            error: function(result){
              wc();
              $("#modalAvisoArticulo").modal('hide');
              alertify.error('Error en eliminado de Artículo...');
            }
        });        
    }

</script>

<!-- Modal aviso eliminar articulo-->
<div class="modal fade" id="modalAvisoArticulo">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-blue">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-trash text-light-blue"></span> Eliminar Artículo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12">
              <h4>¿Desea realmente eliminar el artículo de la etapa productiva?</h4>
              <input type="text" id="arti_id" class="hidden">
              <input type="text" id="tipo" class="hidden">
              <input type="text" id="id_etapa_borrar" class="hidden">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="eliminarArticuloDeEtapa()">Aceptar</button>
        </div>
      </div>
    </div>
</div>
<!-- /  Modal aviso eliminar -->