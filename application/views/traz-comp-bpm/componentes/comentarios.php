<input class="hidden" id="case_id" value="<?php echo $case_id ?>">
<?php
$userdata = $this->session->userdata('user_data');
$usrId = $userdata['userId']; // guarda usuario logueado
$usrName = $userdata['userName'];
$usrLastName = $userdata["userLastName"];

echo "<input type='text' class='hidden' id='usrName' value='$usrName' >";
echo "<input type='text' class='hidden' id='usrLastName' value='$usrLastName' >";
?>
<div class="panel panel-primary">
    <div class="panel-heading">Comentarios</div>
    <div class="panel-body" style="max-height: 500px;overflow-y: scroll;">
        <table class="table">
            <tbody>
                <?php
			foreach ($comentarios as $f) {
                
                if (strcmp($f['userId']['userName'], 'System') == 0) continue;
                
                echo '<hr><div class="item"><p class="message"><a href="#" class="name"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>' . $f['userId']['firstname'] . ' ' . $f['userId']["lastname"] .'</a><br><br>'. $f['content'] . '</p></div>';
                }
                ?>

            </tbody>
        </table>
    </div>
</div>

<div class="input-group oculto">
    <input type="text" class="form-control" id="comentario">
    <div class="input-group-btn">
        <button type="button" class="btn btn-primary" onclick="guardarComentario()">Agregar</button>
    </div>
</div>