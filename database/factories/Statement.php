<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Statement;
use Faker\Generator as Faker;

$factory->define(Statement::class, function (Faker $faker) {
    $subject = $faker->sentence(1);
    $statement = $faker->sentence(6);

    return [
        "subject" => $subject,
        "statement" => $statement,
    ];
});
