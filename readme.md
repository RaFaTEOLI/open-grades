![image](https://github.com/RaFaTEOLI/open-grades/assets/40833512/7da3239e-0c3e-4c86-a79f-174c86b05f37)

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About
Open Grades is an opensource application build with Laravel to manage class calendars, class grades and etc, it is made for students and teachers.
We believe that every school or independent teacher should have access to an easy system to manage his students, grades and much more for free.

(***Development In Progress - First Version Estimated to Be Released Mid 2025***)

- Simple and fast (Clean UI that any user can learn).
- Organize your classes with our calendars.
- Generate grades, classes, presences reports.
- Notify your students.
- Create warnings for bad behavior and etc.
- Charge your students with our payment's system

## Our Team

We would like to extend our thanks to the following members of the team. If you are interested in becoming a member of the team, please send an email to [rafinha.tessarolo@hotmail.com](mailto:rafinha.tessarolo@hotmail.com)

- **[Rafael Tessarolo](https://github.com/RaFaTEOLI)**

## Contributing [![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/RaFaTEOLI/open-grades/issues)

Thank you for considering contributing to Open Grades app! The contribution guide can be found in the [Open Grades documentation](#).

## Security Vulnerabilities

If you discover a security vulnerability within Open Grades, please send an e-mail to Rafael Tessarolo via [rafinha.tessarolo@hotmail.com](mailto:rafinha.tessarolo@hotmail.com). All security vulnerabilities will be promptly addressed.

## License

The Open Grades app is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## How To Install

**Using Docker**
```console
cp .env.example .env
yarn install
yarn up
yarn run:install
yarn migrate
yarn db:seed
```
Then Access: server_domain_or_IP:8000
    
**Without Docker**
```console
cp .env.example .env
yarn install
composer install
php artisan migrate
php artisan db:seed
php artisan serve
```
Then Access: server_domain_or_IP:8000
    
