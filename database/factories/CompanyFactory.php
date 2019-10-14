<?php

use Faker\Factory as FakerFactory;
use App\Models\Company;

$factory->define(Company::class, function () {
    $faker = FakerFactory::create();

    return [
        'name' => preg_replace('/( |　)/', '', $faker->name),
    ];
});
