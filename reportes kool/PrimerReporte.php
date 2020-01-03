<?php

// Require autoload.php from koolreport library
require_once "../koolreport/core/autoload.php";

//Specify some data processes that will be used to process
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;

//Define the class
class PrimerReporte extends \koolreport\KoolReport
{
    use \koolreport\codeigniter\Friendship; // All you need to do is to claim this friendship
    // Por defecto, el informe que tiene amistad con CodeIgniter exportará automáticamente todos sus recursos a 
    // la ubicación predeterminada que es {project_folder}/assets/koolreport_assets. 

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
    }

    protected function setup()
    {
        //Now you can access database that you configured in CodeIgniter, puede usarse con varias fuentes de datos,
        //se deben configurar en la function settings()
        $this->src("tools_test")
            // ->query("select * from orders")
            ->pipe($this->dataStore("primer_reporte"));
    }

    //Mas documentacion de CI en https://www.koolreport.com/forum/topics/31
}
