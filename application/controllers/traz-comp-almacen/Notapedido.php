<?php defined('BASEPATH') or exit('No direct script access allowed');

class Notapedido extends CI_Controller
{

    private $permission = "Add-Edit-Del-View";

    public function __construct()
    {

        parent::__construct();
        $this->load->model(ALM.'Notapedidos');
    }

    public function index()
    {
        $this->load->model('traz-comp/Componentes');
          #COMPONENTE ARTICULOS
        $data['items'] = $this->Componentes->listaArticulos();
        $data['lang'] = lang_get('spanish', 'Ejecutar OT');

        $data['list'] = $this->Notapedidos->notaPedidos_List();
        $data['permission'] = $this->permission;
        $this->load->view(ALM.'notapedido/list', $data);
    }

    public function ObtenerNotasPedidosxOT($idot)
    {
        $data['permission'] = "Add-Edit-Del-View";
        $data['list'] = $this->Notapedidos->getNotasxOT($idot);
        $this->load->view(ALM.'notapedido/list', $data);
    }

    public function getNotasxOT($idot)
    {
        $data['permission'] = $this->permission;
        $data['list'] = $this->Notapedidos->getNotasxOT($idot);
        $this->load->view(ALM.'notapedido/listOt', $data);
    }

    public function agregarNota($idot)
    {
        $data['permission'] = $this->permission;
        $data['ot'] = $this->Notapedidos->getOTporId($idot);
        $this->load->view(ALM.'notapedido/view_', $data);
    }

    // devuelve plantilla de insumos a pedir por cliente
    public function agregarListInsumos($ot)
    {
        $this->load->model(ALM.'Articulos');
        $data['ot'] = $ot;
        $data['permission'] = $this->permission;
        $data['plantilla'] = $this->Articulos->getList();
        $this->load->view(ALM.'notapedido/insumolist', $data);
    }

    // agregar pedido especial carga vista
    public function pedidoEspecial()
    {

        $this->load->view(ALM.'notapedido/viewPedidoEspecial_');
    }

    // guardar pedido especial
    public function setPedidoEspecial()
    {

        $pedido = $this->input->post('pedido').'&'.$this->input->post('justif');
        $ot = $this->input->post('ot');

        echo $this->pedidoExtraordinario($ot,$pedido);

    }

    public function pedidoExtraordinario($ot, $pedidoExtra)
    {
        //? SE DEBE CORRESPONDER CON UN ID EN LA TABLE ORDEN_TRABAJO SINO NO ANDA
        $this->load->library('BPMALM');
        $this->load->model(ALM.'Pedidoextra');

        $contract = [
            'pedidoExtraordinario' =>  $pedidoExtra
        ];

        $data =  $this->bpm->lanzarProceso(BPM_PROCESS_ID_PEDIDOS_EXTRAORDINARIOS,$contract);

        $peex['case_id'] = $data['data']['caseId'];
        $peex['fecha'] = date("Y-m-d");
        $peex['detalle'] = $pedidoExtra;    
        $peex['ortr_id'] = $ot; 
        $peex['empr_id'] = 1; //!HARDCODE

        return $this->Pedidoextra->set($peex);

    }
  

    public function getOrdenesCursos()
    {
        $response = $this->Notapedidos->getOrdenesCursos();
        echo json_encode($response);
    }

    public function getDetalle()
    {
        $response = $this->Notapedidos->getDetalles($this->input->post());
        echo json_encode($response);
    }

    public function getArticulo()
    {
        $response = $this->Notapedidos->getArticulos($this->input->post());
        echo json_encode($response);
    }

    public function getProveedor()
    {
        $response = $this->Notapedidos->getProveedores();
        echo json_encode($response);
    }

    public function getNotaPedidoId()
    {
        $pema_id = $this->input->get('id_nota');
        $response = $this->Notapedidos->getNotaPedidoIds($pema_id);
        echo json_encode($response);
    }

    public function setNotaPedido()
    {
        $ids = $this->input->post('idinsumos');
        $cantidades = $this->input->post('cantidades');
        $idOT = $this->input->post('idOT');
        $justificacion = $this->input->post('justificacion');

        $cabecera = array(
            'fecha' => date('Y-m-d'),
            'ortr_id' => $idOT,
            'empr_id' => empresa(),
            'justificacion' => $justificacion,
            'estado'=>'Creada'
        );

        $idnota = $this->Notapedidos->setCabeceraNota($cabecera);

        // SET EN PEDIDO EXTRA EL PEDIDO MATERILES
        $peex_id = $this->input->post('peex_id');
    
        if($peex_id){$this->load->model(ALM.'Pedidoextra'); $this->Pedidoextra->setPemaId($peex_id, $idnota);}

        for ($i = 0; $i < count($ids); $i++) {
            $deta[$i]['pema_id'] = $idnota;
            $deta[$i]['arti_id'] = $ids[$i];
            $deta[$i]['cantidad'] = $cantidades[$i];
            $deta[$i]['fecha_entrega'] = date('Y-m-d');
        }

        $response = $this->Notapedidos->setDetaNota($deta);
        
        echo json_encode(['pema_id'=>$idnota]);
    }

    
    public function pedidoNormal($pemaId)
    {
        //? DEBE EXISTIR LA NOTA DE PEDIDO 
        $contract = [
            'pIdPedidoMaterial' => $pemaId,
        ];

        $rsp = $this->bpm->lanzarProceso(BPM_PROCESS_ID_PEDIDOS_NORMALES,$contract);

        if(!$rsp['status']){
            return json_encode($rsp);
        }

        echo json_encode($this->Notapedidos->setCaseId($pemaId, $rsp['data']['caseId']));
    }

    public function editarPedido()
    {

        $this->load->model(ALM.'Articulos');
        $data['permission'] = $this->permission;
        $data['plantilla'] = $this->Articulos->getList();
        $this->load->view(ALM.'notapedido/edit_pedido', $data);

    }

    public function editPedido()
    {
        $ids = $this->input->post('idinsumos');
        $cantidades = $this->input->post('cantidades');
        $idOT = $this->input->post('idOT');

        $idnota = $this->input->post('pema');

        for ($i = 0; $i < count($ids); $i++) {
            $deta[$i]['pema_id'] = $idnota;
            $deta[$i]['arti_id'] = $ids[$i];
            $deta[$i]['cantidad'] = $cantidades[$i];
            $deta[$i]['fecha_entrega'] = date('Y-m-d');
        }

        $response = $this->Notapedidos->setDetaNota($deta);
        echo json_encode($response);
    }

    public function getTablaDetalle($pema=null)
    {
        $this->load->model(ALM.'Ordeninsumos');

        $data['list_deta_pema'] = $this->Ordeninsumos->get_detalle_entrega($pema);

        $aux = $this->load->view(ALM.'proceso/tareas/componentes/tabla_detalle_entregas', $data, true);

        echo $aux;
    }

    public function editarDetalle()
    {
        $id = $this->input->post('id');
        $data['cantidad'] = $this->input->post('cantidad');
        echo $this->Notapedidos->editarDetalle($id, $data);
    }

    public function crearPedido($ot=null)
    {   
        $this->load->model('traz-comp/Componentes');
       
        #COMPONENTE ARTICULOS
        $data['items'] = $this->Componentes->listaArticulos();
        $data['lang'] = lang_get('spanish', 'Ejecutar OT');


        if($ot) {
            $info = new stdClass();
            $info->ortr_id = $ot;
            $data['info'] = $info;
        }
        $data['hecho'] = false;
        $this->load->view(ALM.'notapedido/generar_pedido', $data);
       
    }

    public function crearPedido2($ot=null)
    {   
        $this->load->model('traz-comp/Componentes');
        
        #COMPONENTE ARTICULOS
        $data['items'] = $this->Componentes->listaArticulos();
        $data['lang'] = lang_get('spanish', 'Ejecutar OT');

        if($ot) {
            $info = new stdClass();
            $info->ortr_id = $ot;
            $data['info'] = $info;
        }
        $data['hecho'] = true;
        $this->load->view(ALM.'notapedido/generar_pedido', $data);
       
    }
    public function pedidoOffline()
    {
        $idot= $this->input->post('idOT');
        $articulos= json_decode($this->input->post('articulos'));
        $cabecera['fecha'] = date('Y-m-d');
        $cabecera['ortr_id'] = $idot;
        $cabecera['empr_id'] = empresa();
        //var_dump($cabecera);die;
        $idnota = $this->Notapedidos->setCabeceraNota($cabecera);
        for ($i=0; $i < count($articulos); $i++) { 
            $deta[$i]['pema_id'] = $idnota;
            $deta[$i]['arti_id'] = $articulos[$i]->arti_id;
            $deta[$i]['cantidad'] = $articulos[$i]->cantidad;
            $deta[$i]['fecha_entrega'] = date('Y-m-d');
        }
        $response = $this->Notapedidos->setDetaNota($deta);
        $this->pedidoNormal($idnota);
        echo json_encode($response);
    }
}