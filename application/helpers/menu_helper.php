<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('menu')){

    function menu($json)
    {
        $array =  json_decode($json);
       // var_dump($array->menu);die;
        $html = '<ul class="sidebar-menu menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>';
        foreach ($array->menu as $i) {

            switch ($i->nivel) {
                case 1:
                    $html .= '<li><a href="#" data-link="'.$i->link.'"><i class="fa fa-circle-o"></i>'.$i->titulo.'</a></li>';
                    break;
                case 2:
                    $html .= '<li class="treeview">
                    <a href="#">
                        <i class="fa fa-fw fa-check"></i> <span>'.$i->titulo.'</span>
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
            $html.= '<li><a href="#" data-link="'.$i->link.'"><i class="fa fa-fw fa-barcode"></i>'.$i->titulo.'</a></li>';
        }
        return $html.'</ul>';
    }



}