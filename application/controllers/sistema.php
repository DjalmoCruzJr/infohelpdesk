<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sistema extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Sistema_Model', 'SistemaModel');
		$this->load->model('assunto_sistema_model', 'AssuntoSistemaModel');
	}

	public function index() {
		$dados = array();
		
		$dados['NOVO_SISTEMA'] = site_url('sistema/novo');
		
		$dados['BLC_DADOS']    = array();
		$this->carregarDados($dados);
		
		$this->parser->parse('sistema_consulta', $dados);
	}
	
	public function novo() {		
		$dados = array();
		$dados['hel_pk_seq_sis']  	= 0;
		$dados['hel_codigo_sis']    = '';
		$dados['hel_desc_sis']  	= '';
		$dados['hel_tipo_sis']    	= '';
		
		$dados['ACAO'] 	= 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('sistema_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_sis) {		
		$hel_pk_seq_sis = base64_decode($hel_pk_seq_sis);
		$dados = array();
		
		$this->carregarSistema($hel_pk_seq_sis, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
				
		$this->parser->parse('sistema_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_sis;
		global $hel_codigo_sis;
		global $hel_desc_sis;
		global $hel_tipo_sis;
		
		$hel_pk_seq_sis  = $this->input->post('hel_pk_seq_sis');
		$hel_codigo_sis  = $this->input->post('hel_codigo_sis');
		$hel_desc_sis    = $this->input->post('hel_desc_sis');
		$hel_tipo_sis    = $this->input->post('hel_tipo_sis');

		if ($this->testarDados()) {
			$sistema = array(
				"hel_pk_seq_sis" => $hel_pk_seq_sis,
				"hel_codigo_sis" => $hel_codigo_sis,
				"hel_desc_sis"   => $hel_desc_sis,
				"hel_tipo_sis"   => $hel_tipo_sis
			);
			
			if (!$hel_pk_seq_sis) {	
				$hel_pk_seq_sis = $this->SistemaModel->insert($sistema);
			} else {
				$hel_pk_seq_sis = $this->SistemaModel->update($sistema, $hel_pk_seq_sis);
			}

			if (is_numeric($hel_pk_seq_sis)) {
				$this->session->set_flashdata('sucesso', 'Sistema salvo com sucesso.');
				redirect('sistema');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_sis);	
				redirect('sistema');
			}
		} else {
			if (!$hel_pk_seq_sis) {
				redirect('sistema/novo/');
			} else {
				redirect('sistema/editar/'.base64_encode($hel_pk_seq_sis));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_sis) {
		
		if ($this->testarApagar(base64_decode($hel_pk_seq_sis))) {
			$res = $this->SistemaModel->delete(base64_decode($hel_pk_seq_sis));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Sistema apagado com sucesso.');
			} 
		}				
		redirect('sistema');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_SISTEMA']  = site_url('sistema');
		$dados['ACAO_FORM']         = site_url('sistema/salvar');
	}
	
	
	private function carregarDados(&$dados) {
		
		$resultado = $this->SistemaModel->getSistema();
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_codigo_sis"     => $registro->hel_codigo_sis,
				"hel_desc_sis"       => $registro->hel_desc_sis,
				"hel_tipo_sis"       => $this->carregarTipoSistema($registro->hel_tipo_sis),
				"EDITAR_SISTEMA"	 => 'sistema/editar/'.base64_encode($registro->hel_pk_seq_sis),
				"APAGAR_SISTEMA" 	 => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_sis)."')"
			);
		}
	}
	
	private function carregarTipoSistema($hel_tipo_sis){
		$tipo = "";		
		switch ($hel_tipo_sis) {
			case 0 : $tipo = "Desktop";
					 break;
			case 1 : $tipo = "Mobile";
					 break;
			case 2 : $tipo = "Web";
					 break;
		}

		return $tipo;
	}
	
	private function carregarSistema($hel_pk_seq_sis, &$dados) {
		$resultado = $this->SistemaModel->get($hel_pk_seq_sis);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
		
		$this->carregarTipo($dados);
		
	}

	private function testarDados() {
		global $hel_pk_seq_sis;
		global $hel_codigo_sis;
		global $hel_desc_sis;
		global $hel_tipo_sis;
		
		$erros    = FALSE;
		$mensagem = null;
	
		$hel_codigo_sis = trim($hel_codigo_sis);
		$hel_desc_sis   = trim($hel_desc_sis);
		
		
		if (empty($hel_codigo_sis)) {
			$erros    = TRUE;
			$mensagem .= "- Código não preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_CODIGO_SIS', 'has-error');
		}
		
		if (empty($hel_desc_sis)) {
			$erros    = TRUE;
			$mensagem .= "- Descrição não preenchida.\n";
			$this->session->set_flashdata('ERRO_HEL_DESC_SIS', 'has-error');
		}
		
		if ($hel_tipo_sis == '') {
			$erros    = TRUE;
			$mensagem .= "- Tipo não informado.\n";
			$this->session->set_flashdata('ERRO_HEL_TIPO_SIS', 'has-error');
		}
		
		if (!$erros and $this->SistemaModel->getSistemaCadastrado($hel_pk_seq_sis, $hel_tipo_sis, $hel_codigo_sis)){
			$erros    = TRUE;
			$mensagem .= "- Já existi um sistema cadastrao.\n";
			$this->session->set_flashdata('ERRO_HEL_CODIGO_SIS', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_DESC_SIS', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_TIPO_SIS', 'has-error');
		}

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_SIS', TRUE);				
			$this->session->set_flashdata('hel_codigo_sis', $hel_codigo_sis);
			$this->session->set_flashdata('hel_desc_sis', $hel_desc_sis);
			$this->session->set_flashdata('hel_tipo_sis', $hel_tipo_sis);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_sis) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($this->AssuntoSistemaModel->getAssuntoSistema($hel_pk_seq_sis)) {
			$erros    = TRUE;
			$mensagem .= "- Assunto do sistema cadastrado.\n";
		}
		
		if ($this->AssuntoSistemaModel->getAssuntoSistema($hel_pk_seq_sis)) {
			$erros    = TRUE;
			$mensagem .= "- Assunto do sistema cadastrado.\n";
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarTipo(&$dados){
		switch ($dados['hel_tipo_sis']){
			case 0 : $dados['hel_checkDesktop_sis']  = 'checked';
					 break;
			case 1 : $dados['hel_checkMobile_sis']   = 'checked';
					 break;
			case 2 : $dados['hel_checkweb_sis']     = 'checked';
					 break;
		}
	}

	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_SIS      	   = $this->session->flashdata('ERRO_HEL_SIS');
		$ERRO_HEL_CODIGO_SIS   = $this->session->flashdata('ERRO_HEL_CODIGO_SIS');
		$ERRO_HEL_DESC_SIS     = $this->session->flashdata('ERRO_HEL_DESC_SIS');
		$ERRO_HEL_TIPO_SIS     = $this->session->flashdata('ERRO_HEL_TIPO_SIS');
		
		$hel_codigo_sis    	   = $this->session->flashdata('hel_codigo_sis');
		$hel_desc_sis    	   = $this->session->flashdata('hel_desc_sis');
		$hel_tipo_sis    	   = $this->session->flashdata('hel_tipo_sis');
	
		if ($ERRO_HEL_SIS) {
			$dados['hel_codigo_sis']       = $hel_codigo_sis;
			$dados['hel_desc_sis']         = $hel_desc_sis;
			$dados['hel_tipo_sis']         = $hel_tipo_sis;
			if ($hel_tipo_sis != ''){
				$this->carregarTipo($dados);
			}						

			$dados['ERRO_HEL_CODIGO_SIS']  = $ERRO_HEL_CODIGO_SIS;
			$dados['ERRO_HEL_DESC_SIS']    = $ERRO_HEL_DESC_SIS;
			$dados['ERRO_HEL_TIPO_SIS']    = $ERRO_HEL_TIPO_SIS;
			
		}
	}
	
}