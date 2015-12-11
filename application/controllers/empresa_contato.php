<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_Contato extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
 		$this->load->model('Contato_Model', 'ContatoModel');
 		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');	
	}

	
	public function index($hel_seqcon_exc) {
		$dados = array();
		
		$dados['BLC_DADOS']  = array();
		
		$dados['NOVO_EMPRESA_CONTATO']  = site_url('empresa_contato/novo'.$hel_seqcon_exc);
		$dados['hel_seqcon_exc']  		= base64_decode($hel_seqcon_exc);
		
		$this->carregarDadosContato($dados);
		
		$this->carregarDados($dados);
						
		$this->parser->parse('contato_empresa_consulta', $dados);
	}
	
	public function novo() {
			
		$dados = array();
		$dados['hel_pk_seq_cid']  = 0;		
		$dados['hel_nome_cid']    = '';
		$dados['hel_uf_cid']      = '';
		$dados['hel_codmun_cid']  = '';
				
		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('cidade_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_cid) {		
		$hel_pk_seq_cid = base64_decode($hel_pk_seq_cid);
		$dados = array();
		
		$this->carregarCidade($hel_pk_seq_cid, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('cidade_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_cid;
		global $hel_nome_cid;
		global $hel_uf_cid;
		global $hel_codmun_cid;
		
		$hel_pk_seq_cid  = $this->input->post('hel_pk_seq_cid');			
		$hel_nome_cid    = $this->input->post('hel_nome_cid');
		$hel_uf_cid      = $this->input->post('hel_uf_cid');
		$hel_codmun_cid  = $this->input->post('hel_codmun_cid');

		if ($this->testarDados()) {
			$cidade = array(
				"hel_nome_cid"   => $hel_nome_cid, 
				"hel_uf_cid"     => $hel_uf_cid,
				"hel_codmun_cid" => $hel_codmun_cid
			);
			
			if (!$hel_pk_seq_cid) {	
				$hel_pk_seq_cid = $this->CidadeModel->insert($cidade);
			} else {
				$hel_pk_seq_cid = $this->CidadeModel->update($cidade, $hel_pk_seq_cid);
			}

			if (is_numeric($hel_pk_seq_cid)) {
				$this->session->set_flashdata('sucesso', 'Cidade salva com sucesso.');
				redirect('cidade');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_cid);	
				redirect('cidade');
			}
		} else {
			if (!$hel_pk_seq_cid) {
				redirect('cidade/novo/');
			} else {
				redirect('cidade/editar/'.base64_encode($hel_pk_seq_cid));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_cid) {		
		if ($this->testarApagar(base64_decode($hel_pk_seq_cid))) {
			$res = $this->CidadeModel->delete(base64_decode($hel_pk_seq_cid));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Cidade apagada com sucesso.');
			} 
		}				
		redirect('cidade');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_CIDADE']   = site_url('cidade');
		$dados['ACAO_FORM']         = site_url('cidade/salvar');
	}	
	
	private function carregarDadosContato(&$dados) {		
		$resultado = $this->ContatoModel->get($dados['hel_seqcon_exc']);
		
		if ($resultado){
			$dados['HEL_NOME_CON'] = $resultado->hel_nome_con;
		}

	}
	
	private function carregarDados(&$dados) {
				
		$resultado = $this->EmpresaContatoModel->getContatoEmpresa($dados['hel_seqcon_exc']);
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_nomefantasia_emp"  	=> $registro->hel_nomefantasia_emp,
				"hel_nome_con"         		=> $registro->hel_nome_con,
				"hel_desc_tco"         		=> $registro->hel_desc_tco,
				"EDITAR_EMPRESA_CONTATO"	=> site_url('empresa_contato/editar/'.base64_encode($registro->hel_pk_seq_exc).'/'.base64_encode($registro->hel_seqcon_exc)),
				"APAGAR_EMPRESA_CONTATO"	=> "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_cid)."')"
			);
		}
	}
	
	private function carregarCidade($hel_pk_seq_cid, &$dados) {
		$resultado = $this->CidadeModel->get($hel_pk_seq_cid);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
		
		$dados['gab_selected_uf'] = 'selected';
	}
	
	private function testarDados() {
		global $hel_pk_seq_cid;
		global $hel_nome_cid;
		global $hel_uf_cid;
		global $hel_codmun_cid;

		$erros    = FALSE;
		$mensagem = null;

		$hel_nome_cid = trim($hel_nome_cid);
		
		if (empty($hel_nome_cid)) {
			$erros    = TRUE;
			$mensagem .= "- Nome não preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_NOME_CID', 'has-error');
		}

		if (empty($hel_uf_cid)) {
			$erros    = TRUE;
			$mensagem .= "- UF não foi selecionada.\n";
			$this->session->set_flashdata('ERRO_HEL_UF_CID', 'has-error');
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_CID', TRUE);				
			$this->session->set_flashdata('hel_nome_cid', $gab_nome_cid);
			$this->session->set_flashdata('hel_uf_cid', $gab_uf_cid);
			$this->session->set_flashdata('hel_codmun_cid', $gab_codmun_cid);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_cid) {
		$erros    = FALSE;
		$mensagem = null;
	
		if ($this->EmpresaModel->getEmpresaCidade($hel_pk_seq_cid)) {
			$erros    = TRUE;
			$mensagem .= "- Empresa cadastrada.\n";
		}
	
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_CID   	   = $this->session->flashdata('ERRO_HEL_CID');
		$ERRO_HEL_NOME_CID     = $this->session->flashdata('ERRO_HEL_NOME_CID');
		$ERRO_HEL_UF_CID       = $this->session->flashdata('ERRO_HEL_UF_CID');

		$hel_nome_cid     	   = $this->session->flashdata('hel_nome_cid');
		$hel_uf_cid       	   = $this->session->flashdata('hel_uf_cid');
		$hel_codmun_cid        = $this->session->flashdata('hel_codmun_cid');

		if ($ERRO_HEL_CID) {
			$dados['hel_nome_cid']       = $hel_nome_cid;
			$dados['hel_uf_cid']         = $hel_uf_cid;
			$dados['hel_codmun_cid']     = $hel_codmun_cid;

			$dados['ERRO_HEL_NOME_CID']  = $ERRO_HEL_NOME_CID;
			$dados['ERRO_HEL_UF_CID']    = $ERRO_HEL_UF_CID;
		}
	}
	
}