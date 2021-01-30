<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Telegram;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Telegram::class, function (Faker $faker) {
    return [
        "message" => $faker->realText(25, 2),
        "user_id" => User::find(1)->id,
    ];
});
