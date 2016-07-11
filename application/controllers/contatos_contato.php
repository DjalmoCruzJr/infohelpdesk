<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contatos_Contato extends CI_Controller {
	public function __construct() {
		parent::__construct();
			
		$this->layout = LAYOUT_DASHBOARD;
			
		$this->load->model('Contato_Model', 'ContatoModel');
		$this->load->model('Contatos_Contato_Model', 'ContatosContatoModel');
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	public function index($hel_seqcon_cco) {
		$dados = array();
				
		$dados['NOVO_CONTATOS_CONTATO']   = site_url('contatos_contato/novo/'.$hel_seqcon_cco);
		$dados['URL_APAGAR']    		  = site_url('contatos_contato/apagar');
		$dados['VOLTAR_CONTATO']   		  = site_url('contato');
		$dados['BLC_DADOS']   		   	  = array();
		$dados['hel_seqcon_cco']		  = base64_decode($hel_seqcon_cco);

		$this->carregarContato($dados);

		$this->carregarDados($dados);
		
		$this->parser->parse('contatos_contato_consulta', $dados);
	}
	
	public function novo($hel_seqcon_cco) {
		$dados = array();
		$dados['hel_pk_seq_cco']    	= 0;
		$dados['hel_seqcon_cco']    	= base64_decode($hel_seqcon_cco);
		$dados['hel_tipo_cco']      	= '';
		$dados['hel_telefone_cco']  	= '';
		$dados['hel_ramal_cco']     	= '';
		$dados['hel_whatsapp_cco']  	= '';
		$dados['hel_maskphone_cco'] 	= 'mask-phone';
		$dados['hel_lbtelefone_cco'] 	= 'Telefone';
		$dados['hel_checktelefone_cco']	= 'checked';

		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('contatos_contato_cadastro', $dados);
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_CONTATOS_CONTATO']	= site_url('contatos_contato/index/'.base64_encode($dados['hel_seqcon_cco']));
		$dados['ACAO_FORM']            		= site_url('contatos_contato/salvar');
	}

	public function editar($hel_pk_seq_asu, $hel_seqsis_asu) {
		$hel_pk_seq_asu = base64_decode($hel_pk_seq_asu);
		$dados = array();
		$this->carregarAssuntoSistema($hel_pk_seq_asu, $dados);

		$this->carregarDadosFlash($dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		$this->parser->parse('assunto_sistema_cadastro', $dados);
	}
						
	public function salvar() {
		global $hel_pk_seq_cco;
		global $hel_seqcon_cco;
		global $hel_tipo_cco;
		global $hel_telefone_cco;
		global $hel_ramal_cco;
		global $hel_whatsapp_cco;
	
		$hel_pk_seq_cco  	= $this->input->post('hel_pk_seq_cco');
		$hel_seqcon_cco  	= $this->input->post('hel_seqcon_cco');
		$hel_tipo_cco	  	= $this->input->post('hel_tipo_cco');
		$hel_telefone_cco  	= $this->input->post('hel_telefone_cco');
		$hel_ramal_cco  	= $this->input->post('hel_ramal_cco');
		$hel_whatsapp_cco  	= $this->input->post('hel_whatsapp_cco');
		
		$hel_telefone_cco 		= str_replace("(", null, $hel_telefone_cco);
		$hel_telefone_cco 		= str_replace(")", null, $hel_telefone_cco);
		$hel_telefone_cco 		= str_replace("-", null, $hel_telefone_cco);
		if ($this->testarDados()) {
			$assunto = array(
				"hel_seqsis_asu"   => $hel_seqsis_asu,
				"hel_titulo_asu"   => $hel_titulo_asu,
				"hel_link_asu"	   => $hel_link_asu
			);
	
			if (!$hel_pk_seq_asu) {
				$hel_pk_seq_asu = $this->AssuntoSistemaModel->insert($assunto);
			} else {
				$hel_pk_seq_asu = $this->AssuntoSistemaModel->update($assunto, $hel_pk_seq_asu);
			}
	
			if (is_numeric($hel_pk_seq_asu)) {
				$this->session->set_flashdata('sucesso', 'Assunto do Sistema salvo com sucesso.');
				redirect('assunto_sistema/index/'.base64_encode($hel_seqsis_asu));
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_asu);
				redirect('assunto_sistema/index/'.base64_encode($hel_seqsis_asu));
			}
		} else {
			if (!$hel_pk_seq_asu) {
				redirect('contatos_contato/novo/'.base64_encode($hel_seqcon_cco));
			} else {
				redirect('contatos_contato/editar/'.base64_encode($hel_pk_seq_cco).'/'.base64_encode($hel_seqcon_cco));	
			}
		}
	}
	
	public function apagar($hel_pk_seq_asu, $hel_seqsis_asu) {
		if ($this->testarApagar(base64_decode($hel_pk_seq_asu))) {
			$res = $this->AssuntoSistemaModel->delete(base64_decode($hel_pk_seq_asu));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Assunto do sistema apagado com sucesso.');
			}
		}
			redirect('assunto_sistema/index/'.$hel_seqsis_asu);
	}
	
	private function carregarContato(&$dados) {
		$resultado = $this->ContatoModel->get($dados['hel_seqcon_cco']);
		if ($resultado) {
			$dados['NOME_CONTATO'] = $resultado->hel_nome_con;
		}
	}
	
	private function carregarDados(&$dados) {
		$resultado = $this->ContatosContatoModel->getContatos($dados['hel_seqcon_cco']);
		
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
					"hel_tipo_cco"		  		=> $registro->hel_tipo_cco,
					"hel_telefone_cco"			=> $registro->hel_telefone_cco,
					"hel_whatsapp_cco"			=> $registro->hel_whatsapp_cco,
					"EDITAR_CONTATOS_CONTATO"	=> site_url('contatos_contato/editar/'.base64_encode($registro->hel_pk_seq_cco).'/'.base64_encode($registro->hel_seqcon_cco)),
					"APAGAR_ASSUNTO_SISTEMA"	=> "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_cco)."','".base64_encode($dados['hel_seqcon_cco'])."')"
			);
		}
	}
		
	private function carregarAssuntoSistema($hel_pk_seq_asu, &$dados) {
		$resultado = $this->AssuntoSistemaModel->get($hel_pk_seq_asu);
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
	}
		
	private function carregarTelefoneCelular($hel_tipo_cco) {
		$telefoneCelular = '';
		switch ($hel_tipo_cco){
			case 0 : $telefoneCelular = 'Telefone';
					 break;
			case 1 : $telefoneCelular = 'Celular';
					 break;
		}
		return $telefoneCelular;
	}
		
	private function testarDados() {
		global $hel_pk_seq_cco;
		global $hel_seqcon_cco;
		global $hel_tipo_cco;
		global $hel_telefone_cco;
		global $hel_ramal_cco;
		global $hel_whatsapp_cco;
		
		$erros    = FALSE;
		$mensagem = null;
		
		
		if (empty($hel_seqcon_cco)) {
			$erros    = TRUE;
			$mensagem .= "- Contato não informado.\n";
		}
		
		if ($hel_tipo_cco == '') {
			$erros    = TRUE;
			$mensagem .= "- Tipo não informado.\n";
			$this->session->set_flashdata('ERRO_HEL_TIPO_CCO', 'has-error');
		}
		
		if (empty($hel_telefone_cco)) {
			$erros    = TRUE;
			$mensagem .= "- ".$this->carregarTelefoneCelular($hel_tipo_cco)." não informado.\n";
			$this->session->set_flashdata('ERRO_HEL_TELEFONE_CCO', 'has-error');
		}
			if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar, corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			$this->session->set_flashdata('ERRO_HEL_CCO', TRUE);
			$this->session->set_flashdata('hel_seqcon_cco', $hel_seqcon_cco);
			$this->session->set_flashdata('hel_tipo_cco', $hel_tipo_cco);
			$this->session->set_flashdata('hel_telefone_cco', $hel_telefone_cco);
			$this->session->set_flashdata('hel_ramal_cco', $hel_ramal_cco);
			$this->session->set_flashdata('hel_whatsapp_cco', $hel_whatsapp_cco);
		}
		
		return !$erros;
	}


	private function testarApagar($hel_pk_seq_asu) {
		$erros    = FALSE;
		$mensagem = null;

		$resultado = $this->AssuntoSistemaModel->get($hel_pk_seq_asu);

		if ($resultado){
				
			$nome_arquivo = $resultado->hel_link_asu;
			$caminho = "./uploads/assunto_sistema/";
			
			if (file_exists($caminho.$nome_arquivo)){
				unlink($caminho.$nome_arquivo);
			} else {
				$erros = TRUE;
				$mensagem = " - Erro ao verificar se o arquivo existi\n";
			}
		} else {
			show_error('Não foram encontrados dados do arquivo.', 500, 'Ops, erro encontrado');
		}
			
			
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
			
		return !$erros;
	}

	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_CCO   	     = $this->session->flashdata('ERRO_HEL_CCO');
		$ERRO_HEL_TIPO_CCO       = $this->session->flashdata('ERRO_HEL_TIPO_CCO');
		$ERRO_HEL_TELEFONE_CCO   = $this->session->flashdata('ERRO_HEL_TELEFONE_CCO');
		
		$hel_seqcon_cco			= $this->session->flashdata('hel_seqcon_cco');
		$hel_tipo_cco			= $this->session->flashdata('hel_tipo_cco');
		$hel_telefone_cco		= $this->session->flashdata('hel_telefone_cco');
		$hel_ramal_cco			= $this->session->flashdata('hel_ramal_cco');
		$hel_whatsapp_cco		= $this->session->flashdata('hel_whatsapp_cco');
	
		if ($ERRO_HEL_CCO) {
			$dados['hel_seqcon_cco']     		= $hel_seqcon_cco;
			$dados['hel_tipo_cco']       		= $hel_tipo_cco;
			$dados['hel_telefone_cco']	 		= $hel_telefone_cco;
			$dados['hel_ramal_cco']		 		= $hel_ramal_cco;
			$dados['hel_whatsapp_cco']	 		= $hel_whatsapp_cco;
			$dados['hel_lbtelefone_cco'] 		= $hel_tipo_cco == 0 ? 'Telefone' : 'Celular';
			$dados['hel_checktelefone_cco'] 	= $hel_tipo_cco == 0 ? 'checked' : '';
			$dados['hel_checkcelular_cco']  	= $hel_tipo_cco == 1 ? 'checked' : '';
			$dados['hel_checkedwhatsapp_cco']  	= $hel_whatsapp_cco == 1 ? 'checked' : '';
			
			$dados['ERRO_HEL_TIPO_CCO']      	= $ERRO_HEL_TIPO_CCO;
			$dados['ERRO_HEL_TELEFONE_CCO']  	= $ERRO_HEL_TELEFONE_CCO;
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
																																															
}