<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Chamado extends CI_Controller {
    public function __construct() {
        parent::__construct();

	    $this->layout = LAYOUT_DASHBOARD;

        $this->load->model('Chamado_Model', 'ChamadoModel');
        $this->load->model('Item_Ordem_Servico_Model', 'ItemOrdemServicoModel');
        $this->load->model('Contato_Model', 'ContatoModel');
        $this->load->model('Item_Chamado_Model', 'ItemChamadoModel');
        $this->load->model('Empresa_Contato_Model', 'EmpresaContatoModel');
        $this->load->model('Empresa_Model', 'EmpresaModel');
    }

    public function index() {
        $dados = array();

        $dados['NOVO_CHAMADO'] = site_url('chamado/novo');

        $dados['BLC_DADOS'] = array();
        $dados['URL_BUSCAR_CONTATO'] = site_url('json/json/carregar_contato_relatorio/' . CHAVE_JSON);
        $dados['URL_BUSCAR_CHAMADO'] = site_url('json/json/carregar_chamado/' . CHAVE_JSON);
        $dados['ACAO_FILTRO'] = site_url('chamado');

        $status_filtro = $this->input->post('status_filtro');
        $hel_seqemp_filtro = $this->input->post('hel_seqemp_filtro');
        $hel_seqcha_filtro = $this->input->post('hel_seqcha_filtro');
        $hel_seqconpara_filtro = $this->input->post('hel_seqconpara_filtro');

        $dados['status_filtro'] = $status_filtro;
        $dados['hel_seqemp_filtro'] = $hel_seqemp_filtro;
        $dados['hel_seqcha_filtro'] = $hel_seqcha_filtro;
        $dados['hel_seqconpara_filtro'] = $hel_seqconpara_filtro;

        $this->carregarDados($dados);
        $this->carregarEmpresaFiltro($dados);
        $this->carregarChamadoFiltro($dados);
        $this->carregarContatoParaFiltro($dados);

        $this->carregarEmpresaRelatorio($dados);
        $this->carregarChamadoRelatorio($dados);

        $this->parser->parse('chamado_consulta', $dados);
    }

    public function novo() {

        $dados = array();
        $dados['hel_pk_seq_cha'] = 0;
        $dados['hel_seqemp_cha'] = '';
        $dados['hel_seqcon_cha'] = $this->session->userdata('hel_tipo_tco') != 0 ? $this->session->userdata('hel_pk_seq_con') : '';
        $dados['hel_hiddenseqconpara_cha'] = $this->session->userdata('hel_tipo_tco') != 0 ? 'hidden' : '';
        $dados['hel_hiddenseqconsolicitante_cha'] = $this->session->userdata('hel_tipo_tco') != 0 ? 'hidden' : '';
        $dados['hel_seqconde_cha'] = $this->session->userdata('hel_seqconde_cha') != 0 ? '' : $this->session->userdata('hel_pk_seq_con');
        $dados['hel_seqconpara_cha'] = '';
        $dados['hel_status_cha'] = '';
        $dados['hel_checkedencerrado_cha'] = '';
        $dados['hel_disabledencerrado_cha'] = 'disabled="disabled"';

        $dados['ACAO'] = 'Novo';
        $this->setarURL($dados);

        $this->carregarDadosFlash($dados);

        $this->carregarEmpresa($dados);
        $this->carregarContatoDe($dados);
        $this->carregarContatoPara($dados);

        $view = "";

        $view = $this->util->autorizacao($this->session->userdata('hel_tipo_tco')) == TRUE ? 'usuario\chamado_cadastro' : 'chamado_cadastro';

        $this->parser->parse($view, $dados);
    }

    public function editar($hel_pk_seq_cha) {
        $hel_pk_seq_cha = base64_decode($hel_pk_seq_cha);
        $dados = array();

        $this->carregarChamado($hel_pk_seq_cha, $dados);

        $dados['ACAO'] = 'Editar';
        $this->setarURL($dados);

        $this->carregarDadosFlash($dados);

        $this->carregarEmpresa($dados);
        $this->carregarContatoDe($dados);
        $this->carregarContatoPara($dados);

        $view = "";

        $view = $this->util->autorizacao($this->session->userdata('hel_tipo_tco')) == TRUE ? 'usuario\chamado_cadastro' : 'chamado_cadastro';

        $this->parser->parse($view, $dados);
    }

    public function salvar() {
        global $hel_pk_seq_cha;
        global $hel_seqemp_cha;
        global $hel_seqcon_cha;
        global $hel_seqconsolicitante_cha;
        global $hel_seqexc_cha;
        global $hel_seqconde_cha;
        global $hel_seqconpara_cha;
        global $hel_status_cha;

        $hel_pk_seq_cha = $this->input->post('hel_pk_seq_cha');
        $hel_seqemp_cha = $this->input->post('hel_seqemp_cha');
        $hel_seqcon_cha = $this->input->post('hel_seqcon_cha');
        $hel_seqconsolicitante_cha = $this->input->post('hel_seqconsolicitante_cha');
        $hel_seqconde_cha = $this->input->post('hel_seqconde_cha');
        $hel_seqconpara_cha = $this->input->post('hel_seqconpara_cha');
        $hel_status_cha = $this->input->post('hel_status_cha') == 1 ? 1 : 0;

        if ($this->testarDados()) {
            $chamado = array(
                "hel_seqexc_cha" => $hel_seqexc_cha,
                "hel_seqconde_cha" => $hel_seqconde_cha,
                "hel_seqconpara_cha" => $hel_seqconpara_cha,
            );

            if (!$hel_pk_seq_cha) {
                $hel_pk_seq_cha = $this->ChamadoModel->insert($chamado);
            } else {
                $hel_pk_seq_cha = $this->ChamadoModel->update($chamado, $hel_pk_seq_cha);
            }

            if (is_numeric($hel_pk_seq_cha)) {
                $this->session->set_flashdata('sucesso', 'Para continuar, insira os itens');
                redirect('item_chamado/novo/' . base64_encode($hel_pk_seq_cha));
            } else if (is_numeric($hel_pk_seq_cha)) {
                $this->session->set_flashdata('sucesso', 'Chamado salvo com sucesso');
                redirect('chamado');
            } else {
                $this->session->set_flashdata('erro', $hel_pk_seq_cha);
                redirect('chamado');
            }
        } else {
            if (!$hel_pk_seq_cha) {
                redirect('chamado/novo/');
            } else {
                redirect('chamado/editar/' . base64_encode($hel_pk_seq_cha));
            }
        }
    }

    public function apagar($hel_pk_seq_cha) {
        if ($this->testarApagar(base64_decode($hel_pk_seq_cha))) {
            $res = $this->ChamadoModel->delete(base64_decode($hel_pk_seq_cha));
            if ($res) {
                $this->session->set_flashdata('sucesso', 'Chamado apagado com sucesso.');
            }
        }
        redirect('chamado');
    }

    private function setarURL(&$dados) {
        $dados['URL_BUSCAR_CONTATO'] = site_url('json/json/carregar_contato/' . CHAVE_JSON);
        $dados['CONSULTA_CHAMADO'] = site_url('chamado');
        $dados['ACAO_FORM'] = site_url('chamado/salvar');
    }

    private function carregarChamadoRelatorio(&$dados) {

        $resultado = $this->util->autorizacao($this->session->userdata('hel_tipo_tco')) ? $this->ChamadoModel->getChamado($this->session->userdata('hel_pk_seq_con')) : $this->ChamadoModel->getChamado();

        foreach ($resultado as $registro) {
            $dados['BLC_CHAMADO_RELATORIO'][] = array(
                "hel_pk_seq_cha" => $registro->hel_pk_seq_cha,
                "hel_numero_cha" => 'Numero ' . $registro->hel_pk_seq_cha,
            );
        }

        !$resultado ? $dados['BLC_CHAMADO_RELATORIO'][] = array("hel_numero_cha" => 'Não existe nenhum chamado cadastrado') : '';
    }

    private function carregarEmpresaRelatorio(&$dados) {

        $resultado = !$this->util->autorizacao($this->session->userdata('hel_tipo_tco')) ? $this->EmpresaModel->getEmpresa() : $this->EmpresaContatoModel->getEmpresaContatoRelatorio2($this->session->userdata('hel_pk_seq_con'));

        foreach ($resultado as $registro) {
            $dados['BLC_EMPRESA_RELATORIO'][] = array(
                "hel_pk_seq_emp" => $registro->hel_pk_seq_emp,
                "hel_nomefantasia_emp" => $registro->hel_nomefantasia_emp,
            );
        }

        !$resultado ? $dados['BLC_EMPRESA_RELATORIO'][] = array("hel_nomefantasia_emp" => 'Não existe nenhuma empresa cadastrada') : '';
    }

    private function carregarChamadoFiltro(&$dados) {

        $resultado = $this->util->autorizacao($this->session->userdata('hel_tipo_tco')) ? $this->ChamadoModel->getChamado($this->session->userdata('hel_pk_seq_con')) : $this->ChamadoModel->getChamado();

        foreach ($resultado as $registro) {
            $dados['BLC_CHAMADO_FILTRO'][] = array(
                "hel_pk_seq_cha" => $registro->hel_pk_seq_cha,
                "hel_numero_cha" => 'Numero ' . $registro->hel_pk_seq_cha,
                "sel_hel_seqchafiltro_cha" => ($dados['hel_seqcha_filtro'] == $registro->hel_pk_seq_con) ? 'selected' : '',
            );
        }

        !$resultado ? $dados['BLC_CHAMADO_FILTRO'][] = array("hel_numero_cha" => 'Não existe nenhum chamado cadastrado') : '';
    }

    private function carregarEmpresaFiltro(&$dados) {

        $resultado = !$this->util->autorizacao($this->session->userdata('hel_tipo_tco')) ? $this->EmpresaModel->getEmpresa() : $this->EmpresaContatoModel->getEmpresaContatoRelatorio2($this->session->userdata('hel_pk_seq_con'));

        foreach ($resultado as $registro) {
            $dados['BLC_EMPRESA_FILTRO'][] = array(
                "hel_pk_seq_emp" => $registro->hel_pk_seq_emp,
                "hel_nomefantasia_emp" => $registro->hel_nomefantasia_emp,
                "sel_hel_seqempfiltro_cha" => ($dados['hel_seqemp_filtro'] == $registro->hel_pk_seq_emp) ? 'selected' : '',
            );
        }

        !$resultado ? $dados['BLC_EMPRESA_FILTRO'][] = array("hel_nomefantasia_emp" => 'Não existe nenhuma empresa cadastrada') : '';
    }

    private function carregarContatoParaFiltro(&$dados) {

        $resultado = $this->ContatoModel->getContatoTecnico();

        foreach ($resultado as $registro) {
            $dados['BLC_CONTATO_PARA_FILTRO'][] = array(
                "hel_pk_seq_con" => $registro->hel_pk_seq_con,
                "hel_nome_con" => $registro->hel_nome_con,
                "sel_hel_seqconparafiltro_cha" => ($dados['hel_seqconpara_filtro'] == $registro->hel_pk_seq_con) ? 'selected' : '',
            );
        }

        !$resultado ? $dados['BLC_CONTATO_PARA_FILTRO'][] = array("hel_nome_con" => 'Não existe nenhum contato técnico cadastrado') : '';

    }

    private function carregarDados(&$dados) {

        $resultado = $this->util->autorizacao($this->session->userdata('hel_tipo_tco')) ? $this->ChamadoModel->getChamado($this->session->userdata('hel_pk_seq_con')) : $this->ChamadoModel->getChamado(NULL, $dados['status_filtro'], $dados['hel_seqemp_filtro'], $dados['hel_seqcha_filtro'], $dados['hel_seqconpara_filtro']);
        foreach ($resultado as $registro) {
            $dados['BLC_DADOS'][] = array(
                "hel_pk_seq_cha" => $registro->hel_pk_seq_cha,
                "hel_nomefantasia_emp" => $registro->hel_nomefantasia_emp,
                "hel_nome_con" => $registro->hel_nome_con,
                "hel_horarioabertura_cha" => $this->util->formatarDateTime($registro->hel_horarioabertura_cha),
                "hel_status_cha" => $registro->hel_status_cha == 0 ? 'Aberto' : 'Encerrado',
                "ITEM_CHAMADO" => site_url('item_chamado/index/' . base64_encode($registro->hel_pk_seq_cha)),
                "EDITAR_CHAMADO" => site_url('chamado/editar/' . base64_encode($registro->hel_pk_seq_cha)),
                "APAGAR_CHAMADO" => "abrirConfirmacao('" . base64_encode($registro->hel_pk_seq_cha) . "')",
            );
        }
    }

    private function carregarChamado($hel_pk_seq_cha, &$dados) {
        $resultado = $this->ChamadoModel->get($hel_pk_seq_cha);

        if ($resultado) {
            foreach ($resultado as $chave => $valor) {
                $dados[$chave] = $valor;
            }

        } else {
            show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
        }

        $resultado_empresa = $this->EmpresaContatoModel->get($dados['hel_seqexc_cha']);

        if ($resultado_empresa) {
            $dados['hel_seqemp_cha'] = $resultado_empresa->hel_seqemp_exc;
        } else {
            show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
        }

        $resultado_contato = $this->EmpresaContatoModel->get($dados['hel_seqexc_cha']);

        if ($resultado_contato) {
            $dados['hel_seqconsolicitante_cha'] = $resultado_empresa->hel_seqcon_exc;
            $dados['hel_seqcon_cha'] = $resultado_empresa->hel_seqcon_exc;
        } else {
            show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
        }

        $dados['hel_checkedencerrado_cha'] = $dados['hel_status_cha'] == 1 ? 'checked="checked"' : '';
        $dados['hel_hiddenseqconde_cha'] = $this->session->userdata('hel_tipo_tco') != 0 ? 'hidden' : '';
        $dados['hel_hiddenseqconpara_cha'] = $this->session->userdata('hel_tipo_tco') != 0 ? 'hidden' : '';
        $dados['hel_hiddenseqconsolicitante_cha'] = $this->session->userdata('hel_tipo_tco') != 0 ? 'hidden' : '';
        $dados['hel_disabledencerrado_cha'] = 'disabled="disabled"';
        $dados['hel_hiddenseqcon_cha'] = 'hidden';

    }

    private function carregarEmpresa(&$dados) {

        if (empty($dados['hel_seqcon_cha'])) {
            $resultado = $this->EmpresaModel->getEmpresaAtivo();
        } else {
            $resultado = $this->EmpresaContatoModel->getEmpresaContatoAtivo($dados['hel_seqcon_cha']);
        }

        foreach ($resultado as $registro) {
            $dados['BLC_EMPRESA'][] = array(
                "hel_pk_seq_emp" => $registro->hel_pk_seq_emp,
                "hel_nomefantasia_emp" => $registro->hel_nomefantasia_emp,
                "sel_hel_seqemp_cha" => ($dados['hel_seqemp_cha'] == $registro->hel_pk_seq_emp) ? 'selected' : '',
            );
        }

        !$resultado ? $dados['BLC_EMPRESA'][] = array("hel_nomefantasia_emp" => 'Não existe nenhuma empresa cadastrada') : '';
    }

    private function carregarContatoPara(&$dados) {

        $resultado = $this->ContatoModel->getContatoTecnico();

        foreach ($resultado as $registro) {
            $dados['BLC_CONTATO_PARA'][] = array(
                "hel_pk_seq_con" => $registro->hel_pk_seq_con,
                "hel_nome_con" => $registro->hel_nome_con,
                "sel_hel_seqconopara_cha" => ($dados['hel_seqconpara_cha'] == $registro->hel_pk_seq_con) ? 'selected' : '',
            );
        }

    }

    private function carregarContatoDe(&$dados) {

        $resultado = $this->ContatoModel->getContatoTecnico();

        foreach ($resultado as $registro) {
            $dados['BLC_CONTATO_DE'][] = array(
                "hel_pk_seq_con" => $registro->hel_pk_seq_con,
                "hel_nome_con" => $registro->hel_nome_con,
                "sel_hel_seqconode_cha" => ($dados['hel_seqconde_cha'] == $registro->hel_pk_seq_con) ? 'selected' : '',
            );
        }

    }

    private function carregarSolicitante(&$dados) {

        if (!empty($dados['hel_seqemp_cha'])) {
            $resultado = $this->EmpresaContatoModel->getEmpresaContato2($dados['hel_seqemp_cha']);

            if (reset($resultado)) {
                $dados['BLC_CONTATO_SOLICITANTE'][] = array(
                    "hel_pk_seq_con" => '',
                    "hel_nome_con" => 'Selecione...',
                );
            }

            foreach ($resultado as $registro) {
                $dados['BLC_CONTATO_SOLICITANTE'][] = array(
                    "hel_pk_seq_con" => $registro->hel_pk_seq_con,
                    "hel_nome_con" => $registro->hel_nome_con,
                    "sel_hel_seqconsolicitante_cha" => ($dados['hel_seqconsolicitante_cha'] == $registro->hel_pk_seq_con) ? 'selected' : '',
                );
            }
        } else {
            $dados['BLC_CONTATO_SOLICITANTE'][] = array(
                "hel_pk_seq_con" => '',
                "hel_nome_con" => 'Selecione...',
            );
        }
    }

    private function testarDados() {
        global $hel_pk_seq_cha;
        global $hel_seqemp_cha;
        global $hel_seqcon_cha;
        global $hel_seqconsolicitante_cha;
        global $hel_seqexc_cha;
        global $hel_seqconde_cha;
        global $hel_seqconpara_cha;
        global $hel_status_cha;

        $erros = FALSE;
        $mensagem = null;

// 		var_dump($hel_seqcon_cha);
        // 		var_dump($hel_seqconsolicitante_cha);

        $hel_seqcon_cha = empty($hel_seqcon_cha) ? $hel_seqconsolicitante_cha : $hel_seqcon_cha;
        $hel_seqconde_cha = empty($hel_seqconde_cha) ? NULL : $hel_seqconde_cha;
        $hel_seqconpara_cha = empty($hel_seqconpara_cha) ? NULL : $hel_seqconpara_cha;

        if (empty($hel_seqemp_cha)) {
            $erros = TRUE;
            $mensagem .= "- Empresa não foi selecionada.\n";
            $this->session->set_flashdata('ERRO_HEL_SEQEMP_CHA', 'has-error');
        }

        if (empty($hel_seqcon_cha)) {
            $erros = TRUE;
            $mensagem .= "- Solicitante não foi informado.\n";
            $this->session->set_flashdata('ERRO_HEL_SEQCON_CHA', 'has-error');
        }

        if (empty($hel_seqconde_cha) and ($this->session->userdata('hel_tipo_tco') == 0)) {
            $erros = TRUE;
            $mensagem .= "- Informe para quem está abrindo o chamado.\n";
            $this->session->set_flashdata('ERRO_HEL_SEQCONDE_CHA', 'has-error');
        }

        if (empty($hel_seqconpara_cha) and ($this->session->userdata('hel_tipo_tco') == 0)) {
            $erros = TRUE;
            $mensagem .= "- Informe para quem está abrindo o chamado.\n";
            $this->session->set_flashdata('ERRO_HEL_SEQCONPARA_CHA', 'has-error');
        }

        if (!$erros) {

            $resultado = $this->EmpresaContatoModel->getEmpresaContato3($hel_seqcon_cha, $hel_seqemp_cha);
            if ($resultado) {
                $hel_seqexc_cha = $resultado->hel_pk_seq_exc;
            }

            if (!empty($hel_seqconde_cha) and !empty($hel_seqconpara_cha) and ($hel_seqconde_cha == $hel_seqconpara_cha)) {
                $erros = TRUE;
                $mensagem .= "- Não pode abrir o chamado para você mesmo.\n";
                $this->session->set_flashdata('ERRO_HEL_SEQCONPARA_CHA', 'has-error');
                $this->session->set_flashdata('ERRO_HEL_SEQCONDE_CHA', 'has-error');
            }

            if ((!empty($hel_status_cha)) and $this->ItemChamadoModel->getItemChamado($hel_pk_seq_cha)) {
                $erros = TRUE;
                $mensagem .= "- Chamado não pode está encerrado, pois tem iten(s) aberto(s).\n";
                $this->session->set_flashdata('ERRO_HEL_STATUS_CHA', 'has-error');
            }

        }

        if ($erros) {
            $this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros: $hel_seqconde_cha ' . $hel_seqconde_cha);
            $this->session->set_flashdata('erro', nl2br($mensagem));

            $this->session->set_flashdata('ERRO_HEL_CHA', TRUE);
            $this->session->set_flashdata('hel_seqemp_cha', $hel_seqemp_cha);
            $this->session->set_flashdata('hel_seqcon_cha', $hel_seqcon_cha);
            $this->session->set_flashdata('hel_seqconde_cha', $hel_seqconde_cha);
            $this->session->set_flashdata('hel_seqconpara_cha', $hel_seqconpara_cha);
            $this->session->set_flashdata('hel_seqconsolicitante_cha', $hel_seqconsolicitante_cha);
        }

        return !$erros;
    }

    private function testarApagar($hel_pk_seq_cha) {
        $erros = FALSE;
        $mensagem = null;

        if ($this->ItemChamadoModel->getChamadoItem($hel_pk_seq_cha)) {
            $erros = TRUE;
            $mensagem = " - Chamado com item(ns) aberto(s) .\n";
        }

        if ($this->ItemOrdemServicoModel->getChamadoOrdemServico($hel_pk_seq_cha)) {
            $erros = TRUE;
            $mensagem = " - Ordem de Serviço para este chamado .\n";
        }

        $resultado = $this->ChamadoModel->get($hel_pk_seq_cha);

        if ($resultado->hel_status_cha == 1) {
            $erros = TRUE;
            $mensagem .= "- Chamado já encerrado.\n";
        }

        if ($erros) {
            $this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
            $this->session->set_flashdata('erro', nl2br($mensagem));
        }

        return !$erros;
    }

    private function carregarDadosFlash(&$dados) {
        $ERRO_HEL_CHA = $this->session->flashdata('ERRO_HEL_CHA');
        $ERRO_HEL_SEQEMP_CHA = $this->session->flashdata('ERRO_HEL_SEQEMP_CHA');
        $ERRO_HEL_SEQCON_CHA = $this->session->flashdata('ERRO_HEL_SEQCON_CHA');
        $ERRO_HEL_SEQCONDE_CHA = $this->session->flashdata('ERRO_HEL_SEQCONDE_CHA');
        $ERRO_HEL_SEQCONPARA_CHA = $this->session->flashdata('ERRO_HEL_SEQCONPARA_CHA');
        $ERRO_HEL_STATUS_CHA = $this->session->flashdata('ERRO_HEL_STATUS_CHA');

        $hel_seqemp_cha = $this->session->flashdata('hel_seqemp_cha');
        $hel_seqcon_cha = $this->session->flashdata('hel_seqcon_cha');
        $hel_seqconde_cha = $this->session->flashdata('hel_seqconde_cha');
        $hel_seqconpara_cha = $this->session->flashdata('hel_seqconpara_cha');
        $hel_status_cha = $this->session->flashdata('hel_status_cha');
        $hel_seqconsolicitante_cha = $this->session->flashdata('hel_seqconsolicitante_cha');
        $this->carregarSolicitante($dados);

        if ($ERRO_HEL_CHA) {
            $dados['hel_seqemp_cha'] = $hel_seqemp_cha;
            $dados['hel_seqcon_cha'] = $this->session->userdata('hel_tipo_tco') != 0 ? $this->session->userdata('hel_pk_seq_con') : '';
            $dados['hel_seqconde_cha'] = $hel_seqconde_cha;
            $dados['hel_seqconpara_cha'] = $hel_seqconpara_cha;
            $dados['hel_status_cha'] = $hel_status_cha;
            $dados['hel_seqconsolicitante_cha'] = $hel_seqconsolicitante_cha;
            $dados['hel_hiddenseqconde_cha'] = $this->session->userdata('hel_tipo_tco') != 0 ? 'hidden' : '';
            $dados['hel_hiddenseqconpara_cha'] = $this->session->userdata('hel_tipo_tco') != 0 ? 'hidden' : '';
            $dados['hel_checkedencerrado_cha'] = empty($hel_status_cha) ? '' : 'checked="checked"';
            $dados['hel_disabledencerrado_cha'] = 'disabled="disabled"';
            $dados['hel_seqconsolicitante_cha'] = $hel_seqconsolicitante_cha;
            $this->carregarSolicitante($dados);

            $dados['ERRO_HEL_SEQEMP_CHA'] = $ERRO_HEL_SEQEMP_CHA;
            $dados['ERRO_HEL_SEQCON_CHA'] = $ERRO_HEL_SEQCON_CHA;
            $dados['ERRO_HEL_SEQCONDE_CHA'] = $ERRO_HEL_SEQCONDE_CHA;
            $dados['ERRO_HEL_SEQCONPARA_CHA'] = $ERRO_HEL_SEQCONPARA_CHA;
            $dados['ERRO_HEL_STATUS_CHA'] = $ERRO_HEL_STATUS_CHA;
        }
    }

    private function consultarBanco($consulta) {
        $result = $this->db->query($consulta);
        return $result->result();
    }

    public function relatorio($order_by, $layout, $filtro_chamado, $filtro_empresa, $status) {
        $order_by = str_replace("%20", " ", $order_by);
        $clasuraWhere = "";
        $whereAnd = " WHERE ";
        $where_item_chamado = "";

        $arquivo = $layout == 1 ? "report/report_sintetico_chamado" : "report/report_chamado";

        if($status == 1){
            $where_item_chamado = ' AND hel_encerrado_ios = 0 ';
        }else if ($status == 2){
            $where_item_chamado = ' AND hel_encerrado_ios = 1 ';
        }

        $where_item_chamado .= ' ORDER BY hel_pk_seq_ios ';

        if (!empty($status)) {
            $clasuraWhere .= $status == 1 ? $whereAnd . " hel_status_cha = 0 " : $whereAnd . " hel_status_cha = 1 ";
            $whereAnd = " AND ";
        }

        if (!empty($filtro_empresa)) {
            $clasuraWhere .= $whereAnd . " hel_pk_seq_emp IN (" . $filtro_empresa . ")";
            $whereAnd = " AND ";
        }

        if (!empty($filtro_chamado)) {
            $clasuraWhere .= $whereAnd . " hel_pk_seq_cha IN (" . $filtro_chamado . ")";
            $whereAnd = " AND ";
        }

        global $consulta;
        $consulta = " SELECT hel_pk_seq_cha,
						     hel_nomefantasia_emp,
						     solicitante.hel_nome_con as solicitante_nome,
						     de.hel_nome_con as de_nome,
						     para.hel_nome_con as para_nome,
						     hel_horarioabertura_cha,
						     hel_status_cha,
							 CASE hel_status_cha WHEN 0 THEN DATEDIFF(NOW(), hel_horarioabertura_cha)
						     WHEN 1 THEN '0'
						     else 'Contacte a Info Rio'
						     end as hel_dias_cha,
						     ((SELECT COUNT(*) FROM heltbios WHERE hel_tipo_ios = " . CHAMADO . " AND hel_seqcha_ios = hel_pk_seq_cha AND hel_encerrado_ios = 1) / (SELECT COUNT(*) FROM heltbios WHERE " . CHAMADO . " AND hel_seqcha_ios = hel_pk_seq_cha) ) * 100 as hel_percentual_cha
					  FROM heltbcha
					  LEFT JOIN heltbexc         	     ON hel_pk_seq_exc      	    = hel_seqexc_cha
					  LEFT JOIN heltbemp         	     ON hel_pk_seq_emp              = hel_seqemp_exc
					  LEFT JOIN heltbcon as solicitante  ON solicitante.hel_pk_seq_con  = hel_seqcon_exc
					  LEFT JOIN heltbcon as de           ON de.hel_pk_seq_con   	    = hel_seqconde_cha
					  LEFT JOIN heltbcon as para 	     ON para.hel_pk_seq_con	        = hel_seqconpara_cha " . $clasuraWhere . $order_by;

        $dados_relatorio = $this->consultarBanco($consulta);
        $dados['BLC_RELATORIO'] = array();
        $dados['BLC_RELATORIO_ITENS_CHAMADO'] = array();

        if ($dados_relatorio) {
            foreach ($dados_relatorio as $registro) {
                $dados['BLC_RELATORIO'][] = array(
                    "hel_pk_seq_cha" => $registro->hel_pk_seq_cha,
                    "hel_nomefantasia_emp" => $registro->hel_nomefantasia_emp,
                    "hel_horarioabertura_cha" => $this->util->formatarDateTime($registro->hel_horarioabertura_cha),
                    "hel_solicitantenome_cha" => $registro->solicitante_nome,
                    "hel_status_cha" => empty($registro->hel_status_cha) ? 'Aberto' : 'Encerrado',
                    "hel_dias_cha" => $registro->hel_dias_cha,
                    "hel_percentual_cha" => number_format($registro->hel_percentual_cha,2),
                    "hel_abertopor_cha" => $registro->de_nome,
                    "hel_abertopara_cha" => $registro->para_nome,
                );
            }

            $dados['BLC_RELATORIO_HEADER'][] = array(
                "report_caminho_imagem" => base_url("assets/images/logo.png"),
                "report_titulo" => 'Relatório de Chamado',
                "report_modulo" => 'HelpDesk',
                "report_codigo" => 'HELPR601',
                "report_pagina" => 'Página {PAGENO} de {nbpg}',
            );

            $html = ' <html>
							<head>
								<link rel="stylesheet" type="text/css" href="' . base_url("assets/stylesheets/bootstrap.min.css") . '">
								<link rel="stylesheet" type="text/css" href="' . base_url("assets/stylesheets/bootstrap-grid.min.css") . '">
								<link rel="stylesheet" type="text/css" href="' . base_url("assets/stylesheets/estilo.css") . '">
							</head>
							<body class="layout-relatorio"> ';

            $header = $this->parser->parse('report/report_header_padrao', $dados);

            for ($i = 0; $i < count($dados['BLC_RELATORIO']); $i++) {
                $html .= $this->parser->parse($arquivo, $dados['BLC_RELATORIO'][$i]);

                $select_item_chamado = ' SELECT hel_pk_seq_ios,
                                                hel_desc_ser,
                                                hel_desc_sis,
                                                hel_nome_con,
                                                hel_horaricioencerrado_ios,
                                                hel_complemento_ios,
                                                hel_solucao_ios,
                                                hel_seqioscha_ios
                                          FROM heltbios
                                          LEFT JOIN heltbser ON hel_pk_seq_ser = hel_seqser_ios
                                          LEFT JOIN heltbsis ON hel_pk_seq_sis = hel_seqsis_ios
                                          LEFT JOIN heltbcon ON hel_pk_seq_con = hel_seqcontec_ios
                                          WHERE hel_seqcha_ios = ' . $dados['BLC_RELATORIO'][$i]['hel_pk_seq_cha'] . '
                                            AND hel_tipo_ios   = ' . CHAMADO.''.$where_item_chamado ;

                $resultado = $this->consultarBanco($select_item_chamado);

                    if ($resultado) {
                        $dados['BLC_RELATORIO_ITENS_CHAMADO'] = array();
                        foreach ($resultado as $registro) {
                            $dados['BLC_RELATORIO_ITENS_CHAMADO'][] = array(
                                "hel_pk_seq_ios" => $registro->hel_pk_seq_ios,
                                "hel_desc_ser" => $registro->hel_desc_ser,
                                "hel_desc_sis" => $registro->hel_desc_sis,
                                "hel_nome_con" => $registro->hel_nome_con,
                                "hel_complemento_ios" => $registro->hel_complemento_ios,
                                "hel_solucao_ios" => $registro->hel_solucao_ios,
                                "hel_horaricioencerrado_ios" => $this->util->formatarDateTime($registro->hel_horaricioencerrado_ios),
                                "hel_seqioscha_ios" => $registro->hel_seqioscha_ios,
                            );
                        }
                    }

                $html .= $this->parser->parse('report/report_item_chamado', $dados);

            }

            $footer = $_SERVER['HTTP_HOST'] . '|Página {PAGENO} de {nbpg}|' . date('d/m/Y H:i:s');

            $html .= '        </body>
                            </head>
						 </html> ';

            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->setAutoTopMargin = 'stretch';
            $pdf->SetHTMLHeader($header);
            $pdf->SetFooter($footer);
            $pdf->WriteHTML($html);
            $pdf->Output();

            // $this->jasper->gerar_relatorio($arquivo, $consulta, $filtros, $consulta_sub);
        } else {
            $mensagem = "- Nenhum chamado foi encontrado.\n";
            $this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
            $this->session->set_flashdata('erro', nl2br($mensagem));
            redirect('erro_relatorio');
        }
    }

}