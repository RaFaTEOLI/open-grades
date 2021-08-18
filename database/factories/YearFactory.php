<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Year;
use Faker\Generator as Faker;

$factory->define(Year::class, function (Faker $faker) {
    return [
        "start_date" => $faker->date('Y-m-d'),
        "end_date" => $faker->dateTimeBetween('+10 month', '+12 month')->format('Y-m-d')
    ];
});
