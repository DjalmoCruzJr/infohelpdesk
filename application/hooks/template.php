<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	public function init() {
		$CI		= &get_instance();
		
		$output = $CI->output->get_output();
        
        if (isset($CI->layout)) {
			
			if ($CI->layout) {
				
				if ($CI->layout == LAYOUT_DASHBOARD) {
					$tituloErroDash  = $CI->session->flashdata('titulo_erro'); 
					$erroDash        = $CI->session->flashdata('erro'); 
					$sucessoDash     = $CI->session->flashdata('sucesso');
				}
				
				if (!preg_match('/(.+).php$/', $CI->layout)) {
					$CI->layout .= '.php';
				}
				
				$template = APPPATH . 'templates/'.$CI->layout;
				
				if (file_exists($template)){
					$layout = $CI->load->file($template, TRUE);
				} else {
					die('Template inválida.');
				}
				
				$html	= str_replace("{CONTEUDO}", $output, $layout);
				
// 				if ($CI->session->userdata('logado')) {
// 					$this->carregarDadosSessao($CI, $html);
// 				} else {
// 					redirect('login/');
// 				}
				
				if (!$tituloErroDash) {
					$tituloErroDash = '';
				}
				
				if ($erroDash) {
					$html	= str_replace("{MENSAGEM_SISTEMA_ERRO}", $this->criarAlterta('alert-danger', $tituloErroDash, $erroDash), $html);
				} else {
					$html	= str_replace("{MENSAGEM_SISTEMA_ERRO}", null, $html);
				}
				
				if ($sucessoDash) {
					$html	= str_replace("{MENSAGEM_SISTEMA_SUCESSO}", $this->criarAlterta('alert-success', $sucessoDash, ''), $html);
				} else {
					$html	= str_replace("{MENSAGEM_SISTEMA_SUCESSO}", null, $html);
				}
				
				
			} else {
				$html = $output;
			}
		} else {
			$html = $output;
		}
		
		$CI->output->_display($html);
	}
	
	private function criarAlterta($tipo, $titulo, $mensagem) {
		$html = " <br/>
		<div class='alert {$tipo}' role='alert' align='center' >
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
		
	private function carregarDadosSessao($CI, &$html) {
		$CI->load->model('Contato_Model', 'ContatoModel');
		$resultado = $CI->ContatoModel->getQtdAniversariantes();
		
		$html	= str_replace("{gab_nome_usu}", $CI->session->userdata('gab_nome_usu'), $html);
		$html	= str_replace("{gab_desc_per}", $CI->session->userdata('gab_desc_per'), $html);
		$html   = str_replace("{ANIVERSARIANTES}", site_url('contato/carregarAniversariantes') ,$html);
		$html   = str_replace("{QTD_ANIVERSARIANTES}", $resultado->quantidade ,$html);
	}
	
}