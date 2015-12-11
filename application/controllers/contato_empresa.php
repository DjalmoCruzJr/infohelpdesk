<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contato_Empresa extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
 		$this->load->model('Empresa_Model', 'EmpresaModel');
 		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
	}

	
	public function index($hel_seqemp_exc) {
		$dados = array();
		
		$dados['BLC_DADOS']  	  = array();
		$dados['hel_seqemp_exc']  = base64_decode($hel_seqemp_exc);
		$dados['VOLTAR_EMPRESA']  = site_url('empresa');
		
		$this->carregarDadosEmpresa($dados);
		
		$this->carregarDados($dados);
						
		$this->parser->parse('empresa_contato_consulta', $dados);
	}	
	
	private function carregarDadosEmpresa(&$dados) {		
		$resultado = $this->EmpresaModel->get($dados['hel_seqemp_exc']);
		
		if ($resultado){
			$dados['HEL_NOMEFANTASIA_EMP'] = $resultado->hel_nomefantasia_emp;
		}

	}
	
	private function carregarDados(&$dados) {
		$resultado = $this->EmpresaContatoModel->getEmpresaContato2($dados['hel_seqemp_exc']);
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_nome_con"  => $registro->hel_nome_con,
				"hel_desc_tco"	=> $registro->hel_desc_tco,
				"hel_ativo_con"	=> $registro->hel_ativo_con == 1 ? 'Ativo' : 'Inativo'
			);
		}
	}	
}