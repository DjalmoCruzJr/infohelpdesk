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
		$dados['hel_skype_cco']  		= '';
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

	public function editar($hel_pk_seq_cco, $hel_seqsis_asu) {
		$hel_pk_seq_cco = base64_decode($hel_pk_seq_cco);
		$dados = array();
		$this->carregarContatosContato($hel_pk_seq_cco, $dados);

		$this->carregarDadosFlash($dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->parser->parse('contatos_contato_cadastro', $dados);
	}
						
	public function salvar() {
		global $hel_pk_seq_cco;
		global $hel_seqcon_cco;
		global $hel_tipo_cco;
		global $hel_telefone_cco;
		global $hel_ramal_cco;
		global $hel_whatsapp_cco;
		global $hel_skype_cco;
		
		$hel_pk_seq_cco  	= $this->input->post('hel_pk_seq_cco');
		$hel_seqcon_cco  	= $this->input->post('hel_seqcon_cco');
		$hel_tipo_cco	  	= $this->input->post('hel_tipo_cco');
		$hel_telefone_cco  	= $this->input->post('hel_telefone_cco');
		$hel_ramal_cco  	= $this->input->post('hel_ramal_cco');
		$hel_whatsapp_cco  	= $this->input->post('hel_whatsapp_cco') == 1 ? 1 : 0;
		$hel_skype_cco  	= $this->input->post('hel_skype_cco');
		
		$hel_telefone_cco 	= str_replace("(", null, $hel_telefone_cco);
		$hel_telefone_cco 	= str_replace(")", null, $hel_telefone_cco);
		$hel_telefone_cco 	= str_replace("-", null, $hel_telefone_cco);
		
		
		if ($this->testarDados()) {
			$dados_adicionais = array(
				"hel_seqcon_cco"   	=> $hel_seqcon_cco,
				"hel_tipo_cco"   	=> $hel_tipo_cco,
				"hel_telefone_cco"  => $hel_telefone_cco,
				"hel_ramal_cco"	   	=> $hel_ramal_cco,
				"hel_whatsapp_cco"	=> $hel_whatsapp_cco,
				"hel_skype_cco"	   	=> $hel_skype_cco
			);
	
			if (!$hel_pk_seq_cco) {
				$hel_pk_seq_cco = $this->ContatosContatoModel->insert($dados_adicionais);
			} else {
				$hel_pk_seq_cco = $this->ContatosContatoModel->update($dados_adicionais, $hel_pk_seq_cco);
			}
	
			if (is_numeric($hel_pk_seq_cco)) {
				$this->session->set_flashdata('sucesso', 'Dado adicional salvo com sucesso.');
				redirect('contatos_contato/index/'.base64_encode($hel_seqcon_cco));
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_cco);
				redirect('contatos_contato/index/'.base64_encode($hel_seqcon_cco));
			}
		} else {
			if (!$hel_pk_seq_cco) {
				redirect('contatos_contato/novo/'.base64_encode($hel_seqcon_cco));
			} else {
				redirect('contatos_contato/editar/'.base64_encode($hel_pk_seq_cco).'/'.base64_encode($hel_seqcon_cco));	
			}
		}
	}
	
	public function apagar($hel_pk_seq_cco, $hel_seqcon_cco) {
		if ($this->testarApagar(base64_decode($hel_pk_seq_cco))) {
			$res = $this->ContatosContatoModel->delete(base64_decode($hel_pk_seq_cco));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Dado adicional apagado com sucesso.');
			}
		}
			redirect('contatos_contato/index/'.$hel_seqcon_cco);
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
					"hel_tipo_cco"		  		=> $this->carregarTelefoneCelular($registro->hel_tipo_cco),
					"hel_telefone_cco"			=> $registro->hel_telefone_cco,
					"hel_whatsapp_cco"			=> $registro->hel_whatsapp_cco == 1 ? 'Sim' : 'Não',
					"EDITAR_CONTATOS_CONTATO"	=> site_url('contatos_contato/editar/'.base64_encode($registro->hel_pk_seq_cco).'/'.base64_encode($registro->hel_seqcon_cco)),
					"APAGAR_CONTATOS_CONTATO"	=> "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_cco)."','".base64_encode($dados['hel_seqcon_cco'])."')"
			);
		}
	}
		
	private function carregarContatosContato($hel_pk_seq_cco, &$dados) {
		$resultado = $this->ContatosContatoModel->get($hel_pk_seq_cco);
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
		
		$dados['hel_maskphone_cco'] 	    = $dados['hel_tipo_cco'] == 0 ? 'mask-phone' : 'mask-cel';
		$dados['hel_lbtelefone_cco'] 	    = $this->carregarTelefoneCelular($dados['hel_tipo_cco']);
		$dados['hel_checktelefone_cco']	    = $dados['hel_tipo_cco'] == 0 ? 'checked' :'';
		$dados['hel_checkcelular_cco']	    = $dados['hel_tipo_cco'] == 1 ? 'checked' :'';
		$dados['hel_checkedwhatsapp_cco']  	= $dados['hel_whatsapp_cco'] == 1 ? 'checked' : '';
		$dados['hel_disabledramal_cco']  	= $dados['hel_tipo_cco'] == 1 ? 'disabled' : '';
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
		global $hel_skype_cco;
		
		$erros    = FALSE;
		$mensagem = null;
		
		$hel_skype_cco = trim($hel_skype_cco);
				
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
		
		if (($hel_tipo_cco == 1) and (!empty($hel_ramal_cco)) ){
			$erros    = TRUE;
			$mensagem .= "- Tipo ".$this->carregarTelefoneCelular($hel_tipo_cco).", não pode informar o ramal.\n";
			$this->session->set_flashdata('ERRO_HEL_TELEFONE_CCO', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_RAMAL_CCO', 'has-error');
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
			$this->session->set_flashdata('hel_skype_cco', $hel_skype_cco);
		}
		
		return !$erros;
	}


	private function testarApagar($hel_pk_seq_asu) {
		$erros    = FALSE;
		$mensagem = null;			
			
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
		$ERRO_HEL_RAMAL_CCO   	 = $this->session->flashdata('ERRO_HEL_RAMAL_CCO');
		
		$hel_seqcon_cco			= $this->session->flashdata('hel_seqcon_cco');
		$hel_tipo_cco			= $this->session->flashdata('hel_tipo_cco');
		$hel_telefone_cco		= $this->session->flashdata('hel_telefone_cco');
		$hel_ramal_cco			= $this->session->flashdata('hel_ramal_cco');
		$hel_skype_cco			= $this->session->flashdata('hel_skype_cco');
		$hel_whatsapp_cco		= $this->session->flashdata('hel_whatsapp_cco');
	
		if ($ERRO_HEL_CCO) {
			$dados['hel_seqcon_cco']     		= $hel_seqcon_cco;
			$dados['hel_tipo_cco']       		= $hel_tipo_cco;
			$dados['hel_telefone_cco']	 		= $hel_telefone_cco;
			$dados['hel_ramal_cco']		 		= $hel_ramal_cco;
			$dados['hel_skype_cco']	 			= $hel_skype_cco;
			$dados['hel_whatsapp_cco']	 		= $hel_whatsapp_cco;
			$dados['hel_lbtelefone_cco'] 		= $hel_tipo_cco == 0 ? 'Telefone' : 'Celular';
			$dados['hel_checktelefone_cco'] 	= $hel_tipo_cco == 0 ? 'checked' : '';
			$dados['hel_checkcelular_cco']  	= $hel_tipo_cco == 1 ? 'checked' : '';
			$dados['hel_checkedwhatsapp_cco']  	= $hel_whatsapp_cco == 1 ? 'checked' : '';
			$dados['hel_disabledramal_cco']  	= $hel_tipo_cco == 1 ? 'disabled' : '';
			
			$dados['ERRO_HEL_TIPO_CCO']      	= $ERRO_HEL_TIPO_CCO;
			$dados['ERRO_HEL_TELEFONE_CCO']  	= $ERRO_HEL_TELEFONE_CCO;
			$dados['ERRO_HEL_RAMAL_CCO']  		= $ERRO_HEL_RAMAL_CCO;
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
