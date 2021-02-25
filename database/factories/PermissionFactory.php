<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "display_name" => $faker->name,
        "description" => $faker->name,
    ];
});
