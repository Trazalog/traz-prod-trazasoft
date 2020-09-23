<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('lang_get')){

    function lang_get($leng = false, $page = false)
    {
        // if($leng == 'spanish')
        // {
        //     $resource = 'languageesp'; 
        // }
        // if($leng == 'english')
        // {
        //     $resource = 'languageing'; 
        // }
        // $parametros["http"]["method"] = "GET";		 
        // $param = stream_context_create($parametros);
       	
        // $url = 'http://localhost:8080/'.$resource;
        // $lang = file_get_contents($url, false, $param);
        // $lang = json_decode($lang,true);
        $lang = json_decode(
            '{
                "labels": {
                    "label": [
                        {
                            "id": "codigo",
                            "texto": "Codigo"
                        },
                        {
                            "id": "id",
                            "texto": "id"
                        },
                        {
                            "id": "descripcion",
                            "texto": "Descripcion"
                        },
                        {
                            "id": "proveedores",
                            "texto": "Proveedores"
                        },
                        {
                            "id": "cantidad",
                            "texto": "Cant. Pedida"
                        },
                        {
                            "id": "stock",
                            "texto": "Stock"
                        }
                    ]
                }
            }'
        );
        $lang = $lang->labels->label;
        //var_dump($lang);die;
        $lenguaje =  array();
        for($i=0;$i<count($lang);$i++)
        { 
            $aux = array($lang[$i]->id=> $lang[$i]->texto);
            $lenguaje = array_merge($lenguaje,$aux);
        }
        return $lenguaje;
    }
}