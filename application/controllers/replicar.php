<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Replicar extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
  		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Empresa_Model', 'EmpresaModel');
		$this->load->model('Segmento_Model', 'SegmentoModel');
		$this->load->model('Sistema_Contratado_Model', 'SistemaContratadoModel');
		
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	
	public function index() {
		$dados = array();
		$dados['BLC_DADOS']    	 = array();
		$dados['hel_seqseg_emp'] = '';
		
		$this->setarURL($dados);
		
		$this->carregarSegmento($dados);
	
		$this->carregarDadosFlash($dados);
				
		$this->parser->parse('replicar_cadastro', $dados);
	}
	
	
	public function salvar() {
		global $hel_pk_seq_emp;
		global $hel_seqseg_emp;
		global $erros;
		
		$hel_seqseg_emp	= $this->input->post('hel_seqseg_emp');
		
		if ($this->testarDados()) {
		
			/*
			 * Empresa modelo é uma empresa que tem sistema contratado, do segmento informado na tela
			 * */
			$empresa_modelo		  = $this->EmpresaModel->getEmpresaSegmento($hel_seqseg_emp); 
			$sistemas_contratados = $this->SistemaContratadoModel->getEmpresaSistemaContratadoSegmento($empresa_modelo->hel_pk_seq_emp);
			$empresas_destino 	  = $this->EmpresaModel->getEmpresaNaoSistemaContratado();
			
			$erros = false;
			
			foreach ($empresas_destino as $row_empresa){
				foreach ($sistemas_contratados as $row_sistema) {
					
					$sistema_contratado = array(
							"hel_seqemp_sco" => $row_empresa->hel_pk_seq_emp,
							"hel_seqsis_sco" => $row_sistema->hel_seqsis_sco
					);
					
					$hel_pk_seq_emp = $this->SistemaContratadoModel->insert($sistema_contratado);
					
					
					if (!is_numeric($hel_pk_seq_emp)) {
						$this->session->set_flashdata('erro', $hel_pk_seq_emp);
						redirect('replicar');
						exit(1);
						$erros = true;
					} 
				}
			}

			if (!$erros){
				$this->session->set_flashdata('sucesso', 'Replicação concluida com sucesso!!!');
				redirect('replicar');
			}
			
		} else {
			redirect('replicar');
		}
	}
	

	private function setarURL(&$dados) {
		$dados['ACAO_FORM']	= site_url('replicar/salvar');
	}	
	
	
	private function carregarSegmento(&$dados) {
		$resultado = $this->SegmentoModel->getSegmento();
	
		foreach ($resultado as $registro) {
			$dados['BLC_SEGMENTO'][] = array(
					"hel_pk_seq_seg"     => $registro->hel_pk_seq_seg,
					"hel_desc_seg"       => $registro->hel_desc_seg,
					"sel_hel_seqseg_emp" => ($dados['hel_seqseg_emp'] == $registro->hel_pk_seq_seg)?'selected':''
			);
		}
	
		!$resultado ? $dados['BLC_SEGMENTO'][] = array("hel_pk_seq_seg"=> NULL, "hel_desc_seg" => 'Nenhum segmento cadastrado') :'';
	}
	
		
	private function testarDados() {
		global $hel_seqseg_emp;

		$erros    = FALSE;
		$mensagem = null;

		
		if(empty($hel_seqseg_emp)){
			$erros    = TRUE;
			$mensagem .= "- Segmento não foi selecionado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQSEG_EMP', 'has-error');
		}	

		
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_EMP', TRUE);				
			$this->session->set_flashdata('hel_seqseg_emp', $hel_seqseg_emp);
		}
				
		return !$erros;
	}
	
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_EMP   	  = $this->session->flashdata('ERRO_HEL_EMP');
		$ERRO_HEL_SEQSEG_EMP  = $this->session->flashdata('ERRO_HEL_SEQSEG_EMP');		
		
		$hel_seqseg_emp	      = $this->session->flashdata('hel_seqseg_emp');		
		
		if ($ERRO_HEL_EMP) {
			$dados['hel_seqseg_emp']  				= $hel_seqseg_emp;
			
			$dados['ERRO_HEL_SEQSEG_EMP']    		= $ERRO_HEL_SEQSEG_EMP;
		}
	}
	
}