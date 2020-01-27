<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . "/libraries/codigo_qr/phpqrcode/qrlib.php";

class CodigoQR extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/CodigosQR');
        //Agregamos la libreria para genera códigos QR
        // require "libraries/codigo_qr/phpqrcode/qrlib.php";
        // $this->load->library('codigo_qr/phpqrcode/qrlib.php');
    }

    public function generarQR($codigo = null)
    {
        // $this->load->library('../codigo_qr/phpqrcode/qrlib');
        // var_dump("entra");
        $data['visible'] = false;
        if (isset($codigo)) {
            //Carpeta temporal para guardar la imagenes generadas
            $dir = 'application/temp/codigosQR/';

            //Si no existe la carpeta, se crea
            if (!file_exists($dir))
                mkdir($dir);

            //Declaramos la ruta y nombre del archivo a generar
            // unlink($dir . 'QR.png');
            $filename = $dir . $codigo . 'QR.png';

            $rsp = $this->CodigosQR->getDatos($codigo);
            $contenido = $data['contenido'] = $rsp['data'];

            /* PARAMETROS DEL CODIGO QR*/
            $tamano = 5; //Tamaño de Pixel
            $level = 'L'; //Precisión: L(Baja) ; M(Media) ; Q(Alta) ; H(máxima)
            $framSize = 2; //Tamaño en blanco, borde
            $contenido2 = "Datos lote: \nCodigo: " . $contenido[0]->codigo . "\nTel.: " . $contenido[0]->tel . "\nEmail: " . $contenido[0]->email; //Texto
            /* Tipo de Contenido */
            // Texto: 'Esto es un ejemplo'
            // URL: ‘http://www.ejemplo.com’
            // Télefono: ‘tel:(049)123-456-789′
            // SMS: »smsto:(049)012-345-678:Cuerpo de sms’
            // Email: ‘mailto:micorreo@dominio.com?subject=Asunto&body=contenido’

            //Generar código QR 
            QRcode::png($contenido2, $filename, $level, $tamano, $framSize);
            // $data = [];
            // $data['filename'] = $filename;
            // $data['dir'] = $dir;

            $rsp['filename'] = $filename;
            $rsp['dir'] = $dir;

            echo json_encode($rsp);
        } else {
            $data['visible'] = true;
            $this->load->view('plantillas/codigo_qr', $data);
        }
    }
}
