<?php

// Require autoload.php from koolreport library
// require_once "../koolreport/core/autoload.php";
require APPPATH . "/modules/".PRD."/libraries/koolreport/core/autoload.php";

//Specify some data processes that will be used to process
// use \koolreport\processes\Group;
// use \koolreport\processes\Sort;
// use \koolreport\processes\Limit;
// use \koolreport\processes\RemoveColumn;
use \koolreport\processes\OnlyColumn;

//Define the class
class Primer_Reporte extends \koolreport\KoolReport
{
    use \koolreport\clients\Bootstrap;
    use \koolreport\codeigniter\Friendship; // All you need to do is to claim this friendship
    // Por defecto, el informe que tiene amistad con CodeIgniter exportará automáticamente todos sus recursos a 
    // la ubicación predeterminada que es {project_folder}/assets/koolreport_assets. 
    // use \libraries\koolreport\codeigniter\Friendship;

    function cacheSettings()
    {
        return array(
            "ttl" => 60, //determina cuántos segundos será válido el caché
        );
    }

    protected function settings()
    {
        // Modificar la ruda predeterminada:
        // return array(
        //     "assets" => array(
        //         "url" => "myassets",
        //         "path" => "../myassets" // or "path"=>"/var/html/CIProject/myassets"
        //     )
        // );
        //El path puede tener la ruta relativa de su informe a la carpeta de activos o puede ser ruta absoluta.
        // La urlcarpeta es url to assets a la que se puede acceder a través del navegador.
        // return array(
        //     "assets" => array(
        //         "path" => "../../assets",
        //         "url" => "http://localhost/Trazalog/traz-prod-trazasoft/assets",
        //     ),
        //     "dataSources" => array(
        //         "tools_test" => array(
        //             "connectionString" => "pgsql:host=dev-trazalog.com.ar;port=5432;dbname=tools_test",
        //             "username" => "arbolado",
        //             "password" => "password",
        //             "charset" => "utf8",
        //             "port" => '5432'
        //         )
        //     )
        // );

        $json = $this->params;
        $data = json_encode($json);

        return array(
            "dataSources" => array(
                "apiarray" => array(
                    "class" => '\koolreport\datasources\ArrayDataSource',
                    "dataFormat" => "associate",
                    "data" => json_decode(utf8_encode("$data"), true),
                )
            )
        );
    }

    protected function setup()
    {
        //Now you can access database that you configured in CodeIgniter, puede usarse con varias fuentes de datos,
        //se deben configurar en la function settings()
        $this->src("apiarray")
            ->pipe(new OnlyColumn(array(
                "titulo", "stock", "unidad_medida", "estado"
            )))
            ->pipe($this->dataStore("primer_reporte"));

        $this->src("apiarray")
            // ->pipe(new RemoveColumn(array(
            //     "extraInfo","unwantedColumn"
            // )))
            ->pipe(new OnlyColumn(array(
                "titulo", "stock"
            )))
            ->pipe($this->dataStore("grafico_torta"));
    }

    //Mas documentacion de CI en https://www.koolreport.com/forum/topics/31
}
