# Instalando o projeto

O projeto se utiliza de contêineres Docker, através do pacote Laravel Sail para facilitar a configuração do ambiente de desenvolvimento. Portanto, é necessário que já possua o Docker e o Docker Compose instalados na máquina.

### Passos para o rodar o projeto localmente:

- Faça um clone do projeto para sua máquina local
```shell
git clone https://github.com/MatheusCavalc/Medium-clone
```
- Navegue até o diretório raiz do projeto clonado e execute o comando abaixo para abrir a pasta frontend:
```shell
cd frontend
```
- Execute o comando abaixo para instalar as dependências do frontend:
```shell
npm install
```
- Copie o arquivo .env.example, renomeie para .env e preencha com a rota base do backend que será http://localhost/api/products:
```shell
cp .env.example .env
```
- Execute o comando abaixo para compilar e subir o frontend:
```shell
npm run serve
```
- Volte para a raiz do projeto e vá para a pasta backend:
```shell
cd ..
```
```shell
cd backend
```
- Execute o comando abaixo para instalar as dependências do backend:
```shell
composer install
```
- Copie o arquivo .env.example e renomeie para .env. Você pode fazer isso executando o seguinte comando:
```shell
cp .env.example .env
```
- Gere uma chave de aplicativo Laravel usando o seguinte comando:
```shell
php artisan key:generate
```
- Execute o seguinte comando para iniciar o Docker e o Laravel Sail:
```shell
./vendor/bin/sail up -d
```
- Execute o comando abaixo para popular o banco de dados com as tabelas necessárias para a aplicação:
```shell
./vendor/bin/sail artisan migrate
```

Depois que os comandos acima forem executados, você poderá acessar a aplicação em http://localhost:8080
