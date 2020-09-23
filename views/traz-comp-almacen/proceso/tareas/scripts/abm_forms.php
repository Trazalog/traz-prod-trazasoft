<script> //Script Formularios

	var click = 0; 
	$('#formulario').click(function(){
			click = 1;
	});
  // trae valores validos para llenar form asoc.  
	function getformulario(event) {    
		// trae valor de imagenes y llena inputs.
		getImgValor();
		// llena form una sola vez al primer click
		if (click == 0) {    
			var estadoTarea = $('#estadoTarea').val();
			// toma id de form asociado a listarea en TJS
			var idForm = $('#idform').val();  
			// guarda el id form asoc a tarea std en modal para guardar
			$('#idformulario').val(idForm);
			idForm = 1;
			// trae valores validos para llenar componentes de form asoc.
			$.ajax({
				type: 'POST',
				data: { idForm: idForm},
				url: 'index.php/Tarea/getValValido', 
				success: function(data){  
								llenaComp(data);
							},              
				error: function(result){
							
							console.log(result);
						},
				dataType: 'json'
			});
		}
	
	}

  // llena los componentes de form asoc con valores validos
	function llenaComp(data){

		$.each(data,function( index ) {
			//$( "#" + i ).append(  );
			var idSelect = data[index]['idValor'];        
			//console.log('idvalor: '+ data[index]['idValor'] + '-- valor: ' + data[index]['VALOR']);
			var i = 0;
			var valor = "";
			var valorSig = "";      

			if(data[index]['VALOR']!=$('#' + idSelect).val()){
			$('#' + idSelect).append($('<option>',
				{ value: data[index]['VALOR'], text: data[index]['VALOR'] }));
			}
			valor = data[index]['idValor'];     
			valorSig = data[index]['idValor'];
		});
	}

	//Trae valor de las imagenes
	function getImgValor(){
		var valores; 
		// guarda el id form asoc a tarea std en modal para guardar
		idForm =  $('#idform').val();
		idPedido = $('#idPedTrabajo').val();
		// trae valores validos para llenar componentes input files.
		$.ajax({
			type: 'POST',
			data: { idForm: idForm,idPedTrabajo:idPedido},
			url: 'index.php/Tarea/getImgValor', 
			success: function(data){               
																	
							valores = data;
							llenarInputFile(valores);
						},              
			error: function(result){
						
						console.log(result);
					},
			dataType: 'json'
		});
	}

	// carga inputs auxiliares con url de imagen desde BD
	function llenarInputFile(data){
		var id_listarea = $('inptut.archivo').val();

		$.each(data,function( index ) {

			var id = data[index]['valoid'];
			var valor = data[index]['valor'];
			//carga el valor que viene de DB
			if(valor!=""){
				$("."+data[index]['valoid']).removeClass('hidden');
				$("."+data[index]['valoid']).attr('href',valor);
			}else{
				$("."+data[index]['valoid']).addClass('hidden');
			}		
		});
	}

	function GuardarFormularioFAIL(validarOn){
		alert("Guardando Formulario");
		// console.log(form_actual_id + ' id form');
		// console.log(form_actual_data.attr("data-formid") + ' id de form en bd');
		// console.log(form_actual_data.attr("data-bpmIdTarea") + ' bpm id');		
		// console.log($('#id_listarea').val() + 'id listarrea');	
		var imgs = $('input.archivo');
		var formData = new FormData($("#"+form_actual_id)[0]);
		//var id_listarea = form_actual_data.attr("data-bpmIdTarea");
		// formData.append('id_listarea', id_listarea);
		// formData.append('idformulario', form_actual_id);

		/** subidad y resubida de imagenes **/
		// Tomo los inputs auxiliares cargados
		var aux = $('input.auxiliar');
		var auxArray = [];
		aux.each(function () {
			auxArray.push($(this).val());
		});
		//console.table(aux);
		for (var i = 0; i < imgs.length; i++) {
			var inpValor = $(imgs[i]).val();
			var idValor = $(imgs[i]).attr('name');
			// si tiene algun valor (antes de subir img)
			if (inpValor != "") {
				//al subir primera img
				formData.append(idValor, inpValor);
			} else {
				//formData.delete(idValor);
			}
		}
		/* text tipo check */
		var check = $('input.check');
		var checkArray = [];		
		for (var i = 0; i < check.length; i++) {
			var idCheckValor = $(check[i]).attr('name');
			if ($(check[i]).is(':checked')) {
				chekValor = 'tilde';
			} else {
				chekValor = 'notilde';
			}
			formData.append(idCheckValor, chekValor);
		}	
		for (var pair of formData.entries()) {
		 console.log(pair[0]+ ', ' + pair[1]); 
		}

	
		/* Ajax de Grabado en BD */
		$.ajax({
			url: 'index.php/Tarea/guardarForm',
			type: 'POST',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				console.log(form_actual_id+"...OK");
				wc();
				if(existFunction("after_save_form"))after_save_form();
    		},
			error: function(error){
				wc();
				alert(error.msj);
				console.log(error);
			}
		});
	}

	function GuardarFormulario(validarOn){

	//	alert('Guardar Formulario...');
		var imgs = $('input.archivo');
		var formData = new FormData($("#"+form_actual_id)[0]);
		var id_listarea = 0;
		formData.append('id_listarea', id_listarea);
		formData.append('idformulario', form_actual_id);

		/** subidad y resubida de imagenes **/
		// Tomo los inputs auxiliares cargados
		var aux = $('input.auxiliar');
		var auxArray = [];
		aux.each(function () {
			auxArray.push($(this).val());
		});


		for (var i = 0; i < imgs.length; i++) {
			var inpValor = $(imgs[i]).val();
			var idValor = $(imgs[i]).attr('name');
			// si tiene algun valor (antes de subir img)
			if (inpValor != "") {
				//al subir primera img
				formData.append(idValor, inpValor);
			} else {
				//formData.delete(idValor);
			}
		}
		/* text tipo check */
		var check = $('input.check');
		var checkArray = [];		
		for (var i = 0; i < check.length; i++) {
			var idCheckValor = $(check[i]).attr('name');
			if ($(check[i]).is(':checked')) {
				chekValor = 'tilde';
			} else {
				chekValor = 'notilde';
			}
			formData.append(idCheckValor, chekValor);
		}	
		for (var pair of formData.entries()) {
			console.log(pair[0]+ ', ' + pair[1]); 
		}
		/* Ajax de Grabado en BD */
		$.ajax({
			url: 'index.php/Tarea/guardarForm',
			type: 'POST',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (respuesta) {
				console.log(form_actual_id+"...OK");
				wc();
				if(existFunction("after_save_form"))after_save_form();
				ValidarObligatorios(validarOn);
			},
			error: function(respuesta){
				
				wc();
				alert('Error Form');
			}
		});
	}

   
	$('.fecha').datepicker({
			autoclose: true
	});

  var form_actual_id = '';
  var form_actual_data = '';


  $('.getFormularioTarea').click( function(){
		
    wo('Abriendo Formulario');
    form_actual_data = $(this);
		form_actual_data.attr("data-open","true");
    var form_id = form_actual_data.attr("data-formid");
    var idListTarea = form_actual_data.attr("data-bpmIdTarea");

		console.info(idListTarea + 'ide de listarea en guardando:')
		
		$('#idform').val(form_id);	
    form_actual_id = 'genericForm'+idListTarea; 	
    console.log("Get Formularios Tarea..."+form_actual_id);  
    console.info("idListTarea: "+idListTarea);
		//inicializa el validador de campos (visual no en BD)
		IniciarValidador(form_actual_id);
    
		$.ajax({
      data: {form_id:form_id, bpm_task_id: idListTarea },
      dataType: 'json',
      type: 'POST',
      url: 'index.php/Tarea/Obtener_Formulario',
      success: function(result){   
		
								$("#contFormSubtarea").html(result.html);
								if(existFunction("after_get_form"))after_get_form();
								getImgValor();
								//getformularioDiag();
								$('#modalFormSubtarea').modal('show');
								
								$('#id_info').val(idListTarea);	// info id para actualizar frmcompletados
								$('#idformulario').val(form_id);	// id de formulario
								$('.formgenerico').attr("id", form_id); // agrega id de form al form cargado
								
								wc();
							
      },
      error: function(result){
								wc();
								alert("Error: No se pudo obtener el Formulario");
      },
    });
  }); 

</script>