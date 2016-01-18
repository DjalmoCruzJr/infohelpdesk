<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Ordem_Servico extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Ordem_Servico_Model', 'OrdemServicoModel');
		$this->load->model('Servico_Model', 'ServicoModel');
		$this->load->model('Sistema_Model', 'SistemaModel');
		$this->load->model('Sistema_Contratado_Model', 'SistemaContratadoModel');
		$this->load->model('Chamado_Model', 'ChamadoModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
		$this->load->model('Item_Ordem_Servico_Model', 'ItemOrdemServicoModel');
		
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

		$dados = array();
		$dados['hel_pk_seq_ios']  		= 0;		
		$dados['hel_seqose_ios']    	= base64_decode($hel_seqose_ios);
		$dados['hel_seqser_ios']      	= '';
		$dados['hel_seqcha_ios']      	= '';
		$dados['hel_seqsis_ios']    	= '';
		$dados['hel_complemento_ios']	= '';

		
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
		global $hel_seqose_ios;
		global $hel_seqser_ios;
		global $hel_seqsis_ios;
		global $hel_seqcha_ios;
		global $hel_complemento_ios;
		
		$hel_pk_seq_ios  		= $this->input->post('hel_pk_seq_ios');			
		$hel_seqose_ios    		= $this->input->post('hel_seqose_ios');
		$hel_seqser_ios 		= $this->input->post('hel_seqser_ios');
		$hel_seqsis_ios 		= $this->input->post('hel_seqsis_ios');
		$hel_seqcha_ios   		= $this->input->post('hel_seqcha_ios');
		$hel_complemento_ios    = $this->input->post('hel_complemento_ios');
		
		if ($this->testarDados()) {
			
			$item_ordem_servico = array(
				"hel_seqose_ios"        => $hel_seqose_ios,
				"hel_seqser_ios"		=> $hel_seqser_ios,
				"hel_seqsis_ios"   		=> $hel_seqsis_ios, 
				"hel_seqcha_ios"    	=> $hel_seqcha_ios,
				"hel_complemento_ios"	=> $hel_complemento_ios
			);
			
			if (!$hel_pk_seq_ios) {	
				$hel_pk_seq_ios = $this->ItemOrdemServicoModel->insert($item_ordem_servico);
			} else {
				$hel_pk_seq_ios = $this->ItemOrdemServicoModel->update($item_ordem_servico, $hel_pk_seq_ios);
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
		!$resultado ? $dados['BLC_SERVICO'][] = array("hel_desc_sis" => 'Não existe sistema cadastrado') :'';
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
		global $hel_seqose_ios;
		global $hel_seqser_ios;
		global $hel_seqsis_ios;
		global $hel_seqcha_ios;
		global $hel_complemento_ios;
		
		$erros    = FALSE;
		$mensagem = null;

		$hel_seqser_ios = empty($hel_seqser_ios) ? null : $hel_seqser_ios;
		$hel_seqsis_ios = empty($hel_seqsis_ios) ? null : $hel_seqsis_ios;
		$hel_seqcha_ios = empty($hel_seqcha_ios) ? null : $hel_seqcha_ios;
		
		if (empty($hel_seqser_ios)) {
			$erros    = TRUE;
			$mensagem .= "- Serviço não foi selecionada.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQSER_IOS', 'has-error');
		}else {
			$resultado = $this->ServicoModel->get($hel_seqser_ios);

			if ($resultado) {

				if ($resultado->hel_sistema_ser == 1) {
					$erros = TRUE;
					$mensagem .= "- Para serviço selecionado, necessário informar o sistema.\n";
					$this->session->set_flashdata('ERRO_HEL_SEQSIS_IOS', 'has-error');

				}
			}
		}

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_IOS', TRUE);				
			$this->session->set_flashdata('hel_seqose_ios', $hel_seqose_ios);
			$this->session->set_flashdata('hel_seqser_ios', $hel_seqser_ios);
			$this->session->set_flashdata('hel_seqsis_ios', $hel_seqsis_ios);
			$this->session->set_flashdata('hel_seqcha_ios', $hel_seqcha_ios);
			$this->session->set_flashdata('hel_complemento_ios', $hel_complemento_ios);
				
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
		$ERRO_HEL_IOS   	 = $this->session->flashdata('ERRO_HEL_IOS');
		$ERRO_HEL_SEQSER_IOS = $this->session->flashdata('ERRO_HEL_SEQSER_IOS');
		$ERRO_HEL_SEQSIS_IOS = $this->session->flashdata('ERRO_HEL_SEQSIS_IOS');

		$hel_seqose_ios      = $this->session->flashdata('hel_seqose_ios');
		$hel_seqser_ios      = $this->session->flashdata('hel_seqser_ios');
		$hel_seqsis_ios      = $this->session->flashdata('hel_seqsis_ios');
		$hel_seqcha_ios		 = $this->session->flashdata('hel_seqcha_ios');
		$hel_complemento_ios = $this->session->flashdata('hel_complemento_ios');
				
		if ($ERRO_HEL_IOS) {
			$dados['hel_seqose_ios']       	= $hel_seqose_ios;
			$dados['hel_seqser_ios']       	= $hel_seqser_ios;
			$dados['hel_seqsis_ios']       	= $hel_seqsis_ios;
			$dados['hel_seqcha_ios']       	= $hel_seqcha_ios;			
			$dados['hel_complemento_ios']   = $hel_complemento_ios;

			$dados['ERRO_HEL_SEQSER_IOS']  	= $ERRO_HEL_SEQSER_IOS;
			$dados['ERRO_HEL_SEQSIS_IOS']  	= $ERRO_HEL_SEQSIS_IOS;
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