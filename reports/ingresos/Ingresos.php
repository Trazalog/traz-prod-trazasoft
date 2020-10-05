<?php

require  APPPATH . "/modules/".PRD. "/libraries/koolreport/core/autoload.php";

//Specify some data processes that will be used to process
// use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
// use \koolreport\processes\RemoveColumn;
use \koolreport\processes\OnlyColumn;
use \koolreport\processes\Custom;

//Define the class
class Ingresos extends \koolreport\KoolReport
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
    log_message('DEBUG', '#TRAZA| #INGRESOS|#SETTINGS| #INGRESO');
    $json = $this->params;
    $data = json_encode($json);
    // $data = "holanda";

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
    log_message('DEBUG', '#TRAZA| #INGRESOS|#SETUP| #INGRESO');
    $this->src("apiarray")
      ->pipe($this->dataStore("data_ingresos_table"));

    $this->src("apiarray")
      ->pipe($this->dataStore("data_ingresos_pieChart"));

    $this->src("apiarray")
      ->pipe(new OnlyColumn(array(
        "nombre", "neto"
      )))
      ->pipe(new Sort(array(
        "neto" => "desc"
      )))
      ->pipe(new Limit(
        array(6)
      ))
      ->pipe($this->dataStore("data_ingresos_clumnChart"));
  }
}
