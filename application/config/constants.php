<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

# DNATO
define('LOGIN', false);
define('DNATO','http://localhost/traz-comp-dnato/');

#TRAZ-COMP-BPM
define('BPM', 'traz-comp-bpm/');

define('BONITA_URL', 'http://35.243.231.36:8080/bonita/');

define('BPM_PROCESS_ID_PEDIDOS_NORMALES', '6352939331165329370');

define('BPM_PROCESS_ID_PEDIDOS_EXTRAORDINARIOS', '6013058915384903051');

define('BPM_PROCESS', json_encode(array(
    '6352939331165329370' => ['nombre' => 'Ped. Materiales', 'color' => '#F39C12'],
    '6013058915384903051' => ['nombre' => 'Ped. Materiales Ext', 'color' => '#F39C12'],
    '7503443566840192735' => ['nombre' => 'Proc. Mantenimiento', 'color' => '#00A65A'],
)));

define('BPM_ADMIN_USER', 'almacen.tools');
define('BPM_ADMIN_PASS', 'bpm');
define('BPM_USER_PASS', 'bpm');

#ERRORES DE BONITA
define('ASP_100', 'Fallo Conexión BPM');
define('ASP_101', 'Error al Inciar Proceso');
define('ASP_102', 'Error al Tomar Tarea');
define('ASP_103', 'Error al Soltar Tarea');
define('ASP_104', 'Error al Cerrar Tarea');
define('ASP_105', 'Error al Obtener Vista Global');
define('ASP_106', 'Error al Obtener Usuarios');
define('ASP_107', 'Error al Asignar Usuario');
define('ASP_108', 'Error al Guardar Comentarios');
define('ASP_109', 'Error de Loggin');
define('ASP_110', 'Error al Obtener Detalle Tarea');
define('ASP_111', 'Error al Obtener Bandeja de Tareas');
define('ASP_112', 'Error al Obtener Comentarios');
define('ASP_113', 'Usuario No Encontrado');
define('ASP_114', 'Error al Actualizar Variable');
define('ASP_115', 'Error al Leer Variable');


#COMPONENTE ALMACENES
define('ALM', 'traz-comp-almacen/');
define('viewOT', false);

#COMPONENTE FORMULARIOS
define('FRM', 'traz-comp-form/');
define('FILES', 'files/');

#COMPONENTE TAREAS
define('TSK', 'traz-comp-tareas/');

#REST
define('TAREAS_ASIGNAR', 'traz-comp-tareasestandar/asignar');

define('REST', 'http://dev-trazalog.com.ar:8280/services/ProduccionDataService/');
define('RESTPT','http://dev-trazalog.com.ar:8280/services/produccionTest/');
define('REST_TDS','http://dev-trazalog.com.ar:8280/services/TrazabilidadDataService/');
define('REST2', 'http://dev-trazalog.com.ar:8280/services/ProduccionDataService');
define('REST3', 'http://dev-trazalog.com.ar:8280/services/produccionTest');
define('REST4', 'http://dev-trazalog.com.ar:8280/services/TrazabilidadDataService');


//TODO:AGREGAR AL CONSTANT ORIGINAL
#RECURSOS_LOTES
define('MATERIA_PRIMA', 'MATERIA_PRIMA');
define('PRODUCTO', 'PRODUCTO');
define('EQUIPO', 'EQUIPO');
define('RECURSO_HUMANO', 'HUMANO');
define('RECURSO_CONSUMO', 'CONSUMO');



# >> Proyecto
# Default View
#define('DEFAULT_VIEW', 'general/Reporte/tareasOperario');
define('DEFAULT_VIEW', 'general/Establecimiento');

#TRAZASOFT
define('PROVEEDOR_INTERNO', 1000);

#Deposito que contienen todos los reci_id que estan en transporte
define('DEPOSITO_TRANSPORTE', 1000);
define('ESTABLECIMIENTO_TRANSPORTE', 1000);

#ID DE ETAPA
define('ETAPA_TRANSPORTE', 1000);
define('ETAPA_DEPOSITO', 2000);
