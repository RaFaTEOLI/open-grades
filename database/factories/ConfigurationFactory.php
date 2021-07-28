<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Configuration;
use Faker\Generator as Faker;

$factory->define(Configuration::class, function (Faker $faker) {
    return [
        'name' => $this->faker->name,
        'value' => '1'
    ];
});
