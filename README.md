# Styde Seeder

This package for [Laravel](https://laravel.com/) allow seeding your database with faker data. It is an alternative to Model Factories of Laravel 5.1. With this package you can seed a model of your application and its related models too, using the package [Faker](https://github.com/fzaninotto/Faker).

## Installation

To install through [Composer](https://getcomposer.org/):

1. Add the following instruction to the "require" object in your composer.json:
```
"styde/seeder": "^1.0"
```
or simply execute on your console:
```
composer require styde/seeder
```
Then run `composer update`.

2. After **Styde Seeder** is installed, you need to add the service provider to the `providers` array in `config/app.php`
```
'providers' => [
    // ...
    Styde\Seeder\SeederServiceProvider::class,
    // ...
],
```

3. Then add the following to your `database/seeds/DatabaseSeeder.php`:
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
Specify the tables of database you want to `$truncate` (order does not matter since the foreign key check will be disabled) Then add the `$seeders`, by default it will autocomplete the suffix `"TableSeeder"` so no need to add it.

## Usage

To create a new seeder file you can run:
```
php artisan styde:seeder NameOfSeeder
```
And a new file called `NameOfSeederTableSeeder.php` will be created at `database/seeds` directory.

Then complete your seeder with new instance of the Model in the `getModel()` method and its attributes in the `getDummyData` method. You can use [Faker](https://github.com/fzaninotto/Faker) for generates fake data, for example:

```
php artisan styde:seeder User
```
Completing the Model in getModel() and some attributes with faker data:
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

Once you run the seed command in Laravel `php artisan db:seed` it will create 50 users with random data by default.

### Helpers

Also, you can use these two helpers when you are working with tests or `php artisan tinker`:
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
For example to create 5 users `seed('User', 5)` or to create one user with specific data `seed('User', ['name' => 'John', 'email' => 'john@example.com'])`.

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
With this helper you only can create an instance or collection, but will not be persisted to the database.

## About

Styde Seeder was created by [Duilio Palacios](https://twitter.com/sileence) as part of the code for the course [Crea tu primera aplicación con Laravel 5](https://styde.net/cursos/crea-tu-primera-aplicacion-con-laravel-5/) (in Spanish)