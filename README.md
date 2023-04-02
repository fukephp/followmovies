
# Laravel project: REST API (JWT) - Follow movies

## Roadmap

* [Introduction](#introduction)
* [Project requirements](#project-requirements)
* [Installation/Configuration](#installationconfiguration)
* [Project features](#project-features)
* [Run the application tests](#run-the-application-tests)
* [Logging channels](#logging-channels)
* [Aditional libraries used in project](#aditional-libraries-used-in-project)
* [Project challenges](#project-challenges)

## Introduction

Basic laravel project REST API using [JWT](https://jwt.io/introduction) as authentication to secure api routes.
Main topic for this app is following and filtering movies. Real movies can be fetch from [RapidAPI](https://rapidapi.com/SAdrian/api/moviesdatabase) using inbuild command and it has option to choose mutiple real movies that are sorted by for example:
- Top most popular movies, according to imdb ranking
- Top 200 all time box office movies, according to boxofficemojo
- Top 250 english movies by rating, according to imdb ranking and etc.

More about command itself will be explained in Installation/Configuration.

## Project requirements

-  **docker**: v20.10.23
-  **php**: v8.1
-  **laravel/framework**: v10.4.1
-  **db**: mysql
-  **tymon/jwt-auth**: v2.0

## Installation/Configuration

When project is cloned first docker containers needs to be setup.

### Docker setup

**Remainder:** docker container example is used pre-configured docker services [laradock](https://laradock.io/getting-started/#Install-Laravel).
**Laradock**  is a full PHP development environment for Docker.
It supports a variety of common services, all pre-configured to provide a ready PHP development environment.

In terminal go to cloned project and enter docker folder `cd docker`.

In `docker-compose.yml` docker container version is **3.5** and services will be used:

-  **workspace**
-  **php-fpm**
-  **php-worker**
-  **nginx**
-  **mysql**
-  **phpmyadmin**

### Docker enviroment setup

In folder `docker` use command copy file `cp .env.example .env`
In created `.env` file change:
-  `COMPOSE_PROJECT_NAME=followmovies` (or whatever name)
-  `DATA_PATH_HOST=~/.followmovies/data` (needs to be same path name as project name)

### Nginx setup

In `docker/nginx/sites` use command copy file `cp laravel.conf.example followmovies.conf`

In `followmovies.conf` server_name change `server_name followmovies.test;` and register virtual host domain use command `sudo nano /etc/hosts` and below of file add server_name `127.0.0.1 followmovies.test`

Now can procced compose docker container.

### Compose docker container

To install fresh workspace and build container in `docker` folder use command `docker-compose up -d nginx mysql phpmyadmin`

When container is build in `docker` folder use command `docker-compose exec workspace bash`

## Project features

## Run the application tests

## Aditional packages used in project

- [laradock](https://laradock.io/getting-started/#Install-Laravel)
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
