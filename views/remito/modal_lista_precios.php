<!---/////---MODAL VER LISTA DE PRECIO ---/////----->
<div class="modal fade bs-example-modal-lg" id="modalVerListaPrecio" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="myLargeModalLabel">Ver Lista de Precios</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="formLista" id="formLista">
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nombreVer">Nombre(<strong style="color: #dd4b39">*</strong>):</label>
                                <input type="text" class="form-control" name="nombreVer" id="nombreVer" readonly>
                            </div>
                        </div>
                        <!-- Tipo -->
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="tipoVer">Tipo(<strong style="color: #dd4b39">*</strong>):</label>
                                <input type="text" class="form-control" name="tipoVer" id="tipoVer" readonly>
                            </div>
                        </div>
                        <!-- Version -->
                        <div class="col-md-1 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="Version">Versión:</label>
                                <input type="text" class="form-control" name="versionVer" id="versionVer" readonly>
                            </div>
                        </div>
                        <!-- Detalle -->
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="Detalle">Descripción versión:</label>
                                <input type="text" class="form-control" name="detalleVer" id="detalleVer" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Vigente Desde -->
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="vigenteDesdeVer">Vigente Desde:</label>
                                <input type="date" class="form-control requerido" name="vigenteDesdeVer" id="vigenteDesdeVer" readonly>
                            </div>
                        </div>
                        <!-- Vigente Hasta -->
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="vigenteHastaVer">Vigente Hasta:</label>
                                <input type="date" class="form-control requerido" name="vigenteHastaVer" id="vigenteHastaVer" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tablaDetalleVer" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Código Artículo</th>
                                        <th>Descripción</th>
                                        <th>Precio Unitario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="button" class="btn btn-default cerrarModalEdit" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!---/////--- FIN MODAL VER LISTA DE PRECIO ---/////----->