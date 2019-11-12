<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Etapas extends CI_Model
{
		function __construct()
		{
				parent::__construct();
    }
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
					"titulo":"siembra",
					"icon":"",
					"link":"general/Etapa/nuevo?op=1"
					},
					{
					"id":2,
					"titulo":"zaranda",
					"icon":"",
					"link":"general/Etapa/nuevo?op=2"
					},
					{
					"id":3,
					"titulo":"limpieza",
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
				$parametros["http"]["method"] = "GET";
				$parametros["http"]["header"] = "Accept: application/json";			 
        $param = stream_context_create($parametros);
        //if ($id == 1)
        //{
            $resource = '/lote/';	
        //}
        // if ($id == 3)
        // {
        //     $resource = 'fraccioneditar';	
				// }			
        $url = REST3.$resource.$id;
				$array = file_get_contents($url, false, $param);

        return json_decode($array);


    }
    function nuevo($opcion)
    {
        // if($opcion == 3)
        // {
        //     $resource = 'fraccionarnuevo';
        // }else{
        //     $resource = 'etapasnuevo';
        // }

       //TODO: DESHARDCODEAR LA UR DEL RECURSO Y EL NUMERO DE ETAPA

        
        $parametros["http"]["method"] = "GET";	
        $parametros["http"]["header"] = "Accept: application/json";	 
        $param = stream_context_create($parametros);
				//$url = 'http://PC-PC:8280/services/ProduccionDataService/etapas/1';
				$resource = '/etapas/';
				$url = REST2.$resource.$opcion;   
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
		}
		
		// Inicia nueva Etapa (ej siembra)
		function SetNuevoBatch($data)
		{
				$arrayBatch = json_encode($data);
				log_message('DEBUG', 'Etapas/SetNuevoBatch(datos)-> '.$arrayBatch);
				$resource = '/lote';	 	
        $url = REST4.$resource;
        $array = $this->rest->callAPI("POST",$url,  $data); 
				return $array['data'];
		}

    function setCabeceraNP($data)
    {
				log_message('DEBUG', 'Etapas/setCabeceraNP(datos)-> '.json_encode($data));        
        $resource = '/notapedido';	 	
        $url = REST2.$resource;
       
				$array = $this->rest->callAPI("POST", $url, $data);			
				echo("resp set cabecera: ");
				var_dump($array);	
				return $array['data'];
    }


    function setDetaNP($arrayDeta){
			
				//$url = 'http://PC-PC:8280/services/ProduccionDataService/_post_notapedido_detalle_batch_req';
			
				log_message('DEBUG', 'Etapas/setDetaNP(datos)-> '.json_encode($arrayDeta)); 
				$resource = '/_post_notapedido_detalle_batch_req';	 	
				$url = REST2.$resource;				 
				$array = $this->rest->callAPI("POST", $url, $arrayDeta);	
				return $array;
    }

		// Informe de Etapa (modal_finaizar)
		function finalizarEtapa($arrayDatos){

			// $data = json_encode($arrayDatos);
			// $parametros["http"]["method"] = "POST";
			// $parametros["http"]["header"] = "Accept: application/json";	 
			// $parametros["http"]["header"] = "Content-Type: application/json";
			// $parametros["http"]["content"] = $data;	 		 
			// $param = stream_context_create($parametros);	
			// $resource = '/lote/deposito/ingresar';	 	
			// $url = REST4.$resource;			
			// $array = file_get_contents($url, false, $param); 
			// return $array;	

			log_message('DEBUG', 'Etapas/finalizarEtapa(datos)-> '.json_encode($arrayDatos)); 

			//TODO: PREGUNTAR SI SE PUEDE HACER UN BATCH_REQUEST O MANDAR DE AUNO CADA VEZ
			$resource = '/lote';	 	
			$url = REST4.$resource;				 
			$array = $this->rest->callAPI("POST", $url, $arrayDatos);	
			return $array;

		}



}