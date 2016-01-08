<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio_Menu_Contratado extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Sistema_Model', 'SistemaModel');
		$this->load->model('Menu_Model', 'MenuModel');
		$this->load->model('Empresa_Model', 'EmpresaModel');
		
	}

	public function index() {
		$dados = array();

		$dados['BLC_DADOS']  		 = array();

		$this->carregarEmpresaRelatorio($dados);
		$this->carregarSistemaRelatorio($dados);
		$this->carregarMenuRelatorio($dados);

		$this->parser->parse('relatorio_menu_contratado', $dados);
	}
	
	private function carregarEmpresaRelatorio(&$dados) {
		$resultado = $this->EmpresaModel->getEmpresaAtivo();
	
		foreach ($resultado as $registro) {
			$dados['BLC_EMPRESA_RELATORIO'][] = array(
					"hel_pk_seq_emp"     	=> $registro->hel_pk_seq_emp,
					"hel_nomefantasia_emp"  => $registro->hel_nomefantasia_emp,
					"dis_hel_emp"        	=> ''
			);
		}
		!$resultado ? $dados['BLC_EMPRESA_RELATORIO'][] = array("hel_nomefantasia_emp" => 'Não existe nenhum empresa cadastrado',
				"dis_hel_emp"  => 'disabled') :'';
	}
	
	private function carregarMenuRelatorio(&$dados) {
		$resultado = $this->MenuModel->getMenu();
	
		foreach ($resultado as $registro) {
			$dados['BLC_MENU_RELATORIO'][] = array(
					"hel_pk_seq_men" => $registro->hel_pk_seq_men,
					"hel_desc_men" 	 => $registro->hel_desc_men,
					"dis_hel_men"    => ''
			);
		}
		!$resultado ? $dados['BLC_MENU_RELATORIO'][] = array("hel_desc_men" => 'Não existe nenhum menu cadastrado',
				"dis_hel_men"  => 'disabled') :'';
	}

	private function carregarSistemaRelatorio(&$dados) {
		$resultado = $this->SistemaModel->getSistema();
	
		foreach ($resultado as $registro) {
			$dados['BLC_SISTEMA_RELATORIO'][] = array(
					"hel_pk_seq_sis" => $registro->hel_pk_seq_sis,
					"hel_codigo_sis" => $registro->hel_codigo_sis,
					"dis_hel_sis"    => ''
			);
		}
		!$resultado ? $dados['BLC_SISTEMA_RELATORIO'][] = array("hel_codigo_sis" => 'Não existe nenhum sistema cadastrado',
				"dis_hel_sis"  => 'disabled') :'';
	}
	
	
	private function gerarRelatorio(){
		global $consulta;		
		$result = $this->db->query($consulta);
		return $result->result();
	}
	
	public function relatorio($filtro_empresa, $filtro_sistema, $filtro_menu, $order_by) {
		$order_by     			  = str_replace("%20", " ", $order_by);
		$whereAnd 				  = " WHERE ";
		$clasuraWehre   		  = "";
		$select_sistema_contatado = "";
		$select_menu_contatado    = "";
		
		if (!empty($filtro_empresa)){
			$clasuraWehre = $clasuraWehre.$whereAnd.'hel_pk_seq_emp IN ('.$filtro_empresa.')';
			$whereAnd = ' AND ';
		}
		
		$select_sistema_contatado = ' SELECT hel_pk_seq_sco,
											 hel_seqsis_sco,
										     hel_codigo_sis,
										     hel_desc_sis,
										     CASE hel_tipo_sis WHEN 0 THEN "Desktop"
										                       WHEN 1 THEN "Mobile"
										                       WHEN 2 THEN "Web"
											  END AS hel_tipo_sis
									   FROM heltbsco
									   LEFT JOIN heltbsis ON hel_pk_seq_sis = hel_seqsis_sco
									   WHERE hel_seqemp_sco = $P{hel_seqemp_sco} ';
		
		$select_sistema_contatado = $filtro_sistema != 0 ? $select_sistema_contatado.' AND hel_seqsis_sco IN ('.$filtro_sistema.')' : $select_sistema_contatado.'';
		
		$select_menu_contatado = ' SELECT hel_pk_seq_msc,
										  hel_seqmen_msc,
									      hel_desc_men
								   FROM heltbmsc
								   LEFT JOIN heltbmen ON hel_pk_seq_men = hel_seqmen_msc
								   WHERE hel_seqsco_msc = $P{hel_seqsco_msc} ';
		
		$select_menu_contatado = $filtro_menu != 0 ? $select_menu_contatado.' AND hel_seqmen_msc IN ('.$filtro_menu.')' : $select_menu_contatado.'';
	
		global $consulta;
		$consulta = " SELECT hel_pk_seq_emp,
						     hel_nomefantasia_emp,
						     hel_nome_cid,
						     case hel_ativo_emp when 1 then 'Ativo'
						     else 'Inativo'
						     end as hel_ativo_emp
					   FROM heltbemp
					   LEFT JOIN heltbcid ON hel_pk_seq_cid = hel_seqcid_emp ".$clasuraWehre.$order_by;
		
		$select_sub = array (
			"hel_seqemp_sco" => $select_sistema_contatado,
			"hel_seqsco_msc" => $select_menu_contatado			
		);
		
		if ($this->gerarRelatorio()) {
			$this->jasper->gerar_relatorio('assets/relatorios/relatorio_menu_contratado.jrxml', $consulta, NULL, $select_sub);
		}else {
			$mensagem = "- Nenhum contato foi encontrada.\n";
			$this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			redirect('erro_relatorio');
		} 
	}

}