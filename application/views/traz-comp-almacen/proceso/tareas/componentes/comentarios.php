<input class="hidden" id="case_id" value="<?php echo $case_id ?>">
<?php 
  $userdata = $this->session->userdata('user_data')[0];
  $usrId = $userdata['usrId'];     // guarda usuario logueado 
  $usrName =  $userdata['usrName'];
  $usrLastName = $userdata["usrLastName"];
  
  echo "<input type='text' class='hidden' id='usrName' value='$usrName' >";
  echo "<input type='text' class='hidden' id='usrLastName' value='$usrLastName' >";
?>
<div class="panel panel-primary">
	<div class="panel-heading">Comentarios</div>
	<div class="panel-body" style="max-height: 500px;overflow-y: scroll;">
		<ul id="listaComentarios">
			<?php
				foreach($comentarios as $f){

				if(strcmp($f['userId']['userName'],'System')!=0){
				echo '<hr/>';
				echo '<li><h4>'.$f['userId']['firstname'].' '.$f['userId']["lastname"].'<small style="float: right">'.date_format(date_create($f['postDate']),'H:i  d/m/Y').'</small></h4>';
				echo '<p>'.$f['content'].'</p></li>';
				}
				}
				?>
		</ul>
	</div>
</div>
<textarea id="comentario" class="form-control" placeholder="Nuevo Comentario..."></textarea>
<br />
<button class="btn btn-primary" id="guardarComentario" onclick="guardarComentario()">Agregar</button>



<script>
	//Funcion COMENTARIOS
	function guardarComentario() {
		console.log("Guardar Comentarios...");
		var id = $('#case_id').val();
		var nombUsr = $('#usrName').val();
		var apellUsr = $('#usrLastName').val();
		var comentario = $('#comentario').val();

		$.ajax({
			type: 'POST',
			data: { 'processInstanceId': id, 'content': comentario },
			url: 'index.php/Tarea/GuardarComentario',
			success: function (result) {
				var lista = $('#listaComentarios');
				lista.prepend(' <hr/><li><h4>' + nombUsr + ' ' + apellUsr + '<small style="float: right">Hace un momento</small></h4><p>' + comentario + '</p></li>');
				$('#comentario').val('');
			},
			error: function (result) {
				console.log("Error");
			}
		});
	}
</script>