<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lembrar_Senha extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
		$this->load->model('Contato_Model', 'ContatoModel');
	}

	
	public function index() {
		$dados = array();
		
		$dados['BLC_DADOS']   = array();
		
		$dados['hel_email_con'] = '';
		
		$this->setarURL($dados);
		$this->carregarDadosFlash($dados);

		$dados['ACAO_FORM'] 	= site_url('lembrar_senha/salvar');
		$dados['LOGIN_FORM'] 	= site_url('login');		
				
		$this->parser->parse('lembrar_senha_view', $dados);
	}
	
	
	public function salvar() {
		global $hel_pk_seq_con;
		global $hel_nome_con;
		global $hel_email_con;
		
		$hel_email_con = $this->input->post('hel_email_con');		
		
		if ($this->testarDados()) {
			
			$nova_senha = $this->util->gerar_senha(TAMANHO_SENHA,true,true,true);
			$body 		= ' <p>Olá, '.$hel_nome_con.' sua nova senha é:<strong>'.$nova_senha.'</strong>
						 	<p>Use-a para logar no sistema.<p>
							<p>É importante alterada a senha após o primeiro acesso.<p> ';
			$titulo     = 'Recuperação de senha - HelpDesk Info Rio Sistema LTDA';
			$emailFrom  = 'luizmariodev@gmail.com';
			$usuario    = 'Suporte';
			
				
			$contato = array(
				"hel_senha_con" => sha1($nova_senha)
			);
			
			if($hel_pk_seq_con) {
				$hel_pk_seq_con = $this->ContatoModel->update($contato, $hel_pk_seq_con);
			}
			
			if(!empty($hel_pk_seq_con)){
				
				$this->load->library('email');
				$this->email->initialize();
				
				$this->email->from($emailFrom, $usuario);
				$this->email->to($hel_email_con);
				
				$this->email->subject($titulo);
				$this->email->message($body);
				
				if ($this->email->send()){
					$dados = array();
					$dados['hel_email_con'] 			 = '';					
					$dados['MENSAGEM_LEMBRARSENHA_ERRO'] = $this->criarAltertaSucess('Para continuar, acesse seu email: ', ' - Verifique se foi enviando um e-mail com uma nova senha');
					$this->setarURL($dados);
					
					$this->parser->parse('lembrar_senha_view', $dados);
				}else {
					echo '<pre>';
					print_r($this->email->print_debugger());
				}
			}
			
		} else {
			redirect('lembrar_senha');
		}
	}
	
	
	private function setarURL(&$dados) {
		$dados['ACAO_FORM'] 	= site_url('lembrar_senha/salvar');
		$dados['LOGIN_FORM'] 	= site_url('login');
	}	
	
	private function testarDados() {
		global $hel_pk_seq_con;
		global $hel_nome_con;
		global $hel_email_con;

		$erros    = FALSE;
		$mensagem = null;

		$hel_email_con = trim($hel_email_con);

		if (empty($hel_email_con)) {
			$erros = TRUE;
			$mensagem .= "- e-mail não preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_EMAIL_CON', 'has-error');
		} else if (!filter_var($hel_email_con, FILTER_VALIDATE_EMAIL) ){
			$erros     = TRUE;
			$mensagem .= "- e-mail não é válido.\n";
			$this->session->set_flashdata('ERRO_HEL_EMAIL_CON', 'has-error');
		} else {
			
			$resultado = $this->ContatoModel->getEmail($hel_email_con);
		
			if ($resultado){
				$hel_pk_seq_con = $resultado->hel_pk_seq_con;
				$hel_nome_con   = $resultado->hel_nome_con;
			} else {
				$erros     = TRUE;
				$mensagem .= "- Nenhum registro foi encontrado para esse e-mail.\n";
				$this->session->set_flashdata('ERRO_HEL_EMAIL_CON', 'has-error');
			}
						
		}

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_CON', TRUE);				
			$this->session->set_flashdata('hel_email_con', $hel_email_con);
		}
				
		return !$erros;
	}
	
		
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_CON   			= $this->session->flashdata('ERRO_HEL_CON');
		$ERRO_HEL_EMAIL_CON			= $this->session->flashdata('ERRO_HEL_EMAIL_CON');
		$MENSAGEM_LEMBRARSENHA_ERRO	= $this->session->flashdata('MENSAGEM_LEMBRARSENHA_ERRO');

		$hel_email_con  	= $this->session->flashdata('hel_email_con');
		$titulo_erro 		= $this->session->flashdata('titulo_erro');
		$erro        		= $this->session->flashdata('erro');
		
		if ($ERRO_HEL_CON) {
			$dados['hel_email_con'] 	  		 = $hel_email_con;
			
			$dados['ERRO_HEL_EMAIL_CON']  		 = $ERRO_HEL_EMAIL_CON;
			$dados['MENSAGEM_LEMBRARSENHA_ERRO'] = $this->criarAlterta($titulo_erro, $erro);
		}else {
			$dados['MENSAGEM_LEMBRARSENHA_ERRO'] = '';
		}
	}
	
	private function criarAltertaSucess($titulo, $mensagem) {
		$html = " <br/>
		<div class='alert alert-success' role='alert' align='center' >
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
