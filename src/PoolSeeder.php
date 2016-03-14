<?php
namespace Styde\Seeder;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PoolSeeder
{

    /**
     * A Eloquent collection of registered models.
     *
     * @var array
     */
    protected static $pool;

    /**
     * Get an instance of given model.
     *
     * @param  string $model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function random($model)
    {
        if (! static::collectionExist($model)) {
            // If no objects are registered in the given
            // collection attempt to create a new one
            return seed($model);
        }

        return static::$pool[$model]->random();
    }

    /**
     * Save a given model into a pool.
     *
     * @param string $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
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
     * Create a collection.
     *
     * @param $class
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function makeCollection($class)
    {
        if (! static::collectionExist($class)) {
            static::$pool[$class] = new Collection();
        }

        return static::$pool[$class];
    }

    /**
     * Check if the collection exist.
     *
     * @param $class
     *
     * @return bool
     */
    protected static function collectionExist($class)
    {
        return isset(static::$pool[$class]);
    }
}
