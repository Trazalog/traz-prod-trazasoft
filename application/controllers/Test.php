<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/Establecimientos');
        $this->load->model('Tablas');
        $this->load->model(ALM.'Articulos');
    }

    public function index()
    {
        //show(wso2('http://10.142.0.7:8280/services/PRDNoConsumiblesDataService/noConsumibles'));
      //  show(wso2('http://10.142.0.7:8280/services/COREDataService/tablas/tipos_no_consumibles'));
     
      // show(wso2('http://10.142.0.7:8280/services/PRDNoConsumiblesDataService/noConsumible/ABC123'));
      //  show(wso2('http://10.142.0.7:8280/services/ALMDataService/establecimientos/empresa/1'));
      //  show(wso2('http://10.142.0.7:8280/services/PRDNoConsumiblesDataService/noConsumibles'));
     
        #$this->load->view(TST.'pedidos/pedidos_tarea');
    }

    public function index1()
    {
        $data['articulos'] = $this->Articulos->obtener()['data'];
        $data['envases'] = $this->Tablas->obtenerTabla('envases')['data'];
        $data['establecimientos'] =[];# $this->Establecimientos->obtener();
        $this->load->view('test', $data);
    }

}
