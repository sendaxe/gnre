<?php

namespace App\Http\Controllers;

use Sped\Gnre\Sefaz\Lote;
use Sped\Gnre\Sefaz\Guia;
use Sped\Gnre\Sefaz\Consulta;
use Sped\Gnre\Parser\SefazRetorno;
use Sped\Gnre\Parser\Util;
use Sped\Gnre\Configuration\GnreSetup;
use Sped\Gnre\Webservice\Connection;

class Lotes extends Controller {

    private $util;

    public function __construct() {
        parent::__construct();
        $this->util = new Util();
    }

    public function enviar() {
        $config = new GnreSetup;
        $lotes = app('db')->select("SELECT lote.id FROM senda.com_03_02_01_a10 lote WHERE status = ? AND tipo = 'PORTAL'", [STATUS_INCLUIDO]);
        foreach ($lotes as $key => $valLote) {
            $lote = new Lote();
            if (env('CONFIG_ENVIRONMENT') == '2') {
                $lote->utilizarAmbienteDeTeste(true);
            }

            $guias = app('db')->select("SELECT guia.* FROM senda.com_03_02_01_a10_a1 guia WHERE guia.id_lote = ?", [$valLote->id]);
            foreach ($guias as $key => $valGuia) {
                $guia = new Guia();
                if ($guia->verifyProperty('c01_UfFavorecida') && isset($valGuia->c01_UfFavorecida)) {
                    $guia->__set('c01_UfFavorecida', $valGuia->c01_UfFavorecida);
                }
                if ($guia->verifyProperty('c02_receita') && isset($valGuia->c02_receita)) {
                    $guia->__set('c02_receita', $valGuia->c02_receita);
                }
                if ($guia->verifyProperty('c25_detalhamentoReceita') && isset($valGuia->c25_detalhamentoReceita)) {
                    $guia->__set('c25_detalhamentoReceita', $valGuia->c25_detalhamentoReceita);
                }
                if ($guia->verifyProperty('c27_tipoIdentificacaoEmitente') && isset($valGuia->c27_tipoIdentificacaoEmitente)) {
                    $guia->__set('c27_tipoIdentificacaoEmitente', $valGuia->c27_tipoIdentificacaoEmitente);
                }
                if ($guia->verifyProperty('c03_idContribuinteEmitente') && isset($valGuia->c03_idContribuinteEmitente)) {
                    $guia->__set('c03_idContribuinteEmitente', $valGuia->c03_idContribuinteEmitente);
                }
                if ($guia->verifyProperty('c28_tipoDocOrigem') && isset($valGuia->c28_tipoDocOrigem)) {
                    $guia->__set('c28_tipoDocOrigem', $valGuia->c28_tipoDocOrigem);
                }
                if ($guia->verifyProperty('c04_docOrigem') && isset($valGuia->c04_docOrigem)) {
                    $guia->__set('c04_docOrigem', $valGuia->c04_docOrigem);
                }
                if ($guia->verifyProperty('c06_valorPrincipal') && isset($valGuia->c06_valorPrincipal)) {
                    $guia->__set('c06_valorPrincipal', $valGuia->c06_valorPrincipal);
                }
                if ($guia->verifyProperty('c10_valorTotal') && isset($valGuia->c10_valorTotal)) {
                    $guia->__set('c10_valorTotal', $valGuia->c10_valorTotal);
                }
                if ($guia->verifyProperty('c14_dataVencimento') && isset($valGuia->c14_dataVencimento)) {
                    $guia->__set('c14_dataVencimento', $valGuia->c14_dataVencimento);
                }
                if ($guia->verifyProperty('c16_razaoSocialEmitente') && isset($valGuia->c16_razaoSocialEmitente)) {
                    $guia->__set('c16_razaoSocialEmitente', $valGuia->c16_razaoSocialEmitente);
                }
                if ($guia->verifyProperty('c17_inscricaoEstadualEmitente') && isset($valGuia->c17_inscricaoEstadualEmitente)) {
                    $guia->__set('c17_inscricaoEstadualEmitente', $valGuia->c17_inscricaoEstadualEmitente);
                }
                if ($guia->verifyProperty('c18_enderecoEmitente') && isset($valGuia->c18_enderecoEmitente)) {
                    $guia->__set('c18_enderecoEmitente', $valGuia->c18_enderecoEmitente);
                }
                if ($guia->verifyProperty('c19_municipioEmitente') && isset($valGuia->c19_municipioEmitente)) {
                    $guia->__set('c19_municipioEmitente', $valGuia->c19_municipioEmitente);
                }
                if ($guia->verifyProperty('c20_ufEnderecoEmitente') && isset($valGuia->c20_ufEnderecoEmitente)) {
                    $guia->__set('c20_ufEnderecoEmitente', $valGuia->c20_ufEnderecoEmitente);
                }
                if ($guia->verifyProperty('c21_cepEmitente') && isset($valGuia->c21_cepEmitente)) {
                    $guia->__set('c21_cepEmitente', $valGuia->c21_cepEmitente);
                }
                if ($guia->verifyProperty('c22_telefoneEmitente') && isset($valGuia->c22_telefoneEmitente)) {
                    $guia->__set('c22_telefoneEmitente', $valGuia->c22_telefoneEmitente);
                }
                if ($guia->verifyProperty('c34_tipoIdentificacaoDestinatario') && isset($valGuia->c34_tipoIdentificacaoDestinatario)) {
                    $guia->__set('c34_tipoIdentificacaoDestinatario', $valGuia->c34_tipoIdentificacaoDestinatario);
                }
                if (isset($valGuia->c35_idContribuinteDestinatario) && isset($valGuia->c35_idContribuinteDestinatario)) {
                    $guia->__set('c35_idContribuinteDestinatario', $valGuia->c35_idContribuinteDestinatario);
                }
                if ($guia->verifyProperty('c37_razaoSocialDestinatario') && isset($valGuia->c37_razaoSocialDestinatario)) {
                    $guia->__set('c37_razaoSocialDestinatario', $valGuia->c37_razaoSocialDestinatario);
                }
                if ($guia->verifyProperty('c38_municipioDestinatario') && isset($valGuia->c38_municipioDestinatario)) {
                    $guia->__set('c38_municipioDestinatario', $valGuia->c38_municipioDestinatario);
                }
                if ($guia->verifyProperty('c33_dataPagamento') && isset($valGuia->c33_dataPagamento)) {
                    $guia->__set('c33_dataPagamento', $valGuia->c33_dataPagamento);
                }
                if ($guia->verifyProperty('periodo') && isset($valGuia->c05_referencia) && isset($valGuia->c05_referencia->periodo)) {
                    $guia->__set('periodo', $valGuia->c05_referencia->periodo);
                }
                if ($guia->verifyProperty('mes') && isset($valGuia->c05_referencia) && isset($valGuia->c05_referencia->mes)) {
                    $guia->__set('mes', $valGuia->c05_referencia->mes);
                }
                if ($guia->verifyProperty('ano') && isset($valGuia->c05_referencia) && isset($valGuia->c05_referencia->ano)) {
                    $guia->__set('ano', $valGuia->c05_referencia->ano);
                }
                if ($guia->verifyProperty('parcela') && isset($valGuia->c05_referencia) && isset($valGuia->c05_referencia->parcela)) {
                    $guia->__set('parcela', $valGuia->c05_referencia->parcela);
                }
                if ($guia->verifyProperty('c39_camposExtras') && isset($valGuia->c39_camposExtras)) {
                    $arrCampoExtra = [];
                    foreach (json_decode($valGuia->c39_camposExtras) as $key => $val) {
                        if (isset($val->codigo) && isset($val->tipo) && isset($val->valor)) {
                            $arrCampoExtra[] = [
                                'campoExtra' => [
                                    'codigo' => $val->codigo,
                                    'tipo' => $val->tipo,
                                    'valor' => $val->valor
                                ]
                            ];
                        }
                    }
                    if (count($arrCampoExtra) > 0) {
                        $guia->__set('c39_camposExtras', $arrCampoExtra);
                    }
                }
                $lote->addGuia($guia);
            }
            $webService = new Connection($config, $lote->getHeaderSoap(), $lote->toXml());
            $soapResponse = $webService->doRequest($lote->soapAction());
            $soapResponse = str_replace(['ns1:'], [], $soapResponse);
            $arrRetorno = [
                'id' => $valLote->id,
                'ambiente' => $this->util->getTag($soapResponse, 'ambiente'),
                'status' => STATUS_ENVIADO,
                'codigo' => $this->util->getTag($soapResponse, 'codigo'),
                'descricao' => html_entity_decode($this->util->getTag($soapResponse, 'descricao')),
                'reciboNumero' => $this->util->getTag($soapResponse, 'numero'),
                'reciboDataHora' => $this->util->getTag($soapResponse, 'dataHoraRecibo'),
                'reciboTempoProcessamento' => $this->util->getTag($soapResponse, 'tempoEstimadoProc')
            ];
            //print '<pre>'; var_dump($arrRetorno);
            if ($arrRetorno['codigo'] != 100 || empty($arrRetorno['reciboNumero'])) {
                $arrRetorno['status'] = STATUS_FALHA;
            }
            app('db')->update("UPDATE senda.com_03_02_01_a10 SET ambiente=?,status=?,recepcao_codigo=?,recepcao_descricao=?, recibo_numero=?, recibo_data_hora=?, recibo_tempo_processamento=? WHERE id=?", [
                $arrRetorno['ambiente'],
                $arrRetorno['status'],
                $arrRetorno['codigo'],
                $arrRetorno['descricao'],
                $arrRetorno['reciboNumero'],
                $arrRetorno['reciboDataHora'],
                $arrRetorno['reciboTempoProcessamento'],
                $arrRetorno['id']
            ]);
            echo '<pre>';
            print_r($arrRetorno);
            echo '</pre> <br/> <a href="../dashboard">Voltar</a>';
            return;
        }
        echo '<h3>Todos os lotes já foram enviados</h3> <br/> <a href="../dashboard">Voltar</a>';
        return;
    }

    public function consultar() {
        $config = new GnreSetup;
        $lotes = app('db')->select("SELECT lote.* FROM senda.com_03_02_01_a10 lote WHERE status = ? AND tipo = 'PORTAL'", [STATUS_ENVIADO]);
        foreach ($lotes as $key => $valLote) {
            $consulta = new Consulta();
            $consulta->setRecibo($valLote->recibo_numero);
            $consulta->setEnvironment($valLote->ambiente);
            if ($valLote->ambiente == '2') {
                $consulta->utilizarAmbienteDeTeste(true);
            }
            $webService = new Connection($config, $consulta->getHeaderSoap(), $consulta->toXml());
            $soapResponse = $webService->doRequest($consulta->soapAction());
            $soapResponse = str_replace(['ns1:'], [], $soapResponse);
            $this->util = new Util();
            $arrRetorno = [
                'id' => $valLote->id,
                'ambiente' => $this->util->getTag($soapResponse, 'ambiente'),
                'codigo' => $this->util->getTag($soapResponse, 'codigo'),
                'descricao' => html_entity_decode($this->util->getTag($soapResponse, 'descricao')),
                'resultado' => html_entity_decode($this->util->getTag($soapResponse, 'resultado')),
            ];

            app('db')->update("UPDATE senda.com_03_02_01_a10 SET retorno_ambiente=?,retorno_codigo=?,retorno_descricao=?,retorno_resultado=? WHERE id=?", [
                $arrRetorno['ambiente'],
                $arrRetorno['codigo'],
                $arrRetorno['descricao'],
                $arrRetorno['resultado'],
                $arrRetorno['id']
            ]);
        }
        echo '<pre>';
        print_r($arrRetorno);
        echo '</pre> <br/> <a href="../dashboard">Voltar</a>';
        return;
    }

    public function consultarRecibo($numero) {
        $config = new GnreSetup;
        $consulta = new Consulta();
        $consulta->setRecibo($numero);
        $consulta->setEnvironment($config->getEnvironment());
        $consulta->utilizarAmbienteDeTeste($config->getEnvironment());
        header('Content-Type: text/xml');
        $webService = new Connection($config, $consulta->getHeaderSoap(), $consulta->toXml());
        return $webService->doRequest($consulta->soapAction());
    }

}
