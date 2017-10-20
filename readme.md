# SENDA - GNRE

SENDA - GNRE é um projeto de integração entre o sistema Senda ERP e os portais de geração GNRE.

## Documentação
SENDA - GNRE é baseado no projeto: https://github.com/nfephp-org/sped-gnre mantendo-se atualizado conforme as necessidades do sistema Senda ERP.

## Instalando o Servidor PHP
### Para plataforma windows:
- Recomenda-se baixar o XAMPP com a versão PHP 7.0.
- Download do XAMPP: "https://www.apachefriends.org/xampp-files/7.0.23/xampp-win32-7.0.23-0-VC14-installer.exe" 
- Após concluir o download do XAMPP, executar o arquivo recém baixado e seguir os passos do assistente de instalação.
- Antes de iniciar o serviço, verifique se a porta padrão a ser utilizada pelo XAMPP não está em uso por outra aplicação (Por padrão o XAMPP utiliza as portas 80 e 443). Caso tenha o skype instalado, verificar se o mesmo não esta usando as portas 80 e 443 (Menu Ferramentas - Opções - Avançado - Conexão). Desmarque a opção "Use as portas 80 e 443 como conexões de entrada adicionais" caso a mesma esteja marcada.
- Exemplos
  - Removendo o uso da porta 80 e 443 do Skype
    ![Screenshot](./tests/exemplos/img02.png)
- Habilitar Extenções PHP no arquivo "C:\xampp\php\php.ini" - Retire o ";" antes das extenções:
  - php_soap
  - php_openssl
  - php_gd2
  - php_pdo_pgsql
- Ajustar o parametro max_execution_time no php.ini para 500;
- Exemplos
  - Atalho para o php.ini
    ![Screenshot](./tests/exemplos/img01.png)
  - Arquivo php.ini
    ![Screenshot](./tests/exemplos/img03.png)
    ![Screenshot](./tests/exemplos/img04.png)

#### Após configurar o PHP.ini - Adicionar a pasta "c:/xampp/apache/bin" às variáveis de ambiente:
- Siga até as configurações do sistema, mais especificamente nas variáveis de ambiente do sistema. 
- Adicione o caminho de instalação do xampp, exemplo: "C:\xampp\apache\bin" em PATH.
- Exemplos
  - Adicionando o caminho nas variáveis de ambiente - Variáveis de Sistema
    ![Screenshot](./tests/exemplos/img05.png)
    ![Screenshot](./tests/exemplos/img06.png)
- Pare o XAMPP e inicie novamente como ADMINISTRADOR (para extrair os dados do certificado).
- Exemplos
  - Parar o XAMPP e executar novamente como administrador
    ![Screenshot](./tests/exemplos/img07.png)
    ![Screenshot](./tests/exemplos/img08.png)
#### Verificando a instalação
- Antes de prosseguir verifique através do terminal se o openssl esta instalado corretamente, através do comando:
```terminal
openssl version
```
- Verifique se o comando foi reconhecido pelo sistema, caso contrário verifique novamente se a variável de ambiente foi configurada corretamente (pode ser necessário fechar o terminal CMD e abrir novamente).
- Exemplos
  - Verificando se o sistema operacional encontrou a variável de ambiente configurada.
    ![Screenshot](./tests/exemplos/img09.png)
#### Estrutura de Pastas
- Recomenda-se salvar a aplicação baixada na pasta raiz do serviço PHP.
  * C:/xampp/htdocs/senda-gnre (copiar para esta pasta a aplicação baixada)
- Exemplos
  - Estrutura de pastas
    ![Screenshot](./tests/exemplos/img10.png)
#### Ajustando o arquvivo de configuração .ENV
- Assim que as dependências forem baixadas e o serviço esteja devidamente configurado conforme os passos anteriores, acesse a pasta raiz onde foi realizada a instalação.
- Configurando os dados da conexão e certificado do cliente:
    * Abra o arquivo [.env](http://github.com/sendaxe/senda-gnre/blob/master/.env) que esta na raiz do projeto e configure os dados de acesso conforme o arquivo [.env.example](http://github.com/sendaxe/senda-gnre/blob/master/.env.example)
- Exemplos
  - Definindo as configurações iniciais da aplicação (arquivo ".env" na raiz da aplicação)
    ![Screenshot](./tests/exemplos/img11.png)

#### Preparando o Senda para gerar GNRE
- Antes de iniciar a aplicação PHP verifique as configurações no cadastro de empresas do Senda.
- No cadastro de empresas, marque a opção "Gera GNRE" na aba "Configurações" - "Contábil/Fiscal" - "Principal".
- Após marcar a opção "Gera GNRE", configure as informações que estarão disponíveis na aba GNRE.
- Informe a url que estará sendo utilizada para rodar o serviço GNRE na opção URL (definir pelo endereço ip ou nome do servidor na rede para que todas as máquinas cliente tenham acesso a esta url). Exemplos: 
    * http://192.168.133.1/senda/empresa/senda-gnre/public
    * http://endereco-ip/senda/empresa/senda-gnre/public
    * http://nome-da-maquina-na-rede/senda/empresa/senda-gnre/public
- Exemplos
  - Configurando as informações no cadastro de empresa para que as máquinas cliente possam 'enxergar' a aplicação php que esta funcionando no servidor.
    ![Screenshot](./tests/exemplos/img12.png)
  - Informações a serem configuradas no cadastro de empresas do Senda ERP.
    ![Screenshot](./tests/exemplos/img13.png)

### Acessando a aplicação PHP
- Acesse no navegador a url: "http://endereco-ip/senda/empresa/senda-gnre/public" o caminho pode variar conforme for configurado a estrutura de pastas nos passos anteriores.
- Exemplos
  - Acesso ao serviço pelo navegador
    ![Screenshot](./tests/exemplos/img14.png)

### Configurando a URL de Acesso
- Acesse o sistema através da URL da pasta raiz, por exemplo: "http://192.168.133.59/sendaxe/empresa/senda-gnre/public" 
- Se preferir utilizar um endereço de acesso reduzido, crie um arquivo .BAT (windows) com os comandos abaixo:
``` terminal
cd C:\xampp\htdocs\sendaxe\empresa\senda-gnre
php -S 192.168.133.59:80 -t ./public
pause
REM Acesse a url: http://192.168.133.59 através do navegador.
```

### Atualizando/Extraindo os dados do certificado (sempre que estiver expirando)
- Este procedimento precisa estar com o XAMPP rodando em modo administrador
- Sempre que o certificado estiver expirando será necessário atualizar/extrair o certificado novo do cliente através da URL: "/configuracoes" disponível na aplicação.
- No primeiro acesso também deverá ser realizado este procedimento.
- Exemplos
  - Acessando as configurações da aplicação
    ![Screenshot](./tests/exemplos/img15.png)
- Confira se os dados do certificado foram extraídos corretamente
    * Após extrair o certificado, verifique a pasta informada em CERT_DIR no arquivo .ENV. Deverá ser criado automaticamente pelo sistema a pasta "metadata" dentro desta pasta.
    * Confira na pasta "metadata" se a mesma possui 2 arquivos: "certificado_certKEY.pem" e "certificado_privKEY.pem"
- Exemplos
  - Conferindo se os dados do certificado foram extraídos
    ![Screenshot](./tests/exemplos/img16.png)
    ![Screenshot](./tests/exemplos/img17.png)

### Atualizando as receitas
- Assim que os passos anteriores forem realizados, acesse a opção "Atualizar Receitas" na aplicação PHP. Neste momento a aplicação deverá baixar as informações específicas de cada estado (campos obrigatórios, códigos de produto, códigos de detalhamento de receita etc..) salvando essas informações no Senda.
- No primeiro acesso também deverá ser realziado este procedimento.
- Exemplos
  - Atualizando as regras do portal referente aos estados e receitas.
    ![Screenshot](./tests/exemplos/img18.png)

### Configurando as informações no cadastro de estados - Senda ERP
- Após atualizar as receitas, acesse o cadastro de estados no Senda ERP e configure os códigos de "Detalhamento de Receita" e "Código de Produto" para cada estado no qual o cliente irá gerar as guias.
- As informações estarão disponíveis conforme regras atualizadas do portal GNRE. Alguns estados obrigam informar "Detalhamento de Receita" e/ou "Código de Produto", estas informações variam conforme estado e receita.
- Exemplos
  - Configurando as informações no cadastro de estados - Senda ERP.
    ![Screenshot](./tests/exemplos/img19.png)

### Alterando a porta padrão do serviço PHP
- Caso o servidor já tenha algum serviço rodando nas portas padrões do XAMPP (80 e 443) (o xampp não irá iniciar e irá alertar que existe um outro serviço rodando em uma destas portas), é possível alterar as portas que o XAMPP estará trabalhando. Para isso, basta seguir os exemplos abaixo:
- Exemplos
    ![Screenshot](./tests/exemplos/img20.png)
    ![Screenshot](./tests/exemplos/img21.png)
- Após alterar as configurações, parar o Apache e executar novamente para carregar as novas configurações.
- Caso a porta seja diferente de "80", lembrar de atualizar a URL da aplicação no Cadastro de Empresas (Senda ERP) para incluir a porta especificada logo após o endereço ip, por exemplo: "http://192.168.133.59:8000/sendaxe/empresa/senda-gnre/public/"

## Licença
[MIT license](http://opensource.org/licenses/MIT)
