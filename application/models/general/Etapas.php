<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Etapas extends CI_Model
{
		function __construct()
		{
				parent::__construct();
		}
		// trae listado de etapas con sus datos (Tabla)
    function listar()
    {
			//TODO: DESHARDCODEAR SERVICIO
			$parametros["http"]["method"] = "GET";
			$parametros["http"]["header"] = "Accept: application/json";	 		 
			$param = stream_context_create($parametros);
			$resource = '/lotes';	 	
			$url = REST3.$resource;
			//$url = 'http://pc-pc:8280/services/produccionTest/lotes';
			$array = file_get_contents($url, false, $param);

			return json_decode($array);		
		
		}
		// Listado de etapas estandar para seleccionar
    function listarEtapas()
    {
       
        // $parametros["http"]["method"] = "GET";		 
        // $param = stream_context_create($parametros);
        // $resource = 'etapas';	 	
        // $url = REST.$resource;
        // $array = file_get_contents($url, false, $param);
				// return json_decode($array);
				
				$respuesta = '{
					"etapas":
					{"etapa":
					[{
					"id":1,
					"titulo":"finca",
					"icon":"",
					"link":"general/Etapa/nuevo?op=1"
					},
					{
					"id":2,
					"titulo":"seleccion",
					"icon":"",
					"link":"general/Etapa/nuevo?op=2"
					},
					{
					"id":3,
					"titulo":"pelado",
					"icon":"",
					"link":"general/Etapa/nuevo?op=3"
					},
					{
					"id":4,
					"titulo":"estacionamiento",
					"icon":"",
					"link":"general/Etapa/nuevo?op=4"
					},
					{
					"id":5,
					"titulo":"fraccionamiento",
					"icon":"",
					"link":"general/Etapa/fraccionar"
					}
					]
					}
					}';

				$resource = json_decode($respuesta);
				return $resource;
    }
    function buscar($id)
    {
			
        // $parametros["http"]["method"] = "GET";		 
        // $param = stream_context_create($parametros);
        // if ($id == 1)
        // {
        //     $resource = 'etapaeditar';	
        // }
        // if ($id == 3)
        // {
        //     $resource = 'fraccioneditar';	
        // }
        // $url = REST.$resource;
        // $array = file_get_contents($url, false, $param);
				// return json_decode($array);
				// $parametros["http"]["method"] = "GET";
				// $parametros["http"]["header"] = "Accept: application/json";			 
        // $param = stream_context_create($parametros);
        // //if ($id == 1)
        // //{
        //     $resource = '/lote/';	
        // //}
        // // if ($id == 3)
        // // {
        // //     $resource = 'fraccioneditar';	
				// // }			
        // $url = REST3.$resource.$id;
				// $array = file_get_contents($url, false, $param);

				//return json_decode($array);
				log_message('DEBUG', 'Etapas/buscar(batch_id)-> '.$id);
				$resource = '/lote/';	 	
				$url = REST3.$resource.$id;
				$array = $this->rest->callAPI("GET",$url); 
				$resp =  json_decode($array['data']);					
				// echo("info de etapa: ");
				// var_dump($resp);
				return $resp;			



    }
    function nuevo($opcion)
    {    
        // $parametros["http"]["method"] = "GET";	
        // $parametros["http"]["header"] = "Accept: application/json";	 
        // $param = stream_context_create($parametros);		
				// $resource = '/etapas/';
				// $url = REST2.$resource.$opcion;   
        // $array = file_get_contents($url, false, $param);
				// return json_decode($array);
				
				log_message('DEBUG', 'Etapas/nuevo($opcion)-> '.$opcion);					
		
				$resource = '/etapas/'; 	
				$url = REST2.$resource.$opcion;		
				$array = $this->rest->callAPI("GET",$url); 				
				wso2Msj($array);
				return json_decode($array['data']);
		}
		// devuelve id recurso por id articulo
		function getRecursoId($arti_id){
			
			$resource = '/recurso/';	 	
			$url = REST2.$resource.$arti_id;
			$array = $this->rest->callAPI("GET",$url,  $data); 
			$resp =  json_decode($array['data']);					
			$recu_id = $resp->recurso->recu_id;
			return $recu_id;		
		}
		// guarda prod en recursos lotes (productos)		
		function setRecursosLotesProd($batch_id, $recu_id, $cantidad)	{
				
				log_message('DEBUG', 'Etapas/setRecursos(batch_id)-> '.$batch_id);
				log_message('DEBUG', 'Etapas/setRecursos(tipoRecurso)-> '.PRODUCTO);				
				log_message('DEBUG', 'Etapas/setRecursos(recu_id)-> '.$recu_id);
				log_message('DEBUG', 'Etapas/setRecursos(cantidad)-> '.$cantidad);	
				$arrayDatos['batch_id'] = (string)$batch_id;
				$arrayDatos['recu_id'] = (string)$recu_id;		
				$arrayDatos['usuario'] = userNick();
				$arrayDatos['empr_id'] = (string)empresa();
				$arrayDatos['cantidad'] = (string)$cantidad;
				$arrayDatos['tipo'] = PRODUCTO;					
				$data['_post_recurso'] = $arrayDatos;
				// mens en log
				$datos = json_encode($data);
				log_message('DEBUG', 'Etapas/setRecursosLotes(recursos a grabar)-> '.$datos);					
		
				$resource = '/recurso/lote';	 	
				$url = REST2.$resource;			
				$array = $this->rest->callAPI("POST",$url, $data); 				
				wso2Msj($array);
				return json_decode($array['status']);
		}	
		// guarda prod en recursos lotes (articulos)
		function setRecursosLotesMat($data)	{
					
				log_message('DEBUG', 'Etapas/setRecursos(materias a grabar)-> '.$data);	

				$resource = '/recurso/lote_batch_req';	 	
				$url = REST2.$resource;	
				$array = $this->rest->callAPI("POST", $url, $data); 				
				wso2Msj($array);
				return json_decode($array['status']);	
		}
		// Inicia nueva Etapa (ej siembra)
		function SetNuevoBatch($data){
				$arrayBatch = json_encode($data);
				log_message('DEBUG', 'Etapas/SetNuevoBatch(datos)-> '.$arrayBatch);
				$resource = '/lote';	 	
        $url = REST4.$resource;
				$array = $this->rest->callAPI("POST",$url,  $data); 
				wso2Msj($array);
				return json_decode($array['data']);
		}
		// Guarda cabecera de Nota de pedido
    function setCabeceraNP($data){
				log_message('DEBUG', 'Etapas/setCabeceraNP(datos)-> '.json_encode($data));        
        $resource = '/notapedido';	 	
        $url = REST2.$resource;       
				$array = $this->rest->callAPI("POST", $url, $data);	
				return json_decode($array['data']);
    }
		// Guarda detalle de Nota de pedido
    function setDetaNP($arrayDeta){			

				log_message('DEBUG', 'Etapas/setDetaNP(datos)-> '.json_encode($arrayDeta)); 
				$resource = '/_post_notapedido_detalle_batch_req';	 	
				$url = REST2.$resource;				 
				$array = $this->rest->callAPI("POST", $url, $arrayDeta);
				return json_decode($array['code']);
		}
		// devuelve cantidad de prod por batch_id
		//TODO: REVISAR CREO ESTA DEPRECADA POR GETRECURSOSORIGEN
		function getCantProducto($id){
			
			$idBatch = json_encode($id);
			log_message('DEBUG', 'Etapas/getCantProducto(batch_id)-> '.$idBatch);
			$resource = '/lote/existencia/';	 	
			$url = REST4.$resource.$id;
			$array = $this->rest->callAPI("GET",$url,  $id); 		
			return json_decode($array['data']);
		}
		// devuelve nombre de prod por batch_id
		//TODO: REVISAR CREO ESTA DEPRECADA POR GETRECURSOSORIGEN
		function getNomProducto($id){

			$idBatch = json_encode($id);
			log_message('DEBUG', 'Etapas/getNomProducto(batch_id)-> '.$idBatch);
			$resource = '/articulo/nombre/';	 	
			$url = REST2.$resource.$id;
			$array = $this->rest->callAPI("GET",$url,  $id); 		
			return json_decode($array['data']);
		}
		// devuelve de recursos_lotes materia prima y producto segun id batch y tipo  
		function getRecursosOrigen($id, $recursoTipo){
			
			$idBatch = json_encode($id);
			log_message('DEBUG', 'Etapas/getRecursosOrigen(batch_id)-> '.$idBatch);
			log_message('DEBUG', 'Etapas/getRecursosOrigen(tipo de recurso)-> '.$recursoTipo);
			
			$resource = '/recurso/lote/'.$id.'/tiporec/'.$recursoTipo;	 	
			$url = REST2.$resource;
			//var_dump($url);
			$array = $this->rest->callAPI("GET",$url,  $id); 		
			
			return json_decode($array['data']);
		}
		// Informe de Etapa (modal_finaizar)
		function finalizarEtapa($arrayDatos){

			log_message('DEBUG', 'Etapas/finalizarEtapa(datos)-> '.json_encode($arrayDatos)); 

			$resource = '/lote';	 	
			$url = REST4.$resource;				 
			$array = $this->rest->callAPI("POST", $url, $arrayDatos);			
			return json_decode($array['status']);
		}
		//TODO: BOORAR DEPRECADA
		// Guarda fraccionamiento temp Etapa Fraccionamiento
    function setFraccionamTemp($fraccionam){			

			log_message('DEBUG', 'Etapas/setFraccionamTemp(fraccionam)-> '.json_encode($fraccionam)); 
			$resource = '/_post_fraccionamiento_batch_req';	 	
			$url = REST2.$resource;				 
			$array = $this->rest->callAPI("POST", $url, $fraccionam);
			return json_decode($array['code']);
		}
		//TODO: FUNCION DEPRECADA ORIGINAL DE JUDAS
		// guarda Inicia etapa fraccionamiento
		function guardarFraccionar($data){
			echo("datos en model de iniciar fraccionado: ");
			var_dump($data);
		}


}