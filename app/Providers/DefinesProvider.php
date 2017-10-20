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
        define('AVISO_SENDA_FALHA_URL', '901');
        define('AVISO_SENDA_NAOGERA_ES', '902');
        define('AVISO_SENDA_NAOGERA_RJ', '903');
        define('AVISO_SENDA_NAOGERA_SP', '904');
        
        define('AVISO_DESTINO_POPUP', '0');
        define('AVISO_DESTINO_OUTRO', '1');
        
        define('DOMPDF_ENABLE_AUTOLOAD', false);
        
        define('CERT_DIR', 'certs'.DIRECTORY_SEPARATOR);
    }
    
    public function tratarPath($path){
        return strtolower( trim(str_replace('\\', '/', $path)) );
    }
}
