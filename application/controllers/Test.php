<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
       $url = REST_ALM.'pedidos/batch/6801';
       show(wso2($url,'aaaa'));
    }

}
