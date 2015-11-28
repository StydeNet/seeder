<?php

namespace Styde\Seeder;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PoolSeeder {

    protected static $pool;

    public static function random($model)
    {
        if (! static::collectionExist($model)) {
            // If no objects are registered in the given
            // collection attempt to create a new one
            return seed($model);
        }

        return static::$pool[$model]->random();
    }

    public static function add($entity)
    {
        /**
         * Don't cache if there are active DB transactions, because they are
         * used for testing purposes and this could cause potential issues,
         * i.e.: we cache a record and then the transaction is rolled back.
         */
        if (DB::transactionLevel() > 0) {
            return $entity;
        }

        
        $reflection = new \ReflectionClass($entity);
        $class = $reflection->getShortName();

        static::makeCollection($class)->add($entity);

        return $entity;
    }

    /**
     * @param $class
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function makeCollection($class)
    {
        if (! static::collectionExist($class)) {
            static::$pool[$class] = new Collection();
        }

        return static::$pool[$class];
    }

    protected static function collectionExist($class)
    {
        return isset(static::$pool[$class]);
    }

}