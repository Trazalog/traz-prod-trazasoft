<?php

require  APPPATH . "/modules/".PRD. "/libraries/koolreport/core/autoload.php";

//Specify some data processes that will be used to process
// use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
// use \koolreport\processes\RemoveColumn;
use \koolreport\processes\OnlyColumn;

//Define the class
class Asignacion_de_recursos extends \koolreport\KoolReport
{
  use \koolreport\codeigniter\Friendship;
  /*Filtros Avanzados*/
  /*Enlace de datos entre los parámetros del informe y los Controles de entrada */

  function cacheSettings()
  {
    return array(
      "ttl" => 60, //determina cuántos segundos será válido el caché
    );
  }

  protected function settings()
  {
    log_message('DEBUG', '#TRAZA| #ASIGNACIONDERECURSOS|#SETTINGS| #INGRESO');
    $json = $this->params;
    $data = json_encode($json);

    return array(
      "dataSources" => array(
        "apiarray" => array(
          "class" => '\koolreport\datasources\ArrayDataSource',
          "dataFormat" => "associate",
          "data" => json_decode($data, true),
        )
      )
    );
  }

  protected function setup()
  {
    log_message('DEBUG', '#TRAZA| #ASIGNACIONDERECURSOS|#SETUP| #INGRESO');
    $this->src("apiarray")
      ->pipe($this->dataStore("data_asignacion_recurso_table"));

    $this->src("apiarray")
      ->pipe($this->dataStore("data_asignacion_recurso_pieChart"));

    $this->src("apiarray")
      ->pipe($this->dataStore("data_asignacion_recurso_clumnChart"));
  }
}
