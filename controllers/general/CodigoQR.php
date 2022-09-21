<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . "/libraries/codigo_qr/phpqrcode/qrlib.php";

class CodigoQR extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('general/CodigosQR');
    }
    /**
    *  Carga la vista vista para impresion en modal de codigo QR del No Consumible
    * @param array con datos del No Consumible
    * @return view
    */
    public function cargaModalQRNoConsumible(){
        $data = $this->input->post();
        $aux = explode(" ", $data['fec_alta']);
        $data['fec_alta'] = date('d-m-Y', strtotime($aux[0]));
        $this->load->view('NoConsumible/qr_noConsumible', $data);
    }
    /**
    *  Carga la vista para impresion en modal del codigo QR generado para el Lote
    * @param array con datos del Lote
    * @return view
    */
    public function cargaModalQRLote(){
        $data = $this->input->post();

        $this->load->view('etapa/fraccionar/qr_Lote', $data);
    }
}
