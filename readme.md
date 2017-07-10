# SENDA - GNRE

SENDA - GNRE é um projeto de integração entre o sistema Senda ERP e os portais de geração GNRE.

## Documentação
SENDA - GNRE é baseado no projeto: https://github.com/nfephp-org/sped-gnre mantendo-se atualizado conforme as necessidades do sistema Senda ERP.

## Dependencias \ Requisitos
- Apache
- PHP = 7.0 *Problema de comunicação com a Sefaz na versão >= 7.1 do PHP.
- Openssl
- DOMDocument
- Extenções PHP:
  - php_soap
  - php_openssl
  - php_gd2
  - php_pdo_pgsql


## Instalação
### Via Composer

Adicionando o SENDA - GNRE com o composer

Caso você não possua o composer veja [esse link](https://getcomposer.org/doc/01-basic-usage.md) antes de prosseguir

Acesse a pastqa 'www' ou 'html' (dependendo do seu servidor PHP)
Execute o comando abaixo:
``` terminal
composer create-project sendaxe/senda-gnre:dev-master --prefer-dist
```
Aguarde o Download das dependencias.
Em seguida acesse o sistema atraves da URL: localhost/sendaxe/senda-gnre/public ou se preferir crie um arquivo .BAT (windows) com os comandos:
``` terminal
REM echo off
cd C:\xampp\htdocs\sendaxe\senda-gnre
php -S localhost:8000 -t ./public
pause
```
e acesse através de um navegador com a url: http://localhost:8000


## Licença
[MIT license](http://opensource.org/licenses/MIT)
