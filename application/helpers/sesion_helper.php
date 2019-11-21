<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('userId')){

    function userId()
    {
        return 102;//!HARDCODE

        $ci =& get_instance();			
        $userdata  = $ci->session->userdata('user_data');
		return  $userdata[0]['userBpm'];
    }
}

if(!function_exists('userNick')){
    
    function userNick()
    {
        return 'supervisor1'; //!HARDCODE
        $ci =& get_instance();			
        $userdata  = $ci->session->userdata('user_data');
		return  $userdata[0]['usrNick'];
    }
}

if(!function_exists('userPass')){

    function userPass()
    {
        return BPM_USER_PASS;
    }
}

if(!function_exists('empresa')){

   
    function empresa(){
        return 1; //!HARDCODE
        $ci =& get_instance();			
        $userdata  = $ci->session->userdata('user_data');
		return  empresa();
    }
}