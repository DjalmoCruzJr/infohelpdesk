<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('Tipo_Contato_Model', 'TipoContatoModel');
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
		
		$dados['ACAO_FORM']          = site_url('login/entrar');
		$dados['RELEMBRAR_FORM']     = site_url('lembrar_senha');
		
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('login_view', $dados);
	}
	
	public function entrar() {		
		global $hel_login_con;
		global $hel_senha_con;
			
		global $contato;
		global $tipo_contato;
			
		$hel_login_con  	= $this->input->post('hel_login_con');
		$hel_senha_con  	= $this->input->post('hel_senha_con');
		
	
		if ($this->testarDados()) {
			$this->session->set_userdata(array('logado' => TRUE));
			$this->session->set_userdata($contato);
			$this->session->set_userdata($tipo_contato);
			redirect('');
		} else {
			redirect('login');
		}
	}
	
	private function testarDados() {
		global $hel_login_con;
		global $hel_senha_con;
	
		global $contato;
		global $tipo_contato;
	
		$erros    = FALSE;
		$mensagem = null;
	
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
		
		
		if ((!empty($hel_login_con)) and (!empty($hel_senha_con))) {
			$contato = $this->ContatoModel->getContatoLogin($hel_login_con, sha1($hel_senha_con));
			
			if (!$contato){
				$erros    = TRUE;
				$mensagem .= "- Login inválido.\n";
				
				$this->session->set_flashdata('ERRO_HEL_LOGIN_CON', 'has-error');
				$this->session->set_flashdata('ERRO_HEL_SENHA_CON', 'has-error');
				
			} else if ( ($contato) and ($contato->hel_ativo_con == 0) ) {
				$erros    = TRUE;
				$mensagem .= "- Contato inativo.\n";

				$this->session->set_flashdata('ERRO_HEL_LOGIN_CON', 'has-error');
				$this->session->set_flashdata('ERRO_HEL_SENHA_CON', 'has-error');
			} else {
				$tipo_contato = $this->TipoContatoModel->get($contato->hel_seqtco_con);
			}
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
	
		$titulo_erro 		  = $this->session->flashdata('titulo_erro');
		$erro        		  = $this->session->flashdata('erro');
	
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