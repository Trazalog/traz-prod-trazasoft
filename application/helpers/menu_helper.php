<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('menu')){

    function menu($lang,$user)
    {
      
        // $parametros["http"]["method"] = "GET";		 
        // $param = stream_context_create($parametros);
        // $resource = 'menu?user='.$user;	 	
        // $url = REST.$resource;
        // $array = file_get_contents($url, false, $param);
        $array = [];//getJson('menu');//json_decode($array);
       // var_dump($array->menu);die;
        $html = '<ul class="sidebar-menu menu" data-widget="tree">
        <li class="header">'.$lang['navegacion'].'</li>';
        foreach ($array->menus->menu as $i) {

            switch ($i->nivel) {
                case 1:
                    $html .= '<li ><a class="link" href="#" data-link="'.$i->link.'"><i class="'.$i->icono.'"></i>'.$i->titulo.'</a></li>';
                    break;
                case 2:
                    $html .= '<li class="treeview">
                    <a href="#">
                        <i class="'.$i->icono.'"></i> <span>'.$i->titulo.'</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>';
                    $html.= submenu($i->submenu);
                   
                    break;   
                default:
                    break;
            }
            

        }
        return $html.'</ul>';
    }

    function submenu($data)
    {
        $html = ' <ul class="treeview-menu">';
        foreach ($data as $i) {
            $html.= '<li ><a href="#" class="link"data-link="'.$i->link.'"><i class="'.$i->icono.'"></i>'.$i->titulo.'</a></li>';
        }
        return $html.'</ul>';
    }



}