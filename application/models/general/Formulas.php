<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Formulas extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getFormulas()
	{
		$url = RESTPT . 'getFormulas';
		$rsp = $this->rest->callApi('GET', $url);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function setFormula($data)
	{
		log_message('DEBUG', '#FORMULAS | setFormula: >> ' . json_encode($data));

		$url = RESTPT . 'formula';
		$rsp = $this->rest->callApi('POST', $url, $data);
		return $rsp;
	}

	public function setArticulosFormula($data)
	{
		log_message('DEBUG', '#FORMULAS | setArticulosFormula: >> ' . json_encode($data));

		$url = RESTPT . 'formula_articulo_batch_req';
		$rsp = $this->rest->callApi('POST', $url, $data);
		return $rsp;
	}

	public function getReceta($id)
	{
		// $data['form_id'] = $id;
		$url = RESTPT . 'getRecetaFormula/'  . $id;
		$rsp = $this->rest->callApi('GET', $url);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function getArticulosReceta($id)
	{
		// $data['form_id'] = $id;
		$url = RESTPT . 'getArticulosReceta/' . $id;
		$rsp = $this->rest->callApi('GET', $url);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function deleteFormula($id)
	{
		$data['formula']['form_id'] = $id;
		$url = RESTPT . 'deleteFormula';
		$rsp = $this->rest->callApi('PUT', $url, $data);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function updateFormula($data)
	{
		// $data['formula']['form_id'] = $datosFormula;
		$url = RESTPT . 'updateFormula';
		$rsp = $this->rest->callApi('PUT', $url, $data);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function deleteArticulosFormula($id)
	{
		$data['formula']['form_id'] = $id;
		$url = RESTPT . 'deleteArticulosFormula';
		$rsp = $this->rest->callApi('DELETE', $url, $data);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}
}
