<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    /**
    * 
    * @param 
    * @return 
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TestModel');
    }

    /**
     * 
     * @param
     * @return
     */
    public function test()
    {
        log_message('INFO','#TRAZA|test|test() >>');
        $data['materiales'] = $this->TestModel->getMateriales()['data'];
        $data['etapas'] = $this->TestModel->getEtapas()['data'];
        // show($data['etapas']);
        $this->load->view('test',$data);
    }

    // public function prueba()
    // {
    //     $post = $this->input->post();
    //     show($post);
    // }

    public function getMaterialesPorEtapa($etap_id)
    {
        $data = $this->TestModel->getMaterialesPorEtapa($etap_id);
        echo json_encode($data);
    }

}
