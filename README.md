# Laravel project: REST API (JWT) - Follow movies

## Roadmap

* [Introduction](#introduction)
* [Project requirements](#project-requirements)
* [Installation/Configuration](#installationconfiguration)
	* [Docker setup](#docker-setup)
	* [Docker enviroment setup](#docker-enviroment-setup)
    * [Compose docker container](#compose-docker-container)
    * [Bash command](#bash-command)
	* [Nginx setup](#nginx-setup)
	* [Laravel Application setup, database setup, migration, and seeds](#laravel-application-setup-database-setup-migration-and-seeds)
    * [Create new JWT secret token](#create-new-jwt-secret-token)
    * [RapidAPI Setup and Command](#rapidapi-setup-and-command)
* [Dynamic Movie Filter API](#dynamic-movie-filter-api)
* [Run the application tests](#run-the-application-tests)
* [Laravel Request DOCS](#laravel-request-docs)
* [Packages used in application](#packages-used-in-application)
* [Project challenges](#project-challenges)

## Introduction

Basic laravel project REST API using [JWT](https://jwt.io/introduction) as authentication to secure api routes.

Main topic for this app is user can follow and filter movies. Real movies can be fetch from [RapidAPI](https://rapidapi.com/SAdrian/api/moviesdatabase) using inbuild command and it has option to choose mutiple real movies that are sorted by for example:

- Top most popular movies, according to imdb ranking
- Top 200 all time box office movies, according to boxofficemojo
- Top 250 english movies by rating, according to imdb ranking and etc.

More about command itself will be explained in [RapidAPI Setup and Command](#rapidapi-setup-and-command).

## Project requirements

-  **docker**: v20.10.23
-  **php**: v8.1
-  **laravel/framework**: v10.4.1
-  **db**: mysql
-  **tymon/jwt-auth**: v2.0

## Installation/Configuration

When project is cloned first docker containers needs to be setup.

### Docker setup

**Remainder:**
- Install docker desktop [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)
- Docker container example is used pre-configured docker services [laradock](https://laradock.io/getting-started/#Install-Laravel).

**Laradock** is a full PHP development environment for Docker.
It supports a variety of common services, all pre-configured to provide a ready PHP development environment.

In terminal go to cloned project and enter docker folder 
```
cd docker
```

In `docker-compose.yml` docker container version is **3.5** and services will be used:

-  **workspace**
-  **php-fpm**
-  **php-worker**
-  **nginx**
-  **mysql**
-  **phpmyadmin**

### Docker enviroment setup

In folder `docker` use command copy file `cp .env.example .env`
Created `.env` file change:
-  `COMPOSE_PROJECT_NAME=followmovies` (or whatever name)
-  `DATA_PATH_HOST=~/.followmovies/data` (needs to be same path name as project name)

### Compose docker container

To install fresh workspace and build container in `docker` folder use command `docker-compose up -d nginx mysql phpmyadmin`. When build is finished try to enter bash command

### Bash command

When container is build in `docker` folder type command: 
```
docker-compose exec workspace bash
```

### Nginx setup

In `docker/nginx/sites` use command copy file:
```
cp laravel.conf.example followmovies.conf
```

In `followmovies.conf` changes are: 
- Change server name `server_name followmovies.test;`
- Remove directory laravel and root will be like this `root /var/www/public;` 
and register virtual host domain use command `sudo nano /etc/hosts` and below of file add server_name `127.0.0.1 followmovies.test`
After changes are done restart docker container nginx. First check nginx container name it will be mostly named container-name-nginx-1. To check what containers are aviliable type command first exit bash or create new terminal tab and go to project/docker and type command `docker ps`

```
docker-compose container-name-nginx-1 restart
```

### Laravel Application setup, database setup, migration, and seeds

When workspace bash(`docker-compose exec workspace bash`) is executed in `/var/www` type command `composer install` so vendor is avaliable for this laravel project all packages will be installed.

Then in root project type command copy:
```
cp .env.example .env
```
Geneate app key type command:

    php artisan key:generate

and now check database variables.

`DB_CONNECTION` and `DB_HOST` must be **mysql**, `DB_USERNAME` and `DB_PASSWORD` by default is **root**. To check what is default DB configuration in `docker/.env` file.

To create new DB we can use PhpMyAdmin database managment system. container `phpmyadmin` is already running and url is this [http://localhost:8081/index.php](http://localhost:8081/index.php). To access phpmyadmin system type server, user, and password fields. Credentials are same as in .env file.

When DB is added now migrations and seeds will work.

First migrate all migrations type command 

    php artisan migrate

Type command:

    php artisan db:seed

In `DatabaseSeeder.php` uncomment the code what is needed: - create multiple users or single user.

### Create new JWT secret token

Set the JWTAuth secret key used to sign the tokens type command:

    php artisan jwt:secret

### RapidAPI Setup and Command

In [RapidAPI](https://rapidapi.com/SAdrian/api/moviesdatabase) register as user to use free access to api for all virarty of data we now use moviesdatabase In `.env` file add api key in `RAPIDAPI_KEY={key}`
`RAPIDAPI_HOST=moviesdatabase.p.rapidapi.com`

Now we can use this command: 

    php artisan api:store-rapid-api-movies-command

This command is acting as seed so it will store real movies in movies table. Command have few steps to procced but max movies can be added in one command execute is 10. But if we execute command again and **select page 2** then we will get 10 more movies and etc.

## Dynamic Movie Filter API

In api route `/api/movies` will display all movies that are stored in DB

When we want to use filter parameters we need to pass query safe parameters(title, caption, rating and etc.). Also there is predefined operators so if we want to display movies that rating is GRATER_THAN (>) 8.0 value api route will be `/api/movies?rating[gt]=8.0` then we will have list of movies that rating is grater than 8.0 also if we want additional query parameter we use `AND separator &`

## Run the application tests

Test are cover all feature tests:
- CRUD Movies
- User authentication
- User followed movies list and follow request

Use command: 

    php artisan test

## Laravel Request DOCS

Auto Generate API Documentation for request rules and parameters.
Dashboard view in the browser on `/request-docs/`

## Packages used in application

- [laradock](https://laradock.io/getting-started/#Install-Laravel)
- [rakutentech/laravel-request-docs](https://github.com/rakutentech/laravel-request-docs)
- [cviebrock/eloquent-sluggable](https://github.com/cviebrock/eloquent-sluggable): v10.*
- [juststeveking/http-status-code](https://github.com/JustSteveKing/http-status-code): v3.*
- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper): v2.13

## Project challenges

- Authentication Middleware should be JWT
- Controllers should be written in a clean, approachable coding style.
- The API should have postable content with the main topic being movies
- Favorites caching implementation
- Query Filters implementation
- Users should be able to follow a selected movie
- API Pagination
- Slugs
- Database
- Database Migrations
- Database Seeds
- Routes
- Test coverage should be around 40%
