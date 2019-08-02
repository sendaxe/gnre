<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Sped\Gnre\Configuration\CertificatePfxFileOperation;
use Sped\Gnre\Configuration\CertificatePfx;

class Config extends Controller {

    public function show(Request $request, $id_empresa) {
        $statusTitle = NULL;
        $statusMsg = NULL;
        return view('config', [
            'empresa' => $this->getEmpresaById($id_empresa),
            'statusTitle' => $statusTitle,
            'statusMsg' => $statusMsg
        ]);
    }

    public function uploadCert(Request $request, $id_empresa) {
        $this->getEmpresaById($id_empresa);
        $strCertNome = 'cert';
        if (empty($strCertNome)) {
            return redirect('/');
        }
        $strPassword = NULL;
        if ($request->has('password')) {
            $strPassword = $request->input('password');
        }
        $strDIR = CERT_DIR . $id_empresa . DIRECTORY_SEPARATOR;
        Storage::makeDirectory($strDIR);
        $arrMensagens = [];
        if ($request->hasFile('certificado') && $request->file('certificado')->isValid()) {
            $file = $request->file('certificado');

            $pathStorage = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], storage_path('app') . '/') . $strDIR;
            $file->move($pathStorage, $strCertNome . '.pfx');

            $arrCerts = [];
            $key = file_get_contents($pathStorage . $strCertNome . '.pfx');
            if (openssl_pkcs12_read($key, $arrCerts, $strPassword)) {
                if (file_exists($pathStorage . $strCertNome . '.pfx')) {
                    shell_exec('openssl pkcs12 -in "' . $pathStorage . $strCertNome . '.pfx' . '" -nokeys -out "' . $pathStorage . $strCertNome . '_certKEY.pem" -password pass:' . $strPassword);
                }
                /* $certificado = $arrCerts['cert'] . chr(13);
                  foreach ($arrCerts['extracerts'] as $key => $val) {
                  $certificado .= $val . chr(13);
                  }
                  Storage::put($strDIR . $strCertNome . '_certKEY.pem', $certificado); */
                Storage::put($strDIR . $strCertNome . '_privKEY.pem', $arrCerts['pkey']);
            } else {
                $arrMensagens[] = ['mensagem' =>'Não foi possível extrair o certificado, verifique a senha informada. Caso persistir verifique as configurações do serviço OpenSSL.'];
            }
            Storage::delete($strDIR . $strCertNome . '.pfx');
        }
        if (empty($arrMensagens)){
            $arrMensagens[] = ['mensagem' =>'Certificado Extraído.'];
        }
        return view('config', [
            'empresa' => $this->getEmpresaById($id_empresa),
            'mensagens'=> $arrMensagens
        ]);
        //return redirect("/{$id_empresa}/config");
    }

}
