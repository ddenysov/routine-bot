
DC := docker-compose exec
FPM := $(DC) php-fpm
NODE := $(DC) node yarn
MYSQL := $(DC) mysql

start:
	@docker-compose up -d

stop:
	@docker-compose stop

ssh:
	@$(FPM) bash
