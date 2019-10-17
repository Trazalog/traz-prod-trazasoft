navigator.geolocation.getCurrentPosition(success, error, options);
function obtenerPosicion() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success, error, options);
        return (lat && lon);
    } else {
        console.log('GSP | No Activado');
        return false;
    }
}

var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};

var lat = false;
var lon = false;
var ac = false;
var accMax =  parseInt($('#gps-acc').val());

function success(pos) {
    var crd = pos.coords;
    if ((crd.accuracy != null) || (cdr.acurrary < accMax)) {
        lat = crd.latitude;
        lon = crd.longitude;
        ac = crd.accuracy;
    } else {
        lat = false;
        lon = false;
        ac = false;
    }
};

function error(err) {
    console.log('GPS | ERROR(' + err.code + '): ' + err.message);
    lat = false;
    lon = false;
    ac = false;
};

