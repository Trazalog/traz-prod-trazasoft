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
        
        // $parametros["http"]["method"] = "GET";		 
        // $param = stream_context_create($parametros);
        // $resource = 'etapatodo';	 	
        // $url = REST.$resource;
        // $array = file_get_contents($url, false, $param);
				// return json_decode($array);
				
			$respuesta = '{"etapas":
				{
			"etapa":[
				 {"id":1,
				 "titulo":"siembra",
				 "producto": "ajo Morado",
				 "cantidad": 500,
				 "unidad": "m2",
				 "establecimiento":"finca 3",
				 "recipiente": "Parcela 2",
				 "orden": 73
				 },
				 {"id":2,
				 "titulo":"siembra",
				 "producto": "ajo Blanco grande",
				 "cantidad": 300,
				 "unidad": "m2",
				 "establecimiento":"finca 1",
				 "recipiente": "Deposito 22",
				 "orden": 7
				 },
				 {"id":3,
				 "titulo":"fraccionamiento",
				 "producto": "ajo Morado limpio",
				 "cantidad": 1500,
				 "unidad": "cajas",
				 "establecimiento":"Almace 13",
				 "recipiente": "Deposito 24",
				 "orden": 14
				 },
				 {"id":4,
				 "titulo":"zaranda",
				 "producto": "ajo Morado",
				 "cantidad": 800,
				 "unidad": "m2",
				 "establecimiento":"Bahia 3",
				 "recipiente": "Deposito 2",
				 "orden": 15
				 },
				 {"id":5,
				 "titulo":"estacionamiento",
				 "producto": "ajo Morado fraccionado",
				 "cantidad": 800,
				 "unidad": "cajas",
				 "establecimiento":"Almacen 1",
				 "recipiente": "Deposito 2",
				 "orden": "" 
				 },
				 {"id":6,
				 "titulo":"siembra",
				 "producto": "ajo Organico",
				 "cantidad": 1500,
				 "unidad": "m2",
				 "establecimiento":"finca 2",
				 "recipiente": "Parcela 3",
				 "orden": 16
				 },
				 {"id":7,
				 "titulo":"limpieza",
				 "producto": "ajo Morado",
				 "cantidad": 500,
				 "unidad": "cajas",
				 "establecimiento":"finca 3",
				 "recipiente": "Deposito 2",
				 "orden": 73
				 },
				 {"id":8,
				 "titulo":"fraccionamiento",
				 "producto": "ajo Chico",
				 "cantidad": 200,
				 "unidad": "m2",
				 "establecimiento":"finca 3",
				 "recipiente": "Deposito 5",
				 "orden": 4
				 },
				 {"id":9,
				 "titulo":"limpieza",
				 "producto": "ajo Morado",
				 "cantidad": 150,
				 "unidad": "cajas",
				 "establecimiento":"Almacen 3",
				 "recipiente": "Deposito 21",
				 "orden": 16
				 },
				 {"id":10,
				 "titulo":"limpieza",
				 "producto": "ajo Morado",
				 "cantidad": 500,
				 "unidad": "m2",
				 "establecimiento":"finca 3",
				 "recipiente": "Deposito 4",
				 "orden": 8
				 },
				 {"id":11,
				 "titulo":"estacionamiento",
				 "producto": "ajo Organico limpio",
				 "cantidad": 800,
				 "unidad": "cajas",
				 "establecimiento":"finca 4",
				 "recipiente": "Parcela 5",
				 "orden": ""
				 },
				 {"id":12,
				 "titulo":"zaranda",
				 "producto": "ajo Morado",
				 "cantidad": 1500,
				 "unidad": "m2",
				 "establecimiento":"finca 3",
				 "recipiente": "Deposito 2",
				 "orden": 8
				 },
				 {"id":13,
				 "titulo":"zaranda",
				 "producto": "ajo Grande",
				 "cantidad": 800,
				 "unidad": "m2",
				 "establecimiento":"finca 1",
				 "recipiente": "Parcela 4",
				 "orden": 713
				 },
				 {"id":14,
				 "titulo":"fraccionamiento",
				 "producto": "ajo Azul limpio",
				 "cantidad": 100,
				 "unidad": "cajas",
				 "establecimiento":"Bahia 3",
				 "recipiente": "Deposito 2",
				 "orden": 731
				 },
				 {"id":15,
				 "titulo":"estacionamiento",
				 "producto": "ajo Morado de Calidad",
				 "cantidad": 1500,
				 "unidad": "m2",
				 "establecimiento":"finca 3",
				 "recipiente": "Parcela 42",
				 "orden": 173
				 }
				 ]
				 }
				 }';
				 return $respuesta;
    }
    function listarEtapas()
    {
       
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        $resource = 'etapas';	 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    function buscar($id)
    {
        $parametros["http"]["method"] = "GET";		 
        $param = stream_context_create($parametros);
        if ($id == 1)
        {
            $resource = 'etapaeditar';	
        }
        if ($id == 3)
        {
            $resource = 'fraccioneditar';	
        }
        $url = REST.$resource;
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
		

		function SetNuevoBatch($data)
		{
				$arrayBatch = json_encode($data);

				$parametros["http"]["method"] = "POST";
        $parametros["http"]["header"] = "Accept: application/json";	 
        $parametros["http"]["header"] = "Content-Type: application/json";
        $parametros["http"]["content"] = $arrayBatch;	 		 
        $param = stream_context_create($parametros);	

				$resource = '/lote';	 	
        $url = REST2.$resource;
        //$url = 'http://dev-trazalog.com.ar:8280/services/TrazabilidadDataService/lote';
        $array = file_get_contents($url, false, $param); 				

       	return json_decode($array);
		}

    function setCabeceraNP($cab)
    {
        $cab = json_encode($cab);

        $parametros["http"]["method"] = "POST";
        $parametros["http"]["header"] = "Accept: application/json";	 
        $parametros["http"]["header"] = "Content-Type: application/json";
        $parametros["http"]["content"] = $cab;	 		 
        $param = stream_context_create($parametros);
        $resource = '/notapedido';	 	
        $url = REST2.$resource;
        //$url = 'http://PC-PC:8280/services/ProduccionDataService/notapedido';
        $array = file_get_contents($url, false, $param); 

       	return json_decode($array);
    }


    function setDetaNP($arrayDeta){

				$arrayDeta = json_encode($arrayDeta);	

				$parametros["http"]["method"] = "POST";
				$parametros["http"]["header"] = "Accept: application/json";	 
				$parametros["http"]["header"] = "Content-Type: application/json";
				$parametros["http"]["content"] = $arrayDeta;	

				$param = stream_context_create($parametros);
				$resource = '/_post_notapedido_detalle_batch_req';	 	
				$url = REST2.$resource;
				//$url = 'http://PC-PC:8280/services/ProduccionDataService/_post_notapedido_detalle_batch_req';
				$array = file_get_contents($url, false, $param); 	

				return json_decode($array);	
    }






}