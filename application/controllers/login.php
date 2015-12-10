<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('Contato_Model', 'ContatoModel');
		
		if (!isset($_SESSION)) {
			session_start();
		}
		
		if ($this->session->userdata('logado')) {$this->session->destroy();}	
	}
	
	public function index() {
		$dados = array();
		
		$dados['hel_login_con'] = '';
		$dados['hel_senha_con'] = '';
		
		$dados['ACAO_FORM']     = site_url('login/entrar');
		
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('login_view', $dados);
	}
	
	public function entrar() {		
		global $hel_login_con;
		global $hel_senha_con;
			
		global $contato;
		global $empresa;
			
		$hel_login_con  	= $this->input->post('hel_senha_con');
		$hel_senha_con  	= $this->input->post('hel_senha_con');
		
	
		if ($this->testarDados()) {
			$this->session->set_userdata(array('logado' => TRUE));
			$this->session->set_userdata($usuario);
			$this->session->set_userdata($perfil);
			redirect('');
		} else {
			redirect('login');
		}
	}
	
	private function testarDados() {
		global $hel_login_con;
		global $hel_senha_con;
	
		global $contato;
		global $empresa;
	
		$erros    = FALSE;
		$mensagem = null;
	
		
		if ((!empty($gab_login_usu)) and (!empty($gab_senha_usu))) {
			$usuario = $this->UsuarioModel->getUsuarioLogin($gab_login_usu, md5($gab_senha_usu));
			
// 			if (!$usuario){
				
// 				$erros    = TRUE;
// 				$mensagem .= "- Login inválido.\n";
				
// 				$this->session->set_flashdata('ERRO_GAB_LOGIN_USU', 'has-error');
// 				$this->session->set_flashdata('ERRO_GAB_SENHA_USU', 'has-error');
				
// 			} else if ($usuario and ($usuario->gab_ativo_usu == 0)) {
// 				$erros    = TRUE;
// 				$mensagem .= "- Usuário inativo.\n";

// 				$this->session->set_flashdata('ERRO_GAB_LOGIN_USU', 'has-error');
// 				$this->session->set_flashdata('ERRO_GAB_SENHA_USU', 'has-error');
// 			}else {
// 					$perfil = $this->PerfilModel->get($usuario->gab_seqper_usu);
// 				}
		}				
	
		if (empty($hel_login_con)) {
			$erros    = TRUE;
			$mensagem .= "- Login não informado.\n";
	
			$this->session->set_flashdata('ERRO_HEL_LOGIN_CON', 'has-error');
		}
	
		if (empty($hel_senha_con)) {
			$erros    = TRUE;
			$mensagem .= "- Senha não informada.\n";
	
			$this->session->set_flashdata('ERRO_HEL_SENHA_CON', 'has-error');
		}
	
			
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para entrar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
	
			$this->session->set_flashdata('ERRO_LOGIN', TRUE);			
			$this->session->set_flashdata('hel_login_con', $hel_login_con);
		}
	
		return !$erros;
	}

	
	private function carregarDadosFlash(&$dados) {
		$ERRO_LOGIN           = $this->session->flashdata('ERRO_LOGIN');		
		$ERRO_HEL_LOGIN_CON   = $this->session->flashdata('ERRO_HEL_LOGIN_CON');
		$ERRO_HEL_SENHA_CON   = $this->session->flashdata('ERRO_HEL_SENHA_CON');
			
		$hel_login_con        = $this->session->flashdata('hel_login_con');
	
		$titulo_erro = $this->session->flashdata('titulo_erro');
		$erro        = $this->session->flashdata('erro');
	
		if ($ERRO_LOGIN) {			
			$dados['hel_login_con']        = $hel_login_con;
				
			$dados['ERRO_HEL_LOGIN_CON']   = $ERRO_HEL_LOGIN_CON;
			$dados['ERRO_HEL_SENHA_CON']   = $ERRO_HEL_SENHA_CON;
				
			$dados['MENSAGEM_LOGIN_ERRO'] = $this->criarAlterta($titulo_erro, $erro);
		} else {
			$dados['MENSAGEM_LOGIN_ERRO'] = '';
		}
	}
	
	private function criarAlterta($titulo, $mensagem) {
		$html = " <br/>
		<div class='alert alert-danger' role='alert' align='center' >
		<button type='button' class='close' data-dismiss='alert'>
		<span aria-hidden='true'>&times;</span>
		</button>
		<h4>
		<strong>{$titulo}</strong>
		</h4>";
	
		if (!empty($mensagem)) {
		$html .= "<div align='left'>
		<strong>{$mensagem}</strong>
		</div>";
		}
			
			
		$html .= "</div>";
	
		return $html;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */