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
            $aux = new StdClass();
            $aux->taskId = $o['id'];
            $aux->caseId = $o['caseId'];
            $aux->processId = $o['processId'];
            $aux->nombreTarea = $o['name'];
            $aux->nombreProceso =  BPM_PROCESS[$o['processId']]['nombre'];
            $aux->color =  BPM_PROCESS[$o['processId']]['color'];
            $aux->descripcion = 'Esto es una Descripcion de la Tarea...<p>Esto es un texto de la solcitud de servicio que puede ser muy larga</p><span class="label label-danger">Urgente</span> <span class="label label-primary">#PonganseLasPilas</span>';
            $aux->fec_vencimiento = 'dd/mm/aaaa';
            $aux->usuarioAsignado = 'Nombre Apellido';
            $aux->idUsuarioAsignado = $o['assigned_id'];
            $aux->fec_asignacion = $o['assigned_date'];
            $aux->prioridad = $o['priority'];
           
            array_push($array, $aux);
        }
        
        return $array;
        
    }

    public function listar()
    {
       
        $rsp =  $this->bpm->getToDoList();

        if(!$rsp['status']) return $rsp;

        return $this->mapeo($rsp['data']);
    
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
