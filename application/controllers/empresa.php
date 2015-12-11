<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Empresa_Model', 'EmpresaModel');
		$this->load->model('Cidade_Model', 'CidadeModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
		$this->load->model('Sistema_Contratado_Model', 'SistemaContradoModel');
		$this->load->model('Ordem_Servico_Model', 'OrdemServicoModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
	}

	
	public function index() {
		$dados = array();
		$dados['NOVA_EMPRESA'] = site_url('empresa/novo');
		
		$dados['BLC_DADOS']   = array();
		
		$this->carregarDados($dados);
				
		$this->parser->parse('empresa_consulta', $dados);
	}
	
	public function novo() {
			
		$dados = array();
		$dados['hel_pk_seq_emp']  		= 0;		
		$dados['hel_empresa_emp'] 		= '';
		$dados['hel_filial_emp']  		= '';
		$dados['hel_cnpj_emp']  		= '';
		$dados['hel_razaosocial_emp']  	= '';
		$dados['hel_nomefantasia_emp']  = '';
		$dados['hel_endereco_emp']  	= '';
		$dados['hel_numero_emp']  		= '';
		$dados['hel_bairro_emp']  		= '';
		$dados['hel_seqcid_emp']  		= '';
		$dados['hel_cep_emp']  			= '';
		$dados['hel_ativo_emp']  		= '';
		$dados['hel_checkedativo_emp']  = 'checked';
		
		$dados['ACAO'] = 'Novo';
		
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
	
		$this->carregarCidade($dados);
		
		$this->parser->parse('empresa_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_emp) {		
		$hel_pk_seq_emp = base64_decode($hel_pk_seq_emp);
		$dados = array();
		
		$this->carregarEmpresa($hel_pk_seq_emp, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarCidade($dados);
		
		$this->parser->parse('empresa_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_emp;
		global $hel_empresa_emp;
		global $hel_filial_emp;
		global $hel_cnpj_emp;
		global $hel_razaosocial_emp;
		global $hel_nomefantasia_emp;
		global $hel_endereco_emp;
		global $hel_numero_emp;
		global $hel_bairro_emp;
		global $hel_seqcid_emp;
		global $hel_cep_emp;
		global $hel_ativo_emp;
		
		$hel_pk_seq_emp  		= $this->input->post('hel_pk_seq_emp');			
		$hel_empresa_emp 		= $this->input->post('hel_empresa_emp');
		$hel_filial_emp 		= $this->input->post('hel_filial_emp');
		$hel_cnpj_emp 			= $this->input->post('hel_cnpj_emp');
		$hel_razaosocial_emp 	= $this->input->post('hel_razaosocial_emp');
		$hel_nomefantasia_emp 	= $this->input->post('hel_nomefantasia_emp');
		$hel_endereco_emp 		= $this->input->post('hel_endereco_emp');
		$hel_numero_emp 		= $this->input->post('hel_numero_emp');
		$hel_bairro_emp 		= $this->input->post('hel_bairro_emp');
		$hel_seqcid_emp 		= $this->input->post('hel_seqcid_emp');
		$hel_cep_emp 			= $this->input->post('hel_cep_emp');
		$hel_ativo_emp 			= $this->input->post('hel_ativo_emp') == 1 ? 1 : 0;

		$hel_cnpj_emp 			= str_replace(".", null, $hel_cnpj_emp);
		$hel_cnpj_emp 			= str_replace("/", null, $hel_cnpj_emp);
		$hel_cnpj_emp 			= str_replace("-", null, $hel_cnpj_emp);
		
		$hel_cep_emp 			= str_replace("-", null, $hel_cep_emp);
		
		if ($this->testarDados()) {
			$empresa = array(
				"hel_empresa_emp"    	=> $hel_empresa_emp, 
				"hel_filial_emp"     	=> $hel_filial_emp,
				"hel_cnpj_emp" 		 	=> $hel_cnpj_emp,
				"hel_razaosocial_emp"   => $hel_razaosocial_emp,
				"hel_nomefantasia_emp"  => $hel_nomefantasia_emp,
				"hel_endereco_emp"     	=> $hel_endereco_emp,
				"hel_numero_emp"     	=> $hel_numero_emp,
				"hel_bairro_emp"     	=> $hel_bairro_emp,
				"hel_seqcid_emp"     	=> $hel_seqcid_emp,
				"hel_cep_emp"     		=> $hel_cep_emp,
				"hel_ativo_emp"     	=> $hel_ativo_emp
			);
			
			if (!$hel_pk_seq_emp) {	
				$hel_pk_seq_emp = $this->EmpresaModel->insert($empresa);
			} else {
				$hel_pk_seq_emp = $this->EmpresaModel->update($empresa, $hel_pk_seq_emp);
			}

			if (is_numeric($hel_pk_seq_emp)) {
				$this->session->set_flashdata('sucesso', 'Empresa salva com sucesso.');
				redirect('empresa');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_emp);	
				redirect('empresa');
			}
		} else {
			if (!$hel_pk_seq_emp) {
				redirect('empresa/novo/');
			} else {
				redirect('empresa/editar/'.base64_encode($hel_pk_seq_emp));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_emp) {		
		if ($this->testarApagar(base64_decode($hel_pk_seq_emp))) {
			$res = $this->EmpresaModel->delete(base64_decode($hel_pk_seq_emp));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Empresa apagada com sucesso.');
			} 
		}				
		redirect('empresa');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_EMPRESA']  = site_url('empresa');
		$dados['ACAO_FORM']         = site_url('empresa/salvar');
		$dados['URL_BUSCAR_CEP']   	= site_url('json/json/buscarCEP');
	}	
	
	private function carregarDados(&$dados) {
				
		$resultado = $this->EmpresaModel->getEmpresa();	
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_nomefantasia_emp" => $registro->hel_nomefantasia_emp,							
				"hel_cnpj_emp"         => $registro->hel_cnpj_emp,
				"hel_nome_cid"		   => $registro->hel_nome_cid,
				"hel_ativo_emp"		   => $registro->hel_ativo_emp == 1 ? 'Ativo' : 'Inativo',
				"EMPRESA_CONTATO" 	   => site_url('contato_empresa/index/'.base64_encode($registro->hel_pk_seq_emp)),
				"EDITAR_EMPRESA" 	   => site_url('empresa/editar/'.base64_encode($registro->hel_pk_seq_emp)),
				"APAGAR_EMPRESA" 	   => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_emp)."')"
			);
		}
	}
	
	private function carregarEmpresa($hel_pk_seq_emp, &$dados) {
		$resultado = $this->EmpresaModel->get($hel_pk_seq_emp);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
		
		$dados['hel_checkedativo_emp'] = $dados['hel_ativo_emp'] == 1 ? 'checked' : '';
		
	}
	
	
	private function carregarCidade(&$dados) {
		$resultado = $this->CidadeModel->getCidade();
		
		foreach ($resultado as $registro) {
			$dados['BLC_CIDADE'][] = array(
					"hel_pk_seq_cid"     => $registro->hel_pk_seq_cid,
					"hel_nome_cid"       => $registro->hel_nome_cid,
					"hel_codmun_cid"       => $registro->hel_codmun_cid,
					"sel_hel_seqcid_emp" => ($dados['hel_seqcid_emp'] == $registro->hel_pk_seq_cid)?'selected':''
			);
		}
	
		!$resultado ? $dados['BLC_CIDADE'][] = array("hel_nome_cid" => 'Não existe nenhuma cidade cadastrada') :'';
	}
	
	
	private function testarDados() {
		global $hel_pk_seq_emp;
		global $hel_empresa_emp;
		global $hel_filial_emp;
		global $hel_cnpj_emp;
		global $hel_razaosocial_emp;
		global $hel_nomefantasia_emp;
		global $hel_endereco_emp;
		global $hel_numero_emp;
		global $hel_bairro_emp;
		global $hel_seqcid_emp;
		global $hel_cep_emp;
		global $hel_ativo_emp;

		$erros    = FALSE;
		$mensagem = null;

		$hel_razaosocial_emp 	= trim($hel_razaosocial_emp);
		$hel_nomefantasia_emp 	= trim($hel_nomefantasia_emp);
		$hel_endereco_emp 		= trim($hel_endereco_emp);
		$hel_numero_emp 		= trim($hel_numero_emp);
		$hel_bairro_emp 		= trim($hel_bairro_emp);
		
		if (empty($hel_empresa_emp)) {
			$erros    = TRUE;
			$mensagem .= "- Empresa não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_EMPRESA_EMP', 'has-error');
		}
		
		if (empty($hel_filial_emp)) {
			$erros    = TRUE;
			$mensagem .= "- Filial não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_FILIAL_EMP', 'has-error');
		}
		
		if ($hel_cnpj_emp == '') {
			$erros    = TRUE;
			$mensagem .= "- CNPJ não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_CNPJ_EMP', 'has-error');
		}
		
		if (empty($hel_razaosocial_emp)) {
			$erros    = TRUE;
			$mensagem .= "- Razão Social não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_RAZAOSOCIAL_EMP', 'has-error');
		}
		
		if (empty($hel_nomefantasia_emp)) {
			$erros    = TRUE;
			$mensagem .= "- Nome fantasia não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_NOMEFANTASIA_EMP', 'has-error');
		}
		
		if (empty($hel_seqcid_emp)) {
			$erros    = TRUE;
			$mensagem .= "- Cidade não foi selecionada.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQCID_EMP', 'has-error');
		}
		
		if (empty($hel_cep_emp)) {
			$erros    = TRUE;
			$mensagem .= "- CEP não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_CEP_EMP', 'has-error');
		}
		
		if (!$erros and $this->EmpresaModel->getEmpresaCadastrada($hel_cnpj_emp, $hel_pk_seq_emp)){
			$erros    = TRUE;
			$mensagem .= "- Empresa já cadastrada.\n";
			$this->session->set_flashdata('ERRO_HEL_EMPRESA_EMP', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_FILIAL_EMP', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_CNPJ_EMP', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_RAZAOSOCIAL_EMP', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_NOMEFANTASIA_EMP', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_SEQCID_EMP', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_CEP_EMP', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_ATIVO_EMP', 'has-error');
		}

		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_EMP', TRUE);				
			$this->session->set_flashdata('hel_empresa_emp', $hel_empresa_emp);
			$this->session->set_flashdata('hel_filial_emp', $hel_filial_emp);
			$this->session->set_flashdata('hel_cnpj_emp', $hel_cnpj_emp);
			$this->session->set_flashdata('hel_razaosocial_emp', $hel_razaosocial_emp);
			$this->session->set_flashdata('hel_nomefantasia_emp', $hel_nomefantasia_emp);
			$this->session->set_flashdata('hel_endereco_emp', $hel_endereco_emp);
			$this->session->set_flashdata('hel_numero_emp', $hel_numero_emp);
			$this->session->set_flashdata('hel_bairro_emp', $hel_bairro_emp);
			$this->session->set_flashdata('hel_seqcid_emp', $hel_seqcid_emp);
			$this->session->set_flashdata('hel_cep_emp', $hel_cep_emp);
			$this->session->set_flashdata('hel_ativo_emp', $hel_ativo_emp);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_emp) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($this->OrdemServicoModel->getEmpresaOrdemServico($hel_pk_seq_emp)) {
			$erros    = TRUE;
			$mensagem .= "- Ordem Serviço cadastrada.\n";
		}
		
		if ($this->SistemaContradoModel->getEmpresaSistemaContratado($hel_pk_seq_emp)) {
			$erros    = TRUE;
			$mensagem .= "- Sistema Contratado cadastrada.\n";
		}
	
		if ($this->EmpresaContatoModel->getEmpresaContato($hel_pk_seq_emp)) {
			$erros    = TRUE;
			$mensagem .= "- Contatos cadastrada.\n";
		}
	
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_EMP   	   		= $this->session->flashdata('ERRO_HEL_EMP');
		$ERRO_HEL_EMPRESA_EMP   	= $this->session->flashdata('ERRO_HEL_EMPRESA_EMP');
		$ERRO_HEL_FILIAL_EMP   		= $this->session->flashdata('ERRO_HEL_FILIAL_EMP');
		$ERRO_HEL_CNPJ_EMP   		= $this->session->flashdata('ERRO_HEL_CNPJ_EMP');
		$ERRO_HEL_RAZAOSOCIAL_EMP   = $this->session->flashdata('ERRO_HEL_RAZAOSOCIAL_EMP');
		$ERRO_HEL_NOMEFANTASIA_EMP	= $this->session->flashdata('ERRO_HEL_NOMEFANTASIA_EMP');
		$ERRO_HEL_SEQCID_EMP       	= $this->session->flashdata('ERRO_HEL_SEQCID_EMP');
		$ERRO_HEL_CEP_EMP       	= $this->session->flashdata('ERRO_HEL_CEP_EMP');
		$ERRO_HEL_ATIVO_EMP       	= $this->session->flashdata('ERRO_HEL_ATIVO_EMP');

		$hel_empresa_emp     	   = $this->session->flashdata('hel_empresa_emp');
		$hel_filial_emp     	   = $this->session->flashdata('hel_filial_emp');
		$hel_cnpj_emp     	   	   = $this->session->flashdata('hel_cnpj_emp');
		$hel_razaosocial_emp   	   = $this->session->flashdata('hel_razaosocial_emp');
		$hel_nomefantasia_emp  	   = $this->session->flashdata('hel_nomefantasia_emp');
		$hel_endereco_emp  	   	   = $this->session->flashdata('hel_endereco_emp');
		$hel_numero_emp  	   	   = $this->session->flashdata('hel_numero_emp');
		$hel_bairro_emp  	   	   = $this->session->flashdata('hel_bairro_emp');
		$hel_seqcid_emp  	   	   = $this->session->flashdata('hel_seqcid_emp');
		$hel_cep_emp  	   	   	   = $this->session->flashdata('hel_cep_emp');
		$hel_ativo_emp  	   	   = $this->session->flashdata('hel_ativo_emp');
		
		
		if ($ERRO_HEL_EMP) {
			$dados['hel_empresa_emp']      		= $hel_empresa_emp;
			$dados['hel_filial_emp']       		= $hel_filial_emp;
			$dados['hel_cnpj_emp']         		= $hel_cnpj_emp;
			$dados['hel_razaosocial_emp']  		= $hel_razaosocial_emp;
			$dados['hel_nomefantasia_emp'] 		= $hel_nomefantasia_emp;
			$dados['hel_endereco_emp']     		= $hel_endereco_emp;
			$dados['hel_numero_emp']  	   		= $hel_numero_emp;
			$dados['hel_bairro_emp']  	   		= $hel_bairro_emp;
			$dados['hel_seqcid_emp']  	   		= $hel_seqcid_emp;
			$dados['hel_cep_emp']  		   		= $hel_cep_emp;
			$dados['hel_ativo_emp']  	   		= $hel_ativo_emp;
			$dados['hel_checkedativo_emp']  	= $hel_ativo_emp == 1 ? 'checked' : '';
			
			$dados['ERRO_HEL_EMPRESA_EMP']  	= $ERRO_HEL_EMPRESA_EMP;
			$dados['ERRO_HEL_FILIAL_EMP']    	= $ERRO_HEL_FILIAL_EMP;
			$dados['ERRO_HEL_CNPJ_EMP']  		= $ERRO_HEL_CNPJ_EMP;
			$dados['ERRO_HEL_RAZAOSOCIAL_EMP']  = $ERRO_HEL_RAZAOSOCIAL_EMP;
			$dados['ERRO_HEL_NOMEFANTASIA_EMP'] = $ERRO_HEL_NOMEFANTASIA_EMP;
			$dados['ERRO_HEL_SEQCID_EMP']    	= $ERRO_HEL_SEQCID_EMP;
			$dados['ERRO_HEL_CEP_EMP']    		= $ERRO_HEL_CEP_EMP;
			$dados['ERRO_HEL_ATIVO_EMP']    	= $ERRO_HEL_ATIVO_EMP;
		}
	}
	
}