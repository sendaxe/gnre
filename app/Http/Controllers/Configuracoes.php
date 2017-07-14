<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Sped\Gnre\Configuration\CertificatePfxFileOperation;
use Sped\Gnre\Configuration\CertificatePfx;
class Configuracoes extends Controller {

    public function show() {
        return view('configuracoes', []);
    }
    
    public function uploadCertificado(Request $request) {
        if ($request->hasFile('certificado') && $request->file('certificado')->isValid()) {
            $file = $request->file('certificado');
            if(file_exists(env('CERT_DIR'))){
                $pastaOld = env('CERT_DIR').'/old/'.date("YmdHis");                
                if(file_exists(env('CERT_DIR').'/metadata')){
                    if(!file_exists($pastaOld)){
                        mkdir($pastaOld, 0777, true);
                    }
                    rename(env('CERT_DIR').'/metadata', $pastaOld.'/metadata');
                }
                if(file_exists(env('CERT_DIR').'/'.CERT_NAME)){
                    if(!file_exists($pastaOld)){
                        mkdir($pastaOld, 0777, true);
                    }
                    rename(env('CERT_DIR').'/'.CERT_NAME, $pastaOld.'/'.CERT_NAME);
                }
                $request->file('certificado')->move(env('CERT_DIR'),CERT_NAME);
                
                mkdir(env('CERT_DIR').'/metadata', 0777, true);
                
                shell_exec('openssl pkcs12 -in "'.env('CERT_DIR').'/'.CERT_NAME.'" -nokeys -out '.CERT_PEMFILE.' -password pass:'.env('CERT_PASS'));
                
                $certificadoArquivo = new CertificatePfxFileOperation(env('CERT_DIR').'/'.CERT_NAME);
                $gnre = new CertificatePfx($certificadoArquivo, env('CERT_PASS'));
                if($gnre->getPrivateKey()){
                    return redirect('configuracoes');
                }
            }
        }
    }
}
