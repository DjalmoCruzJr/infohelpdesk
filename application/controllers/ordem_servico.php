<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordem_Servico extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Contato_Model', 'ContatoModel');
 		$this->load->model('Empresa_Model', 'EmpresaModel');
		$this->load->model('Ordem_Servico_Model', 'OrdemServicoModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
		$this->load->model('Item_Ordem_Servico_Model', 'ItemOrdemServicoModel');
		
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	public function index() {
		$dados = array();
		
		$dados['NOVA_ORDEM_SERVICO']	= site_url('ordem_servico/novo');
		$dados['URL_BUSCAR_CONTATO']   	= site_url('json/json/carregar_contato_relatorio');
		$dados['ACAO_FILTRO']			= site_url('ordem_servico');
		
		
		$dados['BLC_DADOS']  = array();
		$hel_seqemp_filtro  	= $this->input->post('hel_seqemp_filtro');
		$hel_seqcon_filtro		= $this->input->post('hel_seqcon_filtro');
		$hel_datainicial_filtro	= $this->input->post('hel_dateinicialfiltro_ose');
		$hel_datafinal_filtro	= $this->input->post('hel_datafinalfiltro_ose');

		$dados['hel_seqemp_filtro']		 = $hel_seqemp_filtro;
		$dados['hel_seqcon_filtro']		 = $hel_seqcon_filtro;
		$dados['hel_datainicial_filtro'] = trim($hel_datainicial_filtro) != '' ? $this->util->gravar_data_banco($hel_datainicial_filtro) : '';
		$dados['hel_datafinal_filtro']	 = trim($hel_datafinal_filtro) != '' ? $this->util->gravar_data_banco($hel_datafinal_filtro) : '';

		$this->carregarDados($dados);
		$this->carregarEmpresaFiltro($dados);
		$this->carregarTecnicoFiltro($dados);

		$this->carregarTecnicoRelatorio($dados);
		$this->carregarEmpresaRelatorio($dados);
		$this->carregarOrdemServicoRelatorio($dados);
				
		$this->parser->parse('ordem_servico_consulta', $dados);
	}
	
	public function novo() {
		
		$dados = array();
		$dados['hel_pk_seq_ose']  			= 0;
		$dados['hel_datainicial_ose']    	= '';
		$dados['hel_horarioinicial_ose']    = '';
		$dados['hel_datafinal_ose']    		= '';
		$dados['hel_horariofinal_ose']      = '';
		$dados['hel_seqemp_ose']    		= '';
		$dados['hel_seqcon_ose']    		= '';
		$dados['hel_kminicial_ose']    		= '0';
		$dados['hel_kmfinal_ose']    		= '0';
		$dados['hel_observacao_ose']        = '';
				
		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
	
		$this->carregarEmpresa($dados);
		
		$this->parser->parse('ordem_servico_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_ose) {
		
		$hel_pk_seq_ose = base64_decode($hel_pk_seq_ose);
		$dados = array();

		$this->carregarOrdemServico($hel_pk_seq_ose, $dados);

		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarEmpresa($dados);
		
		$this->parser->parse('ordem_servico_cadastro', $dados);
	}
	
	public function salvar() {
		global $hel_pk_seq_ose;
		global $hel_seqemp_ose;
		global $hel_seqcon_ose;
		global $hel_dateinicial_ose;
		global $hel_horarioinicial_ose;
		global $hel_datefinal_ose;
		global $hel_horariofinal_ose;
		global $hel_kminicial_ose;
		global $hel_kmfinal_ose;
		global $hel_observacao_ose;
		global $hel_seqexc_ose;
		global $hel_seqcontec_ose;
		$inserir = FALSE;
		
		$hel_pk_seq_ose  		= $this->input->post('hel_pk_seq_ose');			
		$hel_seqemp_ose    		= $this->input->post('hel_seqemp_ose');
		$hel_seqcon_ose 		= $this->input->post('hel_seqcon_ose');
		$hel_dateinicial_ose 	= $this->input->post('hel_dateinicial_ose');
		$hel_horarioinicial_ose = $this->input->post('hel_horarioinicial_ose');
		$hel_datefinal_ose   	= $this->input->post('hel_datefinal_ose');
		$hel_horariofinal_ose   = $this->input->post('hel_horariofinal_ose');
		$hel_kminicial_ose      = $this->input->post('hel_kminicial_ose');
		$hel_kmfinal_ose        = $this->input->post('hel_kmfinal_ose');
		$hel_observacao_ose     = $this->input->post('hel_observacao_ose');
		$hel_seqcontec_ose		= $this->session->userdata('hel_pk_seq_con');
		
		if ($this->testarDados()) {
			
			$inserir = empty($hel_pk_seq_ose) ? TRUE : FALSE;
			
			$ordem_servico = array(
				"hel_seqexc_ose"           => $hel_seqexc_ose,
				"hel_seqcontec_ose"		   => $hel_seqcontec_ose,
				"hel_datainicial_ose"      => $this->util->gravar_data_banco($hel_dateinicial_ose),
				"hel_horarioinicial_ose"   => $hel_horarioinicial_ose,
				"hel_datafinal_ose"        => $this->util->gravar_data_banco($hel_datefinal_ose),
				"hel_horariofinal_ose"     => $hel_horariofinal_ose,					
				"hel_kminicial_ose"        => $hel_kminicial_ose,
				"hel_kmfinal_ose"  		   => $hel_kmfinal_ose,
				"hel_observacao_ose" 	   => $hel_observacao_ose
			);
			
			if (!$hel_pk_seq_ose) {
				$hel_pk_seq_ose = $this->OrdemServicoModel->insert($ordem_servico);
			} else {
				$hel_pk_seq_ose = $this->OrdemServicoModel->update($ordem_servico, $hel_pk_seq_ose);
			}

			if (is_numeric($hel_pk_seq_ose) and $inserir) {
				$this->session->set_flashdata('sucesso', 'Para continuar, insira os itens');
				redirect('item_ordem_servico/novo/'.base64_encode($hel_pk_seq_ose));
			} else if (is_numeric($hel_pk_seq_ose)) {
				$this->session->set_flashdata('sucesso', 'Ordem de Serviço salvo com sucesso');
				redirect('ordem_servico');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_ose);
				redirect('ordem_servico');
			}
			
		} else {
			if (!$hel_pk_seq_ose) {
				redirect('ordem_servico/novo/');
			} else {
				redirect('ordem_servico/editar/'.base64_encode($hel_pk_seq_ose));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_ose) {		
		if ($this->testarApagar(base64_decode($hel_pk_seq_ose))) {
			$resultado = $this->OrdemServicoModel->delete(base64_decode($hel_pk_seq_ose));
			if ($resultado) {
				$this->session->set_flashdata('sucesso', 'Ordem de Serviço apagada com sucesso.');
			}	
		}				
		redirect('ordem_servico');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_ORDEM_SERVICO'] = site_url('ordem_servico');
		$dados['ACAO_FORM']         	 = site_url('ordem_servico/salvar');
		$dados['URL_BUSCAR_CONTATO']   	 = site_url('json/json/carregar_contato/'.CHAVE_JSON);
	}	

	private function carregarEmpresaFiltro(&$dados) {
	
		$resultado = !$this->util->autorizacao($this->session->userdata('hel_tipo_tco')) ? $this->EmpresaModel->getEmpresa() : $this->EmpresaContatoModel->getEmpresaContatoRelatorio2($this->session->userdata('hel_pk_seq_con'));
	
		foreach ($resultado as $registro) {
			$dados['BLC_EMPRESA_FILTRO'][] = array(
					"hel_pk_seq_emp"     		=> $registro->hel_pk_seq_emp,
					"hel_nomefantasia_emp" 		=> $registro->hel_nomefantasia_emp,
					"sel_hel_seqempfiltro_cha"	=> ($dados['hel_seqemp_filtro'] == $registro->hel_pk_seq_emp)?'selected':''					
			);
		}
	
		!$resultado ? $dados['BLC_EMPRESA_FILTRO'][] = array("hel_nomefantasia_emp" => 'Não existe nenhuma empresa cadastrada') :'';
	}

	private function carregarTecnicoFiltro(&$dados) {

		$resultado = $this->ContatoModel->getContatoTecnico();
	
		foreach ($resultado as $registro) {
			$dados['BLC_TECNICO_FILTRO'][] = array(
					"hel_pk_seq_con"			=> $registro->hel_pk_seq_con,
					"hel_nome_con"				=> $registro->hel_nome_con,
					"sel_hel_seqconfiltro_con"	=> ($dados['hel_seqcon_filtro'] == $registro->hel_pk_seq_con)?'selected':''							
			);
		}
		!$resultado ? $dados['BLC_TECNICO_FILTRO'][] = array("hel_nome_con" => 'Não existe nenhuma técnico cadastrada') :'';
	}
	
	
	private function carregarDados(&$dados) {
						
		$resultado = $this->OrdemServicoModel->getOrdemServico($dados['hel_seqemp_filtro'], $dados['hel_seqcon_filtro'], $dados['hel_datainicial_filtro'], $dados['hel_datafinal_filtro']);	
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_pk_seq_ose" 	 	  => $registro->hel_pk_seq_ose,					
				"hel_nomefantasia_emp" 	  => $registro->hel_nomefantasia_emp,							
				"hel_nome_con"         	  => $registro->hel_nome_con,
				"hel_datainicial_ose" 	  => $this->util->inverteData($registro->hel_datainicial_ose),
				"hel_datafinal_ose" 	  => $this->util->inverteData($registro->hel_datafinal_ose),
				"hel_disabledexcluir_ose" => $this->session->userdata('hel_pk_seq_con') <> $registro->hel_seqcontec_ose ? 'disabled' : '',	
				"ITEM_ORDEM_SERVICO" 	  => site_url('item_ordem_servico/index/'.base64_encode($registro->hel_pk_seq_ose)),
				"EDITAR_ORDEM_SERVICO" 	  => site_url('ordem_servico/editar/'.base64_encode($registro->hel_pk_seq_ose)),
				"APAGAR_ORDEM_SERVICO" 	  => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_ose)."')"
			);
		}
	}
	
	private function carregarOrdemServico($hel_pk_seq_ose, &$dados) {
		$resultado = $this->OrdemServicoModel->get($hel_pk_seq_ose);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
		
		$resultado_empresa = $this->EmpresaContatoModel->get($dados['hel_seqexc_ose']);
		
		if ($resultado_empresa){
			$dados['hel_seqemp_ose'] = $resultado_empresa->hel_seqemp_exc;
		}else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
		
		$resultado_contato = $this->EmpresaContatoModel->get($dados['hel_seqexc_ose']);
		
		if ($resultado_contato){
			$dados['hel_seqcon_ose'] = $resultado_empresa->hel_seqcon_exc;
		}else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}

		$dados['hel_datainicial_ose'] = $this->util->inverteDataPadrao($dados['hel_datainicial_ose']);
		$dados['hel_datafinal_ose']   = $this->util->inverteDataPadrao($dados['hel_datafinal_ose']);
	}
	
	private function carregarTecnicoRelatorio(&$dados) {
		$resultado = $this->ContatoModel->getContatoTecnico();
	
		foreach ($resultado as $registro) {
			$dados['BLC_TECNICO_RELATORIO'][] = array(
					"hel_pk_seq_con"	=> $registro->hel_pk_seq_con,
					"hel_nome_con"		=> $registro->hel_nome_con
			);
		}
		!$resultado ? $dados['BLC_TECNICO_RELATORIO'][] = array("hel_nome_con" => 'Não existe nenhuma técnico cadastrada') :'';
	}

	private function carregarEmpresaRelatorio(&$dados) {
		$resultado = $this->EmpresaModel->getEmpresaAtivo();

		foreach ($resultado as $registro) {
			$dados['BLC_EMPRESA_RELATORIO'][] = array(
				"hel_pk_seq_emp"     	=> $registro->hel_pk_seq_emp,
				"hel_nomefantasia_emp" 	=> $registro->hel_nomefantasia_emp
			);
		}
		!$resultado ? $dados['BLC_EMPRESA_RELATORIO'][] = array("hel_nomefantasia_emp" => 'Não existe nenhuma empresa cadastrada') :'';
	}
	
	private function carregarOrdemServicoRelatorio(&$dados) {
		$resultado = $this->OrdemServicoModel->getOrdemServico();
	
		foreach ($resultado as $registro) {
			$dados['BLC_ORDEM_SERVICO_RELATORIO'][] = array(
					"hel_pk_seq_ose" => $registro->hel_pk_seq_ose,
					"hel_numero_ose" => 'Nº '.$registro->hel_pk_seq_ose
			);
		}
		!$resultado ? $dados['BLC_ORDEM_SERVICO_RELATORIO'][] = array("hel_numero_ose" => 'Não existe nenhuma ordem de serviço') :'';
	}
	
	private function carregarEmpresa(&$dados) {
		$resultado = $this->EmpresaModel->getEmpresaAtivo();
	
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
		global $hel_seqcon_ose;
		global $hel_dateinicial_ose;
		global $hel_horarioinicial_ose;
		global $hel_datefinal_ose;
		global $hel_horariofinal_ose;
		global $hel_kminicial_ose;
		global $hel_kmfinal_ose;
		global $hel_observacao_ose;
		global $hel_seqexc_ose;
		global $hel_seqcontec_ose;
		
		$erros    = FALSE;
		$mensagem = null;
		
		if (empty($hel_seqemp_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Empresa não selecionada.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQEMP_OSE', 'has-error');
		}

		if (empty($hel_seqcontec_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Técnico não informado.\n";
		}else{
			$tecnico = $this->ContatoModel->get($hel_seqcontec_ose);
			if (!$tecnico) {
				$erros    = TRUE;
				$mensagem .= "- Técnico não cadastro.\n";
			}else if ($tecnico->hel_ativo_con == 0){
				$erros    = TRUE;
				$mensagem .= "- Técnico invativo.\n";
			}
		}

		if (empty($hel_seqcon_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Contato não selecionado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQCON_OSE', 'has-error');
		}
		
		if (empty($hel_dateinicial_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Data inicial não informada.\n";
			$this->session->set_flashdata('ERRO_HEL_DATEINCIAL_OSE', 'has-error');
		} else if (!$this->util->validarData($hel_dateinicial_ose)){
			$erros    = TRUE;
			$mensagem .= "- Data inicial inválida.\n";
			$this->session->set_flashdata('ERRO_HEL_DATEINCIAL_OSE', 'has-error');
		}
		
		if (empty($hel_horarioinicial_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Horário inicial não informada.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOINCIAL_OSE', 'has-error');
		} else if ($this->util->validarHora($hel_horarioinicial_ose)){
			$erros    = TRUE;
			$mensagem .= "- Horário inicial inválido.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOINCIAL_OSE', 'has-error');
		}

		if (empty($hel_datefinal_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Data final não informado.\n";
			$this->session->set_flashdata('ERRO_HEL_DATEFINAL_OSE', 'has-error');
		} else if (!$this->util->validarData($hel_datefinal_ose)){
			$erros    = TRUE;
			$mensagem .= "- Data final inválido.\n";
			$this->session->set_flashdata('ERRO_HEL_DATEFINAL_OSE', 'has-error');
		}
			
		if (empty($hel_horariofinal_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Horário final não informado.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOFINAL_OSE', 'has-error');
		} else if ($this->util->validarHora($hel_horariofinal_ose)){
			$erros    = TRUE;
			$mensagem .= "- Horário final inválido.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOFINAL_OSE', 'has-error');
		}
		
		if (!$erros and ($hel_horarioinicial_ose > $hel_horariofinal_ose) ){
			$erros    = TRUE;
			$mensagem .= "- Horário inicial maior que Horário final.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOINCIAL_OSE', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_HORARIOFINAL_OSE', 'has-error');
		}
		
		if ($hel_dateinicial_ose > $hel_datefinal_ose){
			$erros    = TRUE;
			$mensagem .= "- Data inicial maior que Data final.\n";
			$this->session->set_flashdata('ERRO_HEL_DATEINCIAL_OSE', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_DATEFINAL_OSE', 'has-error');
		}
		

		if (!$erros and ($hel_kminicial_ose > $hel_kmfinal_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Km Inicial maior que Km Final.\n";
			$this->session->set_flashdata('ERRO_HEL_KMINICIAL_OSE', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_KMFINAL_OSE', 'has-error');
		}
	
		if (!$erros){
			$resultado = $this->EmpresaContatoModel->getEmpresaContato3($hel_seqcon_ose,$hel_seqemp_ose);
			if ($resultado){
				$hel_seqexc_ose = $resultado->hel_pk_seq_exc; 
			}
		}
				
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar, corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_OSE', TRUE);				
			$this->session->set_flashdata('hel_seqemp_ose', $hel_seqemp_ose);
			$this->session->set_flashdata('hel_seqcon_ose', $hel_seqcon_ose);
			$this->session->set_flashdata('hel_datainicial_ose', $hel_dateinicial_ose );
			$this->session->set_flashdata('hel_horarioinicial_ose', $hel_horarioinicial_ose);
			$this->session->set_flashdata('hel_datafinal_ose', $hel_datefinal_ose);
			$this->session->set_flashdata('hel_horariofinal_ose', $hel_horariofinal_ose);
			$this->session->set_flashdata('hel_kminicial_ose', $hel_kminicial_ose);
			$this->session->set_flashdata('hel_kmfinal_ose', $hel_kmfinal_ose);
			$this->session->set_flashdata('hel_observacao_ose', $hel_observacao_ose);
				
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_ose) {
		$erros    = FALSE;
		$mensagem = null;
		
		$resultado = $this->OrdemServicoModel->get($hel_pk_seq_ose);
		
		if ( $resultado->hel_seqcontec_ose <> $this->session->userdata('hel_pk_seq_con') ){
			$erros    = TRUE;
			$mensagem = '- Técnico diferente na Ordem de Serviço';
		}
		
		if (!$erros){
			
			$update = ' UPDATE heltbios SET
							   hel_encerrado_ios = 0,
							   hel_seqioscha_ios = NULL,
							   hel_seqcontec_ios = NULL,
							   hel_solucao_ios   = NULL    		
						WHERE hel_pk_seq_ios IN ( SELECT hel_seqioscha_ios FROM ( SELECT hel_seqioscha_ios FROM heltbios
																				  WHERE hel_tipo_ios   = '.ORDEM_SERVICO.'
																                    AND hel_seqose_ios = '.$hel_pk_seq_ose.'
																                    AND hel_seqioscha_ios IS NOT NULL ) AS temp_hetbios ) ';		
			
			if (!$this->ItemOrdemServicoModel->update_ordem_servico($update)){
				$erros    = TRUE;
				$mensagem = '- Aconteceu um Erro grave, entre em contato com a Info Rio Sistemas LTDA';
			}		
			
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarContatoEmpresa(&$dados) {
	
		if ( !empty($dados['hel_seqemp_ose']) ){
			$resultado = $this->EmpresaContatoModel->getEmpresaContato2($dados['hel_seqemp_ose']);
				
			if (reset($resultado)){
				$dados['BLC_CONTATO_EMPRESA'][] = array(
						"hel_pk_seq_con"     => '',
						"hel_nome_con"       => 'Selecione...'
				);
			}
	
			foreach ($resultado as $registro) {
				$dados['BLC_CONTATO_EMPRESA'][] = array(
						"hel_pk_seq_con"     => $registro->hel_pk_seq_con,
						"hel_nome_con"       => $registro->hel_nome_con,
						"sel_hel_seqcon_ose" => ($dados['hel_seqcon_ose'] == $registro->hel_pk_seq_con)?'selected':''
				);
			}
		} else {
			$dados['BLC_CONTATO_EMPRESA'][] = array(
					"hel_pk_seq_con"     => '',
					"hel_nome_con"       => 'Selecione...'
			);
		}
	}
	
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_OSE   	  		= $this->session->flashdata('ERRO_HEL_OSE');
		$ERRO_HEL_SEQEMP_OSE   		= $this->session->flashdata('ERRO_HEL_SEQEMP_OSE');
		$ERRO_HEL_SEQCON_OSE   		= $this->session->flashdata('ERRO_HEL_SEQCON_OSE');
		$ERRO_HEL_DATEINCIAL_OSE 	= $this->session->flashdata('ERRO_HEL_DATEINCIAL_OSE');
		$ERRO_HEL_HORARIOINCIAL_OSE	= $this->session->flashdata('ERRO_HEL_HORARIOINCIAL_OSE');
		$ERRO_HEL_DATEFINAL_OSE  	= $this->session->flashdata('ERRO_HEL_DATEFINAL_OSE');
		$ERRO_HEL_HORARIOFINAL_OSE	= $this->session->flashdata('ERRO_HEL_HORARIOFINAL_OSE');
		$ERRO_HEL_KMINICIAL_OSE     = $this->session->flashdata('ERRO_HEL_KMINICIAL_OSE');
		$ERRO_HEL_KMFINAL_OSE       = $this->session->flashdata('ERRO_HEL_KMFINAL_OSE');
		
		$hel_seqemp_ose       		 = $this->session->flashdata('hel_seqemp_ose');
		$hel_seqcon_ose     		 = $this->session->flashdata('hel_seqcon_ose');
		$hel_dateinicial_ose		 = $this->session->flashdata('hel_datainicial_ose');
		$hel_horarioinicial_ose		 = $this->session->flashdata('hel_horarioinicial_ose');
		$hel_datefinal_ose		 	 = $this->session->flashdata('hel_datafinal_ose');
		$hel_horariofinal_ose	 	 = $this->session->flashdata('hel_horariofinal_ose');
		$hel_kminicial_ose		     = $this->session->flashdata('hel_kminicial_ose');
		$hel_kmfinal_ose		     = $this->session->flashdata('hel_kmfinal_ose');
		$hel_observacao_ose		     = $this->session->flashdata('hel_observacao_ose');
		if (!$ERRO_HEL_OSE){
			$this->carregarContatoEmpresa($dados);
		}

		if ($ERRO_HEL_OSE) {
			$dados['hel_seqemp_ose']       			= $hel_seqemp_ose;
			$dados['hel_seqcon_ose']       			= $hel_seqcon_ose;
			$dados['hel_datainicial_ose']         	= $hel_dateinicial_ose;
			$dados['hel_horarioinicial_ose']       	= $hel_horarioinicial_ose;
			$dados['hel_datafinal_ose']        		= $hel_datefinal_ose;
			$dados['hel_horariofinal_ose']       	= $hel_horariofinal_ose;
			$dados['hel_kminicial_ose']          	= $hel_kminicial_ose;
			$dados['hel_kmfinal_ose']           	= $hel_kmfinal_ose;
			$dados['hel_observacao_ose']         	= $hel_observacao_ose;		
				
			$this->carregarContatoEmpresa($dados);

			$dados['ERRO_HEL_SEQEMP_OSE']  			= $ERRO_HEL_SEQEMP_OSE;
			$dados['ERRO_HEL_SEQCON_OSE']  			= $ERRO_HEL_SEQCON_OSE;
			$dados['ERRO_HEL_DATEINCIAL_OSE']  		= $ERRO_HEL_DATEINCIAL_OSE;
			$dados['ERRO_HEL_HORARIOINCIAL_OSE']  	= $ERRO_HEL_HORARIOINCIAL_OSE;
			$dados['ERRO_HEL_DATEFINAL_OSE']  		= $ERRO_HEL_DATEFINAL_OSE;
			$dados['ERRO_HEL_HORARIOFINAL_OSE']  	= $ERRO_HEL_HORARIOFINAL_OSE;
			$dados['ERRO_HEL_KMINICIAL_OSE']  	    = $ERRO_HEL_KMINICIAL_OSE;
			$dados['ERRO_HEL_KMFINAL_OSE']  		= $ERRO_HEL_KMFINAL_OSE;
		}
	}
	
	private function consultarBanco($consulta){
		$result = $this->db->query($consulta);
		return $result->result();
	}
	
	public function relatorio($filtro_ordem_servico, $filtro_tecnico, $filtro_empresa, $dataIni, $dataFim){
		$clasuraWhere = "";
		$whereAnd     = " WHERE ";
        $dados['BLC_RELATORIO'] = array();
        $dados['BLC_RELATORIO_ITENS_ORDEM_SERVICO'] = array();

        $dados['BLC_RELATORIO_HEADER'][] = array(
            "report_caminho_imagem" => base_url("assets/images/logo.png"),
            "report_titulo" => 'Relatório de Ordem serviço',
            "report_modulo" => 'HelpDesk',
            "report_codigo" => 'HELPR602',
            "report_pagina" => 'Página {PAGENO} de {nbpg}',
        );

        $header = $this->parser->parse('report/report_header_padrao', $dados);
        $footer = $_SERVER['HTTP_HOST'] . '|Página {PAGENO} de {nbpg}|' . date('d/m/Y H:i:s');

        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load();
        $pdf->setAutoTopMargin = 'stretch';
        $pdf->SetHTMLHeader($header);
        $pdf->SetFooter($footer);
		
		if (!empty($filtro_ordem_servico)){
			$clasuraWhere = $clasuraWhere.$whereAnd." hel_pk_seq_ose IN (".$filtro_ordem_servico.") ";
			$whereAnd = " AND ";
		}

		if ((!empty($dataIni)) and (!empty($dataFim))){
			$clasuraWhere = $clasuraWhere.$whereAnd." hel_datainicial_ose BETWEEN '".$dataIni."' and '".$dataFim."'";
			$whereAnd = " AND ";
		}
		
		if (!empty($filtro_tecnico)){
			$clasuraWhere = $clasuraWhere.$whereAnd." tec.hel_pk_seq_con IN (".$filtro_tecnico.") ";
			$whereAnd = " AND ";
		}
		
		if (!empty($filtro_empresa)){
			$clasuraWhere = $clasuraWhere.$whereAnd." hel_pk_seq_emp IN (".$filtro_empresa.") ";
			$whereAnd = " AND ";
		}

		global $consulta;
		$consulta = " SELECT hel_pk_seq_ose,
				             hel_nomefantasia_emp,
						     heltbcon.hel_nome_con as contato_empresa,
						     tec.hel_nome_con as tecnico_nome,
						     TIMEDIFF(hel_horariofinal_ose, hel_horarioinicial_ose) as horas_analista,
						     (hel_kmfinal_ose - hel_kminicial_ose) as distancia,
						     hel_observacao_ose,
						     hel_datainicial_ose,
						     hel_datafinal_ose,
						     hel_horarioinicial_ose,
						     hel_horariofinal_ose
					  FROM heltbose
					  LEFT JOIN heltbexc     ON hel_seqexc_ose    = hel_pk_seq_exc
					  LEFT JOIN heltbemp     ON hel_seqemp_exc    = hel_pk_seq_emp
					  LEFT JOIN heltbcon     ON hel_seqcon_exc    = hel_pk_seq_con
					  LEFT JOIN heltbcon tec ON hel_seqcontec_ose = tec.hel_pk_seq_con ".$clasuraWhere;

        $dados_relatorio = $this->consultarBanco($consulta);


		if ($dados_relatorio) {

            foreach ($dados_relatorio as $registro) {
                $dados['BLC_RELATORIO'][] = array(
                    "hel_pk_seq_ose" => $registro->hel_pk_seq_ose,
                    "hel_nomefantasia_ose" => $registro->hel_nomefantasia_emp,
                    "hel_contatoempresa_ose" => $registro->contato_empresa,
                    "hel_tecniconome_ose" => $registro->tecnico_nome,
                    "hel_horasanalista_ose" => $registro->horas_analista,
                    "hel_distancia_ose" => $registro->distancia,
                    "hel_datainicial_ose" => $this->util->inverteData($registro->hel_datainicial_ose),
                    "hel_datafinal_ose" => $this->util->inverteData($registro->hel_datafinal_ose),
                    "hel_horarioinicial_ose" => $registro->hel_horarioinicial_ose,
                    "hel_horariofinal_ose" => $registro->hel_horariofinal_ose,
                    "hel_observacao_ose" => $registro->hel_observacao_ose,
                );
            }

            for ($i = 0; $i < count($dados['BLC_RELATORIO']); $i++) {
                $html = ' <html>
							<head>
								<link rel="stylesheet" type="text/css" href="' . base_url("assets/stylesheets/bootstrap.min.css") . '">
								<link rel="stylesheet" type="text/css" href="' . base_url("assets/stylesheets/bootstrap-grid.min.css") . '">
								<link rel="stylesheet" type="text/css" href="' . base_url("assets/stylesheets/estilo.css") . '">
							</head>
							<body class="layout-relatorio"> ';

                $html .= $this->parser->parse('report/report_ordem_servico', $dados['BLC_RELATORIO'][$i]);

                $select_item_chamado = ' SELECT hel_pk_seq_ios,
                                                concat(hel_desc_sis, " ( ",hel_codigo_sis, " )") as hel_desc_sis,
                                                hel_desc_ser,
                                                hel_seqcha_ios,
                                                hel_seqioscha_ios,
                                                hel_complemento_ios
                                         FROM heltbios
                                         LEFT JOIN heltbose ON hel_pk_seq_ose = hel_seqose_ios
                                         LEFT JOIN heltbsis ON hel_pk_seq_sis = hel_seqsis_ios
                                         LEFT JOIN heltbser ON hel_pk_seq_ser = hel_seqser_ios
                                         WHERE hel_tipo_ios   = '.ORDEM_SERVICO.'
                                           AND hel_seqose_ios = '.$dados['BLC_RELATORIO'][$i]['hel_pk_seq_ose'] ;

                    $resultado = $this->consultarBanco($select_item_chamado);

                    if ($resultado) {
                        $dados['BLC_RELATORIO_ITENS_ORDEM_SERVICO'] = array();
                        foreach ($resultado as $registro) {
                            $dados['BLC_RELATORIO_ITENS_ORDEM_SERVICO'][] = array(
                                "hel_pk_seq_ios" => $registro->hel_pk_seq_ios,
                                "hel_desc_sis" => $registro->hel_desc_sis,
                                "hel_desc_ser" => $registro->hel_desc_ser,
                                "hel_seqcha_ios" => $registro->hel_seqcha_ios,
                                "hel_seqioscha_ios" => $registro->hel_seqioscha_ios,
                                "hel_complemento_ios" => $registro->hel_complemento_ios
                            );
                        }
                    }

                $html .= $this->parser->parse('report/report_item_ordem_servico', $dados);
                $html .= $this->parser->parse('report/report_sumary_ordem_servico', $dados['BLC_RELATORIO'][$i]);
                $pdf->WriteHTML($html, true);
                if (isset($dados['BLC_RELATORIO'][$i +1]['hel_pk_seq_ose'])){
                    $pdf->AddPage();
                }
                $html .= '        </body>
                            </head>
						 </html> ';
                $html = '';
            }

            $pdf->Output();
		} else {
			$mensagem = "- Nenhuma ordem de serviço foi encontrada.\n";
			$this->session->set_flashdata('erro', nl2br($mensagem));
			redirect('erro_relatorio');
		}
	}	
}