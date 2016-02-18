<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Chamado extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
 		$this->load->model('Chamado_Model', 'ChamadoModel');
		$this->load->model('Item_Chamado_Model', 'ItemChamadoModel');
		$this->load->model('Servico_Model', 'ServicoModel');
		$this->load->model('Sistema_Model', 'SistemaModel');
		$this->load->model('Sistema_Contratado_Model', 'SistemaContratadoModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
	}

	public function index($hel_seqcha_ios) {
		$dados = array();
		
		$dados['NOVO_ITEM_CHAMADO']	= site_url('item_chamado/novo/'.$hel_seqcha_ios);
		$dados['URL_APAGAR']		= site_url('item_chamado/apagar');
		$dados['VOLTAR_CHAMADO']	= site_url('chamado');
		
		$dados['BLC_DADOS']  = array();
		
		$dados['hel_seqcha_ios'] = base64_decode($hel_seqcha_ios);
		
		$this->carregarDados($dados);
				
		$this->parser->parse('item_chamado_consulta', $dados);
	}
	
	public function novo($hel_seqcha_ios) {

		$dados = array();
		$dados['hel_pk_seq_ios']  			= 0;
		$dados['hel_tipo_ios']    			= CHAMADO;
		$dados['hel_seqcha_ios']    		= base64_decode($hel_seqcha_ios);
		$dados['hel_seqser_ios']      		= '';
		$dados['hel_seqsis_ios']    		= '';
		$dados['hel_complemento_ios']		= '';
		$dados['hel_solucao_ios']			= '';
		$dados['hel_hiddensolucao_ios']		= $this->session->userdata('hel_tipo_tco') <> 0 ? 'hidden' : '' ;
		$dados['hel_readonlyencerrado_ios']	= $this->session->userdata('hel_tipo_tco') <> 0 ? 'onclick="return false;"' : '' ;
		
		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
	
		$this->carregarServico($dados);
		$this->carregarDadosChamado($dados);
		$this->carregarDadosEmpresa($dados);
		$this->carregarSistema($dados);
		
		$this->parser->parse('item_chamado_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_ios, $hel_seqcha_ios) {		
		
		$dados = array();
		$hel_pk_seq_ios 		 = base64_decode($hel_pk_seq_ios);
		$dados['hel_seqcha_ios'] = base64_decode($hel_seqcha_ios);
		
		$this->carregarItensChamado($hel_pk_seq_ios, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarServico($dados);
		$this->carregarDadosChamado($dados);
		$this->carregarDadosEmpresa($dados);
		$this->carregarSistema($dados);
		
		$this->parser->parse('item_chamado_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_ios;
		global $hel_tipo_ios;
		global $hel_seqcha_ios;
		global $hel_seqser_ios;
		global $hel_seqsis_ios;
		global $hel_complemento_ios;
		global $hel_solucao_ios;
		global $hel_encerrado_ios;
		
		$hel_pk_seq_ios  		= $this->input->post('hel_pk_seq_ios');
		$hel_tipo_ios   		= $this->input->post('hel_tipo_ios');
		$hel_seqcha_ios   		= $this->input->post('hel_seqcha_ios');
		$hel_seqser_ios 		= $this->input->post('hel_seqser_ios');
		$hel_seqsis_ios 		= $this->input->post('hel_seqsis_ios');
		$hel_complemento_ios    = $this->input->post('hel_complemento_ios');
		$hel_solucao_ios 		= $this->input->post('hel_solucao_ios');
		$hel_encerrado_ios 		= $this->input->post('hel_encerrado_ios') == 1 ? 1 : 0;
		
		if ($this->testarDados()) {
			$item_chamado = array(
				"hel_tipo_ios" 			=> $hel_tipo_ios,	
				"hel_seqcha_ios"        => $hel_seqcha_ios,
				"hel_seqser_ios"		=> $hel_seqser_ios,
				"hel_seqsis_ios"   		=> $hel_seqsis_ios, 
				"hel_complemento_ios"	=> $hel_complemento_ios,
				"hel_solucao_ios"		=> $hel_solucao_ios,
				"hel_encerrado_ios"		=> $hel_encerrado_ios
			);
			
			if (!$hel_pk_seq_ios) {	
				$hel_pk_seq_ios = $this->ItemChamadoModel->insert($item_chamado);
			} else {
				$hel_pk_seq_ios = $this->ItemChamadoModel->update($item_chamado, $hel_pk_seq_ios);
			}

			if (is_numeric($hel_pk_seq_ios)) {
				$this->session->set_flashdata('sucesso', 'Item do Chamado salvo com sucesso.');
				redirect('item_chamado/index/'.base64_encode($hel_seqcha_ios));
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_ios);	
				redirect('item_chamado/index/'.base64_encode($hel_seqcha_ios));
			}
		} else {
			if (!$hel_pk_seq_ios) {
				redirect('item_chamado/novo/'.base64_encode($hel_seqcha_ios));
			} else {
				redirect('item_chamado/editar/'.base64_encode($hel_pk_seq_ios).'/'.base64_encode($hel_seqcha_ios));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_ios, $hel_seqcha_ios) {		
		if ($this->testarApagar(base64_decode($hel_pk_seq_ios))) {
			$res = $this->ItemChamadoModel->delete(base64_decode($hel_pk_seq_ios));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Item do chamado apagado com sucesso.');
			} 
		}				
		redirect('item_chamado/index/'.$hel_seqcha_ios);
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_ITEM_CHAMADO'] = site_url('item_chamado/index/'.base64_encode($dados['hel_seqcha_ios']));
		$dados['ACAO_FORM']         	= site_url('item_chamado/salvar');
	}
	
	private function carregarDadosEmpresa(&$dados){
		$resultado = $this->EmpresaContatoModel->get($dados['hel_seqexc_cha']);
		if ($resultado){
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		}else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
		
	}

	private function carregarDadosChamado(&$dados) {
		$resultado = $this->ChamadoModel->get($dados['hel_seqcha_ios']);
		if ($resultado){
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		}else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}	
	}
	
	
	private function carregarDados(&$dados) {
				
		$resultado = $this->ItemChamadoModel->getItemChamado($dados['hel_seqcha_ios']);
		
		$dados['hel_disabledencerraritemchamado_ios'] = $this->session->userdata('hel_tipo_tco') <> 0 ? 'disabled' : '' ;
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_desc_ser" 	 	  			=> $registro->hel_desc_ser,							
				"hel_desc_sis" 		  			=> $registro->hel_desc_sis,
				"hel_horaricioencerrado_ios"  	=> $this->util->formatarDateTime($registro->hel_horaricioencerrado_ios),					
				"hel_encerrado_ios"	  			=> $registro->hel_encerrado_ios == 0 ? 'Aberto' : 'Encerrado',
				"ENCERRAR_ITEM_CHAMADO"			=> site_url('encerramento_chamado/index/'.base64_encode($registro->hel_pk_seq_ios)),					
				"EDITAR_ITEM_CHAMADO" 			=> site_url('item_chamado/editar/'.base64_encode($registro->hel_pk_seq_ios).'/'.base64_encode($registro->hel_seqcha_ios)),
				"APAGAR_ITEM_CHAMADO" 			=> "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_ios)."','".base64_encode($dados['hel_seqcha_ios'])."')"
			);
		}
	}
	
	private function carregarItensChamado($hel_pk_seq_ios, &$dados) {
		$resultado = $this->ItemChamadoModel->get($hel_pk_seq_ios);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
		
		$dados['hel_checkedencerrado_ios']	= $dados['hel_encerrado_ios'] == 1 ? 'checked' : '' ;
		
		if (($dados['hel_encerrado_ios'] == 1) or ($this->session->userdata('hel_tipo_tco') <> 0)){
			$dados['hel_readonlysolucao_ios'] = 'readonly';
		} else {
			$dados['hel_readonlysolucao_ios'] = '';
		}
		
		if (($dados['hel_encerrado_ios'] == 1) or ($this->session->userdata('hel_tipo_tco') <> 0)){
			$dados['hel_readonlyencerrado_ios'] = 'onclick="return false;"';
		} else {
			$dados['hel_readonlyencerrado_ios'] = '';
		}
		
	}
	
	private function carregarServico(&$dados) {
		$resultado = $this->ServicoModel->getServico();
	
		foreach ($resultado as $registro) {
			$dados['BLC_SERVICO'][] = array(
					"hel_pk_seq_ser"     => $registro->hel_pk_seq_ser,
					"hel_desc_ser" 		 => $registro->hel_desc_ser,
					"sel_hel_seqser_ios" => ($dados['hel_seqser_ios'] == $registro->hel_pk_seq_ser)?'selected':''
			);
		}
		!$resultado ? $dados['BLC_SERVICO'][] = array("hel_desc_ser" => 'Não existe serviço cadastrado') :'';
	}
	
	private function carregarSistema(&$dados) {
		$resultado = $this->SistemaContratadoModel->getSistemaContratadoEmpresa($dados['hel_seqemp_exc']);
	
		foreach ($resultado as $registro) {
			$dados['BLC_SISTEMA'][] = array(
					"hel_pk_seq_sis"     => $registro->hel_pk_seq_sis,
					"hel_desc_sis" 		 => $registro->hel_desc_sis,
					"hel_tipo_sis" 		 => $this->carregarTipoSistema($registro->hel_tipo_sis),
					"sel_hel_seqsis_ios" => ($dados['hel_seqsis_ios'] == $registro->hel_pk_seq_sis)?'selected':''
			);
		}
		!$resultado ? $dados['BLC_SISTEMA'][] = array("hel_pk_seq_sis" => NULL ,"hel_desc_sis" => 'Não existe sistema contratado', "hel_tipo_sis" => '') :'';
	}
	
	private function carregarTipoSistema($hel_tipo_sis){
		$tipo = "";
		switch ($hel_tipo_sis) {
			case 0 : $tipo = "Desktop";
					 break;
			case 1 : $tipo = "Mobile";
					 break;
			case 2 : $tipo = "Web";
					 break;
		}
	
		return $tipo;
	}
	
	private function testarDados() {
		global $hel_pk_seq_ios;
		global $hel_tipo_ios;
		global $hel_seqcha_ios;
		global $hel_seqser_ios;
		global $hel_seqsis_ios;
		global $hel_complemento_ios;
		global $hel_solucao_ios;
		global $hel_encerrado_ios;
		
		$erros    = FALSE;
		$mensagem = null;
		
		$hel_seqsis_ios = empty($hel_seqsis_ios) ? null : $hel_seqsis_ios;
		$hel_complemento_ios = trim($hel_complemento_ios);
		$hel_solucao_ios 	 = trim($hel_solucao_ios);
		
		if (empty($hel_seqser_ios)) {
			$erros    = TRUE;
			$mensagem .= "- Serviço não foi selecionada.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQSER_IOS', 'has-error');
		} else {
			$resultado = $this->ServicoModel->get($hel_seqser_ios);

			if ($resultado) {

				if (($resultado->hel_sistema_ser == 1) and (empty($hel_seqsis_ios))) {
					$erros = TRUE;
					$mensagem .= "- Para serviço selecionado, necessário informar o sistema.\n";
					$this->session->set_flashdata('ERRO_HEL_SEQSER_IOS', 'has-error');
					$this->session->set_flashdata('ERRO_HEL_SEQSIS_IOS', 'has-error');
				}
			}
		}
		
		if (empty($hel_complemento_ios)){
			$erros    = TRUE;
			$mensagem .= "- Complemento não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_COMPLEMENTO_IOS', 'has-error');
		}
		
		if ( ($this->session->userdata('hel_tipo_tco') == 0) and (empty($hel_solucao_ios)) and (!empty($hel_pk_seq_ios))){
			$erros    = TRUE;
			$mensagem .= "- Solução não foi preenchida.\n";
			$this->session->set_flashdata('ERRO_HEL_SOLUCAO_IOS', 'has-error');			
		}
		
		if ( (!$erros) and ($hel_encerrado_ios == 1) and (empty($hel_solucao_ios)) ){
			$erros = TRUE;
			$mensagem .= "- Quando estiver encerrado deve informar a solução.\n";
			$this->session->set_flashdata('ERRO_HEL_SOLUCAO_IOS', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_STATUS_IOS', 'has-error');			
		} else if ( (!$erros) and ($hel_encerrado_ios == 0) and (!empty($hel_solucao_ios)) ) {
			$erros = TRUE;
			$mensagem .= "- Quando estiver solução deve informar encerrado.\n";
			$this->session->set_flashdata('ERRO_HEL_SOLUCAO_IOS', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_STATUS_IOS', 'has-error');
		}

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_IOS', TRUE);
			$this->session->set_flashdata('hel_tipo_ios', $hel_tipo_ios);
			$this->session->set_flashdata('hel_seqcha_ios', $hel_seqcha_ios);
			$this->session->set_flashdata('hel_seqser_ios', $hel_seqser_ios);
			$this->session->set_flashdata('hel_seqsis_ios', $hel_seqsis_ios);
			$this->session->set_flashdata('hel_complemento_ios', $hel_complemento_ios);
			$this->session->set_flashdata('hel_solucao_ios', $hel_solucao_ios);
			$this->session->set_flashdata('hel_encerrado_ios', $hel_encerrado_ios);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_ios) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}	
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_IOS   	 		= $this->session->flashdata('ERRO_HEL_IOS');
		$ERRO_HEL_SEQSER_IOS 		= $this->session->flashdata('ERRO_HEL_SEQSER_IOS');
		$ERRO_HEL_SEQSIS_IOS 		= $this->session->flashdata('ERRO_HEL_SEQSIS_IOS');
		$ERRO_HEL_SOLUCAO_IOS 		= $this->session->flashdata('ERRO_HEL_SOLUCAO_IOS');
		$ERRO_HEL_STATUS_IOS 		= $this->session->flashdata('ERRO_HEL_STATUS_IOS');
		$ERRO_HEL_COMPLEMENTO_IOS 	= $this->session->flashdata('ERRO_HEL_COMPLEMENTO_IOS');

		$hel_tipo_ios      	 	= $this->session->flashdata('hel_tipo_ios');
		$hel_seqcha_ios      	= $this->session->flashdata('hel_seqcha_ios');
		$hel_seqser_ios      	= $this->session->flashdata('hel_seqser_ios');
		$hel_seqsis_ios      	= $this->session->flashdata('hel_seqsis_ios');
		$hel_complemento_ios 	= $this->session->flashdata('hel_complemento_ios');
		$hel_solucao_ios 	 	= $this->session->flashdata('hel_solucao_ios');
		$hel_encerrado_ios 	 	= $this->session->flashdata('hel_encerrado_ios');
				
		if ($ERRO_HEL_IOS) {
			$dados['hel_tipo_ios']       			= $hel_tipo_ios;
			$dados['hel_seqcha_ios']       			= $hel_seqcha_ios;
			$dados['hel_seqser_ios']       			= $hel_seqser_ios;
			$dados['hel_seqsis_ios']       			= $hel_seqsis_ios;
			$dados['hel_seqcha_ios']       			= $hel_seqcha_ios;			
			$dados['hel_complemento_ios']   		= $hel_complemento_ios;
			$dados['hel_solucao_ios']   			= $hel_solucao_ios;
			$dados['hel_encerrado_ios']   			= $hel_encerrado_ios;
			$dados['hel_hiddensolucao_ios']			= $this->session->userdata('hel_tipo_tco') <> 0 ? 'hidden' : '' ;
			$dados['hel_disabledencerrado_ios']		= $this->session->userdata('hel_tipo_tco') <> 0 ? 'disabled' : '' ;
			$dados['hel_checkedencerrado_ios']		= $hel_encerrado_ios == 1 ? 'checked' : '' ;
			

			$dados['ERRO_HEL_SEQSER_IOS']  			= $ERRO_HEL_SEQSER_IOS;
			$dados['ERRO_HEL_SEQSIS_IOS']  			= $ERRO_HEL_SEQSIS_IOS;
			$dados['ERRO_HEL_SOLUCAO_IOS'] 			= $ERRO_HEL_SOLUCAO_IOS;
			$dados['ERRO_HEL_STATUS_IOS']  			= $ERRO_HEL_STATUS_IOS;
			$dados['ERRO_HEL_COMPLEMENTO_IOS']		= $ERRO_HEL_COMPLEMENTO_IOS;
		}
	}	
}