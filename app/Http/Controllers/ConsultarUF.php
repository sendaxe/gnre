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
                    $arrAux = $arrRetorno['detalhamento_receita'];
                    unset($arrRetorno['detalhamento_receita']);
                    app('db')->delete('DELETE FROM senda.com_03_02_01_a9 WHERE uf = ? AND receita = ? AND ambiente = ?', [$row->sigla, $receita, $arrRetorno['ambiente']]);
                    app('db')->table('senda.com_03_02_01_a9')->insert($arrRetorno);
                    $id = app('db')->getPdo()->lastInsertId();
                    if (!empty($id) && !empty($arrAux) && count($arrAux) > 0) {
                        foreach ($arrAux as $key =>$arrDet) {
                            $arrDet['id_receita'] = $id;
                            $arrDet['uf'] = $row->sigla;
                            $arrDet['receita'] = $receita;
                            app('db')->table('senda.com_03_02_01_a9_a1')->insert($arrDet);
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
        $configUF->setEnvironment(env('CONFIG_ENVIRONMENT', 1));
        $configUF->setReceita($receita);
        $configUF->setEstado(strtoupper($estado));
        if (env('CONFIG_ENVIRONMENT', 1) == '2') {
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
                  $arrRetorno['tiposDocumentosOrigem'] = str_replace(['S','N'], ['T','F'], Util::getTag($soapResponse, 'tiposDocumentosOrigem'));
                  $tiposDocOrigem = Util::getTag(Util::getTag($soapResponse, 'tiposDocumentosOrigem'), 'tipoDocumentoOrigem');
                  if (!empty($tiposDocOrigem)) {
                  echo '<pre>';
                  $tiposDocOrigem = explode('</descricao>',$tiposDocOrigem);
                  var_dump($tiposDocOrigem);
                  } */
                $arrRetorno['exigeContribuinteDestinatario'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeContribuinteDestinatario'));
                $arrRetorno['exigeDataVencimento'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeDataVencimento'));
                $arrRetorno['exigeDataPagamento'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeDataPagamento'));
                $arrRetorno['exigeConvenio'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeConvenio'));
                $arrRetorno['exigeCamposAdicionais'] = str_replace(['S', 'N'], ['T', 'F'], Util::getTag($soapResponse, 'exigeCamposAdicionais'));
                $arrRetorno['detalhamento_receita'] = [];

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
                $arrRetorno['ambiente'] = env('CONFIG_ENVIRONMENT', 1);
            } else {
                $arrRetorno = NULL;
                echo "<h4>Não foi possível consultar UF: {$estado}, Receita: {$receita}, Ambiente: " . env('CONFIG_ENVIRONMENT', 1) . ", Código Retorno: {$codigoRetorno}, Mensagem: {$mensagemRetorno}</h4>";
            }
            return $arrRetorno;
        } else {
            print ("Parametros obrigatórios não informados. Informar: Ambiente, Receita e Estado");
        }
        return null;
    }

}

/*
CREATE TABLE senda.com_03_02_01_a9_a1
(
  id serial NOT NULL,
  id_receita integer,
  uf character varying(2),
  receita text,
  codigo integer,
  descricao text,
)
 */