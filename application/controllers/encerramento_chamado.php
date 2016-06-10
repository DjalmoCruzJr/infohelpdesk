<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Encerramento_Chamado extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
 		$this->load->model('Tipo_Contato_Model', 'TipoContatoModel');
 		$this->load->model('Contato_Model', 'ContatoModel');
 		$this->load->model('Servico_Model', 'ServicoModel');
 		$this->load->model('Sistema_Model', 'SistemaModel');
 		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
 		$this->load->model('Item_Chamado_Model', 'ItemChamadoModel');
 		$this->load->model('Chamado_Model', 'ChamadoModel');
 		$this->load->model('Sistema_Contratado_Model', 'SistemaContratadoModel');
 		
 		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	
	public function index($hel_pk_seq_ios) {
		$dados = array();
		global $encerrado;
		$encerrado = FALSE;
		
		$this->carregarItemChamado($hel_pk_seq_ios,$dados);
		
		if ( ($this->session->userdata('hel_pk_seq_con') <> $dados['hel_seqcontec_ios']) and ( !empty($dados['hel_seqcontec_ios']) ) ) {
			redirect('item_chamado/index/'.base64_encode($dados['hel_seqcha_ios']));
		}
		
		$dados['BLC_DADOS']  			= array();
		$dados['VOLTAR_ITEM_CHAMADO']	= site_url('item_chamado/index/'.base64_encode($dados['hel_seqcha_ios']));
		$dados['ACAO_FORM']         	= site_url('encerramento_chamado/salvar/'.base64_encode($encerrado));
		
		$dados['hel_seqcontec_ios']     = $this->session->userdata('hel_pk_seq_con');
		
		$this->carregarServico($dados);
		$this->carregarDadosChamado($dados);
		$this->carregarDadosEmpresa($dados);
		$this->carregarSistema($dados);
		
		$this->carregarDadosFlash($dados);	

		$this->parser->parse('encerrar_chamado_view', $dados);		
	}
	
	private function carregarDadosChamado(&$dados){
		$resultado = $this->ChamadoModel->get($dados['hel_seqcha_ios']);
		if ($resultado){
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
		}
	}
	
	private function carregarDadosEmpresa(&$dados){
		$resultado = $this->EmpresaContatoModel->get($dados['hel_seqexc_cha']);
		if ($resultado){
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
		
	public function salvar($encerrado) {
		global $hel_pk_seq_ios;
		global $hel_seqcha_ios;
		global $hel_solucao_ios;
		global $hel_encerrado_ios;
		global $hel_seqcontec_ios;
		global $hel_encerrado;
		
		$hel_encerrado = base64_decode($encerrado);		
		
		$hel_pk_seq_ios  	= $this->input->post('hel_pk_seq_ios');
		$hel_seqcha_ios 	= $this->input->post('hel_seqcha_ios');
		$hel_solucao_ios 	= $this->input->post('hel_solucao_ios');
		$hel_seqcontec_ios 	= $this->input->post('hel_seqcontec_ios');		
		
		if ($this->testarDados()) {

			if ($hel_encerrado and empty($hel_solucao_ios)){
				$hel_encerrado_ios = 0;
				$hel_seqcontec_ios = NULL;
			} else {
				$hel_encerrado_ios = 1;
			}			
			
			$item_chamado = array( 
				"hel_solucao_ios"  	=> $hel_solucao_ios,
				"hel_seqcontec_ios"	=> $hel_seqcontec_ios,					
				"hel_encerrado_ios"	=> $hel_encerrado_ios
			);
			
			if ($hel_pk_seq_ios) {	
				$hel_pk_seq_ios = $this->ItemChamadoModel->update($item_chamado, $hel_pk_seq_ios);	
			}

			if (is_numeric($hel_pk_seq_ios)) {
				$this->session->set_flashdata('sucesso', 'Item do Chamado encerrado com sucesso');
				redirect('item_chamado/index/'.base64_encode($hel_seqcha_ios));
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_ios);	
				redirect('item_chamado/index/'.base64_encode($hel_seqcha_ios));
			}
		} else {			
			redirect('encerramento_chamado/index/'.base64_encode($hel_pk_seq_ios));
		}
	}
	
	private function carregarItemChamado($hel_pk_seq_ios, &$dados) {
		global $encerrado;
		
		$resultado = $this->ItemChamadoModel->get(base64_decode($hel_pk_seq_ios));
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}

		$dados['hel_checkedencerrado_ios'] = $dados['hel_encerrado_ios'] == 1 ? 'checked="checked"' : '';
		
		$encerrado = $dados['hel_encerrado_ios'] == 1 ? TRUE : FALSE;
	}
	
		
	private function testarDados() {
		global $hel_pk_seq_ios;
		global $hel_seqcha_ios;
		global $hel_solucao_ios;
		global $hel_encerrado_ios;
		global $hel_seqcontec_ios;
		global $hel_encerrado;
		global $hel_seqioscha_ios;

		$erros    = FALSE;
		$mensagem = null;
		
		$resultado = $this->ItemChamadoModel->get($hel_pk_seq_ios);
		
		if ($resultado){
			$hel_seqioscha_ios = $resultado->hel_seqioscha_ios;
		}else{
			show_error('Não foram encontrados item do chamado.', 500, 'Ops, erro encontrado');
		}
		
		$hel_solucao_ios = trim($hel_solucao_ios);
		
		if (empty($hel_seqcontec_ios)){
			$erros    = TRUE;
			$mensagem .= "- Técnico não foi informado.\n";
		} else {
			
			$resultado_contato = $this->ContatoModel->get($hel_seqcontec_ios);
			
			if ($resultado_contato) {
				$resultado_tecnico = $this->TipoContatoModel->getEhTecnico($resultado_contato->hel_seqtco_con);
				
				if (!$resultado_tecnico) {
					$erros     = TRUE;
					$mensagem .= "- Usuário não é técnico, contacte a Info Rio Sistema LTDA.\n";
				} 
				
			} else {
				show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
			}
		}
		
		if (!$hel_encerrado and empty($hel_solucao_ios)) {
			$erros    = TRUE;
			$mensagem .= "- Solução não foi preenchida.\n";
			$this->session->set_flashdata('ERRO_HEL_SOLUCAO_IOS', 'has-error');
		}

		if (!empty($hel_seqioscha_ios) and (empty($hel_solucao_ios))){
			$erros    = TRUE;
			$mensagem .= "- Existe uma ordem de serviço para esse item do chamado.\n";
			$this->session->set_flashdata('ERRO_HEL_SOLUCAO_IOS', 'has-error');
		}
		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_IOS', TRUE);				
			$this->session->set_flashdata('hel_solucao_ios', $hel_solucao_ios);
			$this->session->set_flashdata('hel_encerrado_ios', $hel_encerrado_ios);
			$this->session->set_flashdata('hel_seqcontec_ios', $hel_seqcontec_ios);
		}
				
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_IOS   	   	= $this->session->flashdata('ERRO_HEL_IOS');
		$ERRO_HEL_SOLUCAO_IOS	= $this->session->flashdata('ERRO_HEL_SOLUCAO_IOS');
		$HEL_ENCERRADO_IOS		= $this->session->flashdata('HEL_ENCERRADO_IOS');

		$hel_solucao_ios   	= $this->session->flashdata('hel_solucao_ios');
		$hel_encerrado_ios  = $this->session->flashdata('hel_encerrado_ios');
		$hel_seqcontec_ios 	= $this->session->flashdata('hel_seqcontec_ios');

		if ($ERRO_HEL_IOS) {
			$dados['hel_solucao_ios']       = $hel_solucao_ios;
			$dados['hel_encerrado_ios']  	= $hel_encerrado_ios;
			$dados['hel_seqcontec_ios']  	= $hel_seqcontec_ios;
			$dados['hel_checkedencerrado_ios'] = $hel_encerrado_ios == 1 ? 'checked="checked"' : '';

			$dados['ERRO_HEL_SOLUCAO_IOS'] 	= $ERRO_HEL_SOLUCAO_IOS;
			$dados['HEL_ENCERRADO_IOS'] 	= $HEL_ENCERRADO_IOS;
		}
	}
		
}