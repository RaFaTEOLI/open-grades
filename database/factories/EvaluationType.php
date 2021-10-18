<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\EvaluationType;
use Faker\Generator as Faker;

$factory->define(EvaluationType::class, function (Faker $faker) {
    return [
        "name" => $faker->word(),
        "weight" => $faker->numberBetween(1, 1000),
    ];
});
