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
        
    }

    public function pdfGuia($id) {
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
                )", [$id]
        );
        
        $lote = new Lote();
        //echo "<pre>";
        //echo "<img src='".app('url')->asset('public/img/logo-senda-m.png')."'>";
        //echo "<img src='".app('url')->asset('public/img/logo-senda-m.png')."'>";
        //Storage::disk('local')->get('public/img/logo-senda-m.png');
        //echo "<img src=\"{{ Storage::disk('local')->get('public/img/logo-senda-m.png') }}\" style=\"width:150px; height:150px; float: left; border-radius:50%; margin-right:25px; padding-top: 10px;\">";
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
        $pdf->create($html)->stream('gnre.pdf', ['Attachment' => 0]);
    }
}