<script> //Validacion de Formulario
	//IniciarValidador("genericForm");
	function IniciarValidador(idForm){
	$('#'+idForm).bootstrapValidator({ //VALIDADOR
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {		
				fecha:{
					selector: '.fecha',
					validators:{
						date: {
						format: 'DD-MM-YYYY',
						message: '(*) Formato de Fecha Inválido'
					}
					}
				},
				number: {
					selector: '.numerico',
					validators: {
						integer: {
							message: '(*) Solo Valores Numéricos'
						}
					}
				}

			}
		}).on('success.form.bv', function(e) {
				// Prevent form submission
			
				e.preventDefault();
				//guardarFormulario(true);
			
		});
	}

	var validado=false;
	function ValidarCampos(){
			wo('Validando Formulario');
			ValidarObligatorios();
			GuardarFormulario(true);
	}

	function CerrarModal(){
			$('.modal').modal('hide');
			wo('Guardando Cambios');
			GuardarFormulario(false);
	}
	
	function validarCamposObligatorios(formOt){	

		$.ajax({
				type: 'POST',
				data: {formIdOt:formOt},
				url: 'index.php/Tarea/validarCamposObligatorios',
				success: function (result) {
									var tamaño = result.length;
									if (tamaño > 0) {
										for(var i = 0; i < result.length; i++){		
											var registro = $("*[data-formid = "+result[i]+"]").parents("tr");							
											registro.css('background-color', '#f2c87b');
										}	
										return false;
									} else {
										return true;
									}	
					 
					//wc();
				},
				error: function(result){
					// alert("Fallo la Validación del formularios en el Servidor. Por favor vuelva a intentar.");
				},
				dataType: 'json'
			});
	}

	function ValidarObligatorios(){	//Valida Campos los Obligatorios offline
		var ban = true;
		$('.requerido').each(function(i){//numerico/select/check/text/input_text
			console.log(i+" >> "+($(this).val()!=""));
			ban = ban && ($(this).val()!="");
		});
		console.log("Resultado Validacion >>" + ban);
		return ban;	
	}


</script>