# Tasks Manager

### Run ```composer``` commands

```bash
docker run --rm -it -v $PWD:/app -u $(id -u):$(id -g) composer <command>
```

### Run Symfony's ```bin/console``` commands

```bash
docker-compose run -u $(id -u):$(id -g) php bin/console <command>
```

#### Run Doctrine migrations

```bash
docker-compose run -u $(id -u):$(id -g) php bin/console doctrine:migrations:migrate -n
```

#### Populate the database with fixtures

```bash
docker-compose run -u $(id -u):$(id -g) php bin/console doctrine:fixtures:load -n
```

### Run code sniffer

```bash
# phpcs
docker-compose run -u $(id -u):$(id -g) php vendor/bin/phpcs src
# phpcbf
docker-compose run -u $(id -u):$(id -g) php vendor/bin/phpcbf src
```

### Swagger UI

In web browser, go to http://localhost:8080/api/doc.
