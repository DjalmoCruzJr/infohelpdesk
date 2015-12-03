<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('Usuario_Model', 'UsuarioModel');
		$this->load->model('Perfil_Model', 'PerfilModel');
		
		if (!isset($_SESSION)) {
			session_start();
		}
		
		if ($this->session->userdata('logado')) {$this->session->destroy();}	
	}
	
	public function index() {
		$dados = array();
		
		
		$dados['gab_login_usu']          = '';
		$dados['gab_senha_usu']          = '';
		
		$dados['ACAO_FORM'] = site_url('login/entrar');
		
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('login_view', $dados);
	}
	
	public function entrar() {		
		global $gab_login_usu;
		global $gab_senha_usu;
			
		global $usuario;
		global $perfil;
			
		$gab_login_usu  	= $this->input->post('gab_login_usu');
		$gab_senha_usu  	= $this->input->post('gab_senha_usu');
		
	
		if ($this->testarDados()) {
			$this->session->set_userdata(array('logado' => TRUE));
			$this->session->set_userdata($usuario);
			$this->session->set_userdata($perfil);
			redirect('');
		} else {
			redirect('login/');
		}
	}
	
	private function testarDados() {
		global $gab_login_usu;
		global $gab_senha_usu;
	
		global $usuario;
		global $perfil;
	
		$erros    = FALSE;
		$mensagem = null;
	
		
		if ((!empty($gab_login_usu)) and (!empty($gab_senha_usu))) {
			$usuario = $this->UsuarioModel->getUsuarioLogin($gab_login_usu, md5($gab_senha_usu));
			
			if (!$usuario){
				
				$erros    = TRUE;
				$mensagem .= "- Login inválido.\n";
				
				$this->session->set_flashdata('ERRO_GAB_LOGIN_USU', 'has-error');
				$this->session->set_flashdata('ERRO_GAB_SENHA_USU', 'has-error');
				
			} else if ($usuario and ($usuario->gab_ativo_usu == 0)) {
				$erros    = TRUE;
				$mensagem .= "- Usuário inativo.\n";

				$this->session->set_flashdata('ERRO_GAB_LOGIN_USU', 'has-error');
				$this->session->set_flashdata('ERRO_GAB_SENHA_USU', 'has-error');
			}else {
					$perfil = $this->PerfilModel->get($usuario->gab_seqper_usu);
				}
		}				
	
		if (empty($gab_login_usu)) {
			$erros    = TRUE;
			$mensagem .= "- Login não informado.\n";
	
			$this->session->set_flashdata('ERRO_GAB_LOGIN_USU', 'has-error');
		}
	
		if (empty($gab_senha_usu)) {
			$erros    = TRUE;
			$mensagem .= "- Senha não informada.\n";
	
			$this->session->set_flashdata('ERRO_GAB_SENHA_USU', 'has-error');
		}
	
			
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para entrar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
	
			$this->session->set_flashdata('ERRO_LOGIN', TRUE);			
			$this->session->set_flashdata('gab_login_usu', $gab_login_usu);
		}
	
		return !$erros;
	}

	
	private function carregarDadosFlash(&$dados) {
		$ERRO_LOGIN           = $this->session->flashdata('ERRO_LOGIN');		
		$ERRO_GAB_LOGIN_USU   = $this->session->flashdata('ERRO_GAB_LOGIN_USU');
		$ERRO_GAB_SENHA_USU   = $this->session->flashdata('ERRO_GAB_SENHA_USU');
			
		$gab_login_usu      = $this->session->flashdata('gab_login_usu');
	
		$titulo_erro = $this->session->flashdata('titulo_erro');
		$erro        = $this->session->flashdata('erro');
	
		if ($ERRO_LOGIN) {			
			$dados['gab_login_usu']        = $gab_login_usu;
				
				
			$dados['ERRO_GAB_LOGIN_USU']   = $ERRO_GAB_LOGIN_USU;
			$dados['ERRO_GAB_SENHA_USU']   = $ERRO_GAB_SENHA_USU;
				
				
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