<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Model ABM No Consumibles
class Noconsumibles extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Guardar No Consumibles
    public function guardarNoConsumible($data)
    {
        return requestBox(REST_PRD_NOCON . '/', $data);
    }

// // Listar No Consumibles
    public function tipoNoConsumible()
    {
        $resource = '/tablas/tipos_no_consumibles';
        $url = REST_CORE . $resource;
        return wso2($url);
    }

// Listar Establecimiento
    public function tipoEstablecimiento()
    {
        #HARCODE
        $resource = '/establecimientos/empresa/' . empresa();
        $url = REST_ALM . $resource;
        return wso2($url);

    }

    public function seleccionarDestino()
    {
        $resource = '/tablas/destinos_no_consumibles';
        $url = REST_CORE . $resource;
        return wso2($url);
    }

// Listar Tipos de No Consumibles
    public function ListarNoConsumible()
    {
        #HARCODE .empresa()
        $resource = REST_PRD_NOCON . "/noConsumibles/porEstado/TODOS/porEmpresa/" . empresa();
        $url = $resource; //REST_PRD_NOCON .
        return wso2($url);

    }

    public function editarNoConsumible($data)
    {
        $url = REST_PRD_NOCON . '/noConsumibles';
        $rsp = $this->rest->callApi('PUT', $url, $data);
        return $rsp;
    }

    public function guardarDestino($data)
    {
        $url = REST_CORE . '/tablas';
        $rsp = $this->rest->callApi('POST', $url, $data);
        return $rsp;
    }

    public function eliminarNoConsumible($codigo)
    {

        $url = REST_PRD_NOCON . "/noConsumible";
        return wso2($url, 'DELETE', $codigo);
    }

// Listar trazabilidad No Consumibles
    public function ListarTrazabilidadNoConsumible($codigo)
    {

        $resource = "/noConsumible/trazabilidad/porCodigo/$codigo";
        $url = REST_PRD_NOCON . $resource;
        return wso2($url);
    }

    public function buscarNoConsumible($codigo)
    {
        $resource = "/noConsumible/porCodigo/$codigo";
        $url = REST_PRD_NOCON . $resource;
        return wso2($url);
    }

// // Guardar Movimiento Entrada No Consumibles
    public function guardarMovimientoEntrada($data)
    {
        return requestBox(REST_PRD_NOCON . '/', $data);
    }

// // Guardar Movimiento Salida No Consumibles
    public function guardarMovimientoSalida($data)
    {
        return requestBox(REST_PRD_NOCON . '/', $data);
    }

}
