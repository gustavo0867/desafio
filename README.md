# Sistema de Controle de Viagens

Este é um projeto desenvolvido para avaliação de conhecimentos em Laravel. O sistema tem como objetivo gerenciar o controle de viagens, com funcionalidades para CRUD de **Veículos**, **Motoristas** e **Viagens**.

## Tecnologias Utilizadas

- **Laravel** (para desenvolvimento backend)
- **Blade** (para templates do frontend)
- **PostgreSQL 14+** (como banco de dados)
- **Docker Compose** (para ambiente de banco de dados)

## Arquitetura do Projeto

O projeto segue a arquitetura **MVC** (Model-View-Controller) do Laravel. A organização do código é a seguinte:

- **Modelos**: Responsáveis pela interação com o banco de dados (pasta `app/Models`).
- **Controladores**: Gerenciam a lógica da aplicação e a interação com as views (pasta `app/Http/Controllers`).
- **Views**: Contêm as páginas do frontend e são renderizadas com **Blade** (pasta `resources/views`).
- **Requests**: Usados para validação de dados antes de processar a lógica nos controladores (pasta `app/Http/Requests`).
- **Migrations**: Estrutura do banco de dados, criando e modificando as tabelas (pasta `database/migrations`).

## Funcionalidades

### CRUD de Veículos
- **Modelo**
- **Ano**
- **Data de aquisição**
- **KMs rodados no momento da aquisição**
- **Renavam** (único)
- **Placa** (único)

### CRUD de Motoristas
- **Nome**
- **Data de nascimento** (deve ter no mínimo 18 anos)
- **Número da CNH**

### CRUD de Viagens
- **Escolher motoristas**
- **Escolher o veículo**
- **KM inicial no início da viagem**
- **KM final no final da viagem**
- **Data e hora de início**
- **Data e hora de chegada**

## Como Rodar o Projeto

### 1. **Clonar o Repositório**

Primeiro, clone o repositório para o seu computador com o comando:

```bash
git clone <URL_DO_REPOSITORIO>
cd <nome_do_diretorio>
```

### 2. **Pré-requisitos**

Certifique-se de ter as seguintes dependências instaladas:

- **PHP** (versão 8.0 ou superior)
- **Composer** (para gerenciar as dependências PHP)
- **Docker** (se for usar o banco de dados via Docker)
  
  Para o **Docker Desktop** no Windows, baixe e instale o [Docker Desktop](https://www.docker.com/products/docker-desktop), que não requer o WSL.


### 3. **Instalando o PHP, Composer e Laravel**

Se você não tiver o PHP, o Composer ou o Laravel instalados, siga os passos abaixo para configurá-los.

#### Instalar PHP e Composer

No seu terminal, execute os seguintes comandos para instalar o PHP e o Composer:

```bash
sudo apt update
sudo apt install php php-cli php-fpm php-mbstring php-xml php-zip php-curl php-bcmath php-json
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### Instalar Laravel

No diretório do seu projeto, instale as dependências do Laravel com o Composer:

```bash
composer install
```
### 4. **Configurar o Banco de Dados**

O banco de dados está configurado no Docker com PostgreSQL. Para rodá-lo, execute o seguinte comando:

```bash
docker-compose up -d
```

Se você não estiver utilizando Docker, edite o arquivo `.env` com as configurações do seu banco de dados PostgreSQL:

```ini
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

### 5. **Rodar as Migrations**

As migrations definem a estrutura das tabelas no banco de dados. Para rodar as migrations e configurar o banco de dados, execute:

```bash
php artisan migrate
```

Isso criará as tabelas necessárias, conforme definido nas migrations. Caso já tenha executado o comando uma vez e queira refazer as migrations, pode usar:

```bash
php artisan migrate:refresh
```

### 6. Iniciar o Servidor Laravel

Depois de configurar o banco de dados e rodar as migrations, inicie o servidor de desenvolvimento do Laravel com:

```bash
php artisan serve
```
Acesse o sistema no navegador em: [http://localhost:8000](http://localhost:8000).


