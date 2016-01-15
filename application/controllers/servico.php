<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servico extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Servico_Model', 'ServicoModel');
		
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
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
		$dados['hel_pk_seq_ser']	    	= 0;
		$dados['hel_desc_ser']    	    	= '';
		$dados['hel_sistema_ser'] 	    	= '';
		$dados['hel_checkecsistema_ser'] 	= '';
		
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
		global $hel_sistema_ser;

		$hel_pk_seq_ser  = $this->input->post('hel_pk_seq_ser');			
		$hel_desc_ser    = $this->input->post('hel_desc_ser');
		$hel_sistema_ser = $this->input->post('hel_sistema_ser') == 1 ? 1 : 0;

		if ($this->testarDados()) {
			$servico = array(
				"hel_desc_ser"   => $hel_desc_ser,
				"hel_sistema_ser" => $hel_sistema_ser
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
				$this->session->set_flashdata('sucesso', 'Serviço apagado com sucesso.');
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

		$dados['hel_checkechamado_ser'] 	= $dados['hel_chamado_ser'] == 1 ? 'checked' : '';
		$dados['hel_checkecsistema_ser'] 	= $dados['hel_sistema_ser'] == 1 ? 'checked' : '';
	}

	private function testarDados() {
		global $hel_pk_seq_ser;
		global $hel_desc_ser;
		global $hel_sistema_ser;

		$erros    = FALSE;
		$mensagem = null;

		$hel_desc_ser = trim($hel_desc_ser);
		
		if (empty($hel_desc_ser)) {
			$erros    = TRUE;
			$mensagem .= "- Descrição não preenchida.\n";
			$this->session->set_flashdata('ERRO_HEL_DESC_SER', 'has-error');
		}

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_SER', TRUE);
			$this->session->set_flashdata('hel_desc_ser', $hel_desc_ser);
			$this->session->set_flashdata('hel_sistema_ser', $hel_sistema_ser);
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
		$ERRO_HEL_SER   	   = $this->session->flashdata('ERRO_HEL_SER');
		$ERRO_HEL_DESC_SER     = $this->session->flashdata('ERRO_HEL_DESC_SER');

		$hel_desc_ser    	   = $this->session->flashdata('hel_desc_ser');
		$hel_chamado_ser       = $this->session->flashdata('hel_chamado_ser');
		$hel_sistema_ser       = $this->session->flashdata('hel_sistema_ser');

		if ($ERRO_HEL_SER) {
			$dados['hel_desc_ser']          	= $hel_desc_ser;
			$dados['hel_chamado_ser']       	= $hel_chamado_ser;
			$dados['hel_sistema_ser']       	= $hel_sistema_ser;
			$dados['hel_checkecsistema_ser'] 	= $hel_sistema_ser == 1 ? 'checked' : '';

			$dados['ERRO_HEL_DESC_SER']    		= $ERRO_HEL_DESC_SER;
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
		$consulta = " SELECT * FROM heltbser ".$order_by;
	
		if ($this->gerarRelatorio()) {
			$this->jasper->gerar_relatorio('assets/relatorios/relatorio_servico.jrxml', $consulta);
		} else {
			$mensagem = "- Nenhum serviço foi encontrado.\n";
			$this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			redirect('erro_relatorio');
		}
	}
}