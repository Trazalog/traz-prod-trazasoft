<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tareas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('BPM');
    }

    public function mapeo($data)
    {
        $array = [];

        foreach ($data as $o) {
            $aux = [
                'taskId'=>$o['id'],
                'caseId'=>$o['caseId'],
                'processId'=>$o['processId'],
                'nombreTarea'=>$o['name'],
                'nombreProceso'=>'Nombre de Proceso',
                'descripcion'=>'Esto es una Descripcion de la Tarea...<p>Esto es un texto de la solcitud de servicio que puede ser muy larga</p><span class="label label-danger">Urgente</span> <span class="label label-primary">#PonganseLasPilas</span>',
                'fec_vencimiento'=>'dd/mm/aaaa',
                'usuarioAsignado'=>'Nombre Apellido',
                'idUsuarioAsignado'=>$o['assigned_id'],
                'fec_asignacion'=>$o['assigned_date'],
                'prioridad'=>$o['priority']
            ];
            array_push($array, $aux);
        }
        return $array;
        
    }

    public function listar()
    {
       
        $res =  $this->bpm->getToDoList()['data'];

      //  echo var_dump($res);die;

        return $this->mapeo($res);
    
    }

    public function obtener($id)
    {
        return $this->mapeo(array($this->bpm->getTarea($id)['body']))[0];
    }

    public function editar($id, $data)
    {
        # code...
    }

    public function eliminar($id)
    {
        # code...
    }
}
