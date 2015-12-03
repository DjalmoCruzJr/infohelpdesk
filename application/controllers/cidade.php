<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cidade extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Cidade_Model', 'CidadeModel');
		$this->load->model('Empresa_Model', 'EmpresaModel');
	}

	
	public function index() {
		$dados = array();
		
		$dados['NOVA_CIDADE']    = site_url('cidade/novo');
		
		$dados['BLC_DADOS']    = array();
		$dados['BLC_UF']       = array();
		
		$this->carregarDados($dados);
		
		$this->parser->parse('cidade_consulta', $dados);
	}
	
	public function novo() {		
		$dados = array();
		$dados['hel_pk_seq_cid']  = 0;		
		$dados['hel_nome_cid']    = '';
		$dados['hel_uf_cid']      = '';
		$dados['hel_codmun_cid']  = '';
				
		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
		
		$this->carregarUf($dados);
		
		$this->parser->parse('cidade_cadastro', $dados);
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
		$dados['CONSULTA_CIDADE']   = site_url('cidade');
		$dados['ACAO_FORM']         = site_url('cidade/salvar');
	}
	
	
	private function carregarDados(&$dados) {
		
		$resultado = $this->CidadeModel->getCidade();
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_nome_cid"       => $registro->hel_nome_cid,							
				"hel_uf_cid"         => $registro->hel_uf_cid,
				"EDITAR_CIDADE"	     => 'cidade/editar/'.base64_encode($registro->hel_pk_seq_cid),	
				"APAGAR_CIDADE" 	 => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_cid)."')"
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
	}
	
	
	private function carregarUf(&$dados) {
		$uf = array("AC","AL","AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO");
		
		$dados['BLC_UF'] = array();
		foreach ($uf as $registro) {
			$dados['BLC_UF'][] = array('uf' => $registro,
					                   'selected_uf' => ($dados['hel_uf_cid']==$registro)?'selected':'');
		}
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
			$this->session->set_flashdata('ERRO_GAB_NOME_HEL', 'has-error');
		}

		if (empty($hel_uf_cid)) {
			$erros    = TRUE;
			$mensagem .= "- UF não foi selecionada.\n";
			$this->session->set_flashdata('ERRO_GAB_UF_HEL', 'has-error');
		}

// 		if (!empty($gab_nome_cid) and !empty($gab_uf_cid) and $this->CidadeModel->getCidadeCadastro($gab_pk_seq_cid, $gab_nome_cid, $gab_uf_cid)) {
// 			$erros    = TRUE;
// 			$mensagem .= "- Já existi uma cidade cadastrada.\n";
// 			$this->session->set_flashdata('ERRO_GAB_NOME_CID', 'has-error');
// 			$this->session->set_flashdata('ERRO_GAB_UF_CID', 'has-error');
// 		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_GAB_HEL', TRUE);				
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
		$ERRO_GAB_HEL   	   = $this->session->flashdata('ERRO_GAB_HEL');
		$ERRO_GAB_NOME_HEL     = $this->session->flashdata('ERRO_GAB_NOME_HEL');
		$ERRO_GAB_UF_HEL       = $this->session->flashdata('ERRO_GAB_UF_HEL');

		$hel_nome_cid     	   = $this->session->flashdata('hel_nome_cid');
		$hel_uf_cid       	   = $this->session->flashdata('hel_uf_cid');
		$hel_codmun_cid        = $this->session->flashdata('hel_codmun_cid');

		if ($ERRO_GAB_HEL) {
			$dados['hel_nome_cid']       = $hel_nome_cid;
			$dados['hel_uf_cid']         = $hel_uf_cid;
			$dados['hel_codmun_cid']     = $hel_codmun_cid;

			$dados['ERRO_GAB_NOME_HEL']  = $ERRO_GAB_NOME_HEL;
			$dados['ERRO_GAB_UF_HEL']    = $ERRO_GAB_UF_HEL;
			
		}
	}
	
	private function gerarRelatorio(){
		global $consulta;
		$result = $this->db->query($consulta);
		return $result->result();
	}

	public function relatorio($order_by, $filtro_cidade, $filtro_bairro, $filtro_servico, $filtro_evento, $imprimi_bairro, $imprimi_servico, $imprimi_evento){
		$clasulaWhere 					= "";
		$whereAnd     					= " WHERE ";
		$cidade       					= explode(",", $filtro_cidade);
		$bairro       					= explode(",", $filtro_bairro);
		$servico      					= explode(",", $filtro_servico);
		$evneto       					= explode(",", $filtro_evento);
		$join         					= "";
		$groupBy						= "";
		$order_by     					= str_replace("%20", " ", $order_by);
		$filtros      					= array();
		$arquivo						= '';
		$select_evento    				= '';
		$select_servico    				= '';
		$select_bairro    				= '';
		$select_bairro_servico			= '';
		$select_bairro_servico_evento	= '';
		$select_bairro_evento			= '';
		$select_bairro_servico			= '';
		
		global $consulta;
		$consulta = " SELECT * FROM gabtbcid ";
		
		if ($imprimi_evento == 1){
			
			$select_evento = ' SELECT gab_pk_seq_eve,
									  gab_pk_seq_evc,
									  gab_desc_eve,
								      gab_pk_seq_eve,
								      gab_desc_evc,
								      CASE gab_dia_evc when 1 then "Domingo"
								       				   when 2 then "Segunda"
								       				   when 3 then "Terça"
								       				   when 4 then "Quarta"
								       				   when 5 then "Quinta"
								       				   when 6 then "Sexta"
								       				   when 7 then "Sábado"
								       else ""
								       END AS Dia_Semana,
								       CASE gab_datacomemorativa_evc
								       WHEN 0000-00-00 THEN ""
								       else gab_datacomemorativa_evc END AS DATA_COMEMORATIVA
								FROM gabtbevc
								LEFT OUTER JOIN gabtbeve on gab_pk_seq_eve = gab_seqeve_evc
								WHERE gab_seqcid_evc = $P{gab_seqcid_evc} ';
		
			if ($filtro_evento != 0 ){
				$select_evento .= ' AND gab_pk_seq_eve IN ('.$filtro_evento.')';
			}			
		}
		
		if ($imprimi_servico == 1){
				
			$select_servico = ' SELECT gab_pk_seq_ser,
									   gab_pk_seq_sec,
					                   gab_desc_ser,
									   gab_nome_con,
									   CASE gab_tipo_sec when 0 then "Municipal"
													     when 1 then "Estadual"
													     when 2 then "Federal"
													     when 3 then "Particular"
									   END AS TIPO_SERVICO
								FROM gabtbsec
								LEFT OUTER JOIN gabtbser on gab_seqser_sec = gab_pk_seq_ser
								LEFT OUTER JOIN gabtbcon on gab_seqcon_sec = gab_pk_seq_con
								WHERE gab_seqcid_sec = $P{gab_seqcid_sec} ';
		
			if ($filtro_servico != 0 ) {
				$select_servico .= ' AND gab_pk_seq_ser IN ('.$filtro_servico.')';
			}
		}
		
		if ($imprimi_bairro == 1 and $imprimi_evento == 0 and $imprimi_servico == 0 ){
		
			$select_bairro = ' SELECT gab_pk_seq_bai,
								      gab_desc_bai,
								      case gab_regiao_bai when 0 then "Centro"
								                          when 1 then "Norte"
								                          when 2 then "Sul"
								                          when 3 then "Leste"
								                          when 4 then "Oeste"
								                          when 5 then "Distrito"
								                          when 6 then "Rural"
								                          when 7 then "Ribeirinha"
								       else ""
								       end regiao
								FROM gabtbbai
								WHERE gab_seqcid_bai = $P{gab_seqcid_bai} ';
		
			if ($filtro_bairro != 0 ) {
				$select_bairro .= ' AND gab_pk_seq_bai IN ('.$filtro_bairro.')';
			}
			
		}
		
		if ($imprimi_bairro == 1 and $imprimi_evento == 1 and $imprimi_servico == 1 ){
			
			$select_bairro_servico_evento = ' SELECT gab_pk_seq_bai,
											         gab_desc_bai,
													 case gab_regiao_bai when 0 then "Centro"
																		 when 1 then "Norte"
																		 when 2 then "Sul"
																         when 3 then "Leste"
																         when 4 then "Oeste"
																         when 5 then "Distrito"
																         when 6 then "Rural"
																         when 7 then "Ribeirinha"
													 else ""
													 end regiao,
													 gab_desc_eve,
													 gab_pk_seq_evb,
													 case gab_dia_evb when 1 then "Domingo"
																	  when 2 then "Segunda"
																      when 3 then "Terça"
																      when 4 then "Quarta"
														              when 5 then "Quinta"
														              when 6 then "Sexta"
														              when 7 then "Sábabdo"
													else ""
													end dia_evento,
													gab_datacomemorativa_evb,
													gab_pk_seq_seb,
													gab_desc_evb,
													gab_desc_ser,
													case gab_tipo_seb when 0 then "Municipal"
																      when 1 then "Estadual"
																	  when 2 then "Federal"
																      when 3 then "Particular"
													else ""
													end tipo_servico,
													gab_nome_con
											FROM gabtbbai
											LEFT JOIN gabtbseb ON gab_seqbai_seb = gab_pk_seq_bai
											LEFT JOIN gabtbser ON gab_pk_seq_ser = gab_seqser_seb
											LEFT JOIN gabtbevb ON gab_seqbai_evb = gab_pk_seq_bai
											LEFT JOIN gabtbeve ON gab_pk_seq_eve = gab_seqeve_evb
											LEFT JOIN gabtbcon ON gab_pk_seq_con = gab_seqcon_seb
											WHERE gab_seqcid_bai = $P{cidade_evento_servico} ';
			
			if ($filtro_bairro != 0 ){
				$select_bairro_servico_evento .= ' AND gab_pk_seq_bai IN ('.$filtro_bairro.')';
			}
			
			if ($filtro_evento != 0 ){
				$select_bairro_servico_evento .= ' AND gab_pk_seq_eve IN ('.$filtro_evento.')';
			}
			
			if ($filtro_servico != 0 ){
				$select_bairro_servico_evento .= ' AND gab_pk_seq_ser IN ('.$filtro_servico.')';
			}
			
		} else if ($imprimi_bairro == 1 and $imprimi_evento == 1 and $imprimi_servico == 0){
			
			$select_bairro_evento = ' SELECT gab_pk_seq_bai,
										     gab_desc_bai,
										     case gab_regiao_bai when 0 then "Centro"
																 when 1 then "Norte"
																 when 2 then "Sul"
																 when 3 then "Leste"
																 when 4 then "Oeste"
																 when 5 then "Distrito"
																 when 6 then "Rural"
																 when 7 then "Ribeirinha"
										       else ""
										       end regiao,
										       gab_desc_eve,
										       gab_pk_seq_evb,
										       case gab_dia_evb when 1 then "Domingo"
																when 2 then "Segunda"
																when 3 then "Terça"
																when 4 then "Quarta"
																when 5 then "Quinta"
																when 6 then "Sexta"
																when 7 then "Sábabdo"
										      else ""
										      end dia_evento,
										      gab_datacomemorativa_evb,
										      gab_desc_evb
										FROM gabtbbai
										LEFT JOIN gabtbevb ON gab_seqbai_evb = gab_pk_seq_bai
										LEFT JOIN gabtbeve ON gab_pk_seq_eve = gab_seqeve_evb
										WHERE gab_seqcid_bai = $P{gab_seqcid_evb} ';
				
			if ($filtro_bairro != 0 ){
				$select_bairro_evento .= ' AND gab_pk_seq_bai IN ('.$filtro_bairro.')';
			}
				
			if ($filtro_evento != 0 ){
				$select_bairro_evento .= ' AND gab_pk_seq_eve IN ('.$filtro_evento.')';
			}
			
		} else if ($imprimi_bairro == 1 and $imprimi_servico == 1 and $imprimi_evento == 0){
			
			$select_bairro_servico = ' SELECT gab_pk_seq_bai,
									          gab_desc_bai,
									          case gab_regiao_bai when 0 then "Centro"
																  when 1 then "Norte"
											      				  when 2 then "Sul"
											      				  when 3 then "Leste"
											      				  when 4 then "Oeste" 
											      				  when 5 then "Distrito"
											      				  when 6 then "Rural"
											      				  when 7 then "Ribeirinha"
										      else ""
										      end regiao,
										      gab_pk_seq_seb,
										      gab_desc_ser,
									      	  case gab_tipo_seb when 0 then "Municipal"
											   					when 1 then "Estadual"
											   					when 2 then "Federal"
											   					when 3 then "Particular"
									          else ""
									          end tipo_servico,
									          gab_nome_con
									FROM gabtbbai
									LEFT JOIN gabtbseb ON gab_seqbai_seb = gab_pk_seq_bai
									LEFT JOIN gabtbser ON gab_pk_seq_ser = gab_seqser_seb
									LEFT JOIN gabtbcon ON gab_pk_seq_con = gab_seqcon_seb
									WHERE gab_seqcid_bai = $P{gab_seqbai_seb} ';
			
			if ($filtro_bairro != 0 ){
				$select_bairro_servico .= ' AND gab_pk_seq_bai IN ('.$filtro_bairro.')';
			}
			
			if ($filtro_servico != 0 ){
				$select_bairro_servico .= ' AND gab_pk_seq_ser IN ('.$filtro_servico.')';
			}
			
		}

		
		$consulta_sub = array (
				"gab_seqcid_sec" 		=> $select_servico,
				"gab_seqcid_evc" 		=> $select_evento,
				"gab_seqcid_bai" 	    => $select_bairro,
				"cidade_evento_servico" => $select_bairro_servico_evento,
				"gab_seqcid_evb"		=> $select_bairro_evento,
				"gab_seqbai_seb"		=> $select_bairro_servico
		);
		
		$clasulaWhere = $this->montar_where($filtro_cidade, $filtro_bairro, $filtro_servico, $filtro_evento, $imprimi_bairro, $imprimi_servico, $imprimi_evento);
		
		$imprimi_bairro == 0 and $imprimi_evento != 1 and $imprimi_servico != 1   ? array_push($filtros,"gab_seqcid_bai") : "";		
		$imprimi_servico == 0 													  ? array_push($filtros,"gab_seqcid_sec") : "";
		$imprimi_evento	 == 0 													  ? array_push($filtros,"gab_seqcid_evc") : "";
		
		$consulta .= $clasulaWhere.$order_by;
		
		if ($this->gerarRelatorio()) {
			$this->jasper->gerar_relatorio('assets/relatorios/relatorio_cidade.jrxml', $consulta, $filtros, $consulta_sub);
		} else {
			$mensagem = "- Nenhuma cidade foi encontrada.\n";
			$this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			redirect('erro_relatorio');
		}
	}
	
	private function montar_where($filtro_cidade, $filtro_bairro, $filtro_servico, $filtro_evento, $imprimi_bairro, $imprimi_servico, $imprimi_evento){
		$clasulaWhere = " ";
		$whereAnd     = " WHERE ";
		$groupBy      = " ";
		
		if ($filtro_cidade != 0 ){
			$clasulaWhere .= $whereAnd.' gab_pk_seq_cid IN ('.$filtro_cidade.') ';
			$whereAnd = " AND ";
		}
		
		$groupBy .= ($imprimi_bairro == 1 and $filtro_bairro != 0 ) ? " GROUP BY gab_pk_seq_cid " : " ";
				
		return $clasulaWhere.$groupBy;
		
	}
	
}