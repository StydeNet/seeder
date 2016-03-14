<?php
namespace Styde\Seeder;

use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Seeder as IlluminateSeeder;

abstract class Seeder extends IlluminateSeeder
{
    /**
     * The Faker instance for the builder.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Total of instance to create.
     *
     * @var integer
     */
    protected $total = 50;

    /**
     * Create a new factory instance.
     *
     * @param Faker\Factory $factory
     *
     * @return void
     */
    public function __construct(Faker $factory)
    {
        $this->faker = $factory->create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createMultiple($this->total);
    }

    /**
     * Create a collection of instances of the given model.
     *
     * @param  integer $total
     * @param  array  $customValues
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function makeMultiple($total, array $customValues = array())
    {
        $collection = new Collection();

        for ($i = 1; $i <= $total; $i++) {
            $collection->add($this->make($customValues));
        }

        return $collection;
    }

    /**
     * Create a collection of instances of the given model and persist them to the database.
     *
     * @param  integer $total
     * @param  array  $customValues
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
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

    /**
     * Generate fake data to the model attributes.
     *
     * @param  \Faker\Generator $faker
     * @param  array     $customValues
     *
     * @return array
     */
    abstract public function getDummyData(Generator $faker, array $customValues = array());

    /**
     * Create an instance of the given model.
     *
     * @param  array  $customValues
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function make(array $customValues = array())
    {
        $values = $this->getDummyData($this->faker, $customValues);
        $values = array_merge($values, $customValues);

        Eloquent::unguard();

        $model = $this->getModel()->newInstance($values);

        Eloquent::reguard();

        return $model;
    }

    /**
     * Create an instance of the given model and persist it to the database.
     *
     * @param  array  $customValues
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create(array $customValues = array())
    {
        $model = $this->make($customValues);
        $model->save();
        return PoolSeeder::add($model);
    }

    /**
     * Create an instance of the given model based on another seeder.
     *
     * @param  string $seeder without suffix 'TableSeeder'
     * @param  array  $customValues
     */
    protected function createFrom($seeder, array $customValues = array())
    {
        return Helper::seedModel($seeder, $customValues);
    }
    
    /**
     * Get an already created instance of the given model randomly otherwise it creates it.
     *
     * @param  $model
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function random($model)
    {
        return PoolSeeder::random($model);
    }
}
