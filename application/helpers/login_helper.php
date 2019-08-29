<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('login')){

    function login($dir)
    {
        redirect('http://atom/Dnato/main/setdir?direccion='.$dir.'/Dash&direccionsalida='.$dir.'/Login');
    }

}
if(!function_exists('logout')){

    function logout()
    {
        redirect('http://atom/Dnato/main/logout');
    }
    
}
if(!function_exists('editar')){

    function editar()
    {
        redirect('http://atom/Dnato/main/changeuser');
    }
    
}
