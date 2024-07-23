.RECIPEPREFIX +=
.DEFAULT_GOAL := help
include .env
model = "User"
help:
	@echo "Useful  commands"
install:
	@composer install
test:
	@./vendor/bin/sail artisan test
coverage:
	@./vendor/bin/sail artisan test --coverage
migrate:
	@./vendor/bin/sail artisan migrate
showmodel:
	php artisan model:show $(model)
analyse:
	@./vendor/bin/phpstan analyse
pint:
	@./vendor/bin/pint
up:
	@./vendor/bin/sail up -d
down:
	@./vendor/bin/sail down
vite:
	@./vendor/bin/sail npm run dev
optimize:
	@./vendor/bin/sail artisan optimize:clear
