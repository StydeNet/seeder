# Styde\Seeder
This Laravel's component is part of the code I created for the course (in Spanish):

https://styde.net/cursos/crea-tu-primera-aplicacion-con-laravel-5/

To install through Composer:

1. Add the following instruction to the "require" object in your composer.json: `"styde/seeder": "dev-master"` or execute `composer require styde/seeder` on your console.

2. Execute `composer update` in the console

3. Then add the following to your DatabaseSeeder.php (`database/seeds/DatabaseSeeder.php`)

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

Specify the tables you want to `$truncate` (order does not matter since the foreign key check will be disabled)
Then add the `$seeders`, by default it will autocomplete the suffix `"TableSeeder"` so no need to add it

Then start creating your seeders, for example:

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

Once you run the seed command in Laravel it will create 50 users with random data.

I will be adding more documentation later.
