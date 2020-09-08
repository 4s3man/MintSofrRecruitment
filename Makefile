SHELL:= bash

app:
    docker-compose up -d
	docker container exec -it mint_software_php composer install