<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chamado extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
 		$this->load->model('Chamado_Model', 'ChamadoModel');
		$this->load->model('Sistema_Contratado_Model', 'SistemaContratadoModel');
		$this->load->model('Empresa_Model', 'EmpresaModel');
	}

	
	public function index() {
		$dados = array();
		
		$dados['NOVO_CHAMADO'] = site_url('cidade/novo');
		
		$dados['BLC_DADOS']  = array();
		
		$this->carregarDados($dados);
				
		$this->parser->parse('chamado_consulta', $dados);
		
	}
	
	public function novo() {
			
		$dados = array();
		$dados['hel_pk_seq_cha']  	= 0;		
		$dados['hel_seqexc_cha']  	= '';
		$dados['hel_seqsis_cha']  	= '';
		$dados['hel_seqser_cha']  	= '';
		$dados['hel_seqemp_cha']  	= '';		
		$dados['hel_problema_cha']  = '';
				
		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
		
		$this->carregarEmpresa($dados);
		
		$this->parser->parse('chamado_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_cid) {		
		$hel_pk_seq_cid = base64_decode($hel_pk_seq_cid);
		$dados = array();
		
		$this->carregarCidade($hel_pk_seq_cid, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarEmpresa($dados);
		
		$this->parser->parse('cidade_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_cid;
		global $hel_nome_cid;
		global $hel_uf_cid;
		global $hel_codmun_cid;
		
		$hel_pk_seq_cid  = $this->input->post('hel_pk_seq_cid');			
		$hel_nome_cid    = $this->input->post('hel_nome_cid');
		$hel_uf_cid      = $this->input->post('hel_uf_cid');
		$hel_codmun_cid  = $this->input->post('hel_codmun_cid');

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
		$dados['CONSULTA_CHAMADO']  = site_url('chamado');
		$dados['ACAO_FORM']         = site_url('chamado/salvar');
	}	
	
	private function carregarDados(&$dados) {
				
		$resultado = $this->util->autorizacao($this->session->userdata('hel_tipo_tco')) ? $this->ChamadoModel->getChamado($this->session->userdata('hel_pk_seq_con')) : $this->ChamadoModel->getChamado() ;	
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_pk_seq_cha"     	=> 'Nº '.$registro->hel_pk_seq_cha,							
				"hel_nomefantasia_emp"  => $registro->hel_nomefantasia_emp,
				"hel_nome_con"         	=> $registro->hel_nome_con,
				"hel_codigo_sis"        => $registro->hel_codigo_sis,
				"hel_desc_ser"         	=> $registro->hel_desc_ser,
				"EDITAR_CHAMADO" 	 	=> site_url('chamado/editar/'.base64_encode($registro->hel_pk_seq_cha)),
				"APAGAR_CHAMADO" 	 	=> "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_cha)."')"
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
		$resultado = $this->EmpresaModel->getEmpresaAtivo();
	
		foreach ($resultado as $registro) {
			$dados['BLC_EMPRESA'][] = array(
					"hel_pk_seq_emp"     	=> $registro->hel_pk_seq_emp,
					"hel_nomefantasia_emp"  => $registro->hel_nomefantasia_emp,
					"sel_hel_seqemp_cha" 	=> ($dados['hel_seqemp_cha'] == $registro->hel_pk_seq_emp)?'selected':''
			);
		}
	
		!$resultado ? $dados['BLC_EMPRESA'][] = array("hel_nomefantasia_emp" => 'Não existe nenhuma empresa cadastrada') :'';
	}
	
	private function testarDados() {
		global $hel_pk_seq_cid;
		global $hel_nome_cid;
		global $hel_uf_cid;
		global $hel_codmun_cid;

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
			
			$this->session->set_flashdata('ERRO_HEL_CID', TRUE);				
			$this->session->set_flashdata('hel_nome_cid', $hel_nome_cid);
			$this->session->set_flashdata('hel_uf_cid', $hel_uf_cid);
			$this->session->set_flashdata('hel_codmun_cid', $hel_codmun_cid);
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
		$ERRO_HEL_CHA   	   = $this->session->flashdata('ERRO_HEL_CHA');
		$ERRO_HEL_SEQEMP_CHA   = $this->session->flashdata('ERRO_HEL_SEQEMP_CHA');		
		$ERRO_HEL_SEQSER_CHA   = $this->session->flashdata('ERRO_HEL_SEQSER_CHA');
		$ERRO_HEL_SEQSIS_CHA   = $this->session->flashdata('ERRO_HEL_SEQSIS_CHA');
		$ERRO_HEL_PROBLEMA_CHA = $this->session->flashdata('ERRO_HEL_PROBLEMA_CHA');

		$hel_seqemp_cha   	   = $this->session->flashdata('hel_seqemp_cha');
		$hel_seqser_cha        = $this->session->flashdata('hel_seqser_cha');
		$hel_seqsis_cha        = $this->session->flashdata('hel_seqsis_cha');
		$hel_problema_cha      = $this->session->flashdata('hel_problema_cha');

		if ($ERRO_HEL_CHA) {
			$dados['hel_seqemp_cha']       	 = $hel_seqemp_cha;
			$dados['hel_seqser_cha']         = $hel_seqser_cha;
			$dados['hel_seqsis_cha']     	 = $hel_seqsis_cha;
			$dados['hel_problema_cha']     	 = $hel_problema_cha;

			$dados['ERRO_HEL_SEQEMP_CHA']  	 = $ERRO_HEL_SEQEMP_CHA;
			$dados['ERRO_HEL_SEQSER_CHA']  	 = $ERRO_HEL_SEQSER_CHA;
			$dados['ERRO_HEL_SEQSIS_CHA']  	 = $ERRO_HEL_SEQSIS_CHA;
			$dados['ERRO_HEL_PROBLEMA_CHA']  = $ERRO_HEL_PROBLEMA_CHA;
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