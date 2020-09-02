<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

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
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

# DNATO
define('LOGIN', true);
define('DNATO', 'http://localhost/traz-comp-dnato/');

#TRAZ-COMP-BPM
define('BPM', 'traz-comp-bpm/');

define('BONITA_URL', 'http://10.142.0.7:8080/bonita/');

define('BPM_PROCESS_ID_PEDIDOS_NORMALES', '8803232493891311406');

define('BPM_PROCESS_ID_PEDIDOS_EXTRAORDINARIOS', '6013058915384903051');

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
define('REST_ALM', 'http://10.142.0.7:8280/services/ALMDataService/');
define('viewOT', false);

#COMPONENTE FORMULARIOS
define('FRM', 'traz-comp-form/');
define('FILES', 'files/');

#COMPONENTE TAREAS
define('TSK', 'traz-comp-tareas/');

#COMPONENTE TAREASSESTANDAR
define('TST', 'traz-comp-tareasestandar/');
define('REST_TST', 'http://10.142.0.7:8280/services/TareasSTD/');
define('CAL', 'traz-comp-calendar/');


#REST
define('TAREAS_ASIGNAR', 'traz-comp-tareasestandar/asignar');

define('REST', 'http://10.142.0.7:8280/services/PRDDataService/');
define('RESTPT', 'http://10.142.0.7:8280/services/PRDDataService/');
define('REST_TDS', 'http://10.142.0.7:8280/services/PRDDataService/');
define('REST2', 'http://10.142.0.7:8280/services/PRDDataService');
define('REST3', 'http://10.142.0.7:8280/services/PRDDataService');
define('REST4', 'http://10.142.0.7:8280/services/PRDDataService');
define('REST_PRD_LOTE', 'http://10.142.0.7:8280/services/PRDLoteDataService');
define('REST_CORE', 'http://10.142.0.7:8280/services/COREDataService/');
define('REST_PRD_ETAPA', 'http://10.142.0.7:8280/services/PRDEtapaDataService');

#TOOLS-PRD DATASERVICES /*NUEVOS*/
define('PRD_Etapa_DS', 'http://10.142.0.7:8280/services/PRDEtapaDataService/');
define('PRD_Lote_DS', 'http://10.142.0.7:8280/services/PRDLoteDataService/');
define('LOG_DS', 'http://10.142.0.3:8280/services/LOGDataService/');
define('CORE_DS','http://10.142.0.7:8280/services/COREDataService/');

//TODO:AGREGAR AL CONSTANT ORIGINAL
#RECURSOS_LOTES
define('MATERIA_PRIMA', 'MATERIA_PRIMA');
define('PRODUCTO', 'PRODUCTO');
define('EQUIPO', 'EQUIPO');
define('RECURSO_HUMANO', 'HUMANO');
define('RECURSO_CONSUMO', 'CONSUMO');

# >> Proyecto
# Default View
// define('DEFAULT_VIEW', 'general/Reporte/tareasOperario');
define('DEFAULT_VIEW', 'Test/test2');

#TRAZASOFT
define('PROVEEDOR_INTERNO', 1000);
define('FEC_VEN', '01-01-3000');

#Deposito que contienen todos los reci_id que estan en transporte
define('DEPOSITO_TRANSPORTE', 1000);
define('ESTABLECIMIENTO_TRANSPORTE', 1000);

#ID DE ETAPA
define('ETAPA_TRANSPORTE', 1000);
define('ETAPA_DEPOSITO', 2000);

# >> HELPER WSO2
// define('REST_ALM', 'http://10.142.0.7:8280/services/ALMDataService/');

# >> ALM AVANZAR TASK
define('PLANIF_AVANZA_TAREA', true);

define('LIB', 'lib/');

define('RSP_LOTE', [
  "TOOLSERROR:RECI_NO_VACIO_DIST_ART" => "El recipiente contiene artículos distintos",
  "TOOLSERROR:RECI_NO_VACIO_DIST_LOTE_IGUAL_ART" => "El recipiente contiene lotes distintos",
  "TOOLSERROR:RECI_NO_VACIO_IGUAL_ART_LOTE" => "El recipiente contiene los mismos lotes y artículos"
]);


define('BPM_PROCESS', json_encode(array(
  '8803232493891311406' => ['nombre' => 'Ped. Materiales', 'color' => '#F39C12', 'proyecto' => ALM, 'model' => 'ALM_Tareas'],
  '6013058915384903051' => ['nombre' => 'Ped. Materiales Ext', 'color' => '#F39C12', 'proyecto' => ALM, 'model' => 'ALM_Tareas'],
  '8664799170016058315' => ['nombre' => 'Proc. Mantenimiento', 'color' => '#00A65A', 'proyecto' => 'traz-comp-mantenimiento/', 'model' => 'MAN_Tareas']
)));
