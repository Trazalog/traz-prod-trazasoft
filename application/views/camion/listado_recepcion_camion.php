<!--Pantalla "LISTADO RECEPCION DE CAMION"-->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado Recepción Camión</h3>
    </div>
    <div class="box-body">
    <!--________________________________________________________________________-->    
    <!--Campos de Filtrado de //LISTADO RECEPCION CAMION//-->
        <div class="col-md-6">
            <!--Establecimiento-->
            <div class="form-group">
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Establecimiento</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Establecimiento">
            </div>
            <!--________________________________________________________________________-->   
            <!--Transportista-->
            <div class="form-group">
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Transportista</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Transportista">
            </div>
            <!--________________________________________________________________________-->   
            <!--Proveedor-->
            <div class="form-group">
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Proveedor</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Proveedor">
            </div>
            <!--________________________________________________________________________-->   
        </div>
        <div class="col-md-6">
            <!--Rango Fecha-->
            <div class="form-group">
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Rango Fecha</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Establecimiento">
            </div>
            <!--________________________________________________________________________-->   
            <!--Articulo-->
            <div class="form-group">
                <label for="exampleInputEmail1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Articulo</font></font></label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Establecimiento">
            </div>
        </div>
    <!--________________________________________________________________________-->
    <!--Tabla de datos que recibe informacion carga de la //Recepcion de Camion\\-->
    <div class="box-body">
              <table class="table table-bordered"> 
                <tbody><tr>
                  <th style="width: 10px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"></font></font></th>
                  <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tarea</font></font></th>
                  <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Progreso</font></font></th>
                  <th style="width: 40px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Etiqueta</font></font></th>
                </tr>
                <tr>
                  <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1)</font></font></td>
                  <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Actualiza el software</font></font></td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-red"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">55%</font></font></span></td>
                </tr>
                <tr>
                  <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">2)</font></font></td>
                  <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Base de datos limpia</font></font></td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-yellow"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">70%</font></font></span></td>
                </tr>
                <tr>
                  <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">3)</font></font></td>
                  <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cron trabajo en ejecución</font></font></td>
                  <td>
                    <div class="progress progress-xs progress-striped active">
                      <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-light-blue"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">30%</font></font></span></td>
                </tr>
                <tr>
                  <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4)</font></font></td>
                  <td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Arreglar y eliminar errores</font></font></td>
                  <td>
                    <div class="progress progress-xs progress-striped active">
                      <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-green"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">90%</font></font></span></td>
                </tr>
              </tbody></table>
            </div>
    <!--________________________________________________________________________-->    
    </div>
</div>