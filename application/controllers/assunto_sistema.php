<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assunto_Sistema extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Sistema_Model', 'SistemaModel');
		$this->load->model('Assunto_Sistema_Model', 'AssuntoSistemaModel');
		
// 		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	public function index() {
		$dados = array();
		
		$dados['NOVO_ASSUNTO_SISTEMA']    = site_url('assunto_sistema/novo');
		$dados['BLC_DADOS']   		   	  = array();

		$this->carregarDados($dados);
		
		$this->parser->parse('assunto_sistema_consulta', $dados);
	}
	
	public function novo() {		
		$dados = array();
		$dados['hel_pk_seq_asu']  	= 0;
		$dados['hel_seqsis_asu']    = 0;
		$dados['hel_titulo_asu']    = '';
		$dados['hel_link_asu']    	= '';

		$dados['ACAO'] = 'Novo';

		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);

		$this->parser->parse('assunto_sistema_cadastro', $dados);
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_ASSUNTO_SISTEMA']= site_url('assunto_sistema');
		$dados['ACAO_FORM']            = site_url('assunto_sistema/salvar');
	}
	
	public function editar($hel_pk_seq_asu) {
		$hel_pk_seq_asu = base64_decode($hel_pk_seq_asu);
		$dados = array();

		$this->carregarAssuntoSistema($hel_pk_seq_asu, $dados);

		$this->carregarDadosFlash($dados);

		$dados['ACAO'] = 'Editar';

		$this->setarURL($dados);

		$this->parser->parse('assunto_istema_cadastro', $dados);
	}
	
	public function salvar() {
		global $hel_pk_seq_tco;
		global $hel_desc_tco;
		global $hel_tipo_tco;

		$hel_pk_seq_tco  = $this->input->post('hel_pk_seq_tco');
		$hel_desc_tco    = $this->input->post('hel_desc_tco');
		$hel_tipo_tco    = $this->input->post('hel_tipo_tco');

		if ($this->testarDados()) {
			$tipo_contato = array(
				"hel_desc_tco"   => $hel_desc_tco,
				"hel_tipo_tco"   => $hel_tipo_tco
			);
			
			if (!$hel_pk_seq_tco) {
				$hel_pk_seq_tco = $this->Tipo_ContatoModel->insert($tipo_contato);
			} else {
				$hel_pk_seq_tco = $this->Tipo_ContatoModel->update($tipo_contato, $hel_pk_seq_tco);
			}

			if (is_numeric($hel_pk_seq_tco)) {
				$this->session->set_flashdata('sucesso', 'Tipo de Contato salvo com sucesso.');
				redirect('tipo_contato');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_tco);
				redirect('tipo_contato');
			}
		} else {
			if (!$hel_pk_seq_tco) {
				redirect('tipo_contato/novo/');
			} else {
				redirect('tipo_contato/editar/'.base64_encode($hel_pk_seq_tco));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_asu) {

		$res = $this->AssuntoSistemaModel->delete(base64_decode($hel_pk_seq_asu));
		
		if ($res) {	$this->session->set_flashdata('sucesso', 'Assunto do sistema apagado com sucesso.'); }			
		redirect('assunto_sistema');
	}
	
	
	
	
	private function carregarDados(&$dados) {

		$resultado = $this->AssuntoSistemaModel->getAssunto();

		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_codigo_sis"			=> $registro->hel_codigo_sis,
				"hel_desc_sis"				=> $registro->hel_desc_sis,
				"hel_titulo_asu"			=> $registro->hel_titulo_asu,
				"EDITAR_ASSUNTO_SISTEMA"	=> 'assunto_sistema/editar/'.base64_encode($registro->hel_pk_seq_asu),
				"APAGAR_ASSUNTO_SISTEMA"	=> "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_asu)."')"
			);
		}
	}
	
	private function carregarAssuntoSistema($hel_pk_seq_asu, &$dados) {
		$resultado = $this->AssuntoSistemaModel->getAssuntoSistema($hel_pk_seq_asu);

		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
	}
	

	private function testarDados() {
		global $hel_pk_seq_tco;
		global $hel_desc_tco;
		global $hel_tipo_tco;

		$erros    = FALSE;
		$mensagem = null;

		$hel_desc_tco = trim($hel_desc_tco);
		
		if (empty($hel_desc_tco)) {
			$erros    = TRUE;
			$mensagem .= "- Descrição não preenchida.\n";
			$this->session->set_flashdata('ERRO_HEL_DESC_TCO', 'has-error');
		}

		if ($hel_tipo_tco == '') {
			$erros    = TRUE;
			$mensagem .= "- Tipo de contado não preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_TIPO_TCO', 'has-error');
		}


		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_TCO', TRUE);
			$this->session->set_flashdata('hel_desc_tco', $hel_desc_tco);
			$this->session->set_flashdata('hel_tipo_tco', $hel_tipo_tco);

		}
				
		return !$erros;
	}
	
// 	private function testarApagar($hel_pk_seq_tco) {
// 		$erros    = FALSE;
// 		$mensagem = null;
	
// 		if ($this->ContatoModel->getContatoCadastrado($hel_pk_seq_tco)) {
// 			$erros    = TRUE;
// 			$mensagem .= "- Contato cadastrado.\n";
// 		}
		
// 		if ($erros) {
// 			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
// 			$this->session->set_flashdata('erro', nl2br($mensagem));
// 		}
	
// 		return !$erros;
// 	}
	
	private function carregarDadosFlash(&$dados) {
			
		$ERRO_HEL_ASU   	   = $this->session->flashdata('ERRO_HEL_TCO');
		$ERRO_HEL_SEQSIS_ASU   = $this->session->flashdata('ERRO_HEL_SEQSIS_ASU');
		$ERRO_HEL_TITULO_ASU   = $this->session->flashdata('ERRO_HEL_TITULO_ASU');
		$ERRO_HEL_LINK_ASU     = $this->session->flashdata('ERRO_HEL_LINK_ASU');

		$hel_seqsis_asu			= $this->session->flashdata('hel_seqsis_asu');
		$hel_titulo_asu			= $this->session->flashdata('hel_titulo_asu');
		$hel_link_asu			= $this->session->flashdata('hel_link_asu');

		if ($ERRO_HEL_ASU) {
			$dados['hel_seqsis_asu']       = $hel_seqsis_asu;
			$dados['hel_titulo_asu']       = $hel_titulo_asu;
			$dados['hel_link_asu']		   = $hel_link_asu;
			
			$dados['ERRO_HEL_SEQSIS_ASU']  = $ERRO_HEL_SEQSIS_ASU;
			$dados['ERRO_HEL_TITULO_ASU']  = $ERRO_HEL_TITULO_ASU;
			$dados['ERRO_HEL_LINK_ASU']    = $ERRO_HEL_LINK_ASU;
			
		}
	}

	private function gerarRelatorio(){
		global $consulta;

		$result = $this->db->query($consulta);
		return $result->result();
	}

	public function relatorio($order_by,$hel_tipo_tco){
		$clasulaWhere = "";
		$whereAnd    = " WHERE ";
		$order_by = str_replace("%20", " ", $order_by);

		switch ($hel_tipo_tco){
			case 0 : $clasulaWhere = $clasulaWhere.$whereAnd.' hel_tipo_tco = '.$hel_tipo_tco;
				    $whereAnd = " AND ";
					break;
			case 1 : $clasulaWhere = $clasulaWhere.$whereAnd.' hel_tipo_tco = '.$hel_tipo_tco;
				     $whereAnd = " AND ";
				     break;
			case 2 : $clasulaWhere = $clasulaWhere.$whereAnd.' hel_tipo_tco = '.$hel_tipo_tco;
				     $whereAnd = " AND ";
				     break;
		}

		global $consulta;
		$consulta = " SELECT hel_pk_seq_tco,
							 hel_desc_tco,
							 CASE hel_tipo_tco WHEN 0 THEN 'Técnico'
							  WHEN 1 THEN 'Responsável'
							  WHEN 2 THEN 'Outros'
							 end as hel_tipo_tco
						FROM heltbtco".$clasulaWhere.$order_by;

		if ($this->gerarRelatorio()) {
			$this->jasper->gerar_relatorio('assets/relatorios/relatorio_tipo_contato.jrxml', $consulta);
		} else {
			$mensagem = "- Nenhum Tipo de Contato foi encontrado.\n";
			$this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			redirect('erro_relatorio');
		}
	}
	
	public function uploadArquivo($id){
		
		$dados = array();
		
		$dados['UPLOAD'] 	= site_url('assunto_sistema/uploadArquivo');
		$dados['CANCELAR'] 	= site_url('assunto_sistema/cancelar');
		$dados['CANCELAR'] 	= site_url('assunto_sistema/cancelar');
		$dados['CANCELAR'] 	= site_url('assunto_sistema/excluir');
	}

}