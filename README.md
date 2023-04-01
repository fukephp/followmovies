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
More about command itself will be explained in Instalation/Configuration.

## Project requirements

-  **docker**: v20.10.23
-  **php**: v8.1
-  **laravel/framework**: v10.4.1
-  **db**: mysql
-  **tymon/jwt-auth**: v2.0

## Installation/Configuration

## Project features

## Run the application tests

## Aditional packages used in project

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
