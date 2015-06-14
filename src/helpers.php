<?php

if ( ! function_exists('seed'))
{
    function seed($seeder, $total = 1, $customValues = array())
    {
        return \Styde\Seeder\Helper::seedModel($seeder, $total, $customValues);
    }
}

if ( ! function_exists('model'))
{
    function model($seeder, $total = 1, $customValues = array())
    {
        return \Styde\Seeder\Helper::buildModel($seeder, $total, $customValues);
    }
}