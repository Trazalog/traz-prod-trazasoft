<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Remitos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
	* trae los remitos paginados
	* @param array patron ingresado en pantalla
	* @return array listado de clientes coincidentes con el criterio de busqueda
	*/
    public function listRemitos($start, $lenght, $search, $ordering, $fechaDesde,  $fechaHasta, $cliente){
        
    empty($search) ? $search ="" : $search ;  

    empty($fechaDesde) ? $fechaDesde ="TODOS" : $fechaDesde = date("Y-m-d", strtotime($fechaDesde)); 

    empty($fechaHasta) ? $fechaHasta ="TODOS" : $fechaHasta = date("Y-m-d", strtotime($fechaHasta)); 

    empty($cliente) ? $cliente ="TODOS" : $cliente = $cliente; 
    
    $hasta = date("Y-m-d", strtotime($data["hasta"]));

        $url = REST_CORE."/remitos/".empresa()."/".$lenght."/".$start."/desde/".$fechaDesde."/hasta/".$fechaHasta."/cliente/".$cliente."/search/".$search;

        $aux = $this->rest->callAPI("GET",$url);
        $resp = json_decode($aux['data']);

        if($ordering[0]['column'] != "" && $ordering[0]['dir'] != ""){
            $dataOrdenada = $this->sortTareasBy($resp->remitos->remito, $ordering);
        }

        log_message('DEBUG', "#TRAZA | # #TRAZ-PROD-TRAZASOFT | Remitos | listRemitos()  resp: >> " . json_encode($resp));

        return $dataOrdenada;//$resp->remitos->remito;
    }

    /**
	* Busca cantidad de remitos para armar paginado
	* @param 
	* @return array total de remitos
	*/
    public function cantidadRemitos(){

        $url = REST_CORE."/remitos/cantidad/".empresa();

        $aux = $this->rest->callAPI("GET",$url);
        $resp = json_decode($aux['data']);

        log_message('DEBUG', "#TRAZA | # #TRAZ-PROD-TRAZASOFT | Remitos | cantidadRemitos()  resp: >> " . json_encode($resp));

        return $resp->remitos->remito;
    }

    /**
	* Busca cantidad de remitos con busqueda para armar paginado
	* @param array patron ingresado en pantalla
	* @return array total de remitos
	*/
    public function cantidadRemitosFiltrados($search){

        $url = REST_CORE."/remitosFiltrados/cantidad/".$search."/".empresa();

        $aux = $this->rest->callAPI("GET",$url);
        $resp = json_decode($aux['data']);

        log_message('DEBUG', "#TRAZA | # #TRAZ-PROD-TRAZASOFT | Remitos | cantidadRemitos()  resp: >> " . json_encode($resp));

        return $resp->remitos->remito;
    }

    /**
	*Metodo de ordenamiento para pagina de la tabla remitos
	* @param integer;integer;string start donde comienza el listado; length cantidad de registros; search cadena a buscar
	* @return array listado de remitos paginados
	**/
    function sortTareasBy($data, $ordering) {
        $column = $ordering[0]['column'];
        $direction = $ordering[0]['dir'];
    
        switch ($column) {
            case '1': // Ordenar por nro_remito
                usort($data, function($a, $b) use ($direction) {
                    return ($direction == 'asc') ? strcmp($a->nro_remito, $b->nro_remito) : strcmp($b->nro_remito, $a->nro_remito);
                });
                break;
            case '2': // Ordenar por cliente
                usort($data, function($a, $b) use ($direction) {
                    return ($direction == 'asc') ? strcmp($a->cliente, $b->cliente) : strcmp($b->cliente, $a->cliente);
                });
                break;
            case '3': // Ordenar por fec_alta
                usort($data, function($a, $b) use ($direction) {
                    $dateA = strtotime($a->fec_alta);
                    $dateB = strtotime($b->fec_alta);
                    return ($direction == 'asc') ? $dateA - $dateB : $dateB - $dateA;
                });
                break;
            default:
                // Default case, no sorting
                break;
        }
    
        return $data;
    }

    /**
	* Busca clientes que coincidan con un patron ingresado
	* @param array patron ingresado en pantalla
	* @return array listado de clientes coincidentes con el criterio de busqueda
	*/
    public function buscaClientes($dato){
        
        $url = REST_CORE."/cliente/patron/".$dato."/".empresa();

        $aux = $this->rest->callAPI("GET",$url);
        $resp = json_decode($aux['data']);

        log_message('DEBUG', "#TRAZA | # #TRAZ-PROD-TRAZASOFT | Remitos | buscaClientes()  resp: >> " . json_encode($resp));

        return $resp->clientes->cliente;
    }


    /**
	* trae las lineas del remito por su remi_id
	* @param array remi_id
	* @return array listado de lineas del remito
	*/
    public function getLineasRemito($dato){
        
        $url = REST_CORE."/remitos/lineas/".empresa()."/".$dato;

        $aux = $this->rest->callAPI("GET",$url);
        $resp = json_decode($aux['data']);

        log_message('DEBUG', "#TRAZA | # #TRAZ-PROD-TRAZASOFT | Remitos | getLineasRemito()  resp: >> " . json_encode($resp));

        return $resp->lineas->linea;
    }


    /**
	* trae la version con los articulos y precios
	* @param array remi_id
	* @return array listado de versiones de articulo usados en el remito
	*/
    public function getVersionArticulos($dato){
        
        $url = REST_CORE."/remitos/versiones/".empresa()."/".$dato;

        $aux = $this->rest->callAPI("GET",$url);
        $resp = json_decode($aux['data']);

        log_message('DEBUG', "#TRAZA | # #TRAZ-PROD-TRAZASOFT | Remitos | getVersionArticulos()  resp: >> " . json_encode($resp));

        return $resp->versiones->version;
    }

    

}