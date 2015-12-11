<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_Contato extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
 		$this->load->model('Empresa_Model', 'EmpresaModel');
 		$this->load->model('Contato_Model', 'ContatoModel');
 		$this->load->model('Ordem_Servico_Model', 'OrdemServicoModel');
 		$this->load->model('Chamado_Model', 'ChamadoModel');
 		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');	
	}

	
	public function index($hel_seqcon_exc) {
		$dados = array();
		
		$dados['BLC_DADOS']  = array();
		
		$dados['NOVO_EMPRESA_CONTATO']  = site_url('empresa_contato/novo/'.$hel_seqcon_exc);
		$dados['URL_APAGAR']      		= site_url('empresa_contato/apagar');
		$dados['hel_seqcon_exc']  		= base64_decode($hel_seqcon_exc);
		
		$this->carregarDadosContato($dados);
		
		$this->carregarDados($dados);
						
		$this->parser->parse('contato_empresa_consulta', $dados);
	}
	
	public function novo($hel_seqcon_exc) {			
		$dados = array();
		$dados['hel_pk_seq_exc']  = 0;		
		$dados['hel_seqcon_exc']  = base64_decode($hel_seqcon_exc);
		$dados['hel_seqemp_exc']  = '';
				
		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
		
		$this->carregarEmpresa($dados);
		
		$this->parser->parse('contato_empresa_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_exc, $hel_seqcon_exc) {		
		$hel_pk_seq_exc = base64_decode($hel_pk_seq_exc);
		$dados = array();
		
		$this->carregarContatoEmpresa($hel_pk_seq_exc, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarEmpresa($dados);
		
		$this->parser->parse('contato_empresa_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_exc;
		global $hel_seqcon_exc;
		global $hel_seqemp_exc;
		
		$hel_pk_seq_exc  = $this->input->post('hel_pk_seq_exc');			
		$hel_seqcon_exc  = $this->input->post('hel_seqcon_exc');
		$hel_seqemp_exc  = $this->input->post('hel_seqemp_exc');

		if ($this->testarDados()) {
			$contato_empresa = array( 
				"hel_seqcon_exc" => $hel_seqcon_exc,
				"hel_seqemp_exc" => $hel_seqemp_exc
			);
			
			if (!$hel_pk_seq_exc) {	
				$hel_pk_seq_exc = $this->EmpresaContatoModel->insert($contato_empresa);
			} else {
				$hel_pk_seq_cid = $this->EmpresaContatoModel->update($contato_empresa, $hel_pk_seq_exc);
			}

			if (is_numeric($hel_pk_seq_exc)) {
				$this->session->set_flashdata('sucesso', 'Contato da empresa salvo com sucesso.');
				redirect('empresa_contato/index/'.base64_encode($hel_seqcon_exc));
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_exc);
				redirect('empresa_contato/index/'.base64_encode($hel_seqcon_exc));
			}
		} else {
			if (!$hel_pk_seq_exc) {
				redirect('empresa_contato/novo/'.base64_encode($hel_seqcon_exc));
			} else {
				redirect('cidade/editar/'.base64_encode($hel_pk_seq_cid));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_exc, $hel_seqcon_exc) {
		if ($this->testarApagar(base64_decode($hel_pk_seq_exc))) {
			$res = $this->EmpresaContatoModel->delete(base64_decode($hel_pk_seq_exc));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Contato da empresa apagada com sucesso.');
			} 
		}						
		redirect('empresa_contato/index/'.$hel_seqcon_exc);
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_EMPRESA_CONTATO']  = site_url('empresa_contato/index/'.base64_encode($dados['hel_seqcon_exc']));
		$dados['ACAO_FORM']         		= site_url('empresa_contato/salvar');
	}	
	
	private function carregarDadosContato(&$dados) {		
		$resultado = $this->ContatoModel->get($dados['hel_seqcon_exc']);
		
		if ($resultado){
			$dados['HEL_NOME_CON'] = $resultado->hel_nome_con;
		}

	}
	
	private function carregarEmpresa(&$dados) {
		$resultado = $this->EmpresaModel->getEmpresa();
	
		foreach ($resultado as $registro) {
			$dados['BLC_EMPRESA'][] = array(
					"hel_pk_seq_emp"     	=> $registro->hel_pk_seq_emp,
					"hel_nomefantasia_emp"  => $registro->hel_nomefantasia_emp,
					"sel_hel_seqemp_exc" 	=> ($dados['hel_seqemp_exc'] == $registro->hel_pk_seq_emp)?'selected':''
			);
		}
	
		!$resultado ? $dados['BLC_EMPRESA'][] = array("hel_nomefantasia_emp" => 'Não existe nenhuma empresa cadastrada') :'';
	}
	
	private function carregarDados(&$dados) {
				
		$resultado = $this->EmpresaContatoModel->getContatoEmpresa($dados['hel_seqcon_exc']);
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_nomefantasia_emp"  	=> $registro->hel_nomefantasia_emp,
				"hel_nome_con"         		=> $registro->hel_nome_con,
				"hel_desc_tco"         		=> $registro->hel_desc_tco,
				"EDITAR_EMPRESA_CONTATO"	=> site_url('empresa_contato/editar/'.base64_encode($registro->hel_pk_seq_exc).'/'.base64_encode($registro->hel_seqcon_exc)),
				"APAGAR_EMPRESA_CONTATO"	=> "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_exc)."','".base64_encode($dados['hel_seqcon_exc'])."')"
			);
		}
	}
	
	private function carregarContatoEmpresa($hel_pk_seq_exc, &$dados) {
		$resultado = $this->EmpresaContatoModel->get($hel_pk_seq_exc);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
	}
	
	private function testarDados() {
		global $hel_pk_seq_exc;
		global $hel_seqcon_exc;
		global $hel_seqemp_exc;

		$erros    = FALSE;
		$mensagem = null;		
		
		if (empty($hel_seqemp_exc)){
			$erros    = TRUE;
			$mensagem .= "- Empresa não foi selecionada.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQEMP_EXC', 'has-error');
		}
		
		if (!$erros and $this->EmpresaContatoModel->getContatoEmpresaCadastro($hel_pk_seq_exc, $hel_seqcon_exc,$hel_seqemp_exc)){
			$erros    = TRUE;
			$mensagem .= "- Contato já foi associado a essa empresa.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQEMP_EXC', 'has-error');
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_EXC', TRUE);				
			$this->session->set_flashdata('hel_seqemp_exc', $hel_seqemp_exc);
			$this->session->set_flashdata('hel_seqcon_exc', $hel_seqcon_exc);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_exc) {
		$erros    = FALSE;
		$mensagem = null;
	
		if ($this->OrdemServicoModel->getContatoEmpresaOrdemServico($hel_pk_seq_exc)) {
			$erros    = TRUE;
			$mensagem .= "- Ordem de Serviço cadastrada.\n";
		}
		
		if ($this->ChamadoModel->getEmpresaContatoChamado($hel_pk_seq_exc)) {
			$erros    = TRUE;
			$mensagem .= "- Chamado cadastrada.\n";
		}		
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_EXC   	   = $this->session->flashdata('ERRO_HEL_EXC');
		$ERRO_HEL_SEQEMP_EXC   = $this->session->flashdata('ERRO_HEL_SEQEMP_EXC');

		$hel_seqemp_exc    	   = $this->session->flashdata('hel_seqemp_exc');
		$hel_seqcon_exc        = $this->session->flashdata('hel_seqcon_exc');

		if ($ERRO_HEL_EXC) {
			$dados['hel_seqemp_exc']     	= $hel_seqemp_exc;
			$dados['hel_seqcon_exc']     	= $hel_seqcon_exc;

			$dados['ERRO_HEL_SEQEMP_EXC']   = $ERRO_HEL_SEQEMP_EXC;
		}
	}
	
}