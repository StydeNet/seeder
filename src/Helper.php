<?php
namespace Styde\Seeder;

class Helper
{
    /**
     *
     * @var string
     */
    public static $prefix;

    /**
     * Suffix of the seeders file.
     *
     * @var string
     */
    public static $suffix = 'TableSeeder';

    /**
     * Parse the seeder name.
     *
     * @param  string $seeder
     *
     * @return string
     */
    public static function buildSeederName($seeder)
    {
        return static::$prefix . $seeder . static::$suffix;
    }

    public static function buildSeeder($seeder)
    {
        return app(static::buildSeederName($seeder));
    }

    /**
     * Create one instance or a collection of a given model.
     * 
     * @param  string  $seeder
     * @param  integer $total
     * @param  array   $customValues
     * 
     * @return mixed
     */
    public static function buildModel($seeder, $total = 1, $customValues = array())
    {
        if (is_array($total)) {
            $customValues = $total;
            $total = 1;
        }

        return $total == 1 ?
            static::buildSeeder($seeder)->make($customValues)
            : static::buildSeeder($seeder)->makeMultiple($total, $customValues);
    }

    /**
     * Create one instance or a collection of a given model and persist it to the database.
     * 
     * @param  string  $seeder
     * @param  integer $total
     * @param  array   $customValues
     * 
     * @return mixed
     */
    public static function seedModel($seeder, $total = 1, $customValues = array())
    {
        if (is_array($total)) {
            $customValues = $total;
            $total = 1;
        }

        return $total == 1 ?
            static::buildSeeder($seeder)->create($customValues)
            : static::buildSeeder($seeder)->createMultiple($total, $customValues);
    }
}
