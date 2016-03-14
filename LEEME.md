# Styde Seeder

Este paquete para [Laravel](https://laravel.com/) permite generar datos ficticios en tu base de datos. Es una alternativa a los Model Factories de Laravel 5.1. Con este componente podrás generar datos para un modelo de tu aplicación y sus modelos relacionados, usando el paquete [Faker](https://github.com/fzaninotto/Faker).

## Instalación

Para instalar a través de [Composer](https://getcomposer.org/):

1. Agrega la siguiente instrucción al objeto "require" de tu composer.json:
```
"styde/seeder": "^1.0"
```
o simplemente ejecuta en tu consola:
```
composer require styde/seeder
```
Luego ejecuta `composer update`.

2. Después que **Styde Seeder** esté instalado, debes agregar el service provider al array `providers` del archivo `config/app.php`
```
'providers' => [
    // ...
    Styde\Seeder\SeederServiceProvider::class,
    // ...
],
```

3. Agrega lo siguiente al archivo `database/seeds/DatabaseSeeder.php`:
```
<?php

use Styde\Seeder\BaseSeeder;

class DatabaseSeeder extends BaseSeeder
{
    protected $truncate = array(
        //'users',
    );

    protected $seeders = array(
        //'User',
    );
}
```
En el primer array (`$truncate`) se deben agregar los nombres de las tablas de la base de datos que se desean llenar con los datos de prueba para que el paquete las vacíe antes de llenarlas. No importa el orden debido a que la verificación de claves foráneas será desactivada. En el segundo array (`$seeders`) se deben añadir los nombres de las clases de los seeders omitiendo el sufijo TableSeeder pues el paquete lo agregará automáticamente.

## Usage

Para crear un nuevo Seeder puedes ejecutar:
```
php artisan styde:seeder NombreDeSeeder
```
Y un nuevo archivo llamado `NombreDeSeederTableSeeder.php` será creado en el directorio `database/seeds`.

De esta manera puedes completar tu seeder con la instancia del modelo en el método `getModel()` y sus atributos en el método `getDummyData`. Puedes usar [Faker](https://github.com/fzaninotto/Faker) para generar datos ficticios, por ejemplo:

```
php artisan styde:seeder User
```
Completando el modelo en `getModel()` y algunos atributos con datos ficticios:
```
<?php

use Styde\Seeder\Seeder;
use Faker\Generator;
use App\User;

class UserTableSeeder extends Seeder
{
    protected $total = 50;

    public function getModel()
    {
        return new User();
    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {
        return [
            'name' => $faker->name,
            'email' => $faker->email,
            'password'  => bcrypt('secret'),
        ];
    }
}
```
### Helpers

Puedes usar también estos dos helpers cuando estás trabajando con pruebas (tests) o `php artisan tinker`:
```
/**
     * Create one instance or a collection of the given model and persist them to the database.
     *
     * @param  string  $seeder
     * @param  integer $total
     * @param  array   $customValues
     *
     * @return mixed
     */
    function seed($seeder, $total = 1, array $customValues = array())
```
Ejemplo para crear 5 usuarios: `seed('User', 5)` o para crear usuarios con datos específicos: `seed('User', ['name' => 'John', 'email' => 'john@example.com'])`.

```
/**
     * Create one instance or a collection of a given model.
     *
     * @param  string  $seeder
     * @param  integer $total
     * @param  array   $customValues
     *
     * @return mixed
     */
    function model($seeder, $total = 1, array $customValues = array())
```
Con este helper solo creas una instancia o colección pero no serán persistidos en la base de datos.

Una vez ejecutes el comando de Laravel `php artisan db:seed` se crearán por defecto 50 usuarios en la base de datos.

## About

Styde Seeder fue creado por [Duilio Palacios](https://twitter.com/sileence) como parte del código para el curso [Crea tu primera aplicación con Laravel 5](https://styde.net/cursos/crea-tu-primera-aplicacion-con-laravel-5/)