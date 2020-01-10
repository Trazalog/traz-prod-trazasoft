<div id="snapshot" data-key="<?php echo $key ?>">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">View Test</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>Nombre:</label>
                <input name="vnombre" class="form-control " type="text">
            </div>
            <div class="form-group">
                <label>Provincia:</label>
                <select name="vprovincia" class="form-control">
                    <option value="" selected disabled></option>
                    <option value="San Juan">San Juan</option>
                    <option value="Mendoza">Mendoza</option>
                    <option value="San Luis">San Luis</option>
                </select>
            </div>
            <div class="form-group">
                <input class="hidden" type="radio" name="vopciones">
                <input name="vopciones" type="radio" value="op1" id="opt1" /><label for="opt1">
                    Opción1
                </label><br>
                <input name="vopciones" type="radio" value="op2" id="opt2" /><label for="opt2">
                    Opción2
                </label><br>
                <input name="vopciones" type="radio" value="op3" id="opt3" /><label for="opt3">
                    Opción3
                </label>
            </div>
            <div class="form-group">
                <label>
                    <input name="vterminos" type="checkbox" value="true"> Acepto Términos y Condiciones
                </label><br>
                <label>
                    <input name="vemail" type="checkbox" value="true"> Enviar Mails
                </label>
            </div>
            <div class="form-group">
                <label>Detalle:</label>
                <textarea name="vdetalle" class="form-control"></textarea>
            </div>
            <button onclick="saveSnapshot()">Guardar</button>
        </div>
    </div>
</div>
<script>
getSnapshot()
</script>