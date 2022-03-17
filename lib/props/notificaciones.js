function hecho(msj="Hecho", detalle="Guardado con Éxito!"){
    Swal.fire(
        msj,
        detalle,
        'success'
      )
}

function rehecho(msj="Hecho", detalle="Guardado con Éxito!"){
  Swal.fire(
      msj,
      detalle,
      'success'
    ).then((result) => {
      $('.modal-backdrop ').remove();
      if(result.value) linkTo();
    });
}

function error(msj='Error!', detalle="Algo salio mal"){
    Swal.fire(
        msj,
        detalle,
        'error'
      )
}

function falla() {
  alert('Falla');
}

function msj(msj){
  alert(msj);
}

function bolita(texto, color, detalle = null)
{
    return `<span data-toggle='tooltip' title='${detalle}' class='badge bg-${color} estado'>${texto}</span>`;
}

var s_foco = false;
function foco(id = false) {
  if(id){
    s_foco = id;
    $(id).css('z-index', '9999999999999');
    $('#mdl-back').modal('show');
  }else{
    $(s_foco).css('z-index', '0');
    $('#mdl-back').modal('hide');
  }
}

function conf(fun, e, pregunta = 'Confirma realizar esta acción?', msj = "Esta acción no se pordrá revertir") {
  Swal.fire({
      title: pregunta,
      text: msj,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
      cancelButtonText: 'No, Cancelar!'
  }).then((result) => {
      if (result.value) {
          fun(e);
      }
  });
}