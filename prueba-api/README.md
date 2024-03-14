<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

## Installation

1. Clonar repositorio
   ```sh
   git clone
   
    ```
   2 . Instalar Docker y entrar a la carpeta del proyecto llamada Docker y correr el siguiente comando
   ```sh
   docker-compose up -d
   ```
   3 . Install composer
      ```sh
      docker exec -it prueba-php-1 composer install
      ```
   4 . Create .env file and generate key
      ```sh
       php artisan key:generate
    ```

  5 . Ejecutar migraciones y seeders ya que este contiene el usuario para el acceso inicial
```sh
    php artisan migrate
    php artisan db:seed --class=UserSeeder
```

    
7   .Actualizar el archivo .env con las credenciales de la base de datos que se generan en el docker-compose
   ```sh
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
```

8 .Ejecutar php artisan passport:install
```sh
    php artisan passport:install
```

9. Ingresar las keys generadas en el archivo .env
```sh
    PASSPORT_CLIENT_ID=
    PASSPORT_CLIENT_SECRET=
```
