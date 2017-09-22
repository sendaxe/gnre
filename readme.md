# SENDA - GNRE

SENDA - GNRE é um projeto de integração entre o sistema Senda ERP e os portais de geração GNRE.

## Documentação
SENDA - GNRE é baseado no projeto: https://github.com/nfephp-org/sped-gnre mantendo-se atualizado conforme as necessidades do sistema Senda ERP.

## Instalando o Servidor PHP
### Para plataforma windows:
- Recomenda-se instalar para servidor, o XAMPP com versão PHP 7.0.
- Download do XAMPP: "https://www.apachefriends.org/xampp-files/7.0.23/xampp-win32-7.0.23-0-VC14-installer.exe" 
- Após concluir o download do XAMPP, executar o arquivo recém baixado e seguir os passos do assistente de instalação.
- Antes de iniciar o serviço, verifique se a porta padrão a ser utilizada pelo XAMPP não está em uso por outra aplicação (Por padrão o XAMPP utiliza as portas 80 e 443). Caso tenha o skype instalado, verificar se o mesmo não esta usando as portas 80 e 443 (Menu Ferramentas - Opções - Avançado - Conexão).
- Habilitar Extenções PHP no arquivo php.ini:
  - php_soap
  - php_openssl
  - php_gd2
  - php_pdo_pgsql

## Requisitos
- Apache
- PHP = 7.0 *Problema de comunicação com a Sefaz na versão >= 7.1 do PHP.
- Openssl
- DOMDocument
- Habilitar Extenções PHP no arquivo php.ini:
  - php_soap
  - php_openssl
  - php_gd2
  - php_pdo_pgsql
- Poderá ser necessário modificar o parâmetro max_execution_time no php.ini, sugestão de valor: 500.


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
- Antes de processeguir verifique através do terminal se o openssl esta instalado corretamente, através do comando:
```terminal
openssl version
```
Pois o php também deverá utilizar parte deste comando para extração das chaves
- Sempre que o certificado estiver expirando será necessário atualizar o arquivo através da URL: /configuracoes disponível na aplicação.
```No primeiro acesso será necessário realizar esse upload```

## Licença
[MIT license](http://opensource.org/licenses/MIT)
