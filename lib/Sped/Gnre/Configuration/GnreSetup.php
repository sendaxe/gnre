<?php

namespace Sped\Gnre\Configuration;

class GnreSetup extends Setup
{

    public function getBaseUrl()
    {
      return env('CONFIG_BASEURL', 'http://localhost/');
    }

    public function getCertificateCnpj()
    {
      return env('CERT_CNPJ', '');
    }

    public function getCertificateDirectory()
    {
      return env('CERT_DIR', '');
    }

    public function getCertificateName()
    {
      return env('CERT_NAME', 'certificado.pfx');
    }

    public function getCertificatePassword()
    {
      return env('CERT_PASS', '');
    }

    public function getCertificatePemFile()
    {
      return env('CERT_PEMFILE', '');
    }

    public function getEnvironment()
    {
      return env('CONFIG_ENVIRONMENT', '1');
    }

    public function getPrivateKey()
    {
      return env('CERT_PRIVATEKEY', '');
    }

    public function getProxyIp()
    {
      return env('CONFIG_PROXYIP', '');
    }

    public function getProxyPass()
    {
      return env('CONFIG_PROXYPASS', '');
    }

    public function getProxyPort()
    {
      return env('CONFIG_PROXYPORT', '');
    }

    public function getProxyUser()
    {
      return env('CONFIG_PROXYUSER', '');
    }
    
    public function getDebug()
    {
      return false;
    }
}