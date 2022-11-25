### Requesitos necessários para executar o projeto:
Instalar o PHP,
instalar o MySql e
instalar o composer.

### Para iniciar o servidor:
Dentro da pasta do projeto execute no terminal os seguintes comandos:
`composer dump-autoload`,
`composer require dompdf/dompdf` e
`php -S localhost:(porta desejada) -t public`;

## Criação do banco de dados:
É somente copiar o conteúdo de db.sql e rodar no workbench ou shell do MySQL,
para que possa realizar a criação da tabela.

Para rodar no seu proprio banco de dados altere as variaveis no arquivo conexao.php 
no seu host em "$dbhost", nome de usuario em "$dbusername" e com sua senha pessoal em "$dbpassword".

# Adicionando dados:
Na pagina inicial clique em "Novo" e você será redirecionado a página novo.php,
onde é só inserir os dados de nome, matricula e cidade e clicar em enviar.
Para voltar ao inicio, clique no botão "voltar ao inicio".

Caso aconteça o erro "Class MySqli not found" renomeie dentro da pasta de instalação do seu PHP procure o arquivo php.ini-development,
renomeie para php.ini e entre no arquivo utilizando o seu Visual Studio Code. 
Nas linhas 928 onde tem ";extension=mysqli" retire o ";" e na linha 934 onde tem ";extension=pdo_mysql" retire o ";",
salve e rode o servidor novamente.