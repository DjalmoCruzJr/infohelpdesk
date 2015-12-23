<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordem_Servico extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Ordem_Servico_Model', 'OrdemServicoModel');
		$this->load->model('Empresa_Model', 'EmpresaModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
		
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
		$dados['hel_horarioinicial_ose']    = date("d/m/y H:i:s");
		$dados['hel_horariofinal_ose']      = date("d/m/y H:i:s");
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
	
	public function editar($hel_pk_seq_cid) {		
		$hel_pk_seq_cid = base64_decode($hel_pk_seq_cid);
		$dados = array();
		
		$this->carregarCidade($hel_pk_seq_cid, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		
		$this->parser->parse('cidade_cadastro', $dados);	
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
				"hel_horarioinicial_ose"   => $hel_horarioinicial_ose, 
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
	
	public function apagar($hel_pk_seq_cid) {		
		if ($this->testarApagar(base64_decode($hel_pk_seq_cid))) {
			$res = $this->CidadeModel->delete(base64_decode($hel_pk_seq_cid));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Cidade apagada com sucesso.');
			} 
		}				
		redirect('cidade');
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
				"hel_horarioinicial_ose" => $registro->hel_horarioinicial_ose,
				"hel_horariofinal_ose" 	 => $registro->hel_horariofinal_ose,
				"EDITAR_ORDEM_SERVICO" 	 => site_url('ordem_servico/editar/'.base64_encode($registro->hel_pk_seq_ose)),
				"APAGAR_ORDEM_SERVICO" 	 => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_ose)."')"
			);
		}
	}
	
	private function carregarCidade($hel_pk_seq_cid, &$dados) {
		$resultado = $this->CidadeModel->get($hel_pk_seq_cid);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}

		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
		
		$dados['gab_selected_uf'] = 'selected';
	}
	
	
	private function carregarEmpresa(&$dados) {
		$resultado = $this->EmpresaModel->getEmpresa();
	
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
		}
		
		if (empty($hel_horariofinal_ose)) {
			$erros    = TRUE;
			$mensagem .= "- Horário final não foi informado.\n";
			$this->session->set_flashdata('ERRO_HEL_HORARIOFINAL_OSE', 'has-error');
		}

		if (!empty($hel_kminicial_ose) and !empty($hel_kmfinal_ose)) {
			if ($hel_kminicial_ose > $hel_kmfinal_ose) {
				$erros    = TRUE;
				$mensagem .= "- Km Inicial maior que Km Final.\n";
				$this->session->set_flashdata('ERRO_HEL_KMINICIAL_OSE', 'has-error');
				$this->session->set_flashdata('ERRO_HEL_KMFINAL_OSE', 'has-error');
			}
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
			$this->session->set_flashdata('hel_horarioinicial_ose', $hel_horarioinicial_ose);
			$this->session->set_flashdata('hel_horariofinal_ose', $hel_horariofinal_ose);
			$this->session->set_flashdata('hel_kminicial_ose', $hel_kminicial_ose);
			$this->session->set_flashdata('hel_kmfinal_ose', $hel_kmfinal_ose);
			$this->session->set_flashdata('hel_observacao_ose', $hel_observacao_ose);
				
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_cid) {
		$erros    = FALSE;
		$mensagem = null;
	
		if ($this->EmpresaModel->getEmpresaCidade($hel_pk_seq_cid)) {
			$erros    = TRUE;
			$mensagem .= "- Empresa cadastrada.\n";
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