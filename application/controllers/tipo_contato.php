<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tipo_Contato extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->layout = LAYOUT_DASHBOARD;

        $this->load->model('Tipo_Contato_Model', 'Tipo_ContatoModel');
        $this->load->model('Contato_Model', 'ContatoModel');

        if ($this->util->autorizacao($this->session->userdata('hel_tipo_tco'))) {
            redirect('');
        }
    }


    public function index() {
        $dados = array();

        $dados['NOVO_TIPO_CONTATO'] = site_url('tipo_contato/novo');

        $dados['BLC_DADOS'] = array();

        $this->carregarDados($dados);

        $this->parser->parse('tipo_contato_consulta', $dados);
    }

    public function novo() {
        $dados = array();
        $dados['hel_pk_seq_tco'] = 0;
        $dados['hel_desc_tco'] = '';
        $dados['hel_tipo_tco'] = 0;

        $dados['ACAO'] = 'Novo';

        $this->setarURL($dados);

        $this->carregarDadosFlash($dados);

        $this->parser->parse('tipo_contato_cadastro', $dados);
    }

    public function editar($hel_pk_seq_tco) {
        $hel_pk_seq_tco = base64_decode($hel_pk_seq_tco);
        $dados = array();

        $this->carregarTipo_Contato($hel_pk_seq_tco, $dados);

        $this->carregarDadosFlash($dados);

        $dados['ACAO'] = 'Editar';

        $this->setarURL($dados);


        $this->parser->parse('tipo_contato_cadastro', $dados);
    }

    public function salvar() {
        global $hel_pk_seq_tco;
        global $hel_desc_tco;
        global $hel_tipo_tco;

        $hel_pk_seq_tco = $this->input->post('hel_pk_seq_tco');
        $hel_desc_tco = $this->input->post('hel_desc_tco');
        $hel_tipo_tco = $this->input->post('hel_tipo_tco');

        if ($this->testarDados()) {
            $tipo_contato = array(
                "hel_desc_tco" => $hel_desc_tco,
                "hel_tipo_tco" => $hel_tipo_tco
            );

            if (!$hel_pk_seq_tco) {
                $hel_pk_seq_tco = $this->Tipo_ContatoModel->insert($tipo_contato);
            } else {
                $hel_pk_seq_tco = $this->Tipo_ContatoModel->update($tipo_contato, $hel_pk_seq_tco);
            }

            if (is_numeric($hel_pk_seq_tco)) {
                $this->session->set_flashdata('sucesso', 'Tipo de Contato salvo com sucesso.');
                redirect('tipo_contato');
            } else {
                $this->session->set_flashdata('erro', $hel_pk_seq_tco);
                redirect('tipo_contato');
            }
        } else {
            if (!$hel_pk_seq_tco) {
                redirect('tipo_contato/novo/');
            } else {
                redirect('tipo_contato/editar/' . base64_encode($hel_pk_seq_tco));
            }
        }
    }

    public function apagar($hel_pk_seq_tco) {

        if ($this->testarApagar(base64_decode($hel_pk_seq_tco))) {
            $res = $this->Tipo_ContatoModel->delete(base64_decode($hel_pk_seq_tco));
            if ($res) {
                $this->session->set_flashdata('sucesso', 'Tipo de Contato apagado com sucesso.');
            }
        }
        redirect('tipo_contato');
    }

    private function setarURL(&$dados) {
        $dados['CONSULTA_TIPO_CONTATO'] = site_url('tipo_contato');
        $dados['ACAO_FORM'] = site_url('tipo_contato/salvar');
    }


    private function carregarDados(&$dados) {

        $resultado = $this->Tipo_ContatoModel->getTipoContato();

        foreach ($resultado as $registro) {
            $dados['BLC_DADOS'][] = array(
                "hel_desc_tco" => $registro->hel_desc_tco,
                "hel_tipo_tco" => $this->carregarTipoContato($registro->hel_tipo_tco),
                "EDITAR_TIPO_CONTATO" => 'tipo_contato/editar/' . base64_encode($registro->hel_pk_seq_tco),
                "APAGAR_TIPO_CONTATO" => "abrirConfirmacao('" . base64_encode($registro->hel_pk_seq_tco) . "')"
            );
        }
    }

    private function carregarTipoContato($hel_tipo_tco) {

        $tipo = "";

        if ($hel_tipo_tco == 0) {
            $tipo = "Técnico";
        } else if ($hel_tipo_tco == 1) {
            $tipo = "Responsável";
        } else if ($hel_tipo_tco == 2) {
            $tipo = "Outros";
        }
        return $tipo;
    }

    private function carregarTipo_Contato($hel_pk_seq_tco, &$dados) {
        $resultado = $this->Tipo_ContatoModel->get($hel_pk_seq_tco);

        if ($resultado) {
            foreach ($resultado as $chave => $valor) {
                $dados[$chave] = $valor;
            }
        } else {
            show_error('Não foram encontrados dados.', 500, 'Ops, erro encontrado');
        }

        $this->carregar_tipo_contato($dados);
    }


    private function testarDados() {
        global $hel_pk_seq_tco;
        global $hel_desc_tco;
        global $hel_tipo_tco;

        $erros = FALSE;
        $mensagem = null;

        $hel_desc_tco = trim($hel_desc_tco);

        if (empty($hel_desc_tco)) {
            $erros = TRUE;
            $mensagem .= "- Descrição não preenchida.\n";
            $this->session->set_flashdata('ERRO_HEL_DESC_TCO', 'has-error');
        }

        if ($hel_tipo_tco == '') {
            $erros = TRUE;
            $mensagem .= "- Tipo de contado não preenchido.\n";
            $this->session->set_flashdata('ERRO_HEL_TIPO_TCO', 'has-error');
        }


        if ($erros) {
            $this->session->set_flashdata('titulo_erro', 'Para continuar corrija os seguintes erros:');
            $this->session->set_flashdata('erro', nl2br($mensagem));

            $this->session->set_flashdata('ERRO_HEL_TCO', TRUE);
            $this->session->set_flashdata('hel_desc_tco', $hel_desc_tco);
            $this->session->set_flashdata('hel_tipo_tco', $hel_tipo_tco);

        }

        return !$erros;
    }

    private function testarApagar($hel_pk_seq_tco) {
        $erros = FALSE;
        $mensagem = null;

        if ($this->ContatoModel->getContatoCadastrado($hel_pk_seq_tco)) {
            $erros = TRUE;
            $mensagem .= "- Contato cadastrado.\n";
        }

        if ($erros) {
            $this->session->set_flashdata('titulo_erro', 'Para apagar corrija os seguintes erros:');
            $this->session->set_flashdata('erro', nl2br($mensagem));
        }

        return !$erros;
    }

    private function carregar_tipo_contato(&$dados) {

        switch ($dados['hel_tipo_tco']) {
            case 0:
                $dados['hel_checktecnico_tco'] = 'checked';
                break;
            case 1:
                $dados['hel_checkresponsavel_tco'] = 'checked';
                break;
            case 2:
                $dados['hel_checkoutro_tco'] = 'checked';
                break;
        }

    }

    private function carregarDadosFlash(&$dados) {
        $ERRO_HEL_TCO = $this->session->flashdata('ERRO_HEL_TCO');
        $ERRO_HEL_DESC_TCO = $this->session->flashdata('ERRO_HEL_DESC_TCO');
        $ERRO_HEL_TIPO_TCO = $this->session->flashdata('ERRO_HEL_TIPO_TCO');

        $hel_desc_tco = $this->session->flashdata('hel_desc_tco');
        $hel_tipo_tco = $this->session->flashdata('hel_tipo_tco');

        if ($ERRO_HEL_TCO) {
            $dados['hel_desc_tco'] = $hel_desc_tco;
            $dados['hel_tipo_tco'] = $hel_tipo_tco;
            if ($hel_tipo_tco != '') {
                $this->carregar_tipo_contato($dados);
            }

            $dados['ERRO_HEL_DESC_TCO'] = $ERRO_HEL_DESC_TCO;
            $dados['ERRO_HEL_TIPO_TCO'] = $ERRO_HEL_TIPO_TCO;

        }
    }

    private function gerarRelatorio() {
        global $consulta;

        $result = $this->db->query($consulta);
        return $result->result();
    }

    public function relatorio($order_by, $hel_tipo_tco) {
        $clasulaWhere = " ";
        $whereAnd = " WHERE ";
        $order_by = str_replace("%20", " ", $order_by);

        switch ($hel_tipo_tco) {
            case 0 :
                $clasulaWhere = $clasulaWhere . $whereAnd . ' hel_tipo_tco = ' . $hel_tipo_tco;
                $whereAnd = " AND ";
                break;
            case 1 :
                $clasulaWhere = $clasulaWhere . $whereAnd . ' hel_tipo_tco = ' . $hel_tipo_tco;
                $whereAnd = " AND ";
                break;
            case 2 :
                $clasulaWhere = $clasulaWhere . $whereAnd . ' hel_tipo_tco = ' . $hel_tipo_tco;
                $whereAnd = " AND ";
                break;
        }

        global $consulta;
        $consulta = " SELECT hel_pk_seq_tco,
							 hel_desc_tco,
							 CASE hel_tipo_tco WHEN 0 THEN 'Técnico'
							  WHEN 1 THEN 'Responsável'
							  WHEN 2 THEN 'Outros'
							 end as hel_tipo_tco
						FROM heltbtco " . $clasulaWhere . " " . $order_by;

        $dados['BLC_RELATORIO'] = array();

        $dados_relatorio = $this->gerarRelatorio();

        if ($dados_relatorio) {
            foreach ($dados_relatorio as $registro) {
                $dados['BLC_RELATORIO'][] = array(
                    "hel_pk_seq_tco" => $registro->hel_pk_seq_tco,
                    "hel_desc_tco" => $registro->hel_desc_tco,
                    "hel_tipo_tco" => $registro->hel_tipo_tco
                );
            }

            $dados['BLC_RELATORIO_NUM_TOTALIZADOR'][] = array(
                "hel_numregistros_tco" => count($dados['BLC_RELATORIO'])
            );

            $dados['BLC_RELATORIO_COLUMNHEADER'][] = array(
                "hel_lb_pk_seq_tco" => 'Seq.',
                "hel_lb_desc_tco" => 'Descrição',
                "hel_lb_tipo_tco" => 'Tipo'
            );

            $header = ' <table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom;"><tr>
							<td align="left"><img src="' . base_url('assets/images/logo.png') . '" width="28%" /></td>
							<td align="center"> <h1>Relatório Tipo Contato</h1></td>
							<td style="text-align: right;"><span>HelpDesk</span><br/><span>HELPR503</span><br/><span>Página {PAGENO} de {nbpg}</span> </td>
						</table> ';

            $footer = $_SERVER['HTTP_HOST'] . '|Página {PAGENO} de {nbpg}|' . date('d/m/Y H:i:s');

            $html .= $this->parser->parse('report/report_tipo_contato', $dados);

            $this->load->library('Pdf2');
            $pdf = $this->pdf->load();
            $pdf->setAutoTopMargin = 'stretch';
            $pdf->SetHTMLHeader($header);
            $pdf->SetFooter($footer);
            $pdf->WriteHTML($html);
            $pdf->Output();
        } else {
            $mensagem = "- Nenhum Tipo de Contato foi encontrado.\n";
            $this->session->set_flashdata('titulo_erro', 'Para visualizar corrija os seguintes erros:');
            $this->session->set_flashdata('erro', nl2br($mensagem));
            redirect('erro_relatorio');
        }
    }
}