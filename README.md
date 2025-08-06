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

| Método  | Rota                      | Controlador/Ação                    | Descrição                                    |
| -------- | ------------------------- | ------------------------------------- | ---------------------------------------------- |
| GET/HEAD | `/`                     | —                                    | Rota raiz da aplicação (sem implementação) |
| GET/HEAD | `/api/ping`             | —                                    | Rota de teste de conectividade (ping)          |
| GET/HEAD | `/api/movies`           | `MovieController@index`             | Lista filmes populares da API do TMDB          |
| GET/HEAD | `/api/movies/search`    | `MovieController@searchTitle`       | Busca filmes por título via TMDB              |
| GET/HEAD | `/api/favorites`        | `FavoriteMovieController@index`     | Lista todos os filmes favoritados              |
| POST     | `/api/favorites`        | `FavoriteMovieController@store`     | Adiciona um filme aos favoritos                |
| DELETE   | `/api/favorites/{id}`   | `FavoriteMovieController@destroy`   | Remove um filme dos favoritos (por ID)         |
| GET/HEAD | `/api/favorites/genres` | `FavoriteMovieController@getGenres` | Lista os gêneros dos filmes favoritados       |

#### Vue.js (Frontend)

| Componente                          | Caminho                                                | Descrição                                 |
| ----------------------------------- | ------------------------------------------------------ | ------------------------------------------- |
| **Listar Filmes da API TMDB** | `frontend/src/components/MoviesList.vue`             | Lista os filmes da API                      |
| **Lista Filmes Favoritados**  | `frontend/src/components/Filmes/MoviesFavorites.vue` | Lista os filmes favoritados salvos no banco |
| **Roteamento**                | `frontend/src/router/index.js`                       | Rotas SPA                                   |
| **Integração API**          | `frontend/src/api/movieService.js`                   | Comunicação com a API Laravel             |

## **Passo a Passo para Execução**

---

### 1. Clone o repositório

```
https://github.com/JHugoSilva/tmdb-movies-app.git
```

---

### 2. Acessar a pasta do projeto

```
cd tmdb-movies-app/
```

---

### 3. Configurar .env

```
cp backend/.env.example backend/.env
```

---

### 4. Configurar conexão ao banco de dados

###### *Editar .env*

Conexões do banco de dados

```
DB_CONNECTION=mysql
DB_HOST=tmdb_mysql
DB_PORT=3306
DB_DATABASE=tmdb_db
DB_USERNAME=root
DB_PASSWORD=root
```

---

### **Como obter uma chave de API gratuita da TMDB (The Movie Database)**

#### **Se você ainda não tem uma conta:**

1. Acesse: [https://www.themoviedb.org/signup]()
2. Preencha os dados:  **nome de usuário** , **e-mail** e  **senha** .
3. Confirme o e-mail enviado pelo TMDB para ativar sua conta.
4. Faça login no site.
5. No canto superior direito, clique na sua imagem de perfil e depois em  **"Editar Perfil"** .
6. No menu lateral esquerdo, clique em  **"API"** .
7. Clique em  **"Solicitar uma chave de API"** .
8. Na próxima tela, clique em **"Yes"** quando perguntado se você quer uma API key.
9. Selecione a opção **"Developer"** (para uso pessoal, projetos ou aprendizado).
10. Clique em  **"Subscribe"** .
11. Preencha o formulário com os dados solicitados e envie.
12. Após aprovado, você verá o link:  **"Access your API key details here"** .
13. Clique nesse link e você verá sua  **chave de API (API Key v3 auth)** .

    Copie essa chave e use na sua aplicação.

---

#### **Se você já tem uma conta:**

1. Acesse: [https://www.themoviedb.org/login]()
2. Após o login, clique na sua imagem de perfil (canto superior direito).
3. Vá em  **"Editar Perfil"** .
4. No menu lateral, clique em  **"API"** .
5. Siga os passos a partir do item **7** acima para solicitar a chave (caso ainda não tenha).

---

### ****Configurar Chave e URL da API no arquivo .env do Laravel****

   **Adicione essas duas linhas no final do arquivo**

```
   TMDB_API_KEY=<adicione_sua_chave_aqui>
   TMDB_BASE_URL=https://api.themoviedb.org/3

```

---

### 6. Executar o BackEnd e FrontEnd com Makefile

**O projeto inclui um Makefile que automatiza a execução e configuração completa do ambiente de desenvolvimento.**

**Funcionalidades incluídas no Makefile:**
Correção de permissões das pastas do Laravel

Instalação das dependências PHP com Composer

Geração da chave da aplicação (APP_KEY)

Subida e construção dos containers (Laravel, Vue.js e MySQL)

Execução das migrations do banco de dados

| Comando                  | Descrição                                                                |
| ------------------------ | -------------------------------------------------------------------------- |
| `make setup`           | Sobe todos os serviços (Vue.js, Laravel e MySQL) e configura o Laravel    |
| `make up`              | Sobe os containers e cria as imagens (sem rodar migrations)                |
| `make migrate`         | Executa apenas as migrations                                               |
| `make migrate-refresh` | Apaga todas as tabelas e executa as migrations novamente (migrate:refresh) |
| `make down `           | Para todos os containers                                                   |
| `make clean`           | Remove containers, volumes e imagens                                       |

---

✅ 7. Acessar a aplicação
🔄 Verificar se a API está funcionando
Acesse a rota abaixo para testar se a API está operando corretamente:

👉 Rota para testar API

🗃️ Acessar o banco de dados via phpMyAdmin
Acesse o phpMyAdmin pelo link abaixo:

👉 Acessar o banco de dados

Credenciais de acesso:

Usuário: root

Senha: root

ℹ️ Obs: O phpMyAdmin é utilizado aqui para facilitar o acesso e visualização dos dados do banco de forma gráfica.
---

### Teste Manual (interface)

1. Acesse o frontend: [Click Aqui](http://localhost:5177/)
2. Você poderá:

   Listar filmes da API TMDB e filtrar por título

   Favoritar filmes, salvar no banco de dados e filtrar por gênero

---
