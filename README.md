# Emergency Market Place

this repo is for maintenance code for :
- Backend
- Front App
- Backoffice

## packages
For this project used the packages and versions:
#### Production:
- [laravel/framework (9.19)](https://packagist.org/packages/laravel/laravel)
- [inertiajs/inertia-laravel (0.6.4)](https://packagist.org/packages/inertiajs/inertia-laravel)
- [tightenco/ziggy (1.4)](https://packagist.org/packages/tightenco/ziggy)
- [laravel/sanctum (3.0)](https://packagist.org/packages/laravel/sanctum)
- [filament/filament (2.0)](https://packagist.org/packages/filament/filament)
- [predis/predis (2.0)](https://packagist.org/packages/predis/predis)

#### Development:
- [laravel/pint (1.0)](https://packagist.org/packages/laravel/pint)


## to run dockerized project:

1. create copy of `.env.example` and rename to `.env`
2. in the file `.env` add or change the value of the var `PROJECT_NAME` this value is the name to rename the
   containers an internal volumes.
3. execute the command `docker-compose build` or `docker-compose up -d`
4. have fun coding :)

## Check the makefile.
In this project, a file with the name `Makefile` is added, which contains a series of commands to facilitate some 
repetitive tasks of development and work with docker containers and other commands that have been abbreviated to be used 
in an easier way.
this a list of commands included


- `make pint: reformat code according some pressets example psr-12`
- `make up: start all containers`
- `make down: down all containers`
- `make vite: run the vite dev server`


## Execute jobs for send emails

to dispatch email to send emails with the contracts follows this instructions
configure in the env the next variable and value

`QUEUE_CONNECTION=database`

And run the follow command

`php artisan queue:work`

