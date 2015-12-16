<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sistemas_Contratados extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;

		$this->load->model('Empresa_Model', 'EmpresaModel');
		$this->load->model('Sistemas_Contratados_Model', 'SistemasContratadosModel');
		$this->load->model('Sistema_Model', 'SistemaModel');
		$this->load->model('Menu_Sistema_Model', 'MenuSistemaModel');

	}

	
	public function index($hel_seqemp_sco) {
		$dados = array();
		$dados['NOVO_CONTATO']     = site_url('sistemas_contratados/novo/'.$hel_seqemp_sco);
		$dados['URL_APAGAR'] 	   = site_url('sistemas_contratados/apagar');
		$dados['VOLTAR_EMPRESA']   = site_url('empresa');
		$dados['hel_seqemp_sco']   = base64_decode($hel_seqemp_sco);

		$this->carregarEmpresa($dados);
		
		$dados['BLC_DADOS']   = array();
		
		$this->carregarDados($dados);
				
		$this->parser->parse('sistemas_contratados_consulta', $dados);
	}
	
	public function novo($hel_seqemp_sco) {
			
		$dados = array();
		$dados['hel_pk_seq_sco']  = 0;
		$dados['hel_seqemp_sco'] = base64_decode($hel_seqemp_sco);
		$dados['hel_seqsis_sco'] = '';
		
		$dados['ACAO'] = 'Novo';
		
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);

		$this->carregarSistemas($dados);
		
		$this->parser->parse('sistemas_contratados_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_sco, $hel_seqemp_sco) {
		$dados = array();

		$hel_pk_seq_sco 		 = base64_decode($hel_pk_seq_sco);
		$dados['hel_seqemp_sco'] = base64_decode($hel_seqemp_sco);
		
		$this->carregarSistemasContratados($hel_pk_seq_sco, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarSistemas($dados);
		
		$this->parser->parse('sistemas_contratados_cadastro', $dados);
	}
	
	public function salvar() {
		global $hel_pk_seq_sco;
		global $hel_seqemp_sco;
		global $hel_seqsis_sco;

		$hel_pk_seq_sco = $this->input->post('hel_pk_seq_sco');
		$hel_seqemp_sco = $this->input->post('hel_seqemp_sco');
		$hel_seqsis_sco	= $this->input->post('hel_seqsis_sco');

		if ($this->testarDados()) {
			$sistemas_cadastrados = array(
				"hel_seqemp_sco" => $hel_seqemp_sco,
				"hel_seqsis_sco" => $hel_seqsis_sco,
			);
			
			if (!$hel_pk_seq_sco) {
				$hel_pk_seq_sco = $this->SistemasContratadosModel->insert($sistemas_cadastrados);
			} else {
				$hel_pk_seq_sco = $this->SistemasContratadosModel->update($sistemas_cadastrados, $hel_pk_seq_sco);
			}

			if (is_numeric($hel_pk_seq_sco)) {
				$this->session->set_flashdata('sucesso', 'Sistemas Contratado salvo com sucesso.');
				redirect('sistemas_contratados/index/'.base64_encode($hel_seqemp_sco));
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_sco);
				redirect('sistemas_contratados/index/'.base64_encode($hel_seqemp_sco));
			}
		} else {
			if (!$hel_pk_seq_sco) {
				redirect('sistemas_contratados/novo/'.base64_encode($hel_seqemp_sco));
			} else {
				redirect('sistemas_contratados/editar/'.base64_encode($hel_pk_seq_sco).'/'.base64_encode($hel_seqemp_sco));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_sco, $hel_seqemp_sco) {
		if ($this->testarApagar(base64_decode($hel_pk_seq_sco))) {
			$res = $this->SistemasContratadosModel->delete(base64_decode($hel_pk_seq_sco));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Sistemas Contratados com sucesso.');
			} 
		}				
		redirect('sistemas_contratados/index/'.$hel_seqemp_sco);
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_SISTEMAS_CONTRATADOS']  = site_url('sistemas_contratados/index/'.base64_encode($dados['hel_seqemp_sco']));
		$dados['ACAO_FORM']         			 = site_url('sistemas_contratados/salvar');
	}

	private function carregarEmpresa(&$dados) {

		$resultado = $this->EmpresaModel->get($dados['hel_seqemp_sco']);

		if ($resultado) {
			$dados['NOME_EMPRESA'] = $resultado->hel_nomefantasia_emp;
		}
	}

	private function carregarSistemas(&$dados) {
		$resultado = $this->SistemaModel->getSistema();

		foreach ($resultado as $registro) {
			$dados['BLC_SISTEMA'][] = array(
				"hel_pk_seq_sis"     	=> $registro->hel_pk_seq_sis,
				"hel_desc_sis"  		=> $registro->hel_desc_sis,
				"hel_tipo_sis"  		=> $this->carregarTipoSistema($registro->hel_tipo_sis),
				"sel_hel_seqsis_sco" 	=> ($dados['hel_seqsis_sco'] == $registro->hel_pk_seq_sis)?'selected':'' );
		}

		!$resultado ? $dados['BLC_SISTEMA'][] = array("hel_desc_sis" => 'Não existe nenhuma sistema cadastrado') :'';
	}

	private function carregarTipoSistema($hel_tipo_sis){
		$tipo = "";
		switch ($hel_tipo_sis) {
			case 0 : $tipo = "Desktop";
				break;
			case 1 : $tipo = "Web";
				break;
			case 2 : $tipo = "Mobile";
				break;
		}

		return $tipo;
	}
	
	private function carregarDados(&$dados) {
		$resultado = $this->SistemasContratadosModel->getSistemasContratados($dados['hel_seqemp_sco']);
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_codigo_sis"  			   => $registro->hel_codigo_sis,
				"hel_desc_sis"    			   => $registro->hel_desc_sis,
				"EDITAR_SISTEMAS_CONTRATADOS"  => site_url('sistemas_contratados/editar/'.base64_encode($registro->hel_pk_seq_sco).'/'.base64_encode($registro->hel_seqemp_sco)),
				"APAGAR_SISTEMAS_CONTRATADOS"  => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_sco)."','".base64_encode($dados['hel_seqemp_sco'])."')"
			);
		}
	}
	
	private function carregarSistemasContratados($hel_pk_seq_sco, &$dados) {
		$resultado = $this->SistemasContratadosModel->get($hel_pk_seq_sco);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
	}

	
	
	private function testarDados() {
		global $hel_pk_seq_sco;
		global $hel_seqemp_sco;
		global $hel_seqsis_sco;

		$erros    = FALSE;
		$mensagem = null;


		if (empty($hel_seqsis_sco)){
			$erros    = TRUE;
			$mensagem .= "- Sistema não foi selecionado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQSIS_SCO', 'has-error');
		}

		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_SCO', TRUE);
			$this->session->set_flashdata('hel_seqsis_sco', $hel_seqsis_sco);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_con) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($this->MenuSistemaModel->getMenuSistemaContratado($hel_pk_seq_con)) {
			$erros    = TRUE;
			$mensagem .= "- Contatos da empresa cadastro.\n";
		}
	
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_SCO   	   		= $this->session->flashdata('ERRO_HEL_SCO');
		$ERRO_HEL_SEQSIS_SCO   		= $this->session->flashdata('ERRO_HEL_SEQSIS_SCO');

		$hel_seqsis_sco 	= $this->session->flashdata('hel_seqsis_sco');


		if ($ERRO_HEL_SCO) {
			$dados['hel_seqsis_sco']       = $hel_seqsis_sco;

			$dados['ERRO_HEL_SEQSIS_SCO']  = $ERRO_HEL_SEQSIS_SCO;
		}
	}
	
}
