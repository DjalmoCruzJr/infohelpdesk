<?php
class MeuPerfil extends CI_Controller{
	
	public function __construct() {
		parent::__construct();

		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('contato_model','ContatoModel');
	}
	

	public function index() {
		$dados = array();
	
		$dados['ACAO_FORM'] = site_url('meuperfil/salvar');
		
		$this->carregarDadosContato($this->session->userdata('hel_pk_seq_con'), $dados);
		
		$this->carregarDadosFlash($dados);
	
		$this->parser->parse('meuperfil_view', $dados);
	}
	
	
	private function carregarDadosContato($hel_pk_seq_con, &$dados) {
		$resultado = $this->ContatoModel->get($hel_pk_seq_con);
	
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
		$dados['hel_dis_login_con'] = "readonly";
	}
	
	public function salvar() {
		global $hel_pk_seq_con;
		global $hel_login_con;
		global $hel_senhaatual_con;
		global $hel_novasenha_con;
		global $hel_confirmarsenha_con;
		
	
		$hel_pk_seq_con 			= $this->input->post('hel_pk_seq_con');
		$hel_login_con 				= $this->input->post('hel_login_con');
		$hel_senhaatual_con 		= $this->input->post('hel_senhaatual_con');
		$hel_novasenha_con			= $this->input->post('hel_novasenha_con');
		$hel_confirmarsenha_con 	= $this->input->post('hel_confirmarsenha_con');
			
		if ($this->testarDados()) {
			$contato = array(	
				"hel_senha_con"  => sha1($hel_novasenha_con)
			);
				
			if ($hel_pk_seq_con) {
				$hel_pk_seq_con = $this->ContatoModel->update($contato, $hel_pk_seq_con);
			} 
	
			if (is_numeric($hel_pk_seq_con)) {
				$this->session->set_flashdata('sucesso', 'Senha alterada com sucesso.');
				redirect('meuperfil');
			}
			
		} else {
			if ($hel_pk_seq_con) {
				redirect('meuperfil');
			} 
		}
	}
	
	private function testarDados() {
		global $hel_pk_seq_con;
		global $hel_login_con;
		global $hel_senhaatual_con;
		global $hel_novasenha_con;
		global $hel_confirmarsenha_con;
		
		$erros    = FALSE;
		$mensagem = null;
		
		$hel_senhaatual_con 	= trim($hel_senhaatual_con);
		$hel_novasenha_con 		= trim($hel_novasenha_con);
		$hel_confirmarsenha_con = trim($hel_confirmarsenha_con);
			
		if (empty($hel_senhaatual_con)) {
			$erros     = TRUE;
			$mensagem .= "- Senha atual não preenchida.\n";
			$this->session->set_flashdata('ERRO_HEL_SENHAATUAL_ALT', 'has-error');
		}
		
		$resultado = $this->ContatoModel->get($hel_pk_seq_con);
		
		if (!$erros and $resultado->hel_senha_con != sha1($hel_senhaatual_con) )  {
			$erros     = TRUE;
			$mensagem .= "- Senha Atual diferente.\n";
			$this->session->set_flashdata('ERRO_HEL_SENHAATUAL_ALT', 'has-error');
		}
		
		if (empty($hel_novasenha_con)) {
			$erros     = TRUE;
			$mensagem .= "- Nova senha não preenchida.\n";
			$this->session->set_flashdata('ERRO_HEL_SENHA_ALT', 'has-error');
		}
		
		if (empty($hel_confirmarsenha_con)) {
			$erros     = TRUE;
			$mensagem .= "- Confimarção da nova senha não preenchida.\n";
			$this->session->set_flashdata('ERRO_HEL_CONFIRSENHA_ALT', 'has-error');
		}
				
		if ($hel_novasenha_con != $hel_confirmarsenha_con){
			$erros     = TRUE;
			$mensagem .= "- Nova senha e confirmação são diferentes.\n";
			$this->session->set_flashdata('ERRO_HEL_SENHAATUAL_ALT', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_SENHA_ALT', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_CONFIRSENHA_ALT', 'has-error');
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
				
			$this->session->set_flashdata('ERRO_HEL_ALT', TRUE);
			$this->session->set_flashdata('hel_login_con', $hel_login_con);
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_ALT   	   		= $this->session->flashdata('ERRO_HEL_ALT');
		$ERRO_HEL_SENHAATUAL_ALT    = $this->session->flashdata('ERRO_HEL_SENHAATUAL_ALT');
		$ERRO_HEL_SENHA_ALT    		= $this->session->flashdata('ERRO_HEL_SENHA_ALT');
		$ERRO_HEL_CONFIRSENHA_ALT   = $this->session->flashdata('ERRO_HEL_CONFIRSENHA_ALT');
		
		$hel_login_con     	   		= $this->session->flashdata('hel_login_con');
		
	
		if ($ERRO_HEL_ALT) {
			$dados['hel_login_con']      		= $hel_login_con;
	
			$dados['ERRO_HEL_SENHAATUAL_ALT']   = $ERRO_HEL_SENHAATUAL_ALT;
			$dados['ERRO_HEL_SENHA_ALT']    	= $ERRO_HEL_SENHA_ALT;
			$dados['ERRO_HEL_CONFIRSENHA_ALT']  = $ERRO_HEL_CONFIRSENHA_ALT;
		}
	}
}