<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_Sistemas_Contratados extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;

		$this->load->model('Menu_Model', 'MenuModel');
		$this->load->model('Menu_Sistemas_Contratados_Model', 'MenuSistemasContratadosModel');
		$this->load->model('Sistemas_Contratados_Model', 'SistemasContratadosModel');
		$this->load->model('Sistema_Model', 'SistemaModel');
		$this->load->model('Menu_Sistema_Model', 'MenuSistemaModel');
	}

	
	public function index($hel_seqemp_sco, $hel_pk_seq_sco) {
		$dados = array();
		$dados['NOVO_CONTATO']     			= site_url('menu_sistemas_contratados/novo/'.$hel_seqemp_sco.'/'.$hel_pk_seq_sco);
		$dados['URL_APAGAR'] 	   			= site_url('menu_sistemas_contratados/apagar');
		$dados['VOLTAR_SISTEMA_CONTRATADO'] = site_url('sistemas_contratados/index/'.$hel_seqemp_sco);
		$dados['hel_seqsco_msc']   			= base64_decode($hel_pk_seq_sco);
		$dados['hel_seqemp_sco']   			= $hel_seqemp_sco;

		$this->carregarSistemaContratado($dados);
		
		$dados['BLC_DADOS']   = array();
		
		$this->carregarDados($dados);
				
		$this->parser->parse('menu_sistemas_contratados_consulta', $dados);
	}
	
	public function novo($hel_seqemp_sco, $hel_seqsco_msc) {
			
		$dados = array();
		$dados['hel_pk_seq_msc'] = 0;
		$dados['hel_seqsco_msc'] = base64_decode($hel_seqsco_msc);
		$dados['hel_seqmen_msc'] = '';
		$dados['hel_seqemp_sco'] = $hel_seqemp_sco;
		
		$dados['ACAO'] = 'Novo';
		
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);

		$this->carregarMenu($dados);
		
		$this->parser->parse('menu_sistemas_contratados_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_sco, $hel_seqemp_sco) {
		$dados = array();

		$hel_pk_seq_sco 		 = base64_decode($hel_pk_seq_sco);
		$dados['hel_seqemp_sco'] = base64_decode($hel_seqemp_sco);
		
		$this->carregarSistemasContratados($hel_pk_seq_sco, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarSistemas($dados);
		
		$this->parser->parse('sistemas_contratados_cadastro', $dados);
	}
	
	public function salvar($hel_seqemp_sco) {
		global $hel_pk_seq_msc;
		global $hel_seqsco_msc;
		global $hel_seqmen_msc;

		$hel_pk_seq_msc = $this->input->post('hel_pk_seq_msc');
		$hel_seqsco_msc = $this->input->post('hel_seqsco_msc');
		$hel_seqmen_msc	= $this->input->post('hel_seqmen_msc');

		if ($this->testarDados()) {
			$menu_cadastrado = array(
				"hel_seqsco_msc" => $hel_seqsco_msc,
				"hel_seqmen_msc" => $hel_seqmen_msc,
			);
			
			if (!$hel_pk_seq_msc) {
				$hel_pk_seq_msc = $this->MenuSistemasContratadosModel->insert($menu_cadastrado);
			} else {
				$hel_pk_seq_msc = $this->MenuSistemasContratadosModel->update($menu_cadastrado, $hel_pk_seq_msc);
			}

			if (is_numeric($hel_pk_seq_msc)) {
				$this->session->set_flashdata('sucesso', 'Menu Contratado salvo com sucesso.');
				redirect('menu_sistemas_contratados/index/'.$hel_seqemp_sco.'/'.base64_encode($hel_seqsco_msc));
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_sco);
				redirect('menu_sistemas_contratados/index/'.$hel_seqemp_sco.'/'.base64_encode($hel_seqsco_msc));
			}
		} else {
			if (!$hel_pk_seq_msc) {
				redirect('menu_sistemas_contratados/novo/'.$hel_seqemp_sco.'/'.base64_encode($hel_seqsco_msc));
			} else {
				redirect('menu_sistemas_contratados/editar/'.$hel_seqemp_sco.'/'.base64_encode($hel_seqemp_sco));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_sco, $hel_seqemp_sco) {
		if ($this->testarApagar(base64_decode($hel_pk_seq_sco))) {
			$res = $this->SistemasContratadosModel->delete(base64_decode($hel_pk_seq_sco));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Sistemas Contratados com sucesso.');
			} 
		}				
		redirect('sistemas_contratados/index/'.$hel_seqemp_sco);
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_MENU_CONTRATADOS']  = site_url('menu_sistemas_contratados/index/'.$dados['hel_seqemp_sco'].'/'.base64_encode($dados['hel_seqsco_msc']));
		$dados['ACAO_FORM']         		 = site_url('menu_sistemas_contratados/salvar/'.$dados['hel_seqemp_sco']);
	}

	private function carregarSistemaContratado(&$dados) {

		$resultado = $this->SistemasContratadosModel->get($dados['hel_seqsco_msc']);
		if ($resultado) {
			$resultado = $this->SistemaModel->get($resultado->hel_seqsis_sco);
			if ($resultado){
				$dados['NOME_SISTEMA'] = $resultado->hel_desc_sis;
			}
		}
	}

	private function carregarMenu(&$dados) {
		$resultado = $this->MenuModel->getMenu();

		foreach ($resultado as $registro) {
			$dados['BLC_MENU'][] = array(
				"hel_pk_seq_men"     	=> $registro->hel_pk_seq_men,
				"hel_desc_men"  		=> $registro->hel_desc_men,
				"sel_hel_seqmen_msc" 	=> ($dados['hel_seqmen_msc'] == $registro->hel_pk_seq_men)?'selected':'' );
		}

		!$resultado ? $dados['BLC_SISTEMA'][] = array("hel_desc_men" => 'Não existe nenhuma menu cadastrado') :'';
	}
	
	private function carregarDados(&$dados) {
		$resultado = $this->MenuSistemasContratadosModel->getMenuContratados($dados['hel_seqsco_msc']);
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_desc_men"    			   => $registro->hel_desc_men,
				"EDITAR_SISTEMAS_CONTRATADOS"  => site_url('menu_sistemas_contratados/editar/'.base64_encode($registro->hel_pk_seq_msc).'/'.base64_encode($dados['hel_seqsco_msc']).'/'.$dados['hel_seqemp_sco']),
// 				"APAGAR_SISTEMAS_CONTRATADOS"  => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_msc)."','".base64_encode($dados['hel_seqmen_msc'])."')"
			);
		}
	}
	
	private function carregarSistemasContratados($hel_pk_seq_sco, &$dados) {
		$resultado = $this->SistemasContratadosModel->get($hel_pk_seq_sco);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
	}

	
	
	private function testarDados() {
		global $hel_pk_seq_msc;
		global $hel_seqsco_msc;
		global $hel_seqmen_msc;
		
		$erros    = FALSE;
		$mensagem = null;


		if (empty($hel_seqmen_msc)){
			$erros    = TRUE;
			$mensagem .= "- Menu Contratado não foi selecionado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQMEN_MSC', 'has-error');
		}

		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_MSC', TRUE);
			$this->session->set_flashdata('hel_seqsco_msc', $hel_seqmen_msc);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_con) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($this->MenuSistemaModel->getMenuSistemaContratado($hel_pk_seq_con)) {
			$erros     = TRUE;
			$mensagem .= "- Contatos da empresa cadastro.\n";
		}
	
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_MSC   	 = $this->session->flashdata('ERRO_HEL_MSC');
		$ERRO_HEL_SEQMEN_MSC = $this->session->flashdata('ERRO_HEL_SEQMEN_MSC');

		$hel_seqsco_msc 	        = $this->session->flashdata('hel_seqsco_msc');


		if ($ERRO_HEL_MSC) {
			$dados['hel_seqsco_msc']       = $hel_seqsco_msc;

			$dados['ERRO_HEL_SEQMEN_MSC']  = $ERRO_HEL_SEQMEN_MSC;
		}
	}
	
}
