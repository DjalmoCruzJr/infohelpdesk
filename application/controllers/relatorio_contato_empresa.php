<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio_Contato_Empresa extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Contato_Model', 'ContatoModel');
		$this->load->model('Empresa_Model', 'EmpresaModel');
		
	}

	public function index() {
		$dados = array();

		$dados['BLC_DADOS']  		 = array();

		$this->carregarContatoRelatorio($dados);
		$this->carregarEmpresaRelatorio($dados);

		$this->parser->parse('relatorio_contato_empresa', $dados);
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

	private function carregarContatoRelatorio(&$dados) {
		$resultado = $this->ContatoModel->getContato();
	
		foreach ($resultado as $registro) {
			$dados['BLC_CONTATO_RELATORIO'][] = array(
					"hel_pk_seq_con"     => $registro->hel_pk_seq_con,
					"hel_nome_con"       => $registro->hel_nome_con,
					"dis_hel_con"        => ''
			);
		}
		!$resultado ? $dados['BLC_CONTATO_RELATORIO'][] = array("hel_nome_con" => 'Não existe nenhum contato cadastrado',
				"dis_hel_con"  => 'disabled') :'';
	}
	
	
	private function gerarRelatorio(){
		global $consulta;		
		$result = $this->db->query($consulta);
		return $result->result();
	}
	
	public function relatorio($filtro_contato, $filtro_empresa, $order_by) {
		$order_by     	= str_replace("%20", " ", $order_by);
		$whereAnd 		= " WHERE ";
		$clasuraWehre   = "";
		$select_empresa = '';
		
		if (!empty($filtro_contato)){
			$clasuraWehre = $clasuraWehre.$whereAnd.'hel_pk_seq_con IN ('.$filtro_contato.')';
			$whereAnd = ' AND ';
		}
		
		$select_empresa = ' SELECT hel_pk_seq_emp,
							       hel_nomefantasia_emp,
							       hel_nome_cid,
							       case hel_ativo_emp when 1 then "Ativo"
							       else "Inativo"
							       end as hel_ativo_emp
							FROM heltbexc
							LEFT JOIN heltbemp ON hel_pk_seq_emp = hel_seqemp_exc
							LEFT JOIN heltbcid ON hel_pk_seq_cid = hel_seqcid_emp
							WHERE hel_seqcon_exc = $P{hel_seqcon_exc} ';
		
		$select_empresa .= $filtro_empresa != 0 ? ' AND hel_seqemp_exc IN ('.$filtro_empresa.')' : '';
	
		global $consulta;
		$consulta = " SELECT hel_pk_seq_con,
						     hel_pk_seq_tco,
						     hel_nome_con,
						     hel_login_con,
						     hel_desc_tco,
						     CASE hel_ativo_con WHEN 1 THEN 'Ativo'
						     else 'Inativo'
						     END AS hel_ativo_con
					  from heltbcon
					  LEFT JOIN heltbtco ON hel_pk_seq_tco = hel_seqtco_con ".$clasuraWehre.$order_by;
		
		$select_sub = array (
			"hel_seqcon_exc" => $select_empresa		
		);		
		
		if ($this->gerarRelatorio()) {
			$this->jasper->gerar_relatorio('assets/relatorios/relatorio_empresa_contato.jrxml', $consulta, NULL, $select_sub);
		}else {
			$mensagem = "- Nenhum contato foi encontrada.\n";
			$this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			redirect('erro_relatorio');
		} 
	}

}