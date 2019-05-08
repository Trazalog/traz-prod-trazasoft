<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('login')){

    function login($dir)
    {
        redirect('http://localhost/Dnato/main/setdir?direccion='.$dir.'/Dash&direccionsalida='.$dir.'/Login');
    }

}
if(!function_exists('logout')){

    function logout()
    {
        redirect('http://localhost/Dnato/main/logout');
    }
    
}
if(!function_exists('editar')){

    function editar()
    {
        redirect('http://localhost/Dnato/main/changeuser');
    }
    
}
