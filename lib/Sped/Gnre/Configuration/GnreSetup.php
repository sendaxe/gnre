<?php

namespace Sped\Gnre\Configuration;

use Illuminate\Support\Facades\Storage;

class GnreSetup extends Setup {

    protected $baseUrl;
    protected $certificateCnpj;
    protected $certificateDirectory;
    protected $certificateName;
    protected $certificatePassword;
    protected $certificatePemFile;
    protected $environment;
    protected $privateKey;
    protected $proxyIp;
    protected $proxyPass;
    protected $proxyPort;
    protected $proxyUser;
    protected $debug;

    public function __construct($empresa) {
        if (!empty($empresa->codigo)) {
            $strDIR = CERT_DIR . $empresa->codigo . DIRECTORY_SEPARATOR;
            $pathStorage = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], storage_path('app') . '/') . $strDIR;
            Storage::makeDirectory($strDIR);
            $this->setBaseUrl($empresa->gnre_url_servico);
            $this->setCertificateCnpj($empresa->cnpj);
            $this->setCertificateDirectory($strDIR);
            $this->setCertificateName('cert.pfx');
            $this->setCertificatePemFile("{$pathStorage}cert_certKEY.pem");
            $this->setEnvironment($empresa->gnre_ambiente);
            $this->setPrivateKey("{$pathStorage}cert_privKEY.pem");
            $this->setProxyIp(env('CONFIG_PROXYIP', ''));
            $this->setProxyPass(env('CONFIG_PROXYPASS', ''));
            $this->setProxyPort(env('CONFIG_PROXYPORT', ''));
            $this->setProxyUser(env('CONFIG_PROXYUSER', ''));
            $this->setDebug(FALSE);
        }
    }

    function getBaseUrl() {
        return $this->baseUrl;
    }

    function getCertificateCnpj() {
        return $this->certificateCnpj;
    }

    function getCertificateDirectory() {
        return $this->certificateDirectory;
    }

    function getCertificateName() {
        return $this->certificateName;
    }

    function getCertificatePassword() {
        return $this->certificatePassword;
    }

    function getCertificatePemFile() {
        return $this->certificatePemFile;
    }

    function getEnvironment() {
        return $this->environment;
    }

    function getPrivateKey() {
        return $this->privateKey;
    }

    function getProxyIp() {
        return $this->proxyIp;
    }

    function getProxyPass() {
        return $this->proxyPass;
    }

    function getProxyPort() {
        return $this->proxyPort;
    }

    function getProxyUser() {
        return $this->proxyUser;
    }

    function getDebug() {
        return $this->debug;
    }

    function setBaseUrl($baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    function setCertificateCnpj($certificateCnpj) {
        $this->certificateCnpj = $certificateCnpj;
    }

    function setCertificateDirectory($certificateDirectory) {
        $this->certificateDirectory = $certificateDirectory;
    }

    function setCertificateName($certificateName) {
        $this->certificateName = $certificateName;
    }

    function setCertificatePassword($certificatePassword) {
        $this->certificatePassword = $certificatePassword;
    }

    function setCertificatePemFile($certificatePemFile) {
        $this->certificatePemFile = $certificatePemFile;
    }

    function setEnvironment($environment) {
        $this->environment = $environment;
    }

    function setPrivateKey($privateKey) {
        $this->privateKey = $privateKey;
    }

    function setProxyIp($proxyIp) {
        $this->proxyIp = $proxyIp;
    }

    function setProxyPass($proxyPass) {
        $this->proxyPass = $proxyPass;
    }

    function setProxyPort($proxyPort) {
        $this->proxyPort = $proxyPort;
    }

    function setProxyUser($proxyUser) {
        $this->proxyUser = $proxyUser;
    }

    function setDebug($debug) {
        $this->debug = $debug;
    }

}
