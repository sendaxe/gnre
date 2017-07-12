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
        $arrReceitas = [
            '100064', '100013', '100110', '100102', '100145',
            '150010', '100021', '100137', '100129', '100056',
            '100072', '100080', '100048', '100099', '100030',
            '500011', '600016'
        ];
    }

    public function consultarUf($receita, $estado) {
        $configUF = new ConfigUf;
        $configUF->setEnvironment(env('CONFIG_ENVIRONMENT', 1));
        $configUF->setReceita($receita);
        $configUF->setEstado($estado);
        if (env('CONFIG_ENVIRONMENT', 1) == '2') {
            $configUF->utilizarAmbienteDeTeste(true);
        }
        if (!empty($configUF->getEnvironment()) && !empty($configUF->getReceita()) && !empty($configUF->getEstado())) {
            header('Content-Type: text/xml');
            $config = new GnreSetup;
            $webService = new Connection($config, $configUF->getHeaderSoap(), $configUF->toXml());
            return $webService->doRequest($configUF->soapAction());
        } else {
            print ("Parametros obrigatórios não informados. Informar: Ambiente, Receita e Estado");
        }
        return null;
    }

}
