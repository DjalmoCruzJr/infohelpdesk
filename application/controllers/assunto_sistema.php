<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assunto_Sistema extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->layout = LAYOUT_DASHBOARD;

		$this->load->model('Sistema_Model', 'SistemaModel');
		$this->load->model('Assunto_Sistema_Model', 'AssuntoSistemaModel');
		
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	public function index($hel_seqsis_asu) {
		$dados = array();
		
		$dados['NOVO_ASSUNTO_SISTEMA']    = site_url('assunto_sistema/novo/'.$hel_seqsis_asu);
		$dados['URL_APAGAR']    		  = site_url('assunto_sistema/apagar');
		$dados['VOLTAR_SISTEMA']   		  = site_url('sistema');
		$dados['BLC_DADOS']   		   	  = array();
		$dados['hel_seqsis_asu']		  = base64_decode($hel_seqsis_asu);
		
		$this->carregarSistema($dados);

		$this->carregarDados($dados);
		
		$this->parser->parse('assunto_sistema_consulta', $dados);
	}
	
	public function novo($hel_seqsis_asu) {		
		$dados = array();
		$dados['hel_pk_seq_asu']  = 0;
		$dados['hel_seqsis_asu']  = base64_decode($hel_seqsis_asu);
		$dados['hel_titulo_asu']  = '';
		$dados['hel_link_asu']    = '';

		$dados['ACAO'] = 'Novo';

		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);

		$this->parser->parse('assunto_sistema_cadastro', $dados);
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_ASSUNTO_SISTEMA']	= site_url('assunto_sistema/index/'.base64_encode($dados['hel_seqsis_asu']));
		$dados['ACAO_FORM']            		= site_url('assunto_sistema/salvar');		
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
		global $hel_pk_seq_asu;
		global $hel_seqsis_asu;
		global $hel_titulo_asu;
		global $hel_link_asu;
		
		$hel_pk_seq_asu  = $this->input->post('hel_pk_seq_asu');
		$hel_seqsis_asu  = $this->input->post('hel_seqsis_asu');
		$hel_titulo_asu  = $this->input->post('hel_titulo_asu');	

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
				redirect('assunto_sistema/novo/'.base64_encode($hel_seqsis_asu));
			} else {
				redirect('assunto_sistema/editar/'.base64_encode($hel_pk_seq_asu).'/'.base64_encode($hel_seqsis_asu));
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
	
	private function carregarSistema(&$dados) {
	
		$resultado = $this->SistemaModel->get($dados['hel_seqsis_asu']);
	
		if ($resultado) {
			$dados['NOME_SISTEMA'] = $resultado->hel_desc_sis;
		}
	}
	
	private function carregarDados(&$dados) {

		$resultado = $this->AssuntoSistemaModel->getAssunto($dados['hel_seqsis_asu']);

		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_codigo_sis"			=> $registro->hel_codigo_sis,
				"hel_desc_sis"				=> $registro->hel_desc_sis,
				"hel_titulo_asu"			=> $registro->hel_titulo_asu,
				"hel_link_asu"				=> base_url()."uploads/assunto_sistema/".$registro->hel_link_asu,
				"EDITAR_ASSUNTO_SISTEMA"	=> site_url('assunto_sistema/editar/'.base64_encode($registro->hel_pk_seq_asu).'/'.base64_encode($registro->hel_seqsis_asu)),
				"APAGAR_ASSUNTO_SISTEMA"	=> "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_asu)."','".base64_encode($dados['hel_seqsis_asu'])."')"
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
	

	private function testarDados() {
		global $hel_pk_seq_asu;
		global $hel_seqsis_asu;
		global $hel_titulo_asu;
		global $hel_link_asu;

		$erros    = FALSE;
		$mensagem = null;
		
		$config['upload_path'] 	 = "./uploads/assunto_sistema/";
		$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
		$config['encrypt_name']  = TRUE;
		
		$this->upload->initialize($config);

		$hel_titulo_asu = trim($hel_titulo_asu);
		
		if (!empty($hel_pk_seq_asu)){
			$resultado = $this->AssuntoSistemaModel->get($hel_pk_seq_asu);
			
			if ($resultado){
				$hel_link_asu = $resultado->hel_link_asu;
			} else {
				show_error('Não foram encontrados dados do arquivo anterior.', 500, 'Ops, erro encontrado');
			}	
		}
		
		
		if (empty($hel_titulo_asu)) {
			$erros    = TRUE;
			$mensagem .= "- Titulo não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_TITULO_ASU', 'has-error');
		}
		
		if (empty($_FILES['hel_link_asu']['size'])){
			$erros    = TRUE;
			$mensagem .= "- Selecione um arquivo para upload.\n";
		}
		
		if (!is_dir($config['upload_path'])){
			$erros    = TRUE;
			$mensagem .= " - Não é um diretório válido/n";
		}
		
		if (!is_writable($config['upload_path'])){
			$erros    = TRUE;
			$mensagem .= " - Não é permitido gravar no diretório/n";
		}
		
		$this->load->library('upload', $config);
		
		if (!empty($hel_pk_seq_asu) AND (!empty($_FILES['hel_link_asu']['size']))){
			if ($resultado){
				$nome_arquivo = $resultado->hel_link_asu;
				$caminho = "./uploads/assunto_sistema/";
				if (file_exists($caminho.$nome_arquivo)){
					unlink($caminho.$nome_arquivo);
				}
			}else {
				show_error('Não foram encontrados dados do arquivo anterior.', 500, 'Ops, erro encontrado');
			}	
		}
		
		if (!empty($_FILES['hel_link_asu']['size'])){
						
			if ($this->upload->do_upload('hel_link_asu')){
				$info = $this->upload->data();
				$hel_link_asu = trim($info['file_name']);
				if (empty($hel_link_asu)) {
					$erros    = TRUE;
					$mensagem .= "- Erro ao gravar o nome do arquivo.\n";
				}
			}else {
				$erros    = TRUE;
				$mensagem = $this->upload->display_errors();
			}
				
		}
		

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar, corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_ASU', TRUE);
			$this->session->set_flashdata('hel_seqsis_asu', $hel_seqsis_asu);
			$this->session->set_flashdata('hel_titulo_asu', $hel_titulo_asu);

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
			}else {
				$erros = TRUE;
				$mensagem = " - Erro ao verificar se o arquivo existi\n";
			} 
		}else {
			show_error('Não foram encontrados dados do arquivo.', 500, 'Ops, erro encontrado');
		}
			
	
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_ASU   	   = $this->session->flashdata('ERRO_HEL_ASU');
		$ERRO_HEL_SEQSIS_ASU   = $this->session->flashdata('ERRO_HEL_SEQSIS_ASU');
		$ERRO_HEL_TITULO_ASU   = $this->session->flashdata('ERRO_HEL_TITULO_ASU');

		$hel_seqsis_asu			= $this->session->flashdata('hel_seqsis_asu');
		$hel_titulo_asu			= $this->session->flashdata('hel_titulo_asu');
		$hel_link_asu			= $this->session->flashdata('hel_link_asu');

		if ($ERRO_HEL_ASU) {
			$dados['hel_seqsis_asu']       = $hel_seqsis_asu;
			$dados['hel_titulo_asu']       = $hel_titulo_asu;
			$dados['hel_link_asu']		   = $hel_link_asu;
			
			$dados['ERRO_HEL_SEQSIS_ASU']  = $ERRO_HEL_SEQSIS_ASU;
			$dados['ERRO_HEL_TITULO_ASU']  = $ERRO_HEL_TITULO_ASU;			
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