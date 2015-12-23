<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordem_Servico extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Ordem_Servico_Model', 'OrdemServicoModel');
		$this->load->model('Empresa_Model', 'EmpresaModel');
		
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	
	public function index() {
		$dados = array();
		
		$dados['NOVA_ORDEM_SERVICO']	= site_url('ordem_servico/novo');
		
		$dados['BLC_DADOS']  = array();
		
		$this->carregarDados($dados);
				
		$this->parser->parse('ordem_servico_consulta', $dados);
	}
	
	public function novo() {
			
		$dados = array();
		$dados['hel_pk_seq_cid']  			= 0;		
		$dados['hel_horarioinicial_ose']    = date("d/m/y H:i:s");
		$dados['hel_seqemp_ose']    		= '';
		$dados['hel_seqcontec_ose']    		= '';
				
		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
	
		$this->carregarEmpresa($dados);
		
		$this->parser->parse('ordem_servico_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_cid) {		
		$hel_pk_seq_cid = base64_decode($hel_pk_seq_cid);
		$dados = array();
		
		$this->carregarCidade($hel_pk_seq_cid, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarUf($dados);
		
		$this->parser->parse('cidade_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_ose;
		global $hel_seqemp_ose;
		global $hel_seqcontec_ose;
		
		$hel_pk_seq_ose  	= $this->input->post('hel_pk_seq_ose');			
		$hel_seqemp_ose    	= $this->input->post('hel_seqemp_ose');
		$hel_seqcontec_ose 	= $this->input->post('hel_seqcontec_ose');

		if ($this->testarDados()) {
			$cidade = array(
				"hel_nome_cid"   => $hel_nome_cid, 
				"hel_uf_cid"     => $hel_uf_cid,
				"hel_codmun_cid" => $hel_codmun_cid
			);
			
			if (!$hel_pk_seq_cid) {	
				$hel_pk_seq_cid = $this->CidadeModel->insert($cidade);
			} else {
				$hel_pk_seq_cid = $this->CidadeModel->update($cidade, $hel_pk_seq_cid);
			}

			if (is_numeric($hel_pk_seq_cid)) {
				$this->session->set_flashdata('sucesso', 'Cidade salva com sucesso.');
				redirect('cidade');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_cid);	
				redirect('cidade');
			}
		} else {
			if (!$hel_pk_seq_cid) {
				redirect('cidade/novo/');
			} else {
				redirect('cidade/editar/'.base64_encode($hel_pk_seq_cid));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_cid) {		
		if ($this->testarApagar(base64_decode($hel_pk_seq_cid))) {
			$res = $this->CidadeModel->delete(base64_decode($hel_pk_seq_cid));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Cidade apagada com sucesso.');
			} 
		}				
		redirect('cidade');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_ORDEM_SERVICO'] = site_url('ordem_servico');
		$dados['ACAO_FORM']         	 = site_url('ordem_servico/salvar');
	}	
	
	private function carregarDados(&$dados) {
				
		$resultado = $this->OrdemServicoModel->getOrdemServico();	
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_nomefantasia_emp" 	 => $registro->hel_nomefantasia_emp,							
				"hel_nome_con"         	 => $registro->hel_nome_con,
				"hel_horarioinicial_ose" => $registro->hel_horarioinicial_ose,
				"hel_horariofinal_ose" 	 => $registro->hel_horariofinal_ose,
				"EDITAR_ORDEM_SERVICO" 	 => site_url('ordem_servico/editar/'.base64_encode($registro->hel_pk_seq_ose)),
				"APAGAR_ORDEM_SERVICO" 	 => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_ose)."')"
			);
		}
	}
	
	private function carregarCidade($hel_pk_seq_cid, &$dados) {
		$resultado = $this->CidadeModel->get($hel_pk_seq_cid);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
		
		$dados['gab_selected_uf'] = 'selected';
	}
	
	
	private function carregarEmpresa(&$dados) {
		$resultado = $this->EmpresaModel->getEmpresa();
	
		foreach ($resultado as $registro) {
			$dados['BLC_EMPRESA'][] = array(
					"hel_pk_seq_emp"     	=> $registro->hel_pk_seq_emp,
					"hel_nomefantasia_emp" 	=> $registro->hel_nomefantasia_emp,
					"sel_hel_seqemp_ose"	=> ($dados['hel_seqemp_ose'] == $registro->hel_pk_seq_emp)?'selected':''
			);
		}
	
		!$resultado ? $dados['BLC_EMPRESA'][] = array("hel_nomefantasia_emp" => 'Não existe nenhuma empresa cadastrada') :'';
	}
	
	private function testarDados() {
		global $hel_pk_seq_ose;
		global $hel_seqemp_ose;
		global $hel_seqcontec_ose;

		$erros    = FALSE;
		$mensagem = null;

		$hel_nome_cid = trim($hel_nome_cid);
		
		if (empty($hel_nome_cid)) {
			$erros    = TRUE;
			$mensagem .= "- Nome não preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_NOME_CID', 'has-error');
		}

		if (empty($hel_uf_cid)) {
			$erros    = TRUE;
			$mensagem .= "- UF não foi selecionada.\n";
			$this->session->set_flashdata('ERRO_HEL_UF_CID', 'has-error');
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_OSE', TRUE);				
			$this->session->set_flashdata('hel_nome_cid', $gab_nome_cid);
			$this->session->set_flashdata('hel_uf_cid', $gab_uf_cid);
			$this->session->set_flashdata('hel_codmun_cid', $gab_codmun_cid);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_cid) {
		$erros    = FALSE;
		$mensagem = null;
	
		if ($this->EmpresaModel->getEmpresaCidade($hel_pk_seq_cid)) {
			$erros    = TRUE;
			$mensagem .= "- Empresa cadastrada.\n";
		}
	
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_OSE   	   = $this->session->flashdata('ERRO_HEL_OSE');
		$ERRO_HEL_SEQEXC_OSE   = $this->session->flashdata('ERRO_HEL_SEQEXC_OSE');
		$ERRO_HEL_SEQCON_OSE   = $this->session->flashdata('ERRO_HEL_SEQCON_OSE');
		

		$hel_seqexc_ose        = $this->session->flashdata('hel_seqexc_ose');

		if ($ERRO_HEL_OSE) {
			$dados['hel_seqexc_ose']       = $hel_seqexc_ose;

			$dados['ERRO_HEL_SEQEXC_OSE']  = $ERRO_HEL_SEQEXC_OSE;
			$dados['ERRO_HEL_SEQCON_OSE']  = $ERRO_HEL_SEQCON_OSE;
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
		$consulta = " SELECT * FROM heltbcid ".$order_by;
	
		if ($this->gerarRelatorio()) {
			$this->jasper->gerar_relatorio('assets/relatorios/relatorio_cidade.jrxml', $consulta);
		} else {
			$mensagem = "- Nenhum cidade foi encontrada.\n";
			$this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			redirect('erro_relatorio');
		}
	}
	
}