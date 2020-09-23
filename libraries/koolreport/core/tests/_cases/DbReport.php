<?php
require_once dirname(__FILE__)."/../../autoload.php";

class DbReport extends \koolreport\KoolReport
{
    protected function settings()
    {
        return array(
            "dataSources"=>array(
                "automaker"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=automaker",
                    "username"=>"root",
                    "password"=>"",
                    "charset"=>"utf8"
                ),
                "sakila"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=sakila",
                    "username"=>"root",
                    "password"=>"",
                    "charset"=>"utf8"
                ),
                "world"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=world",
                    "username"=>"root",
                    "password"=>"",
                    "charset"=>"utf8"
                ),            
            )
        );
    }
}