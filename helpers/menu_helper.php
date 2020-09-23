<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('menu')){

    function menu($lang,$user)
    {
        $array = getJson('menu')->menu_items->menu_item;
        $menu = array();
        foreach ($array as $o) {
            if($o->opcion_padre){
               $menu[$o->opcion_padre]->submenu[] = $o;
            }else{
              $menu[$o->opcion] = $o;
            }
        }
        $html = '<ul class="sidebar-menu menu" data-widget="tree">
        <li class="header">'.$lang['navegacion'].'</li>';
        foreach ($array as $i) {

            switch ($i->nivel) {
                case 0:
                    $html .= '<li ><a class="link" href="#" data-link="'.$i->url.'"><i class="'.$i->url_icono.'"></i>'.$i->text.'</a></li>';
                    break;
                case 1:
                    $html .= '<li class="treeview">
                    <a href="#">
                        <i class="'.$i->_url_icono.'"></i> <span>'.$i->texto.'</span>
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
            $html.= '<li ><a href="#" class="link" data-link="'.$i->url.'"><i class="'.$i->url_icono.'"></i>'.$i->texto.'</a></li>';
        }
        return $html.'</ul>';
    }



}