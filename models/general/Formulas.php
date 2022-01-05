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
		$url = REST_PRD_ETAPAS . '/getFormulas/'.empresa();
		$rsp = $this->rest->callApi('GET', $url);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function setFormula($data)
	{
		log_message('DEBUG', '#FORMULAS | setFormula: >> ' . json_encode($data));

		$url = REST_PRD_ETAPAS . '/formula';
		$rsp = $this->rest->callApi('POST', $url, $data);
		return $rsp;
	}

	public function setArticulosFormula($data)
	{
		log_message('DEBUG', '#FORMULAS | setArticulosFormula: >> ' . json_encode($data));

		$url = REST_PRD_ETAPAS . '/formula_articulo_batch_req';
		$rsp = $this->rest->callApi('POST', $url, $data);
		return $rsp;
	}

	public function getReceta($id)
	{
		$url = REST_PRD_ETAPAS . "/getRecetaFormula/$id";
		$rsp = $this->rest->callApi('GET', $url);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function getArticulosReceta($id)
	{
		$url = REST_PRD_ETAPAS . '/getArticulosReceta/' . $id;
		$rsp = $this->rest->callApi('GET', $url);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function deleteFormula($id)
	{
		$data['formula']['form_id'] = $id;
		$url = REST_PRD_ETAPAS . '/deleteFormula';
		$rsp = $this->rest->callApi('PUT', $url, $data);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function updateFormula($data)
	{
		log_message("DEBUG", "#TRAZA | TRAZ-PROD-TRAZASOFT | Formulas | updateFormula()");
		$url = REST_PRD_ETAPAS . '/updateFormula';
		$rsp = $this->rest->callApi('PUT', $url, $data);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}

	public function deleteArticulosFormula($id)
	{
		$data['formula']['form_id'] = $id;
		$url = REST_PRD_ETAPAS . '/deleteArticulosFormula';
		$rsp = $this->rest->callApi('DELETE', $url, $data);
		$rsp['data'] = json_decode($rsp['data']);
		return $rsp['data'];
	}
}
