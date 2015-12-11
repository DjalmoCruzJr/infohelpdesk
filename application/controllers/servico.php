<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servico extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Servico_Model', 'ServicoModel');
	}

	public function index() {
		$dados = array();
		
		$dados['NOVO_SERVICO'] = site_url('servico/novo');
		
		$dados['BLC_DADOS']    = array();

		$this->carregarDados($dados);
		
		$this->parser->parse('servico_consulta', $dados);
	}
	
	public function novo() {		
		$dados = array();
		$dados['hel_pk_seq_ser']  = 0;
		$dados['hel_desc_ser']    = '';
		
		$dados['ACAO'] 	= 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('servico_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_ser) {		
		$hel_pk_seq_ser = base64_decode($hel_pk_seq_ser);
		$dados = array();
		
		$this->carregarServico($hel_pk_seq_ser, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
				
		$this->parser->parse('servico_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_ser;
		global $hel_desc_ser;
		
		$hel_pk_seq_ser  = $this->input->post('hel_pk_seq_ser');			
		$hel_desc_ser    = $this->input->post('hel_desc_ser');

		if ($this->testarDados()) {
			$servico = array(
				"hel_desc_ser"   => $hel_desc_ser
			);
			
			if (!$hel_pk_seq_ser) {	
				$hel_pk_seq_ser = $this->ServicoModel->insert($servico);
			} else {
				$hel_pk_seq_ser = $this->ServicoModel->update($servico, $hel_pk_seq_ser);
			}

			if (is_numeric($hel_pk_seq_ser)) {
				$this->session->set_flashdata('sucesso', 'Serviço salvo com sucesso.');
				redirect('servico');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_ser);	
				redirect('servico');
			}
		} else {
			if (!$hel_pk_seq_ser) {
				redirect('servico/novo/');
			} else {
				redirect('servico/editar/'.base64_encode($hel_pk_seq_ser));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_ser) {
		
		if ($this->testarApagar(base64_decode($hel_pk_seq_ser))) {
			$res = $this->ServicoModel->delete(base64_decode($hel_pk_seq_ser));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Servico apagado com sucesso.');
			} 
		}				
		redirect('servico');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_SERVICO']  = site_url('servico');
		$dados['ACAO_FORM']         = site_url('servico/salvar');
	}
	
	
	private function carregarDados(&$dados) {
		
		$resultado = $this->ServicoModel->getServico();
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_desc_ser"       => $registro->hel_desc_ser,
				"EDITAR_SERVICO"	 => 'servico/editar/'.base64_encode($registro->hel_pk_seq_ser),
				"APAGAR_SERVICO" 	 => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_ser)."')"
			);
		}
	}
	
	private function carregarServico($hel_pk_seq_ser, &$dados) {
		$resultado = $this->ServicoModel->get($hel_pk_seq_ser);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
	}

	private function testarDados() {
		global $hel_desc_ser;

		$erros    = FALSE;
		$mensagem = null;

		$hel_desc_ser = trim($hel_desc_ser);
		
		if (empty($hel_desc_ser)) {
			$erros    = TRUE;
			$mensagem .= "- Descrição não preenchido.\n";
			$this->session->set_flashdata('ERRO_GAB_DESC_HEL', 'has-error');
		}

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_GAB_HEL', TRUE);				
			$this->session->set_flashdata('hel_desc_ser', $hel_desc_ser);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_ser) {
		$erros    = FALSE;
		$mensagem = null;
		
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_GAB_HEL   	   = $this->session->flashdata('ERRO_GAB_HEL');
		$ERRO_GAB_DESC_HEL     = $this->session->flashdata('ERRO_GAB_DESC_HEL');
		
		$hel_desc_hel    	   = $this->session->flashdata('hel_desc_hel');
	
		if ($ERRO_GAB_HEL) {
			$dados['hel_desc_ser']       = $hel_desc_hel;

			$dados['ERRO_GAB_DESC_HEL']  = $ERRO_GAB_DESC_HEL;
		}
	}
}