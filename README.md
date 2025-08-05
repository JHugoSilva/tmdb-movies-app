# **Aplicação web desenvolvida com Laravel, VueJS e MySQL**

### **Check List**

* ✅ API com Laravel
* ✅ Integração com banco de dados MySQL
* ✅ Buscar filmes pelo nome usando na API do TMDB
* ✅ Adicionar filmes aos favoritos, salvando os dados localmente
* ✅ Listar filmes favoritos em uma tela dedicada, com filtro por gênero
* ✅ Remover filmes da lista de favoritos

## **Pré-requisitos**

* Docker instalado ([Download Docker](https://www.docker.com/get-started) - Docker + Docker Compose)
* Git ([Download Git](https://git-scm.com/downloads))

### Ambiente Dockerizado

O projeto já está totalmente dockerizado. Os principais serviços são:

* **app** : aplicação Laravel (PHP + Artisan)
* **node** : aplicação Vue.js (Vite dev server)
* **db** : banco de dados MySQL

### Estrutura do CRUD de Filmes Favoritos

A seguir estão os principais diretórios/arquivos onde o CRUD está implementado:

#### Laravel (Backend)

| Camada               | Caminho                                                    | Descrição                         |
| -------------------- | ---------------------------------------------------------- | ----------------------------------- |
| **Rotas**      | `routes/api.php`                                         | Define as rotas da API de filmes    |
| **Controller** | `app/Http/Controllers/FilmeController.php`               | Controlador com a lógica do CRUD   |
| **Model**      | `app/Models/Filme.php`                                   | Modelo do filme                     |
| **Migration**  | `database/migrations/xxxx_xx_xx_create_filmes_table.php` | Criação da tabela `filmes`      |
| **Seeder**     | `database/seeders/FilmeSeeder.php`                       | Popula o banco com dados de exemplo |
| **Request**    | `app/Http/Requests/FilmeRequest.php` *(se houver)*     | Validação de dados                |

#### Vue.js (Frontend)

| Componente                          | Caminho                                                | Descrição                                 |
| ----------------------------------- | ------------------------------------------------------ | ------------------------------------------- |
| **Listar Filmes da API TMDB** | `frontend/src/components/MoviesList.vue`             | Lista os filmes da API                      |
| **Lista Filmes Favoritados**  | `frontend/src/components/Filmes/MoviesFavorites.vue` | Lista os filmes favoritados salvos no banco |
| **Roteamento**                | `frontend/src/router/index.js`                       | Rotas SPA                                   |
| **Integração API**          | `frontend/src/api/movieService.js`                   | Comunicação com a API Laravel             |

## 🚀 **Passo a Passo para Execução**

### 1. Clone o repositório

```
git clone https://github.com/JHugoSilva/tmdb-api.git
```

### 2. Acessar a pasta do projeto

```
cd tmdb-api/
```

### 3. Configurar .env

```
cp backend/.env.example backend/.env
```

### 4. Configurar conexão ao banco de dados

###### *Editar .env*Conexões do banco de dados

```
DB_CONNECTION=mysql
DB_HOST=tmdb_mysql
DB_PORT=3306
DB_DATABASE=tmdb_db
DB_USERNAME=root
DB_PASSWORD=root
```

### **5. Como obter a chave da API do TMDB**

###### **[Link oficial do TMDB](https://www.themoviedb.org)**

---

### Passos para criar a conta e gerar a chave da API:

| 1. Crie uma conta gratuita                    | Acesse sua conta caso já tenha cadastro     |
| --------------------------------------------- | -------------------------------------------- |
| [Clique Aqui](https://www.themoviedb.org/signup) | [Clique Aqui](https://www.themoviedb.org/login) |

1. **1 Para criar conta gratuita**

   * Forneça um nome de usuário, e-mail e senha.
   * Confirme o e-mail enviado pelo TMDB.
2. **Acesse as configurações da conta:**

   * Após fazer login, clique na sua imagem de perfil (canto superior direito) e vá até  **"Configurações"** .
   * No menu lateral, clique em  **"API"** .
3. **Solicite uma API Key:**

   Escolha entre os tipos de chave:  **Developer** ,  **Personal** , ou  **Commercial** .

   Preencha os dados solicitados (nome da aplicação, descrição, site — opcional para uso pessoal).

   Clique em  **"Submit"** .

   **Configurar Chave e URL da API no arquivo .env do Laravel**

   "Adicione essas duas linhas no final do arquivo"

   ```
   TMDB_API_KEY=<adicione_sua_chave_aqui>
   TMDB_BASE_URL=https://api.themoviedb.org/3

   ```

---

### 6. Executar o BackEnd e FrontEnd com Makefile

1. Corrigir permissões de pastas do Laravel
2. Instalar dependências PHP com composer
3. Gerar chave de app
4. Subir containers e construir do zero
5. Rodar migrations
6. Comandos para executar Makefile conforme a necessidade:| Todas as configurações informadas a cima esta automatizadas no arquivo Makefile | segue a abaixo comandos para executar as rotinas que foram configuradas.

| Comando                  | Descrição                                                             |
| ------------------------ | ----------------------------------------------------------------------- |
| `make setup`           | Sobe tudo (VueJs, banco de dados MySQL e o Laravel) e configura Laravel |
| `make up`              | Sobe os containers e cria as imagens                                    |
| `make migrate`         | Só roda migrations                                                     |
| `make migrate-refresh` | Apaga e constroi novamente as tabela migrations                        |
| `make down `           | Para containers                                                         |
| `make clean`           | Remove tudo (containers, volumes e imagens)                             |

### 6. Acesse a aplicação

Verificar se a API esta funcionando acesse essa rota:

Clique aqui: [Rota para testar API](http://localhost:8088/api/ping)

Acessa o banco de dados

Clique aqui: [Acessar o banco de dados](http://localhost:8081/index.php)

Use essas crendencias

1. **Usuário**: `root`
2. **Senha:** `root`
   ***Obs*: phpMyAdmin, para facilitar o acesso e a visualização dos dados.**

### Teste Manual (interface)

1. Acesse o frontend: [Click Aqui](http://localhost:5177/)
2. Você poderá:
   Listar filmes da API TMDB e filtrar por título
   Favoritar filmes salvar no banco de dados e filtrar por gênero
