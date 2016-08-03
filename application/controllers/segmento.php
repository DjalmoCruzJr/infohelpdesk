<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Segmento extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Segmento_Model', 'SegmentoModel');
		$this->load->model('Empresa_Model', 'EmpresaModel');		
				
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	
	public function index() {
		$dados = array();
		$dados['NOVO_SEGMENTO'] = site_url('segmento/novo');
		
		$dados['BLC_DADOS']   = array();
		
		$this->carregarDados($dados);				
		
		$this->parser->parse('segmento_consulta', $dados);		
	}
	
	public function novo() {
			
		$dados = array();
		$dados['hel_pk_seq_seg'] = 0;		
		$dados['hel_desc_seg'] 	 = '';
		
		$dados['ACAO'] = 'Novo';
		
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('segmento_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_seg) {		
		$hel_pk_seq_seg = base64_decode($hel_pk_seq_seg);
		$dados = array();
		
		$this->carregarSegmento($hel_pk_seq_seg, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->parser->parse('segmento_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_seg;
		global $hel_desc_seg;

		$hel_pk_seq_seg = $this->input->post('hel_pk_seq_seg');
		$hel_desc_seg	= $this->input->post('hel_desc_seg');
		
		if ($this->testarDados()) {
			$segmento = array(
				"hel_desc_seg"   => $hel_desc_seg
			);
			
			if (!$hel_pk_seq_seg) {	
				$hel_pk_seq_seg = $this->SegmentoModel->insert($segmento);
			} else {
				$hel_pk_seq_seg = $this->SegmentoModel->update($segmento, $hel_pk_seq_seg);
			}

			if (is_numeric($hel_pk_seq_seg)) {
				$this->session->set_flashdata('sucesso', 'Segmento salva com sucesso.');
				redirect('segmento');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_seg);	
				redirect('segmento');
			}
		} else {
			if (!$hel_pk_seq_seg) {
				redirect('segmento/novo/');
			} else {
				redirect('segmento/editar/'.base64_encode($hel_pk_seq_seg));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_seg) {		
		if ($this->testarApagar(base64_decode($hel_pk_seq_seg))) {
			$res = $this->SegmentoModel->delete(base64_decode($hel_pk_seq_seg));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Segmento apagado com sucesso.');
			} 
		}				
		redirect('segmento');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_SEGMENTO']  = site_url('segmento');
		$dados['ACAO_FORM']          = site_url('segmento/salvar');
	}	
	
	private function carregarDados(&$dados) {
		$resultado = $this->SegmentoModel->getSegmento();
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_desc_seg" 	   => $registro->hel_desc_seg,
				"EDITAR_SEGMENTO"  => site_url('segmento/editar/'.base64_encode($registro->hel_pk_seq_seg)),
				"APAGAR_SEGMENTO"  => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_seg)."')"
			);
		}
	}
	
	private function carregarSegmento($hel_pk_seq_seg, &$dados) {
		$resultado = $this->SegmentoModel->get($hel_pk_seq_seg);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}	
	}
	
	private function carregarTipoContatoRelatorio(&$dados) {
		$resultado = $this->TipoContatoModel->getTipoContato();
	
		foreach ($resultado as $registro) {
			$dados['BLC_TIPO_CONTATO_RELATORIO'][] = array(
					"hel_pk_seq_tco"     => $registro->hel_pk_seq_tco,
					"hel_desc_tco"       => $registro->hel_desc_tco,
					"dis_hel_tco"        => ''
			);
		}
		
		!$resultado ? $dados['BLC_TIPO_CONTATO_RELATORIO'][] = array("hel_desc_tco" => 'Não existe nenhuma Tipo de Contato cadastrado',
				"dis_hel_tco"  => 'disabled') :'';
	}
	
	
	private function carregarTipoContato(&$dados) {
		$resultado = $this->TipoContatoModel->getTipoContato();
		
		foreach ($resultado as $registro) {
			$dados['BLC_TIPO_CONTATO'][] = array(
					"hel_pk_seq_tco"     => $registro->hel_pk_seq_tco,
					"hel_desc_tco"       => $registro->hel_desc_tco,
					"sel_hel_seqtco_con" => ($dados['hel_seqtco_con'] == $registro->hel_pk_seq_tco)?'selected':''
			);
		}
	
		!$resultado ? $dados['BLC_CIDADE'][] = array("hel_desc_tco" => 'Não existe nenhuma tipo de contato cadastrado') :'';
	}
	
	
	private function testarDados() {
		global $hel_pk_seq_seg;
		global $hel_desc_seg;

		$erros    = FALSE;
		$mensagem = null;

		$hel_desc_seg = trim($hel_desc_seg);

		if (empty($hel_desc_seg)) {
			$erros    = TRUE;
			$mensagem .= "- Descrição não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_DESC_SEG', 'has-error');
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_SEG', TRUE);				
			$this->session->set_flashdata('hel_desc_seg', $hel_desc_seg);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_seg) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($this->EmpresaModel->getEmpresaSegmento($hel_pk_seq_seg)) {
			$erros    = TRUE;
			$mensagem .= "- Segmento cadastro para alguma empresa.\n";
		}
	
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_SEG   	= $this->session->flashdata('ERRO_HEL_SEG');
		$ERRO_HEL_DESC_SEG	= $this->session->flashdata('ERRO_HEL_DESC_SEG');
		

		$hel_desc_seg     	= $this->session->flashdata('hel_desc_seg');
		
		if ($ERRO_HEL_SEG) {
			$dados['hel_desc_seg']     	= $hel_desc_seg;
			
			$dados['ERRO_HEL_DESC_SEG'] = $ERRO_HEL_DESC_SEG;
		}
	}
	
	private function gerarRelatorio(){
		global $consulta;
		$result = $this->db->query($consulta);
		return $result->result();
	}
	
	public function relatorio($order_by, $filtro_tipo_contato, $hel_ativo_con){
		$order_by     = str_replace("%20", " ", $order_by);
		$clasulaWhere = "";
		$whereAnd     = " WHERE ";
	
		if ($filtro_tipo_contato != 0 ){
			$clasulaWhere = $clasulaWhere.$whereAnd.' hel_pk_seq_tco IN ('.$filtro_tipo_contato.') ';
			$whereAnd     = " AND ";
		}
	
		switch ($hel_ativo_con){
			case 0 : $clasulaWhere = $clasulaWhere.$whereAnd.' hel_ativo_con = '.$hel_ativo_con;
					 $whereAnd = " AND ";
					 break;
			case 1 : $clasulaWhere = $clasulaWhere.$whereAnd.' hel_ativo_con = '.$hel_ativo_con;
					 $whereAnd = " AND ";
					 break;
		}
	
		global $consulta;
		$consulta = " SELECT hel_pk_seq_con,
							 hel_pk_seq_tco,
						     hel_nome_con,
						     hel_login_con,
						     hel_desc_tco,
						     CASE hel_ativo_con WHEN 1 THEN 'Ativo'
							 else 'Inativo'
							 END AS hel_ativo_con
						FROM heltbcon
						LEFT JOIN heltbtco ON hel_pk_seq_tco = hel_seqtco_con ".$clasulaWhere.$order_by;
		
		if ($this->gerarRelatorio()) {
			$this->jasper->gerar_relatorio('assets/relatorios/relatorio_contato.jrxml', $consulta);
		} else {
			$mensagem = "- Nenhuma contato foi encontrada.\n";
			$this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			redirect('erro_relatorio');
		}
	}
	
}
