<?php

if (! function_exists('seed')) {
	/**
	 * Create one instance or a collection of the given model and persist it to the database.
	 *
	 * @param  string  $seeder
	 * @param  integer $total
	 * @param  array   $customValues
	 *
	 * @return mixed
	 */
    function seed($seeder, $total = 1, array $customValues = array())
    {
        return \Styde\Seeder\Helper::seedModel($seeder, $total, $customValues);
    }
}

if (! function_exists('model')) {
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
    {
        return \Styde\Seeder\Helper::buildModel($seeder, $total, $customValues);
    }
}
