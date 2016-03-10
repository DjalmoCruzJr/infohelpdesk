<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Ordem_Servico extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Ordem_Servico_Model', 'OrdemServicoModel');
		$this->load->model('Servico_Model', 'ServicoModel');
		$this->load->model('Contato_Model', 'ContatoModel');
		$this->load->model('Tipo_Contato_Model', 'TipoContatoModel');
		$this->load->model('Sistema_Model', 'SistemaModel');
		$this->load->model('Sistema_Contratado_Model', 'SistemaContratadoModel');
		$this->load->model('Chamado_Model', 'ChamadoModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
		$this->load->model('Item_Ordem_Servico_Model', 'ItemOrdemServicoModel');
		$this->load->model('Item_Chamado_Model', 'ItemChamadoModel');
		
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	public function index($hel_seqose_ios) {
		$dados = array();
		
		$dados['NOVO_ITEM_ORDEM_SERVICO']	= site_url('item_ordem_servico/novo/'.$hel_seqose_ios);
		$dados['VOLTAR_ORDEM_SERVICO']		= site_url('ordem_servico');
		$dados['URL_APAGAR']				= site_url('item_ordem_servico/apagar');
		
		$dados['BLC_DADOS']  = array();
		
		$dados['hel_seqose_ios'] = base64_decode($hel_seqose_ios);
		
		$this->carregarDados($dados);
				
		$this->parser->parse('item_ordem_servico_consulta', $dados);
	}
	
	public function novo($hel_seqose_ios) {
		
		$resultado = $this->OrdemServicoModel->get(base64_decode($hel_seqose_ios));
		
		if ($this->util->permissao($resultado->hel_seqcontec_ose, $this->session->userdata('hel_pk_seq_con'))){
			redirect('item_ordem_servico/index/'.$hel_seqose_ios);
		}	

		$dados = array();
		$dados['hel_pk_seq_ios']  		= 0;
		$dados['hel_tipo_ios']  		= ORDEM_SERVICO;
		$dados['hel_seqose_ios']    	= base64_decode($hel_seqose_ios);
		$dados['hel_seqser_ios']      	= '';
		$dados['hel_seqcha_ios']      	= '';
		$dados['hel_seqsis_ios']    	= '';
		$dados['hel_complemento_ios']	= '';
		$dados['hel_seqioscha_ios']		= '';

		
		$dados['ACAO'] = 'Novo';
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
	
		$this->carregarServico($dados);
		$this->carregarDadosOrdemServico($dados);
		$this->carregarDadosEmpresa($dados);
		$this->carregarSistema($dados);
		$this->carregarChamado($dados);
		
		$this->parser->parse('item_ordem_servico_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_ios, $hel_seqose_ios) {
		
		$resultado = $this->OrdemServicoModel->get(base64_decode($hel_seqose_ios));
		
		if ($this->util->permissao($resultado->hel_seqcontec_ose, $this->session->userdata('hel_pk_seq_con'))){
			redirect('item_ordem_servico/index/'.$hel_seqose_ios);
		}		
		
		$dados = array();
		$hel_pk_seq_ios 			= base64_decode($hel_pk_seq_ios);
		$dados['hel_seqose_ios']	= base64_decode($hel_seqose_ios);
		
		$this->carregarOrdemServico($hel_pk_seq_ios, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarServico($dados);
		$this->carregarDadosOrdemServico($dados);
		$this->carregarDadosEmpresa($dados);
		$this->carregarSistema($dados);
		$this->carregarChamado($dados);
		
		$this->parser->parse('item_ordem_servico_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_ios;
		global $hel_tipo_ios;
		global $hel_seqose_ios;
		global $hel_seqser_ios;
		global $hel_seqsis_ios;
		global $hel_seqcha_ios;
		global $hel_complemento_ios;
		global $hel_seqioscha_ios;
		
		$hel_pk_seq_ios  		= $this->input->post('hel_pk_seq_ios');
		$hel_tipo_ios    		= $this->input->post('hel_tipo_ios');
		$hel_seqose_ios    		= $this->input->post('hel_seqose_ios');
		$hel_seqser_ios 		= $this->input->post('hel_seqser_ios');
		$hel_seqsis_ios 		= $this->input->post('hel_seqsis_ios');
		$hel_seqcha_ios   		= $this->input->post('hel_seqcha_ios');
		$hel_complemento_ios    = $this->input->post('hel_complemento_ios');
		$hel_seqioscha_ios	    = $this->input->post('hel_seqioscha_ios');
		
		
		if ($this->testarDados()) {
			
			$parameter_procedure = array();
			
			$item_ordem_servico = array(
				"hel_tipo_ios"       	=> $hel_tipo_ios,					
				"hel_seqose_ios"        => $hel_seqose_ios,
				"hel_seqser_ios"		=> $hel_seqser_ios,
				"hel_seqsis_ios"   		=> $hel_seqsis_ios, 
				"hel_seqcha_ios"    	=> $hel_seqcha_ios,
				"hel_complemento_ios"	=> $hel_complemento_ios,
				"hel_seqioscha_ios"		=> $hel_seqioscha_ios
			);
			
			if (!empty($hel_seqioscha_ios)){
				$parameter_procedure = array (
					"idChamado" => $hel_seqioscha_ios,
					"idTecnico"	=> $this->session->userdata('hel_pk_seq_con'),
					"solucao"   => $hel_complemento_ios		
				);
			}

			$resultado = $this->ItemOrdemServicoModel->get($hel_pk_seq_ios);
			
			if ($resultado->hel_seqioscha_ios <> $hel_seqioscha_ios){
				
				$item_chamado = array (
				  "hel_encerrado_ios" => 0,
				  "hel_seqcontec_ios" => NULL,
				  "hel_solucao_ios"   => NULL				
				);
				
				$this->ItemChamadoModel->update($item_chamado, $resultado->hel_seqioscha_ios);
			}
			
			if (!$hel_pk_seq_ios) {	
				$hel_pk_seq_ios = $this->ItemOrdemServicoModel->insert($item_ordem_servico, $parameter_procedure);
			} else {
				$hel_pk_seq_ios = $this->ItemOrdemServicoModel->update($item_ordem_servico, $hel_pk_seq_ios, $parameter_procedure);
			}

			if (is_numeric($hel_pk_seq_ios)) {
				$this->session->set_flashdata('sucesso', 'Item da Ordem de Serviço salva com sucesso.');
				redirect('item_ordem_servico/index/'.base64_encode($hel_seqose_ios));
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_ios);	
				redirect('item_ordem_servico/index/'.base64_encode($hel_seqose_ios));
			}
		} else {
			if (!$hel_pk_seq_ios) {
				redirect('item_ordem_servico/novo/'.base64_encode($hel_seqose_ios));
			} else {
				redirect('item_ordem_servico/editar/'.base64_encode($hel_pk_seq_ios).'/'.base64_encode($hel_seqose_ios));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_ios, $hel_seqose_ios) {

		$resultado = $this->OrdemServicoModel->get(base64_decode($hel_seqose_ios));
		
		if ($this->util->permissao($resultado->hel_seqcontec_ose, $this->session->userdata('hel_pk_seq_con'))){
			redirect('item_ordem_servico/index/'.$hel_seqose_ios);
		}	
		
		if ($this->testarApagar(base64_decode($hel_pk_seq_ios))) {
			$res = $this->ItemOrdemServicoModel->delete(base64_decode($hel_pk_seq_ios));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Item Ordem de Serviço apagada com sucesso.');
			} 
		}				
		redirect('item_ordem_servico/index/'.$hel_seqose_ios);
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_ITEM_ORDEM_SERVICO'] = site_url('item_ordem_servico/index/'.base64_encode($dados['hel_seqose_ios']));
		$dados['ACAO_FORM']         	 	  = site_url('item_ordem_servico/salvar');
		$dados['URL_BUSCAR_CHAMADO']		  = site_url('json/json/carregar_item_chamado');
	}
	
	private function carregarDadosEmpresa(&$dados){
		$resultado = $this->EmpresaContatoModel->get($dados['hel_seqexc_ose']);
		if ($resultado){
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		}else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
		
	}

	private function carregarDadosOrdemServico(&$dados) {
		$resultado = $this->OrdemServicoModel->get($dados['hel_seqose_ios']);
		if ($resultado){
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		}else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}	
	}
	
	
	private function carregarDados(&$dados) {
				
		$resultado = $this->ItemOrdemServicoModel->getItemOrdemServico($dados['hel_seqose_ios']);

		$dados['hel_disabled_ios'] = $this->contatoEhTecnico($dados) <> $this->session->userdata('hel_pk_seq_con') ? 'disabled' : '';
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_desc_ser" 	 		 	 => $registro->hel_desc_ser,							
				"hel_seqcha_ios"         	 => $registro->hel_seqcha_ios,
				"hel_desc_sis" 		 	 	 => $registro->hel_desc_sis,			
				"EDITAR_ITEM_ORDEM_SERVICO"	 => site_url('item_ordem_servico/editar/'.base64_encode($registro->hel_pk_seq_ios).'/'.base64_encode($registro->hel_seqose_ios)),
				"APAGAR_ITEM_ORDEM_SERVICO"	 => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_ios)."','".base64_encode($dados['hel_seqose_ios'])."')"
			);
		}
	}
	
	private function contatoEhTecnico(&$dados) {
		$resultado = $this->OrdemServicoModel->get($dados['hel_seqose_ios']);
		$tecnico   = '0';
	
		if ($resultado) {
			$contato = $this->ContatoModel->getEhContatoTecnico($resultado->hel_seqcontec_ose);
			if ($contato){
				$tecnico = $contato->hel_pk_seq_con;				
			} else {
				show_error('Não foram encontrados dados da Contato.', 500, 'Ops, erro encontrado');
			}
		} else {
			show_error('Não foram encontrados dados da Ordem de Serviço.', 500, 'Ops, erro encontrado');
		}		
		return $tecnico;
	}
	
	private function carregarOrdemServico($hel_pk_seq_ios, &$dados) {
		$resultado = $this->ItemOrdemServicoModel->get($hel_pk_seq_ios);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
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
	
	public function carregarItemChamado(&$dados) {
		if ( !empty($dados['hel_seqcha_ios']) ){
			$resultado = $this->ItemChamadoModel->getItemChamadoEncerrado($dados['hel_seqcha_ios']);
		
			if (reset($resultado)){
				$dados['BLC_ITEM_CHAMADO'][] = array(
						"hel_pk_seq1_ios"      => '',
						"hel_complemento1_ios" => 'Selecione...'
				);
			}
		
			foreach ($resultado as $registro) {
				$dados['BLC_ITEM_CHAMADO'][] = array(
						"hel_pk_seq1_ios"       => $registro->hel_pk_seq1_ios,
						"hel_complemento1_ios"  => $registro->hel_complemento1_ios,
						"sel_hel_seqioscha_ios" => ($dados['hel_seqcha_ios'] == $registro->hel_pk_seq1_ios)?'selected':''
				);
			}
			
			!$resultado ? $dados['BLC_ITEM_CHAMADO'][] = array("hel_pk_seq_ios" => NULL , "hel_complemento1_ios" => 'Nenhum item foi encontradado') :'';
			
		} else {
			$dados['BLC_ITEM_CHAMADO'][] = array(
					"hel_pk_seq1_ios"     	=> '',
					"hel_complemento1_ios"  => 'Selecione...'
			);
		}
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
	
	private function carregarChamado(&$dados) {
		
		$resultado_empresa = $this->EmpresaContatoModel->get($dados['hel_seqexc_ose']);
		
		if ($resultado_empresa){
			$resultado = $this->ChamadoModel->getChamadosAbertoEmpresa($dados['hel_seqexc_ose']);
		
			foreach ($resultado as $registro) {
				$dados['BLC_CHAMADO'][] = array(
						"hel_pk_seq_cha"     => $registro->hel_pk_seq_cha,
						"hel_desc_cha" 		 => 'Chamado Nº'.$registro->hel_pk_seq_cha,
						"sel_hel_seqcha_ios" => ($dados['hel_seqcha_ios'] == $registro->hel_pk_seq_cha)?'selected':''
				);
			}
			!$resultado ? $dados['BLC_CHAMADO'][] = array("hel_desc_cha" => 'Não existe chamado aberto') :'';
		}
	}
	
	private function testarDados() {
		global $hel_pk_seq_ios;
		global $hel_tipo_ios;
		global $hel_seqose_ios;
		global $hel_seqser_ios;
		global $hel_seqsis_ios;
		global $hel_seqcha_ios;
		global $hel_complemento_ios;
		global $hel_seqioscha_ios;
		
		$erros    = FALSE;
		$mensagem = null;

		$hel_seqser_ios 	 = empty($hel_seqser_ios) ? null : $hel_seqser_ios;
		$hel_seqsis_ios 	 = empty($hel_seqsis_ios) ? null : $hel_seqsis_ios;
		$hel_seqcha_ios 	 = empty($hel_seqcha_ios) ? null : $hel_seqcha_ios;
		$hel_seqioscha_ios 	 = empty($hel_seqioscha_ios) ? null : $hel_seqioscha_ios;
		$hel_complemento_ios = trim($hel_complemento_ios);
		
		if ($hel_tipo_ios == ''){
			$erros    = TRUE;
			$mensagem .= "- Tipo não informado, contacte a Info Rio Sistemas LTDA.\n";
		} else if ($hel_tipo_ios <> 0){
			$erros    = TRUE;
			$mensagem .= "- Tipo de Ordem de Serviço inválido.\n";
		}
		
		if (empty($hel_seqser_ios)) {
			$erros    = TRUE;
			$mensagem .= "- Serviço não selecionado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQSER_IOS', 'has-error');
		} else {
			$resultado = $this->ServicoModel->get($hel_seqser_ios);

			if ($resultado) {

				if ( ($resultado->hel_sistema_ser == 1) and (empty($hel_seqsis_ios)) ) {
					$erros = TRUE;
					$mensagem .= "- Para serviço selecionado, necessário informar o sistema.\n";
					$this->session->set_flashdata('ERRO_HEL_SEQSIS_IOS', 'has-error');
				} else if ( ($resultado->hel_sistema_ser == 0) and (!empty($hel_seqsis_ios)) ) {
					$erros = TRUE;
					$mensagem .= "- Para serviço selecionado, não é necessário informar o sistema.\n";
					$this->session->set_flashdata('ERRO_HEL_SEQSER_IOS', 'has-error');
				}
			}
		}
		
		if (!empty($hel_seqcha_ios) and empty($hel_seqioscha_ios)){
			$erros    = TRUE;
			$mensagem .= "- Chamado informado, mas nenhum item selecionado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQCHA_IOS', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_SEQCHAIOS_IOS', 'has-error');
		}
		
		if (!empty($hel_seqcha_ios) and !empty($hel_seqioscha_ios) and empty($hel_complemento_ios)){
			$erros    = TRUE;
			$mensagem .= "- Chamado informado, mas complemento não foi informada.\n";
			$this->session->set_flashdata('ERRO_HEL_COMPLEMENTO_IOS', 'has-error');
		}

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar, corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_IOS', TRUE);
			$this->session->set_flashdata('hel_tipo_ios', $hel_tipo_ios);
			$this->session->set_flashdata('hel_seqose_ios', $hel_seqose_ios);
			$this->session->set_flashdata('hel_seqser_ios', $hel_seqser_ios);
			$this->session->set_flashdata('hel_seqsis_ios', $hel_seqsis_ios);
			$this->session->set_flashdata('hel_seqcha_ios', $hel_seqcha_ios);
			$this->session->set_flashdata('hel_complemento_ios', $hel_complemento_ios);
			$this->session->set_flashdata('hel_seqioscha_ios', $hel_seqioscha_ios);
			
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_ios) {
		$erros    = FALSE;
		$mensagem = null;
		
		$resultado = $this->ItemOrdemServicoModel->get($hel_pk_seq_ios);
		
		if ($resultado){
			if (!empty($resultado->hel_seqioscha_ios)){
				$item_chamado = array (
					"hel_encerrado_ios" => 0,
					"hel_seqcontec_ios" => NULL,
					"hel_solucao_ios"	=> NULL	 		
				);
								
				$this->ItemChamadoModel->update($item_chamado, $resultado->hel_seqioscha_ios);
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}	
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_IOS   	 	  = $this->session->flashdata('ERRO_HEL_IOS');
		$ERRO_HEL_SEQSER_IOS 	  = $this->session->flashdata('ERRO_HEL_SEQSER_IOS');
		$ERRO_HEL_SEQSIS_IOS 	  = $this->session->flashdata('ERRO_HEL_SEQSIS_IOS');
		$ERRO_HEL_SEQCHA_IOS 	  = $this->session->flashdata('ERRO_HEL_SEQCHA_IOS');
		$ERRO_HEL_SEQCHAIOS_IOS   = $this->session->flashdata('ERRO_HEL_SEQCHAIOS_IOS');
		$ERRO_HEL_COMPLEMENTO_IOS = $this->session->flashdata('ERRO_HEL_COMPLEMENTO_IOS');

		$hel_tipo_ios      	 = $this->session->flashdata('hel_tipo_ios');
		$hel_seqose_ios      = $this->session->flashdata('hel_seqose_ios');
		$hel_seqser_ios      = $this->session->flashdata('hel_seqser_ios');
		$hel_seqsis_ios      = $this->session->flashdata('hel_seqsis_ios');
		$hel_seqcha_ios		 = $this->session->flashdata('hel_seqcha_ios');
		$hel_complemento_ios = $this->session->flashdata('hel_complemento_ios');
		$hel_seqioscha_ios   = $this->session->flashdata('hel_seqioscha_ios');
		$this->carregarItemChamado($dados);
				
		if ($ERRO_HEL_IOS) {
			$dados['hel_tipo_ios']       	= $hel_tipo_ios;
			$dados['hel_seqose_ios']       	= $hel_seqose_ios;
			$dados['hel_seqser_ios']       	= $hel_seqser_ios;
			$dados['hel_seqsis_ios']       	= $hel_seqsis_ios;
			$dados['hel_seqcha_ios']       	= $hel_seqcha_ios;			
			$dados['hel_complemento_ios']   = $hel_complemento_ios;
			$dados['hel_seqioscha_ios']   	= $hel_seqioscha_ios;
			
			$this->carregarItemChamado($dados);

			$dados['ERRO_HEL_SEQSER_IOS']  		= $ERRO_HEL_SEQSER_IOS;
			$dados['ERRO_HEL_SEQSIS_IOS']  		= $ERRO_HEL_SEQSIS_IOS;
			$dados['ERRO_HEL_SEQCHA_IOS']  		= $ERRO_HEL_SEQCHA_IOS;
			$dados['ERRO_HEL_SEQCHAIOS_IOS']  	= $ERRO_HEL_SEQCHAIOS_IOS;
			$dados['ERRO_HEL_COMPLEMENTO_IOS'] 	= $ERRO_HEL_COMPLEMENTO_IOS;
		}
	}
	
}