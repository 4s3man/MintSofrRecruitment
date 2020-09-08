## Install application
install:
	docker-compose up -d --build && \
	docker container exec -t mint_software_php composer install && \
	docker container exec -t mint_software_php php ./bin/console doctrine:migrations:migrate -n && \
	docker container exec -t mint_software_php php ./bin/console doctrine:fixtures:load -n && \\
	make test

test:
	docker container exec -t mint_software_php php ./bin/phpunit

run:
	docker-compose up