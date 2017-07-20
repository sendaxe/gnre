<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use Sped\Gnre\Parser\Util;

class DefinesProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        define('STATUS_INCLUIDO', '1');
        define('STATUS_ENVIADO', '2');
        define('STATUS_PROCESSADO', '3');
        define('STATUS_PENDENCIA', '4');
        define('STATUS_CONTINGENCIA', '5');
        define('STATUS_GUIAGERADA', '6');
        define('STATUS_FALHA', '8');
        define('STATUS_REJEICAO', '9');
        
        define('AVISO_TRANSMISSAO', '10');
        define('AVISO_TRANSMISSAO_FALHA', '11');
        define('AVISO_TRANSMISSAO_PENDENCIA', '12');
        define('AVISO_TRANSMISSAO_OK', '20');
        define('AVISO_CONSULTA', '30');
        define('AVISO_CONSULTA_FALHA', '31');
        define('AVISO_CONSULTA_PENDENCIA', '32');
        define('AVISO_CONSULTA_OK', '40');
        define('AVISO_GUIA', '50');
        define('AVISO_GUIA_FALHA', '51');
        define('AVISO_GUIA_OK', '60');
        
        define('AVISO_DESTINO_POPUP', '0');
        define('AVISO_DESTINO_OUTRO', '1');
        
        define('DOMPDF_ENABLE_AUTOLOAD', false);

        define('CERT_NAME', 'certificado.pfx');
        define('CERT_PEMFILE', env('CERT_DIR') . '/metadata/certificado_certKEY.pem');
        define('CERT_PRIVATEKEY', env('CERT_DIR') . '/metadata/certificado_privKEY.pem');
        
        $configOk = TRUE;
        $arrMsg = [];
        if (empty(env('CERT_CNPJ'))) {
            $arrMsg[] = "<h5>CERT_CNPJ inválido ou não informado.<h5/>";
            $configOk = FALSE;
        } else {
            if (!empty(env('CONFIG_PDFPATH')) && file_exists(env('CONFIG_PDFPATH'))) {
                app('db')->update("UPDATE senda.cad_01_02_a1 SET gnre_pasta_guias=? WHERE gera_gnre = 'T' AND EXISTS (SELECT emp.codigo FROM senda.cad_01_02 emp WHERE emp.codigo = senda.cad_01_02_a1.cod_empresa AND cnpj = ? LIMIT 1) ", [
                    Util::getValue(env('CONFIG_PDFPATH')),
                    Util::getValue(env('CERT_CNPJ'))
                ]);
            } else {
                $arrMsg[] = "<h5>Caminho para CONFIG_PDFPATH não localizado.<h5/>";
                $configOk = FALSE;
            }
            if (empty(env('CERT_DIR')) || !file_exists(env('CERT_DIR'))) {
                $arrMsg[] = "<h5>Caminho para CERT_DIR não localizado.<h5/>";
                $configOk = FALSE;
            }
            if (!empty(env('CONFIG_BASEURL'))) {
                app('db')->update("UPDATE senda.cad_01_02_a1 SET gnre_url_servico=? WHERE gera_gnre = 'T' AND EXISTS (SELECT emp.codigo FROM senda.cad_01_02 emp WHERE emp.codigo = senda.cad_01_02_a1.cod_empresa AND cnpj = ? LIMIT 1) ", [
                    Util::getValue(env('CONFIG_BASEURL')),
                    Util::getValue(env('CERT_CNPJ'))
                ]);
            } else {
                $arrMsg[] = "<h5>Caminho para CONFIG_BASEURL não localizado.<h5/>";
                $configOk = FALSE;
            }
        }
        if (!$configOk) {
            print "<h3>Variáveis de inicialização não configuradas corretamente.<h3/>";
            foreach ($arrMsg as $msg) {
                print $msg;
            }
            die();
        }
    }

}
