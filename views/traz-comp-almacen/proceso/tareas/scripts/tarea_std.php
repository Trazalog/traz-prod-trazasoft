<script>
  //Script para Vista Standar  
  evaluarEstado();

  function evaluarEstado() {

    var asig = $('#asignado').val();
    // si esta tomada la tarea		
    if (asig != "") {
      habilitar();
    } else {
      deshabilitar();
    }
  }

  function habilitar() {

    // habilito btn y textarea       
    $("#btonsoltr").show();
    $("#hecho").show();
    $("#guardarComentario").show();
    $("#comentario").show();
    //desahilito btn tomar      
    $("#btontomar").hide();
    $("#formulario").show();
    $('#acciones_view').show();
    // deshabilito columna y formulario
    $(".columheader").show();
    $(".getFormularioTarea").show();
    $("#pedidoInsumos").show();
    $('#decisionSolicitud').show();
    $('#verOrden').show();
    $('.panel_form').show();
    $('.oculto').show();
  }

  function deshabilitar() {

    $('.oculto').hide();
    // habilito btn tomar
    $("#btontomar").show();
    // habilito btn y textarea  
    $("#btonsoltr").hide();
    $("#hecho").hide();
    $("#guardarComentario").hide();
    $("#comentario").hide();
    $("#formulario").hide();
    $('#acciones_view').hide();
    // deshabilito columna y formulario
    $(".columheader").hide();
    $(".getFormularioTarea").hide();
    $("#pedidoInsumos").hide();
    $('#decisionSolicitud').hide();
    $('#verOrden').hide();
  }
  // Volver al atras
  $('#cerrar').click(function cargarVista() {
    wo();
    $('#content').empty();
    //	$("#content").load("<?php# echo base_url(); ?>index.php/Tarea/index/");
    wc();
  });

  /* Funciones BPM */
  //Ckeck Tarea realizada
  $('.btncolor').click(function(e) {
    //var id = <?php //echo $idorden
                ?>; //tomo valor de id_orden
    console.log(id);
    var id_tarea = $(this).parents('tr').find('td').eq(1).html();
    console.log("Estoy finalizando una tarea");
    $.ajax({
      type: 'POST',
      data: {
        id_tarea: id_tarea,
      }, //Id tarea
      url: 'index.php/Taller/TareaRealizada', //index.php/
      success: function(data) {
        console.log(data);
        //alert("Se Finalizando la SUBTAREA");
        refresca(id);
      },
      error: function(result) {
        console.log(result);
        alert("NO se Finalizo la SUBTAREA");
        refresca(id);
      }
    });
  });

  // function terminarTarea(){
  // 	var ban = true;
  // 	$('.getFormularioTarea').each(function( index ) {
  // 	if($( this ).attr('data-open')=="true"){
  // 			console.log( index + ": " + $( this ).attr('data-validado'));
  // 			ban = ban && ($( this ).attr('data-validado') == "true");
  // 	}
  // 	});
  // 	if(ban==false){alert("Para concluir esta actividad primero debe Validar el Formulario");return;}
  // 	wo('Cerrando Tarea');
  // 	var idTarBonita = $('#idTarBonita').val();
  // 	//alert(idTarBonita);
  // 	$.ajax({
  // 			type: 'POST',
  // 			data: {
  // 					'idTarBonita': idTarBonita,
  // 			},
  // 			url: 'index.php/Tarea/terminarTarea',
  // 			success: function(data) {
  // 								wc();
  // 							// toma a tarea exitosamente
  // 							if(data['reponse_code'] == 204){
  // 									$("#content").load("<?php #echo base_url(); 
                                            ?>index.php/Tarea/index/<?php #echo $permission; 
                                                                                            ?>");
  // 							}
  // 			},
  // 			error: function(data) {
  // 					//alert("Noo");
  // 					console.log(data);
  // 			},
  // 			dataType: 'json'
  // 	}); 
  // }      

  // function terminarTarea(){

  // 	var formOt = [];
  // 	var i = 0;
  // 	$('.getFormularioTarea').each(function( index ) {
  // 		var data = {};
  // 		var idForm = $( this ).attr('data-formid');
  // 		console.log('id form: '+idForm);
  // 		var idOT = $('#ot').val();
  // 		data.idForm = idForm;
  // 		data.idOT = 22;

  // 		formOt.push(data);
  // 	});



  // 	 //if ( validarCamposObligatorios(formOt) ) {
  // 			$.ajax({
  // 				type: 'POST',
  // 				data: {formIdOt:formOt},
  // 				url: 'index.php/Tarea/terminarTareaStandarenBPM',
  // 				success: function(data) {
  // 									wc();
  // 								// toma a tarea exitosamente
  // 								// if(data['reponse_code'] == 204){
  // 								// 		$("#content").load("<?php #echo base_url(); 
                                                ?>index.php/Tarea/index/<?php #echo $permission; 
                                                                                                ?>");
  // 								// }
  // 				},
  // 				error: function(data) {
  // 						//alert("Noo");
  // 						console.log(data);
  // 				},
  // 				dataType: 'json'
  // 			}); 
  // 	 //} else {
  // 	//	alert('Existen Formularios incompletos, por favor rellenelos para completar la tarea.');
  // 	 //}


  // 	//console.table(formOt);
  // 	//if(ban==false){alert("Para concluir esta actividad primero debe Validar el Formulario");return;}
  // 	//wo('Cerrando Tarea');
  // 	// var idTarBonita = $('#idTarBonita').val();
  // 	// //alert(idTarBonita);
  // 	// 
  // }  

  // cerrar tarea Analisis de urgencia
  function decidirUrgencia() {

    wo();
    var opcion = $('input[name="opcion"]:checked').val();
    var idTarBonita = $('#idTarBonita').val();

    $.ajax({
      type: 'POST',
      data: {
        opcion: opcion,
        idTarBonita: idTarBonita
      },
      url: 'index.php/Tarea/decidirUrgencia',
      success: function(data) {
        wc();
        console.table(data);
        //	wc();
        // toma a tarea exitosamente
        if (data['reponse_code'] == 204) {
          //$("#content").load("<?php #echo base_url(); 
                                ?>index.php/Tarea/index/<?php #echo $permission; 
                                                                                ?>");
        }
      },
      error: function(data) {
        wc();
        //alert("Noo");
        console.log(data);
      },
      dataType: 'json'
    });
  }

  function ejecutarOT() {

    var idTarBonita = $('#idTarBonita').val();

    $.ajax({
      type: 'POST',
      data: {
        idTarBonita: idTarBonita
      },
      url: 'index.php/Tarea/ejecutarOT',
      success: function(data) {
        console.table(data);
        //	wc();
        // toma a tarea exitosamente
        sessionStorage.setItem("tareas_cerradas", idTareaBonita + "-");
        if (data['reponse_code'] == 204) {

          $("#content").load(
            "<?php #echo base_url(); 
              ?>index.php/Tarea/index/<?php #echo $permission; 
                                                              ?>");
        }
      },
      error: function(data) {

        console.log(data);
      },
      dataType: 'json'
    });
  }


  // Boton Hecho generico
  function estado() {
    var idTarBonita = $('#idTarBonita').val();
    $.ajax({
      type: 'POST',
      data: {
        'idTarBonita': idTarBonita,
      },
      url: 'index.php/Tarea/estadoCuenta',
      success: function(result) {
        console.log(result);
        //alert("SII");
      },
      error: function(result) {
        alert("Noo");
        console.log(result);
      },
      dataType: 'json'
    });
  }
  //Funcion COMENTARIOS
  function guardarComentario() {
    console.log("Guardar Comentarios...");
    var id = $('#case_id').val();
    var comentario = $('#comentario').val();
    var nombUsr = $('#usrName').val();
    var apellUsr = $('#usrLastName').val();;
    $.ajax({
      type: 'POST',
      data: {
        'processInstanceId': id,
        'content': comentario
      },
      url: '<?php echo base_url(ALM) ?>Proceso/guardarComentario',
      success: function(result) {
        console.log("Submit");
        var lista = $('#listaComentarios');
        lista.prepend('<hr/><li><h4>' + nombUsr + ' ' + apellUsr +
          '<small style="float: right">Hace un momento</small></h4><p>' + comentario + '</p></li>'
        );
        $('#comentario').val('');
      },
      error: function(result) {
        console.log("Error");
      }
    });
  }
  // Toma tarea en BPM
  function tomarTarea() {
    var idTarBonita = $('#idTarBonita').val();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(ALM) ?>Proceso/tomarTarea/' + idTarBonita,
      success: function(data) {

        if (data['status']) {
          habilitar();
        } else {
          alert(data.msj);
        }

      },
      error: function(result) {
        alert('Error al Asignar Usuario');
      },
      dataType: 'json'
    });
  }
  // Soltar tarea en BPM
  function soltarTarea() {
    var idTarBonita = $('#idTarBonita').val();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(ALM) ?>Proceso/soltarTarea/' + idTarBonita,
      success: function(data) {

        // toma a tarea exitosamente
        if (data['status']) {
          deshabilitar();
        } else {
          alert(data.msj);
        }
      },
      error: function(result) {
        console.log('Error al Soltar Tarea');
      },
      dataType: 'json'
    });
  }
</script>
