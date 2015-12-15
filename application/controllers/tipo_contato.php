<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipo_Contato extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Tipo_Contato_Model', 'Tipo_ContatoModel');
		$this->load->model('Contato_Model', 'ContatoModel');
	}

	
	public function index() {
		$dados = array();
		
		$dados['NOVO_TIPO_CONTATO']    = site_url('tipo_contato/novo');
		
		$dados['BLC_DADOS']   		   = array();

		$this->carregarDados($dados);
		
		$this->parser->parse('tipo_contato_consulta', $dados);
	}
	
	public function novo() {		
		$dados = array();
		$dados['hel_pk_seq_tco']  = 0;
		$dados['hel_desc_tco']    = '';
		$dados['hel_tipo_tco']    = 0;

		$dados['ACAO'] = 'Novo';

		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);

		$this->parser->parse('tipo_contato_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_tco) {
		$hel_pk_seq_tco = base64_decode($hel_pk_seq_tco);
		$dados = array();

		$this->carregarTipo_Contato($hel_pk_seq_tco, $dados);

		$this->carregarDadosFlash($dados);

		$dados['ACAO'] = 'Editar';

		$this->setarURL($dados);


		
		$this->parser->parse('tipo_contato_cadastro', $dados);
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
	
	public function apagar($hel_pk_seq_tco) {
		
		if ($this->testarApagar(base64_decode($hel_pk_seq_tco))) {
			$res = $this->Tipo_ContatoModel->delete(base64_decode($hel_pk_seq_tco));
				if ($res) {
					$this->session->set_flashdata('sucesso', 'Tipo de Contato apagado com sucesso.');
				}
		}				
		redirect('tipo_contato');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_TIPO_CONTATO']= site_url('tipo_contato');
		$dados['ACAO_FORM']            = site_url('tipo_contato/salvar');
	}
	
	
	private function carregarDados(&$dados) {
		
		$resultado = $this->Tipo_ContatoModel->getTipoContato();
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_desc_tco"           => $registro->hel_desc_tco,
				"hel_tipo_tco"           => $this->carregarTipoContato($registro->hel_tipo_tco),
				"EDITAR_TIPO_CONTATO"	 => 'tipo_contato/editar/'.base64_encode($registro->hel_pk_seq_tco),
				"APAGAR_TIPO_CONTATO" 	 => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_tco)."')"
			);
		}
	}

	private function carregarTipoContato($hel_tipo_tco){

		$tipo = "";

		if ($hel_tipo_tco == 0){
			$tipo = "Técnico";
		}else if ($hel_tipo_tco == 1){
			$tipo = "Responsável";
		}else if($hel_tipo_tco == 2){
			$tipo = "Outros";
		}
		return $tipo;
	}
	
	private function carregarTipo_Contato($hel_pk_seq_tco, &$dados) {
		$resultado = $this->Tipo_ContatoModel->get($hel_pk_seq_tco);

		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}

		$this->carregar_tipo_contato($dados);
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
	
	private function testarApagar($hel_pk_seq_tco) {
		$erros    = FALSE;
		$mensagem = null;
	
		if ($this->ContatoModel->getContatoCadastrado($hel_pk_seq_tco)) {
			$erros    = TRUE;
			$mensagem .= "- Contato cadastrado.\n";
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}

	private function carregar_tipo_contato(&$dados){

		switch ($dados['hel_tipo_tco']){
			case 0: $dados['hel_checktecnico_tco'] 		= 'checked';
				    break;
			case 1: $dados['hel_checkresponsavel_tco'] 	= 'checked';
				    break;
			case 2: $dados['hel_checkoutro_tco'] 		= 'checked';
				    break;
		}

	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_TCO   	   = $this->session->flashdata('ERRO_HEL_TCO');
		$ERRO_HEL_DESC_TCO     = $this->session->flashdata('ERRO_HEL_DESC_TCO');
		$ERRO_HEL_TIPO_TCO     = $this->session->flashdata('ERRO_HEL_TIPO_TCO');

		$hel_desc_tco     	   = $this->session->flashdata('hel_desc_tco');
		$hel_tipo_tco          = $this->session->flashdata('hel_tipo_tco');

		if ($ERRO_HEL_TCO) {
			$dados['hel_desc_tco']       = $hel_desc_tco;
			$dados['hel_tipo_tco']       = $hel_tipo_tco;
			if ($hel_tipo_tco != '') {
				$this->carregar_tipo_contato($dados);
			}

			$dados['ERRO_HEL_DESC_TCO']  = $ERRO_HEL_DESC_TCO;
			$dados['ERRO_HEL_TIPO_TCO']  = $ERRO_HEL_TIPO_TCO;
			
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