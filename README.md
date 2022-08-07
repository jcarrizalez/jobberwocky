## Download Proyects
```
git clone https://github.com/jcarrizalez/avature.git && cd avature;
git clone https://github.com/avatureassessment/jobberwocky-extra-source.git;
```
## Install Proyects
```
docker-compose exec avature-jobberwocky npm install;
docker-compose exec avature-laravel composer install;
docker-compose exec avature-laravel php artisan migrate:rollback;
docker-compose exec avature-laravel php artisan migrate;
docker-compose exec avature-laravel php artisan db:seed;
```
## Add Data Demo
```
docker-compose exec avature-laravel php artisan db:seed --class="Database\Seeders\AvatureDemoSeeder";
```

## Enpoints
- `GET` http://localhost:9891/api/jobs?count=10&page=1&search=java
```json
request:
{
}
```
```json
response:
{
    "status": "success",
    "data": {
        "elements": [
            {
                "salary": 24000,
                "title": "Jr Java Developer",
                "description": null,
                "external_service": "jobberwocky",
                "skills": [
                    {
                        "slug": "java",
                        "description": "Java"
                    },
                    {
                        "slug": "oop",
                        "description": "OOP"
                    }
                ],
                "country": {
                    "code": "ARG",
                    "name": "Argentina"
                },
                "company": null
            },
            {
            },
            {
            }
        ],
        "metadata": {
            "count": 10,
            "page": 1,
            "total": 6,
            "total_pages": 1
        }
    }
}
```

- `POST` http://localhost:9891/api/jobs
```json
request:
{
    "salary": 10000,
    "title": "Cisco [Weapons Specialists]",
    "hidden_company" : false,
    "description": "Suscipit non iure animi adipisci.......",
    "skills": [
        {
            "slug": "php",
            "description": "PHP"
        },
        {
            "slug": "javascript",
            "description": "JAVASCRIPT"
        }
    ],
    "country": {
        "code": "ARG",
        "name": "Argentina"
    },
    "company": {
        "name" : "Cisco"
    }
}
```
```json
response:
{
    "status": "success",
    "data": {
        "salary": 10000,
        "title": "Cisco [Weapons Specialists]",
        "description": "Suscipit non iure animi adipisci.......",
        "hidden_company":false,
        "external_service": null,
        "skills": [
            {
                "slug": "php",
                "description": "PHP"
            },
            {
                "slug": "javascript",
                "description": "JAVASCRIPT"
            }
        ],
        "country": {
            "code": "ARG",
            "name": "Argentina"
        },
        "company": {
            "name": "Cisco"
        }
    }
}
```

- `GET` http://localhost:9891/api/alerts?count=10&page=1
```json
request:
{
}
```
```json
response:
{
    "status": "success",
    "data": {
        "elements": [
            {
                "slug": "java",
                "description": "Java"
            },
            {
                "slug": "html",
                "description": "HTML"
            }
        ],
        "metadata": {
            "count": 10,
            "page": 1,
            "total": 2,
            "total_pages": 1
        }
    }
}
```
- `POST` http://localhost:9891/api/alerts
```json
request:
{
    "skills" :[
        {
            "slug": "java",
            "description": "Java"
        },
        {
            "slug": "html",
            "description": "HTML"
        }
    ]
}
```
```json
response:
{
    "status": "success",
    "data": [
        {
            "slug": "java",
            "description": "Java"
        },
        {
            "slug": "html",
            "description": "HTML"
        }
    ]
}
```


## Conexion database
- `MYSQL_USER:` develop
- `MYSQL_PASSWORD:` 123456
- ![image](https://user-images.githubusercontent.com/8440072/183313524-a8bd5300-da63-4031-a9b6-346e64a20a5b.png)


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
