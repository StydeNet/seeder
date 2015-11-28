<?php

namespace Styde\Seeder;

use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Seeder as IlluminateSeeder;

abstract class Seeder extends IlluminateSeeder
{
    protected $faker;
    protected $total = 50;

    public function __construct(Faker $factory)
    {
        $this->faker = $factory->create();
    }

    public function run()
    {
        $this->createMultiple($this->total);
    }

    public function makeMultiple($total, array $customValues = array())
    {
        $collection = new Collection();

        for ($i = 1; $i <= $total; $i++) {
            $collection->add($this->make($customValues));
        }

        return $collection;
    }

    public function createMultiple($total, array $customValues = array())
    {
        $collection = new Collection();

        for ($i = 1; $i <= $total; $i++) {
            $collection->add($this->create($customValues));
        }

        return $collection;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract public function getModel();
    abstract public function getDummyData(Generator $faker, array $customValues = array());

    public function make(array $customValues = array())
    {
        $values = $this->getDummyData($this->faker, $customValues);
        $values = array_merge($values, $customValues);

        Eloquent::unguard();

        $model = $this->getModel()->newInstance($values);

        Eloquent::reguard();

        return $model;
    }

    public function create(array $customValues = array())
    {
        $model = $this->make($customValues);
        $model->save();
        return PoolSeeder::add($model);
    }

    protected function createFrom($seeder, array $customValues = array())
    {
        return Helper::seedModel($seeder, $customValues);
    }

    protected function random($model)
    {
        return PoolSeeder::random($model);
    }

}
