<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('login')){

    function login($dir)
    {
        redirect(DNATO.'main/setdir?direccion='.base_url().'Dash&direccionsalida='.base_url().'Login');
    }

}
if(!function_exists('logout')){

    function logout()
    {
        redirect(DNATO.'main/logout');
    }
    
}
if(!function_exists('editar')){

    function editar()
    {
        redirect(DNATO.'main/changeuser');
    }
    
}  