<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chamado extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
 		$this->load->model('Chamado_Model', 'ChamadoModel');
 		$this->load->model('Item_Ordem_Servico_Model', 'ItemOrdemServicoModel');
 		$this->load->model('Contato_Model', 'ContatoModel');
 		$this->load->model('Item_Chamado_Model', 'ItemChamadoModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
		$this->load->model('Empresa_Model', 'EmpresaModel');
	}

	
	public function index() {
		$dados = array();
		
		$dados['NOVO_CHAMADO'] = site_url('chamado/novo');
		
		$dados['BLC_DADOS']  = array();
		
		$this->carregarDados($dados);
				
		$this->parser->parse('chamado_consulta', $dados);
		
	}
	
	public function novo() {
			
		$dados = array();
		$dados['hel_pk_seq_cha']  					= 0;		
		$dados['hel_seqemp_cha']  					= '';
		$dados['hel_seqcon_cha'] 					= $this->session->userdata('hel_tipo_tco') <> 0 ? $this->session->userdata('hel_pk_seq_con') : '';
		$dados['hel_hiddenseqconpara_cha'] 			= $this->session->userdata('hel_tipo_tco') <> 0 ? 'hidden' : '';
		$dados['hel_hiddenseqconsolicitante_cha'] 	= $this->session->userdata('hel_tipo_tco') <> 0 ? 'hidden' : '';
		$dados['hel_seqconde_cha'] 					= $this->session->userdata('hel_tipo_tco') <> 0 ? '' : $this->session->userdata('hel_pk_seq_con');
		$dados['hel_seqconpara_cha']				= '';
		$dados['hel_status_cha'] 					= '';
		$dados['hel_checkedencerrado_cha'] 			= '';
		$dados['hel_disabledencerrado_cha'] 		= 'disabled="disabled"';
				
		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
		
		$this->carregarEmpresa($dados);
		$this->carregarContatoDe($dados);
		$this->carregarContatoPara($dados);
		
		$this->parser->parse('chamado_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_cha) {		
		$hel_pk_seq_cha = base64_decode($hel_pk_seq_cha);
		$dados = array();
		
		$this->carregarChamado($hel_pk_seq_cha, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarEmpresa($dados);
		$this->carregarContatoDe($dados);
		$this->carregarContatoPara($dados);
		
		$this->parser->parse('chamado_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_cha;
		global $hel_seqemp_cha;
		global $hel_seqcon_cha;
		global $hel_seqconsolicitante_cha;
		global $hel_seqexc_cha;
		global $hel_seqconde_cha;
		global $hel_seqconpara_cha;
		global $hel_status_cha;
		
		$hel_pk_seq_cha  	 		= $this->input->post('hel_pk_seq_cha');			
		$hel_seqemp_cha  	 		= $this->input->post('hel_seqemp_cha');
		$hel_seqcon_cha  	 		= $this->input->post('hel_seqcon_cha');
		$hel_seqconsolicitante_cha 	= $this->input->post('hel_seqconsolicitante_cha');
		$hel_seqconde_cha  	 		= $this->input->post('hel_seqconde_cha');
		$hel_seqconpara_cha  		= $this->input->post('hel_seqconpara_cha');
		$hel_status_cha  	 		= $this->input->post('hel_status_cha') == 1 ? 1 : 0;

		if ($this->testarDados()) {			
			$chamado = array(
				"hel_seqexc_cha" 		=> $hel_seqexc_cha, 
				"hel_seqconde_cha"  	=> $hel_seqconde_cha,
				"hel_seqconpara_cha" 	=> $hel_seqconpara_cha
			);
			
			if (!$hel_pk_seq_cha) {	
				$hel_pk_seq_cha = $this->ChamadoModel->insert($chamado);
			} else {
				$hel_pk_seq_cha = $this->ChamadoModel->update($chamado, $hel_pk_seq_cha);
			}

			if (is_numeric($hel_pk_seq_cha)) {
				$this->session->set_flashdata('sucesso', 'Para coninuar insira os itens');
				redirect('item_chamado/novo/'.base64_encode($hel_pk_seq_cha));
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_cha);	
				redirect('chamado');
			}
		} 
		else {
			if (!$hel_pk_seq_cha) {
				redirect('chamado/novo/');
			} else {
				redirect('chamado/editar/'.base64_encode($hel_pk_seq_cha));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_cha) {		
		if ($this->testarApagar(base64_decode($hel_pk_seq_cha))) {
			$res = $this->ChamadoModel->delete(base64_decode($hel_pk_seq_cha));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Chamado apagado com sucesso.');
			} 
		}				
		redirect('chamado');
	}
	
	private function setarURL(&$dados) {
		$dados['URL_BUSCAR_CONTATO']  = site_url('json/json/carregar_contato');
		$dados['CONSULTA_CHAMADO']    = site_url('chamado');
		$dados['ACAO_FORM']           = site_url('chamado/salvar');
	}	
	
	private function carregarDados(&$dados) {
				
		$resultado = $this->util->autorizacao($this->session->userdata('hel_tipo_tco')) ? $this->ChamadoModel->getChamado($this->session->userdata('hel_pk_seq_con')) : $this->ChamadoModel->getChamado() ;	
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_pk_seq_cha"      		=> 'Nº '.$registro->hel_pk_seq_cha,
				"hel_nomefantasia_emp"  	=> $registro->hel_nomefantasia_emp,
				"hel_nome_con"         		=> $registro->hel_nome_con,
				"hel_horarioabertura_cha" 	=> $this->util->formatarDateTime($registro->hel_horarioabertura_cha),
				"hel_status_cha" 			=> $registro->hel_status_cha == 0 ? 'Aberto' : 'Encerrado',
				"ITEM_CHAMADO" 	 			=> site_url('item_chamado/index/'.base64_encode($registro->hel_pk_seq_cha)),					
				"EDITAR_CHAMADO" 	 		=> site_url('chamado/editar/'.base64_encode($registro->hel_pk_seq_cha)),
				"APAGAR_CHAMADO" 	 		=> "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_cha)."')"
			);
		}
	}
	
	private function carregarChamado($hel_pk_seq_cha, &$dados) {
		$resultado = $this->ChamadoModel->get($hel_pk_seq_cha);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
		
		$resultado_empresa = $this->EmpresaContatoModel->get($dados['hel_seqexc_cha']);
		
		if ($resultado_empresa){
			$dados['hel_seqemp_cha'] = $resultado_empresa->hel_seqemp_exc;
		}else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
		
		$resultado_contato = $this->EmpresaContatoModel->get($dados['hel_seqexc_cha']);
		
		if ($resultado_contato){
			$dados['hel_seqconsolicitante_cha'] = $resultado_empresa->hel_seqcon_exc;
			$dados['hel_seqcon_cha'] 			= $resultado_empresa->hel_seqcon_exc;
		} else {
		 	show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
		
		$dados['hel_checkedencerrado_cha'] 			= $dados['hel_status_cha'] == 1 ? 'checked="checked"' : '';
		$dados['hel_hiddenseqconde_cha'] 			= $this->session->userdata('hel_tipo_tco') <> 0 ? 'hidden' : '';
		$dados['hel_hiddenseqconpara_cha'] 			= $this->session->userdata('hel_tipo_tco') <> 0 ? 'hidden' : '';
		$dados['hel_hiddenseqconsolicitante_cha'] 	= $this->session->userdata('hel_tipo_tco') <> 0 ? 'hidden' : '';
		$dados['hel_disabledencerrado_cha'] 		= 'disabled="disabled"';
		$dados['hel_hiddenseqcon_cha'] 				= 'hidden';
	
	}
	
	private function carregarEmpresa(&$dados) {
		
		if (empty($dados['hel_seqcon_cha'])){
			$resultado = $this->EmpresaModel->getEmpresaAtivo();
		} else {
			$resultado = $this->EmpresaContatoModel->getEmpresaContatoAtivo($dados['hel_seqcon_cha']);
		}
		
		foreach ($resultado as $registro) {
			$dados['BLC_EMPRESA'][] = array(
					"hel_pk_seq_emp"     	=> $registro->hel_pk_seq_emp,
					"hel_nomefantasia_emp"  => $registro->hel_nomefantasia_emp,
					"sel_hel_seqemp_cha" 	=> ($dados['hel_seqemp_cha'] == $registro->hel_pk_seq_emp)?'selected':''
			);
		}
	
		!$resultado ? $dados['BLC_EMPRESA'][] = array("hel_nomefantasia_emp" => 'Não existe nenhuma empresa cadastrada') :'';
	}

	private function carregarContatoPara(&$dados) {
	
		$resultado = $this->ContatoModel->getContatoTecnico();
	
		foreach ($resultado as $registro) {
			$dados['BLC_CONTATO_PARA'][] = array(
					"hel_pk_seq_con"       		=> $registro->hel_pk_seq_con,
					"hel_nome_con"         		=> $registro->hel_nome_con,
					"sel_hel_seqconopara_cha" 	=> ($dados['hel_seqconpara_cha'] == $registro->hel_pk_seq_con)?'selected':''
			);
		}
	
	}
	
	private function carregarContatoDe(&$dados) {
	
		$resultado = $this->ContatoModel->getContatoTecnico();
	
		foreach ($resultado as $registro) {
			$dados['BLC_CONTATO_DE'][] = array(
					"hel_pk_seq_con"       	=> $registro->hel_pk_seq_con,
					"hel_nome_con"         	=> $registro->hel_nome_con,
					"sel_hel_seqconode_cha"	=> ($dados['hel_seqconde_cha'] == $registro->hel_pk_seq_con)?'selected':''
			);
		}
	
	}
	
	private function carregarSolicitante(&$dados) {
	
		if ( !empty($dados['hel_seqemp_cha']) ){
			$resultado = $this->EmpresaContatoModel->getEmpresaContato2($dados['hel_seqemp_cha']);
	
			if (reset($resultado)){
				$dados['BLC_CONTATO_SOLICITANTE'][] = array(
						"hel_pk_seq_con"     => '',
						"hel_nome_con"       => 'Selecione...'
				);
			}
	
			foreach ($resultado as $registro) {
				$dados['BLC_CONTATO_SOLICITANTE'][] = array(
						"hel_pk_seq_con"     			=> $registro->hel_pk_seq_con,
						"hel_nome_con"       			=> $registro->hel_nome_con,
						"sel_hel_seqconsolicitante_cha" => ($dados['hel_seqconsolicitante_cha'] == $registro->hel_pk_seq_con)?'selected':''
				);
			}
		} else {
			$dados['BLC_CONTATO_SOLICITANTE'][] = array(
					"hel_pk_seq_con"     => '',
					"hel_nome_con"       => 'Selecione...'
			);
		}
	}
	
	private function testarDados() {
		global $hel_pk_seq_cha;
		global $hel_seqemp_cha;
		global $hel_seqcon_cha;
		global $hel_seqconsolicitante_cha;
		global $hel_seqexc_cha;
		global $hel_seqconde_cha;
		global $hel_seqconpara_cha;
		global $hel_status_cha;

		$erros    = FALSE;
		$mensagem = null;
		
		var_dump($hel_seqcon_cha);
		var_dump($hel_seqconsolicitante_cha);

		$hel_seqcon_cha 	= empty($hel_seqcon_cha) ? $hel_seqconsolicitante_cha : $hel_seqcon_cha;
		$hel_seqconde_cha 	= empty($hel_seqconde_cha) ? NULL : $hel_seqconde_cha;
		$hel_seqconpara_cha = empty($hel_seqconpara_cha) ? NULL : $hel_seqconpara_cha;
		
		if (empty($hel_seqemp_cha)) {
			$erros    = TRUE;
			$mensagem .= "- Empresa não foi selecionada.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQEMP_CHA', 'has-error');
		}
		
		if (empty($hel_seqcon_cha)) {
			$erros    = TRUE;
			$mensagem .= "- Solicitante não foi informado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQCON_CHA', 'has-error');
		}
		
		
		if (empty($hel_seqconde_cha) and ($this->session->userdata('hel_tipo_tco') == 0) ) {
			$erros    = TRUE;
			$mensagem .= "- Informe para quem está abrindo o chamado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQCONDE_CHA', 'has-error');
		}
		

		if (empty($hel_seqconpara_cha) and ($this->session->userdata('hel_tipo_tco') == 0) ) {
			$erros    = TRUE;
			$mensagem .= "- Informe para quem está abrindo o chamado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQCONPARA_CHA', 'has-error');
		}
	
		
		if (!$erros){
			
			$resultado = $this->EmpresaContatoModel->getEmpresaContato3($hel_seqcon_cha,$hel_seqemp_cha);
			if ($resultado){
				$hel_seqexc_cha = $resultado->hel_pk_seq_exc;
			}
			
			if ( !empty($hel_seqconde_cha) and !empty($hel_seqconpara_cha) and ($hel_seqconde_cha == $hel_seqconpara_cha) ){
				$erros    = TRUE;
				$mensagem .= "- Não pode abrir o chamado para você mesmo.\n";
				$this->session->set_flashdata('ERRO_HEL_SEQCONPARA_CHA', 'has-error');
				$this->session->set_flashdata('ERRO_HEL_SEQCONDE_CHA', 'has-error');
			}
			
			if ((!empty($hel_status_cha)) and $this->ItemChamadoModel->getItemChamado($hel_pk_seq_cha) ){
				$erros    = TRUE;
				$mensagem .= "- Chamado não pode está encerrado, pois tem iten(s) aberto(s).\n";
				$this->session->set_flashdata('ERRO_HEL_STATUS_CHA', 'has-error');
			}
			
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_CHA', TRUE);				
			$this->session->set_flashdata('hel_seqemp_cha', $hel_seqemp_cha);
			$this->session->set_flashdata('hel_seqcon_cha', $hel_seqcon_cha);
			$this->session->set_flashdata('hel_seqconde_cha', $hel_seqconde_cha);
			$this->session->set_flashdata('hel_seqconpara_cha', $hel_seqconpara_cha);
			$this->session->set_flashdata('hel_seqconsolicitante_cha', $hel_seqconsolicitante_cha);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_cha) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($this->ItemChamadoModel->getChamadoItem($hel_pk_seq_cha)){
			$erros    = TRUE;
			$mensagem = " - Chamado com iten(s) aberto(s) .\n";
		}

		if ($this->ItemOrdemServicoModel->getChamadoOrdemServico($hel_pk_seq_cha)){
			$erros    = TRUE;
			$mensagem = " - Ordem de Serviço para este chamado .\n";
		}
	
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_CHA   	   		= $this->session->flashdata('ERRO_HEL_CHA');
		$ERRO_HEL_SEQEMP_CHA   		= $this->session->flashdata('ERRO_HEL_SEQEMP_CHA');		
		$ERRO_HEL_SEQCON_CHA   		= $this->session->flashdata('ERRO_HEL_SEQCON_CHA');
		$ERRO_HEL_SEQCONDE_CHA   	= $this->session->flashdata('ERRO_HEL_SEQCONDE_CHA');
		$ERRO_HEL_SEQCONPARA_CHA   	= $this->session->flashdata('ERRO_HEL_SEQCONPARA_CHA');
		$ERRO_HEL_STATUS_CHA   		= $this->session->flashdata('ERRO_HEL_STATUS_CHA');

		$hel_seqemp_cha   	   			 = $this->session->flashdata('hel_seqemp_cha');
		$hel_seqcon_cha        			 = $this->session->flashdata('hel_seqcon_cha');
		$hel_seqconde_cha     			 = $this->session->flashdata('hel_seqconde_cha');
		$hel_seqconpara_cha    			 = $this->session->flashdata('hel_seqconpara_cha');
		$hel_status_cha     			 = $this->session->flashdata('hel_status_cha');
		$hel_seqconsolicitante_cha 		 = $this->session->flashdata('hel_seqconsolicitante_cha');
		$this->carregarSolicitante($dados);

		if ($ERRO_HEL_CHA) {
			$dados['hel_seqemp_cha']       	 	= $hel_seqemp_cha;
			$dados['hel_seqcon_cha'] 			= $this->session->userdata('hel_tipo_tco') <> 0 ? $this->session->userdata('hel_pk_seq_con') : '';
			$dados['hel_seqconde_cha']       	= $hel_seqconde_cha;
			$dados['hel_seqconpara_cha']       	= $hel_seqconpara_cha;
			$dados['hel_status_cha']       	 	= $hel_status_cha;
			$dados['hel_seqconsolicitante_cha'] = $hel_seqconsolicitante_cha;
			$dados['hel_hiddenseqconde_cha'] 	= $this->session->userdata('hel_tipo_tco') <> 0 ? 'hidden' : '';
			$dados['hel_hiddenseqconpara_cha'] 	= $this->session->userdata('hel_tipo_tco') <> 0 ? 'hidden' : '';
			$dados['hel_checkedencerrado_cha'] 	= empty($hel_status_cha) ? '' : 'checked="checked"';
			$dados['hel_disabledencerrado_cha'] = 'disabled="disabled"';
			$dados['hel_seqconsolicitante_cha'] = $hel_seqconsolicitante_cha;
			$this->carregarSolicitante($dados);

			$dados['ERRO_HEL_SEQEMP_CHA']  	 	= $ERRO_HEL_SEQEMP_CHA;
			$dados['ERRO_HEL_SEQCON_CHA']  	 	= $ERRO_HEL_SEQCON_CHA;
			$dados['ERRO_HEL_SEQCONDE_CHA']  	= $ERRO_HEL_SEQCONDE_CHA;
			$dados['ERRO_HEL_SEQCONPARA_CHA']	= $ERRO_HEL_SEQCONPARA_CHA;
			$dados['ERRO_HEL_STATUS_CHA']		= $ERRO_HEL_STATUS_CHA;
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