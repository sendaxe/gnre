<?php

namespace App\Http\Controllers;

use Sped\Gnre\Sefaz\Guia;
use Sped\Gnre\Sefaz\Lote;
use Sped\Gnre\Render\Html;
use Sped\Gnre\Render\Pdf;
use Illuminate\Support\Facades\Storage;
use Sped\Gnre\Parser\Util;

class GerarGuias extends ControllerLotes {

    protected $mensagens;

    public function __construct() {
        parent::__construct();
        $this->mensagens = [];
    }

    public function pdfLotes($id_empresa) {
        $this->getEmpresaById($id_empresa);
        $this->mensagens = [];
        $lotes = app('db')->select("SELECT lote.id, ambiente FROM senda.com_03_02_01_a10 lote WHERE status = ? AND tipo = 'PORTAL' AND cnpj = ?", [STATUS_PROCESSADO, str_replace(['/', '.', '-'], [], $this->getEmpresa()->cnpj)]);
        foreach ($lotes as $key => $valLote) {
            $this->mensagens[] = ['mensagem' => 'LOTE: ' . $valLote->id];
            $this->pdfGuia($id_empresa, $valLote->id);
            $aux = $this->getNotificacoesLote($valLote->id);
            foreach ($aux as $row) {
                $this->mensagens[] = ['mensagem' => "{$row->tipo_mensagem}: {$row->codigo} - {$row->mensagem}"];
            }
            $this->mensagens[] = ['mensagem' => '-------------------------------------------------------'];
        }
        if (count($lotes) == 0) {
            $this->mensagens[] = ['mensagem' => 'Nenhum registro disponível para geração de guia.'];
        }else{
            $this->mensagens[] = ['mensagem' => 'CONCLUÍDO GERAÇÃO DAS GUIAS'];
        }
        return view('lotes', [
            'empresa' => $this->getEmpresaById($id_empresa),
            'mensagens' => $this->mensagens
        ]);
    }

    public function pdfGuia($id_empresa, $id) {
        $this->getEmpresaById($id_empresa);

        require app()->basePath() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'dompdf' . DIRECTORY_SEPARATOR . 'dompdf' . DIRECTORY_SEPARATOR . 'dompdf_config.inc.php';

        $lotes = app('db')->select("SELECT lote.id, ambiente FROM senda.com_03_02_01_a10 lote WHERE id = ? AND status = ? AND tipo = 'PORTAL' AND cnpj = ?", [$id, STATUS_PROCESSADO, str_replace(['/', '.', '-'], [], $this->getEmpresa()->cnpj)]);
        foreach ($lotes as $key => $valLote) {
            $guias = app('db')->select("
                    SELECT env.*, ret.informacoes_complementares, ret.atualizacao_monetaria, ret.numero_controle, ret.codigo_barras, ret.representacao_numerica, ret.juros, ret.multa
                    FROM senda.com_03_02_01_a10_a2 ret
                    LEFT JOIN senda.com_03_02_01_a10_a1 env ON (env.id_lote = ret.id_lote AND env.sequencial = ret.sequencial_guia)
                    WHERE ret.id IN (
                            SELECT MAX(g2.id) AS id
                            FROM senda.com_03_02_01_a10_a2 g2
                            WHERE g2.id_lote = ?
                            GROUP BY g2.id_lote, g2.sequencial_guia
                    )", [$valLote->id]
            );
            $rowLote = app('db')->select("SELECT lote.* FROM senda.com_03_02_01_a10 lote WHERE id = ? ", [$valLote->id]);
            foreach ($rowLote as $key => $val) {
                $rowLote = $val;
                break;
            }
            if (empty($rowLote)) {
                return;
            }
            app('db')->insert("INSERT INTO senda.com_03_02_01_a10_a3(id_lote,id_nf,codigo,usuario,ip_usuario,destino,timeout,autoclose) VALUES (?,?,?,?,?,?,?,?) RETURNING id", [
                Util::getValue($valLote->id),
                Util::getValue($rowLote->id_nf),
                AVISO_GUIA,
                $rowLote->usuario_inc,
                $rowLote->ip_usuario_inc,
                AVISO_DESTINO_POPUP,
                1000,
                'T'
            ]);
            $lote = new Lote();
            //echo "<pre>";
            foreach ($guias as $key => $valGuia) {
                //print_r($valGuia);
                $guia = new Guia();
                $guia->c01_UfFavorecida = $valGuia->c01_UfFavorecida;
                $guia->c02_receita = $valGuia->c02_receita;
                $guia->c25_detalhamentoReceita = $valGuia->c25_detalhamentoReceita;
                $guia->c26_produto = $valGuia->c26_produto;
                $guia->c27_tipoIdentificacaoEmitente = $valGuia->c27_tipoIdentificacaoEmitente;
                $guia->c03_idContribuinteEmitente = $valGuia->c03_idContribuinteEmitente;
                $guia->c28_tipoDocOrigem = $valGuia->c28_tipoDocOrigem;
                $guia->c04_docOrigem = $valGuia->c04_docOrigem;
                $guia->c06_valorPrincipal = $valGuia->c06_valorPrincipal;
                $guia->c10_valorTotal = $valGuia->c10_valorTotal;
                $guia->c14_dataVencimento = Util::convertDateDB($valGuia->c14_dataVencimento);
                $guia->c15_convenio = $valGuia->c15_convenio;
                $guia->c16_razaoSocialEmitente = $valGuia->c16_razaoSocialEmitente;
                $guia->c17_inscricaoEstadualEmitente = $valGuia->c17_inscricaoEstadualEmitente;
                $guia->c18_enderecoEmitente = $valGuia->c18_enderecoEmitente;
                $guia->c19_municipioEmitente = $valGuia->c19_municipioEmitente;
                $guia->c20_ufEnderecoEmitente = $valGuia->c20_ufEnderecoEmitente;
                $guia->c21_cepEmitente = $valGuia->c21_cepEmitente;
                $guia->c22_telefoneEmitente = $valGuia->c22_telefoneEmitente;
                $guia->c34_tipoIdentificacaoDestinatario = $valGuia->c34_tipoIdentificacaoDestinatario;
                $guia->c35_idContribuinteDestinatario = $valGuia->c35_idContribuinteDestinatario;
                $guia->c36_inscricaoEstadualDestinatario = $valGuia->c36_inscricaoEstadualDestinatario;
                $guia->c37_razaoSocialDestinatario = $valGuia->c37_razaoSocialDestinatario;
                $guia->c38_municipioDestinatario = $valGuia->c38_municipioDestinatario;
                $guia->c33_dataPagamento = Util::convertDateDB($valGuia->c33_dataPagamento);
                $guia->retornoInformacoesComplementares = $valGuia->informacoes_complementares;
                $guia->retornoAtualizacaoMonetaria = $valGuia->atualizacao_monetaria;
                $guia->retornoNumeroDeControle = $valGuia->numero_controle;
                $guia->retornoCodigoDeBarras = $valGuia->codigo_barras;
                $guia->retornoRepresentacaoNumerica = $valGuia->representacao_numerica;
                $guia->retornoJuros = $valGuia->juros;
                $guia->retornoMulta = $valGuia->multa;
                $guia->mes = $valGuia->c05_referencia_mes;
                $guia->ano = $valGuia->c05_referencia_ano;
                $guia->parcela = $valGuia->c05_referencia_parcela;
                $guia->periodo = $valGuia->c05_referencia_periodo;
                $lote->addGuia($guia);
            }
            $html = new Html();
            $html->create($lote);

            $pdf = new Pdf();
            if (!file_exists($this->getEmpresa()->gnre_pasta_guias)) {
                mkdir($this->getEmpresa()->gnre_pasta_guias, 0777, true);
            }
            if (file_exists($this->getEmpresa()->gnre_pasta_guias)) {
                //gerar na tela
                //$pdf->create($html)->stream('gnre.pdf', ['Attachment' => 0]);
                //gerar no arquivo
                $valNF = app('db')->select('SELECT nf.numero_nf FROM senda.com_03_02_01 nf WHERE nf.id = (SELECT lote.id_nf FROM senda.com_03_02_01_a10 lote WHERE lote.id = ?)', [$valLote->id]);
                foreach ($valNF as $key => $row) {
                    $valNF = $row;
                }
                $pdf->create($html, $this->getEmpresa()->gnre_pasta_guias . DIRECTORY_SEPARATOR . "{$valLote->id}_{$valNF->numero_nf}.pdf");
                if (file_exists($this->getEmpresa()->gnre_pasta_guias . DIRECTORY_SEPARATOR . "{$valLote->id}_{$valNF->numero_nf}.pdf")) {
                    app('db')->update("UPDATE senda.com_03_02_01_a10 SET status=? WHERE id=?", [STATUS_GUIAGERADA, $valLote->id]);
                    app('db')->insert("INSERT INTO senda.com_03_02_01_a10_a3(id_lote,id_nf,codigo,usuario,ip_usuario,destino,timeout,autoclose) VALUES (?,?,?,?,?,?,?,?) RETURNING id", [
                        Util::getValue($valLote->id),
                        Util::getValue($rowLote->id_nf),
                        AVISO_GUIA_OK,
                        $rowLote->usuario_inc,
                        $rowLote->ip_usuario_inc,
                        AVISO_DESTINO_POPUP,
                        5000,
                        'F'
                    ]);
                    $this->mensagens[] = ['mensagem' => 'Guia Gerada em: ' . $this->getEmpresa()->gnre_pasta_guias . DIRECTORY_SEPARATOR . "{$valLote->id}_{$valNF->numero_nf}.pdf"];
                } else {
                    app('db')->insert("INSERT INTO senda.com_03_02_01_a10_a3(id_lote,id_nf,codigo,usuario,ip_usuario,destino,timeout,autoclose) VALUES (?,?,?,?,?,?,?,?) RETURNING id", [
                        Util::getValue($valLote->id),
                        Util::getValue($rowLote->id_nf),
                        AVISO_GUIA_FALHA,
                        $rowLote->usuario_inc,
                        $rowLote->ip_usuario_inc,
                        AVISO_DESTINO_POPUP,
                        5000,
                        'F'
                    ]);
                    $this->mensagens[] = ['mensagem' => 'Falha ao gerar arquivo em: ' . $this->getEmpresa()->gnre_pasta_guias . DIRECTORY_SEPARATOR . "{$valLote->id}_{$numero_nf}.pdf"];
                }
            } else {
                $this->mensagens[] = ['mensagem' => 'Pasta para geração de arquivos PDF não definida ou inexistente nos parâmetros de configuração.'];
            }
        }
    }

}
