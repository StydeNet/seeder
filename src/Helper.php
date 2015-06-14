<?php

namespace Styde\Seeder;

class Helper
{
    public static $prefix;
    public static $suffix = 'TableSeeder';

    public static function buildSeederName($seeder)
    {
        return static::$prefix . $seeder . static::$suffix;
    }

    public static function buildSeeder($seeder)
    {
        return app(static::buildSeederName($seeder));
    }

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