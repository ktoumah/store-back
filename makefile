default: help

API_URL = http://127.0.0.1:8006

run: ## Run the application
	@if [ -f "./vendor/autoload_runtime.php" ]; then \
		make start; \
	else \
		make init; \
	fi
		$(info The application is running on: $(API_URL)/.) \

init: ## Install the application
	make build start copy_env_file cp_pre_commit_file install_dependencies install_db fix_folder_permissions

build: ## Build images stack
	docker-compose build

start: ## Start stack
	docker-compose up -d --remove-orphans
	make cache_clear

stop: ## Stop stack
	docker-compose stop

restart: ## Restart stack
	docker-compose stop
	docker-compose up -d

down: ## Drop the containers stack
	docker-compose down

logs: ## Show containers logs
	docker-compose logs

app_exec_cmd: app_start  ## Execute commands in PHP container
	docker exec php_store_back_container bash -c "${OPT}"

db_exec_cmd: db_start  ## Execute commands in DB container
	docker exec mysql_store_back_container bash -c "${OPT}"

nginx_exec_cmd: nginx_start ## Execute commands in Nginx container
	docker-compose run --rm nginx_service sh -c "${OPT}"

install_dependencies:  ## Install dependencies
	-make app_exec_cmd OPT="composer install --no-interaction"

install_db:  ## Create database and schema
	make app_exec_cmd OPT="php bin/console doctrine:mongodb:schema:update"

run_migrations:
	make app_exec_cmd OPT="php bin/console doctrine:migrations:migrate --no-interaction"

sh_app: app_start ## Connect to PHP container
	docker exec -it php_store_back_container bash

sh_db: db_start ## Connect to Mysql container
	docker exec -it mysql_store_back_container bash

app_start:
	[ `docker ps -q -f name=php_store_back_container` ] || docker-compose up -d php_service

nginx_start:
	[ `docker ps -q -f name=nginx_store_back_container` ] || docker-compose up -d nginx_service

db_start:
	[ `docker ps -q -f name=mysql_store_back_container` ] || docker-compose up -d mysql_service_movies

cache_clear: ## Clear cache
	make app_exec_cmd OPT="rm -rf var/cache"

copy_env_file:
	@if [ ! -f "./.env.dev.local" ]; then\
		cp docker/build/config/.env.local.php ./.env.local.php;\
	fi
	@if [ ! -f "./.env.dev.local" ]; then\
		cp docker/build/config/.env ./.env;\
	fi

cp_pre_commit_file: ## Copy pre-commit file to Git hooks folder
	rm -f .git/hooks/pre-commit
	cp docker/git/pre-commit .git/hooks
	chmod 755 .git/hooks/pre-commit

check_code_style: ## Execute grumphp pre commit command to check code style
	make app_exec_cmd OPT="./vendor/bin/grumphp git:pre-commit"

fix_folder_permissions:
	make app_exec_cmd OPT="chown -R www-data:www-data /var/www"

help: ## Commands guide .
	@awk -F ':|##' '/^[^\t].+?:.*?##/ {printf "\033[36m%-30s\033[0m %s\n", $$1, $$NF}' $(MAKEFILE_LIST)
