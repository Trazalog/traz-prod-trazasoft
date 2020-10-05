<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('timeline')){
    function timeline($timeline){
                echo '<div class="panel panel-primary">
                <div class="panel-heading">Línea de Tiempo</div>
                <div class="panel-body" style="max-height: 500px;overflow-y: scroll;">
                
                <div class="container" ><ul class="timeline">';
               echo '<h2 style="margin-left:50px;">Actividades Pendientes</h2>';
                foreach ($timeline['listAct'] as $f) {       
                    echo '<li>
                            <div class="timeline-badge info"><i class="glyphicon glyphicon-time"></i></div>
                            <div class="timeline-panel">
                                    <div class="timeline-heading">
                                    <h4 class="timeline-title">'.$f['displayName'].'</h4>
                                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Fecha Inicio: '.date_format(date_create($f['reached_state_date']),'d-m-Y H:i').' hs </small></p>
                                    </div>
                                    <div class="timeline-body">';
                                    if(array_key_exists ( 'assigned_id' , $f ) && $f['assigned_id']!=''){
                                            echo '<p>Usuario: '.$f['assigned_id']['firstname'].' '.$f['assigned_id']['lastname'].'</p>';
                                    }else{
                                            echo '<p>Usuario: Sin Asignar</p>';
                                    }
					echo            '<p>Descripción: '.$f['displayDescription'].'</p>  
							  		 <p>Duración: '.resta_fechas($f['reached_state_date'],date("Y-m-d H:i:s")).'</p> 
                                     <p>Case: '.$f['caseId'].'</p>
									 
                                    </div>
                            </div>
                            </li>';
                    }
                    echo '<h2 style="margin-left:50px;">Actividades Terminadas</h2>';
                    foreach ($timeline['listArch'] as $f) {
                    
                    echo '<li>
                            <div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
                            <div class="timeline-panel">
                                    <div class="timeline-heading">
                                    <h4 class="timeline-title">'.$f['displayName'].'</h4>
                                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Fecha Inicio: '.date_format(date_create($f['assigned_date']),'d/m/Y H:i').' hs | Fecha Fin: '.date_format(date_create($f['archivedDate']),'d/m/Y H:i').' hs</small></p>
                                    </div>
                                    <div class="timeline-body">';
                                    if(array_key_exists ( 'assigned_id' , $f )){
                                            echo '<p>Usuario: '.$f['assigned_id']['firstname'].' '.$f['assigned_id']['lastname'].'</p>';
                                    }else{
                                            echo '<p>Usuario: Sin Asignar</p>';
                                    }
                    echo           '<p>Descripción: '.$f['displayDescription'].'</p>     
                                    <p>Duración: '.resta_fechas($f['assigned_date'],$f['archivedDate']).'</p>   
                                    <p>Case: '.$f['caseId'].'</p>
                                    </div>
                            </div>
                            </li>';
                }
                echo '<li>
                <div class="timeline-badge success"><i class="glyphicon glyphicon-flag"></i></div>
                <div class="timeline-panel">
                        <div class="timeline-heading">
                                <h4 class="timeline-title">Inicio del Proceso</h4>
                        </div>
                </div>
        </li></ul></div></div></ul></div></div><!-- estilos de linea de tiempo -->
        <style type="text/css">
        .timeline {
        list-style: ;
        padding: 0 0 20px;
        position: relative;
        margin-top: -15px;
        margin-left: 70px;
        }
        
        .timeline:before {
        top: 30px;
        bottom: 25px;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #ccc;
        left: 25px;
        margin-right: -1.5px
        }
        
        .timeline>li,
        .timeline>li>.timeline-panel {
        margin-bottom: 5px;
        position: relative
        }
        
        .timeline>li:after,
        .timeline>li:before {
        content: " ";
        display: table
        }
        
        .timeline>li:after {
        clear: both
        }
        
        .timeline>li>.timeline-panel {
        margin-left: 55px;
        float: left;
        top: 19px;
        padding: 4px 10px 8px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 45%
        }
        
        .timeline>li>.timeline-badge {
        color: #fff;
        width: 36px;
        height: 36px;
        line-height: 36px;
        font-size: 1.2em;
        text-align: center;
        position: absolute;
        top: 26px;
        left: 9px;
        margin-right: -25px;
        background-color: #fff;
        z-index: 100;
        border-radius: 50%;
        border: 1px solid #d4d4d4
        }
        
        .timeline>li.timeline-inverted>.timeline-panel {
        float: left
        }
        
        .timeline>li.timeline-inverted>.timeline-panel:before {
        border-right-width: 0;
        border-left-width: 15px;
        right: -15px;
        left: auto
        }
        
        .timeline>li.timeline-inverted>.timeline-panel:after {
        border-right-width: 0;
        border-left-width: 14px;
        right: -14px;
        left: auto
        }
        
        .timeline-badge.primary {
        background-color: #2e6da4 !important
        }
        
        .timeline-badge.success {
        background-color: #3f903f !important
        }
        
        .timeline-badge.warning {
        background-color: #f0ad4e !important
        }
        
        .timeline-badge.danger {
        background-color: #d9534f !important
        }
        
        .timeline-badge.info {
        background-color: #5bc0de !important
        }
        
        .timeline-title {
        margin-top: 0;
        color: inherit
        }
        
        .timeline-body>p,
        .timeline-body>ul {
        margin-bottom: 0;
        margin-top: 0
        }
        
        .timeline-body>p+p {
        margin-top: 5px
        }
        
        .timeline-badge>.glyphicon {
        margin-right: 0px;
        color: #fff
        }
        
        .timeline-body>h4 {
        margin-bottom: 0 !important
        }
        </style>';
    }
}

