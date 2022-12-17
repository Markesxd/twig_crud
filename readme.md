# CRUD TWIG
Este é um crud utilizando twig, uma ferramenta de pré-processamento de texto.  
Para usar este projeto precisará de:
- Composer
- php
- mysql
Para baixar as bibliotecas usadas basta utilizar o comando:
```
    composer install
```
Para o funcionamento do projeto é preciso de um usuario e uma base de dados.  
Crie um arquivo .env na raiz do programa seguindo o exemplo:
```
DATABASE_NAME=<DATABASE>
HOST=<HOST>
DATABASE_USER=<USER>
DATABASE_PASSWORD=<PASSWORD>
```  
Onde DATABASE é o nome da base de dados, HOST é o nome ou ip do host, DATABASE_USER é o nome do usuário da base de dados e DATABASE_PASSWORD é a senha da base de dados.  
Com estes dados preenchido basta rodar o comando para criar as tabelas do banco de dados:
```
php setup.php
```
O projeto pode ser utilizado com o servidor embutido do php com o comando:
```
php -S localhost:<PORTA> public/index.php
```
Pode também ser utilizado com o Apache, nesse caso é necessário utilizar um arquivo .htaccess, existe um exemplo deste na pasta public.

