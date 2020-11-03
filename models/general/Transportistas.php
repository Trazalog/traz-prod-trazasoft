<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Transportistas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener()
    {
        $url = REST_LOG . '/transportistas';
        return wso2($url);
    }
    
}