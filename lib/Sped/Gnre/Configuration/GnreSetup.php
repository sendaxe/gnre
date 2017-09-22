<?php

namespace Sped\Gnre\Configuration;

class GnreSetup extends Setup
{

    public function getBaseUrl()
    {
      return CONFIG_BASEURL;
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
      return CERT_NAME;
    }

    public function getCertificatePassword()
    {
      return env('CERT_PASS', '');
    }

    public function getCertificatePemFile()
    {
      return CERT_PEMFILE;
    }

    public function getEnvironment()
    {
      return CONFIG_ENVIRONMENT;
    }

    public function getPrivateKey()
    {
      return CERT_PRIVATEKEY;
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