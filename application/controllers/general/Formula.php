<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Formula extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('general/Materias');
		$this->load->model(ALM . 'Articulos');
		// $this->load->model(ALM . 'Lotes');
		$this->load->model('Tablas');
		$this->load->model('general/Formulas');
	}

	public function index()
	{
		$data['formulas'] = $this->Formulas->getFormulas()->formulas->formula;
		$this->load->view('produccion/formulas/abm_formulas', $data);
	}

	public function agregarFormula()
	{
		$data['articulos'] = $this->Articulos->getArtiService();
		// $data['um'] = $this->Articulos->getUM();
		$data['um'] = $this->Tablas->obtenerTabla('unidades_medida')['data'];
		// $data['unme_id'] = $this->Articulos->getUM();
		$this->load->view('produccion/formulas/alta_formula', $data);
	}

	public function setFormula($form_id = null)
	{
		$datosFormula['formula'] = $this->input->post('datosFormula');
		if (isset($form_id)) {
			$datosFormula['formula']['form_id'] = $form_id;
			$this->Formulas->deleteArticulosFormula($form_id);
			$this->Formulas->updateFormula($datosFormula);
			$rspFormulaId = $form_id;
		} else {
			$rspFormulaId = json_decode($this->Formulas->setFormula($datosFormula)['data'])->respuesta->form_id;
		}

		$articulos = $this->input->post('articulos');
		$tableData = stripcslashes($articulos);
		$tableDataArray['articulo'] = json_decode($tableData, TRUE);
		foreach ($tableDataArray['articulo'] as $key => $x) {
			$tableDataArray['articulo'][$key]['form_id'] = $rspFormulaId;
			$tableDataArray['articulo'][$key]['cantidad'] = strval($tableDataArray['articulo'][$key]['cantidad']);
		}
		$artiArray['_post_formula_articulo'] = $tableDataArray;
		// $artiArray = $tableDataArray;
		$rspArticulos = $this->Formulas->setArticulosFormula($artiArray);

		$datos = '';

		echo json_encode($rspArticulos);
	}	

	public function modificarFormula($tipo = null, $id =  null)
	{
		$data['tipo'] = $tipo;
		$data['form_id'] = $id;
		// $idFormula = $this->input->post('id');
		$data['formula'] = $this->Formulas->getReceta($id)->formula;
		$data['articulosFormula'] = $this->Formulas->getArticulosReceta($id)->articulos->articulo;

		$data['articulos'] = $this->Articulos->getArtiService();
		// $data['um'] = $this->Articulos->getUM();
		$data['um'] = $this->Tablas->obtenerTabla('unidades_medida')['data'];
		$this->load->view('produccion/formulas/edit_formula', $data);

		// $datos = '';

		// echo json_encode($rspArticulos);
	}

	public function deleteFormula($id =  null)
	{
		$rsp = $this->Formulas->deleteFormula($id);

		$datos = '';

		echo json_encode($rsp);
	}
}
