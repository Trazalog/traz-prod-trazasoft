<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tareas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

				$this->load->library('BPM');
				$this->load->library('REST');
    }

    public function mapeo($data)
    {
        $array = [];

				// echo('datos de bpm');
				// var_dump($data);

        foreach ($data as $o) {
						
					switch ($o['processId']) {
						case BPM_PROCESS_ID_PEDIDOS_NORMALES:
							//echo('entre por proceso pedido');
							$aux = new StdClass();
							$aux->taskId = $o['id'];
							$aux->caseId = $o['caseId'];
							$aux->processId = $o['processId'];
							$aux->nombreTarea = $o['name'];
							$aux->nombreProceso =  json_decode(BPM_PROCESS,true)[$o['processId']]['nombre'];
							$aux->color =  json_decode(BPM_PROCESS,true)[$o['processId']]['color'];
							// $aux->descripcion = 'Esto es una Descripcion de la Tarea...<p>Esto es un texto de la solcitud de servicio que puede ser muy larga</p><span class="label label-danger">Urgente</span> <span class="label label-primary">#PonganseLasPilas</span>';
							$aux->descripcion = $o['name'];
							$aux->fec_vencimiento = $o['dueDate'];
							$aux->usuarioAsignado = 'Nombre Apellido';
							$aux->idUsuarioAsignado = $o['assigned_id'];
							$aux->fec_asignacion = $o['assigned_date'];
							$aux->prioridad = $o['priority'];
							$infoPema = $this->getInfoPedMateriales($o['caseId'])->info;
							$aux->pema_id= $infoPema->pema_id;
							$aux->justificacion = $infoPema->justificacion;
							$aux->fecha = $infoPema->fecha;
							$aux->estado = $infoPema->estado;
							//TODO:DESHARDCODEAR LOTE
						//	$aux->lote_id = $infoPema->lote_id;
							$aux->lote_id = 8;
							break;
						
						default:
							# code...
							break;
					}
					
						// $aux = new StdClass();
            // $aux->taskId = $o['id'];
            // $aux->caseId = $o['caseId'];
            // $aux->processId = $o['processId'];
            // $aux->nombreTarea = $o['name'];
            // $aux->nombreProceso =  json_decode(BPM_PROCESS,true)[$o['processId']]['nombre'];
            // $aux->color =  json_decode(BPM_PROCESS,true)[$o['processId']]['color'];
            // $aux->descripcion = 'Esto es una Descripcion de la Tarea...<p>Esto es un texto de la solcitud de servicio que puede ser muy larga</p><span class="label label-danger">Urgente</span> <span class="label label-primary">#PonganseLasPilas</span>';
            // $aux->fec_vencimiento = 'dd/mm/aaaa';
            // $aux->usuarioAsignado = 'Nombre Apellido';
            // $aux->idUsuarioAsignado = $o['assigned_id'];
            // $aux->fec_asignacion = $o['assigned_date'];
            // $aux->prioridad = $o['priority'];
           
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
		
		function getInfoPedMateriales($caseId){

				//log_message('DEBUG', '#TRAZA | #getInfoPedMateriales >> caseId: ' . $caseId;

        $resource = 'pedidoMateriales';

        $url = REST.$resource.'/'.$caseId;

        $rsp = $this->rest->callAPI('GET', $url);

        if (!$rsp['status']) {

            log_message('DEBUG', '#getInfoPedMateriales| fallo servicio >> ' .  $resource);

            return $this->msj(false, $resource);

        }

        return json_decode($rsp['data']);
		}
}
