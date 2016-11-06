# NUSWhispers

[![Dependency Status](https://gemnasium.com/nusmodifications/nuswhispers.svg)](https://gemnasium.com/nusmodifications/nuswhispers)
[![StyleCI Status](https://styleci.io/repos/31862595/shield?style=plastic)](https://styleci.io/repos/31862595)

> Laravel 5 + AngularJS setup.

## Requirements
- Web server with PHP support
- MySQL / MariaDB
- Redis

For a development environment, using [docker-nuswhispers](https://github.com/nusmodifications/docker-nuswhispers) is highly recommended.

## Installation
1) Rename `.env.example` to `.env`

2) Install PHP dependencies via composer:
```
cd /path/to/current/directory
composer install
```

3) Install JS dependencies via npm and bower:
```
cd /path/to/current/directory
npm install
bower install
```

4) Run database migrations and seed data via command line:
```
cd /path/to/current/directory
php artisan migrate
php artisan db:seed
```

5) Compile angular via gulp:
```
gulp prod
```

## Credits
- [generator-boom](https://www.npmjs.com/package/generator-boom)
