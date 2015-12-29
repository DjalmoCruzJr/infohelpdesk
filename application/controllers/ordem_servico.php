<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordem_Servico extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
 		$this->load->model('Empresa_Model', 'EmpresaModel');
		$this->load->model('Ordem_Servico_Model', 'OrdemServicoModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
		$this->load->model('Item_Ordem_Servico_Model', 'ItemOrdemServicoModel');
		
		
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
		$dados['hel_pk_seq_ose']  			= 0;		
		$dados['hel_horarioinicial_ose']    = '';
		$dados['hel_horariofinal_ose']      = '';
		$dados['hel_seqemp_ose']    		= '';
		$dados['hel_seqcon_ose']    		= '';
		$dados['hel_kminicial_ose']    		= '';
		$dados['hel_kmfinal_ose']    		= '';
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
		$this->carregarContatoEmpresa($dados);
		
		$this->parser->parse('ordem_servico_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_ose;
		global $hel_seqemp_ose;
		global $hel_seqcon_ose;
		global $hel_horarioinicial_ose;
		global $hel_horariofinal_ose;
		global $hel_kminicial_ose;
		global $hel_kmfinal_ose;
		global $hel_observacao_ose;
		global $hel_seqexc_ose;
		
		$hel_pk_seq_ose  		= $this->input->post('hel_pk_seq_ose');			
		$hel_seqemp_ose    		= $this->input->post('hel_seqemp_ose');
		$hel_seqcon_ose 		= $this->input->post('hel_seqcon_ose');
		$hel_horarioinicial_ose = $this->input->post('hel_horarioinicial_ose');
		$hel_horariofinal_ose   = $this->input->post('hel_horariofinal_ose');
		$hel_kminicial_ose      = $this->input->post('hel_kminicial_ose');
		$hel_kmfinal_ose        = $this->input->post('hel_kmfinal_ose');
		$hel_observacao_ose     = $this->input->post('hel_observacao_ose');
		
		if ($this->testarDados()) {
			
			$ordem_servico = array(
				"hel_seqexc_ose"           => $hel_seqexc_ose,
				"hel_seqcontec_ose"		   => $this->session->userdata('hel_pk_seq_con'),
				"hel_horarioinicial_ose"   => $this->util->gravarBancoDateTime($hel_horarioinicial_ose), 
				"hel_horariofinal_ose"     => $this->util->gravarBancoDateTime($hel_horariofinal_ose),
				"hel_kminicial_ose"        => $hel_kminicial_ose,
				"hel_kmfinal_ose"  		   => $hel_kmfinal_ose,
				"hel_observacao_ose" 	   => $hel_observacao_ose
			);
			
			if (!$hel_pk_seq_ose) {	
				$hel_pk_seq_ose = $this->OrdemServicoModel->insert($ordem_servico);
			} else {
				$hel_pk_seq_ose = $this->OrdemServicoModel->update($ordem_servico, $hel_pk_seq_ose);
			}

			if (is_numeric($hel_pk_seq_ose)) {
				$this->session->set_flashdata('sucesso', 'Ordem de serviço salva com sucesso.');
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
			$resp = $this->ItemOrdemServicoModel->deleteItensOrdemServico(base64_decode($hel_pk_seq_ose));
			if ($resp){
				$res = $this->OrdemServicoModel->delete(base64_decode($hel_pk_seq_ose));
				if ($res) {
					$this->session->set_flashdata('sucesso', 'Ordem de Serviço apagada com sucesso.');
				}	
			}
		}				
		redirect('ordem_servico');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_ORDEM_SERVICO'] = site_url('ordem_servico');
		$dados['ACAO_FORM']         	 = site_url('ordem_servico/salvar');
		$dados['URL_BUSCAR_CONTATO']   	 = site_url('json/json/carregar_contato');
	}	
	
	private function carregarDados(&$dados) {
				
		$resultado = $this->OrdemServicoModel->getOrdemServico();	
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_nomefantasia_emp" 	 => $registro->hel_nomefantasia_emp,							
				"hel_nome_con"         	 => $registro->hel_nome_con,
				"hel_horarioinicial_ose" => $this->util->formatarDateTime($registro->hel_horarioinicial_ose),
				"hel_horariofinal_ose" 	 => $this->util->formatarDateTime($registro->hel_horariofinal_ose),
				"ITEM_ORDEM_SERVICO" 	 => site_url('item_ordem_servico/index/'.base64_encode($registro->hel_pk_seq_ose)),					
				"EDITAR_ORDEM_SERVICO" 	 => site_url('ordem_servico/editar/'.base64_encode($registro->hel_pk_seq_ose)),
				"APAGAR_ORDEM_SERVICO" 	 => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_ose)."')"
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
		global $hel_seqexc_ose;
		global $hel_horarioinicial_ose;
		global $hel_horariofinal_ose;
		global $hel_kminicial_ose;
		global $hel_kmfinal_ose;
		global $hel_observacao_ose;
		
		$erros    = FALSE;
		$mensagem = null;
		
		if (empty($hel_seqemp_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Empresa não selecionada.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQEMP_OSE', 'has-error');
		}

		if (empty($hel_seqcon_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Contato não foi selecionado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQCON_OSE', 'has-error');
		}
		
		if (empty($hel_horarioinicial_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Horário inicial não foi informado.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOINCIAL_OSE', 'has-error');
		} else if ($this->util->validarDataHora($hel_horarioinicial_ose)){
			$erros    = TRUE;
			$mensagem .= "- Horário inicial inválido.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOINCIAL_OSE', 'has-error');
		}
		
		if (empty($hel_horariofinal_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Horário final não foi informado.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOFINAL_OSE', 'has-error');
		}else if ($this->util->validarDataHora($hel_horariofinal_ose)){
			$erros    = TRUE;
			$mensagem .= "- Horário final inválido.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOFINAL_OSE', 'has-error');
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
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_OSE', TRUE);				
			$this->session->set_flashdata('hel_seqemp_ose', $hel_seqemp_ose);
			$this->session->set_flashdata('hel_seqcon_ose', $hel_seqcon_ose);
			$this->session->set_flashdata('hel_horarioinicial_ose', $this->util->gravarBancoDateTime($hel_horarioinicial_ose, FALSE) );
			$this->session->set_flashdata('hel_horariofinal_ose', $this->util->gravarBancoDateTime($hel_horariofinal_ose, FALSE));
			$this->session->set_flashdata('hel_kminicial_ose', $hel_kminicial_ose);
			$this->session->set_flashdata('hel_kmfinal_ose', $hel_kmfinal_ose);
			$this->session->set_flashdata('hel_observacao_ose', $hel_observacao_ose);
				
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_ose) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($this->ItemOrdemServicoModel->getOrdemServicoItemOrdemServico($hel_pk_seq_ose)){
			$erros    = TRUE;
			$mensagem = '. Chamados encerrado para esta Ordem de Serviço';			
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
		$ERRO_HEL_HORARIOINCIAL_OSE = $this->session->flashdata('ERRO_HEL_HORARIOINCIAL_OSE');
		$ERRO_HEL_HORARIOFINAL_OSE  = $this->session->flashdata('ERRO_HEL_HORARIOFINAL_OSE');
		$ERRO_HEL_KMINICIAL_OSE     = $this->session->flashdata('ERRO_HEL_KMINICIAL_OSE');
		$ERRO_HEL_KMFINAL_OSE       = $this->session->flashdata('ERRO_HEL_KMFINAL_OSE');
		
		$hel_seqemp_ose       		 = $this->session->flashdata('hel_seqemp_ose');
		$hel_seqcon_ose     		 = $this->session->flashdata('hel_seqcon_ose');
		$hel_horarioinicial_ose		 = $this->session->flashdata('hel_horarioinicial_ose');
		$hel_horariofinal_ose		 = $this->session->flashdata('hel_horariofinal_ose');
		$hel_kminicial_ose		     = $this->session->flashdata('hel_kminicial_ose');
		$hel_kmfinal_ose		     = $this->session->flashdata('hel_kmfinal_ose');
		$hel_observacao_ose		     = $this->session->flashdata('hel_observacao_ose');
				
		if ($ERRO_HEL_OSE) {
			$dados['hel_seqemp_ose']       			= $hel_seqemp_ose;
			$dados['hel_seqcon_ose']       			= $hel_seqcon_ose;
			$dados['hel_horarioinicial_ose']       	= $hel_horarioinicial_ose;			
			$dados['hel_horariofinal_ose']       	= $hel_horariofinal_ose;
			$dados['hel_kminicial_ose']          	= $hel_kminicial_ose;
			$dados['hel_kmfinal_ose']           	= $hel_kmfinal_ose;
			$dados['hel_observacao_ose']         	= $hel_observacao_ose;
				
			$this->carregarContatoEmpresa($dados);

			$dados['ERRO_HEL_SEQEMP_OSE']  			= $ERRO_HEL_SEQEMP_OSE;
			$dados['ERRO_HEL_SEQCON_OSE']  			= $ERRO_HEL_SEQCON_OSE;
			$dados['ERRO_HEL_HORARIOINCIAL_OSE']  	= $ERRO_HEL_HORARIOINCIAL_OSE;
			$dados['ERRO_HEL_HORARIOFINAL_OSE']  	= $ERRO_HEL_HORARIOFINAL_OSE;
			$dados['ERRO_HEL_KMINICIAL_OSE']  	    = $ERRO_HEL_KMINICIAL_OSE;
			$dados['ERRO_HEL_KMFINAL_OSE']  		= $ERRO_HEL_KMFINAL_OSE;
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