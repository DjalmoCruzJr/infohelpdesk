<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Menu_Model', 'MenuModel');
		
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	
	public function index() {
		$dados = array();
		
		$dados['NOVO_MENU']    = site_url('menu/novo');
		
		$dados['BLC_DADOS']    = array();

		$this->carregarDados($dados);
		
		$this->parser->parse('menu_consulta', $dados);
		
	}
	
	public function novo() {		
		$dados = array();
		$dados['hel_pk_seq_men']  = 0;
		$dados['hel_desc_men']    = '';

		$dados['ACAO'] = 'Novo';

		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);

		$this->parser->parse('menu_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_men) {
		$hel_pk_seq_men = base64_decode($hel_pk_seq_men);
		$dados = array();

		$this->carregarMenu($hel_pk_seq_men, $dados);

		$this->carregarDadosFlash($dados);

		$dados['ACAO'] = 'Editar';

		$this->setarURL($dados);


		
		$this->parser->parse('menu_cadastro', $dados);
	}
	
	public function salvar() {
		global $hel_pk_seq_men;
		global $hel_desc_men;

		$hel_pk_seq_men  = $this->input->post('hel_pk_seq_men');
		$hel_desc_men    = $this->input->post('hel_desc_men');


		if ($this->testarDados()) {
			$menu = array(
				"hel_desc_men"   => $hel_desc_men
			);
			
			if (!$hel_pk_seq_men) {
				$hel_pk_seq_men = $this->MenuModel->insert($menu);
			} else {
				$hel_pk_seq_men = $this->MenuModel->update($menu, $hel_pk_seq_men);
			}

			if (is_numeric($hel_pk_seq_men)) {
				$this->session->set_flashdata('sucesso', 'Menu salvo com sucesso.');
				redirect('menu');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_men);
				redirect('menu');
			}
		} else {
			if (!$hel_pk_seq_men) {
				redirect('menu/novo/');
			} else {
				redirect('menu/editar/'.base64_encode($hel_pk_seq_men));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_men) {
		if ($this->testarApagar(base64_decode($hel_pk_seq_men))) {
			$res = $this->MenuModel->delete(base64_decode($hel_pk_seq_men));
				if ($res) {
					$this->session->set_flashdata('sucesso', 'Menu apagado com sucesso.');
				}
		}				
		redirect('menu');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_MENU']	= site_url('menu');
		$dados['ACAO_FORM']     = site_url('menu/salvar');
	}
	
	
	private function carregarDados(&$dados) {
		
		$resultado = $this->MenuModel->getMenu();
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_pk_seq_men"         => $registro->hel_pk_seq_men,
				"hel_desc_men"           => $registro->hel_desc_men,
				"EDITAR_MENU"			 => 'menu/editar/'.base64_encode($registro->hel_pk_seq_men),
				"APAGAR_MENU" 			 => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_men)."')"
			);
		}
	}

	
	private function carregarMenu($hel_pk_seq_men, &$dados) {
		$resultado = $this->MenuModel->get($hel_pk_seq_men);

		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}

	}
	

	private function testarDados() {
		global $hel_pk_seq_men;
		global $hel_desc_men;

		$erros    = FALSE;
		$mensagem = null;

		$hel_desc_men = trim($hel_desc_men);
		
		if (empty($hel_desc_men)) {
			$erros    = TRUE;
			$mensagem .= "- Descrição não preenchida.\n";
			$this->session->set_flashdata('ERRO_HEL_DESC_MEN', 'has-error');
		}

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_MEN', TRUE);
			$this->session->set_flashdata('hel_desc_tco', $hel_desc_men);

		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_men) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}

	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_MEN   	   = $this->session->flashdata('ERRO_HEL_MEN');
		$ERRO_HEL_DESC_MEN     = $this->session->flashdata('ERRO_HEL_DESC_MEN');


		$hel_desc_men     	   = $this->session->flashdata('hel_desc_men');

		if ($ERRO_HEL_MEN) {
			$dados['hel_desc_men']       = $hel_desc_men;

			$dados['ERRO_HEL_DESC_MEN']  = $ERRO_HEL_DESC_MEN;

		}
	}

	private function gerarRelatorio(){
		global $consulta;

		$result = $this->db->query($consulta);
		return $result->result();
	}

	public function relatorio($order_by){
        $order_by = str_replace("%20", " ", $order_by);
        global $consulta;
        $consulta = " SELECT * FROM heltbmen ".$order_by;
        if ($this->gerarRelatorio()) {
            $this->jasper->gerar_relatorio('assets/relatorios/relatorio_menu.jrxml', $consulta);
        } else {
            $mensagem = "- Nenhum Menu foi encontrado.\n";
            $this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
            $this->session->set_flashdata('erro', nl2br($mensagem));
            redirect('erro_relatorio');
        }
    }
	
}