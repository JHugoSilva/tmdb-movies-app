# Caminho do container PHP Laravel
PHP_CONTAINER=tmdb-app

# Subir containers e construir do zero
up:
	docker-compose up -d --build

# Instalar dependências PHP
composer-install:
	docker-compose exec $(PHP_CONTAINER) composer install

# Gerar chave de app
key-generate:
	docker-compose exec $(PHP_CONTAINER) php artisan key:generate

# Corrigir permissões
permissions:
	docker exec $(PHP_CONTAINER) sh -c "chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && chmod -R 775 /var/www/storage /var/www/bootstrap/cache"

# Rodar migrations
migrate:
	docker-compose exec $(PHP_CONTAINER) php artisan migrate

# Rodar migrations com refresh
migrate-refresh:
	docker-compose exec $(PHP_CONTAINER) php artisan migrate:refresh

# Atalho para rodar tudo em ordem
setup: up composer-install key-generate permissions migrate

# Encerrar containers
down:
	docker-compose down

# Limpar containers, volumes e imagens (use com cuidado)
clean:
	docker-compose down --volumes --rmi all --remove-orphans
