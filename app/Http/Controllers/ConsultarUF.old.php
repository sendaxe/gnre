<?php

namespace App\Http\Controllers;

use Sped\Gnre\Sefaz\ConfigUf;
use Sped\Gnre\Parser\Util;
use Sped\Gnre\Configuration\GnreSetup;
use Sped\Gnre\Webservice\Connection;

class ConsultarUF extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function atualizar() {
        $arrUF = [
            'AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'GO',
            'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI',
            'PR', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'TO'
        ];
        $arrUF = app('db')->select("SELECT codigo, sigla FROM senda.cad_01_14 WHERE sigla IN (" . "'" . implode("','", $arrUF) . "')");
        $arrReceitas = ['100102', '100129', '100099']; //receitas utilizadas hoje
        foreach ($arrUF as $key => $row) {
            foreach ($arrReceitas as $key2 => $receita) {
                $arrRetorno = $this->consultarUf($receita, $row->sigla);
                if (!empty($arrRetorno)) {
                    $arrRetorno['id_estado'] = $row->codigo;
                    $arrDetReceita = $arrRetorno['detalhamento_receita'];
                    $arrCamposAdic = $arrRetorno['campos_adicionais'];
                    $arrProduto = $arrRetorno['produtos'];
                    unset($arrRetorno['detalhamento_receita']);
                    unset($arrRetorno['campos_adicionais']);
                    unset($arrRetorno['produtos']);
                    app('db')->delete('DELETE FROM senda.com_03_02_01_a9 WHERE uf = ? AND receita = ? AND ambiente = ?', [$row->sigla, $receita, $arrRetorno['ambiente']]);
                    app('db')->table('senda.com_03_02_01_a9')->insert($arrRetorno);
                    $id = app('db')->getPdo()->lastInsertId();
                    if (!empty($id) && !empty($arrDetReceita) && count($arrDetReceita) > 0) {
                        foreach ($arrDetReceita as $key =>$rowDet) {
                            $rowDet['id_receita'] = $id;
                            $rowDet['uf'] = $row->sigla;
                            $rowDet['receita'] = $receita;
                            app('db')->table('senda.com_03_02_01_a9_a1')->insert($rowDet);
                        }
                    }
                    if (!empty($id) && !empty($arrCamposAdic) && count($arrCamposAdic) > 0) {
                        foreach ($arrCamposAdic as $key =>$rowCamposAdic) {
                            $rowCamposAdic['id_receita'] = $id;
                            $rowCamposAdic['uf'] = $row->sigla;
                            $rowCamposAdic['receita'] = $receita;
                            app('db')->table('senda.com_03_02_01_a9_a2')->insert($rowCamposAdic);
                        }
                    }
                    if (!empty($id) && !empty($arrProduto) && count($arrProduto) > 0) {
                        foreach ($arrProduto as $key =>$rowProduto) {
                            $rowProduto['id_receita'] = $id;
                            $rowProduto['uf'] = $row->sigla;
                            $rowProduto['receita'] = $receita;
                            app('db')->table('senda.com_03_02_01_a9_a3')->insert($rowProduto);
                        }
                    }
                }
            }
        }
        echo "<h4>Concluido atualização de receitas</h4>";
        echo '<br/> <a href="../home">Voltar</a>';
        /* todas receitas
          $arrReceitas = [
          '100064', '100013', '100110', '100102', '100145',
          '150010', '100021', '100137', '100129', '100056',
          '100072', '100080', '100048', '100099', '100030',
          '500011', '600016'
          ]; */
    }

    public function consultarUf($receita, $estado) {
        $configUF = new ConfigUf;
        $configUF->setEnvironment(CONFIG_ENVIRONMENT);
        $configUF->setReceita($receita);
        $configUF->setEstado(strtoupper($estado));
        if (CONFIG_ENVIRONMENT == '2') {
            $configUF->utilizarAmbienteDeTeste(true);
        }
        if (!empty($configUF->getEnvironment()) && !empty($configUF->getReceita()) && !empty($configUF->getEstado())) {
            $config = new GnreSetup;
            $webService = new Connection($config, $configUF->getHeaderSoap(), $configUF->toXml());
            $soapResponse = $webService->doRequest($configUF->soapAction());
            $soapResponse = str_replace(['ns1:'], [], $soapResponse);
            //header('Content-Type: text/xml');
            //echo $soapResponse;
            //die();
            $arrRetorno = [
                'uf' => NULL,
                'exigeUfFavorecida' => NULL,
                'exigeReceita' => NULL,
                'receita' => NULL,
                'receita_descricao' => NULL,
                'exigeContribuinteEmitente' => NULL,
                'exigeDetalhamentoReceita' => NULL,
                'exigeProduto' => NULL,
                'exigePeriodoReferencia' => NULL,
                'exigeParcela' => NULL,
                'valorExigido' => NULL,
                'exigeDocumentoOrigem' => NULL,
                'tiposDocumentosOrigem' => NULL,
                'exigeContribuinteDestinatario' => NULL,
                'exigeDataVencimento' => NULL,
                'exigeDataPagamento' => NULL,
                'exigeConvenio' => NULL,
                'exigeCamposAdicionais' => NULL,
                'detalhamento_receita' => [],
                'campos_adicionais' => [],
                'produtos' => [],
                'ambiente' => NULL
            ];
            $codigoRetorno = Util::getTag(Util::getTag($soapResponse, 'situacaoConsulta'), 'codigo');
            $mensagemRetorno = html_entity_decode(Util::getTag(Util::getTag($soapResponse, 'situacaoConsulta'), 'descricao'), ENT_QUOTES, "ISO-8859-1");
            if (is_numeric($codigoRetorno) && $codigoRetorno == '450') {
                $arrRetorno['uf'] = strtoupper($estado);
                $arrRetorno['exigeUfFavorecida'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeUfFavorecida'));
                $arrRetorno['exigeReceita'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeReceita'));
                $arrRetorno['receita'] = Util::getTagAtributo(Util::getTag($soapResponse, 'receitas'), 'codigo');
                if (!is_numeric($arrRetorno['receita'])) {
                    $arrRetorno['receita'] = $receita;
                }
                $arrRetorno['receita_descricao'] = html_entity_decode(Util::getTagAtributo(Util::getTag($soapResponse, 'receitas'), 'descricao'), ENT_QUOTES, "UTF-8");
                $arrRetorno['exigeContribuinteEmitente'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeContribuinteEmitente'));
                $arrRetorno['exigeDetalhamentoReceita'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeDetalhamentoReceita'));
                $arrRetorno['exigeProduto'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeProduto'));
                $arrRetorno['exigePeriodoReferencia'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigePeriodoReferencia'));
                $arrRetorno['exigeParcela'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeParcela'));
                $arrRetorno['valorExigido'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'valorExigido'));
                $arrRetorno['exigeDocumentoOrigem'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeDocumentoOrigem'));
                /*
                  regras semelhantes aos campos: detalhamentosReceita, porém será salvo em json.
                  $arrRetorno['tiposDocumentosOrigem'] = Util::getTag($soapResponse, 'tiposDocumentosOrigem');
                */
                $arrRetorno['exigeContribuinteDestinatario'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeContribuinteDestinatario'));
                $arrRetorno['exigeDataVencimento'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeDataVencimento'));
                $arrRetorno['exigeDataPagamento'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeDataPagamento'));
                $arrRetorno['exigeConvenio'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeConvenio'));
                $arrRetorno['exigeCamposAdicionais'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeCamposAdicionais'));
                
                /** detalhamentos de receitas **/
                $detReceita = Util::getTag($soapResponse, 'detalhamentosReceita');
                $posUltima = 0;
                for ($index = 0; $index < substr_count($detReceita, '</detalhamentoReceita>'); $index++) {
                    $arrAux = [];
                    $aux = Util::getTag(substr($detReceita, $posUltima), 'codigo');
                    if (is_numeric($aux)) {
                        $arrAux['codigo'] = $aux;
                        $arrAux['descricao'] = html_entity_decode(Util::getTag(substr($detReceita, $posUltima), 'descricao'), ENT_QUOTES, "UTF-8");
                        $arrRetorno['detalhamento_receita'][] = $arrAux;
                    }
                    $posUltima = strpos($detReceita, '</detalhamentoReceita>', $posUltima + strlen('</detalhamentoReceita>'));
                }
                
                /** campos adicionais **/
                $camposAdic = Util::getTag($soapResponse, 'camposAdicionais');
                $posUltima = 0;
                for ($index = 0; $index < substr_count($camposAdic, '</campoAdicional>'); $index++) {
                    $arrAux = [];
                    $aux = Util::getTag(substr($camposAdic, $posUltima), 'codigo');
                    if (is_numeric($aux)) {
                        $arrAux['obrigatorio'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag(substr($camposAdic, $posUltima), 'obrigatorio'));
                        $arrAux['codigo'] = $aux;
                        $arrAux['tipo'] = Util::getTag(substr($camposAdic, $posUltima), 'tipo');
                        $arrAux['tamanho'] = Util::getTag(substr($camposAdic, $posUltima), 'tamanho');
                        $arrAux['casasdecimais'] = Util::getTag(substr($camposAdic, $posUltima), 'casasDecimais');
                        $arrAux['titulo'] = html_entity_decode(Util::getTag(substr($camposAdic, $posUltima), 'titulo'), ENT_QUOTES, "UTF-8");
                        $arrRetorno['campos_adicionais'][] = $arrAux;
                    }
                    $posUltima = strpos($camposAdic, '</campoAdicional>', $posUltima + strlen('</campoAdicional>'));
                }
                
                /** produtos **/
                $produto = Util::getTag($soapResponse, 'produtos');
                $posUltima = 0;
                for ($index = 0; $index < substr_count($produto, '</produto>'); $index++) {
                    $arrAux = [];
                    $aux = Util::getTag(substr($produto, $posUltima), 'codigo');
                    if (is_numeric($aux)) {
                        $arrAux['codigo'] = $aux;
                        $arrAux['descricao'] = html_entity_decode(Util::getTag(substr($produto, $posUltima), 'descricao'), ENT_QUOTES, "UTF-8");
                        $arrRetorno['produtos'][] = $arrAux;
                    }
                    $posUltima = strpos($produto, '</produto>', $posUltima + strlen('</produto>'));
                }
                $arrRetorno['ambiente'] = CONFIG_ENVIRONMENT;
            } else {
                $arrRetorno = NULL;
                echo "<h4>Não foi possível consultar UF: {$estado}, Receita: {$receita}, Ambiente: " . CONFIG_ENVIRONMENT . ", Código Retorno: {$codigoRetorno}, Mensagem: {$mensagemRetorno}</h4>";
            }
            //echo '<pre>';
            //var_dump($arrRetorno);
            return $arrRetorno;
        } else {
            print ("Parametros obrigatórios não informados. Informar: Ambiente, Receita e Estado");
        }
        return null;
    }

}