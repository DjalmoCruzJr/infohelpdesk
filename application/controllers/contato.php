<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contato extends CI_Controller {

    public function __construct() {
		parent::__construct();
				
 		$this->layout = LAYOUT_DASHBOARD;
		
		$this->load->model('Contato_Model', 'ContatoModel');
		$this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
		$this->load->model('Chamado_Model', 'ChamadoModel');
		$this->load->model('Tipo_Contato_Model', 'TipoContatoModel');
		
		if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {redirect('');}
	}

	
	public function index() {
		$dados = array();
		$dados['NOVO_CONTATO'] = site_url('contato/novo');
		
		$dados['BLC_DADOS']   = array();
		
		$this->carregarDados($dados);
		
		$this->carregarTipoContatoRelatorio($dados);
				
		$this->parser->parse('contato_consulta', $dados);
		
	}
	
	public function novo() {
			
		$dados = array();
		$dados['hel_pk_seq_con']  			= 0;		
		$dados['hel_nome_con'] 				= '';
		$dados['hel_login_con']  			= '';
		$dados['hel_senha_con']  			= '';
		$dados['hel_confirsenha_con']		= '';
		$dados['hel_seqtco_con']  			= '';
		$dados['hel_checkedativo_con']  	= 'checked';
		$dados['hel_dis_senha_con']  		= '';
		$dados['hel_dis_confirsenha_con']	= '';
		$dados['hel_email_con']				= '';
		
		$dados['ACAO'] = 'Novo';
		
		$this->setarURL($dados);
	
		$this->carregarDadosFlash($dados);
	
		$this->carregarTipoContato($dados);
		
		$this->parser->parse('contato_cadastro', $dados);
	}
	
	public function editar($hel_pk_seq_con) {		
		$hel_pk_seq_con = base64_decode($hel_pk_seq_con);
		$dados = array();
		
		$this->carregarContato($hel_pk_seq_con, $dados);
		
		$dados['ACAO'] = 'Editar';
		$this->setarURL($dados);
		
		$this->carregarDadosFlash($dados);
		
		$this->carregarTipoContato($dados);
		
		$this->parser->parse('contato_cadastro', $dados);	
	}
	
	public function salvar() {
		global $hel_pk_seq_con;
		global $hel_nome_con;
		global $hel_seqtco_con;
		global $hel_login_con;
		global $hel_senha_con;
		global $hel_confirsenha_con;
		global $hel_ativo_con;
		global $hel_email_con;

		$hel_pk_seq_con			= $this->input->post('hel_pk_seq_con');
		$hel_nome_con			= $this->input->post('hel_nome_con');
		$hel_seqtco_con			= $this->input->post('hel_seqtco_con');
		$hel_login_con 			= $this->input->post('hel_login_con');
		$hel_senha_con 			= $this->input->post('hel_senha_con');
		$hel_confirsenha_con 	= $this->input->post('hel_confirsenha_con');
		$hel_ativo_con 			= $this->input->post('hel_ativo_con') == 1 ? 1 : 0;
		$hel_email_con 			= $this->input->post('hel_email_con');
		
		if ($this->testarDados()) {
			$contato = array(
				"hel_nome_con"   => $hel_nome_con, 
				"hel_seqtco_con" => $hel_seqtco_con,
				"hel_login_con"  => $hel_login_con,
				"hel_senha_con"  => empty($hel_pk_seq_con) ? sha1($hel_senha_con) : $hel_senha_con,
				"hel_ativo_con"  => $hel_ativo_con,
				"hel_email_con"  => $hel_email_con
			);
			
			if (!$hel_pk_seq_con) {	
				$hel_pk_seq_con = $this->ContatoModel->insert($contato);
			} else {
				$hel_pk_seq_con = $this->ContatoModel->update($contato, $hel_pk_seq_con);
			}

			if (is_numeric($hel_pk_seq_con)) {
				$this->session->set_flashdata('sucesso', 'Contato salva com sucesso.');
				redirect('contato');
			} else {
				$this->session->set_flashdata('erro', $hel_pk_seq_con);	
				redirect('contato');
			}
		} else {
			if (!$hel_pk_seq_con) {
				redirect('contato/novo/');
			} else {
				redirect('contato/editar/'.base64_encode($hel_pk_seq_con));
			}			
		}
	}
	
	public function apagar($hel_pk_seq_con) {		
		if ($this->testarApagar(base64_decode($hel_pk_seq_con))) {
			$contato = array ("hel_ativo_con" => 0);
			$res = $this->ContatoModel->update($contato,base64_decode($hel_pk_seq_con));
			if ($res) {
				$this->session->set_flashdata('sucesso', 'Contato inativado com sucesso.');
			} 
		}				
		redirect('contato');
	}
	
	private function setarURL(&$dados) {
		$dados['CONSULTA_CONTATO']  = site_url('contato');
		$dados['ACAO_FORM']         = site_url('contato/salvar');
	}	
	
	private function carregarDados(&$dados) {
		$resultado = $this->ContatoModel->getContato();
			
		foreach ($resultado as $registro) {
			$dados['BLC_DADOS'][] = array(
				"hel_nome_con" 	  => $registro->hel_nome_con,							
				"hel_login_con"   => $registro->hel_login_con,
				"hel_desc_tco"	  => $registro->hel_desc_tco,
				"hel_ativo_con"	  => $registro->hel_ativo_con == 1 ? 'Ativo' : 'Inativo',
				"CONTATO_EMPRESA" => site_url('empresa_contato/index/'.base64_encode($registro->hel_pk_seq_con)),
				"CONTATOS_CONTATO"=> site_url('contatos_contato/index/'.base64_encode($registro->hel_pk_seq_con)),
				"EDITAR_CONTATO"  => site_url('contato/editar/'.base64_encode($registro->hel_pk_seq_con)),
				"APAGAR_CONTATO"  => "abrirConfirmacao('".base64_encode($registro->hel_pk_seq_con)."')"
			);
		}
	}
	
	private function carregarContato($hel_pk_seq_con, &$dados) {
		$resultado = $this->ContatoModel->get($hel_pk_seq_con);
		
		if ($resultado) {
			foreach ($resultado as $chave => $valor) {
				$dados[$chave] = $valor;
			}
		} else {
			show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');			
		}
		
		$dados['hel_checkedativo_con'] 		= $dados['hel_ativo_con'] == 1 ? 'checked' : '';
		$dados['hel_dis_senha_con']    		= 'readonly';
		$dados['hel_dis_confirsenha_con']   = 'readonly';
		$dados['hel_confirsenha_con']    	= $dados['hel_senha_con'];		
	}
	
	private function carregarTipoContatoRelatorio(&$dados) {
		$resultado = $this->TipoContatoModel->getTipoContato();
	
		foreach ($resultado as $registro) {
			$dados['BLC_TIPO_CONTATO_RELATORIO'][] = array(
					"hel_pk_seq_tco"     => $registro->hel_pk_seq_tco,
					"hel_desc_tco"       => $registro->hel_desc_tco,
					"dis_hel_tco"        => ''
			);
		}
		
		!$resultado ? $dados['BLC_TIPO_CONTATO_RELATORIO'][] = array("hel_desc_tco" => 'Não existe nenhuma Tipo de Contato cadastrado',
				"dis_hel_tco"  => 'disabled') :'';
	}
	
	
	private function carregarTipoContato(&$dados) {
		$resultado = $this->TipoContatoModel->getTipoContato();
		
		foreach ($resultado as $registro) {
			$dados['BLC_TIPO_CONTATO'][] = array(
					"hel_pk_seq_tco"     => $registro->hel_pk_seq_tco,
					"hel_desc_tco"       => $registro->hel_desc_tco,
					"sel_hel_seqtco_con" => ($dados['hel_seqtco_con'] == $registro->hel_pk_seq_tco)?'selected':''
			);
		}
	
		!$resultado ? $dados['BLC_CIDADE'][] = array("hel_desc_tco" => 'Não existe nenhuma tipo de contato cadastrado') :'';
	}
	
	
	private function testarDados() {
		global $hel_pk_seq_con;
		global $hel_nome_con;
		global $hel_seqtco_con;
		global $hel_login_con;
		global $hel_senha_con;
		global $hel_confirsenha_con;
		global $hel_ativo_con;
		global $hel_email_con;

		$erros    = FALSE;
		$mensagem = null;

		$hel_nome_con 			= trim($hel_nome_con);
		$hel_login_con 			= trim($hel_login_con);
		$hel_senha_con 			= trim($hel_senha_con);
		$hel_confirsenha_con 	= trim($hel_confirsenha_con);
		$hel_email_con			= trim($hel_email_con);

		if (empty($hel_nome_con)) {
			$erros    = TRUE;
			$mensagem .= "- Nome não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_NOME_CON', 'has-error');
		}
		
		if (empty($hel_seqtco_con)) {
			$erros    = TRUE;
			$mensagem .= "- Tipo de contato não foi selecionado.\n";
			$this->session->set_flashdata('ERRO_HEL_SEQTCO_CON', 'has-error');
		}
		
		if (empty($hel_login_con)) {
			$erros    = TRUE;
			$mensagem .= "- Login não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_LOGIN_CON', 'has-error');
		}
		
		if (empty($hel_senha_con)) {
			$erros    = TRUE;
			$mensagem .= "- Senha não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_SENHA_CON', 'has-error');
		}
		
		if (empty($hel_confirsenha_con)) {
			$erros    = TRUE;
			$mensagem .= "- Confirmação da senha não foi preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_CONFIRSENHA_CON', 'has-error');
		}
		
		if (!empty($hel_senha_con) and !empty($hel_confirsenha_con) and $hel_senha_con <> $hel_confirsenha_con){
			$erros    = TRUE;
			$mensagem .= "- Senha e confirmação da senha diferentes.\n";
			$this->session->set_flashdata('ERRO_HEL_SENHA_CON', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_CONFIRSENHA_CON', 'has-error');
		}
		
		if (!$erros and $this->ContatoModel->getLoginCadastro($hel_pk_seq_con, $hel_login_con)) {
			$erros = TRUE;
			$mensagem .= "- Já existi um contato cadastrado com esse login.\n";
			$this->session->set_flashdata('ERRO_HEL_LOGIN_CON', 'has-error');
		}
		
		$resultado = $this->util->validar_senha($hel_senha_con);
		
		if ($erros and !empty($resultado)){
			$erros    = TRUE;
			$mensagem .= $resultado;
			$this->session->set_flashdata('ERRO_HEL_SENHA_CON', 'has-error');
			$this->session->set_flashdata('ERRO_HEL_CONFIRSENHA_CON', 'has-error');
		}

		if (empty($hel_email_con)) {
			$erros = TRUE;
			$mensagem .= "- E-mail não preenchido.\n";
			$this->session->set_flashdata('ERRO_HEL_EMAIL_CON', 'has-error');
		} else if (!filter_var($hel_email_con, FILTER_VALIDATE_EMAIL) ){
			$erros     = TRUE;
			$mensagem .= "- E-mail não é válido.\n";
			$this->session->set_flashdata('ERRO_HEL_EMAIL_CON', 'has-error');
		}

		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
			
			$this->session->set_flashdata('ERRO_HEL_CON', TRUE);				
			$this->session->set_flashdata('hel_nome_con', $hel_nome_con);
			$this->session->set_flashdata('hel_login_con', $hel_login_con);
// 			$this->session->set_flashdata('hel_senha_con', $hel_senha_con);
// 			$this->session->set_flashdata('hel_confirsenha_con', $hel_confirsenha_con);
			$this->session->set_flashdata('hel_seqtco_con', $hel_seqtco_con);
			$this->session->set_flashdata('hel_ativo_con', $hel_ativo_con);
			$this->session->set_flashdata('hel_email_con', $hel_email_con);
		}
				
		return !$erros;
	}
	
	private function testarApagar($hel_pk_seq_con) {
		$erros    = FALSE;
		$mensagem = null;
		
		if ($this->EmpresaContatoModel->getContatoEmpresaContato($hel_pk_seq_con)) {
			$erros    = TRUE;
			$mensagem .= "- Contatos da empresa cadastro.\n";
		}

		if ($this->ChamadoModel->getContatoChamado($hel_pk_seq_con)) {
			$erros    = TRUE;
			$mensagem .= "- Chamado aberto com esse contato.\n";
		}
		
		if ($this->ChamadoModel->getContatoChamado2($hel_pk_seq_con)) {
			$erros    = TRUE;
			$mensagem .= "- Chamado aberto para este contato.\n";
		}
		
	
		if ($erros) {
			$this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
			$this->session->set_flashdata('erro', nl2br($mensagem));
		}
	
		return !$erros;
	}
	
	private function carregarDadosFlash(&$dados) {
		$ERRO_HEL_CON   	   		= $this->session->flashdata('ERRO_HEL_CON');
		$ERRO_HEL_NOME_CON   		= $this->session->flashdata('ERRO_HEL_NOME_CON');
		$ERRO_HEL_LOGIN_CON   		= $this->session->flashdata('ERRO_HEL_LOGIN_CON');
		$ERRO_HEL_SENHA_CON   		= $this->session->flashdata('ERRO_HEL_SENHA_CON');
		$ERRO_HEL_CONFIRSENHA_CON  	= $this->session->flashdata('ERRO_HEL_CONFIRSENHA_CON');
		$ERRO_HEL_SEQTCO_CON  		= $this->session->flashdata('ERRO_HEL_SEQTCO_CON');
		$ERRO_HEL_ATIVO_CON  		= $this->session->flashdata('ERRO_HEL_ATIVO_CON');
		$ERRO_HEL_EMAIL_CON  		= $this->session->flashdata('ERRO_HEL_EMAIL_CON');
		

		$hel_nome_con     	   		= $this->session->flashdata('hel_nome_con');
		$hel_login_con     	   		= $this->session->flashdata('hel_login_con');
		$hel_senha_con     	   		= $this->session->flashdata('hel_senha_con');
		$hel_confirsenha_con  		= $this->session->flashdata('hel_confirsenha_con');
		$hel_seqtco_con  			= $this->session->flashdata('hel_seqtco_con');
		$hel_ativo_con  	   	   	= $this->session->flashdata('hel_ativo_con');
		$hel_email_con  	   	   	= $this->session->flashdata('hel_email_con');
		
		if ($ERRO_HEL_CON) {
			$dados['hel_nome_con']      		= $hel_nome_con;
			$dados['hel_login_con']       		= $hel_login_con;
			$dados['hel_senha_con']         	= $hel_senha_con;
			$dados['hel_confirsenha_con']  		= $hel_confirsenha_con;
			$dados['hel_seqtco_con'] 			= $hel_seqtco_con;
			$dados['hel_ativo_con'] 			= $hel_ativo_con;
			$dados['hel_email_con'] 			= $hel_email_con;
			$dados['hel_checkedativo_con']  	= $hel_ativo_con == 1 ? 'checked' : '';
			$dados['hel_dis_senha_con']  		= empty($dados['hel_dis_senha_con']) ? '' : $dados['hel_dis_senha_con'];
			$dados['hel_dis_confirsenha_con']  	= empty($dados['hel_dis_confirsenha_con']) ? '' : $dados['hel_dis_confirsenha_con'];
			$dados['hel_checkedativo_con']  	= $hel_ativo_con == 1 ? 'checked' : '';
			
			$dados['ERRO_HEL_NOME_CON']  		= $ERRO_HEL_NOME_CON;
			$dados['ERRO_HEL_LOGIN_CON']    	= $ERRO_HEL_LOGIN_CON;
			$dados['ERRO_HEL_SENHA_CON']  		= $ERRO_HEL_SENHA_CON;
			$dados['ERRO_HEL_CONFIRSENHA_CON']  = $ERRO_HEL_CONFIRSENHA_CON;
			$dados['ERRO_HEL_SEQTCO_CON'] 		= $ERRO_HEL_SEQTCO_CON;
			$dados['ERRO_HEL_ATIVO_CON']    	= $ERRO_HEL_ATIVO_CON;
			$dados['ERRO_HEL_EMAIL_CON']    	= $ERRO_HEL_EMAIL_CON;
		}
	}
	
	private function gerarRelatorio(){
		global $consulta;
		$result = $this->db->query($consulta);
		return $result->result();
	}
	
	public function relatorio($order_by, $filtro_tipo_contato, $hel_ativo_con){
        $order_by     = str_replace("%20", " ", $order_by);
        $clasulaWhere = "";
        $whereAnd     = " WHERE ";

        if ($filtro_tipo_contato != 0 ){
            $clasulaWhere = $clasulaWhere.$whereAnd.' hel_pk_seq_tco IN ('.$filtro_tipo_contato.') ';
            $whereAnd     = " AND ";
        }

        switch ($hel_ativo_con){
            case 0 : $clasulaWhere = $clasulaWhere.$whereAnd.' hel_ativo_con = '.$hel_ativo_con;
                $whereAnd = " AND ";
                break;
            case 1 : $clasulaWhere = $clasulaWhere.$whereAnd.' hel_ativo_con = '.$hel_ativo_con;
                $whereAnd = " AND ";
                break;
        }

        global $consulta;
        $consulta = " SELECT hel_pk_seq_con,
							 hel_pk_seq_tco,
						     hel_nome_con,
						     hel_login_con,
						     hel_desc_tco,
						     CASE hel_ativo_con WHEN 1 THEN 'Ativo'
							 else 'Inativo'
							 END AS hel_ativo_con
						FROM heltbcon
						LEFT JOIN heltbtco ON hel_pk_seq_tco = hel_seqtco_con ".$clasulaWhere.$order_by;

        if ($this->gerarRelatorio()) {
            $this->jasper->gerar_relatorio('assets/relatorios/relatorio_contato.jrxml', $consulta);
        } else {
            $mensagem = "- Nenhuma contato foi encontrada.\n";
            $this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
            $this->session->set_flashdata('erro', nl2br($mensagem));
            redirect('erro_relatorio');
        }
	}
	
}
