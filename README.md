# Modular blog

### Installation With Docker

```sh
git clone https://github.com/idanieldrew/redact

cd modular-blog

# set environment
copy .env.example .env

# Start docker in os
docker-compose up --build
```

### Installation Without Docker

```sh
git clone https://github.com/idanieldrew/redact

cd modular-blog

# set environment
copy .env.example .env

# install composer
composer install
```

## Tests
```sh
docker-compose exec weblog_application php artisan test
```

## Fake data
```sh
php artisan migrate:fresh --seed
```

### Infrastructure Description
- This project is built with laravel and php
- This project offers a special api for blog
- I tried to make the architecture of the project based on
  this [book](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
- Support [laravel 8 with php 7.4](https://github.com/idanieldrew/modular-blog/releases/tag/v1.2.0)
  & [laravel 9 with php 8.1](https://github.com/idanieldrew/modular-blog/releases/tag/v2.0)
- Docker is used for containers

## Database Description

#### Laravel is flexible in determining database but i performed

- PostgresQL for main database
- Redis for cache database
- Elasticsearch for search posts(blogs)

## Webserver Description

- Nginx,because use php-fpm

## Other Description

- Use Kibana for dashboard and management elastic
- Has continuous integration(GitHub actions)

## Tips for developers

- This project is modular,therefor it's content in "Modules" folder
- I tried to ensure all services or modules have tests and their coverage is close to 100%,but you can also help to
  increase coverage tests
- For language and translatable,I make a custom module(Lang).I got help
  form [spatie package](https://github.com/spatie/laravel-translatable).this package gives you many possibilities,but i
  don't need all this.That's why i made this module.
- Similarly, For Roles & permissions,I make a custom module(Role).I got help
  form [spatie package](https://github.com/spatie/laravel-permission). This package gives you many possibilities,but i
  don't need all this.That's why i made this module.
- Use cache for queries(redis)
- I tried to clean code so use Solid and Design patterns. If you have an idea to make the code cleaner,do a pull request.
