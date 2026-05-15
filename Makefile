DC = docker compose -f docker-compose.yml -f docker-compose.dev.yml
APP = $(DC) exec app
NODE = $(DC) exec node

.PHONY: up down build restart logs shell migrate seed test pint npm-build lint format

up:
	$(DC) up -d

down:
	$(DC) down

build:
	$(DC) up -d --build

restart:
	$(DC) restart app

logs:
	$(DC) logs -f app

shell:
	$(DC) exec app bash

migrate:
	$(APP) php artisan migrate

seed:
	$(APP) php artisan db:seed

test:
	$(APP) php artisan test --parallel

pint:
	$(APP) ./vendor/bin/pint --dirty

npm-build:
	$(NODE) npm run build

lint:
	$(NODE) npm run lint

format:
	$(NODE) npm run format
