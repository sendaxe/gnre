<?php

namespace App\Http\Controllers;

use Sped\Gnre\Sefaz\Lote;
use Sped\Gnre\Sefaz\Guia;
use Sped\Gnre\Sefaz\Consulta;
use Sped\Gnre\Parser\SefazRetorno;
use Sped\Gnre\Parser\Util;
use Sped\Gnre\Configuration\GnreSetup;
use Sped\Gnre\Webservice\Connection;
use App\Http\Controllers\GerarGuias;

class Lotes extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function enviar() {
        $lotes = app('db')->select("SELECT lote.id FROM senda.com_03_02_01_a10 lote WHERE status = ? AND tipo = 'PORTAL' AND cnpj = ?", [STATUS_INCLUIDO, env('CERT_CNPJ')]);
        echo '<pre>';
        foreach ($lotes as $key => $valLote) {
           $this->enviarById($valLote->id);
        }
        if (count($lotes) > 0) {
            echo '<a href="../home">Voltar</a>';
        }else{
            echo '</pre><h3>Todos os lotes já foram enviados</h3> <br/> <a href="../home">Voltar</a>';
        }
    }
    
    public function enviarById($id) {
        $config = new GnreSetup;
        $lotes = app('db')->select("SELECT lote.*, (SELECT nf.numero_nf FROM senda.com_03_02_01 nf WHERE nf.id = lote.id_nf) AS numero_nf FROM senda.com_03_02_01_a10 lote WHERE id = ? AND status = ? AND tipo = 'PORTAL' AND cnpj = ?", [$id, STATUS_INCLUIDO, env('CERT_CNPJ')]);
        foreach ($lotes as $key => $valLote) {
            $lote = new Lote();
            if ($valLote->ambiente == '2') {
                $lote->utilizarAmbienteDeTeste(true);
            }
            app('db')->insert("INSERT INTO senda.com_03_02_01_a10_a3(id_lote,id_nf,codigo,usuario,ip_usuario,destino,timeout,autoclose) VALUES (?,?,?,?,?,?,?,?) RETURNING id", [
                Util::getValue($valLote->id),
                Util::getValue($valLote->id_nf),
                AVISO_TRANSMISSAO,
                $valLote->usuario_inc,
                $valLote->ip_usuario_inc,
                AVISO_DESTINO_POPUP,
                1000,
                'T'
            ]);
            $guias = app('db')->select("SELECT guia.* FROM senda.com_03_02_01_a10_a1 guia WHERE guia.id_lote = ?", [$valLote->id]);
            foreach ($guias as $key => $valGuia) {
                $guia = new Guia();
                if (isset($valGuia->c01_UfFavorecida)) {
                    $guia->c01_UfFavorecida = $valGuia->c01_UfFavorecida;
                }
                if (isset($valGuia->c02_receita)) {
                    $guia->c02_receita = $valGuia->c02_receita;
                }
                if (isset($valGuia->c25_detalhamentoReceita)) {
                    $guia->c25_detalhamentoReceita = str_pad($valGuia->c25_detalhamentoReceita, 6, '0', STR_PAD_LEFT);
                }
                if (isset($valGuia->c26_produto)) {
                    $guia->c26_produto = $valGuia->c26_produto;
                }
                if (isset($valGuia->c27_tipoIdentificacaoEmitente)) {
                    $guia->c27_tipoIdentificacaoEmitente = $valGuia->c27_tipoIdentificacaoEmitente;
                }
                if (isset($valGuia->c03_idContribuinteEmitente)) {
                    $guia->c03_idContribuinteEmitente = $valGuia->c03_idContribuinteEmitente;
                }
                if (isset($valGuia->c28_tipoDocOrigem)) {
                    $guia->c28_tipoDocOrigem = $valGuia->c28_tipoDocOrigem;
                }
                if (isset($valGuia->c04_docOrigem)) {
                    $guia->c04_docOrigem = $valGuia->c04_docOrigem;
                }
                if (isset($valGuia->c06_valorPrincipal)) {
                    $guia->c06_valorPrincipal = $valGuia->c06_valorPrincipal;
                }
                if (isset($valGuia->c10_valorTotal)) {
                    $guia->c10_valorTotal = $valGuia->c10_valorTotal;
                }
                if (isset($valGuia->c14_dataVencimento)) {
                    $guia->c14_dataVencimento = $valGuia->c14_dataVencimento;
                }
                if (isset($valGuia->c16_razaoSocialEmitente)) {
                    $guia->c16_razaoSocialEmitente = htmlspecialchars($valGuia->c16_razaoSocialEmitente);
                }
                if (isset($valGuia->c17_inscricaoEstadualEmitente)) {
                    $guia->c17_inscricaoEstadualEmitente = $valGuia->c17_inscricaoEstadualEmitente;
                }
                if (isset($valGuia->c18_enderecoEmitente)) {
                    $guia->c18_enderecoEmitente = $valGuia->c18_enderecoEmitente;
                }
                if (isset($valGuia->c19_municipioEmitente)) {
                    $guia->c19_municipioEmitente = str_pad($valGuia->c19_municipioEmitente, 5, '0', STR_PAD_LEFT);
                }
                if (isset($valGuia->c20_ufEnderecoEmitente)) {
                    $guia->c20_ufEnderecoEmitente = $valGuia->c20_ufEnderecoEmitente;
                }
                if (isset($valGuia->c21_cepEmitente)) {
                    $guia->c21_cepEmitente = $valGuia->c21_cepEmitente;
                }
                if (isset($valGuia->c22_telefoneEmitente)) {
                    $guia->c22_telefoneEmitente = $valGuia->c22_telefoneEmitente;
                }
                if (isset($valGuia->c34_tipoIdentificacaoDestinatario)) {
                    $guia->c34_tipoIdentificacaoDestinatario = $valGuia->c34_tipoIdentificacaoDestinatario;
                }
                if (isset($valGuia->c35_idContribuinteDestinatario)) {
                    $guia->c35_idContribuinteDestinatario = $valGuia->c35_idContribuinteDestinatario;
                }
                if (isset($valGuia->c37_razaoSocialDestinatario)) {
                    $guia->c37_razaoSocialDestinatario = htmlspecialchars($valGuia->c37_razaoSocialDestinatario);
                }
                if (isset($valGuia->c38_municipioDestinatario)) {
                    $guia->c38_municipioDestinatario = str_pad($valGuia->c38_municipioDestinatario, 5, '0', STR_PAD_LEFT);
                }
                if (isset($valGuia->c33_dataPagamento)) {
                    $guia->c33_dataPagamento = $valGuia->c33_dataPagamento;
                }
                if (isset($valGuia->c05_referencia_periodo)) {
                    $guia->periodo = $valGuia->c05_referencia_periodo;
                }
                if (isset($valGuia->c05_referencia_mes)) {
                    $guia->mes = $valGuia->c05_referencia_mes;
                }
                if (isset($valGuia->c05_referencia_ano)) {
                    $guia->ano = $valGuia->c05_referencia_ano;
                }
                if (isset($valGuia->c05_referencia_parcela)) {
                    $guia->parcela = $valGuia->c05_referencia_parcela;
                }
                if (isset($valGuia->c39_camposExtras)) {
                    $arrCampoExtra = [];
                    foreach (json_decode($valGuia->c39_camposExtras) as $key => $val) {
                        if (isset($val->codigo) && isset($val->tipo) && isset($val->valor)) {
                            $arrCampoExtra[] = [
                                'campoExtra' => [
                                    'codigo' => $val->codigo,
                                    'tipo' => $val->tipo,
                                    'valor' => htmlspecialchars($val->valor)
                                ]
                            ];
                        }
                    }
                    if (count($arrCampoExtra) > 0) {
                        $guia->c39_camposExtras = $arrCampoExtra;
                    }
                }
                $lote->addGuia($guia);
            }
            //header('Content-Type: text/xml');
            //var_dump($lote);
            //echo $lote->toXml();
            //die();

            $this->salvarXMLLote($lote, "{$valLote->id}_{$valLote->numero_nf}.xml");

            $webService = new Connection($config, $lote->getHeaderSoap(), $lote->toXml());
            $soapResponse = $webService->doRequest($lote->soapAction());
            $soapResponse = str_replace(['ns1:'], [], $soapResponse);
            $arrRetorno = [
                'id' => $valLote->id,
                'ambiente' => Util::getTag($soapResponse, 'ambiente'),
                'status' => STATUS_ENVIADO,
                'codigo' => Util::getTag($soapResponse, 'codigo'),
                'descricao' => html_entity_decode(Util::getTag($soapResponse, 'descricao')),
                'reciboNumero' => Util::getTag($soapResponse, 'numero'),
                'reciboDataHora' => Util::getTag($soapResponse, 'dataHoraRecibo'),
                'reciboTempoProcessamento' => Util::getTag($soapResponse, 'tempoEstimadoProc')
            ];
            //print '<pre>'; var_dump($arrRetorno);
            /*
              Códigos de Retorno do Envio
              100 - Lote recebido com sucesso
              101 - Certificado inválido
              102 - CNPJ não habilitado para uso do serviço.
              103 - Mensagem excedeu o tamanho máximo de 300KB.
              153 - A quantidade de guias no lote não pode ser maior que 200!
              197 - Erro ao recepcionar o lote
              198 - Este serviço deve usar uma conexão HTTPS Segura! Tente novamente utilizando
              seu Certificado Digital.
             */
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
            if ($arrRetorno['status'] != STATUS_ENVIADO){
                app('db')->delete("DELETE FROM senda.fin_03_02_01 cpa WHERE cpa.id_nf = ? AND saldo = valor_titulo;", [$valLote->id_nf]);
            }
            $aviso = AVISO_TRANSMISSAO_FALHA;
            if ($arrRetorno['status'] == STATUS_ENVIADO) {
                $aviso = AVISO_TRANSMISSAO_OK;
            } else if ($arrRetorno['status'] == STATUS_PENDENCIA) {
                $aviso = AVISO_TRANSMISSAO_PENDENCIA;
            }
            app('db')->insert("INSERT INTO senda.com_03_02_01_a10_a3(id_lote,id_nf,codigo,usuario,ip_usuario,destino,timeout,autoclose) VALUES (?,?,?,?,?,?,?,?) RETURNING id", [
                Util::getValue($valLote->id),
                Util::getValue($valLote->id_nf),
                $aviso,
                $valLote->usuario_inc,
                $valLote->ip_usuario_inc,
                AVISO_DESTINO_POPUP,
                5000,
                ($aviso == AVISO_TRANSMISSAO_OK)?'T':'F'
            ]);
            //print_r($arrRetorno);
            echo '<br/>';
        }
        unset($config);
    }
    
    public function consultar() {
        $lotes = app('db')->select("SELECT lote.id FROM senda.com_03_02_01_a10 lote WHERE status = ? AND tipo = 'PORTAL' AND cnpj = ?", [STATUS_ENVIADO, env('CERT_CNPJ')]);
        foreach ($lotes as $key => $valLote) {
            $this->consultarById($valLote->id);
        }
        if (count($lotes) == 0) {
            echo '<h3>Nenhum Lote Disponível Para Consulta</h3>';
        }
        echo '<br/> <a href="../home">Voltar</a>';
    }
    
    public function consultarById($id) {
        $config = new GnreSetup;
        $lotes = app('db')->select("SELECT lote.* FROM senda.com_03_02_01_a10 lote WHERE id = ? AND status = ? AND tipo = 'PORTAL' AND cnpj = ?", [$id, STATUS_ENVIADO, env('CERT_CNPJ')]);
        foreach ($lotes as $key => $valLote) {
            app('db')->insert("INSERT INTO senda.com_03_02_01_a10_a3(id_lote,id_nf,codigo,usuario,ip_usuario,destino,timeout,autoclose) VALUES (?,?,?,?,?,?,?,?) RETURNING id", [
                Util::getValue($valLote->id),
                Util::getValue($valLote->id_nf),
                AVISO_CONSULTA,
                $valLote->usuario_inc,
                $valLote->ip_usuario_inc,
                AVISO_DESTINO_POPUP,
                1000,
                'T'
            ]);

            $consulta = new Consulta();
            $consulta->setRecibo($valLote->recibo_numero);
            $consulta->setEnvironment($valLote->ambiente);
            if ($valLote->ambiente == '2') {
                $consulta->utilizarAmbienteDeTeste(true);
            }
            $webService = new Connection($config, $consulta->getHeaderSoap(), $consulta->toXml());
            $soapResponse = $webService->doRequest($consulta->soapAction());
            $soapResponse = str_replace(['ns1:'], [], $soapResponse);
            $arrRetorno = [
                'id' => $valLote->id,
                'ambiente' => Util::getTag($soapResponse, 'ambiente'),
                'codigo' => Util::getTag($soapResponse, 'codigo'),
                'descricao' => html_entity_decode(Util::getTag($soapResponse, 'descricao')),
                'resultado' => html_entity_decode(Util::getTag($soapResponse, 'resultado')),
            ];
            /*
              Códigos de Retorno
              400 - Lote Recebido. Aguardando processamento
              401 - Lote em Processamento
              402 - Lote processado com sucesso
              403 - Processado com pendência
              404 - Erro no processamento do lote. Enviar o lote novamente.
             */
            $arrRetorno['status'] = STATUS_ENVIADO;
            $aviso = NULL;
            if ($arrRetorno['codigo'] == '402') {
                $arrRetorno['status'] = STATUS_PROCESSADO;
                $aviso = AVISO_CONSULTA_OK;
            } elseif ($arrRetorno['codigo'] == '403') {
                $arrRetorno['status'] = STATUS_PENDENCIA;
                $aviso = AVISO_CONSULTA_PENDENCIA;
            } elseif (empty($arrRetorno['codigo']) || $arrRetorno['codigo'] == '404') {
                $arrRetorno['status'] = STATUS_FALHA;
                $aviso = AVISO_CONSULTA_FALHA;
            }
            app('db')->update("UPDATE senda.com_03_02_01_a10 SET status=?, retorno_ambiente=?,retorno_codigo=?,retorno_descricao=?,retorno_resultado=? WHERE id=?", [
                $arrRetorno['status'],
                $arrRetorno['ambiente'],
                $arrRetorno['codigo'],
                $arrRetorno['descricao'],
                $arrRetorno['resultado'],
                $arrRetorno['id']
            ]);
            if ($arrRetorno['status'] != STATUS_ENVIADO && $arrRetorno['status'] != STATUS_PROCESSADO){
                app('db')->delete("DELETE FROM senda.fin_03_02_01 cpa WHERE cpa.id_nf = ? AND saldo = valor_titulo;", [$valLote->id_nf]);
            }
            if (!empty($aviso)) {
                app('db')->insert("INSERT INTO senda.com_03_02_01_a10_a3(id_lote,id_nf,codigo,usuario,ip_usuario,destino,timeout,autoclose) VALUES (?,?,?,?,?,?,?,?) RETURNING id", [
                    Util::getValue($valLote->id),
                    Util::getValue($valLote->id_nf),
                    $aviso,
                    $valLote->usuario_inc,
                    $valLote->ip_usuario_inc,
                    AVISO_DESTINO_POPUP,
                    5000,
                    ($aviso == AVISO_CONSULTA_OK)?'T':'F'
                ]);
            }
            $parser = new SefazRetorno($arrRetorno['resultado']);
            $loteRetorno = $parser->getLote();
            echo '<pre>';
            foreach ($loteRetorno->getGuias() as $key2 => $valGuia) {
                $arrRetorno = [
                    'id_lote' => $valLote->id,
                    'id_nf' => $valLote->id_nf,
                    'id_cpa' => NULL,
                    'informacoes_complementares' => trim($valGuia->retornoInformacoesComplementares),
                    'atualizacao_monetaria' => trim(ltrim($valGuia->retornoAtualizacaoMonetaria, '0')),
                    'juros' => trim(ltrim($valGuia->retornoJuros, '0')),
                    'multa' => trim(ltrim($valGuia->retornoMulta, '0')),
                    'representacao_numerica' => trim($valGuia->retornoRepresentacaoNumerica),
                    'codigo_barras' => trim($valGuia->retornoCodigoDeBarras),
                    'situacao_guia' => trim($valGuia->retornoSituacaoGuia),
                    'sequencial_guia' => trim(ltrim($valGuia->retornoSequencialGuia, '0')),
                    'erros_validacao_campo' => trim($valGuia->retornoErrosDeValidacaoCampo),
                    'erros_validacao_codigo' => trim($valGuia->retornoErrosDeValidacaoCodigo),
                    'erros_validacao_descricao' => trim($valGuia->retornoErrosDeValidacaoDescricao),
                    'numero_controle' => trim($valGuia->retornoNumeroDeControle)
                ];
                $arrAux = app('db')->select("SELECT guia.id_cpa FROM senda.com_03_02_01_a10_a1 guia WHERE guia.id_lote=? AND sequencial=?", [$valLote->id, $arrRetorno['sequencial_guia']]);
                foreach ($arrAux as $key2 => $valAux) {
                    $arrRetorno['id_cpa'] = $valAux->id_cpa;
                    break;
                }
                app('db')->insert("INSERT INTO senda.com_03_02_01_a10_a2(id_lote,id_nf,id_cpa,informacoes_complementares,atualizacao_monetaria,juros,multa,representacao_numerica,codigo_barras,situacao_guia,sequencial_guia,erros_validacao_campo,erros_validacao_codigo,erros_validacao_descricao,numero_controle) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) RETURNING id", [
                    Util::getValue($arrRetorno['id_lote']),
                    Util::getValue($arrRetorno['id_nf']),
                    Util::getValue($arrRetorno['id_cpa']),
                    Util::getValue($arrRetorno['informacoes_complementares']),
                    Util::getValue($arrRetorno['atualizacao_monetaria']),
                    Util::getValue($arrRetorno['juros']),
                    Util::getValue($arrRetorno['multa']),
                    Util::getValue($arrRetorno['representacao_numerica']),
                    Util::getValue($arrRetorno['codigo_barras']),
                    Util::getValue($arrRetorno['situacao_guia']),
                    Util::getValue($arrRetorno['sequencial_guia']),
                    Util::getValue($arrRetorno['erros_validacao_campo']),
                    Util::getValue($arrRetorno['erros_validacao_codigo']),
                    Util::getValue($arrRetorno['erros_validacao_descricao']),
                    Util::getValue($arrRetorno['numero_controle'])
                ]); //$arrRetorno['id'] = app('db')->getPdo()->lastInsertId();
                if (!empty(trim($arrRetorno['numero_controle'],'0'))) {
                    app('db')->update("UPDATE senda.fin_03_02_01 SET gnre_numero_controle=? WHERE codigo=?", [
                        Util::getValue($arrRetorno['numero_controle']),
                        Util::getValue($arrRetorno['id_cpa'])
                    ]);
                }
                print_r($arrRetorno);
            }
        }
        unset($config);
    }
    
    public function enviarConsultarGerar() {
        $this->enviar();
        sleep(20);
        $this->consultar();
        $gerar = new GerarGuias();
        $gerar->pdfLotes();
    }
    
    public function enviarConsultarGerarById($id) {
        $this->enviarById($id);
        sleep(20);
        $this->consultarById($id);
        $gerar = new GerarGuias();
        $gerar->pdfGuia($id);
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
    
    private function salvarXMLLote($lote,$file){
        if (!file_exists(CONFIG_XMLPATH)) {
            mkdir(CONFIG_XMLPATH, 0777, true);
        }
        if (file_exists(CONFIG_XMLPATH)) {
            $lote->toXml(CONFIG_XMLPATH . "/{$file}");
            if (file_exists(CONFIG_XMLPATH . "/{$file}")) {
                echo '<h4>XML Gerado em: ' . CONFIG_XMLPATH . "/{$file}" . '</h4>';
            } else {
                echo '<h3>Falha ao gerar arquivo em: ' . CONFIG_XMLPATH . "/{$file}" . '</h4>';
            }
        } else {
            echo '<h3>Pasta para geração de arquivos XML não definida ou inexistente nos parâmetros de configuração.</h3>';
        }
    }
}
