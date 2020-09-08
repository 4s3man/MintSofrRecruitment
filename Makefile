## Install application
install:
	docker-compose up -d && \
	docker container exec -t mint_software_php composer install && \
	docker container exec -t mint_software_php php ./bin/console doctrine:migrations:migrate -n && \
	docker container exec -t mint_software_php php ./bin/console doctrine:fixtures:load -n

tests:
	docker container exec -t mint_software_php php ./bin/phpunit