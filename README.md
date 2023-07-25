```
$ cp .env.example .env
$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
$ ./vendor/bin/sail up -d
$ ./vendor/bin/sail artisan key:generate
```

三種の神器

```bash
$ sail artisan ide-helper:generate
$ sail artisan ide-helper:meta
$ sail artisan ide-helper:models
```

