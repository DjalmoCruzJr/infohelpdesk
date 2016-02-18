<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
		$this->load->model('Item_Chamado_Model', 'ItemChamadoModel');
	}
	
	public function buscarCEP($cep){
		$cep            = $cep;
		$chave          = CHAVE_ACESSO;
		$formato        = 'json';
		$siteaddressAPI = "http://www.devmedia.com.br/api/cep/service/?cep=".$cep."&chave=".$chave."&formato=".$formato;
	
		$data = $this->get_content($siteaddressAPI);
		echo $data;
	}
	
	private function get_content($URL){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_exec($ch);
		$data = curl_exec($ch);
	
		curl_close($ch);
		return $data;
	}	
	
	
	public function carregar_contato($empresa) {
		$resultado = $this->EmpresaContatoModel->getEmpresaContato2($empresa);
		echo json_encode($resultado, JSON_PRETTY_PRINT);			
	}

	public function carregar_contato_relatorio($empresa) {
		$filtro_empresa = array ();
		$data = explode(",",$empresa);
		for ($i = 0; $i < sizeof($data); $i ++){
			$filtro_empresa[$i] = $data[$i];
		}
		$resultado = $this->EmpresaContatoModel->getEmpresaContatoRelatorio($filtro_empresa);
		echo json_encode($resultado, JSON_PRETTY_PRINT);
	}
	
	public function carregar_item_chamado($hel_seqcha_ios){
		$resultado = $this->ItemChamadoModel->getItemChamadoEncerrado($hel_seqcha_ios);
		echo json_encode($resultado, JSON_PRETTY_PRINT);
	}

}
