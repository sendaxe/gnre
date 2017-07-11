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
- Composer

## Instalação

### Criando um novo projeto Via Composer

Caso você não possua o composer veja [esse link](https://getcomposer.org/doc/01-basic-usage.md) antes de prosseguir

- Acesse a pasta 'htdocs' ou 'html' via terminal (dependendo da configuração do seu servidor PHP)
- Execute o comando abaixo:
``` terminal
composer create-project sendaxe/senda-gnre:dev-master --prefer-dist
```
Aguarde o Download das dependencias.

### Ajustando o arquvivo de configuração .ENV
- Assim que as dependências forem baixadas, acesse a pasta raiz onde foi realizada a instalação.
- Abra o arquivo [.env](http://github.com/sendaxe/senda-gnre/blob/master/.env) que esta na raiz do projeto e configure os dados de acesso conforme o arquivo [.env.example](http://github.com/sendaxe/senda-gnre/blob/master/.env.example)

### Configurando a URL de Acesso
- Acesse o sistema atraves da URL: "http://localhost/sendaxe/senda-gnre/public" 
- Se preferir crie um arquivo .BAT (windows) com os comandos abaixo:
``` terminal
cd C:\xampp\htdocs\sendaxe\senda-gnre
php -S localhost:8000 -t ./public
pause
REM Acesse a url: http://localhost:8000 através de um navegador.
```
### Atualizando o Certificado.
- Sempre que o certificado estiver expirando será necessário atualizar o arquivo através da URL: /configuracoes disponível na aplicação
```(No primeiro acesso será necessário realizar esse upload)```



## Licença
[MIT license](http://opensource.org/licenses/MIT)
