<?php

namespace App\Http\Controllers;

use Sped\Gnre\Sefaz\Guia;
use Sped\Gnre\Sefaz\Lote;
use Sped\Gnre\Render\Html;
use Sped\Gnre\Render\Pdf;
use Illuminate\Support\Facades\Storage;

class GerarGuias extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function pdfLotes() {
        $lotes = app('db')->select("SELECT lote.id, ambiente FROM senda.com_03_02_01_a10 lote WHERE status = ? AND tipo = 'PORTAL' ", [STATUS_PROCESSADO]);
        foreach ($lotes as $key => $valLote) {
            $this->pdfGuia($valLote->id);
        }
        if(count($lotes) == 0){
            echo '<h3>Nenhum registro disponível para geração</h3>';
        }
        echo '<br/> <a href="../home">Voltar</a>';
    }

    public function pdfGuia($idLote) {
        require '../vendor/dompdf/dompdf/dompdf_config.inc.php';

        $guias = app('db')->select("
                SELECT env.*, ret.informacoes_complementares, ret.atualizacao_monetaria, ret.numero_controle, ret.codigo_barras, ret.representacao_numerica, ret.juros, ret.multa
                FROM senda.com_03_02_01_a10_a2 ret
                LEFT JOIN senda.com_03_02_01_a10_a1 env ON (env.id_lote = ret.id_lote AND env.sequencial = ret.sequencial_guia)
                WHERE ret.id IN (
                        SELECT MAX(g2.id) AS id
                        FROM senda.com_03_02_01_a10_a2 g2
                        WHERE g2.id_lote = ?
                        GROUP BY g2.id_lote, g2.sequencial_guia
                )", [$idLote]
        );

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
            $guia->c14_dataVencimento = $valGuia->c14_dataVencimento;
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
            $guia->c33_dataPagamento = $valGuia->c33_dataPagamento;
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
        if (!file_exists(env('CONFIG_PDFPATH'))) {
            mkdir(env('CONFIG_PDFPATH'), 0777, true);
        }
        if (file_exists(env('CONFIG_PDFPATH'))) {
            //gerar na tela
            //$pdf->create($html)->stream('gnre.pdf', ['Attachment' => 0]);
            //gerar no arquivo
            $pdf->create($html, env('CONFIG_PDFPATH') . "/{$idLote}.pdf");
            if (file_exists(env('CONFIG_PDFPATH') . "/{$idLote}.pdf")) {
                app('db')->update("UPDATE senda.com_03_02_01_a10 SET status=? WHERE id=?", [STATUS_GUIAGERADA, $idLote]);
                echo '<h4>Guia Gerada em: ' . env('CONFIG_PDFPATH') . "/{$idLote}.pdf" . '</h4>';
            } else {
                echo '<h3>Falha ao gerar arquivo em: ' . env('CONFIG_PDFPATH') . "/{$idLote}.pdf" . '</h4>';
            }
        } else {
            echo '<h3>Pasta para geração de arquivos PDF não definida ou inexistente nos parâmetros de configuração.</h3>';
        }
    }

}
