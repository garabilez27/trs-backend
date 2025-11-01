# Getting started

Prerequisites:
- PHP (8.2.x or higher)
- Composer
- MySQL

Steps:
1. Clone repository.
2. Copy env file:
   - cp .env.example .env
3. Install PHP dependencies:
   - composer install
4. Generate app key:
   - php artisan key:generate
5. Generate jwt secret key:
   - php artisan jwt:secret
6. Run migrations & seeders:
   - php artisan migrate
7. Serve locally:
   - php artisan serve
