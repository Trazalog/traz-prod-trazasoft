<script>  //Script para Vista Standar  
    evaluarEstado();    
    function evaluarEstado(){       
		
			var asig = $('#asignado').val();       
			// si esta tomada la tarea		
			if(asig != ""){
					habilitar();
			}else{
					deshabilitar();
			}
    }      
   
    function habilitar(){       
			
			$(".btn-soltar").show();    
			$(".btn-tomar").hide();    
			$('#view').css('pointer-events', 'auto');
			//$('.view .oculto').show();
			
    }
    function deshabilitar(){
			$(".btn-soltar").hide();
			$(".btn-tomar").show();    
			$('#view').css('pointer-events', 'none');
			//$('.view .oculto').hide();
    }    
  
     


    // //Funcion COMENTARIOS
    // function guardarComentario() {
	// 		console.log("Guardar Comentarios...");
	// 		var id= $('#case_id').val();
	// 		var comentario=$('#comentario').val();
    //         var nombUsr = $('#usrName').val();
    //         var apellUsr = $('#usrLastName').val();;
	// 		$.ajax({
	// 				type:'POST',
	// 				data:{'processInstanceId':id, 'content':comentario},
	// 				url:'index.php/general/Proceso/guardarComentario',
	// 				success:function(result){
	// 					console.log("Submit");
	// 					var lista =  $('#listaComentarios');
	// 					lista.prepend('<hr/><li><h4>'+nombUsr+' '+apellUsr +'<small style="float: right">Hace un momento</small></h4><p>'+comentario+'</p></li>');
	// 					$('#comentario').val('');
	// 				},
	// 				error:function(result){
	// 					console.log("Error");
	// 				}
	// 		});
	// 	}
    // Toma tarea en BPM
    function tomarTarea() {
			var taskId = $('#taskId').val();
			
			$.ajax({
					type: 'POST',
					data: {
							id: taskId
					},
					url: 'index.php/Tarea/tomarTarea',
					success: function(data) {
						
						if(data['status']){
								habilitar();
						}else{
							alert(data['msj']);
						}

					},
					error: function(result) {
							alert('Error');
					},
					dataType: 'json'
			});
    }
    // Soltar tarea en BPM
    function soltarTarea() {
			var taskId = $('#taskId').val();
			$.ajax({
					type: 'POST',
					data: {
							id: taskId
					},
					url: 'index.php/Tarea/soltarTarea',
					success: function(data) {
						
									// toma a tarea exitosamente
									if(data['status']){
											deshabilitar();
									}
					},
					error: function(result) {
							console.log(result);
					},
					dataType: 'json'
			});
    }

</script>